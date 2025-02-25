<?php

namespace App\Http\Controllers;
use Inertia\Inertia;

class FriendController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $friends = $user->getAllFriends();
        $users = $user->allUsersExcludingRelations();
        $subscriptions = $user->subscriptions;
        $subsribers = $user->subscribers;
        return Inertia::render("Friends/Index", compact('friends', 'users', 'subscriptions', 'subsribers'));
    }
}