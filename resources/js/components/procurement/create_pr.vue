<style>
.select-option {
  height: 40px;
}

.date-option {
  height: 40px;
}

.container .card {
  height: auto;
  width: auto;
  background-color: #fff;
  position: relative;
  box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
  font-family: "Poppins", sans-serif;
  border-radius: 20px;
}

.container .card .form {
  width: 100%;
  height: 100%;
  display: flex;
}

.container .card .left-side {
  width: 35%;
  background-color: #304767;
  height: 100%;
  border-top-left-radius: 20px;
  border-bottom-left-radius: 20px;
  padding: 20px 30px;
  box-sizing: border-box;
}

/*left-side-start*/
.left-heading {
  color: #fff;
}

.steps-content {
  margin-top: 30px;
  color: #fff;
}

.steps-content p {
  font-size: 12px;
  margin-top: 15px;
}

.progress-barv2 {
  list-style: none;
  /*color:#fff;*/
  margin-top: 30px;
  font-size: 13px;
  font-weight: 700;
  text-align: left;
  counter-reset: container 0;
}

.progress-barv2 li {
  position: relative;
  margin-left: 40px;
  margin-top: 50px;
  counter-increment: container 1;
  color: #4f6581;
}

.progress-barv2 li::before {
  content: counter(container);
  line-height: 25px;
  text-align: center;
  position: absolute;
  height: 25px;
  width: 25px;
  border: 1px solid #4f6581;
  border-radius: 50%;
  left: -40px;
  top: -5px;
  z-index: 10;
  background-color: #304767;
}

.progress-barv2 li::after {
  content: "";
  position: absolute;
  height: 90px;
  width: 2px;
  background-color: #4f6581;
  z-index: 1;
  left: -27px;
  top: -70px;
}

.progress-barv2 li.active::after {
  background-color: #fff;
}

.progress-barv2 li:first-child:after {
  display: none;
}

/*.progress-barv2 li:last-child:after{*/
/*  display:none;  */
/*}*/
.progress-barv2 li.active::before {
  color: #fff;
  border: 1px solid #fff;
}

.progress-barv2 li.active {
  color: #fff;
}

.d-none {
  display: none;
}

/*left-side-end*/
.container .card .right-side {
  width: 100% !important;
  background-color: #fff;
  height: 100%;
  border-radius: 20px;
}

/*right-side-start*/
.main {
  display: none;
}

.active {
  display: block;
}

.main {
  padding: 10px;
}

.main small {
  display: flex;
  justify-content: center;
  align-items: center;
  margin-top: 2px;
  height: 30px;
  width: 30px;
  background-color: #ccc;
  border-radius: 50%;
  color: yellow;
  font-size: 19px;
}

.text {
  margin-top: 20px;
}

.congrats {
  text-align: center;
}

.text p {
  margin-top: 10px;
  font-size: 13px;
  font-weight: 700;
  color: #cbced4;
}

.input-text {
  margin: 30px 0;
  display: flex;
  gap: 20px;
}

.input-text .input-div {
  width: 100%;
  position: relative;
}

input[type="text"] {
  width: 100%;
  height: 40px;
  border: none;
  outline: 0;
  border-radius: 5px;
  border: 1px solid #cbced4;
  gap: 20px;
  box-sizing: border-box;
  padding: 0px 10px;
}

select {
  width: 100%;
  height: 40px;
  border: none;
  outline: 0;
  border-radius: 5px;
  border: 1px solid #cbced4;
  gap: 20px;
  box-sizing: border-box;
  padding: 0px 10px;
}

.input-text .input-div span {
  position: absolute;
  top: 10px;
  left: 10px;
  font-size: 14px;
  transition: all 0.5s;
}

.input-div input:focus~span,
.input-div input:valid~span {
  top: -15px;
  left: 6px;
  font-size: 10px;
  font-weight: 600;
}

.input-div span {
  top: -15px;
  left: 6px;
  font-size: 10px;
}

/* .buttons button {
  height: 40px;
  width: 100px;
  border: none;
  border-radius: 5px;
  background-color: #0075ff;
  font-size: 12px;
  color: #fff;
  cursor: pointer;
} */



.button_space {
  display: flex;
  gap: 20px;
}

.button_space button:nth-child(1) {
  background-color: #fff;
  color: #000;
  border: 1px solid#000;
}

.user_card {
  margin-top: 20px;
  margin-bottom: 40px;
  height: 200px;
  width: 100%;
  border: 1px solid #c7d3d9;
  border-radius: 10px;
  display: flex;
  overflow: hidden;
  position: relative;
  box-sizing: border-box;
}

.user_card span {
  height: 80px;
  width: 100%;
  background-color: #dfeeff;
}

.circle {
  position: absolute;
  top: 40px;
  left: 60px;
}

.circle span {
  height: 70px;
  width: 70px;
  background-color: #fff;
  display: flex;
  justify-content: center;
  align-items: center;
  border: 2px solid #fff;
  border-radius: 50%;
}

.circle span img {
  width: 100%;
  height: 100%;
  border-radius: 50%;
  object-fit: cover;
}

.social {
  display: flex;
  position: absolute;
  top: 100px;
  right: 10px;
}

.social span {
  height: 30px;
  width: 30px;
  border-radius: 7px;
  background-color: #fff;
  border: 1px solid #cbd6dc;
  display: flex;
  justify-content: center;
  align-items: center;
  margin-left: 10px;
  color: #cbd6dc;
}

.social span i {
  cursor: pointer;
}

.heart {
  color: red !important;
}

.share {
  color: red !important;
}

.user_name {
  position: absolute;
  top: 110px;
  margin: 10px;
  padding: 0 30px;
  display: flex;
  flex-direction: column;
  width: 100%;
}

.user_name h3 {
  color: #4c5b68;
}

.detail {
  /*margin-top:10px;*/
  display: flex;
  justify-content: space-between;
  margin-right: 50px;
}

.detail p {
  font-size: 12px;
  font-weight: 700;
}

.detail p a {
  text-decoration: none;
  color: blue;
}

.checkmark__circle {
  stroke-dasharray: 166;
  stroke-dashoffset: 166;
  stroke-width: 2;
  stroke-miterlimit: 10;
  stroke: #7ac142;
  fill: none;
  animation: stroke 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards;
}

.checkmark {
  width: 56px;
  height: 56px;
  border-radius: 50%;
  display: block;
  stroke-width: 2;
  stroke: #fff;
  stroke-miterlimit: 10;
  margin: 10% auto;
  box-shadow: inset 0px 0px 0px #7ac142;
  animation: fill 0.4s ease-in-out 0.4s forwards, scale 0.3s ease-in-out 0.9s both;
}

.checkmark__check {
  transform-origin: 50% 50%;
  stroke-dasharray: 48;
  stroke-dashoffset: 48;
  animation: stroke 0.3s cubic-bezier(0.65, 0, 0.45, 1) 0.8s forwards;
}

@keyframes stroke {
  100% {
    stroke-dashoffset: 0;
  }
}

@keyframes scale {

  0%,
  100% {
    transform: none;
  }

  50% {
    transform: scale3d(1.1, 1.1, 1);
  }
}

@keyframes fill {
  100% {
    box-shadow: inset 0px 0px 0px 30px #7ac142;
  }
}

.warning {
  border: 1px solid red !important;
}

/*right-side-end*/
@media (max-width: 750px) {
  .container {
    height: scroll;
  }

  .container .card {
    max-width: 350px;
    height: auto !important;
    margin: 30px 0;
  }

  .container .card .right-side {
    width: 100%;
  }

  .input-text {
    /* display: block; */
  }

  .input-text .input-div {
    /* margin-top: 20px; */
  }

  .container .card .left-side {
    display: none;
  }
}

.selected img {
  border: 2px solid #007bff;
  /* Change the border color as needed */
  box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
  /* Change the box shadow as needed */
}
</style>

<template>
  <div class="container-scroller">
    <Navbar></Navbar>
    <div class="container-fluid page-body-wrapper">
      <Sidebar />
      <div class="main-panel">
        <div class="content-wrapper">
          <BreadCrumbs />
          <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
              <div class="card">
                <div class="card-body">
                  <div class="card-title d-flex justify-content-between align-items-center">
                    <h5 class="card-title">
                      <font-awesome-icon :icon="['fas', 'list']"></font-awesome-icon>&nbsp;Create Purchase Request Item
                    </h5>
                  </div>
                  <div class="row">
                    <div class="col-lg-3">
                      <TextInput label="Purchase Request No." iconValue="circle-question" v-model="purchase_no"
                        :value="purchase_no" :readonly="true" />
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-3">
                      <SelectInput label="Office" v-model="prData.pmo" class="select-option">
                        <option v-for="option in pmo" :key="option.value" :value="option.value">{{ option.label }}
                        </option>
                      </SelectInput>
                      

                    </div>
                    <div class="col-lg-3">
                      <SelectInput label="Procurement Type" v-model="prData.pr_type" class="select-option">
                        <option v-for="option in pr_type" :key="option.value" :value="option.value">{{ option.label }}
                        </option>
                      </SelectInput>
                    </div>
                    <div class="col-lg-3">
                      <TextInput class="date-option" v-model="prData.pr_date" label="PR Date"
                        iconValue="circle-question" type="date" />
                    </div>
                    <div class="col-lg-3">
                      <TextInput class="date-option" v-model="prData.target_date" label="Target Date"
                        iconValue="circle-question" type="date" />
                    </div>
                    <div class="col-lg-12 mt-4">
                      <TextAreaInput label="Particulars" v-model="prData.particulars" />
                    </div>
                    <div class="col-lg-12">
                      <button class="btn btn-outline-primary" style="float:right;"
                        @click="post_create_pr();">Create</button>
                    </div>
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

<script>
import Navbar from "../layout/Navbar.vue";
import Sidebar from "../layout/Sidebar.vue";
import FooterVue from "../layout/Footer.vue";
import BreadCrumbs from "../dashboard_tiles/BreadCrumbs.vue";
import item_table from "./item_table.vue";
import dtable from "./table.vue";
import axios from "axios";
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { library } from '@fortawesome/fontawesome-svg-core'; // Import the library object
import { faCircleCheck, faCircleInfo, faEye, faLayerGroup, faList, faPesoSign, faQuestionCircle } from '@fortawesome/free-solid-svg-icons';
import TextAreaInput from '../micro/TextAreaInput.vue';
import SelectInput from "../micro/SelectInput.vue";



library.add(faCircleInfo, faList, faCircleCheck, faEye, faLayerGroup, faPesoSign, faQuestionCircle);

export default {
  name: 'create_pr',
  data() {
    return {
      modalVisible: false,
      purchase_no: null,
      purchase_id: null,
      prData: {
        pmo: null,
        pr_type: null,
        pr_date: null,
        target_date: null,
        particulars: null
      },
      pmo: [
        { value: '15', label: 'ORD' },
        { value: '1', label: 'ORD-Legal' },
        { value: '2', label: 'ORD-Planning' },
        { value: '3', label: 'LGMED-MBRTG' },
        { value: '4', label: 'LGCDD-PDMU' },
        { value: '5', label: 'FAD' },
        { value: '6', label: 'ORD-RICTU' },
        { value: '7', label: 'LGCDD' },
        { value: '8', label: 'LGMED' },
      ],
      pr_type: [
        { value: '1', label: 'Catering Services' },
        { value: '2', label: 'Meals, Venue and Accomodation' },
        { value: '3', label: 'Repair and Maintenance' },
        { value: '4', label: 'Supplies, Materials and Devices' },
        { value: '5', label: 'Other Services' },
        { value: '6', label: 'Reimbursement and Petty Cash' }
      ],
    }
  },
  created() {
    this.userId = localStorage.getItem('userId');
  },
  computed: {

  },
  mounted() {
    this.generatePurchaseRequestNo();

  },
  methods: {
    generatePurchaseRequestNo: async function () {
      try {
        const response = await axios.get('../api/generatePurchaseRequestNo');
        const currentDate = new Date();
        const year = currentDate.getFullYear();
        const month = String(currentDate.getMonth() + 1).padStart(2, '0'); // Adding 1 because months are zero-indexed
        const purchaseNoFormat = `${year}-${month}`;
        const purchaseNoFromApi = response.data[0].pr_count;
        const formattedSequence = purchaseNoFromApi.toString().padStart(5, '0');

        if (this.$route.query.pr_no) {
          this.purchase_no = this.$route.query.pr_no;
        } else {
          this.purchase_no = `${purchaseNoFormat}-${formattedSequence}`;
        }
        this.purchase_id = response.data[0].pr_count;
      } catch (error) {
        console.error('Error fetching data', error);
      }
    },
    post_create_pr() {
      axios.post('/api/post_create_purchaseRequest', {
        created_by: this.userId,
        pr_no: this.purchase_no,
        pmo: this.prData.pmo,
        type: this.prData.pr_type,
        pr_date: this.prData.pr_date,
        target_date: this.prData.target_date,
        purpose: this.prData.particulars
      }
      ).then(() => {
        const purchaseId = this.purchase_id; // Assuming your API returns the inserted purchase ID
        console.log(purchaseId);
        toast.success('Successfully added!', {
          autoClose: 1000
        });
        setTimeout(() => {
          this.$router.push({ path: `/procurement/select_purchase_item/${purchaseId}` });
        }, 1000);

      }).catch((error) => {
      })
    },
    openModal() {
      this.modalVisible = true;
    },
    closeModal() {
      this.modalVisible = false;
    },
  },

  components: {
    Navbar,
    Sidebar,
    FooterVue,
    BreadCrumbs,
    item_table,
    dtable,
    TextAreaInput,
    SelectInput
  },
};
</script>
