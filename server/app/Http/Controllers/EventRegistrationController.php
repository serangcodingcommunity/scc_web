<?php

namespace App\Http\Controllers;

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
        $validatedData = Validator::make($request->all(), [
            "event_id" => ['required', 'unique:registrasi_events,event_id'],
        ]);

        if ($validatedData->fails()) {
            return response()->json([
                "message" => "Validation error",
                "errors" => $validatedData->errors()
            ], 422);
        }

        $user = Auth::user();

        $registrasiEvent = new RegistrasiEvent([
            'event_id' => $request->event_id,
            'user_id' => $user->id
        ]);

        $pembayaran = new Pembayaran([
            'bukti_pemb' => $request->bukti_pemb,
            'status' => "Proses"
        ]);

        $registrasiEvent->save();
        $pembayaran->id = $registrasiEvent->id;
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
    public function destroy(RegistrasiEvent $registrasiEvent)
    {
        //
    }
}
