<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\JsonResponse;

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

        if ($validatedData->fails()) {
            return response()->json([
                'message' => 'Invalid data',
                'errors' => $validatedData->errors()
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
            "message" => "User created successfully",
            "data" => $success
        ], 201);
    }

    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            /** @var \App\Models\User $user */
            $user = Auth::user();
            $success['token'] = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                "message" => "User logged in successfully",
                "data" => $success
            ]);
        } else {
            return response()->json([
                "message" => "Wrong Email or Password"
            ], 401);
        }
    }


    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            "message" => "User logged out successfully"
        ]);
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
                "data" => [
                    "token" => $token
                ]
            ], 201);
        } else {
            if ($registeredUser->google_id) {
                $registeredUser->update([
                    'github_id' => $socialUser->id,
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
}
