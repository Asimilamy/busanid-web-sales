<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import DangerButton from "@/Components/DangerButton.vue";
import { Table as InertiaTable } from "@protonemedia/inertiajs-tables-laravel-query-builder";
import { Head, useForm, usePage, Link } from "@inertiajs/vue3";

const form = useForm({});
const page = usePage();

defineProps(["products"]);

function destroy(id) {
    if (confirm("Are you sure to delete?")) {
        form.delete(route("products.destroy", id));
    }
}
</script>

<template>
    <div>
        <Head title="Products" />
        <AuthenticatedLayout>
            <template #header>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Products
                </h2>
            </template>

            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                    <PrimaryButton :type="`button`">
                        <Link href="/products/create">Add New</Link>
                    </PrimaryButton>
                    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                        <div
                            v-if="page.props.flash.message"
                            class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800"
                            role="alert"
                        >
                            <span class="font-medium">
                                {{ page.props.flash.message }}
                            </span>
                        </div>
                        <InertiaTable :resource="products" :striped="true">
                            <template #cell(actions)="{ item: product }">
                                <SecondaryButton :type="`button`" class="mr-2">
                                    <Link
                                        :href="`/products/edit/` + product.id"
                                    >
                                        Edit
                                    </Link>
                                </SecondaryButton>
                                <DangerButton
                                    :type="`button`"
                                    v-on:click="destroy(product.id)"
                                >
                                    Delete
                                </DangerButton>
                            </template>
                        </InertiaTable>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    </div>
</template>
