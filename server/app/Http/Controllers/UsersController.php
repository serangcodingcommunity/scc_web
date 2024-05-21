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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


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

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'photo_profile_path' => 'file|max:512'
        ], [
            'photo_profile_path.max' => 'File harus berukuran 500 kb'
        ]);

        if($request->hasFile('profile_photo_path')) {
            if ($user->profile_photo_path) {
                $profilePhotoPath = 'images/photo-profile/' . $user->profile_photo_path;
                Storage::disk('public')->delete($profilePhotoPath);
            }

            $image = $userName . '-' . $timestamp . '.' . $request->file('profile_photo_path')->getClientOriginalExtension();
            $filePath = 'images/photo-profile/' . $image; 
            Storage::disk('public')->put($filePath, file_get_contents($request->file('profile_photo_path')));
            $user->profile_photo_path = $image;
            $user->save();

            return response()->json([
                'message' => 'Foto profile berhasil diupdate',
            ], 200);
        }
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
        $user = Auth::user();
        $portofolio = new Portofolio();
        $userName = $user->name;
        $timestamp = now()->timestamp;

        $validatedData = $request->validate([
            'name' => 'required|string',
            'link' => 'required|string',
            'keterangan' => 'required|string',
            'image' => 'file|max:512',
            'project_date' => 'required|date',
        ], [
            'image.max' => 'File harus berukuran 500 kb'
        ]);

        if (Portofolio::where('user_id', $user->id)->exists()) {
            return response()->json([
                'message' => 'Sudah mengisi portofolio'
            ], 409);
        }
    
        $portofolio->user_id = $user->id;
        $portofolio->name = $validatedData['name'];
        $portofolio->link = $validatedData['link'];
        $portofolio->keterangan = $validatedData['keterangan'];
        
        if($request->hasFile('image')) {
            if ($portofolio->image) {
                $profilePhotoPath = 'images/portofolio/' . $portofolio->image;
                Storage::disk('public')->delete($profilePhotoPath);
            }

            $image = $userName . '-' . $timestamp . '.' . $request->file('image')->getClientOriginalExtension();
            $filePath = 'images/portofolio/' . $image; 
            Storage::disk('public')->put($filePath, file_get_contents($request->file('image')));

            $portofolio->image = $image;
        }

        $portofolio->project_date = $validatedData['project_date'];
        $portofolio->save();

        return response()->json([
            'message' => 'Berhasil mengisi portofolio',
            'data' => [
                'id' => $portofolio->id,
                'user_id' => $portofolio->user_id,
                'name' => $portofolio->name,
                'link' => $portofolio->link,
                'keterangan' => $portofolio->keterangan,
                'image' => $portofolio->image,
                'project_date' => $portofolio->project_date
            ]
        ], 200);
    }

    public function updatePortofolio(Request $request, string $id)
    {
        $portofolio = Portofolio::find($id);
        $user = Auth::user();

        $validatedData = $request->validate([
            'name' => 'string',
            'link' => 'string',
            'keterangan' => 'string',
            'image' => 'file|max:512',
            'project_date' => 'date'
        ], [
            'image.max' => 'File harus berukuran 500 kb'
        ]);

        if (!$portofolio) {
            return response()->json([
                'message' => 'Belum mengisi portofolio'
            ], 404);
        } elseif ($portofolio->user_id !== $user->id) {
            return response()->json([
                "message" => "Tidak bisa mengedit portofolio ini"
            ], 403);
        }

        if($request->hasFile('image')) {
            if ($portofolio->image) {
                $profilePhotoPath = 'images/portofolio/' . $portofolio->image;
                Storage::disk('public')->delete($profilePhotoPath);
            }
            $userName = slugify($user->name);
            $timestamp = now()->timestamp;
            $image = 'porto-' . $userName . '-' . $timestamp . '.' . $request->file('image')->getClientOriginalExtension();
            $filePath = 'images/portofolio/' . $image; 
            Storage::disk('public')->put($filePath, file_get_contents($request->file('image')));
            $validatedData['image'] = $image;
        }

        $portofolio->update($validatedData);

        return response()->json([
            "message" => "Berhasil mengubah data portofolio",
            "data" => [
                'user_id' => $portofolio->user_id,
                'name' => $portofolio->name,
                'link' => $portofolio->link,
                'keterangan' => $portofolio->keterangan,
                'image' => $portofolio->image,
                'project_date' => $portofolio->project_date
            ]
        ], 200);
    }
    
    public function destroyPortofolio()
    {
        $user_id = auth()->id();
        $portofolio = Portofolio::where('user_id', $user_id)->first();

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
<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{

    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 5);
        $search = $request->input('search', '');
        $order_by = $request->input('order_by', 'name');
        $direction = $request->input('direction', 'asc');
        $user = User::select('name', 'email', 'profile_photo_path')
            ->where('name', 'like', '%' . $search . '%')
            ->orderBy($order_by, $direction)
            ->paginate($perPage);
        return response()->json([
            'data' => $user,
            'meta' => [
                'current_page' => $user->currentPage(),
                'per_page' => $user->perPage(),
                'total' => $user->total(),
                'from' => $user->firstItem(),
            ],
        ], 200);
    }

    public function show(string $id)
    {
        $user = User::select('name', 'email', 'profile_photo_path')
            ->where('id', $id)->first();
        return response()->json([
            "data" => $user
        ], 200);
    }

    public function upload(Request $request)
    {
        $user = Auth::user();
        $userName = $user->name;
        $timestamp = now()->timestamp;
        $rules = ['profile_photo_path' => 'required|file|max:500'];
    
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(
                [
                    'message' => 'Please fill in the form correctly',
                    'data' => $validator->errors(),
                ],
                400
            );
        }
    
        if($request->hasFile('profile_photo_path')) {
            if ($user->profile_photo_path) {
                $profilePhotoPath = 'profile/' . $user->profile_photo_path;
                Storage::disk('public')->delete($profilePhotoPath);
            }

            $image = $userName . $timestamp . '.' . $request->file('profile_photo_path')->getClientOriginalExtension();
            $filePath = 'profile/' . $image; 
            Storage::disk('public')->put($filePath, file_get_contents($request->file('profile_photo_path')));
            $user->profile_photo_path = $image;
            $user->save();

            return response()->json([
                'message' => 'Image uploaded successfully',
            ], 200);
        }
    }
}
