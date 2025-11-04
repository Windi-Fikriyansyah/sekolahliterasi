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
use App\Models\LpProgram;
use Dotlogics\Grapesjs\App\Traits\EditorTrait;
use App\Models\Page;

class ProgramsController extends Controller
{
    use EditorTrait;
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
            <a href="' . route('lp_programs.atur', $encryptedId) . '" class="btn btn-sm btn-warning" title="Atur Halaman">
                <i class="bi bi-pencil-square"></i> Atur
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

        $id = Crypt::decrypt($encryptedId);

        $pages = DB::table('pages')
            ->where('id_product', $id)
            ->orderBy('created_at', 'DESC')
            ->get();

        $id_product = $id;
        return view('lp_programs.atur', compact('pages', 'id_product'));
    }

    public function create($id_product = null)
    {
        return view('lp_programs.create', compact('id_product'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'title' => 'required|string|max:255',
            'short_description' => 'required|string',
            'id_product' => 'required',
        ]);

        // Ambil konten default dari file JSON
        $jsonFilePath = storage_path('app/public/default.json');
        $jsonContent = file_get_contents($jsonFilePath);

        // Buat UUID baru untuk id
        $uuid = (string) Str::uuid();

        // Simpan data ke tabel pages
        DB::table('pages')->insert([
            'id' => $uuid,
            'id_product' => $request->id_product,
            'title' => $request->title,
            'short_description' => $request->short_description,
            'content' => $jsonContent,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Redirect kembali ke halaman atur
        return redirect()
            ->route('lp_programs.atur', Crypt::encrypt($request->id_product))
            ->with('success', 'Page berhasil dibuat.');
    }

    public function edit($id)
    {
        $page = DB::table('pages')->where('id', $id)->first();
        return view('lp_programs.create', compact('page'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'short_description' => 'required|string',
        ]);

        $page = DB::table('pages')->where('id', $id)->first();
        if (!$page) {
            abort(404, 'Halaman tidak ditemukan');
        }

        // Lakukan update data
        DB::table('pages')
            ->where('id', $id)
            ->update([
                'title' => $request->title,
                'short_description' => $request->short_description,
                'updated_at' => now(),
            ]);


        return redirect()
            ->route('lp_programs.atur', Crypt::encrypt($page->id_product))
            ->with('success', 'Page berhasil diperbarui.');
    }


    public function destroy($id)
    {
        try {

            $page = DB::table('pages')->where('id', $id)->first();
            if (!$page) {
                return redirect()->back()->with('error', 'Halaman tidak ditemukan.');
            }


            DB::table('pages')->where('id', $id)->delete();

            // Redirect ke halaman atur sesuai id_product
            return redirect()
                ->route('lp_programs.atur', Crypt::encrypt($page->id_product))
                ->with('success', 'Page berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Gagal menghapus page: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus data.');
        }
    }


    public function show($id)
    {
        $page = DB::table('pages')->where('id', $id)->first();

        if (!$page) {
            abort(404, 'Halaman tidak ditemukan');
        }

        return view('lp_programs.preview', compact('page'));
    }
}
