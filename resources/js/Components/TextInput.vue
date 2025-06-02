<template>
    <input
        :id="id"
        ref="input"
        v-model="model"
        :type="type"
        :class="[
            'input-base',
            'placeholder-gray-400',
            { 'border-red-500 focus:border-red-500 focus:ring-red-500': hasError },
            additionalClasses
        ]"
        :placeholder="placeholder"
        :required="required"
        :disabled="disabled"
        :autocomplete="autocomplete"
    />
</template>

<script setup>
import { onMounted, ref } from 'vue'

const model = defineModel()

const props = defineProps({
    id: String,
    type: {
        type: String,
        default: 'text',
    },
    placeholder: String,
    required: Boolean,
    disabled: Boolean,
    autocomplete: String,
    hasError: Boolean,
    additionalClasses: {
        type: String,
        default: '',
    },
})

const input = ref(null)

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus()
    }
})

defineExpose({ focus: () => input.value.focus() })
</script>

<style scoped>
/* Add any additional styles if needed */
</style>
