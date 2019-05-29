<?php

namespace App\Http\Controllers;

use App\SectionsContent;
use Illuminate\Http\Request;

class SectionContentController extends Controller
{
    function index(Request $request)
    {
        $inputs = SectionsContent::all();

        $inputs_send = [];

        foreach ($inputs as $input) {
            if ($input->type == 'text') {
                $inputs_send[] = $input;
            }
            if ($input->type == 'files') {
                if ($input->childrenFiles()->count() > 0) {
                    $files = [];
                    foreach ($input->childrenFiles() as $file) {
                        $files[] = $file;
                    }
                    $input->content = $files;
                }
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
        $data = json_decode($request->inputs);

        foreach ($data as $block) {
            if ($block->type == 'text') {
                SectionsContent::create([
                    'name' => $block->name,
                    'type' => $block->type,
                    'position' => $block->position,
                    'content' => $block->content,
                ]);
            }
            if ($block->type == 'files') {
                $group = SectionsContent::create([
                    'name' => $block->name,
                    'type' => $block->type,
                    'position' => $block->position,
                ]);
                if (count($block->content) > 0) {
                    foreach ($block->content as $file) {
                        if ($request->hasFile($file->vmodel)) {
                            $original = $request[$file->vmodel]->getClientOriginalName();
                            $fileSave = $request[$file->vmodel]->store('public/section-files');
                            $fileName = basename($fileSave);

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
        return $request;
    }
}
