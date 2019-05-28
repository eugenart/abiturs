<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SectionContentController extends Controller
{
    function index(Request $request)
    {
        return json_decode($request->inputs);
    }
}
