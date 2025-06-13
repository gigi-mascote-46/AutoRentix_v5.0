# 📡 Chat em Tempo Real com Laravel + Vue (Inertia) + Redis + Pusher

Este projeto permite criar uma aplicação de chat em tempo real utilizando **Laravel** com **Inertia.js**, **Vue 3**, **Redis** e **Laravel Echo Server** (via **Pusher** como driver de broadcast).

---

## 🛠️ Pré-requisitos

- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL
- Redis
- Laravel
- Inertia.js
- Vue 3
- Laravel Echo
- Laravel Echo Server
- Pusher (chaves ou servidor local)

---

## 1️⃣ Instalar Laravel

```bash
composer create-project laravel/laravel chat-app
cd chat-app
```

---

## 2️⃣ Configurar Inertia + Vue

```bash
composer require inertiajs/inertia-laravel
npm install @inertiajs/inertia @inertiajs/inertia-vue3 vue@^3
```

Cria o `app.js` e o layout base `GuestLayout.vue`.

---

## 3️⃣ Autenticação (Laravel Breeze)

```bash
composer require laravel/breeze --dev
php artisan breeze:install vue
npm install && npm run dev
php artisan migrate
```

---

## 4️⃣ Criar Modelo e Migration das Mensagens

```bash
php artisan make:model Message -m
```

### 🔧 Migration

```php
Schema::create('messages', function (Blueprint $table) {
    $table->id();
    $table->foreignId('sender_id')->constrained('users')->onDelete('cascade');
    $table->foreignId('receiver_id')->constrained('users')->onDelete('cascade');
    $table->text('message');
    $table->timestamps();
});
```

```bash
php artisan migrate
```

---

## 5️⃣ Controlador do Chat

```bash
php artisan make:controller ChatController
```

### `ChatController.php`

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
```

---

## 6️⃣ Criar Evento `MessageSent`

```bash
php artisan make:event MessageSent
```

### `MessageSent.php`

```php
use Illuminate\Broadcasting\PrivateChannel;

public function broadcastOn()
{
    return new PrivateChannel('chat.' . $this->message->receiver_id);
}
```

---

## 7️⃣ Criar o Componente Vue `Chat.vue`

```vue
<template>
  <div class="chat">
    <h2>Chat</h2>
    <div v-for="msg in messages" :key="msg.id">
      <strong>{{ msg.sender_id === userId ? 'Eu' : 'Outro' }}:</strong> {{ msg.message }}
    </div>
    <input v-model="newMessage" @keyup.enter="sendMessage" placeholder="Mensagem..." />
  </div>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import Echo from 'laravel-echo';

const props = defineProps(['contacts']);
const messages = ref([]);
const newMessage = ref('');
const receiverId = ref(props.contacts[0]?.id);
const userId = window.Laravel.user.id;

onMounted(() => {
  loadMessages();
  window.Echo.private(`chat.${userId}`)
    .listen('MessageSent', (e) => {
      messages.value.push(e.message);
    });
});

function loadMessages() {
  axios.get(`/chat/messages/${receiverId.value}`).then(res => {
    messages.value = res.data;
  });
}

function sendMessage() {
  axios.post('/chat/send', {
    receiver_id: receiverId.value,
    message: newMessage.value,
  }).then(() => {
    messages.value.push({
      sender_id: userId,
      message: newMessage.value
    });
    newMessage.value = '';
  });
}
</script>
```

---

## 8️⃣ Configurar Laravel Echo + Laravel Echo Server

```bash
npm install --save laravel-echo socket.io-client
npm install -g laravel-echo-server
```

---

## 9️⃣ Criar `laravel-echo-server.json`

```json
{
  "authHost": "http://127.0.0.1:8000",
  "authEndpoint": "/broadcasting/auth",
  "clients": [
    {
      "appId": "2005504",
      "key": "b8a6503396759bc82ae6f",
      "secret": "2e28bb8f46f24386ce1f"
    }
  ],
  "database": "redis",
  "databaseConfig": {
    "redis": {},
    "sqlite": {
      "databasePath": "/database/laravel-echo-server.sqlite"
    }
  },
  "devMode": true,
  "host": "127.0.0.1",
  "port": "6001",
  "protocol": "http",
  "subscribers": {
    "http": true,
    "redis": true
  },
  "apiOriginAllow": {
    "allowCors": true,
    "allowOrigin": "*",
    "allowMethods": "GET, POST",
    "allowHeaders": "Origin, Content-Type, Accept, Authorization, X-Request-With"
  }
}
```

---

## 🔟 `.env` (Pusher Local)

```env
BROADCAST_DRIVER=pusher
QUEUE_CONNECTION=redis

PUSHER_APP_ID=2005504
PUSHER_APP_KEY=b8a6503396759bc82ae6f
PUSHER_APP_SECRET=2e28bb8f46f24386ce1f
PUSHER_HOST=127.0.0.1
PUSHER_PORT=6001
PUSHER_SCHEME=http
PUSHER_APP_CLUSTER=mt1
```

---

## 🔁 Iniciar Redis

### Ubuntu/macOS:
```bash
redis-server
```

### Windows com Docker:
```bash
docker run --name redis -p 6379:6379 -d redis
```

---

## ▶️ Iniciar os serviços

```bash
php artisan queue:work
laravel-echo-server start
npm run dev
php artisan serve
```

---

## ✅ Testar o Chat

1. Autentica-te com 2 utilizadores diferentes em 2 janelas do navegador.
2. Vai para `/chat`
3. Envia mensagens — o outro utilizador deverá vê-las em tempo real.

---

## 📁 Rotas web.php

```php
use App\Http\Controllers\ChatController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/chat', [ChatController::class, 'index'])->name('chat');
    Route::get('/chat/messages/{user}', [ChatController::class, 'fetchMessages']);
    Route::post('/chat/send', [ChatController::class, 'sendMessage']);
});
```

---

## 🧠 Notas Finais

- Este sistema é baseado em canais privados.
- Usa `window.Echo.private(...)` e `broadcastOn()` com `PrivateChannel`.
- Garante que estás autenticado e com a `BroadcastServiceProvider` ativa.

---

## ❓Problemas Comuns

| Problema                          | Solução                              |
|-----------------------------------|---------------------------------------|
| `View [layouts.app] not found`    | Usa Inertia e `Inertia::render()`    |
| Redis não inicia                  | Verifica se o Redis está instalado   |
| Mensagens não chegam              | Garante que Echo Server está ativo   |

---

Feito com ❤️ por [O Teu Nome Aqui]
