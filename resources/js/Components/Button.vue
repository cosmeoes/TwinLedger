<script setup>
</script>

<template>
    <button @click="$emit('click')" :class="class" class="px-10 py-2 rounded-md">
        <slot />
    </button>
</template>
