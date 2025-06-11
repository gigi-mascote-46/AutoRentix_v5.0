<template>
  <div class="flex flex-col min-h-screen">
    <!-- Header -->
    <header class="flex items-center justify-between p-4 bg-white shadow">
      <Link href="/" class="text-2xl font-bold text-blue-600">AutoRentix</Link>

      <nav class="space-x-4">
        <Link href="/" class="hover:text-blue-600">Home</Link>
        <Link href="/vehicles" class="hover:text-blue-600">Viaturas</Link>
        <Link href="/sobre" class="hover:text-blue-600">Sobre</Link>
        <Link href="/contacto" class="hover:text-blue-600">Contacto</Link>

        <template v-if="!user">
          <Link href="/login" class="font-semibold text-blue-600 hover:underline">Entrar</Link>
          <Link href="/register" class="font-semibold text-blue-600 hover:underline">Registar</Link>
        </template>

        <template v-else>
          <Link href="/areacliente/dashboard" class="font-semibold text-blue-600 hover:underline">Dashboard</Link>
          <button @click="logout" class="text-red-600 hover:underline">Sair</button>
        </template>
      </nav>
    </header>

    <!-- Main content -->
    <main class="flex-grow w-full p-6">
      <slot />
    </main>

    <!-- Footer -->

    <footer class="p-4 text-sm text-center text-gray-600 bg-gray-100">
      &copy; {{ new Date().getFullYear() }} AutoRentix. Todos os direitos reservados.
    </footer>

    <!-- Floating Chat Button -->
    <button
      @click="toggleChat"
      class="fixed z-50 flex items-center justify-center text-white bg-blue-600 rounded-full shadow-lg bottom-6 right-6 hover:bg-blue-700 w-14 h-14"
      aria-label="Open chat"
      title="Abrir chat de ajuda"
    >
      <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72A7.963 7.963 0 013 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
      </svg>
    </button>

    <!-- Chat Window -->
    <div
      v-if="chatOpen"
      class="fixed z-50 flex flex-col max-w-full bg-white border border-gray-300 rounded-lg shadow-lg bottom-20 right-6 w-80"
    >
      <div class="flex items-center justify-between px-4 py-2 text-white bg-blue-600 rounded-t-lg">
        <h3 class="font-semibold">Chat de Ajuda</h3>
        <button @click="toggleChat" aria-label="Fechar chat" title="Fechar chat" class="text-white hover:text-gray-200">
          &times;
        </button>
      </div>
      <div class="flex-1 p-4 space-y-3 overflow-y-auto max-h-64" ref="messagesContainer">
        <div v-for="message in messages" :key="message.id" :class="{'text-right': message.sender_id === userId}">
          <div
            :class="[
              'inline-block px-3 py-2 rounded-lg',
              message.sender_id === userId ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-800'
            ]"
          >
            {{ message.message }}
          </div>
        </div>
      </div>
      <form @submit.prevent="sendMessage" class="flex p-2 border-t border-gray-300">
        <input
          v-model="newMessage"
          type="text"
          placeholder="Escreva a sua mensagem..."
          class="flex-1 px-3 py-2 border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-blue-600"
          :disabled="!userId"
          required
        />
        <button
          type="submit"
          class="px-4 py-2 text-white bg-blue-600 rounded-r-lg hover:bg-blue-700"
          :disabled="!newMessage || !userId"
        >
          Enviar
        </button>
      </form>
      <div v-if="!userId" class="p-2 text-sm text-center text-red-600">
        Por favor, faça login para enviar mensagens.
      </div>
    </div>
  </div>
</template>

<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';
import { ref, nextTick } from 'vue';
import axios from 'axios';

const page = usePage();
const user = page.props?.auth?.user || null;

function logout() {
  if (confirm('Deseja terminar a sessão?')) {
    Inertia.post(route('logout'));
  }
}

const chatOpen = ref(false);
const messages = ref([]);
const newMessage = ref('');
const userId = ref(user ? user.id : null);
const adminUserId = ref(null);
const messagesContainer = ref(null);

const toggleChat = () => {
  chatOpen.value = !chatOpen.value;
  if (chatOpen.value) {
    fetchAdminUserId();
  }
};

const fetchAdminUserId = async () => {
  try {
    // Fetch admin user from /chat endpoint (which returns admin contact)
    const response = await axios.get('/chat');
    if (response.data.contacts && response.data.contacts.length > 0) {
      adminUserId.value = response.data.contacts[0].id;
      if (userId.value) {
        fetchMessages();
      }
    }
  } catch (error) {
    console.error('Erro ao obter admin user:', error);
  }
};

const fetchMessages = async () => {
  if (!adminUserId.value || !userId.value) return;
  try {
    const response = await axios.get(`/messages/${adminUserId.value}`);
    messages.value = response.data;
    scrollToBottom();
  } catch (error) {
    console.error('Erro ao obter mensagens:', error);
  }
};

const sendMessage = async () => {
  if (!newMessage.value.trim() || !adminUserId.value) return;
  try {
    await axios.post('/messages', {
      receiver_id: adminUserId.value,
      message: newMessage.value.trim(),
    });
    newMessage.value = '';
    await fetchMessages();
  } catch (error) {
    console.error('Erro ao enviar mensagem:', error);
  }
};

const scrollToBottom = () => {
  nextTick(() => {
    if (messagesContainer.value) {
      messagesContainer.value.scrollTop = messagesContainer.value.scrollHeight;
    }
  });
};
</script>
