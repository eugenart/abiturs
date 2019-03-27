<?php

namespace App\Http\Controllers;

use App\Infoblock;
use Illuminate\Http\Request;
use function Symfony\Component\Console\Tests\Command\createClosure;

class InfoblockController extends Controller
{
    public function index(Request $request) {
        if ($request->ajax()) {
            return response()->json(Infoblock::all(), 200);
        }

        return response()->json(['message' => 'success'], 200);
    }

    public function store(Request $request) {
        if ($request->ajax()) {
            $infoblock = Infoblock::create([
                'name' => $request->name,
                'url' => $request->url,
                'menu' => $request->menu,
                'menu_priority' => $request->menu_priority,
                'start_page' => $request->start_page,
                'start_page_priority' => $request->start_page_priority,
            ]);
            return response()->json([
                'message' => "Infoblock was created",
                'infoblock' => $infoblock
            ], 200);
        }

        return response()->json(['message' => 'Oops'], 404);
    }
}
