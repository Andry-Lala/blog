<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class InformationController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return view('informations.index', compact('user'));
    }
}
