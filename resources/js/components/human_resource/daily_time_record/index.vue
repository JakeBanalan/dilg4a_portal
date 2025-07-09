<template>
    <div class="container-scroller">
        <Navbar />
        <div class="container-fluid page-body-wrapper">
            <Sidebar />
            <div class="main-panel">
                <div class="content-wrapper">
                    <BreadCrumbs />
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex justify-content-between align-items-center">
                                <h5 class="card-title">
                                    <font-awesome-icon :icon="['fas', 'list']" />
                                    &nbsp;Daily Time Record
                                </h5>
                                <div class="d-flex">
                                    <button class="btn btn-outline-primary btn-fw btn-icon-text mx-2"
                                        @click="openMonthlyRecordsTab">
                                        Add Monthly Records
                                    </button>
                                    <div class="btn-group mx-2">
                                        <button class="btn btn-outline-success btn-fw btn-icon-text dropdown-toggle"
                                            type="button" id="actionDropdown" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            Actions
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="actionDropdown">
                                            <li>
                                                <button class="dropdown-item" data-bs-toggle="modal"
                                                    data-bs-target="#importDTRModal">
                                                    Import DTR
                                                </button>
                                            </li>
                                            <li>
                                                <button class="dropdown-item" data-bs-toggle="modal"
                                                    data-bs-target="#exportModal">
                                                    Export Multiple DTR
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Search Bar -->
                            <div class="form-group mb-3" style="max-width: 200px; float: right;">
                                <input type="text" v-model="searchQuery" placeholder="Search name..."
                                    class="form-control" />
                            </div>

                            <div class="table-responsive">
                                <table style="width: 100%;"
                                    class="table table-striped table-borderless display expandable-table dataTable no-footer"
                                    role="grid">
                                    <thead>
                                        <tr>
                                            <th class="sorting_desc" tabindex="0" aria-controls="example" rowspan="1"
                                                colspan="1" aria-label="Product: activate to sort column ascending"
                                                aria-sort="descending">Employee Name
                                            </th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="record in filteredRecords" :key="record.id">
                                            <td style="font-size: 12pt;">{{ record.name }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-primary"
                                                    @click="viewRecordDetails(record.id)">
                                                    View Details
                                                </button>
                                            </td>
                                        </tr>
                                        <tr v-if="filteredRecords.length === 0">
                                            <td colspan="5" class="text-center">No records available</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <br />

                            <Pagination :total="pagination.total" :currentPage="pagination.current_page"
                                :itemsPerPage="pagination.per_page" @pageChange="fetchRecords" />
                            <div class="mb-2" style="font-weight: 500;">{{ showingEntriesMessage }}</div>
                        </div>
                    </div>
                </div>
                <FooterVue />
            </div>
        </div>

        <!-- Import DTR Modal -->
        <div class="modal fade" id="importDTRModal" tabindex="-1" role="dialog" aria-labelledby="importDTRModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="importDTRModalLabel"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <blockquote>
                            <form id="uploadForm" @submit.prevent="importDTR">
                                <div class="blockquote-custom-icon-task bg-info shadow-sm text-center mb-3">
                                    <i class="fa fa-upload text-white" style="font-size: 38pt;"></i>
                                </div>

                                <div class="row mb-3 border-bottom">
                                    <h2 class="text-center" style="color:#346e8c;"><b>IMPORT DTR</b></h2>
                                </div>

                                <div class="row mb-3" style="font-size:14px;">
                                    <i>
                                        <ul>
                                            <li> Make sure that internet connection is stable.</li>
                                            <li> Do not close/reload this page while importing is ongoing.</li>
                                            <li> Page will reload automatically once done.</li>
                                            <li> Upload time depends on file size.</li>
                                            <li> Please be patient during the process.</li>
                                        </ul>
                                    </i>
                                </div>

                                <!-- DATE RANGE -->
                                <div class="row mb-3">
                                    <!-- Date From -->
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label>Date From:</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="date" v-model="date_from" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Date To -->
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label>Date To:</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="date" v-model="date_to" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <label>File:</label>
                                    </div>
                                    <div class="col-md-7">
                                        <div class="form-group attendee">
                                            <div class="input-group">
                                                <label class="input-group-btn">
                                                    <span class="btn btn-primary">
                                                        Browse &hellip;
                                                        <input type="file" name="uploadfile" id="uploadfile"
                                                            style="display: none;" @change="handleFileUpload" required
                                                            accept=".xls,.xlsx,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" />

                                                    </span>

                                                </label>
                                                &nbsp;
                                                <input type="text" id="uploadtxt" class="form-control" readonly
                                                    :value="fileName">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Progress Bar -->
                                <div v-if="uploading" class="progress mb-3">
                                    <div class="progress-bar" role="progressbar"
                                        :style="{ width: uploadProgress + '%' }">
                                        {{ uploadProgress }}%
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <button type="button" class="btn btn-secondary btn-md btn-block"
                                            data-bs-dismiss="modal">
                                            <span class="fa fa-close"></span> Cancel
                                        </button>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="submit" class="btn btn-primary btn-md btn-block"
                                            :disabled="uploading">
                                            <span v-if="uploading">Uploading...</span>
                                            <span v-else><span class="fa fa-upload"></span> Start</span>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </blockquote>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Import DTR Modal -->

        <!-- Export Multiple DTR Modal -->
        <div class="modal fade" id="exportModal" tabindex="-1" role="dialog" aria-labelledby="exportModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exportModalLabel"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <blockquote>
                            <form @submit.prevent="exportMultipleDTR">
                                <div class="blockquote-custom-icon-task bg-info shadow-sm">
                                    <i class="fa fa-download text-white" style="font-size: 38pt;"></i>
                                </div>

                                <div class="col-md-12 pull-right" style="position: absolute; top: 7px; left: -7%;">
                                    <div class="row">
                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="row" style="margin-bottom: 3%; border-bottom: 1px solid lightgray;">
                                        <h2 class="text-center" style="color:#4cae4c;"><b>EXPORT MULTIPLE DTR</b>
                                        </h2>
                                    </div>
                                </div>

                                <hr>

                                <div class="progress_tracker" style="margin-bottom: 1%;">
                                    <b><span class="progress_tracker_txt"></span></b>
                                </div>


                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <label>Office:</label>
                                    </div>
                                    <div class="col-md-7">
                                        <select v-model="exportOffice" class="form-control" required>
                                            <option value="">-- Select Office --</option>
                                            <option v-for="office in pmo" :key="office.value" :value="office.value">
                                                {{ office.label }}
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <label>Year:</label>
                                    </div>
                                    <div class="col-md-7">
                                        <select v-model="exportYear" class="form-control" required
                                            :disabled="!exportOffice">
                                            <option value="">-- Select Year --</option>
                                            <option v-for="year in yearOptions" :key="year" :value="year">{{ year }}
                                            </option>
                                        </select>
                                        <span v-if="!exportOffice" class="text-danger" style="font-size: 12pt;">Please
                                            select office first</span>
                                    </div>
                                </div>


                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <label>Month:</label>
                                    </div>
                                    <div class="col-md-7">
                                        <select v-model="exportMonth" class="form-control" :disabled="!exportYear"
                                            required>
                                            <option value="">-- Select Month --</option>
                                            <option v-for="(label, value) in monthOptions" :key="value" :value="value">
                                                {{ label }}
                                            </option>
                                        </select>
                                        <span v-if="!exportYear" class="text-danger" style="font-size: 12pt;">Please
                                            select year first</span>
                                    </div>
                                </div>

                                <div v-if="exporting" class="progress mb-3">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated"
                                        role="progressbar" :style="{ width: exportProgress + '%' }">
                                        {{ exportProgress }}%
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <button type="button" class="btn btn-secondary btn-md btn-block"
                                            data-bs-dismiss="modal">
                                            <span class="fa fa-close"></span> Cancel
                                        </button>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="submit" class="btn btn-success btn-md btn-block">
                                            <span class="fa fa-download"></span> Start
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </blockquote>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Export Multiple DTR Modal -->


    </div>
</template>

<script>
import Navbar from "../../layout/Navbar.vue";
import Sidebar from "../../layout/Sidebar.vue";
import FooterVue from "../../layout/Footer.vue";
import BreadCrumbs from "../../dashboard_tiles/BreadCrumbs.vue";
import Pagination from "../../procurement/Pagination.vue";
import axios from "axios";
import _ from 'lodash';
export default {
    name: "DailyTimeRecords",
    components: { Navbar, Sidebar, FooterVue, BreadCrumbs, Pagination },
    data() {
        return {
            records: [],
            pagination: { total: 0, current_page: 1 },
            file: null,
            uploading: false,
            uploadProgress: 0,
            exporting: false,
            exportProgress: 0,
            fileName: "",
            monthlyRecords: [],
            searchQuery: "",
            date_from: '',
            date_to: '',
            exportOffice: '',
            exportMonth: '',
            exportYear: '',
            pmo: [
                { value: '1', label: 'ORD-Legal' },
                { value: '2', label: 'ORD-Planning' },
                { value: '3', label: 'LGMED-MBRTG' },
                { value: '4', label: 'LGCDD-PDMU' },
                { value: '5', label: 'FAD' },
                { value: '6', label: 'ORD-RICTU' },
                { value: '7', label: 'LGCDD' },
                { value: '8', label: 'LGMED' },
                { value: '9', label: 'BATANGAS' },
                { value: '10', label: 'CAVITE' },
                { value: '11', label: 'LAGUNA' },
                { value: '12', label: 'QUEZON' },
                { value: '13', label: 'RIZAL' },
                { value: '14', label: 'LUCENA CITY' },
                { value: '15', label: 'ORD' },
            ],

            monthOptions: {
                1: 'January',
                2: 'February',
                3: 'March',
                4: 'April',
                5: 'May',
                6: 'June',
                7: 'July',
                8: 'August',
                9: 'September',
                10: 'October',
                11: 'November',
                12: 'December'
            },
            yearOptions: []
        };
    },
    computed: {
        filteredRecords() {
            return this.records.filter(record =>
                record.name.toLowerCase().includes(this.searchQuery.toLowerCase())
            );
        },


        showingEntriesMessage() {
            const currentPage = this.pagination.current_page || 1;
            const itemsPerPage = this.pagination.per_page || 10;
            const total = this.pagination.total || 0;

            const start = total > 0 ? (currentPage - 1) * itemsPerPage + 1 : 0;
            const end = Math.min(start + itemsPerPage - 1, total);

            return `Showing ${start} to ${end} of ${total} entries`;
        }
    },

    methods: {
        fetchRecords(page = 1, search = '') {
            // Sanitize search query to prevent malicious input
            const sanitizedSearch = search.replace(/[^a-zA-Z0-9\s]/g, '').trim();

            axios
                .get(`/api/daily-time-records`, {
                    params: { page, search: sanitizedSearch },
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('api_token')}`, // Include authorization token
                    },
                })
                .then(response => {
                    // Validate response structure
                    if (response.data && response.data.data && Array.isArray(response.data.data)) {
                        this.records = response.data.data;
                        this.pagination = response.data;
                    } else {
                        console.error('Unexpected response format:', response.data);
                        alert('Failed to fetch records. Please try again later.');
                    }
                })
                .catch(error => {
                    console.error('Error fetching records:', error.response || error);
                    alert('An error occurred while fetching records. Please try again later.');
                });
        },

        viewRecordDetails(userId) {
            // Ensure userId is a valid number before navigating
            if (!Number.isInteger(userId)) {
                alert('Invalid user ID.');
                return;
            }
            this.$router.push({ name: 'View Monthly Records', params: { userId } });
        },

        openMonthlyRecordsTab() {
            // Open the monthly records tab securely
            window.open("/human_resource/daily_time_record/monthly", "_blank");
        },

        handleFileUpload(event) {
            const file = event.target.files[0];
            const allowedTypes = [
                "application/vnd.ms-excel",
                "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
            ];
            const allowedExtensions = ['xls', 'xlsx'];

            if (!file) {
                this.file = null;
                this.fileName = '';
                return;
            }

            const fileExt = file.name.split('.').pop().toLowerCase();

            if (!allowedTypes.includes(file.type) || !allowedExtensions.includes(fileExt)) {
                alert("Please upload a valid Excel file (.xls or .xlsx)");
                this.file = null;
                this.fileName = '';
                event.target.value = null;
                return;
            }

            this.file = file;
            this.fileName = file.name;
        },
        importDTR() {
            if (!this.file) {
                alert("Please select a file to upload.");
                return;
            }
            if (!this.date_from || !this.date_to) {
                alert("Please select date range.");
                return;
            }

            const formData = new FormData();
            formData.append("file", this.file);
            formData.append("date_from", this.date_from);
            formData.append("date_to", this.date_to);

            this.uploading = true;
            this.uploadProgress = 0;

            axios.post("/api/daily-time-records/import", formData, {
                headers: {
                    "Content-Type": "multipart/form-data",
                    Authorization: `Bearer ${localStorage.getItem('api_token')}`, // Include authorization token
                },
                onUploadProgress: progressEvent => {
                    if (progressEvent.total > 0) {
                        this.uploadProgress = Math.round((progressEvent.loaded / progressEvent.total) * 100);
                    }
                }
            })
                .then(() => {
                    alert("DTR imported successfully!");
                    location.reload();
                })
                .catch(error => {
                    console.error("Error importing DTR:", error.response || error);
                    alert("Failed to import DTR. Please try again later.");
                })
                .finally(() => {
                    this.uploading = false;
                    this.uploadProgress = 0;
                });
        },
        exportMultipleDTR() {
            if (!this.exportOffice || !this.exportMonth || !this.exportYear) {
                alert("Please complete all fields.");
                return;
            }

            const params = {
                office: this.exportOffice,
                month: this.exportMonth,
                year: this.exportYear
            };

            this.exporting = true;
            this.exportProgress = 30; // Simulate some progress immediately

            axios.get("/api/daily-time-records/export", {
                params,
                responseType: "blob",
                headers: {
                    Authorization: `Bearer ${localStorage.getItem('api_token')}`,
                },
                onDownloadProgress: progressEvent => {
                    if (progressEvent.lengthComputable) {
                        this.exportProgress = Math.round((progressEvent.loaded / progressEvent.total) * 100);
                    }
                }
            })
                .then(response => {
                    this.exportProgress = 100;

                    Swal.fire({
                        icon: 'success',
                        title: 'Export Complete',
                        text: 'Your DTR export is ready. Click OK to download.',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        const url = window.URL.createObjectURL(new Blob([response.data]));
                        const link = document.createElement("a");
                        link.href = url;

                        const disposition = response.headers['content-disposition'];
                        let filename = 'export.xlsx';
                        if (disposition && disposition.indexOf('filename=') !== -1) {
                            const filenameMatch = disposition.match(/filename="?([^"]+)"?/);
                            if (filenameMatch.length > 1) {
                                filename = filenameMatch[1];
                            }
                        }

                        link.setAttribute("download", filename);
                        document.body.appendChild(link);
                        link.click();
                        document.body.removeChild(link);
                        window.URL.revokeObjectURL(url);
                    });

                })
                .catch(error => {
                    console.error("Error exporting multiple DTR:", error.response || error);
                    alert("Failed to export multiple DTR. Please try again later.");
                })
                .finally(() => {
                    this.exporting = false;
                    this.exportProgress = 0;
                });
        }


    },
    watch: {
        searchQuery: _.debounce(function (newQuery) {
            this.fetchRecords(1, newQuery);
        }, 400),
        exportYear(newYear) {
            this.exportMonth = ''; // Reset month if year changes
        },

        exportOffice(newOffice) {
            this.exportYear = '';  // Reset year if office changes
            this.exportMonth = ''; // Also reset month just to be safe
        },
    },
    mounted() {
        this.fetchRecords();
        const currentYear = new Date().getFullYear();
        for (let i = 0; i < 5; i++) {
            this.yearOptions.push(currentYear - i);
        }
    },
};
</script>


<style scoped>
/* .modal-dialog {

    vertical-align: middle;

}


.blockquote {
    padding: 10px 20px;
    margin: 0 0 20px;
    font-size: 17.5px;
    border-left: 0px;
}

.blockquote-custom-icon-task {
    width: 75px;
    height: 75px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    position: absolute;
    top: -18px;
    background-color: white;
    color: #4cae4c;
    left: 44%;
} */
</style>
