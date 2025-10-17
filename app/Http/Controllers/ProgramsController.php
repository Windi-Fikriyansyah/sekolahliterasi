<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Handler\AbstractHandler;
use Pion\Laravel\ChunkUpload\Handler\ContentRangeUploadHandler;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;


class ProgramsController extends Controller
{
    public function index()
    {
        return view('lp_programs.index');
    }

    public function load(Request $request)
    {
        try {
            $kursus = DB::table('products')
                ->select(['id', 'judul', 'tipe_produk', 'thumbnail', 'status', 'created_at'])
                ->where('status', 'aktif')
                ->where('tipe_produk', 'program')
                ->orderBy('created_at', 'desc');

            return DataTables::of($kursus)
                ->addIndexColumn()

                // tampilkan gambar
                ->addColumn('gambar', function ($row) {
                    if ($row->thumbnail) {
                        $url = asset('storage/' . $row->thumbnail);
                        return '<img src="' . $url . '" class="img-thumbnail" style="width:80px;height:80px;">';
                    }
                    return '<span class="text-muted">Tidak ada</span>';
                })

                // kolom aksi
                ->addColumn('action', function ($row) {
                    $encryptedId = Crypt::encrypt($row->id);

                    return '
                    <div class="btn-group" role="group">
                        <a href="' . route('lp_programs.atur', $encryptedId) . '" class="btn btn-sm btn-warning me-1" title="Atur Landing Page">
                            <i class="bi bi-pencil"></i>
                        </a>
                    </div>';
                })

                ->rawColumns(['gambar', 'action'])
                ->make(true);
        } catch (\Exception $e) {
            Log::error('Error loading kursus data: ' . $e->getMessage());
            return response()->json([
                'error' => true,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }



    public function atur($encryptedId)
    {
        try {
            // Dekripsi ID dari tombol DataTables
            $id = Crypt::decrypt($encryptedId);

            // Ambil data program dari tabel products
            $program = DB::table('products')->where('id', $id)->first();

            if (!$program) {
                abort(404, 'Program tidak ditemukan');
            }

            // Cek apakah sudah ada landing page untuk program ini
            $landing = DB::table('lp_program')->where('product_id', $id)->first();
            $sections = DB::table('landing_sections_program')
                ->where('landing_page_id', optional($landing)->id)
                ->orderBy('order', 'asc')
                ->get();
            // Kirim data ke view
            return view('lp_programs.atur', compact('program', 'landing', 'sections'));
        } catch (\Exception $e) {
            Log::error('Error saat membuka halaman atur landing page: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal membuka halaman atur.');
        }
    }

    public function updateAll(Request $request, $id)
    {

        try {
            DB::beginTransaction();

            $productId = $request->input('product_id');

            // Update atau buat data landing page utama
            $this->updateLandingPage($request, $productId);

            // Update semua sections
            if ($request->has('sections')) {
                $this->updateSections($request->input('sections'));
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Semua data berhasil disimpan.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal menyimpan semua data landing page: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan: ' . $e->getMessage()
            ], 500);
        }
    }

    private function updateLandingPage($request, $productId)
    {
        $existing = DB::table('lp_program')->where('product_id', $productId)->first();

        $data = [
            'product_id' => $productId,
            'nama_halaman' => $request->input('nama_halaman'),
            'slug' => Str::slug($request->input('nama_halaman')),
            'hero_title' => $request->input('hero_title'),
            'hero_subtitle' => $request->input('hero_subtitle'),
            'hero_subtitle_2' => $request->input('hero_subtitle_2'),
            'hero_color_start' => $request->input('hero_color_start'),
            'hero_color_end' => $request->input('hero_color_end'),
            'primary_color' => $request->input('primary_color'),
            'secondary_color' => $request->input('secondary_color'),
            'footer_text' => $request->input('footer_text'),
            'footer_contact' => $request->input('footer_contact'),
            'footer_phone' => $request->input('footer_phone'),
            'updated_at' => now(),
        ];

        // Simpan file gambar jika ada
        if ($request->hasFile('hero_image')) {
            $path = $request->file('hero_image')->store('hero', 'public');
            $data['hero_image'] = $path;
        }

        if ($request->hasFile('header_logo1')) {
            $path = $request->file('header_logo1')->store('logos', 'public');
            $data['header_logo1'] = $path;
        }
        if ($request->hasFile('header_logo2')) {
            $path = $request->file('header_logo2')->store('logos', 'public');
            $data['header_logo2'] = $path;
        }

        if ($existing) {
            DB::table('lp_program')
                ->where('id', $existing->id)
                ->update($data);
        } else {
            $data['created_at'] = now();
            DB::table('lp_program')->insert($data);
        }
    }


    private function updateSections($sectionsData)
    {
        foreach ($sectionsData as $sectionId => $sectionData) {
            $section = DB::table('landing_sections_program')->where('id', $sectionId)->first();

            if (!$section) {
                continue;
            }

            $updateData = [
                'section_type' => $sectionData['section_type'],
                'section_title' => $sectionData['section_title'],
                'order' => $sectionData['order'] ?? 0,
                'updated_at' => now(),
            ];

            // Process content based on section type
            $content = $this->processSectionContent($sectionData['section_type'], $sectionId);
            if ($content !== null) {
                $updateData['content'] = json_encode($content, JSON_UNESCAPED_UNICODE);
            }

            DB::table('landing_sections_program')
                ->where('id', $sectionId)
                ->update($updateData);
        }
    }

    private function processSectionContent($sectionType, $sectionId)
    {
        $content = [];

        switch ($sectionType) {
            case 'info_cards':
                $content = $this->processInfoCardsContent($sectionId);
                break;
            case 'gallery':
                $content = $this->processGalleryContent($sectionId);
                break;
            case 'video':
                $content = $this->processVideoContent($sectionId);
                break;
            case 'form':
                $content = $this->processFormContent($sectionId);
                break;
            case 'text':
                $content = $this->processTextContent($sectionId);
                break;
            case 'points':
                $content = $this->processPointsContent($sectionId);
                break;
        }

        return $content;
    }

    private function processInfoCardsContent($sectionId)
    {
        $content = [];
        $index = 0;

        while (request()->has("sections.{$sectionId}.content.{$index}.icon")) {
            $content[] = [
                'icon' => request()->input("sections.{$sectionId}.content.{$index}.icon"),
                'title' => request()->input("sections.{$sectionId}.content.{$index}.title"),
                'description' => request()->input("sections.{$sectionId}.content.{$index}.description"),
            ];
            $index++;
        }

        return $content;
    }

    private function processGalleryContent($sectionId)
    {
        $title = request()->input("sections.{$sectionId}.content.title");
        $description = request()->input("sections.{$sectionId}.content.description");

        $images = [];

        // 1️⃣ Gambar lama yang dipertahankan
        $existingImages = request()->input("sections.{$sectionId}.content.images_existing") ?? [];
        foreach ($existingImages as $existing) {
            if (!empty($existing)) {
                $images[] = ['image' => $existing];
            }
        }

        // 2️⃣ Gambar baru yang diupload
        $imageGroups = request()->file("sections.{$sectionId}.content.images") ?? [];
        foreach ($imageGroups as $index => $fileGroup) {
            if (isset($fileGroup['image']) && $fileGroup['image'] instanceof \Illuminate\Http\UploadedFile) {
                $file = $fileGroup['image'];
                if ($file->isValid()) {
                    $filename = time() . '_' . Str::random(8) . '_' . $file->getClientOriginalName();
                    $path = $file->storeAs('gallery', $filename, 'public');
                    $images[] = ['image' => $path];
                }
            }
        }

        return [
            'title' => $title,
            'description' => $description,
            'images' => $images,
        ];
    }




    private function processVideoContent($sectionId)
    {
        return [
            'video_url' => request()->input("sections.{$sectionId}.content.video_url")
        ];
    }

    private function processFormContent($sectionId)
    {
        $content = [];
        $index = 0;

        while (request()->has("sections.{$sectionId}.content.{$index}.name")) {
            $content[] = [
                'name' => request()->input("sections.{$sectionId}.content.{$index}.name"),
                'placeholder' => request()->input("sections.{$sectionId}.content.{$index}.placeholder"),
                'type' => request()->input("sections.{$sectionId}.content.{$index}.type"),
            ];
            $index++;
        }

        return $content;
    }

    private function processTextContent($sectionId)
    {
        $oldSection = DB::table('landing_sections_program')->where('id', $sectionId)->first();
        $oldContent = json_decode(optional($oldSection)->content, true) ?? [];

        $content = [
            'heading' => request()->input("sections.{$sectionId}.content.heading") ?? ($oldContent['heading'] ?? ''),
            'body' => request()->input("sections.{$sectionId}.content.body") ?? ($oldContent['body'] ?? ''),
            'images' => $oldContent['images'] ?? [],
        ];

        // Ambil gambar lama yang masih dipertahankan
        $existing = request()->input("sections.{$sectionId}.content.images_existing") ?? [];
        $content['images'] = array_values(array_filter($existing));

        // Tambah gambar baru jika diupload
        if (request()->hasFile("sections.{$sectionId}.content.images")) {
            foreach (request()->file("sections.{$sectionId}.content.images") as $file) {
                if ($file->isValid()) {
                    $filename = time() . '_' . Str::random(8) . '_' . $file->getClientOriginalName();
                    $path = $file->storeAs('text_images', $filename, 'public');
                    $content['images'][] = $path;
                }
            }
        }

        return $content;
    }



    private function processPointsContent($sectionId)
    {
        $content = [];
        $index = 0;

        while (request()->has("sections.{$sectionId}.content.{$index}.text")) {
            $content[] = [
                'text' => request()->input("sections.{$sectionId}.content.{$index}.text"),
            ];
            $index++;
        }

        return $content;
    }


    public function create($landing_page_id)
    {
        $landing = DB::table('lp_program')->find($landing_page_id);
        if (!$landing) {
            abort(404, 'Landing page tidak ditemukan');
        }

        $types = ['info_cards', 'gallery', 'video', 'form', 'text', 'points'];

        return view('lp_programs.sections.create', compact('landing', 'types'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'landing_page_id' => 'required|integer',
            'section_type' => 'required|string|max:100',
            'section_title' => 'nullable|string|max:255',
            'order' => 'nullable|integer',
        ]);


        DB::table('landing_sections_program')->insert([
            'landing_page_id' => $data['landing_page_id'],
            'section_type' => $data['section_type'],
            'section_title' => $data['section_title'],
            'order' => $data['order'] ?? 0,
            'content' => json_encode([], JSON_UNESCAPED_UNICODE),
            'is_active' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $landing = DB::table('lp_program')->where('id', $data['landing_page_id'])->first();

        if (!$landing) {
            return redirect()->back()->with('error', 'Landing page tidak ditemukan.');
        }

        // Redirect ke halaman atur dengan product_id terenkripsi
        return redirect()
            ->route('lp_programs.atur', Crypt::encrypt($landing->product_id))
            ->with('success', '✅ Section baru berhasil ditambahkan.');
    }

    public function deleteSection($id)
    {
        try {
            $deleted = DB::table('landing_sections_program')->where('id', $id)->delete();

            if ($deleted) {
                return response()->json([
                    'success' => true,
                    'message' => 'Section berhasil dihapus.'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Section tidak ditemukan.'
                ], 404);
            }
        } catch (\Exception $e) {
            Log::error('Gagal hapus section: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus section.'
            ], 500);
        }
    }

    public function updateSection(Request $request, $id)
    {
        try {
            $section = DB::table('landing_sections_program')->where('id', $id)->first();

            if (!$section) {
                return redirect()->back()->with('error', 'Section tidak ditemukan.');
            }

            $data = [
                'section_type' => $request->input('section_type'),
                'section_title' => $request->input('section_title'),
                'order' => $request->input('order') ?? 0,
                'updated_at' => now(),
            ];

            // Jika tipe section diganti, kosongkan konten agar tidak bentrok
            if ($section->section_type !== $request->input('section_type')) {
                $data['content'] = json_encode([], JSON_UNESCAPED_UNICODE);
            }

            DB::table('landing_sections_program')->where('id', $id)->update($data);

            return redirect()->back()->with('success', '✅ Section berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Gagal update section: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat update section.');
        }
    }
}
