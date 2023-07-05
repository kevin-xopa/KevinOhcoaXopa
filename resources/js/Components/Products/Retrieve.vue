<script setup>
import { ref, computed, defineEmits } from "vue";
import { useForm } from "@inertiajs/vue3";
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
const emit = defineEmits(["restore_item", "close_dialog"]);

// const
const loading = ref(false);
const message_alert = ref(null);
const status_alert = ref(null);
const form = useForm({
  slug: props.item.slug,
});

// methods
const close = async () => {
  loading.value = false;
  emit("close_dialog");
};

const erase = async () => {
  try {
    loading.value = true;

    let response = await axios.post("/api/restore-presentation", form);
    const { message, status, data } = response.data;
    message_alert.value = message;
    status_alert.value = status;
    if (status == 200) {
      emit("restore_item", form);
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
const message_for_delete = computed(() => {
  return `¿Estas seguro de restaurar el estado ${props.item.name}?`;
});
// watchers
</script>

<template>
  <v-dialog v-model="props.dialog_prop" persistent width="400">
    <v-card>
      <form @submit.prevent="erase()">
        <v-card-text class="text-center">
          <span v-if="status_alert == null">
            {{ message_for_delete }}
          </span>
          <AlertByAction
            :status="status_alert"
            :message="message_alert"
            v-if="message_alert != null"
          />
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="delete" variant="flat" @click="close" size="small">
            Cerrar
          </v-btn>
          <v-btn
            v-if="props.item.products_count == 0 && status_alert == null"
            color="success"
            variant="flat"
            type="submit"
            size="small"
            :loading="loading"
          >
            Aplicar
          </v-btn>
        </v-card-actions>
      </form>
    </v-card>
  </v-dialog>
</template>
