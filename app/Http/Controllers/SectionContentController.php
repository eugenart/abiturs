<?php

namespace App\Http\Controllers;

use App\SectionsContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SectionContentController extends Controller
{
    function index(Request $request)
    {
        $inputs = SectionsContent::all();

        $inputs_send = [];

        foreach ($inputs as $input) {
            if ($input->type == 'text') {
                $input->isEdit = false;
                $inputs_send[] = $input;
            }
            if ($input->type == 'files') {
                if ($input->childrenFiles->count() > 0) {
                    $files = [];
                    foreach ($input->childrenFiles as $file) {
                        $file->isEdit = false;
                        $files[] = $file;
                    }
                    $input->content = $files;
                }
                $input->isEdit = false;
                $inputs_send[] = $input;

            }
        }

        if ($request->ajax()) {
            return response()->json($inputs_send, 200);
        }

        return view('structure.sectionInfo');
    }

    function store(Request $request)
    {
        if ($request->ajax()) {
            $data = json_decode($request->inputs);

            foreach ($data as $block) {
                if ($block->type == 'text') {
                    if ($block->id) {
                        SectionsContent::find($block->id)->update([
                            'name' => $block->name,
                            'type' => $block->type,
                            'position' => $block->position,
                            'content' => $block->content,
                        ]);
                    } else {
                        SectionsContent::create([
                            'name' => $block->name,
                            'type' => $block->type,
                            'position' => $block->position,
                            'content' => $block->content,
                        ]);
                    }

                }
                if ($block->type == 'files') {
                    if ($block->id) {
                        $group = SectionsContent::find($block->id);
                        $group->update([
                            'name' => $block->name,
                            'type' => $block->type,
                            'position' => $block->position,
                        ]);
                    } else {
                        $group = SectionsContent::create([
                            'name' => $block->name,
                            'type' => $block->type,
                            'position' => $block->position,
                        ]);
                    }

                    if ($block->content && count($block->content) > 0) {
                        foreach ($block->content as $file) {
                            if ($request->hasFile($file->vmodel)) {
                                $original = $request[$file->vmodel]->getClientOriginalName();
                                $fileSave = $request[$file->vmodel]->store('public/section-files');
                                $fileName = basename($fileSave);

                                if ($file->id) {
                                    $blockFile = SectionsContent::find($file->id);
                                    Storage::delete('public/section-files/' . $blockFile->file_name);
                                    $blockFile->update([
                                        'name' => $file->name,
                                        'file_name' => $fileName,
                                        'type' => $file->type,
                                        'vmodel' => $file->vmodel,
                                        'position' => $file->position,
                                        'parent_id' => $group->id,
                                        'content' => $original,
                                    ]);
                                } else {
                                    SectionsContent::create([
                                        'name' => $file->name,
                                        'file_name' => $fileName,
                                        'type' => $file->type,
                                        'vmodel' => $file->vmodel,
                                        'position' => $file->position,
                                        'parent_id' => $group->id,
                                        'content' => $original,
                                    ]);
                                }


                            }
                        }
                    }
                }
            }
            return response()->json(['message' => "OK",], 200);
        }

        return response()->json(['message' => 'Oops'], 404);
    }

    public function destroy(Request $request, $id)
    {
        if ($request->ajax()) {
            $sectionContent = SectionsContent::findOrFail($id);
            if ($sectionContent->childrenFiles->count() > 0) {
                foreach ($sectionContent->childrenFiles as $file) {
                    Storage::delete('public/section-files/' . $file->file_name);
                    $file->delete();
                }
            }
            if ($sectionContent->type == 'file') {
                Storage::delete('public/section-files/' . $sectionContent->file_name);
            }
            $sectionContent->delete();
            return response()->json(['message' => 'Content was deleted'], 200);
        }
        return response()->json(['message' => 'Oops'], 404);
    }
}
