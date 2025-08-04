<template>
    <div class="container-scroller">
        <Navbar />
        <div class="container-fluid page-body-wrapper">
            <Sidebar />
            <div class="main-panel">
                <div class="content-wrapper">
                    <BreadCrumbs />
                    <div class="row">
                        <div class="col-lg-12 mt-4">
                            <div class="card mb-4">
                                <div class="card-body d-flex justify-content-between align-items-center">
                                    <h5 class="card-title mb-0">
                                        <font-awesome-icon :icon="['fas', 'list']" />
                                        Bids and Award Committee Resolution
                                    </h5>
                                    <div>
                                        <button class="btn btn-warning btn-icon-text mx-2" @click="saveContent">
                                            <font-awesome-icon :icon="['fas', 'download']" />
                                            Save
                                        </button>
                                        <button class="btn btn-success btn-icon-text mx-2" @click="exportToPDF">
                                            <font-awesome-icon :icon="['fas', 'file-export']" />
                                            Export
                                        </button>
                                        <button class="btn btn-primary btn-icon-text mx-2" @click="printContent">
                                            <font-awesome-icon :icon="['fas', 'print']" />
                                            Print
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-4">
                                <div class="main-container">
                                    <div class="editor-container editor-container_classic-editor editor-container_include-style editor-container_include-word-count editor-container_include-fullscreen"
                                        ref="editorContainerElement">
                                        <div class="editor-container__editor">
                                            <div ref="editorElement">
                                                <ckeditor v-if="editor && config" v-model="editorData" :editor="editor"
                                                    :config="config" @ready="onReady" />
                                            </div>
                                        </div>
                                        <div class="editor_container__word-count" ref="editorWordCountElement"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <FooterVue />
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed, ref, onMounted, nextTick } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import axios from 'axios';
import { jsPDF } from 'jspdf';
import html2canvas from 'html2canvas';
import { Ckeditor } from '@ckeditor/ckeditor5-vue';
import {
    ClassicEditor,
    Alignment,
    Autoformat,
    AutoImage,
    Autosave,
    BlockQuote,
    Bold,
    CloudServices,
    Code,
    Emoji,
    Essentials,
    FontBackgroundColor,
    FontColor,
    FontFamily,
    FontSize,
    Fullscreen,
    GeneralHtmlSupport,
    Heading,
    Highlight,
    HorizontalLine,
    HtmlComment,
    HtmlEmbed,
    ImageBlock,
    ImageCaption,
    ImageInline,
    ImageInsertViaUrl,
    ImageResize,
    ImageStyle,
    ImageTextAlternative,
    ImageToolbar,
    ImageUpload,
    Indent,
    IndentBlock,
    Italic,
    Link,
    LinkImage,
    List,
    ListProperties,
    MediaEmbed,
    Mention,
    PageBreak,
    Paragraph,
    PasteFromOffice,
    PlainTableOutput,
    RemoveFormat,
    ShowBlocks,
    SpecialCharacters,
    SpecialCharactersArrows,
    SpecialCharactersCurrency,
    SpecialCharactersEssentials,
    SpecialCharactersLatin,
    SpecialCharactersMathematical,
    SpecialCharactersText,
    Strikethrough,
    Style,
    Subscript,
    Superscript,
    Table,
    TableCaption,
    TableCellProperties,
    TableColumnResize,
    TableLayout,
    TableProperties,
    TableToolbar,
    TextPartLanguage,
    TextTransformation,
    TodoList,
    Underline,
    WordCount,
} from 'ckeditor5';
import 'ckeditor5/ckeditor5.css';
import Navbar from '../../layout/Navbar.vue';
import Sidebar from '../../layout/Sidebar.vue';
import FooterVue from '../../layout/Footer.vue';
import BreadCrumbs from '../../dashboard_tiles/BreadCrumbs.vue';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { faList, faDownload, faFileExport, faPrint } from '@fortawesome/free-solid-svg-icons';
import { library } from '@fortawesome/fontawesome-svg-core';

library.add(faList, faDownload, faFileExport, faPrint);

const LICENSE_KEY = 'eyJhbGciOiJFUzI1NiJ9.eyJleHAiOjE3NTUyMTU5OTksImp0aSI6IjQ4MjE5NTQ5LWY5ZmQtNGRiYS1hZjEzLTJmOGMyZDgxMGRlZSIsInVzYWdlRW5kcG9pbnQiOiJodHRwczovL3Byb3h5LWV2ZW50LmNrZWRpdG9yLmNvbSIsImRpc3RyaWJ1dGlvbkNoYW5uZWwiOlsiY2xvdWQiLCJkcnVwYWwiLCJzaCJdLCJ3aGl0ZUxhYmVsIjp0cnVlLCJsaWNlbnNlVHlwZSI6InRyaWFsIiwiZmVhdHVyZXMiOlsiKiJdLCJ2YyI6ImI1MzkxOGY2In0.o9oP7VEOUGH3jKcM_Nr2PA_x5fulDeMD3XzBhjAX0VWVcg29jdWnBP4u8R45a0hy0XfGwXPCqcwF1Ger7B59NA';

const route = useRoute();
const router = useRouter();
const editor = ClassicEditor;
const editorData = ref('');
const editorWordCountElement = ref(null);
const editorContainerElement = ref(null);
const isLayoutReady = ref(false);
const resolutionData = ref({});
const abstractId = ref(null);
const rfqId = ref(null);

const config = computed(() => {
    if (!isLayoutReady.value) {
        return null;
    }
    return {
        toolbar: {
            items: [
                'undo', 'redo', '|', 'showBlocks', '|', 'heading', 'style', '|',
                'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', '|',
                'bold', 'italic', 'underline', '|', 'link', 'insertTable', 'highlight', 'blockQuote', '|',
                'alignment', '|', 'bulletedList', 'numberedList', 'todoList', 'outdent', 'indent',
            ],
            shouldNotGroupWhenFull: false,
        },
        plugins: [
            Alignment, Autoformat, AutoImage, Autosave, BlockQuote, Bold, CloudServices, Code, Emoji,
            Essentials, FontBackgroundColor, FontColor, FontFamily, FontSize, Fullscreen,
            GeneralHtmlSupport, Heading, Highlight, HorizontalLine, HtmlComment, HtmlEmbed,
            ImageBlock, ImageCaption, ImageInline, ImageInsertViaUrl, ImageResize, ImageStyle,
            ImageTextAlternative, ImageToolbar, ImageUpload, Indent, IndentBlock, Italic, Link,
            LinkImage, List, ListProperties, MediaEmbed, Mention, PageBreak, Paragraph,
            PasteFromOffice, PlainTableOutput, RemoveFormat, ShowBlocks, SpecialCharacters,
            SpecialCharactersArrows, SpecialCharactersCurrency, SpecialCharactersEssentials,
            SpecialCharactersLatin, SpecialCharactersMathematical, SpecialCharactersText,
            Strikethrough, Style, Subscript, Superscript, Table, TableCaption, TableCellProperties,
            TableColumnResize, TableLayout, TableProperties, TableToolbar, TextPartLanguage,
            TextTransformation, TodoList, Underline, WordCount,
        ],
        alignment: {
            options: [
                { name: 'left', style: { name: 'text-align', value: 'left' } },
                { name: 'center', style: { name: 'text-align', value: 'center' } },
                { name: 'right', style: { name: 'text-align', value: 'right' } },
                { name: 'justify', style: { name: 'text-align', value: 'justify' } },
            ],
        },
        fontFamily: {
            options: ['Times New Roman', 'Arial', 'default'],
            supportAllValues: true,
        },
        fontSize: {
            options: [10, 12, 14, 'default', 18, 20, 22],
            supportAllValues: true,
        },
        fullscreen: {
            onEnterCallback: (container) =>
                container.classList.add(
                    'editor-container', 'editor-container_classic-editor',
                    'editor-container_include-style', 'editor-container_include-word-count',
                    'editor-container_include-fullscreen', 'main-container'
                ),
        },
        heading: {
            options: [
                { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
                { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' },
                { model: 'heading5', view: 'h5', title: 'Heading 5', class: 'ck-heading_heading5' },
                { model: 'heading6', view: 'h6', title: 'Heading 6', class: 'ck-heading_heading6' },
            ],
        },
        htmlSupport: {
            allow: [{ name: /^.*$/, styles: true, attributes: true, classes: true }],
        },
        image: {
            toolbar: [
                'toggleImageCaption', 'imageTextAlternative', '|', 'imageStyle:inline',
                'imageStyle:wrapText', 'imageStyle:breakText', '|', 'resizeImage', 'alignment',
            ],
        },
        initialData: editorData.value,
        licenseKey: LICENSE_KEY,
        link: {
            addTargetToExternalLinks: true,
            defaultProtocol: 'https://',
            decorators: {
                toggleDownloadable: {
                    mode: 'manual',
                    label: 'Downloadable',
                    attributes: { download: 'file' },
                },
            },
        },
        list: {
            properties: { styles: true, startIndex: true, reversed: true },
        },
        mention: { feeds: [{ marker: '@', feed: [] }] },
        menuBar: { isVisible: true },
        placeholder: 'Type or paste your content here!',
        style: {
            definitions: [
                { name: 'Article category', element: 'h3', classes: ['category'] },
                { name: 'Title', element: 'h2', classes: ['document-title'] },
                { name: 'Subtitle', element: 'h3', classes: ['document-subtitle'] },
                { name: 'Info box', element: 'p', classes: ['info-box'] },
                { name: 'CTA Link Primary', element: 'a', classes: ['button', 'button--green'] },
                { name: 'CTA Link Secondary', element: 'a', classes: ['button', 'button--black'] },
                { name: 'Marker', element: 'span', classes: ['marker'] },
                { name: 'Spoiler', element: 'span', classes: ['spoiler'] },
            ],
        },
        table: {
            contentToolbar: [
                'tableColumn', 'tableRow', 'mergeTableCells', 'tableProperties', 'tableCellProperties',
            ],
        },
    };
});

const fetchResolutionData = async () => {
    try {
        const url = route.params.id ? `/api/fetchResolutionByAbstract/${route.params.id}` : '/api/fetchResolution';
        const response = await axios.get(url);
        if (response.data) {
            resolutionData.value = response.data;
            if (response.data.reso_content) {
                editorData.value = response.data.reso_content;
                await nextTick(() => {
                    const editorInstance = editorContainerElement.value?.querySelector('.ck-editor__editable');
                    if (editorInstance?.ckeditorInstance) {
                        editorInstance.ckeditorInstance.editing.view.document.fire('layoutChanged');
                    }
                });
            }
            abstractId.value = response.data.abstract_id || parseInt(route.params.id);
            rfqId.value = response.data.rfq_id || (route.query.rfq_id ? parseInt(route.query.rfq_id) : null);
            console.log('Fetched resolution:', resolutionData.value);
            console.log('Abstract ID:', abstractId.value);
            console.log('RFQ ID:', rfqId.value);
        }
    } catch (err) {
        console.error('Error fetching resolution:', err.response?.data || err);
        // Suppress alert for new resolutions
    }
};

const saveContent = async () => {
    if (!abstractId.value) {
        alert('Abstract ID is missing.');
        return;
    }
    try {
        const url = resolutionData.value?.id
            ? `/api/resolution/${resolutionData.value.id}` // Update existing resolution
            : '/api/PostResolution'; // Create new resolution
        const method = resolutionData.value?.id ? 'put' : 'post';
        const response = await axios[method](url, {
            content: editorData.value,
            abstract_id: abstractId.value,
            rfq_id: rfqId.value,
        });
        alert(response.data.message);
    } catch (err) {
        console.error('Failed to save resolution:', err.response?.data || err);
        alert('Save failed: ' + (err.response?.data?.message || 'Unknown error'));
    }
};

const exportToPDF = async () => {
    const editorElement = editorContainerElement.value?.querySelector('.ck-editor__editable');
    if (!editorElement) {
        alert('Failed to export PDF: Editor not found.');
        return;
    }

    try {
        const canvas = await html2canvas(editorElement, {
            scale: 2,
            useCORS: true,
            width: editorElement.scrollWidth,
            height: editorElement.scrollHeight,
            scrollY: -window.scrollY,
        });
        const imgData = canvas.toDataURL('image/png');
        const pdf = new jsPDF('p', 'mm', 'a4');
        const pageWidth = pdf.internal.pageSize.getWidth();
        const pageHeight = pdf.internal.pageSize.getHeight();
        const imgWidth = (canvas.width * pageHeight) / canvas.height;
        const imgHeight = pageHeight;

        pdf.text(`Resolution for Abstract ID: ${abstractId.value || 'Unknown'}`, 10, 10);
        pdf.addImage(imgData, 'PNG', 0, 20, imgWidth, imgHeight - 20);

        if (canvas.height > canvas.width * (pageHeight / pageWidth)) {
            let heightLeft = canvas.height - (canvas.width * (pageHeight / pageWidth));
            let position = pageHeight;
            while (heightLeft > 0) {
                pdf.addPage();
                pdf.addImage(imgData, 'PNG', 0, -position, imgWidth, imgHeight);
                heightLeft -= pageHeight;
                position += pageHeight;
            }
        }

        pdf.save(`RESO-${abstractId.value || '2025'}.pdf`);
    } catch (err) {
        console.error('Error exporting to PDF:', err);
        alert('Failed to export PDF.');
    }
};

const printContent = () => {
    const currentDate = new Date().toLocaleString('en-US', {
        timeZone: 'America/Los_Angeles',
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
        hour12: true,
    }).replace(/(\d{1,2}:\d{2})\s*([AP]M)/i, '$1 $2 PST'); // Updated to "August 01, 2025, 01:55 PM PST"

    const content = `
        <html>
            <head>
                <title>Print Resolution - ${abstractId.value || 'Unknown'}</title>
                <style>
                    body {
                        font-family: 'Times New Roman', serif;
                        padding: 0;
                        margin: 0;
                        font-size: 12pt;
                    }
                    p, h1, h2, h3, h4, h5, h6 {
                        margin: 1rem 0;
                        padding: 0;
                        box-sizing: border-box;
                    }
                    .content {
                        width: 100%;
                        box-sizing: border-box;
                        padding-top: 0; /* Handled by @page top margin */
                    }
                    @media print {
                        body { margin: 0; }
                        .content { padding: 0 0.75in; } /* Matches page side margins */
                    }
                </style>
            </head>
            <body>
                <div class="content">
                    ${editorData.value}
                </div>
            </body>
        </html>
    `;

    const printWindow = window.open('', '_blank');
    if (!printWindow) return alert('Failed to open print window.');

    printWindow.document.open();
    printWindow.document.write(content);
    printWindow.document.close();
    printWindow.focus();
    printWindow.print();
};

const onReady = (editor) => {
    const wordCountPlugin = editor.plugins.get('WordCount');
    if (editorWordCountElement.value) {
        editorWordCountElement.value.innerHTML = '';
        editorWordCountElement.value.appendChild(wordCountPlugin.wordCountContainer);
    }
};

onMounted(() => {
    isLayoutReady.value = true;
    if (route.params.id) {
        abstractId.value = parseInt(route.params.id);
    }
    if (route.query.rfq_id) {
        rfqId.value = parseInt(route.query.rfq_id);
    }
    fetchResolutionData();
});
</script>

<style scoped>
.editor-container {
    border: 1px solid #ddd;
    border-radius: 4px;
    padding: 1rem;
    background: #fff;
    min-height: 400px;
}

.ck-content p,
.ck-content h1,
.ck-content h2,
.ck-content h3,
.ck-content h4,
.ck-content h5,
.ck-content h6 {
    margin: 1rem 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Times New Roman', serif;
    font-size: 12pt;
}

.ck-content h1 {
    font-size: 18pt;
    font-weight: bold;
}

.ck-content h2 {
    font-size: 14pt;
    font-weight: bold;
}
</style>