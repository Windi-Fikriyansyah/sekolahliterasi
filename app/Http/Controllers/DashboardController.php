<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function dashboardOwner(Request $request)
    {
        return view('dashboardOwner');
    }
    public function dashboardUser(Request $request)
    {
        return view('dashboardUser');
    }
}
