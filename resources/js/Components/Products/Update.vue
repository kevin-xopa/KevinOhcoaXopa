<script setup>
import { ref, defineEmits } from "vue";
import { usePage, useForm } from "@inertiajs/vue3";
import { useVuelidate } from "@vuelidate/core";
import { required, helpers, maxLength, numeric } from "@vuelidate/validators";
import AlertByAction from "@/Components/Default/AlertByAction.vue";

// props
const props = defineProps({
    item: {
        required: true,
    },
    dialog_prop: {
        required: true,
    },
});

// emits
const emit = defineEmits(["update_item", "close_dialog"]);

// const
const old_url = ref(props.item.url);
const loading = ref(false);
const message_alert = ref(null);
const status_alert = ref(null);
const form = useForm(Object.assign({}, props.item));

// rules of validation
const rules = {
    price_pesos: {
        numeric: helpers.withMessage(
            "Este campo solo puede ser un numérico",
            numeric
        ),
        required: helpers.withMessage(
            "Este campo no puede estar vacío",
            required
        ),
    },
    points: {
        numeric: helpers.withMessage(
            "Este campo solo puede ser un numérico",
            numeric
        ),
        required: helpers.withMessage(
            "Este campo no puede estar vacío",
            required
        ),
    },
    active: {
        required: helpers.withMessage(
            "Este campo no puede estar vacío",
            required
        ),
    },
    name: {
        required: helpers.withMessage(
            "Este campo no puede estar vacío",
            required
        ),
        maxLength: helpers.withMessage(
            ({ $pending, $invalid, $params, $model }) =>
                `Este campo tiene un valor de '${$model}' pero debe tener una longitud maxima de ${$params.min
                } por lo que es ${$invalid ? "inválido" : "válido"}`,
            maxLength(100)
        ),
    },
    description: {
        required: helpers.withMessage(
            "Este campo no puede estar vacío",
            required
        ),
        maxLength: helpers.withMessage(
            ({ $pending, $invalid, $params, $model }) =>
                `Este campo tiene un valor de '${$model}' pero debe tener una longitud maxima de ${$params.min
                } por lo que es ${$invalid ? "inválido" : "válido"}`,
            maxLength(255)
        ),
    },
    long_description: {},
};

const v$ = useVuelidate(rules, form);

// methods
const close = async () => {
    loading.value = false;
    emit("close_dialog");
};

const update = async () => {
    try {
        if (v$.value.$invalid) {
            v$.value.$touch();
        } else {
            loading.value = true;
            form.old_url = old_url.value;
            let response = await axios.put("/api/products/update-product", form);
            const { message, status, data } = response.data;
            message_alert.value = message;
            status_alert.value = status;
            if (status == 200) {
                emit("update_item", data[0]);
                loading.value = false;
                old_url.value = data[0].url
            } else {
                loading.value = false;
            }
        }
    } catch (e) {
        if (e.response.data.status === 422) {
            message_alert.value = e.response.data.message;
            status_alert.value = e.response.data.status;
        }
        loading.value = false;
    }
};
// watchers
</script>

<template>
    <v-dialog v-model="props.dialog_prop" persistent>
        <v-card>
            <form @submit.prevent="update()">
                <v-card-title class="text-center"> Modificar presentación </v-card-title>
                <v-card-text>
                    <AlertByAction :status="status_alert" :message="message_alert" v-if="message_alert != null" />
                    <v-container>
                        <v-row>
                            <v-col cols="12" xl="4" lg="4" md="4" sm="6" xs="12">
                                <v-text-field id="price_pesos" v-model="form.price_pesos" label="Price" clearable required
                                    type="number" :min="1" step="any"
                                    :error-messages="v$.price_pesos.$errors[0] ? v$.price_pesos.$errors[0].$message : ''"
                                    @change="v$.price_pesos.$touch()" @blur="v$.price_pesos.$touch()" />
                            </v-col>
                            <v-col cols="12" xl="4" lg="4" md="4" sm="6" xs="12">
                                <v-text-field id="points" v-model="form.points" label="Points" clearable required
                                    type="number" :min="1"
                                    :error-messages="v$.points.$errors[0] ? v$.points.$errors[0].$message : ''"
                                    @change="v$.points.$touch()" @blur="v$.points.$touch()" />
                            </v-col>
                            <v-col cols="12" xl="4" lg="4" md="4" sm="6" xs="12">
                                <v-select id="active" v-model="form.active" label="Active" required
                                    :error-messages="v$.active.$errors[0] ? v$.active.$errors[0].$message : ''"
                                    @change="v$.active.$touch()" @blur="v$.active.$touch()"
                                    :items="['Deactivate', 'Activate']" />

                            </v-col>

                            <v-col cols="12" xl="4" lg="4" md="4" sm="6" xs="12">
                                <v-text-field id="name" v-model="form.name" label="Name" clearable required counter
                                    :error-messages="v$.name.$errors[0] ? v$.name.$errors[0].$message : ''"
                                    @change="v$.name.$touch()" @blur="v$.name.$touch()" />
                            </v-col>
                            <v-col cols="12" xl="4" lg="4" md="4" sm="6" xs="12">
                                <v-text-field id="description" v-model="form.description" label="Description" clearable
                                    counter required
                                    :error-messages="v$.description.$errors[0] ? v$.description.$errors[0].$message : ''"
                                    @change="v$.description.$touch()" @blur="v$.description.$touch()"></v-text-field>
                            </v-col>
                            <v-col cols="12" xl="4" lg="4" md="4" sm="6" xs="12">
                                <v-text-field id="long_description" v-model="form.long_description" label="Long Description"
                                    clearable
                                    :error-messages="v$.long_description.$errors[0] ? v$.long_description.$errors[0].$message : ''"
                                    @change="v$.long_description.$touch()"
                                    @blur="v$.long_description.$touch()"></v-text-field>
                            </v-col>
                        </v-row>
                    </v-container>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="delete" variant="flat" @click="close" size="small">
                        Close
                    </v-btn>
                    <v-btn color="success" variant="flat" type="submit" :loading="loading" size="small">
                        Save
                    </v-btn>
                </v-card-actions>
            </form>
        </v-card>
    </v-dialog>
</template>
