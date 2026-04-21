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

                    $passwordBtn = '
            <button class="btn btn-sm btn-info password-btn"
                title="Ubah Password"
                data-id="' . $row->id . '">
                <i class="bi bi-key"></i>
            </button>';

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
                        . $toggle . $passwordBtn . $deleteBtn .
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


    public function getSubscription($id)
    {
        try {
            $subscription = DB::table('user_subscriptions')
                ->where('user_id', $id)
                ->first();

            $packages = DB::table('products')
                ->where('status', 'aktif')
                ->where('tipe_produk', 'program')
                ->select('id', 'judul')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $subscription,
                'packages' => $packages
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }


    public function toggleStatus(Request $request)
    {
        try {
            DB::beginTransaction();
            $user = User::findOrFail($request->user_id);
            $user->is_active = $request->is_active;
            $user->save();

            $subscription = DB::table('user_subscriptions')
                ->where('user_id', $request->user_id)
                ->first();

            if ($subscription) {
                DB::table('user_subscriptions')
                    ->where('user_id', $request->user_id)
                    ->update([
                        'package_id' => $request->package_id,
                        'started_at' => $request->started_at,
                        'expired_at' => $request->expired_at,
                        'status' => $request->status,
                        'updated_at' => now()
                    ]);
            } else {
                DB::table('user_subscriptions')->insert([
                    'user_id' => $request->user_id,
                    'package_id' => $request->package_id,
                    'started_at' => $request->started_at,
                    'expired_at' => $request->expired_at,
                    'status' => $request->status,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil disimpan'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }


    public function updatePassword(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        try {
            $user = User::findOrFail($request->user_id);
            $user->password = Hash::make($request->password);
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Password berhasil diubah'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
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
