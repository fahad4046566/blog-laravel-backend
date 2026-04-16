<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\UserResource;


class AuthController extends Controller
{
    function register(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
        ];

        $messages = [
            'name.required' => 'Name field is required',
            'email.required' => 'Email field is required',
            'email.email' => 'Please enter a valid email address',
            'email.unique' => 'This email is already taken',
            'password.min' => 'Password must be at least 8 characters',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        $input = $request->only(['name', 'email', 'password']);
        $input["password"] = bcrypt($input["password"]);
        $user = User::create($input);
        return response()->json([
            'success' => true,
            'result' => [
                'token' => $user->createToken('myApp')->plainTextToken,
                'user' => new UserResource($user)
            ]
        ], 201);
    }
    function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                "success" => false,
                "result" => [
                    "message" => "Invalid email or password"
                ]
            ],401);
        }

        return response()->json([
            'success' => true,
            'result' => [
                'token' => $user->createToken('myApp')->plainTextToken,
               'user' => new UserResource($user)
            ]
        ], 200);
    }


    function logout(Request $request)
    {
        if ($request->user()) {
            $request->user()->tokens()->delete();
        }

        return response()->json([
            'success' => true,
            'message' => 'Logged out from all devices'
        ], 200);
    }
}
