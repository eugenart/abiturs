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
            $infoblock = Infoblock::where('url', $route)->get();
            $section = Section::where('url', $route)->get();
            if (count($infoblock) > 0) {
                if ($infoblock[0]->sections->count() > 0) {
                    return $infoblock[0]->sections->first();
                }
                return $infoblock;
            }

            if (count($section) > 0) {
                return $section[0];
            }

            return 'no';

        }

        $infoblocks = Infoblock::where('activity', true)->where('startPage', true)->get();
        $slider = Slider::where('activity', true)->get();
        return view('pages.home', compact('infoblocks', 'slider'));

    }
}
