<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;


class CartController extends Controller
{
    // 🔹 Ambil semua item cart milik user login
    public function index()
    {
        $carts = DB::table('carts')
            ->join('products', 'carts.product_id', '=', 'products.id')
            ->select(
                'carts.id as cart_id',
                'carts.qty',
                'carts.checked',
                'products.id as product_id',
                'products.judul',
                'products.harga',
                'products.thumbnail'
            )
            ->where('carts.user_id', Auth::id())
            ->get();

        return response()->json($carts);
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $existing = DB::table('carts')
            ->where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->first();

        if ($existing) {
            // jika sudah ada → naikkan qty
            DB::table('carts')
                ->where('id', $existing->id)
                ->update([
                    'qty' => $existing->qty + 1,
                    'updated_at' => now(),
                ]);
            return response()->json([
                'message' => 'Produk sudah ada di keranjang',
                'status' => 'exists'
            ]);
        }

        DB::table('carts')->insert([
            'user_id' => Auth::id(),
            'product_id' => $request->product_id,
            'qty' => 1,
            'checked' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json([
            'message' => 'Produk ditambahkan ke keranjang',
            'status' => 'new'
        ]);
    }

    // 🔹 Update jumlah (qty)
    public function updateQty(Request $request, $id)
    {
        $request->validate(['qty' => 'required|integer|min:1']);

        DB::table('carts')
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->update([
                'qty' => $request->qty,
                'updated_at' => now(),
            ]);

        return response()->json(['message' => 'Jumlah diperbarui']);
    }

    // 🔹 Ubah status checked (pilih untuk checkout)
    public function toggleCheck(Request $request, $id)
    {
        $request->validate(['checked' => 'required|boolean']);

        DB::table('carts')
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->update([
                'checked' => $request->checked,
                'updated_at' => now(),
            ]);


        return response()->json(['message' => 'Status diperbarui']);
    }


    // 🔹 Hapus item dari cart
    public function remove($id)
    {
        DB::table('carts')
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->delete();

        return response()->json(['message' => 'Item dihapus dari keranjang']);
    }

    // 🔹 Hitung total belanja item yang dipilih (checked)
    public function total()
    {
        $total = DB::table('carts')
            ->join('products', 'carts.product_id', '=', 'products.id')
            ->where('carts.user_id', Auth::id())
            ->where('carts.checked', true)
            ->sum(DB::raw('products.harga * carts.qty'));

        return response()->json(['total' => $total]);
    }



    public function checkoutBuku()
    {
        // 🔹 Ambil asal pengiriman (city_id) dari profile_perusahaan
        $asal = DB::table('profile_perusahaan')->first();

        // 🔹 Ambil daftar provinsi dari RajaOngkir
        $response = Http::withHeaders([
            'key' => config('services.rajaongkir.key')
        ])->get('https://rajaongkir.komerce.id/api/v1/destination/province');

        $provinsi = $response->successful() ? ($response->json()['data'] ?? []) : [];

        // 🔹 Ambil produk dari cart yang dicentang
        $checkoutItems = DB::table('carts')
            ->join('products', 'carts.product_id', '=', 'products.id')
            ->select(
                'carts.id as cart_id',
                'carts.qty',
                'products.judul',
                'products.harga',
                'products.thumbnail'
            )
            ->where('carts.user_id', Auth::id())
            ->where('carts.checked', 1)
            ->get();

        // Jika tidak ada item dipilih, kembali ke halaman utama
        if ($checkoutItems->isEmpty()) {
            return redirect('/')->with('warning', 'Pilih produk terlebih dahulu sebelum checkout.');
        }

        return view('produk.checkout_buku', compact('provinsi', 'asal', 'checkoutItems'));
    }


    public function getKota($provinsi_id)
    {
        try {
            $response = Http::withHeaders([
                'key' => config('services.rajaongkir.key'),
            ])->get("https://rajaongkir.komerce.id/api/v1/destination/city/{$provinsi_id}");

            if ($response->successful()) {
                $json = $response->json();

                // ✅ Ambil dari key "data"
                if (isset($json['data']) && is_array($json['data'])) {
                    return response()->json($json['data']);
                } else {
                    return response()->json([
                        'error' => 'Format respons tidak sesuai',
                        'response' => $json,
                    ], 500);
                }
            }

            return response()->json([
                'error' => 'Gagal mengambil data kota',
                'status' => $response->status(),
                'body' => $response->body(),
            ], $response->status());
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Terjadi kesalahan',
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    public function getKecamatan($city_id)
    {
        try {
            $response = Http::withHeaders([
                'key' => config('services.rajaongkir.key')
            ])->get("https://rajaongkir.komerce.id/api/v1/destination/district/{$city_id}");

            if ($response->successful()) {
                $json = $response->json();

                if (isset($json['data']) && is_array($json['data'])) {
                    return response()->json($json['data']);
                } else {
                    return response()->json([
                        'error' => 'Format respons tidak sesuai',
                        'response' => $json,
                    ], 500);
                }
            } else {
                return response()->json([
                    'error' => 'Gagal mengambil data kecamatan',
                    'status' => $response->status(),
                    'body' => $response->body(),
                ], $response->status());
            }
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Terjadi kesalahan',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function getOngkir(Request $request)
    {

        try {
            // Ambil origin dari profile_perusahaan (ID district/kecamatan asal pengiriman)
            $asal = DB::table('profile_perusahaan')->value('origin_subdistrict_id');

            // Ambil data dari request
            $destination = $request->input('kecamatan'); // ID district tujuan
            $kurir = $request->input('kurir'); // Contoh: jne / tiki / pos
            $weight = 1000; // gram (1kg)
            $price_mode = 'lowest'; // sesuai dokumentasi

            // Pastikan semua parameter wajib ada
            if (!$asal || !$destination || !$kurir) {
                return response()->json([
                    'error' => 'Data tidak lengkap. Pastikan origin, destination, dan kurir sudah dipilih.'
                ], 422);
            }

            // Panggil API RajaOngkir (POST dengan form-urlencoded)
            $response = Http::asForm()
                ->withHeaders([
                    'key' => config('services.rajaongkir.key'),
                    'Content-Type' => 'application/x-www-form-urlencoded',
                ])
                ->post('https://rajaongkir.komerce.id/api/v1/calculate/district/domestic-cost', [
                    'origin' => $asal,
                    'destination' => $destination,
                    'weight' => $weight,
                    'courier' => $kurir, // bisa lebih dari 1 kurir, misalnya: jne:tiki:pos
                    'price' => $price_mode,
                ]);

            // Tangani jika gagal
            if (!$response->successful()) {
                return response()->json([
                    'error' => 'Gagal menghitung ongkir',
                    'status' => $response->status(),
                    'body' => $response->body(),
                ], $response->status());
            }

            // Parsing hasil JSON
            $data = $response->json();


            if (!isset($data['data']) || !is_array($data['data'])) {
                return response()->json([
                    'error' => 'Format respons tidak sesuai',
                    'response' => $data,
                ], 500);
            }

            // Kirim hasil balik ke frontend
            return response()->json([
                'success' => true,
                'results' => $data['data']
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Terjadi kesalahan saat menghitung ongkir',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
