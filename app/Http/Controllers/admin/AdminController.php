<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AdminController extends Controller
{
  public function home(): RedirectResponse
  {
    return redirect()->route('admin.dashboard');
  }

  public function index(Request $req){
    return view('admin.dashboard');
  }
}
