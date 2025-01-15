<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function show(): array
    {
        return ['data' => auth()->user()];
    }

    public function update(Request $request): array
    {
        /** @var User $user */
        $user = auth()->user();

        $data = $request->validate([
            'id' => 'prohibited',
            'username' => Rule::unique('users')->ignore($user),
            'phone_number' => "regex:/^\+\d{1,14}$/|" . Rule::unique('users')->ignore($user),
            'phone_number_verified_at' => 'prohibited',
            'picture_file' => 'image|mimes:jpeg,png,jpg|max:2048',
            'picture_path' => fn ($p, $v, $f) => $f("You cannot update 'picture_path' directly, use 'picture_file' instead!"),
            'password' => 'min:8|confirmed',
            'created_at' => 'prohibited',
            'updated_at' => 'prohibited',
        ]);

        if (request('phone_number') != $user->phone_number) {
            $user->phone_number_verified_at = null;
            $user->save();
        }

        $user->update($data);

        return [
            'data' => [
                'message' => 'User updated successfully',
                'user' => $user
            ]
        ];
    }
}
