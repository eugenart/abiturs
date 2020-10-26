<?php

namespace App\Http\Controllers;

use App\Archive;
use App\ArchiveInfoblock;
use App\Infoblock;
use Illuminate\Http\Request;

class ArchiveController extends Controller
{
    public function index(Request $request) {
        $arc = Archive::all();
        foreach ( $arc as $item) {
            $item->idforblock = 'archive'. $item->id;
            $item->collapsed = 'collapsed'. $item->id;
        }
        return view('pages.archive', ['archives' => $arc]);

    }
    public function index_admin(Request $request) {

        $infoblocks = Infoblock::where('archive', '=', 1)->get();
        foreach ($infoblocks as $i){
            $i->archive_ob = $i->archives()->first();
        }

        if ($request->ajax()) {
            return response()->json($infoblocks, 200);
        }


        return view('structure.archive', compact('infoblocks'));
    }
    public function get_archives(Request $request) {

        $archives = Archive::all();
        foreach ($archives as $a){
            $a->infoblocks = $a->infoblocks()->get();
        }

//        if ($request->ajax()) {
            return response()->json($archives, 200);
//        }


//        return view('structure.archive', compact('$archives'));
    }
}
