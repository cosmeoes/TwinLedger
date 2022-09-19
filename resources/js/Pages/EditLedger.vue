<script setup>
import { ref, onMounted, watch, reactive } from 'vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm, usePage } from '@inertiajs/inertia-vue3';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Select from '@/Components/Select.vue';
import Button from '@/Components/Button.vue';

const user = usePage().props.value.auth.user

const props = defineProps({
    users: Array,
    ledger: Object,
})

const nonSelectedUser = id => {
    return props.users.filter((user) => user.id != id)[0]
}

const form = useForm({
    amount: props.ledger.amount / 100,
    lender_id: props.ledger.lender_id,
    debtor_id: props.ledger.debtor_id, 
    concept: props.ledger.concept
});

watch(() => form.lender_id, (selected) => {
    form.debtor_id = nonSelectedUser(selected).id
})

watch(() => form.debtor_id, (selected) => {
    form.lender_id = nonSelectedUser(selected).id
})


const submit = () => {
    form.transform((data) => ({
        ...data,
        amount: data.amount * 100 // convert to cents
    })).patch(route('ledger.update', { ledger: props.ledger.id }));
};


</script>

<template>
    <Head title="Write on Ledger ✍️" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Write on Ledger ✍️
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="flex w-full p-6 bg-white border-b border-gray-200 space-x-8">
                        <form @submit.prevent="submit">
                            <div>
                                <InputLabel for="Amount" value="Amount"/>
                                <TextInput id="amount" type="text" placeholder="95.50" class="block w-full mt-1" v-model="form.amount" required autofocus />
                                <InputError class="mt-2" :message="form.errors.amount" />
                            </div>

                            <div class="mt-4">
                                <InputLabel for="lenderId" value="Lender (The person who the money is owed to)" />
                                <Select class="w-full" name="lenderId" :users="users" v-model="form.lender_id"/>
                                <InputError class="mt-2" :message="form.errors.lenderId" />
                            </div>
                            <div class="mt-4">
                                <InputLabel for="debtorId" value="Debtor (The person who owes the money)" />
                                <Select class="w-full" name="debtorId" :users="users" v-model="form.debtor_id"/>
                                <InputError class="mt-2" :message="form.errors.debtorId" />
                            </div>
                            <div class="mt-4">
                                <InputLabel for="debtorId" value="Concept"/>
                                <textarea class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" placeholder="Buffalucas" name="concept" v-model="form.concept"/>
                                <InputError class="mt-2" :message="form.errors.debtorId" />
                            </div>
                            <div class="flex items-center justify-end mt-4">
                                <Link :href="route('ledger.index')" class="px-4 py-1 ml-4 text-white bg-red-400 rounded-md hover:bg-red-500" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" as="button" type="button">
                                    Cancel
                                </Link>
                                <PrimaryButton class="ml-4 bg-green-400 hover:bg-green-500 focus:border-green-500 active:bg-green-500" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                Save
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
