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

class MateriController extends Controller
{
    public function index()
    {
        return view('materi.index');
    }

    public function load(Request $request)
    {
        try {
            // Join dengan tabel courses untuk mendapatkan judul kursus
            $kursus = DB::table('materi as m')
                ->join('products as p', 'm.product_id', '=', 'p.id')
                ->select([
                    'm.id',
                    'p.judul',
                    'm.deskripsi',
                    'm.jenis_materi',
                    'm.file_path',
                    'm.created_at',
                    'm.updated_at'
                ])
                ->orderBy('m.created_at', 'desc');

            return DataTables::of($kursus)
                ->addIndexColumn()
                ->filterColumn('judul', function ($query, $keyword) {
                    $query->whereRaw("LOWER(p.judul) like ?", ["%" . strtolower($keyword) . "%"]);
                })
                ->addColumn('action', function ($row) {
                    $deleteUrl = route('materi.destroy', $row->id);

                    // Encrypt ID untuk link edit
                    $encryptedId = Crypt::encrypt($row->id);

                    $buttons = '<div class="btn-group" role="group">';
                    $buttons .= '<a href="' . route('materi.edit', $encryptedId) . '" class="btn btn-sm btn-warning me-1" title="Edit"><i class="bi bi-pencil"></i></a>';
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

    public function create()
    {

        $products = DB::table('products')
            ->select('products.*')
            ->whereIn('tipe_produk', ['ebook', 'kelas_video'])
            ->get();

        return view('materi.create', compact('products'));
    }

    public function edit($id)
    {
        try {
            $decryptedId = Crypt::decrypt($id);
        } catch (\Exception $e) {
            return redirect()->route('materi.index')->with('error', 'ID tidak valid');
        }

        $materi = DB::table('materi')->where('id', $decryptedId)->first();

        if (!$materi) {
            return redirect()->route('materi.index')->with('error', 'Materi tidak ditemukan');
        }

        $products = DB::table('products')
            ->select('products.*')
            ->whereIn('tipe_produk', ['ebook', 'kelas_video'])
            ->get();

        return view('materi.create', compact('products', 'materi'));
    }

    /**
     * Handle chunk upload untuk video
     */
    public function uploadVideoChunk(Request $request)
    {
        try {
            Log::info('Video chunk upload started', [
                'request_files' => array_keys($request->allFiles()),
                'request_data' => $request->except(['_token']),
                'content_type' => $request->header('Content-Type')
            ]);

            // Validasi file
            $request->validate([
                'video_file' => 'required|file|mimes:mp4,avi,mov,wmv,mkv|max:2097152', // 2GB = 2097152 KB
            ]);

            // Periksa apakah ada file yang diupload
            if (!$request->hasFile('video_file')) {
                Log::error('No video file found in request');
                return response()->json([
                    'status' => false,
                    'message' => 'No video file received'
                ], 400);
            }

            // Untuk upload biasa tanpa chunk (FilePond bisa handle file kecil tanpa chunk)
            $file = $request->file('video_file');

            // Generate unique filename
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $fileName = $originalName . '_' . time() . '_' . uniqid() . '.' . $extension;

            // Store file
            $path = $file->storeAs('videos', $fileName, 'public');

            // Verify file was stored
            if (!Storage::disk('public')->exists($path)) {
                throw new \Exception('File was not stored successfully');
            }

            Log::info('Video upload successful', ['path' => $path]);

            // Return success response
            return response()->json([
                'status' => true,
                'message' => 'Video uploaded successfully',
                'path' => $path,
                'url' => Storage::url($path),
                'filename' => $fileName
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Video upload validation error: ' . json_encode($e->errors()));
            return response()->json([
                'status' => false,
                'message' => 'Validation failed: ' . implode(', ', $e->validator->errors()->all())
            ], 422);
        } catch (\Exception $e) {
            Log::error('Video chunk upload error: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Upload failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete uploaded video file (when user removes file from FilePond)
     */
    public function deleteVideoChunk(Request $request)
    {
        try {
            $filePath = trim($request->getContent());

            Log::info('Attempting to delete video file', ['path' => $filePath]);

            if ($filePath && Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
                Log::info('Video file deleted successfully', ['path' => $filePath]);
                return response()->json(['status' => true, 'message' => 'File deleted successfully']);
            }

            Log::warning('File not found for deletion', ['path' => $filePath]);
            return response()->json(['status' => false, 'message' => 'File not found']);
        } catch (\Exception $e) {
            Log::error('Delete video chunk error: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Delete failed: ' . $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'jenis_materi' => 'required|in:pdf,video',
            'deskripsi' => 'nullable|string',
            'pdf_file' => 'nullable|string',
            'video_file' => 'nullable|string',
        ]);

        try {
            // Tentukan path file berdasarkan jenis materi
            $filePath = null;

            if ($request->jenis_materi === 'pdf' && $request->pdf_file) {
                $filePath = $request->pdf_file;
            } elseif ($request->jenis_materi === 'video' && $request->video_file) {
                $filePath = $request->video_file;
            }

            // dd($filePath);
            // Simpan ke tabel materi
            DB::table('materi')->insert([
                'product_id'   => $request->product_id,
                'jenis_materi' => $request->jenis_materi,
                'deskripsi'    => $request->deskripsi,
                'file_path'    => $filePath,
                'created_at'   => now(),
                'updated_at'   => now(),
            ]);

            return redirect()->route('materi.index')->with('success', 'Materi berhasil disimpan!');
        } catch (\Exception $e) {
            \Log::error('Store materi error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'product_id'   => 'required|exists:products,id',
            'jenis_materi' => 'required|in:pdf,video',
            'deskripsi'    => 'nullable|string',
            'pdf_file'     => 'nullable|string',
            'video_file'   => 'nullable|string',
        ]);

        try {
            $materi = DB::table('materi')->where('id', $id)->first();
            if (!$materi) {
                return redirect()->back()->with('error', 'Materi tidak ditemukan');
            }

            // Tentukan file lama untuk dihapus jika diganti
            $oldFilePath = $materi->file_path;
            $newFilePath = null;

            // Tentukan path file baru sesuai jenis_materi
            if ($request->jenis_materi === 'pdf' && $request->pdf_file) {
                $newFilePath = $request->pdf_file;

                // Jika file lama berbeda dan masih ada di storage, hapus
                if ($oldFilePath && $oldFilePath !== $newFilePath && Storage::disk('public')->exists($oldFilePath)) {
                    Storage::disk('public')->delete($oldFilePath);
                }
            } elseif ($request->jenis_materi === 'video' && $request->video_file) {
                $newFilePath = $request->video_file;

                // Jika file lama berbeda dan masih ada di storage, hapus
                if ($oldFilePath && $oldFilePath !== $newFilePath && Storage::disk('public')->exists($oldFilePath)) {
                    Storage::disk('public')->delete($oldFilePath);
                }
            } else {
                // Jika tidak ada file baru, gunakan file lama
                $newFilePath = $oldFilePath;
            }

            // Update data ke tabel materi
            DB::table('materi')->where('id', $id)->update([
                'product_id'   => $request->product_id,
                'jenis_materi' => $request->jenis_materi,
                'deskripsi'    => $request->deskripsi,
                'file_path'    => $newFilePath,
                'updated_at'   => now(),
            ]);

            return redirect()->route('materi.index')->with('success', 'Materi berhasil diperbarui!');
        } catch (\Exception $e) {
            Log::error('Update materi error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }


    public function destroy($id)
    {
        try {
            // Ambil data materi berdasarkan ID
            $materi = DB::table('materi')->where('id', $id)->first();

            if (!$materi) {
                return response()->json([
                    'success' => false,
                    'message' => 'Materi tidak ditemukan'
                ], 404);
            }

            // Hapus file terkait jika ada
            if ($materi->file_path && Storage::disk('public')->exists($materi->file_path)) {
                Storage::disk('public')->delete($materi->file_path);
            }

            // Hapus data materi dari database
            $deleted = DB::table('materi')->where('id', $id)->delete();

            if ($deleted) {
                return response()->json([
                    'success' => true,
                    'message' => 'Materi berhasil dihapus'
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus materi'
            ], 500);
        } catch (\Exception $e) {
            Log::error('Error deleting materi: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }


    public function uploadPdfChunk(Request $request)
    {
        try {
            Log::info('PDF chunk upload started', [
                'request_files' => array_keys($request->allFiles()),
                'request_data' => $request->except(['_token']),
                'content_type' => $request->header('Content-Type')
            ]);

            // Validasi file
            $request->validate([
                'pdf_file' => 'required|file|mimes:pdf|mimetypes:application/pdf|max:102400',
            ]);
            // Periksa apakah ada file yang diupload
            if (!$request->hasFile('pdf_file')) {
                Log::error('No PDF file found in request');
                return response()->json([
                    'status' => false,
                    'message' => 'No PDF file received'
                ], 400);
            }

            // Untuk upload biasa tanpa chunk
            $file = $request->file('pdf_file');

            // Generate unique filename
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $fileName = $originalName . '_' . time() . '_' . uniqid() . '.' . $extension;

            // Store file
            $path = $file->storeAs('pdfs', $fileName, 'public');

            // Verify file was stored
            if (!Storage::disk('public')->exists($path)) {
                throw new \Exception('File was not stored successfully');
            }

            Log::info('PDF upload successful', ['path' => $path]);

            // Return success response
            return response()->json([
                'status' => true,
                'message' => 'PDF uploaded successfully',
                'path' => $path,
                'url' => Storage::url($path),
                'filename' => $fileName
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('PDF upload validation error: ' . json_encode($e->errors()));
            return response()->json([
                'status' => false,
                'message' => 'Validation failed: ' . implode(', ', $e->validator->errors()->all())
            ], 422);
        } catch (\Exception $e) {
            Log::error('PDF chunk upload error: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Upload failed: ' . $e->getMessage()
            ], 500);
        }
    }

    public function deletePdfChunk(Request $request)
    {
        try {
            $filePath = trim($request->getContent());

            Log::info('Attempting to delete PDF file', ['path' => $filePath]);

            if ($filePath && Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
                Log::info('PDF file deleted successfully', ['path' => $filePath]);
                return response()->json(['status' => true, 'message' => 'File deleted successfully']);
            }

            Log::warning('File not found for deletion', ['path' => $filePath]);
            return response()->json(['status' => false, 'message' => 'File not found']);
        } catch (\Exception $e) {
            Log::error('Delete PDF chunk error: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Delete failed: ' . $e->getMessage()
            ], 500);
        }
    }
}
