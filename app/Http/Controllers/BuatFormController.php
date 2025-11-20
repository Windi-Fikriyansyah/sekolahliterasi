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

class BuatFormController extends Controller
{
    public function index()
    {
        return view('buat_form.index');
    }

    public function load(Request $request)
    {
        try {
            $forms = DB::table('forms')
                ->select(['id', 'title', 'created_at'])
                ->orderBy('created_at', 'desc');

            return DataTables::of($forms)
                ->addIndexColumn()
                ->addColumn('title', function ($row) {
                    return $row->title;
                })
                ->addColumn('action', function ($row) {
                    $edit = route('buat_form.edit', $row->id);
                    $delete = route('buat_form.destroy', $row->id);

                    return '
                <div class="btn-group" role="group">


                    <a href="' . $edit . '" class="btn btn-sm btn-warning">
                        <i class="bi bi-pencil-square"></i> Edit
                    </a>

                    <button class="btn btn-sm btn-danger delete-btn" data-id="' . $row->id . '">
                        <i class="bi bi-trash"></i> Hapus
                    </button>
                </div>';
                })
                ->rawColumns(['action'])
                ->make(true);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function create()
    {
        return view('buat_form.create');
    }

    public function store(Request $request)
    {

        // Validasi minimal
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable',
            'fields' => 'required|array',
        ]);

        DB::beginTransaction();

        try {

            // 1. Simpan HEADER FORM
            $formId = DB::table('forms')->insertGetId([
                'title' => $request->title,
                'description' => $request->description,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // 2. Simpan FIELD
            foreach ($request->fields as $f) {

                DB::table('form_fields')->insert([
                    'form_id'     => $formId,
                    'label'       => $f['label'],
                    'type'        => $f['type'],
                    'is_required' => $f['is_required'] ?? 0,
                    'order'       => $f['order'] ?? 1,
                    'options'     => ($f['options'] ?? null)
                        ? json_encode(explode(',', $f['options']))
                        : null,
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ]);
            }

            DB::commit();

            return redirect()->route('buat_form.index')
                ->with('success', 'Formulir berhasil disimpan!');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Gagal menyimpan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit($id)
    {
        $formulir = DB::table('forms')->where('id', $id)->first();

        $formFields = DB::table('form_fields')
            ->where('form_id', $id)
            ->get();

        return view('buat_form.create', compact('formulir', 'formFields'));
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable',
            'fields' => 'required|array',
        ]);

        DB::beginTransaction();

        try {
            // 1. Update HEADER
            DB::table('forms')->where('id', $id)->update([
                'title' => $request->title,
                'description' => $request->description,
                'updated_at' => now(),
            ]);

            // 2. Hapus field lama
            DB::table('form_fields')->where('form_id', $id)->delete();

            // 3. Simpan field baru
            foreach ($request->fields as $f) {
                DB::table('form_fields')->insert([
                    'form_id'     => $id,
                    'label'       => $f['label'],
                    'type'        => $f['type'],
                    'is_required' => $f['is_required'] ?? 0,
                    'order'       => $f['order'] ?? 1,
                    'options'     => ($f['options'] ?? null)
                        ? json_encode(explode(',', $f['options']))
                        : null,
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ]);
            }

            DB::commit();

            return redirect()->route('buat_form.index')
                ->with('success', 'Formulir berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Gagal update: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {

            // Hapus semua fields
            DB::table('form_fields')->where('form_id', $id)->delete();

            // Hapus form utama
            DB::table('forms')->where('id', $id)->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Formulir berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus: ' . $e->getMessage()
            ], 500);
        }
    }
}
