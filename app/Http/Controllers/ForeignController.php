<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ForeignController extends Controller
{
    public function index(Request $request) {
        return view('pages.foreign');
    }
}
