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
                ->addColumn('gambar', function ($row) {
                    if ($row->thumbnail) {
                        $url = asset('storage/' . $row->thumbnail);
                        return '<img src="' . $url . '" class="img-thumbnail" style="width:80px;height:80px;">';
                    }
                    return '<span class="text-muted">Tidak ada</span>';
                })
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
            $id = Crypt::decrypt($encryptedId);
            $program = DB::table('products')->where('id', $id)->first();

            if (!$program) {
                abort(404, 'Program tidak ditemukan');
            }

            $landing = DB::table('lp_programs')->where('product_id', $id)->first();

            // Jika belum ada landing page, buat record baru
            if (!$landing) {
                $landingId = DB::table('lp_programs')->insertGetId([
                    'product_id' => $id,
                    'nama_halaman' => $program->judul ?? 'Landing Page Program',
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
                $landing = DB::table('lp_programs')->where('id', $landingId)->first();
            }

            $sections = DB::table('landing_sections_program')
                ->where('landing_page_id', $landing->id)
                ->orderBy('order', 'asc')
                ->get();

            return view('lp_programs.atur', compact('program', 'landing', 'sections'));
        } catch (\Exception $e) {
            Log::error('Error saat membuka halaman atur landing page: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal membuka halaman atur.');
        }
    }

    public function updateAll(Request $request, $programId)
    {
        try {
            DB::beginTransaction();

            // Cari atau buat landing page
            $landing = DB::table('lp_programs')->where('product_id', $programId)->first();

            $landingData = [
                'nama_halaman' => $request->nama_halaman,
                'primary_color' => $request->primary_color,
                'secondary_color' => $request->secondary_color,
                'accent_color' => $request->accent_color,
                'dark_color' => $request->dark_color,
                'footer_text' => $request->footer_text,
                'footer_whatsapp' => $request->footer_whatsapp,
                'footer_contact' => $request->footer_contact,
                'footer_instagram' => $request->footer_instagram,
                'footer_youtube' => $request->footer_youtube,
                'footer_facebook' => $request->footer_facebook,
                'tentang_title' => $request->tentang_title,
                'tentang_paragraph1' => $request->tentang_paragraph1,
                'tentang_paragraph2' => $request->tentang_paragraph2,
                'tentang_quote' => $request->tentang_quote,
                'tentang_quote_author' => $request->tentang_quote_author,
                'wln_title' => $request->wln_title,
                'wln_subtitle' => $request->wln_subtitle,
                'wln_paragraph1' => $request->wln_paragraph1,
                'wln_paragraph2' => $request->wln_paragraph2,
                'wln_paragraph3' => $request->wln_paragraph3,
                'wln_paragraph4' => $request->wln_paragraph4,
                'wln_paragraph5' => $request->wln_paragraph5,
                'jejak_title' => $request->jejak_title,
                'jejak_subtitle' => $request->jejak_subtitle,
                'jejak_description' => $request->jejak_description,
                'reward_title' => $request->reward_title,
                'reward_subtitle' => $request->reward_subtitle,
                'reward_kategori_a' => $request->reward_kategori_a,
                'reward_kategori_b' => $request->reward_kategori_b,
                'reward_kategori_c' => $request->reward_kategori_c,
                'reward_gil_title' => $request->reward_gil_title,
                'reward_gil_description' => $request->reward_gil_description,
                'reward_gil_characteristics' => $request->reward_gil_characteristics,
                'reward_gil_rewards' => $request->reward_gil_rewards,
                'reward_utama_title' => $request->reward_utama_title,
                'reward_utama_subtitle' => $request->reward_utama_subtitle,
                'tour_title' => $request->tour_title,
                'tour_quote' => $request->tour_quote,
                'tour_description1' => $request->tour_description1,
                'tour_description2' => $request->tour_description2,
                'tour_preparation_points' => $request->tour_preparation_points,
                'tour_conclusion' => $request->tour_conclusion,
                'timeline_title' => $request->timeline_title,
                'timeline_subtitle' => $request->timeline_subtitle,
                'manfaat_title' => $request->manfaat_title,
                'manfaat_subtitle' => $request->manfaat_subtitle,
                'mengapa_title' => $request->mengapa_title,
                'mengapa_opening' => $request->mengapa_opening,
                'mengapa_points' => $request->mengapa_points,
                'mengapa_quote' => $request->mengapa_quote,
                'mengapa_quote_author' => $request->mengapa_quote_author,
                'cta_main_title' => $request->cta_main_title,
                'cta_main_description' => $request->cta_main_description,
                'cta_subtitle' => $request->cta_subtitle,
                'cta_call_text' => $request->cta_call_text,
                'cta_button_text' => $request->cta_button_text,
                'cta_registration_info' => $request->cta_registration_info,
                'modal_title' => $request->modal_title,
                'modal_warning' => $request->modal_warning,
                'modal_subtitle' => $request->modal_subtitle,
                'modal_period' => $request->modal_period,
                'modal_instructions' => $request->modal_instructions,
                'modal_instruction_points' => $request->modal_instruction_points,
                'modal_facilities' => $request->modal_facilities,
                'modal_note' => $request->modal_note,
                'modal_transfer_info' => $request->modal_transfer_info,
                'modal_closing1' => $request->modal_closing1,
                'modal_closing2' => $request->modal_closing2,
                'updated_at' => now()
            ];

            // Handle file uploads untuk header
            if ($request->hasFile('header_background')) {
                $landingData['header_background'] = $this->uploadFile($request->file('header_background'), 'landing/headers');
            }
            if ($request->hasFile('header_logo1')) {
                $landingData['header_logo1'] = $this->uploadFile($request->file('header_logo1'), 'landing/logos');
            }
            if ($request->hasFile('header_logo2')) {
                $landingData['header_logo2'] = $this->uploadFile($request->file('header_logo2'), 'landing/logos');
            }

            // Handle file uploads untuk tentang program
            if ($request->hasFile('tentang_image')) {
                $landingData['tentang_image'] = $this->uploadFile($request->file('tentang_image'), 'landing/tentang');
            }

            // Handle file uploads untuk WLN
            if ($request->hasFile('wln_logo1')) {
                $landingData['wln_logo1'] = $this->uploadFile($request->file('wln_logo1'), 'landing/wln');
            }
            if ($request->hasFile('wln_logo2')) {
                $landingData['wln_logo2'] = $this->uploadFile($request->file('wln_logo2'), 'landing/wln');
            }
            for ($i = 1; $i <= 3; $i++) {
                if ($request->hasFile("wln_image$i")) {
                    $landingData["wln_image$i"] = $this->uploadFile($request->file("wln_image$i"), 'landing/wln');
                }
            }

            // Handle file uploads untuk jejak literasi
            for ($i = 1; $i <= 10; $i++) {
                if ($request->hasFile("jejak_image$i")) {
                    $landingData["jejak_image$i"] = $this->uploadFile($request->file("jejak_image$i"), 'landing/jejak');
                }
            }

            // Handle file uploads untuk reward utama
            for ($i = 1; $i <= 3; $i++) {
                if ($request->hasFile("reward_utama_image$i")) {
                    $landingData["reward_utama_image$i"] = $this->uploadFile($request->file("reward_utama_image$i"), 'landing/reward');
                }
            }

            // Handle timeline dates dan events
            for ($i = 1; $i <= 8; $i++) {
                $landingData["timeline_date$i"] = $request->input("timeline_date$i");
                $landingData["timeline_event$i"] = $request->input("timeline_event$i");
            }

            // Handle manfaat items
            for ($i = 1; $i <= 5; $i++) {
                $landingData["manfaat_icon$i"] = $request->input("manfaat_icon$i");
                $landingData["manfaat_item_title$i"] = $request->input("manfaat_item_title$i");
                $landingData["manfaat_item_description$i"] = $request->input("manfaat_item_description$i");
            }

            if ($landing) {
                // Update existing
                DB::table('lp_programs')->where('id', $landing->id)->update($landingData);
            } else {
                // Create new
                $landingData['product_id'] = $programId;
                $landingData['created_at'] = now();
                DB::table('lp_programs')->insert($landingData);
            }

            // Handle sections dinamis
            if ($request->has('sections')) {
                foreach ($request->sections as $sectionId => $sectionData) {
                    DB::table('landing_sections_program')
                        ->where('id', $sectionId)
                        ->update([
                            'section_type' => $sectionData['section_type'],
                            'section_title' => $sectionData['section_title'],
                            'order' => $sectionData['order'] ?? 0,
                            'updated_at' => now()
                        ]);
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Landing page berhasil disimpan!'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error saving landing page: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan landing page: ' . $e->getMessage()
            ], 500);
        }
    }

    public function deleteSection($sectionId)
    {
        try {
            DB::table('landing_sections_program')->where('id', $sectionId)->delete();

            return response()->json([
                'success' => true,
                'message' => 'Section berhasil dihapus!'
            ]);
        } catch (\Exception $e) {
            Log::error('Error deleting section: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus section: ' . $e->getMessage()
            ], 500);
        }
    }

    private function uploadFile($file, $folder = 'landing')
    {
        if (!$file) return null;

        $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs($folder, $filename, 'public');

        return $path;
    }
}
