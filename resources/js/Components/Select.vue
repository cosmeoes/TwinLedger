<template>
  <div class="">
      <select v-model="modelValue" @input="$emit('update:modelValue', $event.target.value)" :class="class" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" :name="name">
          <option v-for="user in users" :value="user.id">{{ user.name }}</option>
      </select>
  </div>
</template>

<script setup>

defineProps({
    users: Array,
    modelValue: Number,
    name: String,
    class: String
})

defineEmits(['update:modelValue'])
</script>

