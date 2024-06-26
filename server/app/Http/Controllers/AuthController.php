<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'name' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required'],
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
        // $data['access_token'] = bin2hex(random_bytes(32));

        $user = User::create($data);

        $success['token'] = $user->createToken('auth_token')->plainTextToken;
        $success['name'] = $user->name;

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

    public function refresh()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        $socialUser = Socialite::driver('google')->user();

        $registeredUser = User::where('google_id', $socialUser->id)->first();

        if (!$registeredUser) {
            $user = User::updateOrCreate([
                'google_id' => $socialUser->id,
            ], [
                'name' => $socialUser->name,
                'email' => $socialUser->email,
                'password' => bcrypt('KucingMerah2024')
            ]);

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
