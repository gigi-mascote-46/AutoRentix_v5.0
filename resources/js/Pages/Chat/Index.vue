<script setup>
import { ref, onMounted, watch } from 'vue';
import { router } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

const props = defineProps({
  contacts: Array
});

const selectedUser = ref(null);
const messages = ref([]);
const newMessage = ref('');

const fetchMessages = async (user) => {
  selectedUser.value = user;
  const response = await axios.get(`/chat/${user.id}/messages`);
  messages.value = response.data;
};

const sendMessage = async () => {
  if (!newMessage.value.trim()) return;

  await axios.post('/chat/send', {
    receiver_id: selectedUser.value.id,
    message: newMessage.value
  });

  messages.value.push({
    sender_id: 0, // Temporário
    message: newMessage.value,
    created_at: new Date().toISOString()
  });

  newMessage.value = '';
};

const currentUserId = ref(null);

onMounted(async () => {
  const response = await axios.get('/api/user');
  currentUserId.value = response.data.id;

  window.Pusher = Pusher;

  window.Echo = new Echo({
    broadcaster: 'socket.io',
    host: window.location.hostname + ':6001'
  });

  window.Echo.private(`chat.${currentUserId.value}`)
    .listen('MessageSent', (e) => {
      if (selectedUser.value && e.message.sender_id === selectedUser.value.id) {
        messages.value.push(e.message);
      }
    });
});
</script>

<template>
  <GuestLayout>
    <div class="grid h-screen grid-cols-3 gap-4 p-6">
      <!-- Lista de contactos -->
      <div class="overflow-y-auto bg-white rounded-lg shadow">
        <h2 class="p-4 text-lg font-bold border-b">Contatos</h2>
        <ul>
          <li v-for="contact in contacts" :key="contact.id"
              @click="fetchMessages(contact)"
              class="p-4 border-b cursor-pointer hover:bg-gray-100">
            {{ contact.name }}
          </li>
        </ul>
      </div>

      <!-- Mensagens -->
      <div class="flex flex-col col-span-2 bg-white rounded-lg shadow">
        <div class="p-4 font-bold border-b">
          {{ selectedUser ? selectedUser.name : 'Seleciona um contacto' }}
        </div>

        <div class="flex-1 p-4 space-y-2 overflow-y-auto">
          <div v-for="(msg, index) in messages" :key="index"
               :class="msg.sender_id === currentUserId ? 'text-right' : 'text-left'">
            <span class="inline-block px-4 py-2 bg-gray-200 rounded-lg">
              {{ msg.message }}
            </span>
          </div>
        </div>

        <div class="flex gap-2 p-4 border-t">
          <input v-model="newMessage" type="text" class="w-full px-4 py-2 border rounded-lg"
                 placeholder="Escreve uma mensagem..." @keyup.enter="sendMessage" />
          <button @click="sendMessage" class="px-4 py-2 text-white bg-blue-600 rounded-lg">
            Enviar
          </button>
        </div>
      </div>
    </div>
  </GuestLayout>
</template>
