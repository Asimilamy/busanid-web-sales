<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import DangerButton from "@/Components/DangerButton.vue";
import { Head, useForm, usePage } from "@inertiajs/vue3";

const props = defineProps({
    products: {
        type: Object,
        default: () => ({}),
    },
});

const form = useForm({});
const page = usePage();

function destroy(id) {
    if (confirm("Are you sure to delete?")) {
        form.delete(route("products.destroy", id));
    }
}
</script>

<template>
    <Head title="Products" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Products
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <span class="font-semibold text-xl leading-tight mb-4">
                        Table goes here!
                    </span>

                    <div
                        v-if="page.props.flash.message"
                        class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800"
                        role="alert"
                    >
                        <span class="font-medium">
                            {{ page.props.flash.message }}
                        </span>
                    </div>

                    <table
                        class="w-full text-sm text-left text-gray-500 table-auto mt-4 border-collapse border border-slate-500"
                        aria-label="IndexTable"
                    >
                        <thead
                            class="text-xl text-gray-700 uppercase bg-gray-50"
                        >
                            <tr>
                                <th
                                    scope="col"
                                    class="border border-slate-600 px-3 py-4 text-center"
                                >
                                    #
                                </th>
                                <th
                                    scope="col"
                                    class="border border-slate-600 px-3 py-4 text-center"
                                >
                                    Name
                                </th>
                                <th
                                    scope="col"
                                    class="border border-slate-600 px-3 py-4 text-center"
                                >
                                    Type
                                </th>
                                <th
                                    scope="col"
                                    class="border border-slate-600 px-3 py-4 text-center"
                                >
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(product, index) in products"
                                :key="product.id"
                                class="bg-white border-b"
                            >
                                <td
                                    class="border border-slate-700 px-6 py-4 font-medium text-gray-900 whitespace-nowrap text-center"
                                >
                                    {{ index + 1 }}
                                </td>
                                <td
                                    class="border border-slate-700 px-6 py-4 font-medium text-gray-900 whitespace-nowrap"
                                >
                                    {{ product.name }}
                                </td>
                                <td
                                    class="border border-slate-700 px-6 py-4 text-center"
                                >
                                    {{ product.type }}
                                </td>

                                <td
                                    class="border border-slate-700 px-6 py-4 text-center"
                                >
                                    <SecondaryButton
                                        :type="`button`"
                                        class="mr-2"
                                    >
                                        <a :href="route('products')"> Edit </a>
                                    </SecondaryButton>
                                    <DangerButton
                                        :type="`button`"
                                        v-on:click="destroy(product.id)"
                                    >
                                        Delete
                                    </DangerButton>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
