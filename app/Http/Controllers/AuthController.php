<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        try {
            if (Auth::attempt($request->only('email', 'password'))) {
                $auth_user = Auth::user();
                $user = User::find($auth_user->id);
                $token = $user->createToken('app')->accessToken;

                return response([
                    'message' => 'Successfully login!',
                    'token' => $token,
                    'user' => $user
                ], 200);
            }
        } catch (Exception $exception) {
            return response([
                'message' => $exception->getMessage()
            ], 400);
        }

        return response([
            'message' => 'Invalid Email or Password'
        ], 401);
    }

    public function register(RegisterRequest $request)
    {
        try {

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);
            $token = $user->createToken('app')->accessToken;

            return response([
                'message' => 'Registration successful!',
                'token' => $token,
                'user' => $user
            ], 200);
        } catch (Exception $exception) {
            return response([
                'message' => $exception->getMessage()
            ], 400);
        }
    }
}
