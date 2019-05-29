<?php

namespace App\Http\Controllers;

use App\SectionsContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SectionContentController extends Controller
{
    function index(Request $request)
    {
        return $request;
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



//                        $original = $file->content->getClientOriginalName();
//                        $date = new \DateTime();
//                        $fileName = $date->format('Ymd_His') . '_' . $original;
//                        $file->content->storeAs('public/section-files', $fileName);

                        SectionsContent::create([
                            'name' => $file->name,
                            'type' => $file->type,
                            'position' => $file->position,
                            'parent_id' => $group->id,
                            'content' => 'file',
                        ]);
                    }
                }
            }
        }

    }
}
