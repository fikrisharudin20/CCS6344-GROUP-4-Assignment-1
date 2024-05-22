<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if (Auth::user()->role === 'user') {
            return view('userdash');

        } elseif (Auth::user()->role === 'organiser') {
            return view('organiserdash');

        } elseif (Auth::user()->role === 'admin') {
            return view('admindash');

        } else {
            return view('dashboard');
        }
    }
}