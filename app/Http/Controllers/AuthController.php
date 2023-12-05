<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{       

    public function register(RegisterRequest $request){
        $request->validated();
        $userdata=[
            'name' => $request->name,
            'username'=> $request->username,
            'email'=> $request->email,
            'password'=> Hash::make($request->password),
        ];
        $user  = User::create($userdata);
        $token = $user->createToken('forumapp')->plainTextToken;
        return response([
            'message'=> 'register success',
            'user'=> $user,
            'token'=> $token,
        ],200);
    }
    public function login(LoginRequest $request){
        $request->validated();
        $user = User::where('username', $request->username)->first();
        if(!$user||!Hash::check($request->password, $user->password )){
            return response([
                'message'=> 'invalid',
            ],422);
        }
        $token = $user->createToken('forumapp')->plainTextToken;
        return response([
            'message'=> 'login success',
            'user'=> $user,
            'token'=> $token,
        ],200);
    }
    }

