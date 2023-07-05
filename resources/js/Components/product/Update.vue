<script setup>
import { ref, computed, defineEmits } from "vue";
import { usePage, useForm } from "@inertiajs/vue3";
import { useVuelidate } from "@vuelidate/core";
import { required, decimal, helpers } from "@vuelidate/validators";
import { mdiPanoramaVariant } from "@mdi/js";
import { router } from "@inertiajs/vue3";
import OverlayRedirect from "@/Components/Default/OverlayRedirect.vue";
import AlertByAction from "@/Components/Default/AlertByAction.vue";

// props
const props = defineProps({
  departments: {
    required: true,
    type: Array,
  },
  presentations: {
    required: true,
    type: Array,
  },
  item: {
    required: true,
  },
  statuses_products: {
    required: true,
    type: Array,
  },
});

// emits
const emit = defineEmits(["update_item", "close_dialog"]);

// computed
const user = computed(() => {
  return usePage().props.user;
});

// const
const loading = ref(false);
const message_alert = ref(null);
const status_alert = ref(null);
const form = useForm(Object.assign({}, props.item));
const time = ref(null);
const overlay = ref(false);

// rules of validation
const rules_form = {
  name: {
    required: helpers.withMessage("Este campo no puede estar vacío", required),
  },
  price: {
    required: helpers.withMessage("Este campo no puede estar vacío", required),
    decimal: helpers.withMessage("Este campo solo puede ser un numérico", decimal),
  },
  state_slug: {
    required: helpers.withMessage("Este campo no puede estar vacío", required),
  },
  department_slug: {
    required: helpers.withMessage("Este campo no puede estar vacío", required),
  },
  presentation_slug: {
    required: helpers.withMessage("Este campo no puede estar vacío", required),
  },
};

const rules_photo = [
  (value) => {
    return (
      !value ||
      !value.length ||
      value[0].size < 2000000 ||
      "Avatar size should be less than 2 MB!"
    );
  },
];

const photo = null;

const v$ = useVuelidate(rules_form, form);

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
      form.updated_by = usePage().props.user.slug;
      let response = await axios.put("/api/admin/update-product", form);
      const { message, status, data } = response.data;
      message_alert.value = message;
      status_alert.value = status;
      if (status == 200) {
        if (data.slug != form.slug) {
          time.value = 3000;
          overlay.value = true;
          setTimeout(function () {
            router.visit(`${data.slug}`, { method: "get" });
          }, 3000);
        }
        data.user_name = usePage().props.user.name;
        data.user_surnames = usePage().props.user.surnames;
        data.user_slug = usePage().props.user.slug;
        emit("update_item", data);
        loading.value = false;
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
  <OverlayRedirect :time="time" :overlay="overlay" />

  <form @submit.prevent="update()">
    <v-card-title class="text-center"> Modificar producto </v-card-title>
    <v-card-text>
      <AlertByAction
        :status="status_alert"
        :message="message_alert"
        v-if="message_alert != null"
      />
      <v-container>
        <v-row>
          <v-col cols="12" xl="6" lg="6" md="12" sm="6" xs="12">
            <v-text-field
              id="name"
              v-model="form.name"
              label="Nombre"
              clearable
              required
              :error-messages="v$.name.$errors[0] ? v$.name.$errors[0].$message : ''"
              @change="v$.name.$touch()"
              @blur="v$.name.$touch()"
            ></v-text-field>
          </v-col>
          <v-col cols="12" xl="6" lg="6" md="12" sm="6" xs="12">
            <v-text-field
              id="price"
              v-model="form.price"
              label="Precio de venta en linea"
              clearable
              required
              type="number"
              :min="1"
              step="any"
              :error-messages="v$.price.$errors[0] ? v$.price.$errors[0].$message : ''"
              @change="v$.price.$touch()"
              @blur="v$.price.$touch()"
            ></v-text-field>
          </v-col>
          <v-col
            v-if="user.rol === 'admin'"
            cols="12"
            xl="6"
            lg="6"
            md="12"
            sm="12"
            xs="12"
          >
            <v-select
              id="state_product"
              :items="statuses_products"
              item-title="name"
              item-value="slug"
              v-model="form.state_slug"
              label="Estado en linea"
              required
              :error-messages="
                v$.state_slug.$errors[0] ? v$.state_slug.$errors[0].$message : ''
              "
              @change="v$.state_slug.$touch()"
              @blur="v$.state_slug.$touch()"
            ></v-select>
          </v-col>
          <v-col cols="12" xl="6" lg="6" md="12" sm="6" xs="12">
            <v-select
              id="department"
              :items="departments"
              item-title="name"
              item-value="slug"
              v-model="form.department_slug"
              label="Departamento"
              required
              :error-messages="
                v$.department_slug.$errors[0]
                  ? v$.department_slug.$errors[0].$message
                  : ''
              "
              @change="v$.department_slug.$touch()"
              @blur="v$.department_slug.$touch()"
            ></v-select>
          </v-col>
          <v-col cols="12" xl="6" lg="6" md="12" sm="6" xs="12">
            <v-select
              id="presentation"
              v-model="form.presentation_slug"
              item-title="name"
              item-value="slug"
              :items="presentations"
              label="Presentación"
              required
              :error-messages="
                v$.presentation_slug.$errors[0]
                  ? v$.presentation_slug.$errors[0].$message
                  : ''
              "
              @change="v$.presentation_slug.$touch()"
              @blur="v$.presentation_slug.$touch()"
            ></v-select>
          </v-col>
          <v-col cols="12" xl="6" lg="6" md="12" sm="12" xs="12">
            <v-file-input
              id="photo"
              show-size
              v-model="photo"
              :rules="rules_photo"
              accept="image/png, image/jpeg, image/bmp, image/jpg"
              placeholder="Elige una imagen"
              label="Fotografía"
              :prepend-inner-icon="mdiPanoramaVariant"
              prepend-icon=""
            ></v-file-input>
          </v-col>
        </v-row>
      </v-container>
    </v-card-text>
    <v-card-actions>
      <v-spacer></v-spacer>
      <v-btn color="delete" variant="flat" @click="close" size="small"> Cancelar </v-btn>
      <v-btn color="success" variant="flat" type="submit" :loading="loading" size="small">
        Aplicar
      </v-btn>
    </v-card-actions>
  </form>
</template>
