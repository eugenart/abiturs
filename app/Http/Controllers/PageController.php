<?php

namespace App\Http\Controllers;

use App\Infoblock;
use App\Section;
use App\Slider;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index(Request $request)
    {
        $infoblocks = Infoblock::where('activity', true)->where('startPage', true)->orderBy('startPagePriority', 'desc')->where('foreigner', '=', 0)->get();
        $infoblocks_int = Infoblock::where('activity', true)->where('startPage', true)->orderBy('startPagePriority', 'desc')->where('foreigner', '=', 1)->get();
        $slider = Slider::where('activity', true)->orderBy('priority', 'desc')->get();
        $date_now = Carbon::today();
        $date_now = $date_now->toDateString();

//        return view('pages.home', compact('infoblocks', 'slider'));
        return view('pages.home', ['infoblocks' => $infoblocks, 'infoblocks_int' => $infoblocks_int, 'slider' => $slider, 'date_now' => $date_now]);

    }

    public function route($route)
    {
        if ($route) {
            $infoblock = Infoblock::where('url', $route)->first();
            $section = Section::where('real_link', $route)->where('activity', true)->first();
            $date_now = Carbon::today();
            $date_now = $date_now->toDateString();
            if ($section || $infoblock) {
                if ($infoblock) {
                    if ((($date_now > $infoblock->activityFrom || $date_now == $infoblock->activityFrom) &&
                            ($date_now < $infoblock->activityTo || $date_now == $infoblock->activityTo))
                        || (is_null($infoblock->activityFrom) && is_null($infoblock->activityTo))) {
                        if ($infoblock->sections->count() > 0) {
                            $all_sections = Section::where('infoblockID', '=', $infoblock->id)->where('activity', true)->orderBy('startPagePriority', 'desc')->get();
                            $section = $all_sections->first();
                            if ($section) {
                                $menuSections = Section::where('infoblockID', '=', $infoblock->id)->where('activity', true)->orderBy('startPagePriority', 'desc')->get();
                                if ((($date_now > $section->activityFrom || $date_now == $section->activityFrom) &&
                                        ($date_now < $section->activityTo || $date_now == $section->activityTo))
                                    || (is_null($section->activityFrom) && is_null($section->activityTo))) {
                                    return view('pages.priem', ['block' => $section, 'date_now' => $date_now, 'menuSections' => $menuSections]);
                                }
                            }
                        }
                    }
                }

                if ($section) {
                    $menuSections = Section::where('infoblockID', '=', $section->infoblockID)->where('activity', true)->orderBy('startPagePriority', 'desc')->get();
                    if ((($date_now > $section->activityFrom || $date_now == $section->activityFrom) &&
                            ($date_now < $section->activityTo || $date_now == $section->activityTo))
                        || (is_null($section->activityFrom) && is_null($section->activityTo))) {
//                        return view('pages.priem')->with('block', $section);
                        return view('pages.priem', ['block' => $section, 'date_now' => $date_now, 'menuSections' => $menuSections]);
                    }
                }

                $infoblocks = Infoblock::where('activity', true)->where('startPage', true)->orderBy('startPagePriority', 'desc')->where('foreigner', '=', 0)->get();
                $infoblocks_int = Infoblock::where('activity', true)->where('startPage', true)->orderBy('startPagePriority', 'desc')->where('foreigner', '=', 1)->get();
                $slider = Slider::where('activity', true)->orderBy('priority', 'desc')->get();
                $date_now = Carbon::today();
                $date_now = $date_now->toDateString();
//                return view('pages.home', compact('infoblocks', 'slider'));
                return view('pages.home', ['infoblocks' => $infoblocks, 'infoblocks_int' => $infoblocks_int, 'slider' => $slider, 'date_now' => $date_now]);
            } else {
                abort(404);
            }

        } else {
            abort(404);
        }

//        $infoblocks = Infoblock::where('activity', true)->where('startPage', true)->get();
//        $slider = Slider::where('activity', true)->get();
//        return view('pages.home', compact('infoblocks', 'slider'));

    }
}
