<?php

namespace App\Http\Controllers;

use App\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    public function index(Request $request)
    {
        $slider = Slider::all();

        if ($request->ajax()) {
            return response()->json($slider, 200);
        }

        return view('structure.slider', compact('slider'));
    }

    public function store(Request $request)
    {
        if ($request->ajax()) {
            $fileName = 'default.jpg';
            if ($request->hasFile('image')) {
                $original = $request->image->getClientOriginalName();
                $date = new \DateTime();
                $fileName = $date->format('Ymd_His') . '_' . $original;
                $request->image->storeAs('public/slider', $fileName);
            }
            $slider = Slider::create([
                'name' => $request->name,
                'url' => $request->url,
                'priority' => $request->priority,
                'activity' => in_array($request->activity, ['true', 1]) ? 1 : 0,
                'activityFrom' => $request->activityFrom,
                'activityTo' => $request->activityTo,
                'image' => $fileName ? $fileName : null
            ]);
            return response()->json([
                'message' => "Slider was created",
                'slider' => $slider
            ], 200);
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
                $request->image->storeAs('public/slider', $fileName);
            }
            $slider = Slider::findOrFail($id);
            $slider->update([
                'name' => $request->name,
                'url' => $request->url,
                'priority' => $request->priority,
                'activity' => in_array($request->activity, ['true', 1]) ? 1 : 0,
                'activityFrom' => $request->activityFrom,
                'activityTo' => $request->activityTo,
                'image' => $fileName ? $fileName : null
            ]);
            return response()->json([
                'message' => "Slider was updated",
                'slider' => $slider
            ], 200);
        }

        return response()->json(['message' => 'Oops'], 404);
    }

    public function destroy(Request $request, $id)
    {
        if ($request->ajax()) {
            $slider = Slider::findOrFail($id);
            ($slider->image != 'default.jpg') ? Storage::delete('public/slider/' . $slider->image) : null;
            $slider->delete();
            return response()->json(['message' => 'Slider was deleted'], 200);
        }
        return response()->json(['message' => 'Oops'], 404);
    }
}
