<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Narasumber;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::with([
            'narasumber' => function ($query) {
                $query->select('id', 'name', 'keterangan', 'image');
            },
            'user' => function ($query) {
                $query->select('id', 'name');
            }
        ])->get();

        return response()->json([
            "data" => $events,
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
            "title" => ['required', 'unique:events,title'],
            "keterangan" => ['required'],
            "image" => ['required'],
            "price" => ['required'],
            "quota" => ['required'],
            "status" => ['required'],
            "event_date" => ['required'],
            "lokasi" => ['required'],
            "narasumber_id" => ['required'],
        ]);

        if ($validatedData->fails()) {
            return response()->json([
                "message" => "Validation error",
                "errors" => $validatedData->errors()
            ], 422);
        }

        $slug = strtolower(slugify($request->input('title')));
        $user = Auth::user();

        $event = Event::create([
            'slug' => $slug,
            'title' => $request->input('title'),
            'keterangan' => $request->keterangan,
            'image' => $request->image,
            'price' => $request->price,
            'quota' => $request->quota,
            'status' => $request->status,
            'publish_date' => date('Y-m-d'),
            'event_date' => $request->event_date,
            'published' => 0,
            'lokasi' => $request->lokasi,
            'narasumber_id' => $request->narasumber_id,
            'user_id' => $user->id,
        ]);

        return response()->json([
            "message" => "Event created successfully",
            "data" => $event
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Event $event)
    {
        $event = Event::find($request->id);

        if (!$event) {
            return response()->json([
                "error" => "Event not found"
            ], 404);
        }

        $narasumber = Narasumber::find($event->narasumber_id);
        $user = User::find($event->user_id);

        return response()->json([
            "data" => $event,
            "narasumber" => [
                'id' => $narasumber->id,
                'name' => $narasumber->name,
                'keterangan' => $narasumber->keterangan,
                'image' => $narasumber->image,
            ],
            "users" => [
                'id' => $user->id,
                'name' => $user->name
            ]
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function publish(Request $request, Event $event)
    {
        $event = Event::find($request->id);
        if (!$event) {
            return response()->json([
                "error" => "Event not found"
            ], 404);
        }

        Event::where('id', $request->id)->update([
            'published' => $request->published,
            'publish_date' => date('Y-m-d'),
        ]);

        $event = Event::find($request->id);

        return response()->json([
            "message" => "Event updated successfully",
            "data" => [
                'id' => $event->id,
                'published' => $event->published,
                'publish_date' => $event->publish_date,
                'updated_at' => $event->updated_at,
            ]
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        $validatedData = Validator::make($request->all(), [
            "title" => ['required', 'unique:events,title'],
            "keterangan" => ['required'],
            "image" => ['required'],
            "price" => ['required'],
            "quota" => ['required'],
            "status" => ['required'],
            "event_date" => ['required'],
            "lokasi" => ['required'],
            "narasumber_id" => ['required'],
        ]);

        $event = Event::find($request->id);
        if (!$event) {
            return response()->json([
                "error" => "Event not found"
            ], 404);
        }

        if ($validatedData->fails()) {
            return response()->json([
                "message" => "Validation error",
                "errors" => $validatedData->errors()
            ], 422);
        }

        $slug = strtolower(slugify($request->input('title')));
        $user = Auth::user();

        Event::where('id', $request->id)->update([
            'slug' => $slug,
            'title' => $request->input('title'),
            'keterangan' => $request->keterangan,
            'image' => $request->image,
            'price' => $request->price,
            'quota' => $request->quota,
            'status' => $request->status,
            'publish_date' => date('Y-m-d'),
            'event_date' => $request->event_date,
            'published' => 0,
            'lokasi' => $request->lokasi,
            'narasumber_id' => $request->narasumber_id,
            'user_id' => $user->id,
        ]);

        $event = Event::find($request->id);

        return response()->json([
            "message" => "Event updated successfully",
            "data" => $event
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Event $event)
    {
        $event = Event::find($request->id);
        if (!$event) {
            return response()->json([
                "error" => "Event not found"
            ], 404);
        }

        Event::where('id', $request->id)->delete();

        return response()->json([
            "data" => "ok"
        ], 200);
    }
}
