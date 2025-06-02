<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index()
    {
        $data = ['nama' => "puteri", 'foto' => 'avatar2.png'];
        return view('dashboard', compact('data'));
    }
}
