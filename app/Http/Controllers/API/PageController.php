<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;
use Illuminate\Support\Facades\DB;

class PageController extends Controller
{
    public function loadProjectApi($id)
    {
        $page = DB::table('pages')->where('id', $id)->first();

        if (!$page) {
            return response()->json([
                'success' => false,
                'message' => 'Page not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => json_decode($page->content),
            'html' => $page->html_content, // Kolom baru untuk HTML
            'css' => $page->css_content,   // Kolom baru untuk CSS
            'message' => 'Success load HTML content'
        ]);
    }

    public function storeProjectApi(Request $request, $id)
    {
        // Validasi request
        $request->validate([
            'data' => 'required',
            'html' => 'sometimes',
            'css' => 'sometimes'
        ]);

        // Ambil data dari request
        $data = $request->input('data');
        $html = $request->input('html');
        $css = $request->input('css');

        // Cek apakah page dengan ID tersebut ada
        $page = DB::table('pages')->where('id', $id)->first();

        if (!$page) {
            return response()->json([
                'success' => false,
                'message' => 'Page not found'
            ], 404);
        }

        // Update kolom content, html_content, dan css_content
        DB::table('pages')
            ->where('id', $id)
            ->update([
                'content' => json_encode($data),
                'html_content' => $html, // Kolom baru untuk HTML
                'css_content' => $css,   // Kolom baru untuk CSS
                'updated_at' => now()
            ]);

        return response()->json([
            'success' => true,
            'data' => null,
            'message' => 'Project stored successfully'
        ]);
    }
}
