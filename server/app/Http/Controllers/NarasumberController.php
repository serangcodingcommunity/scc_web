<?php

namespace App\Http\Controllers;

use App\Models\Narasumber;
use Illuminate\Http\Request;
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
            "name" => ['required']
        ]);

        if ($validatedData->fails()) {
            return response()->json([
                "message" => "Validation error",
                "errors" => $validatedData->errors()
            ], 422);
        }

        $narasumber = Narasumber::create([
            'name' => $request->name,
            'keterangan' => $request->keterangan,
            'image' => $request->image
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
            "name" => 'required'
        ]);

        if ($validatedData->fails()) {
            return response()->json([
                "message" => "Validation error",
                "errors" => $validatedData->errors()
            ], 422);
        }

        $image = base64_encode($request->image);

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

        $relatedEventsCount = $narasumber->events()->count();
        if ($relatedEventsCount > 0) {
            return response()->json([
                "error" => "Narasumber still related to events"
            ], 422);
        }

        $narasumber->delete();

        return response()->json([
            "message" => "Narasumber deleted successfully"
        ], 200);
    }
}
