<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Str;

class ProdukController extends Controller
{
    public function index()
    {
        return view('produk.index');
    }

    public function load(Request $request)
    {
        try {
            $kursus = DB::table('products')
                ->select([
                    'id',
                    'judul',
                    'deskripsi',
                    'thumbnail',
                    'harga',
                    'tipe_produk',
                    'jenis_program',
                    'status',
                    'created_at',
                    'updated_at',
                    'tampil_harga'
                ])
                ->whereIn('tipe_produk', ['ebook', 'kelas_video', 'program', 'mitra', 'book_masterpiece'])
                ->orderBy('created_at', 'desc');

            return DataTables::of($kursus)
                ->addIndexColumn()
                ->addColumn('link', function ($row) {
                    if ($row->tipe_produk === 'program') {
                        $slug = Str::slug($row->judul) . '--' . Crypt::encryptString($row->id);
                        $url = $row->jenis_program === 'sekolah'
                            ? route('landing_page.pendaftaran_program', ['slug' => $slug])
                            : route('landing_page.pendaftaran', ['slug' => $slug]);

                        return '
                        <div class="d-flex align-items-center">
                            <a href="' . $url . '" target="_blank" class="text-primary text-decoration-underline me-2">Buka</a>
                            <button class="btn btn-sm btn-outline-secondary copy-link-btn" data-link="' . $url . '" title="Salin Link">
                                <i class="bi bi-clipboard"></i>
                            </button>
                        </div>
                    ';
                    }
                    return '-';
                })
                ->addColumn('action', function ($row) {
                    $encryptedId = Crypt::encrypt($row->id);
                    $deleteUrl = route('produk.destroy', $row->id);

                    $statusBtn = '
    <button class="btn btn-sm ' . ($row->status === "aktif" ? "btn-secondary" : "btn-success") . ' toggle-status-btn"
        data-id="' . $row->id . '"
        data-status="' . $row->status . '"
        title="Ubah Status">
        ' . ($row->status === "aktif" ? '<i class="bi bi-x-circle"></i>' : '<i class="bi bi-check-circle"></i>') . '
    </button>
';

                    $buttons = '<div class="btn-group" role="group">';
                    $buttons .= $statusBtn;
                    $buttons .= '<a href="' . route('produk.edit', $encryptedId) . '" class="btn btn-sm btn-warning me-1" title="Edit"><i class="bi bi-pencil"></i></a>';
                    $buttons .= '<button class="btn btn-sm btn-info copy-btn" title="Copy" data-id="' . $row->id . '"><i class="bi bi-files"></i></button>';
                    $buttons .= '<button class="btn btn-sm btn-danger delete-btn" title="Hapus" data-id="' . $row->id . '" data-url="' . $deleteUrl . '"><i class="bi bi-trash"></i></button>';
                    if (trim($row->tipe_produk) === 'program' && trim($row->jenis_program) === 'sekolah') {
                        $uploadUrl = route('produk.upload_file', $row->id);
                        $buttons .= '<a href="' . $uploadUrl . '"
                    class="btn btn-sm btn-success ms-1"
                    title="Upload File">
                    <i class="bi bi-file-earmark-pdf"></i>
                </a>';
                    }

                    $buttons .= '</div>';

                    return $buttons;
                })
                ->rawColumns(['link', 'action'])
                ->make(true);
        } catch (\Exception $e) {
            Log::error('Error loading kursus data: ' . $e->getMessage());
            return response()->json([
                'error' => true,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function toggleHarga(Request $request)
    {
        DB::table('products')
            ->where('id', $request->id)
            ->update([
                'tampil_harga' => $request->tampil_harga
            ]);

        return response()->json([
            'success' => true,
            'message' => $request->tampil_harga == 1
                ? 'Harga sekarang ditampilkan.'
                : 'Harga sekarang disembunyikan.'
        ]);
    }


    public function toggleStatus($id)
    {
        try {
            $produk = DB::table('products')->where('id', $id)->first();

            if (!$produk) {
                return response()->json(['success' => false, 'message' => 'Produk tidak ditemukan'], 404);
            }

            $newStatus = $produk->status === 'aktif' ? 'nonaktif' : 'aktif';

            DB::table('products')
                ->where('id', $id)
                ->update(['status' => $newStatus, 'updated_at' => now()]);

            return response()->json([
                'success' => true,
                'message' => 'Status berhasil diubah menjadi ' . ucfirst($newStatus)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }


    public function uploadfile($id)
    {
        try {
            $productId = is_numeric($id) ? $id : Crypt::decrypt($id);
            $produk = DB::table('products')->where('id', $productId)->first();

            if (!$produk) {
                return redirect()->route('produk.index')->with('error', 'Produk tidak ditemukan.');
            }

            // Hanya program sekolah
            if ($produk->tipe_produk !== 'program' || $produk->jenis_program !== 'sekolah') {
                return redirect()->route('produk.index')->with('error', 'Upload PDF hanya untuk program sekolah.');
            }

            // Ambil file yang sudah ada
            $materi = DB::table('file_download_program')
                ->where('product_id', $productId)
                ->get();

            return view('produk.upload_file', compact('produk', 'materi'));
        } catch (\Exception $e) {
            Log::error('Error membuka halaman upload PDF: ' . $e->getMessage());
            return redirect()->route('produk.index')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    public function uploadPdfChunk(Request $request)
    {
        try {
            Log::info('Upload start', ['keys' => array_keys($request->allFiles())]);

            $files = $request->file('file') ?? $request->file('pdf_file');

            if (!$files) {
                return response()->json(['status' => false, 'message' => 'No file received'], 400);
            }

            if (!is_array($files)) {
                $files = [$files];
            }

            $uploaded = [];

            foreach ($files as $file) {
                if (!$file->isValid()) continue;

                // Validasi: boleh PDF atau gambar
                $request->validate([
                    'file' => 'mimetypes:application/pdf,image/jpeg,image/png,image/jpg|max:102400',
                ]);

                $extension = $file->getClientOriginalExtension();
                $mime = $file->getMimeType();

                // Tentukan folder penyimpanan berdasarkan tipe file
                $folder = str_contains($mime, 'pdf') ? 'pdfs_program' : 'images_program';

                $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)
                    . '_' . time() . '.' . $extension;

                $path = $file->storeAs($folder, $filename, 'public');

                $uploaded[] = [
                    'path' => $path,
                    'url' => Storage::url($path),
                    'filename' => $filename,
                    'type' => str_contains($mime, 'pdf') ? 'pdf' : 'image'
                ];
            }

            return response()->json([
                'status' => true,
                'message' => 'File(s) uploaded successfully',
                'files' => $uploaded,
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => false,
                'message' => implode(', ', $e->validator->errors()->all())
            ], 422);
        } catch (\Exception $e) {
            Log::error('Upload failed: ' . $e->getMessage());
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }


    public function deletePdfChunk(Request $request)
    {
        try {
            $filePath = trim($request->getContent());
            if ($filePath && Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
                return response()->json(['status' => true, 'message' => 'File deleted successfully']);
            }
            return response()->json(['status' => false, 'message' => 'File not found']);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }


    public function store_file(Request $request)
    {

        try {
            $request->validate([
                'product_id' => 'required|exists:products,id',
                'judul.*' => 'required|string|max:255',
            ]);

            $productId = $request->input('product_id');
            $judulList = $request->input('judul', []);
            $idMateriList = $request->input('id_materi', []);
            $uploadedPaths = $request->input('uploaded_paths', []);

            $existingIds = DB::table('file_download_program')
                ->where('product_id', $productId)
                ->pluck('id')
                ->toArray();

            $processedIds = [];

            foreach ($judulList as $index => $judul) {
                $idMateri = $idMateriList[$index] ?? null;
                $path = $uploadedPaths[$index] ?? null;

                $fileType = null;
                if (!empty($uploadedPaths[$index])) {
                    $fileType = str_ends_with($uploadedPaths[$index], '.pdf') ? 'pdf' : 'image';
                }
                if ($idMateri) {
                    // Update data lama
                    $existing = DB::table('file_download_program')->find($idMateri);
                    if ($existing) {
                        DB::table('file_download_program')
                            ->where('id', $idMateri)
                            ->update([
                                'judul' => $judul,
                                'file_path' => $path ?: $existing->file_path,
                                'file_type' => $fileType ?? $existing->file_type,
                                'updated_at' => now(),
                            ]);
                        $processedIds[] = $idMateri;
                    }
                } else {
                    // Insert baru
                    $newId = DB::table('file_download_program')->insertGetId([
                        'product_id' => $productId,
                        'judul' => $judul,
                        'file_path' => $path,
                        'file_type' => $fileType ?? 'pdf',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    $processedIds[] = $newId;
                }
            }

            // Hapus data yang tidak ada lagi
            $toDelete = array_diff($existingIds, $processedIds);
            if (!empty($toDelete)) {
                DB::table('file_download_program')->whereIn('id', $toDelete)->delete();
            }

            return redirect()->route('produk.index')
                ->with('success', 'Materi berhasil disimpan dan diperbarui.');
        } catch (\Exception $e) {
            Log::error('Error saat menyimpan file materi: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }


    public function copy($id)
    {
        try {
            $produk = DB::table('products')->where('id', $id)->first();

            if (!$produk) {
                return response()->json([
                    'success' => false,
                    'message' => 'Produk tidak ditemukan'
                ], 404);
            }

            // Duplikasi data (tanpa ID, tapi bisa ubah judul biar unik)
            $newId = DB::table('products')->insertGetId([
                'judul' => $produk->judul . ' (Copy)',
                'deskripsi' => $produk->deskripsi,
                'manfaat' => $produk->manfaat,
                'harga' => $produk->harga,
                'tipe_produk' => $produk->tipe_produk,
                'thumbnail' => $produk->thumbnail,
                'status' => $produk->status,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil disalin.',
                'id_baru' => $newId,
            ]);
        } catch (\Exception $e) {
            Log::error('Error copy produk: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            // Hapus data kursus langsung dari database
            $deleted = DB::table('products')->where('id', $id)->delete();

            if ($deleted) {
                return response()->json([
                    'success' => true,
                    'message' => 'Kursus berhasil dihapus'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Kursus tidak ditemukan'
                ], 404);
            }
        } catch (\Exception $e) {
            Log::error('Error deleting kursus: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }


    public function create()
    {
        $forms = DB::table('forms')->orderBy('title')->get();
        return view('produk.create', compact('forms'));
    }


    public function store(Request $request)
    {


        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tipe_produk' => 'required|in:ebook,book_masterpiece,buku,kelas_video,program,mitra',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'harga' => $request->tipe_produk === 'mitra'
                ? 'nullable|numeric|min:0'
                : 'required|numeric|min:0',
            'status' => 'required|in:aktif,nonaktif',
            'manfaat' => 'nullable|array',
            'manfaat.*.judul' => 'nullable|string|max:255',
            'manfaat.*.deskripsi' => 'nullable|string',
        ]);

        try {
            $thumbnailPath = null;

            if ($request->hasFile('thumbnail')) {
                $file = $request->file('thumbnail');
                $filename = Str::uuid() . '.webp'; // Nama acak aman
                $path = 'thumbnails/' . $filename;

                $manager = new ImageManager(new Driver());
                $image = $manager->read($file)->toWebp(80);

                Storage::disk('public')->put($path, $image);
                $thumbnailPath = $path;
            }


            $slugBase = Str::slug($request->judul);
            $slug = $slugBase;
            $count = DB::table('products')->where('slug', $slugBase)->count();
            if ($count > 0) {
                $slug = "{$slugBase}-{$count}";
            }
            DB::table('products')->insert([
                'judul' => $request->judul,
                'slug' => $slug,
                'deskripsi' => $request->deskripsi,
                'manfaat' => json_encode($request->manfaat ?? []),
                'harga' => $request->harga,
                'tipe_produk' => $request->tipe_produk,
                'thumbnail' => $thumbnailPath,
                'jenis_program' => $request->jenis_program ?? null,
                'form_id' => $request->form_id,
                'payment_type' => $request->payment_type,
                'status' => $request->status,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return redirect()->route('produk.index')
                ->with('success', 'Produk berhasil disimpan.');
        } catch (\Exception $e) {
            Log::error('Error store produk: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $decryptedId = Crypt::decrypt($id);
        $produk = DB::table('products')->where('id', $decryptedId)->first();
        $forms = DB::table('forms')->orderBy('title')->get();
        if (!$produk) {
            return redirect()->route('produk.index')->with('error', 'Produk tidak ditemukan');
        }

        return view('produk.create', compact('produk', 'forms'));
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tipe_produk' => 'required|in:ebook,book_masterpiece,buku,kelas_video,program,mitra',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'harga' => $request->tipe_produk === 'mitra'
                ? 'nullable|numeric|min:0'
                : 'required|numeric|min:0',
            'status' => 'required|in:aktif,nonaktif',
            'manfaat' => 'nullable|array',
            'manfaat.*.judul' => 'nullable|string|max:255',
            'manfaat.*.deskripsi' => 'nullable|string',
        ]);

        try {
            $produk = DB::table('products')->where('id', $id)->first();
            if (!$produk) {
                return back()->with('error', 'Produk tidak ditemukan');
            }

            $data = [
                'judul' => $request->judul,
                'deskripsi' => $request->deskripsi,
                'manfaat' => json_encode($request->manfaat ?? []),
                'harga' => $request->harga,
                'tipe_produk' => $request->tipe_produk,
                'jenis_program' => $request->jenis_program ?? null,
                'form_id' => $request->form_id,
                'payment_type' => $request->payment_type,
                'status' => $request->status,
                'updated_at' => now(),
            ];

            if ($request->hasFile('thumbnail')) {
                if ($produk->thumbnail && Storage::disk('public')->exists($produk->thumbnail)) {
                    Storage::disk('public')->delete($produk->thumbnail);
                }

                $file = $request->file('thumbnail');
                $filename = Str::uuid() . '.webp';
                $path = 'thumbnails/' . $filename;

                $manager = new ImageManager(new Driver());
                $image = $manager->read($file)->toWebp(80);
                Storage::disk('public')->put($path, $image);

                $data['thumbnail'] = $path;
            }

            DB::table('products')->where('id', $id)->update($data);

            return redirect()->route('produk.index')
                ->with('success', 'Produk berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Error update produk: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function kursus()
    {
        $content = DB::table('landing_page_sections')->first();
        $programs = DB::table('products')
            ->where('tipe_produk', 'program')
            ->where('status', 'aktif')
            ->orderBy('created_at', 'desc')
            ->limit(4)
            ->get();

        $landingPage = DB::table('landing_page_sections')->first();
        $featurespage = DB::table('landing_page_features')
            ->where('landing_page_id', $landingPage->id ?? 1)
            ->orderBy('order', 'asc')
            ->get();
        $kelasVideo = DB::table('products')
            ->where('tipe_produk', 'kelas_video')
            ->where('status', 'aktif')
            ->orderBy('created_at', 'desc')
            ->limit(4)
            ->get();

        $ebooks = DB::table('products')
            ->where('tipe_produk', 'ebook')
            ->where('status', 'aktif')
            ->orderBy('created_at', 'desc')
            ->limit(4)
            ->get();

        $book_masterpiece = DB::table('products')
            ->where('tipe_produk', 'book_masterpiece')
            ->where('status', 'aktif')
            ->orderBy('created_at', 'desc')
            ->limit(4)
            ->get();

        $bukus = DB::table('products')
            ->where('tipe_produk', 'buku')
            ->where('status', 'aktif')
            ->orderBy('created_at', 'desc')
            ->limit(4)
            ->get();
        $mitras = DB::table('products')
            ->where('tipe_produk', 'mitra')
            ->where('status', 'aktif')
            ->orderBy('created_at', 'desc')
            ->limit(4)
            ->get();

        $testimonials = DB::table('landing_page_testimonials')
            ->where('landing_page_id', $content->id ?? 1)
            ->orderBy('order', 'asc')
            ->get();
        $faqs = DB::table('landing_page_faqs')
            ->where('landing_page_id', $content->id ?? 1)
            ->orderBy('order', 'asc')
            ->get();

        return view('welcome', compact('programs', 'mitras', 'landingPage', 'featurespage', 'kelasVideo', 'ebooks', 'bukus', 'content', 'testimonials', 'faqs', 'book_masterpiece'));
    }
    public function course()
    {
        // Ambil semua data course dari tabel 'products'
        $products = DB::table('products')
            ->join('kategori', 'products.id_kategori', '=', 'kategori.id')
            ->select('products.id', 'products.title', 'kategori.id as kategori_id', 'products.description', 'products.thumbnail', 'products.price', 'products.features', 'kategori.nama_kategori')
            ->orderBy('products.created_at', 'desc')
            ->get();
        $kategori = DB::table('kategori')->get();

        return view('kursus', compact('products', 'kategori'));
    }
    public function detail($encryptedCourseId)
    {
        try {
            $courseId = Crypt::decrypt($encryptedCourseId);

            // Ambil data course dari database tanpa model
            $produk = DB::table('products')->where('id', $courseId)->first();

            if (!$produk) {
                return redirect()->back()->with('error', 'Kursus tidak ditemukan.');
            }

            return view('produk.detail', compact('produk'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function checkout($id)
    {


        $id = Crypt::decrypt($id);
        try {
            $produk = DB::table('products')->where('id', $id)->first();

            if (!$produk) {
                return redirect()->back()->with('error', 'Produk tidak ditemukan.');
            }

            return view('produk.checkout', compact('produk'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function pay(Request $request, $id)
    {
        // Contoh simpan transaksi
        DB::table('transactions')->insert([
            'course_id' => $id,
            'user_id' => auth()->id(),
            'status' => 'pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('course')->with('success', 'Pembayaran berhasil, silakan cek riwayat transaksi!');
    }

    public function show($id)
    {
        try {
            $id = Crypt::decrypt($id);

            // Ambil data course dari database tanpa model
            $produk = DB::table('products')->where('id', $id)->first();

            if (!$produk) {
                return redirect()->back()->with('error', 'Kursus tidak ditemukan.');
            }

            $related = DB::table('products')
                ->where('tipe_produk', $produk->tipe_produk)
                ->where('id', '!=', $id)
                ->limit(4)
                ->get();

            return view('produk.show', compact('produk', 'related'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
