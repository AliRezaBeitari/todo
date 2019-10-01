<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\User;

class AuthController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:api');
    }


    /**
     * Create a new user instance after a valid registration.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'api_token' => Str::random(80),
        ]);

        return [
            'ok' => true,
            'api_token' => $user->api_token,
        ];
    }


    /**
     * Attemp to login a user.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (! $user) {
            return response([ 'message' => 'Unauthorized. Check your credentials.' ], 401);
        }

        $auth = Hash::check($credentials['password'], $user->password);

        if (! $auth) {
            return response([ 'message' => 'Unauthorized. Check your credentials.' ], 401);
        }

        if (! $user->api_token) {
            $user->api_token = Str::random(80);
            $user->save();
        }

        return [
            'ok' => true,
            'api_token' => $user->api_token,
        ];
    }
}
