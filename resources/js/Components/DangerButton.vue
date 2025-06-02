<template>
    <button
        :type="type"
        :class="[
            'btn-base bg-red-600 text-white hover:bg-red-700 focus:ring-red-500',
            'shadow-sm hover:shadow-md transform hover:-translate-y-0.5',
            'active:transform active:translate-y-0 active:shadow-sm',
            { 'opacity-25': disabled },
            additionalClasses
        ]"
        :disabled="disabled"
    >
        <slot />
  </button>
</template>

<script setup>
defineProps({
    type: {
        type: String,
        default: 'button',
    },
    disabled: {
        type: Boolean,
        default: false,
    },
    additionalClasses: {
        type: String,
        default: '',
    },
})
</script>

<style scoped>
/* Add any additional styles if needed */
</style>
