<?php

namespace App\Http\Controllers;

use App\Section;
use App\SectionsContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SectionContentController extends Controller
{
    public function index(Request $request, $id)
    {


        $section = Section::find($id);
        if ($section) {
            $link = $section->url;
        } else {
            $link = "";
        }

        if ($request->ajax()) {

            $inputs = SectionsContent::where('section_id', $id)->get();

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

            return response()->json($inputs_send, 200);
        }

        return view('structure.sectionInfo')->with('id', $id)->with('link', $link);
    }

    public function store(Request $request)
    {
        if ($request->ajax()) {

            if (isset($request->updown)) {
                if ($request->updown == 'up') {
                    $section = SectionsContent::find($request->parent_id);
                    if ($request->child_id) {
                        $file = $section->childrenFiles->find($request->child_id);
                        $file2 = $section->childrenFiles->where('position', $file->position + 1)->first();
                        $file2->update(['position' => $file->position]);
                        $file->update(['position' => $file->position + 1]);

                    } else {
                        $section2 = SectionsContent::where('position', $section->position + 1)->where('parent_id', null)->first();
                        $section2->update(['position' => $section->position]);
                        $section->update(['position' => $section->position + 1]);
                    }

                }
                if ($request->updown == 'down') {
                    $section = SectionsContent::find($request->parent_id);
                    if ($request->child_id) {
                        $file = $section->childrenFiles->find($request->child_id);
                        $file2 = $section->childrenFiles->where('position', $file->position - 1)->first();
                        $file2->update(['position' => $file->position]);
                        $file->update(['position' => $file->position - 1]);
                    } else {
                        $section2 = SectionsContent::where('position', $section->position - 1)->where('parent_id', null)->first();
                        $section2->update(['position' => $section->position]);
                        $section->update(['position' => $section->position - 1]);
                    }

                }
                return response()->json(['message' => "OK_up",], 200);
            }

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
                            'section_id' => $block->section_id,
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
                            'section_id' => $block->section_id,
                            'name' => $block->name,
                            'type' => $block->type,
                            'position' => $block->position,
                        ]);
                    }

                    if ($block->content && count($block->content) > 0) {
                        foreach ($block->content as $file) {
                            if ($request->hasFile($file->vmodel)) {
                                $original = $request[$file->vmodel]->getClientOriginalName();
                                $extension = $request[$file->vmodel]->getClientOriginalExtension();
                                $fileSave = $request[$file->vmodel]->store('public/section-files');
                                $fileName = basename($fileSave);
                                if ($file->id) {
                                    $blockFile = SectionsContent::find($file->id); //находим файл в базе
                                    Storage::delete('public/section-files/' . $blockFile->file_name); //удаялем
                                    $blockFile->update([  //обеовляем
                                        'name' => $file->name,
                                        'file_name' => $fileName,
                                        'content' => $original,
                                        'ext_file' => strval($extension)
                                    ]);
                                } else {
                                    SectionsContent::create([//или создаем если не находим
                                        'name' => $file->name,
                                        'file_name' => $fileName,
                                        'type' => $file->type,
                                        'vmodel' => $file->vmodel,
                                        'position' => $file->position,
                                        'parent_id' => $group->id,
                                        'content' => $original,
                                        'ext_file' => strval($extension)
                                    ]);
                                }


                            } else {
                                if ($file->id) {
                                    $blockFile = SectionsContent::find($file->id);
                                    $blockFile->update([
                                        'name' => $file->name,
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

            $sectionContent->delete();

            return response()->json(['message' => 'Content was deleted'], 200);
        }
        return response()->json(['message' => 'Oops'], 404);
    }
}
