<?php

namespace App\Http\Controllers;

use App\DateUpdate;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupDetailController extends Controller
{
    public function update(Request $request)
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
