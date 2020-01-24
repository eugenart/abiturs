<?php

namespace App\Http\Controllers;

use App\Infoblock;
use App\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function index(Request $request)
    {
        $sections = Section::all();
//        $infoblocks = Infoblock::all();
//
//        foreach ($infoblocks as $infoblock) {
//            $infoblock->sectionsList = $infoblock->sections->where('sectionID', null);
//            foreach ($infoblock->sectionsList->where('isFolder', true) as $folder) {
//                $folder->folder = $folder->childrenSections;
//            }
//        }

        if ($request->ajax()) {
            return response()->json($sections, 200);
        }

        return view('structure.section', compact('sections'));
    }

    public function store(Request $request)
    {
        if ($request->ajax()) {
            $section = Section::create([
                'name' => $request->name,
                'url' => $request->url,
                'description' => $request->description,
                'startPage' => $request->startPage ? 1 : 0,
                'startPagePriority' => $request->startPagePriority,
                'activity' => $request->activity ? 1 : 0,
                'activityFrom' => $request->activityFrom,
                'activityTo' => $request->activityTo,
                'sectionID' => $request->sectionID,
                'infoblockID' => $request->infoblockID,
                'isFolder' => $request->isFolder ? 1 : 0,
            ]);
            return response()->json([
                'message' => "Section was created",
                'section' => $section
            ], 200);
        }

        return response()->json(['message' => 'Oops'], 404);
    }

    public function update(Request $request, $id)
    {
        if ($request->ajax()) {
            Section::findOrFail($id)->update([
                'name' => $request->name,
                'url' => $request->url,
                'description' => $request->description,
                'startPage' => $request->startPage ? 1 : 0,
                'startPagePriority' => $request->startPagePriority,
                'activity' => $request->activity ? 1 : 0,
                'activityFrom' => $request->activityFrom,
                'activityTo' => $request->activityTo,
            ]);
            return response()->json([
                'message' => "Section was updated"
            ], 200);
        }

        return response()->json(['message' => 'Oops'], 404);
    }

    public function destroy(Request $request, $id)
    {
        if ($request->ajax()) {
            $section = Section::findOrFail($id);
            if ($section->childrenSections->count() !== 0) {
                foreach ($section->childrenSections as $subSection) {
                    $subSection->delete();
                }
            };
            $section->delete();
            return response()->json(['message' => 'Section was deleted'], 200);
        }
        return response()->json(['message' => 'Oops'], 404);
    }
}
