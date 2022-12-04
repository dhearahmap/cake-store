<script setup>
import { defineComponent } from 'vue';
import { Link } from "@inertiajs/inertia-vue3";
import AppLayout from '@/Layouts/AppLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';

defineComponent({
    AppLayout,
    PrimaryButton,
    DangerButton,
});

defineProps({
    cake_types: Object
});
</script>

<template>
    <AppLayout title="Cake Types">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Cake Type Management
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <Link :href="route('cakes.types.create')">
                <PrimaryButton>
                    Add New Cake Type
                </PrimaryButton>
                </Link>
                <div class="bg-rose-200 overflow-hidden shadow-xl sm:rounded-lg mt-8">
                    <div class="flex flex-col">
                        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="inline-block min-w-full sm:px-6 lg:px-8">
                                <div class="overflow-hidden">
                                    <table class="min-w-full">
                                        <thead class="bg-rose-200 border-b">
                                            <tr>
                                                <th scope="col"
                                                    class="text-sm font-bold text-gray-900 px-6 py-4 text-left">
                                                    ID
                                                </th>
                                                <th scope="col"
                                                    class="text-sm font-bold text-gray-900 px-6 py-4 text-left">
                                                    Cake Type
                                                </th>
                                                <th scope="col"
                                                    class="text-sm font-bold text-gray-900 px-6 py-4 text-left">
                                                    Action
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="bg-rose-50 border-b transition duration-300 ease-in-out hover:bg-rose-100"
                                                v-for="cake_type in cake_types" :key="cake_type.id">
                                                <td
                                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                    {{ cake_type.id }}
                                                </td>
                                                <td
                                                    class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                    {{ cake_type.name }}
                                                </td>
                                                <td
                                                    class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                    <Link :href="
                                                        route(
                                                            'cakes.types.edit',
                                                            cake_type.id
                                                        )
                                                    ">
                                                    <PrimaryButton>
                                                        Edit
                                                    </PrimaryButton>
                                                    </Link>
                                                    <Link :href="
    route(
        'cakes.types.destroy',
        cake_type.id
    )
                                                    ">
                                                    <DangerButton class="ml-4">
                                                        Remove
                                                    </DangerButton>
                                                    </Link>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
