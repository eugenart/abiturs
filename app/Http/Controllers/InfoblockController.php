<?php

namespace App\Http\Controllers;

use App\Infoblock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class InfoblockController extends Controller
{
    public function index(Request $request)
    {
        $infoblocks = Infoblock::all();

        if ($request->ajax()) {
            return response()->json($infoblocks, 200);
        }

        return view('structure.infoblock', compact('infoblocks'));
    }

    public function store(Request $request)
    {
        if ($request->ajax()) {
            $fileName = 'default.jpg';
            if ($request->hasFile('image')) {
                $original = $request->image->getClientOriginalName();
                $date = new \DateTime();
                $fileName = $date->format('Ymd_His') . '_' . $original;
                $request->image->storeAs('public/preview', $fileName);
            }
            $infoblock = Infoblock::create([
                'name' => $request->name,
                'url' => $request->url,
                'menu' => $request->menu ? 1 : 0,
                'menuPriority' => $request->menuPriority,
                'startPage' => $request->startPage ? 1 : 0,
                'startPagePriority' => $request->startPagePriority,
                'activity' => $request->activity ? 1 : 0,
                'activityFrom' => $request->activityFrom,
                'activityTo' => $request->activityTo,
                'image' => $fileName ? $fileName : null
            ]);
            return response()->json([
                'message' => "Infoblock was created",
                'infoblock' => $infoblock
            ], 200);
        }

        return response()->json(['message' => 'Oops'], 404);
    }

    public function update(Request $request, $id)
    {
        if ($request->ajax()) {
            $fileName = $request->image? $request->image : 'default.jpg';
            if ($request->hasFile('image')) {
                $original = $request->image->getClientOriginalName();
                $date = new \DateTime();
                $fileName = $date->format('Ymd_His') . '_' . $original;
                $request->image->storeAs('public/preview', $fileName);
            }
            $infoblock = Infoblock::findOrFail($id)->update([
                'name' => $request->name,
                'url' => $request->url,
                'menu' => $request->menu ? 1 : 0,
                'menuPriority' => $request->menuPriority,
                'startPage' => $request->startPage ? 1 : 0,
                'startPagePriority' => $request->startPagePriority,
                'activity' => $request->activity ? 1 : 0,
                'activityFrom' => $request->activityFrom,
                'activityTo' => $request->activityTo,
                'image' => $fileName ? $fileName : null
            ]);
            return response()->json([
                'message' => "Infoblock was updated",
                'infoblock' => $infoblock
            ], 200);
        }

        return response()->json(['message' => 'Oops'], 404);
    }

    public function destroy(Request $request, $id)
    {
        if ($request->ajax()) {
            $infoblock = Infoblock::findOrFail($id);
            if ($infoblock->sections->count() !== 0) {
                foreach ($infoblock->sections as $section) {
                    $section->delete();
                }
            }
            ($infoblock->image != 'default.jpg') ? Storage::delete('public/preview/' . $infoblock->image) : null;
            $infoblock->delete();
            return response()->json(['message' => 'Infoblock was deleted'], 200);
        }
        return response()->json(['message' => 'Oops'], 404);
    }
}
