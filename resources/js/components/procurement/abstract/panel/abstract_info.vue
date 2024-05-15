<template>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title"><font-awesome-icon
                    :icon="['fas', 'circle-info']"></font-awesome-icon>&nbsp;Information
            </h5>
            <div class="row">
                <div class="col-lg-3">
                    <TextInput label="Abstract Number" iconValue="gear"   />
                </div>
                <div class="col-lg-3">
                    <TextInput label="RFQ Number" iconValue="gear"   />
                </div>
                <div class="col-lg-3">
                    <TextInput label="Purchase Request Number" iconValue="gear" 
                         />
                </div>
                <div class="col-lg-3">
                    <TextInput label="Total ABC" iconValue="peso-sign"   />
                </div>

            </div>
            <div class="row">
                <div class="col-lg-3">
                    <TextInput label="Abstract Date" style="height:40px;" iconValue="calendar" type="datetime-local"
                          />
                </div>
                <div class="col-lg-3">
                    <TextInput label="RFQ Date" style="height:40px;" iconValue="calendar" type="datetime-local"
                          />
                </div>
                <div class="col-lg-3">
                    <TextInput label="Purchase Request Date" style="height:40px;" iconValue="calendar"
                        type="datetime-local"   />
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label>Office</label>
                        <VueMultiselect v-model="selected_office" deselect-label="Can't remove this value"
                            track-by="value" label="value" placeholder="Select one" :options="office"
                            :searchable="false" :allow-empty="false">
                        </VueMultiselect>
                    </div>
                </div>

            </div>

        </div>
    </div>
</template>

<script>
import VueMultiselect from 'vue-multiselect';

export default {
    name: 'Abstract Information',
    data(){
        return{
            selected_office:null,
            office: [{ label: "ORD", value: "ORD" }, { label: "LGMED", value: "LGMED" }, { label: "LGCDD", value: "LGCDD" }, { label: "FAD", value: "FAD" }],

        }
    },
    component:{
        VueMultiselect
    }
}
</script>