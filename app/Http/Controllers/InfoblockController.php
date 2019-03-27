<?php

namespace App\Http\Controllers;

use App\Infoblock;
use Illuminate\Http\Request;
use function Symfony\Component\Console\Tests\Command\createClosure;

class InfoblockController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return response()->json(Infoblock::all(), 200);
        }

        return view('structure.infoblock');
    }

    public function store(Request $request)
    {
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

    public function destroy(Request $request, $id)
    {
        if ($request->ajax()) {
            Infoblock::destroy($id);
            return response()->json([
                'message' => "Infoblock was deleted",
            ], 200);
        }

        return response()->json(['message' => 'Oops'], 404);
    }
}
