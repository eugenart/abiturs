<?php

namespace App\Http\Controllers;

use App\Archive;
use App\ArchiveInfoblock;
use App\Infoblock;
use Illuminate\Http\Request;

class ArchiveController extends Controller
{
    public function index(Request $request) {
//        $arc = ArchiveInfoblock::all()->groupBy('id_archive');
//        foreach ($arc as $arci){
//            $arci->name = Archive::where('id', '=',  $arci)->first();
//            foreach ($arci as $item) {
//                $item->infoblock = Infoblock::where('id', '=', $item->id_infoblock)->first();
//            }
//        }
        $arc = Archive::all();
        foreach ( $arc as $item) {
            $item->idforblock = 'archive'. $item->id;
            $item->collapsed = 'collapsed'. $item->id;
        }

        return view('pages.archive', ['archives' => $arc]);

    }
    public function index_admin(Request $request) {
        return view('structure.archive');
    }
}
