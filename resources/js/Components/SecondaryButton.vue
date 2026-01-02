<template>
    <button
        :type="type"
        :class="[
            'btn-secondary',
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
