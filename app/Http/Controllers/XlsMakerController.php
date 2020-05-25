<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\XlsMakerTrait;

class XlsMakerController extends Controller
{
    use XlsMakerTrait;

    public function index(Request $request){
       // $this->createXls();
    }
}
