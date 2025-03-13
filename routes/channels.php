<?php

use App\Models\Chat;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('notifications.{id}', function ($user) {
    return $user;
});

Broadcast::channel('chat-room.{chat_id}', function ($user, $chatId) {
    return Chat::query()
        ->where('id', $chatId)
        ->where(function (Builder $query) use ($user) {
            $query->where('user_one_id', $user->id)
                ->orWhere('user_two_id', $user->id);
        })->exists();
});
