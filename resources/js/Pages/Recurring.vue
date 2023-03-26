<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/inertia-vue3';
import Button from '@/Components/Button.vue';
import Credits from '@/Components/Credits.vue';
import { Link, usePage } from '@inertiajs/inertia-vue3'

const props = defineProps({
    recurringItems: Object,
})

const user = usePage().props.value.auth.user
</script>

<template>
    <Head title="Recurring Charges 🔄 " />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Recurring Charges 🔄
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="w-full p-6 bg-white border-b border-gray-200">
                        <div class="flex justify-between">
                            <Link :href="route('recurring.create')">
                            <Button class="text-white bg-green-500">Create recurring charge</Button>
                            </Link>
                        </div>
                        <div class="mt-10 overflow-scroll border-b border-gray-200 shadow lg:overflow-hidden sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                            Concept
                                        </th> 
                                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                            Lender Name
                                        </th> 
                                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                            Debtor Name
                                        </th> 
                                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                            Amount
                                        </th> 
                                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                            Next Charge
                                        </th> 
                                        <th>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr v-for="registry in recurringItems.data" :key="registry">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ registry.concept }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ registry.lender.name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ registry.debtor.name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap" :class="registry.debtor.id == user.id ? 'text-red-400' : 'text-green-400'">
                                            {{ registry.formatted_amount }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ new Date(registry.next_charge).toLocaleString('en-mx', { year: 'numeric', month: 'short', day: 'numeric' }) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex justify-between">
                                                <Link :href="route('recurring.delete', {'recurringItem': registry.id})" class="text-red-600">Delete</Link>
                                                <Link :href="route('recurring.edit', {'recurringItem': registry.id})" class="text-purple-600">Edit</Link>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="flex mt-6">
                            <template v-for="link in recurringItems.links">
                                <div class="">
                                    <Link v-if="link.url" :href="link.url" class="w-full" :class="link.active ? 'bg-blue-300 text-white' : 'bg-white'">
                                        <div v-html="link.label" class="inline px-1 border shadow-sm">

                                        </div>
                                    </Link>
                                    <span v-if="!link.url" :href="link.url" class="px-1 text-gray-500 border shadow-sm" v-html="link.label"></span>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
