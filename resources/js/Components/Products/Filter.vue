<script setup>
import { mdiFilterVariant } from "@mdi/js";
import { ref } from "vue";

const dialog = ref(false);
const form = ref({
    items_for_paginate: 40,
    recently: false,
    order_by: "ASC",
});
const orders_by = [
    { name: "Ascendente", slug: "ASC" },
    { name: "Descendente", slug: "DESC" },
];

</script>
<template>
    <div class="text-right">
        <v-btn
            color="filter_button"
            @click="dialog = true"
            :prepend-icon="mdiFilterVariant"
        >
            Filters
        </v-btn>
        <v-dialog v-model="dialog">
            <v-card>
                <v-card-title class="ml-2"> Filters </v-card-title>
                <v-card-text>
                    <v-row>
                        <!-- item for page -->
                        <v-col cols="12" xl="4" lg="4" md="4" sm="6" xs="12">
                            <v-text-field
                                label="Productos por pagina"
                                id="items_for_paginate"
                                v-model="form.items_for_paginate"
                                type="number"
                                autofocus
                                :min="1"
                            />
                        </v-col>
                        <!-- order -->
                        <v-col cols="12" xl="4" lg="4" md="4" sm="6" xs="12">
                            <v-select
                                v-model="form.order_by"
                                :items="orders_by"
                                item-title="name"
                                item-value="slug"
                                label="Ordenar de manera"
                            ></v-select>
                        </v-col>
                        <!-- recently -->
                        <v-col cols="12" xl="4" lg="4" md="4" sm="6" xs="12">
                            <v-checkbox
                                v-model="form.recently"
                                label="Recientemente agregados"
                                :value="true"
                                color="pink"
                            ></v-checkbox>
                        </v-col>
                    </v-row>
                </v-card-text>
                <v-card-actions class="justify-end">
                    <v-btn
                        color="delete"
                        size="small"
                        variant="flat"
                        @click="dialog = false"
                    >
                        Cerrar
                    </v-btn>
                    <v-btn
                        color="success"
                        size="small"
                        variant="flat"
                        @click="
                            (dialog = false),
                                $emit('filter', { name: 'filter', value: form })
                        "
                    >
                        Aplicar
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>
