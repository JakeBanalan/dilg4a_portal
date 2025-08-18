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

    <!-- Reject Modal -->
    <div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel"
        :aria-hidden="!isRejectModalVisible">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="rejectModalLabel">Reject Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to reject this item? This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        @click="closeRejectModal">Cancel</button>
                    <button type="button" class="btn btn-danger" @click="confirmReject">Confirm Reject</button>
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
import { toast } from 'vue3-toastify';
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
        },
        userId: {
            type: [String, Number],
            default: null
        }
    },
    emits: ['approve-item', 'edit-item', 'refresh'],
    data() {
        return {
            selectedAppId: null,
            snInput: '',
            isModalVisible: false,
            modeOfProcTitle: '',
            pr_typeOption: [
                { value: '1', label: 'Small Value Procurement' },
                { value: '2', label: 'Shopping' },
                { value: '3', label: 'NP Lease of Venue' },
                { value: '4', label: 'Direct Contracting' },
                { value: '5', label: 'Agency to Agency' },
                { value: '6', label: 'Public Bidding' },
                { value: '7', label: 'Not Applicable N/A' }
            ],
            isRejectModalVisible: false,
            selectedRejectAppId: null,
            dataTable: null,
        };
    },
    mounted() {
        if (this.userId) {
            this.listenForEvents();
        } else {
            toast.error('User ID is missing. Please log in again.', { autoClose: 1500 });
        }
    },
    beforeDestroy() {
        window.Echo.leaveChannel('app-item');
    },
    methods: {
        initializeTable(data) {
            if (!Array.isArray(data)) {
                toast.error('Invalid data format for table.', { autoClose: 1500 });
                return;
            }

            if (this.dataTable) {
                // ✅ Just refresh rows
                this.dataTable.clear().rows.add(data).draw();
            } else {
                // ✅ Initialize only once
                this.dataTable = $('#app_table').DataTable({
                    data,
                    columns: [
                        { data: 'sn', defaultContent: '' },
                        { data: 'item_category_title', defaultContent: '' },
                        { data: 'item_title', defaultContent: '' },
                        {
                            data: 'app_status',
                            render: function (data) {
                                if (data === 'for approval') {
                                    return `<span class="badge badge-danger"><span class="text-danger">●</span> ${data.toUpperCase()}</span>`;
                                } else if (data === 'approve') {
                                    return `<span class="badge badge-success">${data.toUpperCase()}</span>`;
                                }
                                return data ? data.toUpperCase() : '';
                            },
                        },
                        { data: 'mode_of_proc_title', defaultContent: '' },
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
                                    buttons += `
                  <button class="btn btn-success approve-btn" data-id="${data.app_id}" ${disabled}>
                    <i class="fas fa-check"></i> Approve
                  </button>
                  <button class="btn btn-danger reject-btn" data-id="${data.app_id}" ${disabled}>
                    <i class="fas fa-trash"></i> Reject
                  </button>`;
                                }
                                return buttons;
                            }
                        },
                    ],
                    order: [],
                    drawCallback: () => {
                        this.rebindButtons();
                    },
                });
            }

            // Rebind buttons each time rows change
            this.rebindButtons();
        },
        rebindButtons() {
            this.handleApproveButton();
            this.handleEditButton();
            this.handleRejectButton();
        },
        handleRejectButton() {
            $('#app_table').off('click', '.reject-btn').on('click', '.reject-btn', (event) => {
                this.selectedRejectAppId = $(event.currentTarget).data('id');
                this.openRejectModal(this.selectedRejectAppId);
            });
        },
        handleApproveButton() {
            $('#app_table').off('click', '.approve-btn:not([disabled])').on('click', '.approve-btn:not([disabled])', (event) => {
                this.selectedAppId = $(event.currentTarget).data('id');
                this.snInput = '';
                this.isModalVisible = true;
                $('#approveModal').modal('show');
            });
        },
        handleEditButton() {
            $('#app_table').off('click', '.edit-btn').on('click', '.edit-btn', (event) => {
                const appId = $(event.currentTarget).data('id');
                this.$emit('edit-item', appId);
            });
        },
        closeModal() {
            this.isModalVisible = false;
            $('#approveModal').modal('hide');
        },
        saveApproval() {
            if (!this.snInput) {
                toast.error('Please enter a Stock Number (SN).', { autoClose: 1500 });
                return;
            }
            this.$emit('approve-item', { appId: this.selectedAppId, sn: this.snInput, mode: this.modeOfProcTitle });
            this.closeModal();
        },
        openRejectModal(appId) {
            this.selectedRejectAppId = appId;
            this.isRejectModalVisible = true;
            $('#rejectModal').modal('show');
        },
        closeRejectModal() {
            this.isRejectModalVisible = false;
            $('#rejectModal').modal('hide');
        },
        confirmReject() {
            axios.delete(`/api/app-items/${this.selectedRejectAppId}`)
                .then(res => {
                    toast.success(res.data.message || 'Item rejected successfully.', { autoClose: 1500 });
                    this.closeRejectModal();
                    this.$emit('refresh');
                })
                .catch(err => {
                    toast.error(err.response?.data?.error || 'Failed to reject item.', { autoClose: 1500 });
                });
        },
        showNotification(title, body, iconPath) {
            if (Notification.permission === 'granted') {
                const n = new Notification(title, { body, icon: iconPath });
                n.onclick = () => window.open(`${window.location.origin}/procurement/PPMP`, '_blank');
            } else if (Notification.permission !== 'denied') {
                Notification.requestPermission().then(permission => {
                    if (permission === 'granted') {
                        this.showNotification(title, body, iconPath);
                    }
                }).catch(err => console.error('Notification permission error:', err));
            }
        },
        listenForEvents() {
            const channel = window.Echo.channel('app-item');

            // 🔑 Prevent multiple bindings
            channel.stopListening('AppItemApproved')
                .stopListening('AppItemRejected');

            const iconPath = `${window.location.origin}/images/logo.png`;

            channel.listen('AppItemApproved', (e) => {
                if (+e.user_id === +this.userId) {
                    toast.success(`Your item "${e.item_title}" has been approved.`, { autoClose: 3000 });
                    this.showNotification('Item Approved', `Your item "${e.item_title}" has been approved.`, iconPath);
                    this.$emit('refresh');
                }
            });

            channel.listen('AppItemRejected', (e) => {
                if (+e.user_id === +this.userId) {
                    toast.error(`Your item "${e.item_title}" has been rejected.`, { autoClose: 3000 });
                    this.showNotification('Item Rejected', `Your item "${e.item_title}" has been rejected.`, iconPath);
                    this.$emit('refresh');
                }
            });
        },


    }
};
</script>
