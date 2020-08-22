<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (User::is_Admin()) return redirect()->route('admin');
        if (User::is_Agent()) return redirect()->route('agent');
        if (User::is_SuperAdmin()) return redirect()->route('admin');
        return redirect()->route('login');
    }
}
