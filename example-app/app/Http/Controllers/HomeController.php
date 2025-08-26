<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

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
        $data = User::where('role', '!=', 'Admin')->get();
        return view('home', ['data' => $data]);
    }

    public function buyer()
    {
        return view('homeofbuyer');
    }

    public function seller()
    {
        return view('homeofseller');
    }
}
