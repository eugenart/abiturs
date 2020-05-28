<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\XlsMakerTrait;

class XlsMakerController extends Controller
{
    use XlsMakerTrait;

    public function index(Request $request){
//        $this->queryXlsBach([1], [3], 1, "Списки_Очно_Бюджет_БакалавриатСпециалитет");
//       return view('pages.files');
    }
}
