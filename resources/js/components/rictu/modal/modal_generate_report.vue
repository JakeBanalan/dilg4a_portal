<template>
    <div v-if="visible" class="modal-background">
        <div class="modal fade show" tabindex="-1" style="display: block;">
            <div class="modal-dialog" style="margin-top: 5%; display: flex; align-items: center;">
                <div class="modal-content" style="width: 150%; margin-bottom: 5%;">
                    <div class="modal-header">
                        <div
                            style="width: 75px; height: 75px; border-radius: 50%; display: flex; align-items: center; justify-content: center; position: absolute; top: -18px; background-color: white; color: #4cae4c; left: 44%;">
                            <img :src="logo" style="width:60px; height:60px;">
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="row">

                                    <div class="col-lg-6">
                                        <SelectInput label="Type of Report" class="select-option"
                                            v-model="this.report_type">
                                            <option v-for="option in options" :key="option.value" :value="option.value">
                                                {{ option.label }}
                                            </option>
                                        </SelectInput>
                                    </div>
                                    <div class="col-lg-6">
                                        <SelectInput label="Select Quarter" class="select-option"
                                            v-model="this.selected_quarter">
                                            <option v-for="option in quarter" :key="option.value" :value="option.value">
                                                {{ option.label }}
                                            </option>
                                        </SelectInput>
                                    </div>

                                    <div class="col-lg-12 mt-4">
                                        <SelectInput label="Select Year" class="select-option"
                                            v-model="this.selected_year">
                                            <option v-for="option in year" :key="option.value" :value="option.value">{{
                                                option.label }}
                                            </option>
                                        </SelectInput>
                                    </div>

                                </div>


                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-outline-primary btn-fw btn-icon-text" @click="generate()">Export</button>
                        <button class="btn btn-outline-primary btn-fw btn-icon-text" @click="close()">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import dilg_logo from "../../../../assets/logo.png";
import TextInput from "../../micro/TextInput.vue";
import TextAreaInput from "../../micro/TextAreaInput.vue";
import SelectInput from "../../micro/SelectInput.vue";

import axios from 'axios'; // Import Axios library
import { toast } from "vue3-toastify";

export default {
    name: 'modal_complete_ta',
    data() {
        return {
            logo: dilg_logo,
            cid: null,
            completed_date: null,
            recommendation: null,
            report_type: null,
            selected_quarter: null,
            selected_year: null,
            options: [
                { label: 'PML', value: 1 },
                 { label: 'PSL', value: 2 },
            ],
            quarter: [
                { label: '1st Quarter', value: 1 },
                { label: '2nd Quarter', value: 2 },
                { label: '3rd Quarter', value: 3 },
                { label: '4th Quarter', value: 4 },
            ],
            year: [
                { label: '2030', value: 2030 },
                { label: '2029', value: 2029 },
                { label: '2028', value: 2028 },
                { label: '2027', value: 2027 },
                { label: '2026', value: 2026 },
                { label: '2025', value: 2025 },
                { label: '2024', value: 2024 },
            ]
        };
    },
    props: {
        visible: Boolean,
        id: Number,
        control_no: String,
        requested_by: String,
        request_date: String,
        office: String,
        request_type: String,
        sub_request_type: String
    },
    components: {
        TextInput,
        TextAreaInput,
        SelectInput
    },
    methods: {
        showToatSuccess(message) {
            toast.success(message, {
                autoClose: 1000,
            });
        },
        formatDate(date) {
            if (!date || date === '0000-00-00') {
                return null; // Return null if the date is null or '0000-00-00'
            } else {
                const formattedDate = new Date(date).toLocaleString('en-US', {
                    year: 'numeric',
                    month: 'short',
                    day: 'numeric',

                });
                return formattedDate;
            }
        },
        close() {
            this.$emit('close');
        },
        generate() {
            const rt = this.report_type;
            const sq = this.selected_quarter;
            const sy = this.selected_year;
            const url = `../../api/generate-report/${sy}/${sq}/${rt}?export=true`;
            window.open(url, '_blank');
            this.showToatSuccess('Successfully downloaded!');
            setTimeout(() => {
                location.reload();
            }, 1000); // Adjust the delay as needed
        }

    }
};
</script>