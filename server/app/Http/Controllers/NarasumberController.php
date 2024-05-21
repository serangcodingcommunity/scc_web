<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Narasumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class NarasumberController extends Controller
{
    public function index()
    {
        $narasumber = Narasumber::all();

        return response()->json([
            "data" => $narasumber
        ], 200);
    }

    public function store(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            "name" => 'required',
            "image" => 'file|mimes:jpg,jpeg,png,webp|max:512'
        ]);

        if ($validatedData->fails()) {
            return response()->json([
                "message" => "Validation error",
                "errors" => $validatedData->errors()
            ], 422);
        }

        $timestamp = now()->timestamp;

        $image =  strtolower(str_replace(' ', '', $request->name)) . $timestamp . '.' . $request->file('image')->getClientOriginalExtension();
        $filePath = 'images/narasumber/' . $image;
        Storage::disk('public')->put($filePath, file_get_contents($request->file('image')));

        $narasumber = Narasumber::create([
            'name' => $request->name,
            'keterangan' => $request->keterangan,
            'image' => $image
        ]);

        return response()->json([
            "message" => "Narasumber created successfully",
            "data" => $narasumber
        ], 201);
    }

    public function show(Request $request, Narasumber $narasumber)
    {
        $narasumber = Narasumber::find($request->id);
        if (!$narasumber) {
            return response()->json([
                "error" => "Narasumber not found"
            ], 404);
        }

        return response()->json([
            "data" => $narasumber
        ], 200);
    }

    public function update(Request $request, Narasumber $narasumber)
    {
        $narasumber = Narasumber::find($request->id);
        if (!$narasumber) {
            return response()->json([
                "error" => "Narasumber not found"
            ], 404);
        }

        $validatedData = Validator::make($request->all(), [
            "name" => 'required',
            "image" => 'file|mimes:jpg,jpeg,png,webp|max:512'
        ]);

        if ($validatedData->fails()) {
            return response()->json([
                "message" => "Validation error",
                "errors" => $validatedData->errors()
            ], 422);
        }

        if ($request->hasFile('image')) {
            if ($narasumber->image) {
                $oldImagePath = 'images/narasumber/' . $narasumber->image;
                Storage::disk('public')->delete($oldImagePath);
            }

            $timestamp = now()->timestamp;
            $image = strtolower(str_replace(' ', '', $request->name)) . $timestamp . '.' . $request->file('image')->getClientOriginalExtension();
            $filePath = 'images/narasumber/' . $image;
            Storage::disk('public')->put($filePath, file_get_contents($request->file('image')));
        } else {
            $image = $narasumber->image;
        }

        Narasumber::where('id', $request->id)->update([
            'name' => $request->name,
            'keterangan' => $request->keterangan,
            'image' => $image
        ]);

        $narasumber = Narasumber::find($request->id);

        return response()->json([
            "message" => "Narasumber updated successfully",
            "data" => $narasumber
        ], 201);
    }

    public function destroy(Request $request, Narasumber $narasumber)
    {
        $narasumber = Narasumber::find($request->id);
        if (!$narasumber) {
            return response()->json([
                "error" => "Narasumber not found"
            ], 404);
        }

        $relatedEventsCount = Event::where(function ($query) use ($narasumber) {
            $query->where('nid_1', $narasumber->id)
                ->orWhere('nid_2', $narasumber->id)
                ->orWhere('nid_3', $narasumber->id)
                ->orWhere('nid_4', $narasumber->id)
                ->orWhere('nid_5', $narasumber->id)
                ->orWhere('nid_6', $narasumber->id);
        })->count();

        if ($relatedEventsCount > 0) {
            return response()->json([
                "error" => "Narasumber still related to events"
            ], 422);
        }

        if ($narasumber->image) {
            $oldImagePath = 'images/narasumber/' . $narasumber->image;
            Storage::disk('public')->delete($oldImagePath);
        }

        $narasumber->delete();

        return response()->json([
            "message" => "Narasumber deleted successfully"
        ], 200);
    }
}
