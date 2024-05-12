<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Event;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use App\Models\RegistrasiEvent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class EventRegistrationController extends Controller
{
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

        foreach ($registrasiEvent as $registration) {
            $registration->event->price = $registration->event->price;
        }

        return response()->json([
            "data" => $registrasiEvent,
        ], 200);
    }

    public function store(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            "event_id" => ['required'],
            "user_id" => ['required'],
        ]);

        if ($validatedData->fails()) {
            return response()->json([
                "message" => "Validation error",
                "errors" => $validatedData->errors()
            ], 422);
        }

        $user = Auth::user();
        $event = Event::find($request->event_id);
        $registrasiEventExist = RegistrasiEvent::where('event_id', $event->id)->where('user_id', $user->id)->first();

        if (!$event) {
            return response()->json([
                "error" => "Event not found"
            ], 404);
        }

        if ($event->published == 0) {
            return response()->json([
                "error" => "Event belum di publish"
            ], 422);
        }

        if ($event->status == 'upcoming') {
            return response()->json([
                "error" => "Event masih upcoming"
            ], 422);
        } elseif ($event->status == 'unavailable') {
            return response()->json([
                "error" => "Event unavailable"
            ], 422);
        } elseif ($event->status == 'soldout') {
            return response()->json([
                "error" => "Tiket sudah soldout"
            ], 422);
        } elseif ($event->status == 'available') {
            if ($registrasiEventExist) {
                return response()->json([
                    "message" => "Anda sudah terdaftar untuk acara ini",
                ], 200);
            }

            $registrasiEvent = new RegistrasiEvent();
            $registrasiEvent->user_id = $user->id;
            $registrasiEvent->event_id = $request->event_id;
            $registrasiEvent->save();

            return response()->json([
                "message" => "Registrasi berhasil",
                "data" => $registrasiEvent
            ], 201);
        }
    }

    public function bayar(Request $request, string $id)
    {
        $user = Auth::user();
        $userName = $user->name;
        $timestamp = now()->timestamp;
        $rules = ['bukti_pemb' => 'required|file|max:512'];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                "message" => "Please fill in the form correctly",
                "data" => $validator->errors()
            ], 422);
        }

        $pembayaran = RegistrasiEvent::find($id);
        $pembayaranExist = Pembayaran::find($id);
        $registrasiEvent = Event::where('id', $pembayaran->event_id)->first();

        $cekPembCount = RegistrasiEvent::where('event_id', $registrasiEvent->id)
            ->whereHas('pembayaran', function ($query) {
                $query->where('status', ['success', 'process']);
            })
            ->count();

        if ($cekPembCount >= $registrasiEvent->quota) {
            return response()->json([
                "error" => "Mohon maaf antrian bayar penuh, silahkan coba beberapa saat lagi",
            ], 422);
        }

        if (!$pembayaran) {
            return response()->json([
                "error" => "Tidak ada tagihan pembayaran untuk registrasi event ini",
            ], 404);
        }

        if ($pembayaranExist) {
            return response()->json([
                "error" => "Anda sudah melakukan pembayaran",
            ], 422);
        }

        if ($request->hasFile('bukti_pemb')) {
            if ($pembayaran->bukti_pemb) {
                $profilePhotoPath = 'pembayaran/' . $pembayaran->bukti_pemb;
                Storage::disk('public')->delete($profilePhotoPath);
            }

            $image = $userName . $timestamp . '.' . $request->file('bukti_pemb')->getClientOriginalExtension();
            $filePath = 'pembayaran/' . $image;
            Storage::disk('public')->put($filePath, file_get_contents($request->file('bukti_pemb')));

            $pembayaran = new Pembayaran();
            $pembayaran->id = $id;
            $pembayaran->bukti_pemb = $image;
            $pembayaran->status = 'process';
            $pembayaran->save();

            $eventRegistrationCount = RegistrasiEvent::where('event_id', $registrasiEvent->id)
                ->whereHas('pembayaran', function ($query) {
                    $query->where('status', 'success');
                })
                ->count();
            $quotaNow = $registrasiEvent->quota - $eventRegistrationCount;
            if ($quotaNow <= 0) {
                Event::where('id', $registrasiEvent->id)->update([
                    'status' => 'soldout',
                ]);
            }

            return response()->json([
                "message" => "Pembayaran akan diverifikasi",
            ], 200);
        }
    }

    public function show(Request $request)
    {
        $registrasiEvent = RegistrasiEvent::find($request->id);

        if (!$registrasiEvent) {
            return response()->json([
                "error" => "Registrasi event not found"
            ], 404);
        }

        $event = Event::find($registrasiEvent->event_id);
        $user = User::find($registrasiEvent->user_id);
        $pembayaran = Pembayaran::find($registrasiEvent->id);

        return response()->json([
            "data" => $registrasiEvent,
            "event" => [
                'id' => $event->id,
                'title' => $event->title,
                'keterangan' => $event->keterangan,
                'image' => $event->image,
                'price' => formatPrice($event->price),
                'quota' => $event->quota,
                'status' => $event->status,
                'event_date' => $event->event_date,
                'lokasi' => $event->lokasi,
            ],
            "users" => [
                'id' => $user->id,
                'name' => $user->name
            ],
            "pembayaran" => $pembayaran ? [
                'id' => $pembayaran->id,
                'bukti_pemb' => $pembayaran->bukti_pemb,
                'status' => $pembayaran->status,
            ] : null
        ], 200);
    }

    public function accept(Request $request)
    {
        $eventRegistration = RegistrasiEvent::find($request->id);

        if (!$eventRegistration) {
            return response()->json([
                "error" => "Pembayaran tidak ditemukan"
            ], 404);
        }

        $verifikasiPembayaran = Pembayaran::where('id', $eventRegistration->id)->where('status', 'success')->first();

        if ($verifikasiPembayaran) {
            return response()->json([
                "error" => "Pembayaran sudah diverifikasi"
            ], 422);
        }

        $pembayaran = Pembayaran::find($eventRegistration->id);

        if (!$pembayaran) {
            return response()->json([
                "error" => "Pembayaran tidak ditemukan"
            ], 404);
        } else {
            Pembayaran::where('id', $pembayaran->id)->update([
                'status' => 'success'
            ]);
            return response()->json([
                "message" => "Pembayaran diverifikasi"
            ], 200);
        }
    }

    public function reject(Request $request)
    {
        $eventRegistration = RegistrasiEvent::find($request->id);

        if (!$eventRegistration) {
            return response()->json([
                "error" => "Pembayaran tidak ditemukan"
            ], 404);
        }

        $verifikasiPembayaran = Pembayaran::where('id', $eventRegistration->id)->where('status', 'success')->first();

        if ($verifikasiPembayaran) {
            return response()->json([
                "error" => "Pembayaran tidak bisa ditolak karena sudah diverifikasi"
            ], 422);
        }

        $pembayaran = Pembayaran::where('id', $eventRegistration->id)->where('status', 'process')->first();

        if ($pembayaran) {
            Pembayaran::where('id', $pembayaran->id)->where('status', 'process')->delete();
            RegistrasiEvent::where('id', $pembayaran->id)->delete();

            return response()->json([
                "message" => "Pembayaran dan Registrasi event berhasil ditolak"
            ], 200);
        } else {
            return response()->json([
                "error" => "Pembayaran tidak ditemukan"
            ], 404);
        }
    }

    public function destroy(Request $request)
    {
        $bayar = Pembayaran::where('id', $request->id)->count();
        $registrasiEventExists = RegistrasiEvent::where('id', $request->id)->exists();

        if (!$registrasiEventExists) {
            return response()->json([
                "error" => "Registration event not found"
            ], 404);
        }

        if ($bayar > 0) {
            return response()->json([
                "error" => "Tidak dapat dibatalkan, sudah melakukan pembayaran"
            ], 422);
        } else if ($bayar == 0) {
            $registrasievent = Registrasievent::find($request->id);
            $registrasievent->delete();

            return response()->json([
                "message" => "Registrasi event berhasil dibatalkan"
            ], 200);
        }
    }
}
