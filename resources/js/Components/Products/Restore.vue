<script setup>
import { ref, onMounted } from "vue";
import CardItem from "./CardItem.vue";
import Delete from "./Delete.vue";
import Retrieve from "./Retrieve.vue";
import ButtonForAction from "@/Components/Default/ButtonForAction.vue";
import LoadingData from "@/Components/Default/LoadingData.vue";
import ErrorLoadingData from "@/Components/Default/ErrorLoadingData.vue";
import Pagination from "@/Components/Default/Pagination.vue";
import Filter from "./Filter.vue";
import SearchBox from "@/Components/Default/SearchBox.vue";
import NoRecords from "@/Components/Default/NoRecords.vue";

const presentations = ref([]);
const item_restore = ref(null);
const item_delete = ref(null);
const index = ref(-1);
const page = ref(1);
const open_dialog_restore = ref(false);
const open_dialog_delete = ref(false);
const items_for_paginate = ref(16);
const recently = ref("");
const order_by = ref("ASC");
const needle = ref("");
const total = ref(0);
const charging = ref(false);
const status_request = ref(null);
const message_request = ref(null);
const total_visible = ref(4);
const view_num_products = ref(true);

const get_presentations = async (n) => {
  try {
    if (n) {
      if (n.name === "filter") {
        items_for_paginate.value =
          n.value.items_for_paginate != null ? n.value.items_for_paginate : "";
        recently.value = n.value.recently != null ? n.value.recently : "";
      }
      page.value = n.name === "page" ? n.value : page.value;
      needle.value = n.name === "needle" ? n.value : needle.value;
      needle.value = n.name === "clean" ? "" : needle.value;
    }

    charging.value = true;
    let response = await axios.get(
      `/api/presentations?only_trashed=${true}&schema=${
        route().params.schema
      }&items_for_paginate=${items_for_paginate.value}&recently=${
        recently.value
      }&view_num_products=${view_num_products.value}&needle=${needle.value}&order_by=${
        order_by.value
      }&page=${page.value}`
    );
    const { message, status } = response.data;
    const { data, last_page, current_page } = response.data.data;
    presentations.value = data;
    total.value = last_page;
    page.value = current_page;
    charging.value = false;
    status_request.value = status;
    message_request.value = message;
  } catch (e) {
    if (e.response.request.status === 500) {
      message_request.value = e.response.request.statusText;
      charging.value = false;
    }
    console.log(e);
  }
};

const delete_item = async () => {
  presentations.value.splice(index.value, 1);
  index.value = -1;
};

onMounted(() => {
  get_presentations();
});
</script>
<template>
  <v-row justify="center">
    <v-col cols="12" xl="3" lg="3" md="3" sm="6" xs="12" class="text-center">
      <SearchBox @search="get_presentations" @clean_search="get_presentations" />
    </v-col>
    <v-col cols="12" xl="3" lg="3" md="3" sm="6" xs="12" class="text-center">
      <Filter @filter="get_presentations" />
    </v-col>
  </v-row>
  <div class="text-center" v-if="charging">
    <LoadingData />
  </div>
  <div class="text-center" v-else-if="!charging && status_request === null">
    <ErrorLoadingData
      @click-button-loading-data="get_presentations"
      :text="message_request"
    />
  </div>
  <v-row v-else-if="!charging && status_request == 200 && presentations.length > 0">
    <v-col
      cols="12"
      xl="2"
      lg="3"
      md="3"
      sm="4"
      xs="6"
      v-for="(item, i) in presentations"
      :key="i"
    >
      <CardItem :item="item">
        <v-col cols="12" class="text-right">
          <ButtonForAction
            type="restore"
            class="text-right"
            @click="
              (open_dialog_restore = !open_dialog_restore),
                (item_restore = item),
                (index = presentations.indexOf(item))
            "
          />
          <ButtonForAction
            type="delete"
            class="text-right"
            @click="
              (open_dialog_delete = !open_dialog_delete),
                (item_delete = item),
                (index = presentations.indexOf(item))
            "
          />
        </v-col>
      </CardItem>
    </v-col>
  </v-row>

  <div class="text-center" v-else>
    <NoRecords />
  </div>
  <v-col cols="12" v-show="total > 0">
    <Pagination
      :total_visible="total_visible"
      :length="total"
      
      :page="page"
      @page-is-updated="get_presentations"
    />
  </v-col>

  <Delete
    :permanent_delete="true"
    :item="item_delete"
    :dialog_prop="open_dialog_delete"
    v-if="open_dialog_delete"
    @close_dialog="(open_dialog_delete = false), (index = -1)"
    @delete_item="delete_item"
  />

  <Retrieve
    :item="item_restore"
    :dialog_prop="open_dialog_restore"
    v-if="open_dialog_restore"
    @close_dialog="(open_dialog_restore = false), (index = -1)"
    @restore_item="delete_item"
  />
</template>
