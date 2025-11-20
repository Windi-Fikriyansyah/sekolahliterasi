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
use Illuminate\Support\Facades\Http;

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

    public function pembayaran()
    {
        $programs = DB::table('pendaftaran_program')
            ->join('products', 'pendaftaran_program.id_product', '=', 'products.id')
            ->select(
                'pendaftaran_program.*',
                'products.id as product_id',
                'products.judul',
                'products.payment_type',
                'products.jenis_program',
                'products.status as status_program'
            )
            ->where('pendaftaran_program.user_id', Auth::id())
            ->orderBy('pendaftaran_program.created_at', 'desc')
            ->get()
            ->map(function ($program) {
                $program->files = DB::table('file_download_program')
                    ->where('product_id', $program->product_id)
                    ->get();
                return $program;
            });

        return view('pembayaran_program', compact('programs'));
    }


    public function daftar($slug)
    {
        $product = DB::table('products')->where('slug', $slug)->first();

        if (!$product) {
            abort(404, 'Produk tidak ditemukan');
        }

        // Ambil formulir berdasarkan product->form_id
        $form = DB::table('forms')->where('id', $product->form_id)->first();

        if (!$form) {
            abort(404, 'Formulir tidak ditemukan');
        }

        // Ambil field dari form_fields
        $formFields = DB::table('form_fields')
            ->where('form_id', $form->id)
            ->orderBy('order', 'asc')
            ->get();

        return view('landing_page.daftar', compact('product', 'form', 'formFields'));
    }

    public function getProvinsi()
    {
        $response = Http::get('https://wilayah.id/api/provinces.json');
        return response()->json($response->json());
    }

    public function getKota($kode)
    {
        $response = Http::get("https://wilayah.id/api/regencies/{$kode}.json");
        return response()->json($response->json());
    }

    public function daftarProgram($slug)
    {
        try {

            [$judulSlug, $encryptedId] = explode('--', $slug);

            // Dekripsi ID
            $product_id = Crypt::decryptString($encryptedId);
        } catch (\Exception $e) {
            abort(404, 'Link tidak valid');
        }
        $product = DB::table('products')->where('id', $product_id)->first();
        return view('landing_page.daftar_program', compact('product'));
    }





    public function landing_page($slug)
    {
        $product = DB::table('products')->where('slug', $slug)->first();
        if (!$product) {
            abort(404, 'Produk tidak ditemukan');
        }

        $landing = DB::table('pages')->where('id_product', $product->id)->first();
        if (!$landing) {
            abort(404, 'Landing page tidak ditemukan untuk produk ini');
        }

        $slugDaftar = $product->slug;
        // Ambil seluruh PDF/VIDEO BERDASARKAN URUTAN
        $programs = DB::table('lp_program_pdfs')
            ->where('id_program', $product->id)
            ->orderBy('urutan', 'ASC')
            ->get();

        return view('landing_page.index', [
            'product' => $product,
            'landing' => $landing,
            'programs' => $programs,
            'slugDaftar' => $slugDaftar
        ]);
    }

    public function store(Request $request)
    {
        // Ambil produk
        $product = DB::table('products')->where('id', $request->id_product)->first();

        if (!$product) {
            return back()->with('error', 'Produk tidak ditemukan');
        }

        // Ambil semua field dari form
        $formFields = DB::table('form_fields')
            ->where('form_id', $request->form_id)
            ->get();

        $savedValues = []; // tempat menyimpan hasil input

        foreach ($formFields as $field) {

            $fieldName = "fields_" . $field->id;

            // Jika file
            if ($field->type == 'file') {
                if ($request->hasFile("fields.$field->id")) {
                    $file = $request->file("fields.$field->id");
                    $path = $file->store('uploads/form_files', 'public');
                    $savedValues[$field->label] = $path;
                } else {
                    $savedValues[$field->label] = null;
                }
                continue;
            }

            // Checkbox (array)
            if ($field->type == 'checkbox') {
                $savedValues[$field->label] = $request->input("fields.$field->id", []);
                continue;
            }

            // Field umum
            $savedValues[$field->label] = $request->input("fields.$field->id");
        }

        // Simpan ke database
        DB::table('pendaftaran_program')->insert([
            'user_id'    => Auth::id(),
            'id_product' => $request->id_product,
            'form_id'    => $request->form_id,
            'value'      => json_encode($savedValues),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        if ($product->payment_type === 'manual') {

            $user = Auth::user();

            // Generate ID unik
            $externalId = 'MAN-PROGRAM-' . $user->id . '-' . time();
            $invoiceId  = 'INV-MAN-' . time();



            // Insert transaksi manual
            DB::table('transactions')->insert([
                'external_id'      => $externalId,
                'invoice_id'       => $invoiceId,
                'user_id'          => $user->id,
                'product_id'       => $product->id,
                'amount'           => $product->harga ?? 0,
                'status'           => 'PENDING',
                'payment_method'   => 'manual',
                'payment_channel'  => 'manual',
                'paid_at'          => now(),
                'expired_at'       => null,
                'tripay_data'      => null,

                'created_at'          => now(),
                'updated_at'          => now(),
            ]);

            return redirect()->route('pendaftaran.sukses');
        }


        // Jika auto → redirect ke halaman pemilihan channel pembayaran
        $encryptedId = \Illuminate\Support\Facades\Crypt::encrypt($product->id);
        return redirect()->route('payment.index', $encryptedId);
    }


    public function storesekolah(Request $request)
    {
        // Validasi input sesuai form
        $validated = $request->validate([
            'nama_sekolah' => 'required|string|max:255',
            'npsn' => 'nullable|string|max:50',
            'kategori' => 'required|string|max:100',
            'alamat' => 'required|string|max:500',
            'kota' => 'required|string|max:100',
            'provinsi' => 'required|string|max:100',
            'kepala' => 'required|string|max:255',
            'hp_kepala' => 'required|string|max:20',
            'koordinator' => 'required|string|max:255',
            'wa_koordinator' => 'required|string|max:20',
            'total_siswa' => 'required|integer|min:1',
            'jumlah_siswa_daftar' => 'required|integer|min:1',
            'jumlah_guru_daftar' => 'required|integer|min:0',
            'kategori_karya' => 'required|array|min:1',
            'kategori_karya.*' => 'string|max:100',
            'sumber_biaya' => 'required|string|max:255',
            'testimoni' => 'nullable|string|max:1000',
            'fasilitator' => 'nullable|string|max:255',
        ]);

        // Simpan ke database
        DB::table('pendaftaran_program')->insert([
            'user_id' => Auth::id(),
            'id_product' => $request->id_product,
            'nama_sekolah' => $validated['nama_sekolah'],
            'npsn' => $validated['npsn'] ?? null,
            'kategori' => $validated['kategori'],
            'alamat' => $validated['alamat'],
            'kota' => $validated['kota'],
            'provinsi' => $validated['provinsi'],
            'kepala' => $validated['kepala'],
            'hp_kepala' => $validated['hp_kepala'],
            'koordinator' => $validated['koordinator'],
            'wa_koordinator' => $validated['wa_koordinator'],
            'total_siswa' => $validated['total_siswa'],
            'jumlah_siswa_daftar' => $validated['jumlah_siswa_daftar'],
            'jumlah_guru_daftar' => $validated['jumlah_guru_daftar'],
            'kategori_karya' => implode(', ', $validated['kategori_karya']), // array -> string
            'sumber_biaya' => $validated['sumber_biaya'],
            'testimoni' => $validated['testimoni'] ?? null,
            'fasilitator' => $validated['fasilitator'] ?? null,
            'status_pendaftaran' => 'pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('pembayaran_program_sekolah.index')
            ->with('success', 'Pendaftaran berhasil!');
    }
}
