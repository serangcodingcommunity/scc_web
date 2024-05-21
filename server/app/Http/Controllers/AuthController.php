<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'name' => ['required'],
            'email' => ['required', 'email','unique:users'],
            'password' => ['required', 'min:8'],
            'password_confirmation' => ['required', 'same:password']
        ]);

        $userExists = User::where('email', $request->input('email'))->exists();
        if ($userExists) {
            return response()->json([
                'message' => 'Email sudah terdaftar'
            ], 409);
        }

        if (strlen($request->input('password')) < 8) {
            return response()->json([
                'message' => 'Kata sandi minimal harus 8 karakter'
            ], 422);
        }

        if ($request->input('password') !== $request->input('password_confirmation')) {
            return response()->json([
                'message' => 'Kata sandi tidak sesuai'
            ], 422);
        }

        $data = $request->all();
        $data['password'] = bcrypt($data['password']);

        $user = User::create($data);

        $success['token'] = $user->createToken('auth_token')->plainTextToken;
        $success['user'] = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email
        ];

        return response()->json([
            "message" => "Pengguna berhasil dibuat",
            "data" => [
                "name" => $user->name,
                "email" => $user->email
            ]
        ], 201);
    }

    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            /** @var \App\Models\User $user */
            $user = Auth::user();

            // $user->access_token = bin2hex(random_bytes(32));
            // $user->save();

            // $success['token'] = $user->access_token;
            // $success['name'] = $user->name;

            $success['token'] = $user->createToken('auth_token')->plainTextToken;
            $success['name'] = $user->name;

            // return response()->json([
            //     "message" => "User logged in successfully",
            //     "data" => $success
            // ])->header('Authorization', 'Bearer ' . $user->access_token); // Menambahkan header Authorization

            return response()->json([
                "msg" => "User logged in successfully",
                "data" => $success
            ]);
        } else {
            if (!User::where('email', $request->email)->exists()) {
                return response()->json([
                    "message" => "Email belum terdaftar"
                ], 401);
            } else {
                return response()->json([
                    "message" => "Email atau kata sandi salah"
                ], 401);
            }
        }
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            "message" => "Pengguna berhasil logout"
        ]);

        if ($request->user()) {
            return response()->json([
                "data" => "ok"
            ], 200);
        } else {
            return response()->json([
                "message" => "Unauthorized"
            ], 401);
        }

    }

    public function resetPassword(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'email' => ['required', 'email'],
            'password' => ['required'],
            'password_confirmation' => ['required', 'same:password']
        ]);

        if ($request->input('password') !== $request->input('password_confirmation')) {
            return response()->json([
                'message' => 'Kata sandi tidak sesuai'
            ], 422);
        }
    
        $user = User::where('email', $request->input('email'))->first();
        if (!$user) {
            return response()->json([
                'message' => 'Email belum terdaftar'
            ], 404);
        }
    
        if (Hash::check($request->input('password'), $user->password)) {
            return response()->json([
                'message' => 'Kata sandi tidak boleh sama dengan yang lama'
            ], 422);
        }
    
        if (strlen($request->input('password')) < 8) {
            return response()->json([
                'message' => 'Kata sandi minimal 8 karakter'
            ], 422);
        }
    
        $user->password = bcrypt($request->input('password'));
        $user->save();
    
        return response()->json([
            'data' => [
                'name' => $user->name
            ]
        ], 200);
    }

    public function refreshGithub(): JsonResponse
    {
        $url = Socialite::driver('github')->stateless()->redirect()->getTargetUrl();
        
        return response()->json([
            'url' => $url,
        ]);
    }

    public function refreshGoogle(): JsonResponse
    {
        $url = Socialite::driver('google')->stateless()->redirect()->getTargetUrl();
        
        return response()->json([
            'url' => $url,
        ]);
    }

    public function callbackGoogle()
    {
        $socialUser = Socialite::driver('google')->stateless()->user();
        $registeredUser = User::where('email', $socialUser->email)->first();
        
        if (!$registeredUser) {
            $user = User::create([
                'name' => $socialUser->name,
                'email' => $socialUser->email,
                'google_id' => $socialUser->id,
                'password' => bcrypt('GlorySCC2024'),
            ]);
    
            $token = $user->createToken('auth_token')->plainTextToken;
            Auth::login($user);
    
            return response()->json([
                "message" => "User created successfully",
                "data" => [
                    "token" => $token
                ]
            ], 201);
        } else {
            if ($registeredUser->github_id) {
                $registeredUser->update([
                    'google_id' => $socialUser->id,
                ]);
            }
    
            $token = $registeredUser->createToken('auth_token')->plainTextToken;
            return response()->json([
                "message" => "User logged in successfully",
                "data" => [
                    "token" => $token
                ]
            ]);
        }
    }
    
    public function callbackGithub()
    {
        $socialUser = Socialite::driver('github')->stateless()->user();
        $registeredUser = User::where('email', $socialUser->email)->first();
        
        if (!$registeredUser) {
            $user = User::create([
                'name' => $socialUser->name,
                'email' => $socialUser->email,
                'github_id' => $socialUser->id,
                'password' => bcrypt('GlorySCC2024'),
            ]);
    
            $token = $user->createToken('auth_token')->plainTextToken;
            Auth::login($user);
    
            return response()->json([
                "message" => "User created successfully",
                "data" => $socialUser->id
            ], 201);

            // return redirect('/dashboard');
        }

        return response()->json([
            "message" => "User logged in successfully",
        ]);
    }
}
