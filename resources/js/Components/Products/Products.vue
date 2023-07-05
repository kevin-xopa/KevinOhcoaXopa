<script setup>
import { ref, onMounted } from "vue";
import CardItem from "./CardItem.vue";
import Create from "./Create.vue";
import Update from "./Update.vue";
import Delete from "./Delete.vue";
import ButtonForAction from "@/Components/Default/ButtonForAction.vue";
import ButtonLinkRedirect from "@/Components/Default/ButtonLinkRedirect.vue";
import LoadingData from "@/Components/Default/LoadingData.vue";
import ErrorLoadingData from "@/Components/Default/ErrorLoadingData.vue";
import Pagination from "@/Components/Default/Pagination.vue";
import Filter from "./Filter.vue";
import SearchBox from "@/Components/Default/SearchBox.vue";
import NoRecords from "@/Components/Default/NoRecords.vue";

const products = ref([]);
const item_update = ref(null);
const item_delete = ref(null);
const index = ref(-1);
const open_dialog_update = ref(false);
const open_dialog_delete = ref(false);
const page = ref(1);
const items_for_paginate = ref(20);
const recently = ref("");
const order_by = ref("ASC");
const needle = ref("");
const total = ref(0);
const charging = ref(false);
const status_request = ref(null);
const message_request = ref(null);
const total_visible = ref(4);
const view_num_products = ref(true);
const headers = [
    {
        title: "Sku",
        align: "center",
        key: "sku",
    },
    {
        title: "Name",
        align: "center",
        key: "name",
    },
    {
        title: "Dollar Price",
        align: "center ",
        key: "dollar_price",
    },
    {
        title: "Price Pesos",
        align: "center ",
        key: "price_pesos",
    },
    {
        title: "Points",
        align: "center ",
        key: "points",
    },
    {
        title: "Active",
        align: "center ",
        key: "active",
    },
    {
        title: "Created at",
        align: "center ",
        key: "created_at",
    },
    {
        title: "Updated at",
        align: "center ",
        key: "updated_at",
    },
    { title: "Acciones", key: "actions", sortable: false },
];

const get_products = async (n) => {
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
            `/api/products?items_for_paginate=${items_for_paginate.value}&recently=${recently.value}&view_num_products=${view_num_products.value}&needle=${needle.value}&order_by=${order_by.value}&page=${page.value}`
        );
        const { message, status } = response.data;
        const { data, last_page, current_page } = response.data.data;
        products.value = data;
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

const add_item = async (n) => {
    products.value.push(n);
    products.value.sort((a, b) => (a.name < b.name ? -1 : a.name > b.name ? 1 : 0));
};

const update_item = async (n) => {
    Object.assign(products.value[index.value], n);
};

const delete_item = async () => {
    products.value.splice(index.value, 1);
};

onMounted(() => {
    get_products();
});
</script>
<template>
    <v-row justify="center">
        <v-col cols="12" xl="3" lg="3" md="3" sm="6" xs="12" class="text-center">
            <SearchBox @search="get_products" @clean_search="get_products" />
        </v-col>
        <v-col cols="12" xl="3" lg="3" md="3" sm="6" xs="12" class="text-center">
            <Filter @filter="get_products" />
        </v-col>
        <v-col cols="12" xl="4" lg="4" md="4" sm="6" xs="12" class="text-center">
            <Create @new_item="add_item" />
        </v-col>
        <v-col cols="12" xl="1" lg="1" md="1" sm="3" xs="6" class="text-center">
            <ButtonLinkRedirect type="restore" route_name="products.dump" text="Basurero" />
        </v-col>
    </v-row>
    <div class="text-center" v-if="charging">
        <LoadingData />
    </div>
    <div class="text-center" v-else-if="!charging && status_request === null">
        <ErrorLoadingData @click-button-loading-data="get_products" :text="message_request" />
    </div>
    <v-row v-else-if="!charging && status_request == 200 && products.length > 0">
        <v-data-table v-model:items-per-page="items_for_paginate" :headers="headers" :items="products" item-value="name"
            class="data_table_color rounded-lg elevation-10" hide-default-footer>
            <!-- <template v-slot:item.balance="{ item }">
                <p>${{ item.raw.balance }}</p>
            </template> -->
            <template v-slot:item.actions="{ item }">
                <ButtonLinkRedirect size="x-small" type="more_info" route_name="product" text="Mas información"
                    class="text-right" :params="{ product: item.raw.url }" />
                <ButtonForAction type="update" class="text-right" @click="
                    (open_dialog_update = !open_dialog_update),
                    (item_update = item.raw),
                    (index = products.indexOf(item.raw))
                    " />
                <ButtonForAction type="delete" class="text-right" @click="
                    (open_dialog_delete = !open_dialog_delete),
                    (item_delete = item.raw),
                    (index = products.indexOf(item.raw))
                    " />
            </template>
        </v-data-table>
    </v-row>

    <div class="text-center" v-else>
        <NoRecords />
    </div>
    <v-col cols="12" v-show="total > 0">
        <Pagination :total_visible="total_visible" :length="total" :page="page" @page-is-updated="get_products" />
    </v-col>

    <Update :item="item_update" :dialog_prop="open_dialog_update" v-if="open_dialog_update"
        @close_dialog="(open_dialog_update = false), (index = -1)" @update_item="update_item" />

    <Delete :item="item_delete" :dialog_prop="open_dialog_delete" v-if="open_dialog_delete"
        @close_dialog="(open_dialog_delete = false), (index = -1)" @delete_item="delete_item" />
</template>
