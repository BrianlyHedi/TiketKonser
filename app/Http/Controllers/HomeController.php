<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use App\Models\Tempat;
use App\Models\Tiket;
use App\Models\User;
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
        $tempat = Tempat::count();
        $pendapatan = Pemesanan::where('status', 'Sudah Terverifikasi')->sum('total');
        $tiket = Tiket::count();
        $user = User::count();
        return view('server.home', compact('tempat', 'pendapatan', 'tiket', 'user'));
    }
}
