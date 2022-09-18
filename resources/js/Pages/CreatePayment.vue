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
})

const nonSelectedUser = id => {
    return props.users.filter((user) => user.id != id)[0]
}

const form = useForm({
    amount: '',
    lender_id: user.id,
    debtor_id: nonSelectedUser(user.id).id, 
});

watch(() => form.lender_id, (selected) => {
    form.debtor_id = nonSelectedUser(selected).id
})

watch(() => form.debtor_id, (selected) => {
    form.lender_id = nonSelectedUser(selected).id
})


const submit = () => {
    console.log(form)
    form.post(route('payments.store'), {
        onFinish: () => _,
    });
};


</script>

<template>
    <Head title="Create Payment" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Create Payment
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="flex w-full p-6 bg-white border-b border-gray-200 space-x-8">
                        <form @submit.prevent="submit">
                            <div>
                                <InputLabel for="Amount" value="Amount" />
                                <TextInput id="amount" type="text" class="block w-full mt-1" v-model="form.amount" required autofocus />
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
                            <div class="flex items-center justify-end mt-4">
                                <Link :href="route('dashboard')">
                                    <PrimaryButton type="button" class="ml-4 bg-red-400 hover:bg-red-500" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                    Cancel
                                    </PrimaryButton>
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
