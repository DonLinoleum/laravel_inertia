<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Notifications\AcceptFriendRequest;
use App\Notifications\SendFriendRequest;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Illuminate\Http\Request;

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

    public function sendRequest(User $user)
    {
        $currentUser = auth()->user();
        $currentUser->subscribers()->attach($user->id, ['accepted' => false]);
        $user->notify(new SendFriendRequest($currentUser, $user));
        return redirect()->back()->with("success", "Заявка отправлена");
    }

    public function acceptRequestById(Request $request)
    {
        $currentUser = auth()->user();
        $friendship_id = $request->input("friendship_id");
        $friendship = DB::table("friends")->where('id', $friendship_id)->first();
        if ($currentUser->acceptRequestById($friendship_id)) {
            $friend = User::query()->find($friendship->friend_id);
            $friend->notify(new AcceptFriendRequest($currentUser));
            return redirect()->back();
        }
        return redirect()->back()->withErrors(['error' => 'Не удалось подтвердить заявку']);
    }
}