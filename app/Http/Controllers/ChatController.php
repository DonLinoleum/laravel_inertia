<?php

namespace App\Http\Controllers;

use App\Events\MessageSentEvent;
use App\Models\Chat;
use App\Models\Message;
use App\Services\ChatService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ChatController extends Controller
{
    protected ChatService $chatService;
    public function __construct(ChatService $chatService)
    {
        $this->chatService = $chatService;
    }
    public function index()
    {
        $chats = $this->chatService->getAllChats();
        return Inertia::render("Chats/Index", compact('chats'));
    }

    public function createChat(Request $request)
    {
        $chat = $this->chatService->createChat($request);
        return redirect(route('chats.detail', $chat->id))->with('msg', 'success');
    }

    public function detail(int $chatId)
    {
        $authUserId = Auth::id();
        $chat = Chat::query()
            ->where('id', $chatId)
            ->with("messages", "userOne", "userTwo")
            ->first();
        $otherUser = null;
        if ($chat->user_one_id == $authUserId)
            $otherUser = $chat->userTwo;
        else
            $otherUser = $chat->userOne;
        return Inertia::render("Chats/Detail/Index", compact('chat', 'otherUser'));
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
            'chat_id' => 'required|integer'
        ]);

        $message = Message::query()->create([
            'from_user_id' => auth()->id(),
            'to_user_id' => $request->input('user_id'),
            'chat_id' => $request->input('chat_id'),
            'message' => $request->input('message'),
        ]);
        broadcast(new MessageSentEvent($message))->toOthers();
    }
}
