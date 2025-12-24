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

class UserController extends Controller
{
    public function index()
    {


        return view('user.index');
    }

    public function load(Request $request)
    {

        try {
            $currentUserId = auth()->id();

            // Mengambil data pengguna dengan role guru atau siswa
            $users = User::where('role', 'user')
                ->select([
                    'id',
                    'name',
                    'no_hp',
                    'email',
                    'kabupaten',
                    'provinsi',
                    'instansi',
                    'is_active',
                    'created_at'
                ])
                ->orderBy('created_at', 'desc');

            return DataTables::of($users)
                ->addIndexColumn()
                ->addColumn('action', function ($row) use ($currentUserId) {

                    $checked = $row->is_active ? 'checked' : '';

                    $toggle = '
        <div class="form-check form-switch d-inline-block me-2">
            <input class="form-check-input toggle-status"
                   type="checkbox"
                   data-id="' . $row->id . '"
                   ' . $checked . '
                   title="Aktif / Nonaktif">
        </div>
    ';

                    $deleteBtn = '';
                    if ($row->id != $currentUserId) {
                        $deleteBtn = '
            <button class="btn btn-sm btn-danger delete-btn"
                title="Hapus"
                data-id="' . $row->id . '">
                <i class="bi bi-trash"></i>
            </button>';
                    }

                    return '<div class="d-flex align-items-center gap-1">'
                        . $toggle . $deleteBtn .
                        '</div>';
                })
                ->rawColumns(['action'])
                ->make(true);
        } catch (\Exception $e) {
            Log::error('Error loading user data: ' . $e->getMessage());
            return response()->json([
                'error' => true,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }


    public function toggleStatus(Request $request)
    {
        $user = User::findOrFail($request->id);
        $user->is_active = $request->is_active;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => $request->is_active ? 'User aktif' : 'User nonaktif'
        ]);
    }


    public function destroy($id)
    {
        try {
            $users = DB::table('users')->where('id', $id)->first();

            if (!$users) {
                return response()->json([
                    'error' => true,
                    'message' => 'users tidak ditemukan'
                ], 404);
            }

            DB::table('users')->where('id', $id)->delete();

            return response()->json([
                'success' => true,
                'message' => 'users berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            Log::error('Error deleting users: ' . $e->getMessage());
            return response()->json([
                'error' => true,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
