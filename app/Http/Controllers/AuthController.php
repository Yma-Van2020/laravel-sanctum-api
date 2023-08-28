<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request){
        $fields = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed'
        ]);

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password'])
        ]);

        //if all passes
        $token = $user->createToken('myapptoken')->plainTextToken;
        $cookie = cookie('api_token', $token, 60*20); //1 day

        return response([
            'user' => $user,
            'message' => 'Logged in'
        ])->withCookie($cookie);
    }

    public function login(Request $request){
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        //check email
        $user = User::where('email', $fields['email'])->first();

        //check password
        if(!$user || !Hash::check($fields['password'], $user->password)){
            return new Response([
                'message' => 'Bad creds'
            ], 401);
        };

        //if all passes
        $token = $user->createToken('myapptoken')->plainTextToken;
        $cookie = cookie('api_token', $token, 60*20); //1 day

        return response([
            'user' => $user,
            'message' => 'Logged in'
        ])->withCookie($cookie);
    }
    public function logout(Request $request){
        // Check if the 'api_token' cookie exists
        if ($request->hasCookie('api_token')) {
            // Clear the 'api_token' cookie
            $cookie = cookie('api_token', null, -1);

            return response([
                'message' => 'Logged out'
            ])->withCookie($cookie);
        }

        return response([
            'message' => 'unauthenticated'
        ]);
    }

}
