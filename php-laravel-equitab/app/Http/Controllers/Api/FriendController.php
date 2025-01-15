<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use DB;
use Symfony\Component\HttpFoundation\Response;

class FriendController extends Controller
{
    public function index(): array
    {
        return ['data' => auth()->user()->friends()->paginate()];
    }

    public function show(User $friend) {
        /** @var User $user */
        $user = auth()->user();

        if (!$user->friends()->where('users.id', $friend->id)->exists()) {
            return response([
                'error' => [
                    'type' => 'Not friends',
                    'message' => 'You aren\'t friends with this user.'
                ]
            ], Response::HTTP_FORBIDDEN);
        }

        return ['data' => $friend];
    }

    public function destroy(User $friend)
    {
        /** @var User $user */
        $user = auth()->user();

        if (!$user->friends()->where('users.id', $friend->id)->exists()) {
            return response([
                'error' => [
                    'type' => 'Not friends',
                    'message' => 'You aren\'t even friends in the first place!'
                ]
            ], Response::HTTP_OK);
        }

        DB::transaction(function () use ($user, $friend) {
            $user->friends()->detach($friend);
            $friend->friends()->detach($user);
        });

        return [
            'data' => [
                'message' => 'Friend removed.'
            ]
        ];

    }
}
