<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;

class BonusController extends Controller
{
    // 📄 LIST
    public function index()
    {
        return view('bonus.index');
    }

    // 📦 DATATABLE LOAD
    public function load(Request $request)
    {
        $data = DB::table('bonuses')->latest();

        return datatables()->of($data)
            ->addIndexColumn()
            ->addColumn('icon', fn($row) => $row->icon ? "<i class='{$row->icon}'></i>" : '-')
            ->addColumn('action', function ($row) {
                return '
                    <a href="' . route('bonus.edit', $row->id) . '" class="btn btn-sm btn-warning">Edit</a>
                    <button class="btn btn-sm btn-danger delete-btn" data-id="' . $row->id . '">Hapus</button>
                ';
            })
            ->rawColumns(['icon', 'action'])
            ->make(true);
    }

    // ➕ CREATE
    public function create()
    {
        return view('bonus.create');
    }

    // 💾 STORE
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'file'  => 'required|mimes:pdf'
        ]);

        $path = $request->file('file')->store('bonus');

        DB::table('bonuses')->insert([
            'title'      => $request->title,
            'slug'       => Str::slug($request->title),
            'icon'       => $request->icon,
            'desc'       => $request->desc,
            'file_path'  => $path,
            'created_at' => now(),
        ]);

        return redirect()->route('bonus.index')->with('success', 'Bonus berhasil ditambahkan');
    }

    // ✏️ EDIT
    public function edit($id)
    {
        $bonus = DB::table('bonuses')->find($id);
        return view('bonus.create', compact('bonus'));
    }

    // 🔄 UPDATE
    public function update(Request $request, $id)
    {
        $bonus = DB::table('bonuses')->find($id);

        $data = [
            'title' => $request->title,
            'slug'  => Str::slug($request->title),
            'icon'  => $request->icon,
            'desc'  => $request->desc,
        ];

        if ($request->hasFile('file')) {
            Storage::delete($bonus->file_path);
            $data['file_path'] = $request->file('file')->store('bonus');
        }

        DB::table('bonuses')->where('id', $id)->update($data);

        return redirect()->route('bonus.index')->with('success', 'Bonus diperbarui');
    }

    // 🗑️ DELETE
    public function destroy($id)
    {
        $bonus = DB::table('bonuses')->find($id);

        Storage::delete($bonus->file_path);
        DB::table('bonuses')->where('id', $id)->delete();

        return response()->json(['success' => true]);
    }

    // 👁️ VIEW PDF
    public function view($slug)
    {
        $bonus = DB::table('bonuses')->where('slug', $slug)->first();

        return Response::file(
            storage_path('app/' . $bonus->file_path),
            ['Content-Type' => 'application/pdf']
        );
    }
}
