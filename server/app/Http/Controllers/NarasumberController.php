<?php

namespace App\Http\Controllers;

use App\Models\Narasumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NarasumberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $narasumber = Narasumber::all();

        return response()->json([
            "data" => $narasumber
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            "name" => ['required'],
            "keterangan" => ['required'],
            "image" => ['required'],
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

    /**
     * Display the specified resource.
     */
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

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Narasumber $narasumber)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Narasumber $narasumber)
    {
        $validatedData = Validator::make($request->all(), [
            "name" => ['required'],
            "keterangan" => ['required'],
            "image" => ['required'],
        ]);

        $narasumber = Narasumber::find($request->id);
        if (!$narasumber) {
            return response()->json([
                "error" => "Narasumber not found"
            ], 404);
        }

        if ($validatedData->fails()) {
            return response()->json([
                "message" => "Validation error",
                "errors" => $validatedData->errors()
            ], 422);
        }

        Narasumber::where('id', $request->id)->update([
            'name' => $request->name,
            'keterangan' => $request->keterangan,
            'image' => $request->image
        ]);

        $narasumber = Narasumber::find($request->id);

        return response()->json([
            "message" => "Narasumber updated successfully",
            "data" => $narasumber
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
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
