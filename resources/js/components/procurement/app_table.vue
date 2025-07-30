<template>
    <table id="app_table" style="width: 100%;"
        class="table table-striped table-borderless display expandable-table dataTable no-footer" role="grid">
        <thead>
            <tr role="row">
                <th>Stock #</th>
                <th>Category</th>
                <th>Item</th>
                <th>Status</th>
                <th>Mode of Procurement</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>

    <!-- Approve Modal -->
    <div class="modal fade" id="approveModal" tabindex="-1" role="dialog" aria-labelledby="approveModalLabel"
        :aria-hidden="!isModalVisible">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="approveModalLabel">Approve Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="snInput">Stock Number (SN)</label>
                        <input type="text" id="snInput" v-model="snInput" class="form-control"
                            placeholder="Enter Stock Number" />
                    </div>
                    <label>Mode of Procurement</label>
                    <v-select id="procurement-select" v-model="modeOfProcTitle" :options="pr_typeOption" label="label"
                        :reduce="option => option.value"></v-select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        @click="closeModal">Cancel</button>
                    <button type="button" class="btn btn-success" @click="saveApproval">Save</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import vSelect from "vue-select";
import "vue-select/dist/vue-select.css";
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { library } from '@fortawesome/fontawesome-svg-core';
import { faDownload, faEye, faPaperPlane, faShareSquare, faTrash, faEdit, faCheck } from '@fortawesome/free-solid-svg-icons';
library.add(faEye, faPaperPlane, faDownload, faTrash, faShareSquare, faEdit, faCheck);
export default {
    components: {
        vSelect,
        FontAwesomeIcon,
    },
    name: 'app_table',
    props: {
        role: {
            type: String,
            default: ''
        }
    },

    emits: ['approve-item', 'edit-item'],
    data() {
        return {
            selectedAppId: null,
            snInput: '',
            isModalVisible: false,
            modeOfProcTitle: '',
            pr_typeOption: [
                { value: '1', label: 'Small Value Procuremen' },
                { value: '2', label: 'Shopping' },
                { value: '3', label: 'NP Lease of Venue' },
                { value: '4', label: 'Direct Contracting' },
                { value: '5', label: 'Agency to Agency' },
                { value: '6', label: 'Public Bidding' },
                { value: '7', label: 'Not Applicable N/A' }
            ],

        };
    },
    methods: {

        initializeTable(data) {
            if ($.fn.DataTable.isDataTable('#app_table')) {
                $('#app_table').DataTable().clear().rows.add(data).draw();
            } else {
                $('#app_table').DataTable({
                    data: data,
                    columns: [
                        { data: 'sn' },
                        { data: 'item_category_title' },
                        { data: 'item_title' },
                        {
                            data: 'app_status',
                            render: function (data) {
                                if (data === 'for approval') {
                                    return `<span class="badge badge-danger"><span class="text-danger">●</span> ${data.toUpperCase()}</span>`;
                                } else if (data === 'approve') {
                                    return `<span class="badge badge-success">${data.toUpperCase()}</span>`;
                                }
                                return data.toUpperCase();
                            },
                        },
                        {
                            data: 'mode_of_proc_title',
                        },
                        {
                            data: null,
                            orderable: false,
                            render: (data) => {
                                let buttons = '';
                                if (this.role !== 'gss_admin') {
                                    buttons += `<button class="btn btn-info edit-btn" data-id="${data.app_id}"><i class="fas fa-edit"></i> Edit</button>`;
                                }
                                if (this.role === 'gss_admin') {
                                    const disabled = data.app_status === 'approve' ? 'disabled' : '';
                                    buttons += ` <button class="btn btn-success approve-btn" data-id="${data.app_id}" ${disabled}><i class="fas fa-check"></i> Approve</button>`;
                                }
                                return buttons;
                            }
                        },
                    ],
                    order: [],
                });

                this.handleApproveButton();
                this.handleEditButton();
            }
        },
        handleApproveButton() {
            $('#app_table').off('click', '.approve-btn:not([disabled])').on('click', '.approve-btn:not([disabled])', (event) => {
                this.selectedAppId = $(event.target).data('id');
                this.snInput = '';
                this.isModalVisible = true;
                $('#approveModal').modal('show');
            });
        },
        handleEditButton() {
            $('#app_table').off('click', '.edit-btn').on('click', '.edit-btn', (event) => {
                const appId = $(event.target).data('id');
                this.$emit('edit-item', appId);
            });
        },
        closeModal() {
            this.isModalVisible = false;
            $('#approveModal').modal('hide');
        },
        saveApproval() {
            if (!this.snInput) {
                alert('Please enter a Stock Number (SN).');
                return;
            }
            this.$emit('approve-item', { appId: this.selectedAppId, sn: this.snInput, mode: this.modeOfProcTitle });
            this.closeModal();
        }
    }
};
</script>
