<?php

namespace App\Http\Controllers;

use App\Infoblock;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index() {
        $infoblocks = Infoblock::where('activity', true)->where('startPage', true)->get();
        return view('pages.home', compact('infoblocks'));
    }
}
