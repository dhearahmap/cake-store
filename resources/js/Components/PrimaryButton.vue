<script setup>
defineProps({
    type: {
        type: String,
        default: 'submit',
    },
});
</script>

<template>
    <button :type="type" class="inline-flex items-center px-4 py-2 bg-rose-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-rose-500 active:bg-rose-600 focus:outline-none focus:border-rose-700 focus:ring focus:ring-rose-300 disabled:opacity-25 transition">
        <slot />
    </button>
</template>
