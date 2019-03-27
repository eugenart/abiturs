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
                'menu' => $request->menu? 1 : 0,
                'menuPriority' => $request->menuPriority,
                'startPage' => $request->startPage? 1 : 0,
                'startPagePriority' => $request->startPagePriority,
                'activity' => $request->activity? 1 : 0,
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

    public function destroy(Request $request, $id) {
        if ($request->ajax()) {
            Infoblock::destroy($id);
            return response()->json(['message' => 'Infoblock was deleted'], 200);
        }
        return response()->json(['message' => 'Oops'], 404);
    }
}
