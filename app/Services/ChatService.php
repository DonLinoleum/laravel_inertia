<?php

namespace App\Services;

use App\Models\Chat;
use App\Models\Message;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatService
{
    public function getAllChats()
    {
        $authUserId = auth()->user()->id;
        $chats = Chat::query()
            ->where('user_one_id', $authUserId)
            ->orWhere('user_two_id', $authUserId)
            ->with(['userOne', 'userTwo'])
            ->get();

        return $chats->map(function ($chat) use ($authUserId) {
            $otherUserId = $chat->user_one_id == $authUserId ? $chat->user_two_id : $chat->user_one_id;
            $lastMessage = Message::query()
                ->where('chat_id', $chat->id)
                ->orderBy('created_at', 'desc')
                ->first();

            return [
                'chat_id' => $chat->id,
                'other_user' => $otherUserId,
                'other_user_info' => $chat->user_one_id == $authUserId ? $chat->userTwo : $chat->userOne,
                'last_message' => $lastMessage
            ];
        });
    }

    public function createChat(Request $request)
    {
        $authUserId = Auth::id();
        $chat = Chat::query()->where(function (Builder $query) use ($authUserId, $request) {
            $query
                ->where('user_one_id', $authUserId)
                ->where('user_two_id', $request->friend_id);
        })
            ->orWhere(function (Builder $query) use ($authUserId, $request) {
                $query
                    ->where('user_one_id', $request->friend_id)
                    ->where('user_two_id', $authUserId);
            })->first();
        if (!$chat) {
            return Chat::query()->create([
                "user_one_id" => $authUserId,
                "user_two_id" => $request->friend_id
            ]);
        }
        return $chat;
    }
}