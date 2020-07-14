<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SessionController extends Controller
{
    public function index(Request $request)
    {
        $data = $request->session()->all();
//       $test = session('locale');
        return $data;
    }
    public function toOvzVer(Request $request)
    {
        $request->session()->put('ovz-style', 'ovz');
        //$data = $request->session()->all();
        //return $data;
        return redirect()->back();
    }

    public function backToMainVer(Request $request)
    {
        $request->session()->put('ovz-style', 'style');
        //$data = $request->session()->all();
        //return $data;
        return redirect()->back();
    }

    public function toEn(Request $request)
    {
        $request->session()->put('locale', 'en');

//        return redirect()->back();
        return redirect('/');
    }

    public function toRu(Request $request)
    {
        $request->session()->put('locale', 'ru');

//        return redirect()->back();
        return redirect('/');
    }

}
