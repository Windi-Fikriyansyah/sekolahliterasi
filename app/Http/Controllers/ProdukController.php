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
                    'status',
                    'created_at',
                    'updated_at'
                ])
                ->whereIn('tipe_produk', ['ebook', 'kelas_video', 'program'])
                ->orderBy('created_at', 'desc');

            return DataTables::of($kursus)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $encryptedId = Crypt::encrypt($row->id);
                    $deleteUrl = route('produk.destroy', $row->id);

                    $buttons = '<div class="btn-group" role="group">';
                    $buttons .= '<a href="' . route('produk.edit', $encryptedId) . '" class="btn btn-sm btn-warning me-1" title="Edit"><i class="bi bi-pencil"></i></a>';
                    $buttons .= '<button class="btn btn-sm btn-info copy-btn" title="Copy" data-id="' . $row->id . '"><i class="bi bi-files"></i></button>';
                    $buttons .= '<button class="btn btn-sm btn-danger delete-btn" title="Hapus" data-id="' . $row->id . '" data-url="' . $deleteUrl . '"><i class="bi bi-trash"></i></button>';
                    $buttons .= '</div>';

                    return $buttons;
                })
                ->rawColumns(['action'])
                ->make(true);
        } catch (\Exception $e) {
            Log::error('Error loading kursus data: ' . $e->getMessage());
            return response()->json([
                'error' => true,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
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

        return view('produk.create');
    }


    public function store(Request $request)
    {

        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tipe_produk' => 'required|in:ebook,buku,kelas_video,program',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'harga' => 'required|numeric|min:0',
            'status' => 'required|in:aktif,nonaktif',
            'manfaat' => 'nullable|array',
            'manfaat.*.judul' => 'nullable|string|max:255',
            'manfaat.*.deskripsi' => 'nullable|string|max:500',
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

            DB::table('products')->insert([
                'judul' => $request->judul,
                'deskripsi' => $request->deskripsi,
                'manfaat' => json_encode($request->manfaat ?? []),
                'harga' => $request->harga,
                'tipe_produk' => $request->tipe_produk,
                'thumbnail' => $thumbnailPath,
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
        if (!$produk) {
            return redirect()->route('produk.index')->with('error', 'Produk tidak ditemukan');
        }

        return view('produk.create', compact('produk'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tipe_produk' => 'required|in:ebook,buku,kelas_video,program',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'harga' => 'required|numeric|min:0',
            'status' => 'required|in:aktif,nonaktif',
            'manfaat' => 'nullable|array',
            'manfaat.*.judul' => 'nullable|string|max:255',
            'manfaat.*.deskripsi' => 'nullable|string|max:500',
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
        $programs = DB::table('products')
            ->where('tipe_produk', 'program')
            ->where('status', 'aktif')
            ->orderBy('created_at', 'desc')
            ->limit(4)
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

        $bukus = DB::table('products')
            ->where('tipe_produk', 'buku')
            ->where('status', 'aktif')
            ->orderBy('created_at', 'desc')
            ->limit(4)
            ->get();

        return view('welcome', compact('programs', 'kelasVideo', 'ebooks', 'bukus'));
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
