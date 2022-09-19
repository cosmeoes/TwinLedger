
<template>
    <div>
        {{ (positiveCredit ? "They owe you:" : "You owe:") }} <span :class="positiveCredit ? 'text-green-500' : 'text-red-500'">${{Math.abs(user.credit / 100)}}</span>
    </div>
</template>

<script setup>
import {  usePage } from '@inertiajs/inertia-vue3';
const user = usePage().props.value.auth.user
const positiveCredit = user.credit >= 0
</script>
