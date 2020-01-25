<?php

namespace App\Http\Controllers;

use App\Infoblock;
use App\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SectionController extends Controller
{
    public function index(Request $request)
    {
        $sections = Section::all();
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
            if ($section->sectionContent->count() !== 0) {
                foreach ($section->sectionContent as $subSection) {
                    if ($subSection->type == 'files') {
                        foreach ($subSection->childrenFiles as $file) {
                            Storage::delete('public/section-files/' . $file->file_name);
                            $file->delete();
                        }
                    }
                    $subSection->delete();
                }
            };

            $section->delete();
            return response()->json(['message' => 'Section was deleted'], 200);
        }
        return response()->json(['message' => 'Oops'], 404);
    }
}
