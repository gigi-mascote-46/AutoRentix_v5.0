<template>
  <p class="mt-2 text-sm text-red-600" v-if="$slots.default">
    <slot />
  </p>
</template>

<script setup>
// Simple component to display input error messages
</script>

<style scoped>
/* Add any additional styles if needed */
</style>
