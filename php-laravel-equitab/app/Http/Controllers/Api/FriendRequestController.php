<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use DB;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FriendRequestController extends Controller
{
    public function index(Request $request)
    {
        $request->validate(['type' => 'required|in:incoming,outgoing']);

        /** @var User $user */
        $user = auth()->user();

        return ['data' => ($request->type == 'incoming' ? $user->incoming_friends() : $user->outgoing_friends())->paginate()];
    }

    public function store(User $friend)
    {
        /** @var User $user */
        $user = auth()->user();

        if ($user->id === $friend->id) {
            return response([
                'error' => [
                    'type' => 'You can\'t befriend yourself',
                    'message' => 'You can\'t add friends with yourself!'
                ]
            ], Response::HTTP_BAD_REQUEST);
        }

        if ($user->friends()->where('friend_id', $friend->id)->exists()) {
            return response([
                'error' => [
                    'type' => 'Already friends',
                    'message' => 'You\'re already friends with this user.'
                ]
            ], Response::HTTP_BAD_REQUEST);
        }

        if ($user->outgoing_friends()->where('users.id', $friend->id)->exists()) {
            return response([
                'error' => [
                    'type' => 'Friend request already sent',
                    'message' => 'You\'ve already sent a friend request to this user, please wait for their response'
                ]
            ], Response::HTTP_BAD_REQUEST);
        }

        if ($user->incoming_friends()->where('users.id', $friend->id)->first()) {
            DB::transaction(function () use ($user, $friend) {
                $user->incoming_friends()->detach($friend);

                $user->friends()->attach($friend);
                $friend->friends()->attach($user);
            });

            return response([
                'data' => [
                    'message' => 'Friend added successfully!'
                ]
            ], Response::HTTP_CREATED);
        } else {
            $user->outgoing_friends()->attach($friend);

            return response([
                'data' => [
                    'message' => 'Friend request sent.'
                ]
            ], Response::HTTP_CREATED);
        }
    }

    public function destroy(User $friend)
    {
        /** @var User $user */
        $user = auth()->user();

        $outgoing = $user->outgoing_friends()->where('to_user_id', $friend->id)->first();
        $incoming = $user->incoming_friends()->where('from_user_id', $friend->id)->first();

        if ($outgoing) {
            $user->outgoing_friends()->detach($friend);

            return [
                'data' => [
                    'message' => 'Friend request cancelled.'
                ]
            ];
        } else if ($incoming) {
            $user->incoming_friends()->detach($friend);

            return [
                'data' => [
                    'message' => 'Friend request rejected.'
                ]
            ];
        } else {
            return response([
                'error' => [
                    'type' => 'Not Found Error',
                    'message' => 'Friend request not found.'
                ]
            ], Response::HTTP_NOT_FOUND);
        }
    }
}
