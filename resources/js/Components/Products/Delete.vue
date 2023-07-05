<script setup>
import { ref, computed, defineEmits } from "vue";
import { usePage, useForm } from "@inertiajs/vue3";
import AlertByAction from "@/Components/Default/AlertByAction.vue";
import ConfirmsPassword from "@/Components/Default/ConfirmsPassword.vue";

// props
const props = defineProps({
    item: {
        required: true,
    },
    dialog_prop: {
        required: true,
    },
    permanent_delete: {
        default: false,
    },
});

const message_for_delete = computed(() => {
    let message = "";
    message = `¿Estas seguro de eliminar ${props.permanent_delete == true ? "de forma permanente" : "el producto"}  ${props.item.name}?`;
    return message;
});

// emits
const emit = defineEmits(["delete_item", "close_dialog"]);

// const
const loading = ref(false);
const message_alert = ref(null);
const status_alert = ref(null);
const form = useForm({
    sku: props.item.sku,
});

// methods
const close = async () => {
    loading.value = false;
    emit("close_dialog");
};

const erase = async () => {
    try {
        loading.value = true;

        let response = await axios.delete(
            props.permanent_delete == false
                ? "/api/products/delete-product"
                : "/api/products/permanent-delete-product",
            { data: form }
        );
        const { message, status, data } = response.data;
        message_alert.value = message;
        status_alert.value = status;
        if (status == 200) {
            emit("delete_item", form);
            loading.value = false;
        } else {
            loading.value = false;
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
    <v-dialog v-model="props.dialog_prop" persistent width="400">
        <v-card>
            <v-card-text class="text-center">
                <span v-if="status_alert == null">
                    {{ message_for_delete }}
                </span>
                <AlertByAction :status="status_alert" :message="message_alert" v-if="message_alert != null" />
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="delete" variant="flat" @click="close" size="small"> Cerrar </v-btn>
                <ConfirmsPassword @confirmed="erase()" :disabled="false"
                    v-if="status_alert == null" />
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>
