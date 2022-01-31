<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ResetRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ResetController extends Controller
{
    public function resetPassword(ResetRequest $request)
    {
        $email = $request->email;
        $token = $request->token;
        $password = Hash::make($request->password);

        $emailCheck = DB::table('password_resets')->where('email', $email)->first();
        $pinCheck = DB::table('password_resets')->where('token', $token)->first();

        if (!$emailCheck) {
            return response([
                'message' => 'Email not found!'
            ], 401);
        }
        if (!$pinCheck) {
            return response([
                'message' => 'Pin Code Invalid!'
            ], 401);
        }

        DB::table('users')->where('email', $email)->update(['password' => $password]);
        DB::table('password_resets')->where('email', $email)->delete();
        return response([
            'message' => 'Password Reset Successfully!'
        ], 200);
    }
}
