<template>

  <div>
    <h1 class="mb-4 text-xl font-bold">Recuperar Palavra-passe</h1>
    <form @submit.prevent="submit">
      <input v-model="form.email" type="email" placeholder="Email" class="w-full px-3 py-2 border rounded" />
      <div v-if="form.errors.email" class="text-sm text-red-500">{{ form.errors.email }}</div>
      <button class="px-4 py-2 mt-4 text-white bg-blue-600 rounded">Enviar link</button>
      <div v-if="status" class="mt-2 text-green-600">{{ status }}</div>
    </form>
  </div>

</template>

<script setup>
import { ref } from 'vue'
import { useForm } from '@inertiajs/vue3'
import AuthLayout from '@/Layouts/AuthLayout.vue'
defineOptions({ layout: AuthLayout })

const status = ref('')
const form = useForm({ email: '' })

function submit() {
  form.post('/password/email', {
    onSuccess: () => {
      status.value = 'Se o email existir, foi enviado um link de recuperação.'
    }
  })
}
</script>
