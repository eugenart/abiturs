<?php

namespace App\Http\Controllers;

use App\Infoblock;
use Illuminate\Http\Request;

class InfoblockController extends Controller
{
    public function index(Request $request) {
        $infoblocks = Infoblock::all();

        if ($request->ajax()) {
            return response()->json($infoblocks, 200);
        }

        return view('structure.infoblock', compact('infoblocks'));
    }

    public function store(Request $request) {
        if ($request->ajax()) {
            $infoblock = Infoblock::create([
                'name' => $request->name,
                'url' => $request->url,
                'menu' => $request->menu,
                'menuPriority' => $request->menuPriority,
                'startPage' => $request->startPage,
                'startPagePriority' => $request->startPagePriority,
                'activity' => $request->activity,
                'activityFrom' => $request->activityFrom,
                'activityTo' => $request->activityTo,
            ]);
            return response()->json([
                'message' => "Infoblock was created",
                'infoblock' => $infoblock
            ], 200);
        }

        return response()->json(['message' => 'Oops'], 404);
    }
}
