4️⃣ Criar Modelo e Migration das Mensagens

```bash

php artisan make:model Message -m

🔧 Migration:

```bash
Schema::create('messages', function (Blueprint $table) {
    $table->id();
    $table->foreignId('sender_id')->constrained('users')->onDelete('cascade');
    $table->foreignId('receiver_id')->constrained('users')->onDelete('cascade');
    $table->text('message');
    $table->timestamps();
});

---


```bash

php artisan migrate
