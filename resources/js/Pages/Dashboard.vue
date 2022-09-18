<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/inertia-vue3';
import Button from '@/Components/Button.vue';
import { Link } from '@inertiajs/inertia-vue3'
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="flex w-full p-6 bg-white border-b border-gray-200 space-x-8">
                        <Link :href="route('payments.create')">
                            <Button class="text-white bg-green-500">Register Payment</Button>
                        </Link>
                        <Link :href="route('debts.create')">
                            <Button class="text-white bg-blue-600">Register Debt</Button>
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
