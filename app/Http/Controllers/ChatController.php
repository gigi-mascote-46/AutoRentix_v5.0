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
            'message'     => 'required|string',
        ]);

        if (!$admin || $request->receiver_id != $admin->id) {
            return response()->json(['error' => 'You can only send messages to the admin.'], 403);
        }

        $message = Message::create([
            'sender_id'   => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'message'     => $request->message,
        ]);

        broadcast(new MessageSent($message))->toOthers();

        return ['status' => 'Message Sent!'];
    }
}
