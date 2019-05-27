<?php

namespace App\Http\Controllers;

use App\Infoblock;
use App\Slider;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index() {
        $infoblocks = Infoblock::where('activity', true)->where('startPage', true)->get();
        $slider = Slider::where('activity', true)->get();
        return view('pages.home', compact('infoblocks', 'slider'));
    }
}
