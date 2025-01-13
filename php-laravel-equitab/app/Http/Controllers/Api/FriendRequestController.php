<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FriendRequest;
use App\Models\Friendship;
use App\Models\User;
use DB;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Http\Request;

class FriendRequestController extends Controller
{
    public function index(Request $request)
    {
        $request->validate(['type' => 'required|in:incoming,outgoing']);

        /** @var User $user */
        $user = auth()->user();

        $paginate = $request->type == 'incoming'
            ? $user->incoming_friends()->paginate(25)
            : $user->outgoing_friends()->paginate(25);

        return [
            'data' => [
                'users' => $paginate->items(),
                'page' => $paginate->currentPage(),
                'pages' => $paginate->lastPage(),
                'per_page' => $paginate->perPage(),
            ]
        ];
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
            ], \Symfony\Component\HttpFoundation\Response::HTTP_BAD_REQUEST);
        }

        if ($user->friends()->where('friend_id', $friend->id)->exists()) {
            return response([
                'error' => [
                    'type' => 'Already friends',
                    'message' => 'You\'re already friends with this user.'
                ]
            ], \Symfony\Component\HttpFoundation\Response::HTTP_BAD_REQUEST);
        }

        if ($user->outgoing_friends()->where('users.id', $friend->id)->exists()) {
            return response([
                'error' => [
                    'type' => 'Friend request already sent',
                    'message' => 'You\'ve already sent a friend request to this user, please wait for their response'
                ]
            ], \Symfony\Component\HttpFoundation\Response::HTTP_BAD_REQUEST);
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
            ], \Symfony\Component\HttpFoundation\Response::HTTP_CREATED);
        } else {
            $user->outgoing_friends()->attach($friend);

            return response([
                'data' => [
                    'message' => 'Friend request sent.'
                ]
            ], \Symfony\Component\HttpFoundation\Response::HTTP_CREATED);
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
            ], \Symfony\Component\HttpFoundation\Response::HTTP_NOT_FOUND);
        }
    }
}
