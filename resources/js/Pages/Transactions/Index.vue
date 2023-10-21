<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import DangerButton from "@/Components/DangerButton.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import { Table as InertiaTable } from "@protonemedia/inertiajs-tables-laravel-query-builder";
import { Head, useForm, usePage, Link } from "@inertiajs/vue3";

const form = useForm({
    start_date: usePage().props.start_date,
    end_date: usePage().props.end_date,
});
const page = usePage();

defineProps(["transactions"]);

function destroy(id) {
    if (confirm("Are you sure to delete?")) {
        form.delete(route("transactions.destroy", id));
    }
}
</script>

<template>
    <div>
        <Head title="Transactions" />
        <AuthenticatedLayout>
            <template #header>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Transactions
                </h2>
            </template>

            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                    <PrimaryButton :type="`button`">
                        <Link href="/transactions/create">Add New</Link>
                    </PrimaryButton>

                    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                        <div class="mt-4">
                            <InputLabel for="start_date" value="Start Date" />

                            <TextInput
                                id="email"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.start_date"
                                autocomplete="start_date"
                                placeholder="YYYY-MM-DD"
                            />
                        </div>
                        <div class="mt-4">
                            <InputLabel for="end_date" value="End Date" />

                            <TextInput
                                id="email"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.end_date"
                                autocomplete="end_date"
                                placeholder="YYYY-MM-DD"
                            />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <PrimaryButton
                                :type="`button`"
                                class="ml-4 items-right"
                            >
                                <a
                                    :href="
                                        `/transactions/export/` +
                                        form.start_date +
                                        `/` +
                                        form.end_date
                                    "
                                    target="_blank"
                                    >Download Report</a
                                >
                            </PrimaryButton>
                        </div>
                    </div>

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
                        <InertiaTable :resource="transactions" :striped="true">
                            <template #cell(actions)="{ item: transaction }">
                                <SecondaryButton :type="`button`" class="mr-2">
                                    <Link
                                        :href="
                                            `/transactions/edit/` +
                                            transaction.id
                                        "
                                    >
                                        Edit
                                    </Link>
                                </SecondaryButton>
                                <DangerButton
                                    :type="`button`"
                                    v-on:click="destroy(transaction.id)"
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
