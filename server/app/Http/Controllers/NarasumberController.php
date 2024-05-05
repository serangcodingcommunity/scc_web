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
        //
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
    public function show(Narasumber $narasumber)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Narasumber $narasumber)
    {
        //
    }
}
