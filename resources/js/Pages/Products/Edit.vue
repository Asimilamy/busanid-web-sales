<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import SelectInput from "@/Components/SelectInput.vue";
import { Head, useForm, Link, usePage } from "@inertiajs/vue3";

const product = usePage().props.product;

const form = useForm({
    id: product.id,
    name: product.name,
    type: product.type,
});

const submit = () => {
    form.post(route("products.submit"), {
        onFinish: () => form.reset("name", "type"),
    });
};
</script>

<template>
    <div>
        <Head title="Create Products" />
        <AuthenticatedLayout>
            <template #header>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Create Products
                </h2>
            </template>

            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                    <SecondaryButton :type="`button`">
                        <Link href="/products">Back to Table</Link>
                    </SecondaryButton>

                    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                        <form @submit.prevent="submit">
                            <div>
                                <InputLabel for="name" value="Name *" />

                                <TextInput
                                    id="name"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.name"
                                    autofocus
                                    autocomplete="name"
                                    placeholder="Name..."
                                />

                                <InputError
                                    class="mt-2"
                                    :message="form.errors.name"
                                />
                            </div>

                            <div class="mt-4">
                                <InputLabel for="type" value="Type *" />

                                <SelectInput
                                    class="mt-1 block w-full"
                                    v-model="form.type"
                                    :options="[
                                        { code: 'barang', label: 'Barang' },
                                        { code: 'jasa', label: 'Jasa' },
                                    ]"
                                    key-index="code"
                                    value-index="code"
                                    label-index="label"
                                ></SelectInput>

                                <InputError
                                    class="mt-2"
                                    :message="form.errors.type"
                                />
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <PrimaryButton
                                    class="ml-4"
                                    :class="{ 'opacity-25': form.processing }"
                                    :disabled="form.processing"
                                >
                                    Submit
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    </div>
</template>
