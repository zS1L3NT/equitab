<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class FriendController extends Controller
{
    public function index()
    {
        return UserResource::collection(auth()->user()->friends()->paginate());
    }

    public function show(User $friend)
    {
        if (auth()->user()->friends()->where('users.id', $friend->id)->doesntExist()) {
            throw new ModelNotFoundException()->setModel(User::class);
        }

        return [
            'data' => new UserResource($friend)
        ];
    }

    public function destroy(User $friend)
    {
        /** @var User $user */
        $user = auth()->user();

        if ($user->friends()->where('users.id', $friend->id)->doesntExist()) {
            throw new ModelNotFoundException()->setModel(User::class);
        }

        DB::transaction(function () use ($user, $friend) {
            $user->friends()->detach($friend);
            $friend->friends()->detach($user);
        });

        return [
            'message' => 'Friend removed.'
        ];
    }
}
