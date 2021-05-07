<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);
        $token = $user->createToken('auth_token')->plainTextToken;
       response()->json([
       'access_token' => $token,
       'token_type' => 'Bearer',
        ]);
//        return 1;
    }
    public function login(Request $request)
    {
        $user = User::where('email', $request->input('email'))->first();
        if(!Hash::check($request->input('password'), $user->password)){
            return response()->json([
                'message' => 'Invalid login details'
            ], 401);
        }
//        $apikey = base64_encode(str_random(40));
//        Users::where('email', $request->input('email'))->update(['api_key' => "$apikey"]);;
//        $user = User::where('email', $request['email'])->firstOrFail();
//
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
      ]);
//        return  true;
    }
    public function me(Request $request)
    {
        return Auth::user();
    }
    public function logout(Request $request)
    {
//        $request->user()->currentAccessToken()->delete();
//        Auth::guard('web')->logout();
//        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }
}
