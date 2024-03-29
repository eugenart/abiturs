<?php

namespace App\Http\Controllers;

use App\Infoblock;
use App\Section;
use App\SectionsContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class InfoblockController extends Controller
{
    //Для добавления нового поля в админку и бд,
    // 1. миграция
    //2. модель филбл
    //3. resources\js\components\Infoblock.vue
    //4.resources\store\block.js
    //5. npm run production
    // 6. котроллер
    public function index(Request $request)
    {
//        $infoblocks = Infoblock::where('archive', '=', 0)->get();
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
            $check = Infoblock::where('name', '=', $request->name)->first();

            if (!isset($check)) {
                $infoblock = Infoblock::create([
                    'name' => $request->name,
                    'url' => $request->url,
                    'menu' => in_array($request->menu, ['true', 1]) ? 1 : 0,
                    'menuPriority' => $request->menuPriority,
                    'startPage' => in_array($request->startPage, ['true', 1]) ? 1 : 0,
                    'startPagePriority' => $request->startPagePriority,
                    'activity' => in_array($request->activity, ['true', 1]) ? 1 : 0,
                    'activityFrom' => $request->activityFrom,
                    'activityTo' => $request->activityTo,
                    'image' => $fileName ? $fileName : null,
                    'news' => $request->news ? $request->news : array(),
                    'foreigner' => in_array($request->foreigner, ['true', 1]) ? 1 : 0,
                    'archive' => 0,
                ]);
                return response()->json([
                    'message' => "Infoblock was created",
                    'infoblock' => $infoblock
                ], 200);
            }
        }

        return response()->json(['message' => 'Oops'], 404);
    }

    public function update(Request $request, $id)
    {
        if ($request->ajax()) {
            $fileName = $request->image ? $request->image : 'default.jpg';
            if ($request->hasFile('image')) {
                $original = $request->image->getClientOriginalName();
                $date = new \DateTime();
                $fileName = $date->format('Ymd_His') . '_' . $original;
                $request->image->storeAs('public/preview', $fileName);
            }
            $infoblock = Infoblock::findOrFail($id);
            $check = Infoblock::where('name', '=', $request->name)->where('id', '<>', $id)->first();
            if (!isset($check)) {
                $old_url = $infoblock->url;
                $infoblock->update([
                    'name' => $request->name, //
                    'url' => $request->url,
                    'menu' => in_array($request->menu, ['true', 1]) ? 1 : 0,
                    'menuPriority' => $request->menuPriority,
                    'startPage' => in_array($request->startPage, ['true', 1]) ? 1 : 0,
                    'startPagePriority' => $request->startPagePriority,
                    'activity' => in_array($request->activity, ['true', 1]) ? 1 : 0,
                    'activityFrom' => $request->activityFrom,
                    'activityTo' => $request->activityTo,
                    'image' => $fileName ? $fileName : null,
                    'news' => $request->news ? $request->news : array(),
                    'foreigner' => in_array($request->foreigner, ['true', 1]) ? 1 : 0,
                    'archive' => in_array($request->archive, ['true', 1]) ? 1 : 0,
                ]);

                if ($old_url != $infoblock->url) {
                    $sections = Section::where('infoblockID', '=', $id)->get();
                    foreach ($sections as $section) {
                        $new_link = $infoblock->url . '-' . $section->url;
                        $section->update([
                            'real_link' => $new_link
                        ]);
                    }
                }


                return response()->json([
                    'message' => "Infoblock was updated",
                    'infoblock' => $infoblock
                ], 200);
            }
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
                    if ($section->sectionContent->count() !== 0) {
                        foreach ($section->sectionContent as $subSection) {
                            if ($subSection->type == 'files') {
                                foreach ($subSection->childrenFiles as $file) {
//                                    Storage::delete('public/section-files/' . $file->file_name);
                                    $file->delete();
                                }
                            }
                            $subSection->delete();
                        }
                    };
                    $section->delete();
                }
            }
//            ($infoblock->image != 'default.jpg') ? Storage::delete('public/preview/' . $infoblock->image) : null;
            $infoblock->delete();
            return response()->json(['message' => 'Infoblock was deleted'], 200);
        }
        return response()->json(['message' => 'Oops'], 404);
    }

    public function copy(Request $request, $copy_id)
    {

        $infoblock_orig = Infoblock::findOrFail($copy_id);
        $rand = substr(strval(base_convert((mt_rand() / mt_getrandmax()), 10, 36)), 0, 3) . substr(strval(base_convert((mt_rand() / mt_getrandmax()), 10, 36)), 0, 3);

        $new_name = $infoblock_orig->name . '_copy_' . $rand;
        $new_url = $infoblock_orig->url . '_copy_' . $rand;

        $original_img_name = $infoblock_orig->image;
        $date = new \DateTime();
        $fileName = $date->format('Ymd_His') . '_' .substr(strval(base_convert((mt_rand() / mt_getrandmax()), 10, 36)), 0, 3) . substr(strval(base_convert((mt_rand() / mt_getrandmax()), 10, 36)), 0, 3).substr($original_img_name, -10);
        $path_or_img = $_SERVER['DOCUMENT_ROOT'] .'/storage/preview/' . $infoblock_orig->image;
        $path_new_img = $_SERVER['DOCUMENT_ROOT'] .'/storage/preview/' . $fileName;
        copy($path_or_img, $path_new_img);

        $new_infoblock = Infoblock::create([
            'name' => $new_name,
            'url' => $new_url,
            'menu' => $infoblock_orig->menu,
            'menuPriority' => $infoblock_orig->menuPriority,
            'startPage' => $infoblock_orig->startPage,
            'startPagePriority' => $infoblock_orig->startPagePriority,
            'activity' => 0,
            'activityFrom' => $infoblock_orig->activityFrom,
            'activityTo' => $infoblock_orig->activityTo,
            'image' => $fileName,
            'news' => $infoblock_orig->news,
            'foreigner' => $infoblock_orig->foreigner,
            'archive' => 0,
        ]);

        if ($infoblock_orig->sections->count() !== 0) {
            foreach ($infoblock_orig->sections as $section_orig) {
                $realLink = $new_url . '-' . $section_orig->url;
                $new_section = Section::create([
                    'name' => $section_orig->name,
                    'url' => $section_orig->url,
                    'description' => $section_orig->description,
                    'startPage' => $section_orig->startPage ? 1 : 0,
                    'startPagePriority' => $section_orig->startPagePriority,
                    'activity' => $section_orig->activity ? 1 : 0,
                    'activityFrom' => $section_orig->activityFrom,
                    'activityTo' => $section_orig->activityTo,
                    'sectionID' => $section_orig->sectionID,
                    'infoblockID' => $new_infoblock->id,
                    'isFolder' => $section_orig->isFolder ? 1 : 0,
                    'real_link' => $realLink
                ]);
                if ($section_orig->sectionContent->count() !== 0) {
//                    $group = null;
                    $groups_id = array();
                    foreach ($section_orig->sectionContent as $content_orig) {
                        if ($content_orig->type == 'files') { //контент группа
                            //создали новую группу
                            $new_group = SectionsContent::create([
                                'section_id' => $new_section->id,
                                'name' => $content_orig->name,
                                'type' => $content_orig->type,
                                'position' => $content_orig->position,
                            ]);
//                           $groups_id[$content_orig->id] = $new_group->id; //связали id
                            $sub_files = SectionsContent::where('parent_id', '=', $content_orig->id)->get();
                            if (isset($sub_files)) {
                                foreach ($sub_files as $file_orig) {

                                    $new_file_name = null;
                                    if(!is_null($file_orig->file_name)) {
                                        if(file_exists($_SERVER['DOCUMENT_ROOT'] . '/storage/section-files/' . $file_orig->file_name)) {
                                            $original_file_name = $file_orig->file_name;
                                            $date = new \DateTime();
                                            $new_file_name = $date->format('Ymd_His') . '_' . substr(strval(base_convert((mt_rand() / mt_getrandmax()), 10, 36)), 0, 3) . substr(strval(base_convert((mt_rand() / mt_getrandmax()), 10, 36)), 0, 3) . substr($original_file_name, -10);
                                            $path_or_img = $_SERVER['DOCUMENT_ROOT'] . '/storage/section-files/' . $file_orig->file_name;
                                            $path_new_img = $_SERVER['DOCUMENT_ROOT'] . '/storage/section-files/' . $new_file_name;
                                            copy($path_or_img, $path_new_img);
                                        }
                                    }

                                    SectionsContent::create([
                                        'name' => $file_orig->name,
//                                        'file_name' => $file_orig->file_name,
                                        'file_name' => $new_file_name,
                                        'position' => $file_orig->position,
                                        'content' => $file_orig->content,
                                        'type' => $file_orig->type,
                                        'vmodel' => $file_orig->vmodel,
                                        'parent_id' => $new_group->id,
                                        'ext_file' => $file_orig->ext_file
                                    ]);
                                }
                            }
                        } else {
                            $new_file_name = null;
                            if(!is_null($content_orig->fileName)) {
                                if(file_exists($_SERVER['DOCUMENT_ROOT'] . '/storage/section-files/' . $content_orig->fileName)) {
                                    $original_file_name = $content_orig->fileName;
                                    $date = new \DateTime();
                                    $new_file_name = $date->format('Ymd_His') . '_' . substr(strval(base_convert((mt_rand() / mt_getrandmax()), 10, 36)), 0, 3) . substr(strval(base_convert((mt_rand() / mt_getrandmax()), 10, 36)), 0, 3) . substr($original_file_name, -10);
                                    $path_or_img = $_SERVER['DOCUMENT_ROOT'] . '/storage/section-files/' . $original_file_name;
                                    $path_new_img = $_SERVER['DOCUMENT_ROOT'] . '/storage/section-files/' . $new_file_name;
                                    copy($path_or_img, $path_new_img);
                                }
                            }
                            SectionsContent::create([
                                'name' => $content_orig->name,
//                                'file_name' => $content_orig->fileName,
                                'file_name' => $new_file_name,
                                'position' => $content_orig->position,
                                'content' => $content_orig->content,
                                'type' => $content_orig->type,
                                'vmodel' => $content_orig->vmodel,
                                'section_id' => $new_section->id,
                                'ext_file' => $content_orig->ext_file
                            ]);
                        }

                    }
                }
            }
        }

        return response()->json(['message' => "Infoblock was created",
            'infoblock' => $new_infoblock], 200);

    }
}
