<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Event;
use App\Models\Narasumber;
use Illuminate\Http\Request;
use App\Models\RegistrasiEvent;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::with([
            'nid1' => function ($query) {
                $query->select('id', 'name', 'keterangan', 'image');
            },
            'nid2' => function ($query) {
                $query->select('id', 'name', 'keterangan', 'image');
            },
            'nid3' => function ($query) {
                $query->select('id', 'name', 'keterangan', 'image');
            },
            'nid4' => function ($query) {
                $query->select('id', 'name', 'keterangan', 'image');
            },
            'nid5' => function ($query) {
                $query->select('id', 'name', 'keterangan', 'image');
            },
            'nid6' => function ($query) {
                $query->select('id', 'name', 'keterangan', 'image');
            },
            'user' => function ($query) {
                $query->select('id', 'name');
            }
        ])->get();

        $eventsData = $events->map(function ($event) {
            $event['price'] = formatPrice($event['price']);
            return $event;
        });

        return response()->json([
            "data" => $eventsData,
        ], 200);
    }

    public function store(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            "title" => 'required|unique:events,title',
            "keterangan" => 'required',
            "image" => 'file|max:512',
            "price" => 'required',
            "quota" => 'required',
            "status" => 'required',
            "event_date" => 'required',
            "lokasi" => 'required',
            "nid_1" => 'required',
        ]);

        if ($validatedData->fails()) {
            return response()->json([
                "message" => "Validation error",
                "errors" => $validatedData->errors()
            ], 422);
        }

        $slug = strtolower(slugify($request->input('title')));
        $user = Auth::user();

        $timestamp = now()->timestamp;

        $image =  strtolower(str_replace(' ', '', $request->title)) . $timestamp . '.' . $request->file('image')->getClientOriginalExtension();
        $filePath = 'images/events/' . $image;
        Storage::disk('public')->put($filePath, file_get_contents($request->file('image')));

        $event = Event::create([
            'slug' => $slug,
            'title' => $request->input('title'),
            'keterangan' => $request->keterangan,
            'image' => $image,
            'price' => $request->price,
            'quota' => $request->quota,
            'status' => 'upcoming',
            'publish_date' => date('Y-m-d'),
            'event_date' => $request->event_date,
            'published' => 0,
            'lokasi' => $request->lokasi,
            'nid_1' => $request->nid_1,
            'nid_2' => $request->nid_2,
            'nid_3' => $request->nid_3,
            'nid_4' => $request->nid_4,
            'nid_5' => $request->nid_5,
            'nid_6' => $request->nid_6,
            'user_id' => $user->id,
        ]);

        return response()->json([
            "message" => "Event created successfully",
            "data" => $event
        ], 201);
    }

    public function show(Request $request, Event $event)
    {
        $event = Event::find($request->id);

        if (!$event) {
            return response()->json([
                "error" => "Event not found"
            ], 404);
        }

        $eventRegistrationCount = RegistrasiEvent::where('event_id', $event->id)->count();
        $quotaNow = $event->quota - $eventRegistrationCount;

        $nid_1 = Narasumber::find($event->nid_1);
        $nid_2 = Narasumber::find($event->nid_2);
        $nid_3 = Narasumber::find($event->nid_3);
        $nid_4 = Narasumber::find($event->nid_4);
        $nid_5 = Narasumber::find($event->nid_5);
        $nid_6 = Narasumber::find($event->nid_6);
        $user = User::find($event->user_id);

        return response()->json([
            "data" => [
                'id' => $event->id,
                'slug' => $event->slug,
                'title' => $event->title,
                'keterangan' => $event->keterangan,
                'image' => $event->image,
                'price' => formatPrice($event->price),
                'quota' => $event->quota,
                'quota_now' => $quotaNow,
                'status' => $event->status,
                'user_id' => $event->user_id,
                'publish_date' => $event->publish_date,
                'event_date' => $event->event_date,
                'published' => $event->published,
                'lokasi' => $event->lokasi,
                'created_at' => $event->created_at,
                'updated_at' => $event->updated_at
            ],
            "nid_1" => [
                'id' => $nid_1->id,
                'name' => $nid_1->name,
                'keterangan' => $nid_1->keterangan,
                'image' => $nid_1->image,
            ],
            "nid_2" => $nid_2 ? [
                'id' => $nid_2->id,
                'name' => $nid_2->name,
                'keterangan' => $nid_2->keterangan,
                'image' => $nid_2->image,
            ] : null,
            "nid_3" => $nid_3 ? [
                'id' => $nid_3->id,
                'name' => $nid_3->name,
                'keterangan' => $nid_3->keterangan,
                'image' => $nid_3->image,
            ] : null,
            "nid_4" => $nid_4 ? [
                'id' => $nid_4->id,
                'name' => $nid_4->name,
                'keterangan' => $nid_4->keterangan,
                'image' => $nid_4->image,
            ] : null,
            "nid_5" => $nid_5 ? [
                'id' => $nid_5->id,
                'name' => $nid_5->name,
                'keterangan' => $nid_5->keterangan,
                'image' => $nid_5->image,
            ] : null,
            "nid_6" => $nid_6 ? [
                'id' => $nid_6->id,
                'name' => $nid_6->name,
                'keterangan' => $nid_6->keterangan,
                'image' => $nid_6->image,
            ] : null,
            "users" => [
                'id' => $user->id,
                'name' => $user->name
            ]
        ], 200);
    }

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
            "message" => "Event published successfully",
            "data" => [
                'id' => $event->id,
                'published' => $event->published,
                'publish_date' => $event->publish_date,
                'updated_at' => $event->updated_at,
            ]
        ], 200);
    }

    public function update(Request $request, Event $event)
    {
        $event = Event::find($request->id);
        if (!$event) {
            return response()->json([
                "error" => "Event not found"
            ], 404);
        }

        $validatedData = Validator::make($request->all(), [
            "title" => ['required', Rule::unique('events')->ignore($event->id)],
            "keterangan" => 'required',
            "image" => 'file|max:512',
            "price" => 'required',
            "quota" => 'required',
            "status" => 'required',
            "event_date" => 'required',
            "lokasi" => 'required',
            "nid_1" => 'required',
        ]);

        if ($validatedData->fails()) {
            return response()->json([
                "message" => "Validation error",
                "errors" => $validatedData->errors()
            ], 422);
        }

        $slug = strtolower(slugify($request->input('title')));
        $user = Auth::user();

        if ($request->hasFile('image')) {
            if ($event->image) {
                $oldImagePath = 'images/events/' . $event->image;
                Storage::disk('public')->delete($oldImagePath);
            }

            $timestamp = now()->timestamp;
            $image =  strtolower(str_replace(' ', '', $request->title)) . $timestamp . '.' . $request->file('image')->getClientOriginalExtension();
            $filePath = 'images/events/' . $image;
            Storage::disk('public')->put($filePath, file_get_contents($request->file('image')));
        } else {
            $image = $event->image;
        }

        Event::where('id', $request->id)->update([
            'slug' => $slug,
            'title' => $request->input('title'),
            'keterangan' => $request->keterangan,
            'image' => $image,
            'price' => $request->price,
            'quota' => $request->quota,
            'status' => $request->status,
            'event_date' => $request->event_date,
            'lokasi' => $request->lokasi,
            'nid_1' => $request->nid_1,
            'nid_2' => $request->nid_2,
            'nid_3' => $request->nid_3,
            'nid_4' => $request->nid_4,
            'nid_5' => $request->nid_5,
            'nid_6' => $request->nid_6,
            'user_id' => $user->id,
        ]);

        $event = Event::find($request->id);

        return response()->json([
            "message" => "Event updated successfully",
            "data" => $event
        ], 200);
    }

    public function tersediaEvent(string $id)
    {
        $eventExist = Event::find($id);

        if (!$eventExist) {
            return response()->json([
                "error" => "Event not found"
            ], 422);
        }

        Event::where('id', $id)->update([
            'status' => 'available'
        ]);

        return response()->json([
            "message" => "Event available"
        ], 200);
    }

    public function selesaiEvent(string $id)
    {
        $eventExist = Event::find($id);

        if (!$eventExist) {
            return response()->json([
                "error" => "Event not found"
            ], 422);
        }

        $registrasiTanpaPembayaran = RegistrasiEvent::where('event_id', $id)->whereDoesntHave('pembayaran')->get();
        foreach ($registrasiTanpaPembayaran as $registrasi) {
            $registrasi->delete();
        }

        Event::where('id', $id)->update([
            'status' => 'unavailable'
        ]);

        return response()->json([
            "message" => "Event selesai"
        ], 200);
    }

    public function destroy(Request $request, Event $event)
    {
        $event = Event::find($request->id);

        if (!$event) {
            return response()->json([
                "error" => "Event not found"
            ], 404);
        }

        $registrasiEventExists = RegistrasiEvent::where('event_id', $event->id)->first();

        if ($registrasiEventExists) {
            return response()->json([
                "error" => "Tidak dapat menghapus event karena masih ada registrasi event terkait"
            ], 422);
        } else {
            if ($event->image) {
                $oldImagePath = 'images/events/' . $event->image;
                Storage::disk('public')->delete($oldImagePath);
            }
            Event::where('id', $event->id)->delete();
            return response()->json([
                "message" => "Event berhasil dihapus"
            ], 200);
        }
    }
}
