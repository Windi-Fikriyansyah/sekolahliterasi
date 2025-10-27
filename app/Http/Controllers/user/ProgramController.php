<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

class ProgramController extends Controller
{

    public function index()
    {
        $programs = DB::table('products')
            ->where('tipe_produk', 'program')
            ->where('status', 'aktif')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('program', compact('programs'));
    }

    public function daftar($slug)
    {
        try {

            [$judulSlug, $encryptedId] = explode('--', $slug);

            // Dekripsi ID
            $product_id = Crypt::decryptString($encryptedId);
        } catch (\Exception $e) {
            abort(404, 'Link tidak valid');
        }
        $product = DB::table('products')->where('id', $product_id)->first();
        return view('landing_page.daftar', compact('product'));
    }


    public function landing_page($slug)
    {
        try {
            // Pisahkan bagian judul dan ID terenkripsi
            [$judulSlug, $encryptedId] = explode('--', $slug);

            // Dekripsi ID
            $product_id = Crypt::decryptString($encryptedId);
        } catch (\Exception $e) {
            abort(404, 'Link tidak valid');
        }

        // Ambil data produk berdasarkan ID
        $product = DB::table('products')->where('id', $product_id)->first();
        if (!$product) {
            abort(404, 'Produk tidak ditemukan');
        }

        // Ambil landing page sesuai product_id
        $landing = DB::table('lp_programs')->where('product_id', $product_id)->first();
        if (!$landing) {
            abort(404, 'Landing page tidak ditemukan untuk produk ini');
        }

        return view('landing_page.index', compact('product', 'landing'));
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'asal_instansi' => 'required|string|max:255',
            'profesi' => 'required|string|max:255',
            'kota' => 'required|string|max:100',
            'provinsi' => 'required|string|max:100',
            'no_wa' => 'required|string|max:20',
            'foto' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'alamat' => 'required|string|max:500',
        ]);

        // Simpan file foto
        $path = $request->file('foto')->store('uploads/foto_pendaftar', 'public');

        // Simpan ke database
        DB::table('pendaftaran_program')->insert([
            'user_id' => Auth::id(),
            'id_product' => $request->id_product,
            'nama_lengkap' => $validated['nama_lengkap'],
            'asal_instansi' => $validated['asal_instansi'],
            'profesi' => $validated['profesi'],
            'kota' => $validated['kota'],
            'provinsi' => $validated['provinsi'],
            'no_wa' => $validated['no_wa'],
            'foto' => $path,
            'alamat' => $validated['alamat'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $product = DB::table('products')->where('id', $request->id_product)->first();

        // Enkripsi id produk agar aman untuk dikirim ke route pembayaran
        $encryptedId = \Illuminate\Support\Facades\Crypt::encrypt($product->id);

        // Redirect ke halaman pemilihan channel pembayaran
        return redirect()->route('payment.index', $encryptedId);
    }
}
