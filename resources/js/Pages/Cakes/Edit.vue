<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/inertia-vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import ActionMessage from "@/Components/ActionMessage.vue";
import FormSection from "@/Components/FormSection.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";

const typeInput = ref(null);
const storeInput = ref(null);
const nameInput = ref(null);
const stockInput = ref(null);
const type = ref(null);
const store = ref(null);

const form = useForm({
    type: 0,
    store: 0,
    name: null,
    stock: null,
});

const updateData = (cake) => {
    form.type = type.value ? type.value.id : cake.cake_type_id;
    form.store = store.value ? store.value.id : cake.cake_store_id;
    form.name = cake.name;
    form.stock = cake.stock;
    form.put(route("cakes.update", cake.id), {
        errorBag: "updateData",
        preserveScroll: true,
        onError: () => {
            if (form.errors.type) {
                form.reset("type");
                typeInput.value.focus();
            }
            if (form.errors.store) {
                form.reset("store");
                storeInput.value.focus();
            }
            if (form.errors.name) {
                form.reset("name");
                nameInput.value.focus();
            }
            if (form.errors.stock) {
                form.reset("stock");
                stockInput.value.focus();
            }
        },
    });
};

const chooseType = (cake_type) => {
    type.value = cake_type;
};

const chooseStore = (cake_store) => {
    store.value = cake_store;
};

defineProps({
    cake_types: Object,
    cake_stores: Object,
    cake: Object,
});
</script>

<template>
    <AppLayout title="Cakes">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Cakes Management
            </h2>
        </template>

        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <FormSection @submitted="updateData(cake)">
                <template #title>Edit Cake</template>

                <template #description>
                    Edit a cake data.
                </template>

                <template #form>
                    <div class="col-span-6 sm:col-span-4">
                        <InputLabel for="type" value="Cake Type" />
                        <div class="dropdown relative mt-2 w-full">
                            <button ref="typeInput"
                                class="dropdown-toggle w-full px-6 py-3 bg-rose-200 text-gray-800 font-medium text-sm leading-tight capitalize rounded shadow-md hover:bg-rose-300 hover:shadow-lg focus:bg-rose-300 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-rose-200 active:shadow-lg transition duration-150 ease-in-out flex items-center whitespace-nowrap"
                                type="button" id="type" data-bs-toggle="dropdown" aria-expanded="false">
                                {{
                                        type ? type.name : cake.cake_type_name
                                }}
                                <div class="w-full flex justify-end">
                                    <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="caret-down"
                                        class="w-2 ml-2" role="img" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 320 512">
                                        <path fill="currentColor"
                                            d="M31.3 192h257.3c17.8 0 26.7 21.5 14.1 34.1L174.1 354.8c-7.8 7.8-20.5 7.8-28.3 0L17.2 226.1C4.6 213.5 13.5 192 31.3 192z">
                                        </path>
                                    </svg>
                                </div>
                            </button>
                            <ul class="dropdown-menu min-w-max absolute w-full bg-white text-base z-50 float-left py-2 list-none text-left rounded-lg shadow-lg mt-1 hidden m-0 bg-clip-padding border-none"
                                aria-labelledby="dropdown_type">
                                <li class="dropdown-item text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-gray-700 hover:bg-gray-100"
                                    v-for="cake_type in cake_types" @click="chooseType(cake_type)">
                                    {{ cake_type.name }}
                                </li>
                            </ul>
                        </div>
                        <InputError :message="form.errors.type" class="mt-2" />
                    </div>
                    <div class="col-span-6 sm:col-span-4">
                        <InputLabel for="store" value="Cake Store" />
                        <div class="dropdown relative mt-2 w-full">
                            <button ref="storeInput"
                                class="dropdown-toggle w-full px-6 py-3 bg-rose-200 text-gray-800 font-medium text-sm leading-tight capitalize rounded shadow-md hover:bg-rose-300 hover:shadow-lg focus:bg-rose-300 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-rose-200 active:shadow-lg transition duration-150 ease-in-out flex items-center whitespace-nowrap"
                                type="button" id="store" data-bs-toggle="dropdown" aria-expanded="false">
                                {{
                                        store ? store.name : cake.cake_store_name
                                }}
                                <div class="w-full flex justify-end">
                                    <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="caret-down"
                                        class="w-2 ml-2" role="img" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 320 512">
                                        <path fill="currentColor"
                                            d="M31.3 192h257.3c17.8 0 26.7 21.5 14.1 34.1L174.1 354.8c-7.8 7.8-20.5 7.8-28.3 0L17.2 226.1C4.6 213.5 13.5 192 31.3 192z">
                                        </path>
                                    </svg>
                                </div>
                            </button>
                            <ul class="dropdown-menu min-w-max absolute w-full bg-white text-base z-50 float-left py-2 list-none text-left rounded-lg shadow-lg mt-1 hidden m-0 bg-clip-padding border-none"
                                aria-labelledby="dropdown_store">
                                <li class="dropdown-item text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-gray-700 hover:bg-gray-100"
                                    v-for="cake_store in cake_stores" @click="chooseStore(cake_store)">
                                    {{ cake_store.name }}
                                </li>
                            </ul>
                        </div>
                        <InputError :message="form.errors.store" class="mt-2" />
                    </div>
                    <div class="col-span-6 sm:col-span-4">
                        <InputLabel for="name" value="Cake Name" />
                        <TextInput id="name" ref="nameInput" v-model="cake.name" type="text"
                            class="mt-1 block w-full" />
                        <InputError :message="form.errors.name" class="mt-2" />
                    </div>
                    <div class="col-span-6 sm:col-span-4">
                        <InputLabel for="stock" value="Cake Stock" />
                        <TextInput id="stock" ref="stockInput" v-model="cake.stock" type="number"
                            class="mt-1 block w-full" />
                        <InputError :message="form.errors.stock" class="mt-2" />
                    </div>
                </template>

                <template #actions>
                    <ActionMessage :on="form.recentlySuccessful" class="mr-3">
                        Saved.
                    </ActionMessage>

                    <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Save
                    </PrimaryButton>
                </template>
            </FormSection>
        </div>
    </AppLayout>
</template>
