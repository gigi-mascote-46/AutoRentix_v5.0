<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Events\MessageSent;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ChatController extends Controller
{
public function index()
{
    $admin = User::where('role', 'admin')->first();
    return Inertia::render('Chat/Index', [
        'contacts' => $admin ? collect([$admin]) : collect([]),
    ]);
}

    public function fetchMessages(User $user)
    {
        $me = Auth::id();
        $admin = User::where('role', 'admin')->first();

        if (!$admin || ($user->id !== $admin->id && $me !== $admin->id)) {
            return response()->json([], 403); // Forbidden if not admin or chatting with admin
        }

        $messages = Message::where(function($q) use($me, $user) {
                $q->where('sender_id', $me)->where('receiver_id', $user->id);
            })->orWhere(function($q) use($me, $user) {
                $q->where('sender_id', $user->id)->where('receiver_id', $me);
            })
            ->orderBy('created_at')
            ->get();

        return response()->json($messages);
    }

    public function sendMessage(Request $request)
{
    $admin = User::where('role', 'admin')->first();

    $request->validate([
        'receiver_id' => 'required|exists:users,id',
        'message'     => 'required|string|max:1000',
    ]);

    if (!$admin || $request->receiver_id != $admin->id) {
        return response()->json(['error' => 'You can only send messages to the admin.'], 403);
    }

    // Allow guests (sender_id null)
    $senderId = Auth::id(); // null if guest

    // Save user's message
    $userMessage = Message::create([
        'sender_id'   => $senderId,
        'receiver_id' => $request->receiver_id,
        'message'     => $request->message,
    ]);

    // Broadcast user message for real-time updates
    broadcast(new MessageSent($userMessage))->toOthers();

    // Call OpenAI to get AI response
    $openAiService = app(\App\Services\OpenAiService::class);
    $aiResponseText = $openAiService->sendMessage($request->message);

    if ($aiResponseText) {
        // Save AI reply as message from admin to sender (or fallback to admin)
        $aiMessage = Message::create([
            'sender_id'   => $admin->id,
            'receiver_id' => $senderId ?? $admin->id,
            'message'     => $aiResponseText,
        ]);

        broadcast(new MessageSent($aiMessage))->toOthers();
    }

    return response()->json([
        'status' => 'Message Sent!',
        'user_message' => $userMessage,
        'ai_response_message' => $aiMessage ?? null,
    ]);
}
}
