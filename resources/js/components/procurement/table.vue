<template>
    <div class="table-container">
        <table class="table table-striped table-bordered" style="table-layout: fixed;">
            <thead>
                <tr>
                    <th v-for="column in columns" :key="column">{{ column }}</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="item in data" :key="item.id">
                    <td v-for="column in columns" :key="column"
                        style="white-space: normal; width: calc(100% / {{ columns.length }}); ">
                        <!-- Check if the column is 'ACTION' -->
                        <template v-if="column === 'app_price'">
                            <div class="template-demo">
                                {{ formatAppPrice(item[column]) }}
                            </div>

                        </template>
                        <template v-else-if="column === 'total'">
                            <div class="template-demo" style="font-weight: bolder;">
                                {{ formatAppPrice(item[column]) }}
                            </div>

                        </template>
                        <template v-else-if="column === 'action'">
                            <div class="template-demo">

                                <button type="button" class="btn btn-success btn-rounded btn-icon"
                                    @click="openModal(item.app_id)">
                                    <font-awesome-icon :icon="['fas', 'pen-to-square']" />
                                </button>
                                <button type="button" class="btn btn-primary btn-rounded btn-icon"
                                    @click="removePrItems(item.app_id)"><i class="ti-trash"></i></button>
                            </div>
                        </template>
                        <!-- If not 'ACTION', display the regular item[column] content -->
                        <template v-else>
                            {{ item[column] }}
                        </template>
                    </td>
                </tr>
            </tbody>
        </table>
        <!-- Modal component -->
        <ModalDefault :visible="modalVisible" @close="closeModal" :appId="selectedItem" />
    </div>
</template>

<script>
import { formatTotalAmount } from '../../globalMethods';
import ModalDefault from '../procurement/modal_showItemDetails.vue';
import { toast } from "vue3-toastify";

import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { library } from '@fortawesome/fontawesome-svg-core';
import { faEye, faPenToSquare } from '@fortawesome/free-solid-svg-icons';
library.add(faPenToSquare, faEye);

export default {
    components: {
        ModalDefault,
        FontAwesomeIcon
    },
    props: {
        data: {
            type: Array,
            required: true,
        },
        columns: {
            type: Array,
            required: true,
        },
    },
    data() {
        return {
            modalVisible: false,
            selectedItem: null,
            appId: null,
            app_price: null
        };
    },
    methods: {
        openModal(appId) {
            this.selectedItem = appId;
            this.modalVisible = true;
        },
        closeModal() {
            this.modalVisible = false;
        },

        removePrItems(selectedItemIds) {
            // Make an API call to your server to remove the selected items from the database
            axios.post('/api/post_remove_pritem', {
                pr_id: this.$route.query.id,
                itemIds: selectedItemIds
            })
                .then((response) => {
                    // Handle the success response
                    toast.success('Cart details successfully updated', {
                        autoClose: 1000
                    });
                    // location.reload();
                })
                .catch((error) => {
                    // Handle the error
                    console.error('Error removing items from the database:', error);
                });
        },
        formatAppPrice(price) {
            return formatTotalAmount(price);
        }
    },
};
</script>
