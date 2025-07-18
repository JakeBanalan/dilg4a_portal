<style>
.pull-right {
    position: absolute;
    right: 100px;
    top: 10px;
}

.pull-right-cancel {
    position: absolute;
    right: 10px;
    top: 10px;
}

.select2-selection__rendered {
    line-height: 30px !important;
    /* Adjust based on your form-control height */
    vertical-align: middle !important;
}

.select2-container .select2-selection--single {
    height: 40px !important;
    /* Match your form-control height */
    display: flex;
    align-items: center;
}

.select2-container--default .select2-selection--single {
    padding-top: 3px;
    /* Adjust padding if necessary */
}
</style>
<template>
    <div class="container-scroller">
        <Navbar />
        <div class="container-fluid page-body-wrapper">
            <Sidebar />
            <div class="main-panel">
                <div class="content-wrapper">
                    <BreadCrumbs />
                    <form class="form-sample" @submit.prevent="submitAppItem">
                        <div class="row">
                            <div class="col-md-12 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">Add New Item</h4>
                                        <p class="card-description">Enter item details below</p>
                                        <div class="form-group row">
                                            <label for="item-name" class="col-sm-3 col-form-label">Item Name</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="item-name"
                                                    placeholder="Item Name" v-model="sanitizedItemTitle" />
                                            </div>

                                        </div>
                                        <div class="form-group row">
                                            <label for="unit" class="col-sm-3 col-form-label">Unit</label>
                                            <div class="col-sm-9">
                                                <select class="form-control form-control-lg" id="unit"
                                                    v-model="formData.unit_id">
                                                    <option v-for="option in unitOption" :key="option.value"
                                                        :value="option.value">{{ option.label }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="category" class="col-sm-3 col-form-label">Category</label>
                                            <div class="col-sm-9">
                                                <v-select v-model="formData.category_id" :options="categoriesOption"
                                                    label="label" :reduce="option => option.value" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-12 text-right">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <FooterVue />
            </div>
        </div>
    </div>
</template>>

<script>

import Navbar from '../layout/Navbar.vue';
import Sidebar from '../layout/Sidebar.vue';
import FooterVue from '../layout/Footer.vue';
import BreadCrumbs from '../dashboard_tiles/BreadCrumbs.vue';
import axios from 'axios';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
import vSelect from "vue-select";
import "vue-select/dist/vue-select.css";

export default {
    name: 'Add PPMP',
    data() {
        return {
            unitOption: [
                { value: '1', label: 'piece' },
                { value: '2', label: 'box' },
                { value: '3', label: 'ream' },
                { value: '4', label: 'lot' },
                { value: '5', label: 'unit' },
                { value: '6', label: 'crtg' },
                { value: '7', label: 'pack' },
                { value: '8', label: 'tube' },
                { value: '9', label: 'roll' },
                { value: '10', label: 'can' },
                { value: '11', label: 'bottle' },
                { value: '12', label: 'set' },
                { value: '13', label: 'jar' },
                { value: '14', label: 'bundle' },
                { value: '15', label: 'pad' },
                { value: '16', label: 'book' },
                { value: '17', label: 'pouch' },
                { value: '18', label: 'dozen' },
                { value: '19', label: 'pair' },
                { value: '20', label: 'gallon' },
                { value: '21', label: 'cart' },
                { value: '22', label: 'pax' },
                { value: '23', label: 'liters' },
                { value: '24', label: 'meters' },
            ],
            modeOption: [
                { value: '1', label: 'Small Value Procurement' },
                { value: '2', label: 'Shopping' },
                { value: '3', label: 'NP Lease of Venue' },
                { value: '4', label: 'Direct Contracting' },
                { value: '5', label: 'Agency to Agency' },
                { value: '6', label: 'Public Bidding' },
                { value: '7', label: 'Not Applicable' },

            ],
            categoriesOption: [
                { value: '1', label: '2.1 Common Office Supplies' },
                { value: '2', label: '2.1.1 Papers' },
                { value: '3', label: '2.1.2 Supplies/Devices' },
                { value: '4', label: '2.1.3 Pencils/Pens/Water Color' },
                { value: '5', label: '2.1.4 Envelopes/Folders/Document Organizers' },
                { value: '6', label: '2.1.5 Checks' },
                { value: '7', label: '2.2 Common Training Supplies' },
                { value: '8', label: '2.3 Others' },
                { value: '9', label: '3.1 Letterhead, A4' },
                { value: '10', label: '3.2 Tarpaulins' },
                { value: '11', label: '3.3 T-shirts' },
                { value: '12', label: '3.4 Bags' },
                { value: '13', label: '3.5  Manuals' },
                { value: '14', label: '3.6  Banner' },
                { value: '15', label: '3.7 Leaflets' },
                { value: '16', label: '3.8 Brochures' },
                { value: '17', label: '3.9 Flyers' },
                { value: '18', label: '3.10 Primers' },
                { value: '19', label: '3.11 Handouts' },
                { value: '20', label: '3.12 Handbooks' },
                { value: '21', label: '3.13 Coffee Table Books' },
                { value: '22', label: '3.14 Other IECs' },
                { value: '23', label: '4.1 Parts for assembly (Desktop)' },
                { value: '24', label: '4.1.1. Processor' },
                { value: '25', label: '4.1.2. Motherboard' },
                { value: '26', label: '4.1.3. Memory' },
                { value: '27', label: '4.1.4. Hard disk' },
                { value: '28', label: '4.1.5. ATX Case' },
                { value: '29', label: '4.2 Printer' },
                { value: '30', label: '4.3 Fax Machine' },
                { value: '31', label: '4.4 Audio Visual Peripherals and Equipment' },
                { value: '32', label: '4.5 Network Accessories' },
                { value: '33', label: '4.6 Accessories' },
                { value: '34', label: '4.6.1. Speaker' },
                { value: '35', label: '4.6.2. External Hard Drive' },
                { value: '36', label: '4.6.3. USB Flash Drive' },
                { value: '37', label: '4.6.4. Mouse' },
                { value: '38', label: '4.6.5. Keyboard' },
                { value: '39', label: '4.7 Desktop' },
                { value: '40', label: '4.9 Replacement Parts & Accessories with equipment' },
                { value: '41', label: '5.1 Copier' },
                { value: '42', label: '5.2 Printer consumables not available in PS' },
                { value: '43', label: '6. Optical Drive' },
                { value: '44', label: '7.1 Audio and Video Recording' },
                { value: '45', label: '7.2 Audio and Video Editing' },
                { value: '46', label: '7.3 Live Streaming' },
                { value: '47', label: '7.4 Audio and Video Equipment Rentals' },
                { value: '48', label: '7.5 Others' },
                { value: '49', label: '8.1 Venue' },
                { value: '50', label: '8.2 Catering' },
                { value: '51', label: '8.3 Hotel & Accommodation ' },
                { value: '52', label: '8.4 Venue, accommodation, and food' },
                { value: '53', label: '9. Monitor' },
                { value: '54', label: '9.1 Metro Manila' },
                { value: '55', label: '9.2 Luzon' },
                { value: '56', label: '9.3 Visayas' },
                { value: '57', label: '9.4 Mindanao' },
                { value: '58', label: '10. UPS (Uninterrupted Power Supply)' },
                { value: '59', label: '10.1 Carpentry' },
                { value: '60', label: '10.2 Paint/Thinner' },
                { value: '61', label: '10.3 Partition & Fixtures ' },
                { value: '62', label: '11. Video Graphics Adapter (VGA)' },
                { value: '63', label: '11.1 Internet/Broadband/Leased Line' },
                { value: '64', label: '11.2 Janitorial Services' },
                { value: '65', label: '11.3 Pest Control' },
                { value: '66', label: '11.4 Supply & Delivery of Purified Drinking Water' },
                { value: '67', label: '11.5 Cable TV Subscription ' },
                { value: '68', label: '11.6 Electricity' },
                { value: '69', label: '11.7 Rental Fees' },
                { value: '70', label: '11.8 Repairs and Maintenance ' },
                { value: '71', label: '11.9 Others' },
                { value: '72', label: '12.1 Parts/Accessories' },
                { value: '73', label: '12.1.1 Batteries' },
                { value: '74', label: '12.1.2 Tires' },
                { value: '75', label: '12.1.3 Other Parts/Accessories' },
                { value: '76', label: '12.2 Preventive Car Maintenance' },
                { value: '77', label: '12.2.1 Change Oil' },
                { value: '78', label: '12.2.2 Tire Mounting ' },
                { value: '79', label: '12.2.3 Other Labor/Services' },
                { value: '80', label: '13.1 Medical Supplies & Equipment' },
                { value: '81', label: '13.2 Dental Supplies & Equipment' },
                { value: '82', label: '13.3 MEDICINES' },
                { value: '83', label: '13.3.1  ANALGESIC/ANTI-PYRETIC' },
                { value: '84', label: '13.3.2 ANTACID/ANTI-REFLUX' },
                { value: '85', label: '13.3.3 ANTI-BACTERIAL' },
                { value: '86', label: '13.3.4 BRONCHODILLATOR' },
                { value: '87', label: '13.3.5 ANTI-CHOLINERGIC' },
                { value: '88', label: '13.3.6 ANTI-DIABETIC' },
                { value: '89', label: '13.3.7 ANTI-DIARRHEAL' },
                { value: '90', label: '13.3.8 DYSLIPIDAEMIC' },
                { value: '91', label: '13.3.9 ANTI-EMETIC' },
                { value: '92', label: '13.3.10 ANTI-GOUT' },
                { value: '93', label: '13.3.11 ANTI-HISTAMINE' },
                { value: '94', label: '13.3.12 ANTI-HYPERTENSIVE' },
                { value: '95', label: '13.3.13 MULTI-VITAMINS' },
                { value: '96', label: '13.3.14 ANTI-THROMBOTIC' },
                { value: '97', label: '13.3.15 VACCINES' },
                { value: '98', label: '13.3.16 Others' },
                { value: '99', label: '14.1 Law Related References' },
                { value: '100', label: '14.2 Dictionaries' },
                { value: '101', label: '14.3 Encyclopedia' },
                { value: '102', label: '14.4 Children\'s Books (For DILG Day Care Center)' },
                { value: '103', label: '14.5 Maps' },
                { value: '104', label: '14.6 Charts/Posters' },
                { value: '105', label: '14.7 Others' },
                { value: '106', label: '15.1 Tables' },
                { value: '107', label: '15.2 Chairs' },
                { value: '108', label: '15.3 Cabinets' },
                { value: '109', label: '15.4 Mobile Pedestal' },
                { value: '110', label: '15.5 Kitchenware and Appliances' },
                { value: '111', label: '15.6 Shelves' },
                { value: '112', label: '15.7 Others (Mats, etc.)' },
                { value: '113', label: '16.1 Fire extinguisher/ firefighting equipment' },
                { value: '114', label: '16.2 Firearms & ammunitions' },
                { value: '115', label: '17.1 Plaques' },
                { value: '116', label: '17.2 Awards' },
                { value: '117', label: '17.3 Mugs' },
                { value: '118', label: '17.4 Umbrellas' },
                { value: '119', label: '17.5 Planners' },
                { value: '120', label: '17.6 Others' },
                { value: '121', label: '18.1 ICT resources' },
                { value: '122', label: '18.1.1 Tablet' },
                { value: '123', label: '18.1.2 Laptop' },
                { value: '124', label: '18.1.3 Copier' },
                { value: '125', label: '18.1.4 Printer' },
                { value: '126', label: '18.2 Communication Equipment' },
                { value: '127', label: '18.3 Office Equipment' },
                { value: '128', label: '18.3.1 Biometrics Machine' },
                { value: '129', label: '18.3.2 Barcode System' },
                { value: '130', label: '18.4 Desktop' },
                { value: '131', label: '19 Consulting Services' },
                { value: '134', label: '21.1 Gasoline (for Trainings/Seminar/Activities On' },
                { value: '135', label: '21.2 Plane Ticket' },
                { value: '136', label: '5.0 Others' },
                { value: '137', label: '6.1 Newspapers' },
            ],
            formData: {
                item_title: '',
                unit_id: '',
                category_id: '',
                userId: '',
                app_year: new Date().getFullYear(),
            },
            cardTitle: "Please provide the needed information below. Fill out all the required fields (*)."
        }


    },
    components: {
        Navbar,
        Sidebar,
        FooterVue,
        BreadCrumbs,
        vSelect
    },
    computed: {
        sanitizedItemTitle: {
            get() {
                return this.formData.item_title;
            },
            set(value) {
                // Accept only letters, numbers, and spaces
                this.formData.item_title = value.replace(/[^a-zA-Z0-9\s]/g, '');
            }
        }
    },
    methods: {
        showToatWarning() {
            toast.warning('Wow warning!', {
                autoClose: 1000,
            });
        },
        showToatSuccess(message) {
            toast.success(message, {
                autoClose: 1000,
            });
        },
        showToatInfo() {
            toast.info('Wow info!', {
                autoClose: 1000,
            });
        },
        mounted() {
            this.formData.userId = localStorage.getItem('userId');
        },
        created() {
            this.userId = localStorage.getItem('userId');
        },
        async submitAppItem() {
            try {

                this.formData.userId = localStorage.getItem('userId');
                const response = await axios.post('/api/app-items', this.formData);
                toast.success(response.data.message || 'Item added successfully!', { autoClose: 1000 });
                // ✅ Notify the gss_admin role
                this.notifyNewApproval();

                setTimeout(() => {
                    this.$router.push({ path: '/procurement/PPMP' });
                }, 1000);
            } catch (error) {
                const errorMsg = error.response?.data?.message || 'An error occurred while saving the item.';

                if (error.response?.status === 422 && errorMsg.includes('Duplicated')) {
                    toast.error('Duplicate item title. Please enter a unique title.', { autoClose: 1500 });
                } else {
                    toast.error(errorMsg, { autoClose: 1500 });
                }

                console.error('Submission error:', error);
            }
        },
        notifyNewApproval() {
            const iconPath = `${window.location.origin}/images/logo.png`;

            if (Notification.permission === "granted") {
                const notification = new Notification("New PPMP Added", {
                    body: "A new item has been added and is awaiting approval.",
                    icon: iconPath
                });

                notification.onclick = () => {
                    window.open(`${window.location.origin}/procurement/PPMP`, '_blank');
                };
            } else if (Notification.permission !== "denied") {
                Notification.requestPermission().then(permission => {
                    if (permission === "granted") {
                        const notification = new Notification("New PPMP Added", {
                            body: "A new item has been added and is awaiting approval.",
                            icon: iconPath
                        });

                        notification.onclick = () => {
                            window.open(`${window.location.origin}/procurement/PPMP`, '_blank');
                        };
                    }
                });
            }
        }

    },
}
</script>
