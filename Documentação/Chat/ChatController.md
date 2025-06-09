5️⃣ Controlador do Chat

```bash

php artisan make:controller ChatController


- ChatController.php

```php

public function index()
{
    $contacts = User::where('id', '!=', Auth::id())->get();
    return Inertia::render('Chat', ['contacts' => $contacts]);
}

public function fetchMessages(User $user)
{
    $me = Auth::id();
    $messages = Message::where(function ($q) use ($me, $user) {
        $q->where('sender_id', $me)->where('receiver_id', $user->id);
    })->orWhere(function ($q) use ($me, $user) {
        $q->where('sender_id', $user->id)->where('receiver_id', $me);
    })->orderBy('created_at')->get();

    return response()->json($messages);
}

public function sendMessage(Request $request)
{
    $message = Message::create([
        'sender_id' => Auth::id(),
        'receiver_id' => $request->receiver_id,
        'message' => $request->message
    ]);

    broadcast(new MessageSent($message))->toOthers();

    return ['status' => 'Message Sent!'];
}



