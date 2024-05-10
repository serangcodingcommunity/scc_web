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
        $user = User::all();
        return response()->json([
            "data" => $user
        ], 200);
    }

    public function show(string $id)
    {
        $user = User::find($id);
        return response()->json([
            "data" => $user
        ], 200);
    }

    public function upload(Request $request)
    {
        $user = Auth::user();
        $userName = $user->name;
        $timestamp = now()->timestamp;
        $rules = ['profile_photo_path' => 'required|file'];
    
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
