<?php

namespace App\Http\Controllers;

use App\Models\Token_User;
use App\Models\User;
use Carbon\Carbon;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Psy\Util\Str;

class AuthController extends Controller
{
    public function register(Request $request){

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => ['required', Password::min(8)->symbols()->letters()->numbers()],
        ]);

        $user = new User();
        $user = $request;
        $user->save();

        return response()->json([
            'message' => 'user success create;'
        ], 201);
    }

    public function login(Request $request){
        $check_user = $request->only(['email', 'password']);

        if(!$check_user ||!Auth::attempt($check_user)){
            return response()->json([
                'error' => 'invalid credentials',
            ],401);
        }

        $user = Auth::user();

        if($user->token)
            $user->token->delete();

        $token = \Illuminate\Support\Str::uuid();

        Token_User::create([
            'user_id' => $user->user_id,
            'token' => $token,
            'expired_time' => Carbon::now()->addMinute(30),
        ]);

        return \response()->json([
            'token' => $token,
            'user' => $user,
            'token_type' => 'Bearer',
        ]);

    }
}
