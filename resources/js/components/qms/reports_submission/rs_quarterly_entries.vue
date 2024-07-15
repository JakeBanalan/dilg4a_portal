<template>

    <div class="card" style="margin-top:1%;" v-if="data.indicator_a !== null">
        <div class="card-body">
            <table id="tb1" class="table table-striped table-responsive table-bordered dropbox">
                <thead>
                    <tr style="background-color: #367fa9; color: white;">
                        <th class="text-center" colspan="13">Indicator A: {{ data.indicator_a }}
                        </th>
                    </tr>
                    <tr style="background-color: #ffa500a3;">
                        <th class="text-center" width="7.5%">1ST QUARTER</th>
                        <th class="text-center" width="7.5%">2ND QUARTER</th>
                        <th class="text-center" width="7.5%">3RD QUARTER</th>
                        <th class="text-center" width="7.5%">4TH QUARTER</th>
                        <th rowspan="2" class="text-center" width="7.5%" style="vertical-align: middle;">TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-center" width="7.5%">
                            <input type="text" class="form-control" v-model="quarterData.Q1">
                        </td>
                        <td class="text-center" width="7.5%">
                            <input type="text" class="form-control" v-model="quarterData.Q2">
                        </td>
                        <td class="text-center" width="7.5%">
                            <input type="text" class="form-control" v-model="quarterData.Q3">
                        </td>
                        <td class="text-center" width="7.5%">
                            <input type="text" class="form-control" v-model="quarterData.Q4">
                        </td>
                        <td rowspan="2" class="text-center" width="7.5%" style="vertical-align: middle;">0.00
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="card" style="margin-top:1%;" v-if="data.indicator_b !== null">
        <div class="card-body">
            <table id="tb1" class="table table-striped table-responsive table-bordered dropbox">
                <thead>
                    <tr style="background-color: #367fa9; color: white;">
                        <th class="text-center" colspan="13">Indicator B: {{ data.indicator_b }}
                        </th>
                    </tr>
                    <tr style="background-color: #ffa500a3;">
                        <th class="text-center" width="7.5%">1ST QUARTER</th>
                        <th class="text-center" width="7.5%">2ND QUARTER</th>
                        <th class="text-center" width="7.5%">3RD QUARTER</th>
                        <th class="text-center" width="7.5%">4TH QUARTER</th>
                        <th rowspan="2" class="text-center" width="7.5%" style="vertical-align: middle;">TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-center" width="7.5%">
                            <input type="text" class="form-control" id="rev_no" />
                        </td>
                        <td class="text-center" width="7.5%">
                            <input type="text" class="form-control" id="rev_no" />
                        </td>
                        <td class="text-center" width="7.5%">
                            <input type="text" class="form-control" id="rev_no" />
                        </td>
                        <td class="text-center" width="7.5%">
                            <input type="text" class="form-control" id="rev_no" />
                        </td>
                        <td rowspan="2" class="text-center" width="7.5%" style="vertical-align: middle;">00.0</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="card" style="margin-top:1%;" v-if="data.indicator_c !== null">
        <div class="card-body">
            <table id="tb1" class="table table-striped table-responsive table-bordered dropbox">
                <thead>
                    <tr style="background-color: #367fa9; color: white;">
                        <th class="text-center" colspan="13">Indicator C: {{ data.indicator_c }}
                        </th>
                    </tr>
                    <tr style="background-color: #ffa500a3;">
                        <th class="text-center" width="7.5%">1ST QUARTER</th>
                        <th class="text-center" width="7.5%">2ND QUARTER</th>
                        <th class="text-center" width="7.5%">3RD QUARTER</th>
                        <th class="text-center" width="7.5%">4TH QUARTER</th>
                        <th rowspan="2" class="text-center" width="7.5%" style="vertical-align: middle;">TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-center" width="7.5%">
                            <input type="text" class="form-control" id="rev_no" />
                        </td>
                        <td class="text-center" width="7.5%">
                            <input type="text" class="form-control" id="rev_no" />
                        </td>
                        <td class="text-center" width="7.5%">
                            <input type="text" class="form-control" id="rev_no" />
                        </td>
                        <td class="text-center" width="7.5%">
                            <input type="text" class="form-control" id="rev_no" />
                        </td>
                        <td rowspan="2" class="text-center" width="7.5%" style="vertical-align: middle;">00.0</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="card" style="margin-top:1%;" v-if="data.indicator_d !== null">
        <div class="card-body">
            <table id="tb1" class="table table-striped table-responsive table-bordered dropbox">
                <thead>
                    <tr style="background-color: #367fa9; color: white;">
                        <th class="text-center" colspan="13">Indicator D: {{ data.indicator_d }}
                        </th>
                    </tr>
                    <tr style="background-color: #ffa500a3;">
                        <th class="text-center" width="7.5%">1ST QUARTER</th>
                        <th class="text-center" width="7.5%">2ND QUARTER</th>
                        <th class="text-center" width="7.5%">3RD QUARTER</th>
                        <th class="text-center" width="7.5%">4TH QUARTER</th>
                        <th rowspan="2" class="text-center" width="7.5%" style="vertical-align: middle;">TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-center" width="7.5%">
                            <input type="text" class="form-control" id="rev_no" />
                        </td>
                        <td class="text-center" width="7.5%">
                            <input type="text" class="form-control" id="rev_no" />
                        </td>
                        <td class="text-center" width="7.5%">
                            <input type="text" class="form-control" id="rev_no" />
                        </td>
                        <td class="text-center" width="7.5%">
                            <input type="text" class="form-control" id="rev_no" />
                        </td>
                        <td rowspan="2" class="text-center" width="7.5%" style="vertical-align: middle;">00.0</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>


    <!--FORMULA-->
    <div class="card" style="margin-top:1%;">
        <div class="card-body">
            <table id="tb1" class="table table-striped table-responsive table-bordered dropbox">
                <thead>
                    <tr style="background-color: #367fa9; color: white;">
                        <th class="text-center" colspan="13"> Formula {{ data.formula }}
                        </th>
                    </tr>
                    <tr style="background-color: #ffa500a3;">
                        <th class="text-center" width="7.5%">1ST QUARTER</th>
                        <th class="text-center" width="7.5%">2ND QUARTER</th>
                        <th class="text-center" width="7.5%">3RD QUARTER</th>
                        <th class="text-center" width="7.5%">4TH QUARTER</th>
                        <th rowspan="2" class="text-center" width="7.5%" style="vertical-align: middle;">TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-center" width="7.5%">
                            <input type="text" class="form-control" id="rev_no" />
                        </td>
                        <td class="text-center" width="7.5%">
                            <input type="text" class="form-control" id="rev_no" />
                        </td>
                        <td class="text-center" width="7.5%">
                            <input type="text" class="form-control" id="rev_no" />
                        </td>
                        <td class="text-center" width="7.5%">
                            <input type="text" class="form-control" id="rev_no" />
                        </td>
                        <td rowspan="2" class="text-center" width="7.5%" style="vertical-align: middle;">00.0</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            id:'',
            qoe_id:'',
          
        }
    },
    props: {
        data: {
            type: Object
        }
    },
    mounted() {
        this.qoe_id = this.$route.params.qoe_id1;
        this.id = this.$route.params.id;
    },
    methods:{
      
  
    }
    // created() {
    //     console.log(data)
    // }

}
</script>