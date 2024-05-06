<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use App\Models\RegistrasiEvent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class EventRegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function index()
    {
        $registrasiEvent = RegistrasiEvent::with([
            'event' => function ($query) {
                $query->select('id', 'title', 'keterangan', 'image', 'price', 'quota', 'status', 'event_date', 'lokasi');
            },
            'user' => function ($query) {
                $query->select('id', 'name');
            },
            'pembayaran' => function ($query) {
                $query->select('id', 'bukti_pemb', 'status');
            },
        ])->get();

        return response()->json([
            "data" => $registrasiEvent,
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
        $eventExists = Event::where('id', $request->event_id)->exists();

        if (!$eventExists) {
            return response()->json([
                "error" => "Event not found"
            ], 404);
        }

        $validatedData = Validator::make($request->all(), [
            "event_id" => ['required'],
            "bukti_pemb" => ['required', function ($attribute, $value, $fail) use ($request) {
                if (!$request->has('event_id')) {
                    return;
                }

                $existingRegistration = DB::table('registrasi_events')
                    ->where('user_id', auth()->id())
                    ->where('event_id', $request->event_id)
                    ->exists();

                if ($existingRegistration) {
                    $fail('You have already registered for this event.');
                }
            }],
        ]);

        if ($validatedData->fails()) {
            return response()->json([
                "message" => "Validation error",
                "errors" => $validatedData->errors()
            ], 422);
        }

        $registrasiEvent = new RegistrasiEvent();
        $registrasiEvent->user_id = auth()->user()->id;
        $registrasiEvent->event_id = $request->event_id;
        $registrasiEvent->save();

        $user = Auth::user();
        $registrasiEventId = RegistrasiEvent::where('user_id', $user->id)->latest()->first();

        $pembayaran = new Pembayaran();
        $pembayaran->id = $registrasiEventId->id;
        $pembayaran->bukti_pemb = $request->bukti_pemb;
        $pembayaran->status = 'Proses';
        $pembayaran->save();

        return response()->json([
            "message" => "Registrasi berhasil",
            "data" => $registrasiEvent
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(RegistrasiEvent $registrasiEvent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RegistrasiEvent $registrasiEvent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RegistrasiEvent $registrasiEvent)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, RegistrasiEvent $registrasiEvent)
    {
        $registrasiEventExists = RegistrasiEvent::where('id', $request->id)->exists();

        if (!$registrasiEventExists) {
            return response()->json([
                "error" => "Registration event not found"
            ], 404);
        }

        return response()->json([
            "error" => "Tidak dapat dibatalkan, sudah melakukan pembayaran"
        ], 200);
    }
}
