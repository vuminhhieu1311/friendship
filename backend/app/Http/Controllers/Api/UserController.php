<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::where('id', '!=', Auth::id())->get();

        return response()->json([
            'users' => $users,
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return response()->json([
            'user' => $user,
            'isFriendsWith' => request()->user()->is_friends_with($user->id),
            'friendRequestSentTo' => request()->user()->has_pending_friend_request_sent_to($user->id),
            'friendRequestSentFrom' => request()->user()->has_pending_friend_request_from($user->id),
        ], 200);
    }
}
