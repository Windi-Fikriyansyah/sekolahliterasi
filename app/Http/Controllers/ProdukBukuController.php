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

class ProdukBukuController extends Controller
{
    public function index()
    {
        return view('produk_buku.index');
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
                ->where('tipe_produk', 'buku')
                ->orderBy('created_at', 'desc');

            return DataTables::of($kursus)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $encryptedId = Crypt::encrypt($row->id);
                    $deleteUrl = route('produk_buku.destroy', $row->id);

                    $buttons = '<div class="btn-group" role="group">';
                    $buttons .= '<a href="' . route('produk_buku.edit', $encryptedId) . '" class="btn btn-sm btn-warning me-1" title="Edit"><i class="bi bi-pencil"></i></a>';
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

    public function destroy($id)
    {
        try {
            DB::table('bukus_detail')->where('product_id', $id)->delete();
            DB::table('products')->where('id', $id)->delete();

            return response()->json(['success' => true, 'message' => 'Produk berhasil dihapus']);
        } catch (\Exception $e) {
            Log::error('Error delete produk: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }


    public function create()
    {

        $kategoris = DB::table('kategori_buku')
            ->select('kategori_buku.*')
            ->get();
        return view('produk_buku.create', compact('kategoris'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'harga' => 'required|numeric|min:0',
            'status' => 'required|in:aktif,nonaktif',
            // validasi tambahan untuk detail buku
            'penulis' => 'nullable|string|max:255',
            'isbn' => 'nullable|string|max:255',
            'penerbit' => 'nullable|string|max:255',
            'tanggal_terbit' => 'nullable|date',
            'jumlah_halaman' => 'nullable|numeric',
            'berat' => 'nullable|numeric',
            'jenis_cover' => 'nullable|string|max:255',
            'dimensi' => 'nullable|string|max:255',
            'kategori' => 'required|string|max:255',
            'bahasa' => 'nullable|string|max:255',
            'stok' => 'nullable|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $thumbnailPath = null;

            // Simpan thumbnail sebagai WebP
            if ($request->hasFile('thumbnail')) {
                $file = $request->file('thumbnail');
                $filename = Str::uuid() . '.webp';
                $path = 'thumbnails/' . $filename;

                $manager = new ImageManager(new Driver());
                $image = $manager->read($file)->toWebp(80);

                Storage::disk('public')->put($path, $image);
                $thumbnailPath = $path;
            }

            // Simpan ke tabel products
            $productId = DB::table('products')->insertGetId([
                'judul' => $request->judul,
                'deskripsi' => $request->deskripsi,
                'harga' => $request->harga,
                'tipe_produk' => 'buku',
                'thumbnail' => $thumbnailPath,
                'status' => $request->status,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Simpan ke tabel bukus_detail
            DB::table('bukus_detail')->insert([
                'product_id' => $productId,
                'penulis' => $request->penulis,
                'isbn' => $request->isbn,
                'penerbit' => $request->penerbit,
                'tanggal_terbit' => $request->tanggal_terbit,
                'jumlah_halaman' => $request->jumlah_halaman,
                'berat' => $request->berat,
                'jenis_cover' => $request->jenis_cover,
                'dimensi' => $request->dimensi,
                'kategori' => $request->kategori,
                'bahasa' => $request->bahasa,
                'stok' => $request->stok,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::commit();

            return redirect()->route('produk_buku.index')
                ->with('success', 'Produk berhasil disimpan ke dua tabel.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error store produk: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $decryptedId = Crypt::decrypt($id);

        $produk = DB::table('products')
            ->join('bukus_detail', 'products.id', '=', 'bukus_detail.product_id')
            ->select('products.*', 'bukus_detail.*', 'products.id as id')
            ->where('products.id', $decryptedId)
            ->first();

        if (!$produk) {
            return redirect()->route('produk_buku.index')->with('error', 'Produk tidak ditemukan');
        }

        $kategoris = DB::table('kategori_buku')->get();
        return view('produk_buku.create', compact('produk', 'kategoris'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric|min:0',
            'status' => 'required|in:aktif,nonaktif',
            'kategori' => 'required|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            $produk = DB::table('products')->where('id', $id)->first();
            if (!$produk) {
                return back()->with('error', 'Produk tidak ditemukan');
            }

            // Update produk utama
            $data = [
                'judul' => $request->judul,
                'deskripsi' => $request->deskripsi,
                'harga' => $request->harga,
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

            // Update detail buku
            DB::table('bukus_detail')->where('product_id', $id)->update([
                'penulis' => $request->penulis,
                'isbn' => $request->isbn,
                'penerbit' => $request->penerbit,
                'tanggal_terbit' => $request->tanggal_terbit,
                'jumlah_halaman' => $request->jumlah_halaman,
                'berat' => $request->berat,
                'jenis_cover' => $request->jenis_cover,
                'dimensi' => $request->dimensi,
                'kategori' => $request->kategori,
                'bahasa' => $request->bahasa,
                'stok' => $request->stok,
                'updated_at' => now(),
            ]);

            DB::commit();
            return redirect()->route('produk_buku.index')->with('success', 'Produk berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error update produk: ' . $e->getMessage());
            return back()->withInput()->with('error', $e->getMessage());
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
    public function detail($slug)
    {
        // Ambil ID dari slug (angka di belakang)
        $id = (int) substr(strrchr($slug, '-'), 1);

        $course = DB::table('products')
            ->join('kategori', 'products.id_kategori', '=', 'kategori.id')
            ->select('products.*', 'kategori.nama_kategori')
            ->where('products.id', $id)
            ->first();

        if (!$course) {
            abort(404);
        }

        return view('produk_buku.detail', compact('course'));
    }

    public function checkout($id)
    {
        $course = DB::table('products')->where('id', $id)->first();
        return view('produk_buku.checkout', compact('course'));
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

    public function show($encryptedCourseId)
    {
        try {
            $courseId = Crypt::decryptString($encryptedCourseId);

            // Ambil data course dari database tanpa model
            $course = DB::table('products')->where('id', $courseId)->first();

            if (!$course) {
                return redirect()->back()->with('error', 'Kursus tidak ditemukan.');
            }

            return view('produk_buku.show', compact('course'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
