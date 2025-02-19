<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $data = $request->validate([
            'username' => 'required',
            'password' => 'required',
            'device_name' => 'required'
        ]);

        if (!auth()->attempt(collect($data)->forget('device_name')->toArray())) {
            return response([
                'error' => [
                    'type' => 'Invalid credentials',
                    'message' => 'The username or password provided is incorrect.'
                ]
            ], Response::HTTP_BAD_REQUEST);
        }

        $user = auth()->user();

        return [
            'message' => 'Logged in successfully.',
            'data' => [
                'token' => $user->createToken($request->device_name . " @ " . $request->ip())->plainTextToken,
                'user' => new UserResource($user),
            ]
        ];
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Logged out successfully.'
        ];
    }
}
