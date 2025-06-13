
# 📍 Implementação de Mapa com Leaflet em Vue + Inertia + Laravel

Este guia mostra todos os passos necessários para integrar um mapa interativo usando a API Leaflet numa aplicação Laravel com Inertia e Vue 3.

---

## ✅ Pré-requisitos

- Laravel com Inertia.js já instalado
- Vue 3 configurado
- Layout funcional (`GuestLayout.vue` ou equivalente)
- Node.js e NPM instalados

---

## 1️⃣ Instalar Leaflet

Instala a biblioteca Leaflet com o seguinte comando:

```bash
npm install leaflet
```

Depois, compila os assets:

```bash
npm run dev
```

---

## 2️⃣ Importar Leaflet no componente Vue

Dentro do teu componente (por exemplo `Contactos.vue`), adiciona:

```vue
<script setup>
import { onMounted } from 'vue'
import L from 'leaflet'
import 'leaflet/dist/leaflet.css'

import GuestLayout from '@/Layouts/GuestLayout.vue'
defineOptions({ layout: GuestLayout })
</script>
```

---

## 3️⃣ Criar a estrutura do mapa no template

```vue
<template>
  <div class="flex flex-col gap-6 p-6 md:flex-row">
    <!-- Mapa -->
    <div id="map" class="w-full rounded-lg shadow-md md:w-1/2 h-96"></div>

    <!-- Informações de contacto -->
    <div class="w-full md:w-1/2">
      <h1 class="mb-4 text-2xl font-bold">Contactos</h1>
      <p>📧 Email: apoio@autorentix.pt</p>
      <p>📞 Telefone: +351 912 345 678</p>
      <p>📍 Morada: Rua da Mobilidade, nº 12, 1000-000 Lisboa, Portugal</p>

      <br>
      <h2 class="mt-6 text-xl font-semibold">Horário de atendimento:</h2>
      <p>Segunda a Sexta: 09h00 – 18h00</p>

      <p class="mt-4">Estamos aqui para ajudar!</p>
    </div>
  </div>
</template>
```

---

## 4️⃣ Inicializar o mapa

Adiciona no `onMounted` o seguinte código para carregar o mapa com a vista sobre Lisboa:

```js
onMounted(() => {
  const map = L.map('map').setView([38.736946, -9.142685], 15) // Lisboa

  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors'
  }).addTo(map)

  L.marker([38.736946, -9.142685])
    .addTo(map)
    .bindPopup('Autorentix - Rua da Mobilidade, nº 12')
    .openPopup()
})
```

---

## 5️⃣ Corrigir estilos

No `<style scoped>`, adiciona este bloco para corrigir o z-index do mapa:

```css
<style scoped>
.leaflet-container {
  z-index: 0;
}
</style>
```

---

## 🧪 Resultado Esperado

- O mapa será carregado automaticamente com zoom sobre Lisboa.
- Um marcador será apresentado com a morada e popup da empresa.

---

## ℹ️ Dica adicional

Se os ícones do mapa não aparecerem corretamente, podes importar o CSS dos ícones diretamente ou usar um CDN como:

```html
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
```

---

## 📦 Recompilar os assets

Sempre que fizeres alterações nos `.vue`, recompila os assets com:

```bash
npm run dev
```

---

## ✅ Done!

O mapa com Leaflet está agora integrado no teu projeto Inertia + Vue!
