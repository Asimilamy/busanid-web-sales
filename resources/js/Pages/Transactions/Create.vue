<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import DangerButton from "@/Components/DangerButton.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import SelectInput from "@/Components/SelectInput.vue";
import { Head, useForm, Link, usePage } from "@inertiajs/vue3";
import { reactive, computed, watch } from "vue";

const salespeople = usePage().props.salespeople;
const products = reactive(usePage().props.products);
const productByType = computed(() => {
    return products.filter((item) => item.type == form.type);
});

const form = useForm({
    salesperson_id: "",
    date: "",
    type: "",
    grandtotal: 0,
    details: [],
});

watch(form.details, function (details) {
    details.map((detail) => (detail.subtotal = detail.value * detail.qty));
    form.grandtotal = details.reduce((grandtotal, detail) => {
        return grandtotal + detail.subtotal;
    }, 0);
});

const addDetail = () => {
    form.details.push({
        product_id: null,
        qty: 0,
        value: 0,
        subtotal: 0,
    });
};

const removeDetail = (detail) => {
    form.details = form.details.filter((item) => item != detail);
};

const submit = () => {
    form.post(route("transactions.submit"));
};
</script>

<template>
    <div>
        <Head title="Create Transaction" />
        <AuthenticatedLayout>
            <template #header>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Create Transaction
                </h2>
            </template>

            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                    <SecondaryButton :type="`button`">
                        <Link href="/transactions">Back to Table</Link>
                    </SecondaryButton>

                    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                        <form @submit.prevent="submit">
                            <div>
                                <InputLabel
                                    for="salesperson_id"
                                    value="Salesperson *"
                                />

                                <SelectInput
                                    class="mt-1 block w-full"
                                    v-model="form.salesperson_id"
                                    :options="salespeople"
                                    key-index="id"
                                    value-index="id"
                                    label-index="name"
                                />

                                <InputError
                                    class="mt-2"
                                    :message="form.errors.salesperson_id"
                                />
                            </div>

                            <div class="mt-4">
                                <InputLabel for="date" value="Date *" />

                                <TextInput
                                    id="email"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.date"
                                    autocomplete="date"
                                    placeholder="YYYY-MM-DD"
                                />

                                <InputError
                                    class="mt-2"
                                    :message="form.errors.date"
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

                            <div class="mt-8">
                                <PrimaryButton
                                    :type="`button`"
                                    @click="addDetail"
                                    :disabled="form.type === ''"
                                    >Add Product</PrimaryButton
                                >
                            </div>

                            <div class="mt-4">
                                <table
                                    class="min-w-full divide-y divide-gray-200 bg-white"
                                    aria-label="TableDetail"
                                >
                                    <thead class="bg-gray-50">
                                        <tr
                                            class="font-medium text-xs uppercase text-center tracking-wider text-gray-500 py-3 px-6"
                                        >
                                            <th scope="col">
                                                <span
                                                    class="py-3 px-6 w-full flex flex-row"
                                                >
                                                    <span class="uppercase">
                                                        Action
                                                    </span>
                                                </span>
                                            </th>
                                            <th scope="col">
                                                <span
                                                    class="py-3 px-6 w-full flex flex-row"
                                                >
                                                    <span class="uppercase">
                                                        #
                                                    </span>
                                                </span>
                                            </th>
                                            <th scope="col">
                                                <span
                                                    class="py-3 px-6 w-full flex flex-row"
                                                >
                                                    <span class="uppercase">
                                                        Product
                                                    </span>
                                                </span>
                                            </th>
                                            <th scope="col">
                                                <span
                                                    class="py-3 px-6 w-full flex flex-row"
                                                >
                                                    <span class="uppercase">
                                                        Qty
                                                    </span>
                                                </span>
                                            </th>
                                            <th scope="col">
                                                <span
                                                    class="py-3 px-6 w-full flex flex-row"
                                                >
                                                    <span class="uppercase">
                                                        Value
                                                    </span>
                                                </span>
                                            </th>
                                            <th scope="col">
                                                <span
                                                    class="py-3 px-6 w-full flex flex-row"
                                                >
                                                    <span class="uppercase">
                                                        Subtotal
                                                    </span>
                                                </span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody
                                        class="bg-white divide-y divide-gray-200"
                                    >
                                        <template
                                            v-if="form.details.length < 1"
                                        >
                                            <tr class="hover:bg-gray-100">
                                                <td
                                                    class="text-sm py-4 px-6 text-gray-500 whitespace-nowrap"
                                                    colspan="6"
                                                >
                                                    No product on transaction,
                                                    please add!
                                                </td>
                                            </tr>
                                        </template>
                                        <tr
                                            v-else
                                            class="hover:bg-gray-100"
                                            v-for="(
                                                detail, index
                                            ) in form.details"
                                            :key="index"
                                        >
                                            <td
                                                class="text-sm py-4 px-6 text-gray-500 whitespace-nowrap"
                                            >
                                                <DangerButton
                                                    :type="`button`"
                                                    v-on:click="
                                                        removeDetail(detail)
                                                    "
                                                >
                                                    Delete
                                                </DangerButton>
                                            </td>
                                            <td
                                                class="text-sm py-4 px-6 text-gray-500 whitespace-nowrap"
                                            >
                                                {{ index + 1 }}
                                            </td>
                                            <td
                                                class="text-sm py-4 px-6 text-gray-500 whitespace-nowrap"
                                            >
                                                <SelectInput
                                                    class="mt-1 block w-full"
                                                    v-model="
                                                        form.details[index]
                                                            .product_id
                                                    "
                                                    :options="productByType"
                                                    key-index="id"
                                                    value-index="id"
                                                    label-index="name"
                                                />
                                            </td>
                                            <td
                                                class="text-sm py-4 px-6 text-gray-500 whitespace-nowrap"
                                            >
                                                <TextInput
                                                    type="text"
                                                    class="mt-1 block w-full"
                                                    v-model="
                                                        form.details[index].qty
                                                    "
                                                    placeholder="Qty..."
                                                />
                                            </td>
                                            <td
                                                class="text-sm py-4 px-6 text-gray-500 whitespace-nowrap"
                                            >
                                                <TextInput
                                                    type="text"
                                                    class="mt-1 block w-full"
                                                    v-model="
                                                        form.details[index]
                                                            .value
                                                    "
                                                    placeholder="Value..."
                                                />
                                            </td>
                                            <td
                                                class="text-sm py-4 px-6 text-gray-500 whitespace-nowrap"
                                            >
                                                <TextInput
                                                    type="text"
                                                    class="mt-1 block w-full"
                                                    v-model="
                                                        form.details[index]
                                                            .subtotal
                                                    "
                                                    placeholder="Subtotal..."
                                                    readonly
                                                />
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot class="bg-gray-50">
                                        <tr
                                            class="font-medium text-xs uppercase text-center tracking-wider text-gray-500 py-3 px-6"
                                        >
                                            <th scope="col" colspan="5">
                                                <span
                                                    class="py-3 px-6 w-full flex flex-row"
                                                >
                                                    <span class="uppercase">
                                                        Grandtotal
                                                    </span>
                                                </span>
                                            </th>
                                            <th scope="col">
                                                <span
                                                    class="py-3 px-6 w-full flex flex-row"
                                                >
                                                    <span class="uppercase">
                                                        {{ form.grandtotal }}
                                                    </span>
                                                </span>
                                            </th>
                                        </tr>
                                    </tfoot>
                                </table>
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
