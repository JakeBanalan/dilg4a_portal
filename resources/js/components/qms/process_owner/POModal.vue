<template>
    <div v-if="visible" class="modal-background">
        <div class="modal" tabindex="1" style="display: block;">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <div
                            style="width: 75px; height: 75px; border-radius: 50%; display: flex; align-items: center; justify-content: center; position: absolute; top: -18px; background-color: white; color: #4cae4c; left: 45%;">
                            <img :src="logo" style="width:60px; height:60px;">
                        </div>
                    </div>
                    <div class="modal-body" style="max-height: 650px; overflow:scroll;">
                        <table id="user_table" style="width:100%" class="table table-striped table-bordered">
                            <thead>
                                <tr role="row">
                                    <th>OFFICE</th>
                                    <th>NAME</th>
                                    <th>POSITION</th>
                                    <th>ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="user in UserList" :key="user.id">
                                    <td>{{ user.pmo_title }}</td>
                                    <td>{{ user.fname }}</td>
                                    <td>{{ user.position_title }}</td>
                                    <td>
                                        <button class="btn btn-icon mr-1" style="background-color:#059886;color:#fff;"
                                            @click="AddProcessOwner(user.id)">
                                            <font-awesome-icon :icon="['fas', 'plus']"></font-awesome-icon>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" style="float: right;margin-left:5px;"
                            @click="CloseModal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
import axios from "axios";
import dilg_logo from "../../../../assets/logo.png";
import { toast } from "vue3-toastify";

export default {
    data() {
        return {
            logo: dilg_logo,
            UserList: [],
        }
    },
    props: {
        visible: Boolean,
    },
    watch: {
        visible(val) {
            if (val) {
                this.fetchUser();
            }
        }
    },
    methods: {
        CloseModal() {
            this.$emit('close');
        },
        fetchUser() {
            axios.get('/api/fetchAllUser').then((response) => {
                this.UserList = response.data;
                const vm = this; // Save Vue instance context

                if ($.fn.DataTable.isDataTable('#user_table')) {
                    $('#user_table').DataTable().destroy();
                }
                $('#user_table').DataTable({
                    retrieve: true,
                    ordering: false,
                    paging: true,
                    pageLength: 10,
                    columns: [
                        { data: 'pmo_title' },
                        { data: 'fname' },
                        { data: 'position_title' },
                        {
                            data: null, orderable: false, render: function (data) {
                                return '<button class="btn btn-primary btn-fw btn-icon-text mx-2" data-id="' + data.id + '">Add</button>';
                            },
                        },
                    ],
                });

                // $('#user_table tbody').on('click', 'button', function () {
                //     const id = $(this).data('id');
                //     vm.AddProcessOwner(id);
                // });
            }).catch((error) => console.log(error));
        },
        AddProcessOwner(id) {
            this.$emit('addprocessowner', id);
        }
    }
}
</script>


<style>
.err-msg {
    font-style: italic;
    font-size: 4;
    color: red;
}

/* Style for dimming the background */
.modal-background {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    /* Adjust the opacity to make it darker or lighter */
    /* z-index: 10502; */
    /* Ensure it's above other elements */
}

/* Style for centering the modal */
.modal-dialog {
    top: -6%;

    /* Adjust as needed */
}

.selected img {
    border: 2px solid #007bff;
    /* Change the border color as needed */
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
    /* Change the box shadow as needed */
}

div::-webkit-scrollbar {
    display: none;
}
</style>