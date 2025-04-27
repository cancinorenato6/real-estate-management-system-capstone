<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminModuleController extends Controller
{
    public function adminDashboard(){
        $admin = Auth::guard('admin')->user();
        return view('admin.adminDashboard', ['admin' => $admin]);
    }
    public function adminAgents(){
        $admin = Auth::guard('admin')->user();
        return view('admin.adminAgents', ['admin' => $admin]);
    }
}
