<?php

namespace App\Http\Controllers;

use App\Infoblock;
use App\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function index(Request $request) {
        $infoblocks = Infoblock::all();

        foreach ($infoblocks as $infoblock) {
            $infoblock->sectionsList = $infoblock->sections;
        }

        if ($request->ajax()) {
            return response()->json($infoblocks, 200);
        }

        return view('structure.section', compact('infoblocks'));
    }

    public function store(Request $request) {
        if ($request->ajax()) {
            $section = Section::create([
                'name' => $request->name,
                'url' => $request->url,
                'description' => $request->description,
                'startPage' => $request->startPage? 1 : 0,
                'startPagePriority' => $request->startPagePriority,
                'activity' => $request->activity? 1 : 0,
                'activityFrom' => $request->activityFrom,
                'activityTo' => $request->activityTo,
                'sectionID' => $request->sectionID,
                'infoblockID' => $request->infoblockID,
            ]);
            return response()->json([
                'message' => "Section was created",
                'section' => $section
            ], 200);
        }

        return response()->json(['message' => 'Oops'], 404);
    }

    public function update(Request $request, $id) {
        if ($request->ajax()) {
            Section::findOrFail($id)->update([
                'name' => $request->name,
                'url' => $request->url,
                'description' => $request->description,
                'startPage' => $request->startPage? 1 : 0,
                'startPagePriority' => $request->startPagePriority,
                'activity' => $request->activity? 1 : 0,
                'activityFrom' => $request->activityFrom,
                'activityTo' => $request->activityTo,
                'sectionID' => $request->sectionID,
                'infoblockID' => $request->infoblockID,
            ]);
            return response()->json([
                'message' => "Section was updated"
            ], 200);
        }

        return response()->json(['message' => 'Oops'], 404);
    }

    public function destroy(Request $request, $id) {
        if ($request->ajax()) {
            $section = Section::findOrFail($id);
            $section->childrenSections->count() !==0 ? $section->childrenSections->update(['sectionID', '']) : null;
            $section->delete();
            return response()->json(['message' => 'Section was deleted'], 200);
        }
        return response()->json(['message' => 'Oops'], 404);
    }
}
