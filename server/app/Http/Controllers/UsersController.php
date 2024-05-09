<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Member;
use App\Models\Pekerjaan;
use App\Models\Pendidikan;
use App\Models\Sosmed;
use App\Models\Portofolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UsersController extends Controller
{
// Users
    public function index(Request $request)
    {
        $users = User::with(['members', 'sosmeds', 'pekerjaans', 'pendidikans', 'portofolios'])->get();

        $response = $users->map(function ($user) {
            return [
                "data" => [
                    "id" => $user->id,
                    "name" => $user->name,
                    "email" => $user->email,
                    "photo_profile_path" => $user->profile_photo_path ?? "Tidak ada Foto"
                ],
                "member" => $user->members ? [
                    "id" => $user->members->id,
                    "alamat" => $user->members->alamat,
                    "no_hp" => $user->members->no_hp,
                    "level" => $user->members->level
                ] : "Tidak terdaftar sebagai member",
                "sosmed" => $user->sosmeds->isEmpty() ? "Tidak mengisi sosmed" : $user->sosmeds->map(function ($sosmed) {
                    return [
                        "user_id" => $sosmed->user_id,
                        "link" => $sosmed->link,
                        "category" => $sosmed->category
                    ];
                }),
                "pekerjaan" => $user->pekerjaans->isEmpty() ? "Tidak mengisi pekerjaan" : $user->pekerjaans->map(function ($pekerjaan) {
                    return [
                        "user_id" => $pekerjaan->user_id,
                        "name" => $pekerjaan->name,
                        "bagian" => $pekerjaan->bagian,
                        "alamat" => $pekerjaan->alamat,
                        "in_date" => $pekerjaan->in_date,
                        "out_date" => $pekerjaan->out_date
                    ];
                }),
                "pendidikan" => $user->pendidikans->isEmpty() ? "Tidak mengisi pendidikan" : $user->pendidikans->map(function ($pendidikan) {
                    return [
                        "user_id" => $pendidikan->user_id,
                        "name" => $pendidikan->name,
                        "jurusan" => $pendidikan->jurusan,
                        "alamat" => $pendidikan->alamat,
                        "in_date" => $pendidikan->in_date,
                        "out_date" => $pendidikan->out_date
                    ];
                }),
                "portofolio" => $user->portofolios->isEmpty() ? "Tidak mengisi portofolio" : $user->portofolios->map(function ($portofolio) {
                    return [
                        "user_id" => $portofolio->user_id,
                        "title" => $portofolio->title,
                        "keterangan" => $portofolio->keterangan,
                        "image" => $portofolio->image,
                        "project_date" => $portofolio->project_date
                    ];
                }),
            ];
        });

        return response()->json($response);
    }

    public function show(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }
    
// Member
    public function storeMember(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required',
            'alamat' => 'required|string',
            'no_hp' => 'required|numeric'
        ]);

        if (!User::where('id', $validatedData['id'])->exists()) {
            return response()->json([
                'message' => 'User ini tidak ada'
            ], 404);
        } elseif (Member::where('id', $validatedData['id'])->exists()) {
            return response()->json([
                'message' => 'Member ini sudah terdaftar'
            ], 409);
        } elseif (Member::where('no_hp', $validatedData['no_hp'])->exists()) {
            return response()->json([
                'message' => 'Nomor HP sudah digunakan'
            ], 409);
        }
        
        $member = new Member();
        $member->save([
            'id' => $validatedData['id'],
            'alamat' => $validatedData['alamat'],
            'no_hp' => $validatedData['no_hp'],
            'level' => 1
        ]);

        return response()->json([
            'data' => [
                'id' => $validatedData['id'],
                'alamat' => $member->alamat,
                'no_hp' => $member->no_hp,
                'level' => $member->level
            ]
        ], 200);
        
    }

    public function updateMember(Request $request, string $id)
    {
        $member = Member::find($id);

        $validatedData = $request->validate([
            'alamat' => 'required|string',
            'no_hp' => 'required|numeric'
        ]);

        if (Member::where('no_hp', $validatedData['no_hp'])->exists()) {
            return response()->json([
                'message' => 'Nomor HP sudah digunakan'
            ], 409);
        } elseif (!$member) {
            return response()->json([
                'message' => 'User belum memiliki member'
            ], 404);
        }

        $member->update([
            'alamat' => $validatedData['alamat'],
            'no_hp' => $validatedData['no_hp']
        ]);

        return response()->json([
            "message" => "Berhasil mengubah data member",
            "data" => [
                'alamat' => $member->alamat,
                'no_hp' => $member->no_hp
            ]
        ], 200);
    }

// Pekerjaan
    public function storePekerjaan(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required',
            'name' => 'required|string',
            'bagian' => 'required|string',
            'alamat' => 'required|string',
            'in_date' => 'required|date',
            'out_date' => 'required|date'
        ]);

        if (!User::where('id', $validatedData['user_id'])->exists()) {
            return response()->json([
                'message' => 'User ini tidak ada'
            ], 404);
        } elseif (Pekerjaan::where('user_id', $validatedData['user_id'])->exists()) {
            return response()->json([
                'message' => 'Sudah mengisi pekerjaan'
            ], 409);
        }
        
        $pekerjaan = new Pekerjaan();
        $pekerjaan->user_id = $validatedData['user_id'];
        $pekerjaan->name = $validatedData['name'];
        $pekerjaan->bagian = $validatedData['bagian'];
        $pekerjaan->alamat = $validatedData['alamat'];
        $pekerjaan->in_date = $validatedData['in_date'];
        $pekerjaan->out_date = $validatedData['out_date'];
        $pekerjaan->save();

        return response()->json([
            'message' => 'Berhasil mengisi pekerjaan',
            'data' => [
                'id' => $pekerjaan->id,
                'name' => $pekerjaan->name,
                'bagian' => $pekerjaan->bagian,
                'alamat' => $pekerjaan->alamat,
                'in_date' => $pekerjaan->in_date,
                'out_date' => $pekerjaan->out_date
            ]
        ], 200);
        
    }

    public function updatePekerjaan(Request $request, string $id)
    {
        $pekerjaan = Pekerjaan::where('user_id', $id)->first();

        $validatedData = $request->validate([
            'name' => 'required|string',
            'bagian' => 'required|string',
            'alamat' => 'required|string',
            'in_date' => 'required|date',
            'out_date' => 'required|date'
        ]);

        $pekerjaan->update([
            'name' => $validatedData['name'],
            'bagian' => $validatedData['bagian'],
            'alamat' => $validatedData['alamat'],
            'in_date' => $validatedData['in_date'],
            'out_date' => $validatedData['out_date']
        ]);

        return response()->json([
            "message" => "Berhasil mengubah data pekerjaan",
            "data" => [
                'name' => $pekerjaan->name,
                'bagian' => $pekerjaan->bagian,
                'alamat' => $pekerjaan->alamat,
                'in_date' => $pekerjaan->in_date,
                'out_date' => $pekerjaan->out_date
            ]
        ], 200);
    }

    public function destroyPekerjaan(string $id)
    {
        $pekerjaan = Pekerjaan::where('user_id', $id)->first();

        if (!$pekerjaan) {
            return response()->json([
                'message' => 'Data pekerjaan tidak ditemukan'
            ], 404);
        }

        $pekerjaan->delete();

        return response()->json([
            'message' => 'Berhasil menghapus data pekerjaan',
            'data' => "ok"
        ], 200);
    }

// Pendidikan
    public function storePendidikan(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required',
            'name' => 'required|string',
            'jurusan' => 'required|string',
            'alamat' => 'required|string',
            'in_date' => 'required|date',
            'out_date' => 'required|date'
        ]);

        if (!User::where('id', $validatedData['user_id'])->exists()) {
            return response()->json([
                'message' => 'User ini tidak ada'
            ], 404);
        } elseif (Pendidikan::where('user_id', $validatedData['user_id'])->exists()) {
            return response()->json([
                'message' => 'Sudah mengisi pendidikan'
            ], 409);
        }
        
        $pendidikan = new Pendidikan();
        $pendidikan->user_id = $validatedData['user_id'];
        $pendidikan->name = $validatedData['name'];
        $pendidikan->jurusan = $validatedData['jurusan'];
        $pendidikan->alamat = $validatedData['alamat'];
        $pendidikan->in_date = $validatedData['in_date'];
        $pendidikan->out_date = $validatedData['out_date'];
        $pendidikan->save();

        return response()->json([
            'message' => 'Berhasil mengisi pendidikan',
            'data' => [
                'id' => $pendidikan->id,
                'user_id' => $pendidikan->user_id,
                'name' => $pendidikan->name,
                'jurusan' => $pendidikan->jurusan,
                'alamat' => $pendidikan->alamat,
                'in_date' => $pendidikan->in_date,
                'out_date' => $pendidikan->out_date
            ]
        ], 200);
        
    }

    public function updatePendidikan(Request $request, string $id)
    {
        $pendidikan = Pendidikan::where('user_id', $id)->first();

        $validatedData = $request->validate([
            'name' => 'required|string',
            'jurusan' => 'required|string',
            'alamat' => 'required|string',
            'in_date' => 'required|date',
            'out_date' => 'required|date'
        ]);

        if (!$pendidikan) {
            return response()->json([
                'message' => 'User belum mengisi pendidikan'
            ], 404);
        }

        $pendidikan->update([
            'name' => $validatedData['name'],
            'jurusan' => $validatedData['jurusan'],
            'alamat' => $validatedData['alamat'],
            'in_date' => $validatedData['in_date'],
            'out_date' => $validatedData['out_date']
        ]);

        return response()->json([
            "message" => "Berhasil mengubah data pendidikan",
            "data" => [
                'user_id' => $pendidikan->user_id,
                'name' => $pendidikan->name,
                'jurusan' => $pendidikan->jurusan,
                'alamat' => $pendidikan->alamat,
                'in_date' => $pendidikan->in_date,
                'out_date' => $pendidikan->out_date
            ]
        ], 200);
    }

    public function destroyPendidikan(string $id)
    {
        $pendidikan = Pendidikan::where('user_id', $id)->first();

        if (!$pendidikan) {
            return response()->json([
                'message' => 'Data pendidikan tidak ditemukan'
            ], 404);
        }

        $pendidikan->delete();

        return response()->json([
            'message' => 'Berhasil menghapus data pendidikan',
            'data' => "ok"
        ], 200);
    }

// Sosmed
    public function storeSosmed(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required',
            'link' => 'required|string',
            'category' => 'required',
        ]);

        if (!User::where('id', $validatedData['user_id'])->exists()) {
            return response()->json([
                'message' => 'User ini tidak ada'
            ], 404);
        } elseif (Sosmed::where('user_id', $validatedData['user_id'])->exists()) {
            return response()->json([
                'message' => 'Sudah mengisi sosmed'
            ], 409);
        }
        
        $sosmed = new Sosmed();
        $sosmed->user_id = $validatedData['user_id'];
        $sosmed->link = $validatedData['link'];
        $sosmed->category = $validatedData['category'];
        $sosmed->save();

        return response()->json([
            'message' => 'Berhasil mengisi sosmed',
            'data' => [
                'id' => $sosmed->id,
                'user_id' => $sosmed->user_id,
                'link' => $sosmed->link,
                'category' => $sosmed->category
            ]
        ], 200);
        
    }

    public function updateSosmed(Request $request, string $id)
    {
        $sosmed = Sosmed::where('user_id', $id)->first();

        $validatedData = $request->validate([
            'link' => 'required|string',
            'category' => 'required'
        ]);

        if (!$sosmed) {
            return response()->json([
                'message' => 'User belum mengisi sosmed'
            ], 404);
        }

        $sosmed->update([
            'link' => $validatedData['link'],
            'category' => $validatedData['category']
        ]);

        return response()->json([
            "message" => "Berhasil mengubah data sosmed",
            "data" => [
                'user_id' => $sosmed->user_id,
                'link' => $sosmed->link,
                'category' => $sosmed->category
            ]
        ], 200);
    }

    public function destroySosmed(string $id)
    {
        $sosmed = Sosmed::where('user_id', $id)->first();

        if (!$sosmed) {
            return response()->json([
                'message' => 'Data sosmed tidak ditemukan'
            ], 404);
        }

        $sosmed->delete();

        return response()->json([
            'message' => 'Berhasil menghapus data sosmed',
            'data' => "ok"
        ], 200);
    }

// Portofolio
    public function storePortofolio(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required',
            'title' => 'required|string',
            'keterangan' => 'required|string',
            'image' => 'required|string',
            'project_date' => 'required|date',
        ]);

        if (!User::where('id', $validatedData['user_id'])->exists()) {
            return response()->json([
                'message' => 'User ini tidak ada'
            ], 404);
        } elseif (Portofolio::where('user_id', $validatedData['user_id'])->exists()) {
            return response()->json([
                'message' => 'Sudah mengisi portofolio'
            ], 409);
        }
        
        $portofolio = new Portofolio();
        $portofolio->user_id = $validatedData['user_id'];
        $portofolio->title = $validatedData['title'];
        $portofolio->slug = Str::slug($validatedData['title']);
        $portofolio->keterangan = $validatedData['keterangan'];
        $portofolio->image = $validatedData['image'];
        $portofolio->project_date = $validatedData['project_date'];
        $portofolio->save();

        return response()->json([
            'message' => 'Berhasil mengisi portofolio',
            'data' => [
                'id' => $portofolio->id,
                'user_id' => $portofolio->user_id,
                'title' => $portofolio->title,
                'slug' => $portofolio->slug,
                'keterangan' => $portofolio->keterangan,
                'image' => $portofolio->image,
                'project_date' => $portofolio->project_date
            ]
        ], 200);
    }

    public function updatePortofolio(Request $request, string $id)
    {
        $portofolio = Portofolio::where('user_id', $id)->first();

        $validatedData = $request->validate([
            'title' => 'required|string',
            'keterangan' => 'required|string',
            'image' => 'required|string',
            'project_date' => 'required|date'
        ]);

        if (!$portofolio) {
            return response()->json([
                'message' => 'User belum mengisi portofolio'
            ], 404);
        }

        $portofolio->update([
            'title' => $validatedData['title'],
            'slug' => Str::slug($validatedData['title']),
            'keterangan' => $validatedData['keterangan'],
            'image' => $validatedData['image'],
            'project_date' => $validatedData['project_date']
        ]);

        return response()->json([
            "message" => "Berhasil mengubah data portofolio",
            "data" => [
                'user_id' => $portofolio->user_id,
                'title' => $portofolio->title,
                'slug' => $portofolio->slug,
                'keterangan' => $portofolio->keterangan,
                'image' => $portofolio->image,
                'project_date' => $portofolio->project_date
            ]
        ], 200);
    }

    public function destroyPortofolio(string $id)
    {
        $portofolio = Portofolio::where('user_id', $id)->first();

        if (!$portofolio) {
            return response()->json([
                'message' => 'Data portofolio tidak ditemukan'
            ], 404);
        }

        $portofolio->delete();

        return response()->json([
            'message' => 'Berhasil menghapus data portofolio',
            'data' => "ok"
        ], 200);
    }
}
