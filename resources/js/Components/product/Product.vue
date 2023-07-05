<script setup>
import { ref, onMounted, computed } from "vue";
import { usePage } from "@inertiajs/vue3";
import ButtonForAction from "@/Components/Default/ButtonForAction.vue";
import Update from "./Update.vue";
import LoadingData from "@/Components/Default/LoadingData.vue";
import ErrorLoadingData from "@/Components/Default/ErrorLoadingData.vue";
import CodesProduct from "@/Components/CodesProduct/CodesProduct.vue";
import ProductCosts from "@/Components/ProductCosts/ProductCosts.vue";
import CardItem from "./CardItem.vue";
import NoRecords from "@/Components/Default/NoRecords.vue";

const products = ref([]);
const departments = ref([]);
const presentations = ref([]);
const branch_offices = ref([]);
const statuses_products = ref([]);
const charging = ref(false);
const status_request = ref(null);
const message_request = ref(null);
const view_edit = ref(false);

// computed
const user = computed(() => {
  return usePage().props.user;
});

const get_statuses_products = async () => {
  let response = await axios.get("/api/admin/statuses?schema=productos");
  statuses_products.value = response.data.data;
};

const get_departments = async () => {
  let response = await axios.get("/api/departments");
  departments.value = response.data.data;
};

const get_presentations = async () => {
  let response = await axios.get("/api/presentations");
  presentations.value = response.data.data;
};

const get_product = async (n) => {
  try {
    charging.value = true;
    let response = await axios.get(`/api/products?product=${route().params.product}`);
    const { data, message, status } = response.data;
    products.value = data;
    charging.value = false;
    status_request.value = status;
    message_request.value = message;
  } catch (e) {
    // if (e.response.request.status === 500) {
    //   message_request.value = e.response.request.statusText;
    //   charging.value = false;
    // }
  }
};

const update_item = async (n) => {
  if (products.value[0].slug != n.slug) {
    view_edit.value = true;
  } else {
    Object.assign(products.value[0], n);
    view_edit.value = false;
  }
};

onMounted(() => {
  get_statuses_products();
  get_departments();
  get_presentations();
  get_product();
});
</script>
<template>
  <div class="text-center" v-if="charging">
    <LoadingData />
  </div>
  <div class="text-center" v-else-if="!charging && status_request === null">
    <ErrorLoadingData @click-button-loading-data="get_product" :text="message_request" />
  </div>
  <v-row v-else-if="!charging && status_request == 200 && products.length > 0">
    <v-col cols="12" v-for="(item, i) in products" :key="i">
      <CardItem :item="item" :view_edit="view_edit">
        <br />
        <ButtonForAction
          type="update"
          class="ml-4 mb-6"
          @click="view_edit = !view_edit"
          v-if="view_edit == false"
        />
        <Update
          v-if="user.rol === 'admin' && view_edit"
          :item="item"
          :statuses_products="statuses_products"
          :departments="departments"
          :presentations="presentations"
          @update_item="update_item"
          @close_dialog="view_edit = false"
        />
      </CardItem>
    </v-col>
    <v-col cols="12">
      <CodesProduct />
    </v-col>
    <v-col cols="12">
      <ProductCosts />
    </v-col>
  </v-row>
  <div class="text-center" v-else>
    <NoRecords />
  </div>
</template>
