<template>
    <div class="container-scroller">
        <Navbar></Navbar>
        <div class="container-fluid page-body-wrapper">
            <Sidebar />
            <div class="main-panel">
                <div class="content-wrapper">
                    <BreadCrumbs />
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 mt-4">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <font-awesome-icon :icon="['fas', 'list']"></font-awesome-icon>&nbsp;
                                        Bids and Award Committee Resolution
                                    </h5>
                                    <div class="d-flex" style="float:right;margin-top:-50px;">
                                        <button type="button" class="btn btn-warning btn-icon-text mx-2"
                                            @click="SaveContent">
                                            <font-awesome-icon :icon="['fas', 'download']"></font-awesome-icon>
                                            Save
                                        </button>
                                        <button type="button" class="btn btn-success btn-icon-text mx-2"
                                            @click="exportToPDF">
                                            <font-awesome-icon :icon="['fas', 'file-export']"></font-awesome-icon>
                                            Export
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="card mb-4">
                                <div class="card-body a4-wrapper">
                                    <div>
                                        <div id="reso-editor" class="form-control p-0 quill-a4"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { library } from '@fortawesome/fontawesome-svg-core';
import Quill from 'quill';
import 'quill/dist/quill.snow.css';
import jsPDF from 'jspdf';
import html2canvas from 'html2canvas';

import Navbar from "../../layout/Navbar.vue";
import Sidebar from "../../layout/Sidebar.vue";
import FooterVue from "../../layout/Footer.vue";
import BreadCrumbs from "../../dashboard_tiles/BreadCrumbs.vue";

import {
    faSpinner, faCartShopping, faListCheck, faPesoSign, faSave,
    faDownload, faPen, faCalendar, faFileExport, faShare, faPlus
} from '@fortawesome/free-solid-svg-icons';

library.add(faSpinner, faCartShopping, faListCheck, faPesoSign, faSave,
    faDownload, faPen, faCalendar, faFileExport, faShare, faPlus);

export default {
    name: 'Resolution',
    data() {
        return {
            quill: null,
        };
    },
    components: {
        FontAwesomeIcon,
        Navbar,
        Sidebar,
        FooterVue,
        BreadCrumbs,
    },
    mounted() {
        this.initQuill();
    },
    methods: {
        initQuill() {
            const FontAttributor = Quill.import('attributors/class/font');
            FontAttributor.whitelist = ['times-new-roman', 'sofia', 'slabo', 'roboto', 'inconsolata', 'ubuntu'];
            Quill.register(FontAttributor, true);

            this.quill = new Quill('#reso-editor', {
                theme: 'snow',
                modules: {
                    toolbar: [
                        [{ 'font': FontAttributor.whitelist }, { 'size': [] }],
                        ['bold', 'italic', 'underline', 'strike'],
                        [{ 'color': [] }, { 'background': [] }],
                        [{ 'script': 'super' }, { 'script': 'sub' }],
                        [{ 'header': '1' }, { 'header': '2' }, 'blockquote', 'code-block'],
                        [{ 'list': 'ordered' }, { 'list': 'bullet' }, { 'indent': '-1' }, { 'indent': '+1' }],
                        ['direction', { 'align': [] }],
                        ['link', 'image', 'video', 'formula'],
                        ['clean']
                    ]
                }
            });

            // Allow clicking anywhere to focus
            // const editorContainer = document.querySelector('#reso-editor');
            // editorContainer.addEventListener('click', () => {
            //     this.quill.focus();
            // });
        },
        SaveContent() {
            if (!this.quill) {
                console.error("Quill is not initialized.");
                return;
            }

            // Get Quill Delta JSON (safe to store in DB JSON column)
            const delta = this.quill.getContents();

            // Optionally, also get HTML (if you need to display formatted content immediately)
            // const html = this.quill.root.innerHTML;
            // console.log("Delta:", delta);
            // Send to Laravel backend
            axios.post('../../api/PostResolution', {
                content: delta.ops // or html, depending on what you're storing
            })
                .then(response => {
                    this.$toast?.success("Content saved successfully!"); // if using Vue toast
                    console.log("Saved:", response.data);
                })
                .catch(error => {
                    console.error("Save failed:", error.response?.data || error.message);
                    this.$toast?.error("Failed to save content.");
                });
        },
        exportToPDF() {
            const editorContent = this.quill.root;
            const pdf = new jsPDF('p', 'mm', 'a4');

            html2canvas(editorContent, { scale: 2 }).then((canvas) => {
                const imgData = canvas.toDataURL('image/png');
                const pageWidth = pdf.internal.pageSize.getWidth();
                const pageHeight = pdf.internal.pageSize.getHeight();

                // 1 inch margins (25.4mm) top, left, right; 0.59 inch bottom (15mm)
                const marginTop = 25.4;
                const marginLeft = 25.4;
                const marginRight = 25.4;
                const marginBottom = 15;

                const usableWidth = pageWidth - marginLeft - marginRight;
                const imgHeight = (canvas.height * usableWidth) / canvas.width;
                let position = marginTop;
                let heightLeft = imgHeight;

                pdf.addImage(imgData, 'PNG', marginLeft, position, usableWidth, imgHeight);

                while (heightLeft > pageHeight - marginBottom - marginTop) {
                    heightLeft -= pageHeight - marginTop - marginBottom;
                    position = marginTop - heightLeft + imgHeight;
                    pdf.addPage();
                    pdf.addImage(imgData, 'PNG', marginLeft, position, usableWidth, imgHeight);
                }

                pdf.save('resolution.pdf');
            });
        }
    }
};
</script>

<style>
.a4-wrapper {
    display: flex;
    justify-content: center;
    align-items: flex-start;
    background: #f0f0f0;
    padding: 40px 0;
    overflow-x: auto;
}

.quill-a4 {
    background: white;
    width: 210mm;
    min-height: 297mm;
    padding: 25.4mm 25.4mm 15mm 25.4mm;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
    border-radius: 4px;
    overflow-y: visible;
}

.ql-toolbar.ql-snow {
    border-radius: 0.375rem 0.375rem 0 0;
    border-color: #ced4da;
    max-width: 210mm;
    margin: 0 auto;
}

.ql-container.ql-snow {
    border-radius: 0 0 0.375rem 0.375rem;
    border-color: #ced4da;
    min-height: 297mm;
    max-width: 210mm;
    margin: 0 auto;
}

.ql-font-times-new-roman {
    font-family: 'Times New Roman', Times, serif;
}
</style>
