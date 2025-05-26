<template>
  <div>
    <h1>Editar Viatura</h1>
    <form @submit.prevent="submit">
      <div>
        <label for="marca">Marca:</label>
        <select v-model="form.marca_id" id="marca" required>
          <option v-for="marca in marcas" :key="marca.id" :value="marca.id">{{ marca.nome }}</option>
        </select>
      </div>

      <div>
        <label for="modelo">Modelo:</label>
        <input type="text" id="modelo" v-model="form.modelo" required />
      </div>

      <div>
        <label for="cor">Cor:</label>
        <input type="text" id="cor" v-model="form.cor" required />
      </div>

      <div>
        <label for="preco_diario">Preço Diário (€):</label>
        <input type="number" id="preco_diario" v-model.number="form.preco_diario" step="0.01" required />
      </div>

      <!-- Add other fields as needed -->

      <div>
        <label for="photos">Fotos do Veículo:</label>
        <input type="file" id="photos" multiple @change="handleFileChange" />
      </div>

      <div class="photo-previews">
        <div v-for="(photo, index) in photoPreviews" :key="index" class="photo-preview">
          <img :src="photo" alt="Preview" class="object-cover w-32 h-24" />
        </div>
        <div v-for="photo in bem.photos" :key="photo.id" class="photo-existing">
          <img :src="`/storage/${photo.photo_path}`" alt="Existing Photo" class="object-cover w-32 h-24" />
        </div>
      </div>

      <button type="submit">Salvar</button>
    </form>
  </div>
</template>

<script setup>
import { reactive, ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
defineOptions({ layout: AdminLayout });

const props = defineProps({
  bem: Object,
  marcas: Array,
});

const form = useForm({
  marca_id: props.bem.marca_id || '',
  modelo: props.bem.modelo || '',
  cor: props.bem.cor || '',
  preco_diario: props.bem.preco_diario || 0,
  photos: [],
});

const photoPreviews = ref([]);

function handleFileChange(event) {
  const files = event.target.files;
  form.photos = [];
  photoPreviews.value = [];
  for (let i = 0; i < files.length; i++) {
    form.photos.push(files[i]);
    const reader = new FileReader();
    reader.onload = e => {
      photoPreviews.value.push(e.target.result);
    };
    reader.readAsDataURL(files[i]);
  }
}

function submit() {
  form.put(route('admin.vehicles.update', props.bem.id));
}
</script>

<style scoped>
.photo-previews {
  display: flex;
  gap: 10px;
  margin-top: 10px;
}
.photo-preview img,
.photo-existing img {
  border-radius: 4px;
  border: 1px solid #ccc;
}
</style>
