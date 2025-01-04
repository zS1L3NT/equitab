<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\InvalidCredentialsException;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * @throws InvalidCredentialsException
     */
    public function login(Request $request): array
    {
        $data = $request->validate([
            'username' => 'required',
            'password' => 'required',
            'device_name' => 'required'
        ]);

        if (!auth()->attempt(collect($data)->forget('device_name')->toArray())) {
            throw new InvalidCredentialsException;
        }

        /** @var User $user */
        $user = auth()->user();

        return [
            'data' => [
                'token' => $user->createToken(request('device_name') . " @ " . $request->ip())->plainTextToken,
                'message' => 'Logged in successfully'
            ]
        ];
    }

    public function logout(Request $request): array
    {
        $request->user()->tokens()->delete();

        return [
            'data' => [
                'message' => 'Logged out successfully'
            ]
        ];
    }
}
