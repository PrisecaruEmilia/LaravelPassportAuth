<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Mail\ForgetMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ForgetRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\RegisterRequest;

class ForgetController extends Controller
{
    public function forgetPassword(ForgetRequest $request)
    {
        $email = $request->email;

        if (User::where('email', $email)->doesntExist()) {
            return response([
                'message' => 'Email Invalid!'
            ], 401);
        }

        // generate rand token

        $token = rand(10, 100000);

        try {

            DB::table('password_resets')->insert([
                'email' => $email,
                'token' => $token
            ]);

            Mail::to($email)->send(new ForgetMail($token));

            return response([
                'message' => 'Reset Password Mail send to your email'
            ], 200);
        } catch (Exception $exception) {
            return response([
                'message' => $exception->getMessage()
            ], 400);
        }
    }
}
