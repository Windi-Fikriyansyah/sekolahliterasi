<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\GuruMasterpieceUser;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class GuruMasterpieceUserController extends Controller
{
    public function index()
    {
        return view('guru_masterpiece.index');
    }

    public function load(Request $request)
    {
        try {
            $users = GuruMasterpieceUser::select([
                'id',
                'name',
                'whatsapp',
                'email',
                'package',
                'referral_code',
                'referral_balance',
                'is_active',
                'created_at'
            ])->orderBy('created_at', 'desc');

            return DataTables::of($users)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
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

                    $deleteBtn = '
                        <button class="btn btn-sm btn-danger delete-btn"
                            title="Hapus"
                            data-id="' . $row->id . '">
                            <i class="bi bi-trash"></i>
                        </button>';

                    return '<div class="d-flex align-items-center gap-1">'
                        . $toggle . $passwordBtn . $deleteBtn .
                        '</div>';
                })
                ->rawColumns(['action'])
                ->make(true);
        } catch (\Exception $e) {
            Log::error('Error loading Guru Masterpiece user data: ' . $e->getMessage());
            return response()->json([
                'error' => true,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getSubscription($id)
    {
        try {
            $user = GuruMasterpieceUser::findOrFail($id);

            // Construct a virtual subscription structure compatible with the AJAX form
            $subscription = [
                'user_id' => $user->id,
                'package_id' => $user->package,
                'started_at' => $user->created_at ? $user->created_at->format('Y-m-d') : now()->format('Y-m-d'),
                'expired_at' => null,
                'status' => $user->is_active ? 'active' : 'inactive',
            ];

            // Define the available packages for Guru Masterpiece
            $packages = [
                ['id' => 'free', 'judul' => 'Free'],
                ['id' => 'premium', 'judul' => 'Premium']
            ];

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
            DB::connection('mysql_guru')->beginTransaction();

            $user = GuruMasterpieceUser::findOrFail($request->user_id);
            $user->is_active = $request->is_active;
            $user->package = $request->package_id;
            $user->save();

            DB::connection('mysql_guru')->commit();

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil disimpan'
            ]);
        } catch (\Exception $e) {
            DB::connection('mysql_guru')->rollBack();
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
            $user = GuruMasterpieceUser::findOrFail($request->user_id);
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
            $user = GuruMasterpieceUser::find($id);

            if (!$user) {
                return response()->json([
                    'error' => true,
                    'message' => 'User tidak ditemukan'
                ], 404);
            }

            $user->delete();

            return response()->json([
                'success' => true,
                'message' => 'User berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            Log::error('Error deleting Guru Masterpiece user: ' . $e->getMessage());
            return response()->json([
                'error' => true,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
