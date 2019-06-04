<?php

namespace App\Http\Controllers;

use App\Infoblock;
use App\Section;
use App\Slider;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index(Request $request) {
        $infoblocks = Infoblock::where('activity', true)->where('startPage', true)->get();
        $slider = Slider::where('activity', true)->get();
        return view('pages.home', compact('infoblocks', 'slider'));

    }

    public function route($route) {
        if ($route) {
            $infoblock = Infoblock::where('url', $route)->first();
            $section = Section::where('url', $route)->first();
            if ($infoblock) {
                if ($infoblock->sections->count() > 0) {
                    $section = $infoblock->sections->first();
                    return view('pages.priem')->with('block', $section);
                }
            }

            if ($section) {
                return view('pages.priem')->with('block', $section);
            }

            $infoblocks = Infoblock::where('activity', true)->where('startPage', true)->get();
            $slider = Slider::where('activity', true)->get();
            return view('pages.home', compact('infoblocks', 'slider'));

        }

        $infoblocks = Infoblock::where('activity', true)->where('startPage', true)->get();
        $slider = Slider::where('activity', true)->get();
        return view('pages.home', compact('infoblocks', 'slider'));

    }
}
