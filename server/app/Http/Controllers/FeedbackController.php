<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Event;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function index()
    {
        $feedbacks = Feedback::with(['event', 'user'])->get();

        $response = $feedbacks->map(function ($feedback) {
            return [
                "data" => [
                    "id" => $feedback->id,
                    "event_id" => $feedback->event_id,
                    "user_id" => $feedback->user_id,
                    "rate" => $feedback->rate,
                    "keterangan" => $feedback->keterangan,
                    "created_at" => $feedback->created_at,
                    "updated_at" => $feedback->updated_at
                ],
                "events" => [
                    "id" => $feedback->event->id,
                    "name" => $feedback->event->title
                ],
                "users" => [
                    "id" => $feedback->user->id,
                    "name" => $feedback->user->name
                ]
            ];
        });

        return response()->json($response);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'rate' => 'required|integer|min:1|max:5',
            'keterangan' => 'required|string',
            'user_id' => 'required|exists:users,id',
            'event_id' => 'required|exists:events,id'
        ]);

        // $event = Event::find($request->event_id);
        // if (!$event || !$event->users || !$event->users->contains($request->user_id)) {
        //     return response()->json([
        //         "error" => "anda tidak mengikuti event"
        //     ], 403);
        // }

        if (auth()->user()->id != $request->user_id) {
            return response()->json([
                "error" => "anda tidak mengikuti event"
            ], 403);
        }

        $feedback = new Feedback([
            'rate' => $request->rate,
            'keterangan' => $request->keterangan,
            'user_id' => $request->user_id,
            'event_id' => $request->event_id
        ]);

        $feedback->save();

        return response()->json([
            "data" => [
                'id' => $feedback->id,
                'event_id' => $feedback->event_id,
                'user_id' => $feedback->user_id,
                'rate' => $feedback->rate,
                'keterangan' => $feedback->keterangan,
                'created_at' => $feedback->created_at,
                'updated_at' => $feedback->updated_at
            ]
        ], 201);
    }
}
