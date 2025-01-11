<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\AlreadyFriendsException;
use App\Http\Controllers\Controller;
use App\Models\Friendship;
use App\Models\User;
use DB;
use Illuminate\Http\Request;

class FriendController extends Controller
{
    public function index(): array
    {
        /** @var User $user */
        $user = auth()->user();

        $paginate = $user->friends()->paginate(25);

        return [
            'data' => [
                'users' => $paginate->items(),
                'page' => $paginate->currentPage(),
                'pages' => $paginate->lastPage(),
                'per_page' => $paginate->perPage(),
            ],
        ];
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
            ], \Symfony\Component\HttpFoundation\Response::HTTP_OK);
        }

        $user->friends()->detach($friend);
        $friend->friends()->detatch($user);

        return [
            'data' => [
                'message' => 'Friend removed.'
            ]
        ];

    }
}
