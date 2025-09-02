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

class KursusController extends Controller
{
    public function index()
    {
        return view('kursus.index');
    }

    public function load(Request $request)
    {
        try {
            $kursus = DB::table('courses')
                ->select([
                    'id',
                    'title',
                    'description',
                    'thumbnail',
                    'price',
                    'is_free',
                    'status',
                    'created_at',
                    'updated_at'
                ])
                ->orderBy('created_at', 'desc');

            return DataTables::of($kursus)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $encryptedId = Crypt::encrypt($row->id);
                    $deleteUrl = route('kursus.destroy', $row->id);

                    $buttons = '<div class="btn-group" role="group">';
                    $buttons .= '<a href="' . route('kursus.edit', $row->id) . '" class="btn btn-sm btn-warning me-1" title="Edit"><i class="bi bi-pencil"></i></a>';
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
            // Hapus data kursus langsung dari database
            $deleted = DB::table('courses')->where('id', $id)->delete();

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
        return view('kursus.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'price' => 'required|numeric|min:0',
            'is_free' => 'required|boolean',
            'status' => 'required|in:active,inactive'
        ]);

        try {
            // Format price
            $price = str_replace(['Rp', '.', ' '], '', $request->price);
            $price = (float) $price;

            // Handle thumbnail upload
            $thumbnailPath = null;
            if ($request->hasFile('thumbnail')) {
                $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
            }

            // Insert course using Query Builder
            DB::table('courses')->insert([
                'title' => $request->title,
                'description' => $request->description,
                'thumbnail' => $thumbnailPath,
                'price' => $price,
                'is_free' => $request->is_free,
                'status' => $request->status,
                'created_by' => auth()->id(),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            return redirect()->route('kursus.index')
                ->with('success', 'Kursus berhasil dibuat');
        } catch (\Exception $e) {
            Log::error('Error creating course: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $course = DB::table('courses')->where('id', $id)->first();
        return view('kursus.create', compact('course'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'price' => 'required|numeric|min:0',
            'is_free' => 'required|boolean',
            'status' => 'required|in:active,inactive'
        ]);

        try {
            $course = DB::table('courses')->where('id', $id)->first();

            if (!$course) {
                return back()->with('error', 'Kursus tidak ditemukan');
            }

            // Format price
            $price = str_replace(['Rp', '.', ' '], '', $request->price);
            $price = (float) $price;

            $dataUpdate = [
                'title' => $request->title,
                'description' => $request->description,
                'price' => $price,
                'is_free' => $request->is_free,
                'status' => $request->status,
                'updated_at' => now()
            ];

            // Handle thumbnail upload
            if ($request->hasFile('thumbnail')) {
                // Delete old thumbnail
                if ($course->thumbnail && Storage::disk('public')->exists($course->thumbnail)) {
                    Storage::disk('public')->delete($course->thumbnail);
                }

                $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
                $dataUpdate['thumbnail'] = $thumbnailPath;
            }

            // Update course using Query Builder
            DB::table('courses')->where('id', $id)->update($dataUpdate);

            return redirect()->route('kursus.index')
                ->with('success', 'Kursus berhasil diperbarui');
        } catch (\Exception $e) {
            Log::error('Error updating course: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
