<script setup>
import { onMounted, ref } from "vue";

defineProps({
    modelValue: String,
    keyIndex: String,
    valueIndex: String,
    labelIndex: String,
    placeholder: {
        type: String,
        default: "Please select...",
    },
    options: Array,
});

defineEmits(["update:modelValue"]);

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute("autofocus")) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <select
        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
        :value="modelValue"
        @change="$emit('update:modelValue', $event.target.value)"
        ref="input"
    >
        <option value="">{{ placeholder }}</option>
        <option
            v-for="item in options"
            :key="item[keyIndex]"
            :value="item[valueIndex]"
        >
            {{ item[labelIndex] }}
        </option>
    </select>
</template>
