<script setup>
import { ref, reactive, nextTick } from "vue";
import { mdiEyeOff, mdiEye } from "@mdi/js";
import AlertByAction from "@/Components/Default/AlertByAction.vue";

const emit = defineEmits(["confirmed"]);

defineProps({
  disabled: {
    type: Boolean,
    default: true,
  },
});

const dialog = ref(false);
const loading = ref(false);
const message_alert = ref(null);
const status_alert = ref(null);
const is_password_visible = ref(false);
const form = reactive({
  password: "",
  processing: false,
});
const passwordInput = ref(null);

// methods

const startConfirmingPassword = () => {
  axios.get(route("password.confirmation")).then((response) => {
    if (response.data.confirmed) {
      emit("confirmed");
    } else {
      dialog.value = true;

      setTimeout(() => passwordInput.value.focus(), 250);
    }
  });
};

const confirm_password = () => {
  form.processing = true;

  axios
    .post(route("password.confirm"), {
      password: form.password,
    })
    .then(() => {
      form.processing = false;

      close();
      nextTick().then(() => emit("confirmed"));
    })
    .catch((error) => {
      message_alert.value = error.response.data.errors.password[0];
      status_alert.value = 422;
      form.processing = false;
      passwordInput.value.focus();
    });
};

const close = () => {
  dialog.value = false;
  form.password = "";
  loading.value = false;
};
</script>

<template>
  <v-dialog v-model="dialog" persistent width="400">
    <template v-slot:activator="{ props }">
      <v-btn
        color="success"
        variant="flat"
        class="mx-1"
        type="submit"
        :loading="loading"
        size="small"
        @click="startConfirmingPassword"
        :disabled="disabled"
      >
        Aplicar
      </v-btn>
    </template>
    <v-card color="black">
      <v-card-title class="text-center"> Confirma contraseña </v-card-title>
      <v-card-text>
        <p>Por su seguridad, confirme su contraseña para continuar.</p>
        <AlertByAction
          :status="status_alert"
          :message="message_alert"
          v-if="message_alert != null"
        />
        <v-container>
          <v-row>
            <v-col cols="12">
              <v-text-field
                ref="passwordInput"
                v-model="form.password"
                name="password"
                label="Contraseña"
                :append-inner-icon="is_password_visible ? mdiEye : mdiEyeOff"
                :type="is_password_visible ? 'text' : 'password'"
                @click:append-inner="is_password_visible = !is_password_visible"
                :error-messages="message_alert != null ? message_alert : ''"
                @keyup.enter="confirm_password"
              ></v-text-field>
            </v-col>
          </v-row>
        </v-container>
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn
          color="delete"
          variant="flat"
          size="small"
          @click="close(), (dialog = false), (message_alert = null), (loading = false)"
        >
          Cerrar
        </v-btn>
        <v-btn
          color="success"
          variant="flat"
          type="submit"
          :loading="loading"
          size="small"
          :disabled="form.processing"
          @click="confirm_password"
        >
          Aplicar
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>
