<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\DateUpdate;
use Illuminate\Support\Facades\Auth;

class DateUpdateController extends Controller
{
    public function index(Request $request)
    {
        $times = DateUpdate::select('*')->whereIn('name_file', ['stat_bach', 'stat_master', 'stat_asp', 'stat_spo'])->get();

        foreach($times as $time){
            $pieces = explode(" ", $time->date_update);
            $time->date_update = $pieces[0] . 'T' . $pieces[1];
        }

        if ($request->ajax()) {
            return response()->json($times, 200);
        }

        return view('structure.time', compact('times'));
    }

    public function update(Request $request, $id)
    {
        if ($request->ajax()) {

            $times = DateUpdate::findOrFail($id);
            $user = User::where('id', '=', Auth::id())->first();

            $times->update([
                'name_file' => $request->name_file,
                'date_update' => $request->date_update,
                'username' => $user->name
            ]);

            return response()->json([
                'message' => "Times was updated",
                'times' => $times
            ], 200);
        }

        return response()->json(['message' => 'Oops'], 404);
    }
}
