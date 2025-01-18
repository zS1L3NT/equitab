<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function show(): array
    {
        return [
            'data' => new UserResource(auth()->user())
        ];
    }

    public function update(Request $request): array
    {
        /** @var User $user */
        $user = auth()->user();

        $data = $request->validate([
            'username' => Rule::unique('users')->ignore($user),
            'phone_number' => "regex:/^\+\d{1,14}$/|" . Rule::unique('users')->ignore($user),
            'picture' => 'image|mimes:jpeg,png,jpg|max:2048',
            'password' => 'min:8|confirmed',
        ]);

        if ($request->phone_number != $user->phone_number) {
            $user->phone_number_verified_at = null;
            $user->save();
        }

        $user->update($data);

        return [
            'message' => 'Profile updated successfully'
        ];
    }
}
