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

class MitraController extends Controller
{
    use EditorTrait;
    public function index()
    {
        return view('lp_mitra.index');
    }

    public function load(Request $request)
    {
        try {
            $kursus = DB::table('products')
                ->select(['id', 'judul', 'tipe_produk', 'thumbnail', 'status', 'created_at'])
                ->where('status', 'aktif')
                ->where('tipe_produk', 'mitra')
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
                    return '
        <div class="btn-group" role="group">
            <button class="btn btn-sm btn-warning upload-btn" data-id="' . $row->id . '" title="Upload PDF">
                <i class="bi bi-upload"></i> Atur
            </button>
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

    public function uploadPdf(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:products,id',
            'file_pdf' => 'required|mimes:pdf',
            'whatsapp' => 'required|string|min:10|max:20'
        ]);

        try {
            $file = $request->file('file_pdf');
            $filename = 'mitra_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('kemitraan/pdf', $filename, 'public');

            DB::table('products')
                ->where('id', $request->produk_id)
                ->update([
                    'pdf_path' => $path,
                    'whatsapp' => $request->whatsapp,
                ]); // pastikan kolom pdf_path sudah ada

            return response()->json(['success' => true, 'message' => 'File PDF berhasil diupload!']);
        } catch (\Exception $e) {
            Log::error('Upload PDF gagal: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat upload.']);
        }
    }



    public function landing_page($slug)
    {
        $mitra = DB::table('products')->where('slug', $slug)->first();

        if (!$mitra) {
            abort(404, 'Mitra tidak ditemukan');
        }

        if (empty($mitra->pdf_path) || !Storage::disk('public')->exists($mitra->pdf_path)) {
            abort(404, 'File PDF belum diunggah untuk produk ini');
        }

        // Buat URL file PDF (akses publik)
        $pdfUrl = asset('storage/' . $mitra->pdf_path);

        if (empty($mitra->pdf_path) || !Storage::disk('public')->exists($mitra->pdf_path)) {
            abort(404, 'File PDF belum tersedia untuk mitra ini.');
        }

        $pdfUrl = asset('storage/' . $mitra->pdf_path);
        $whatsapp = $mitra->whatsapp ?? '6281234567890';

        return view('lp_mitra.viewer', compact('mitra', 'pdfUrl', 'whatsapp'));
    }

    public function halaman_mitra()
    {
        $mitras = DB::table('products')
            ->where('tipe_produk', 'mitra')
            ->where('status', 'aktif')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('mitra', compact('mitras'));
    }
}
