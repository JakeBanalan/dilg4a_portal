<template>
    <div class="container-scroller">
        <Navbar />
        <div class="container-fluid page-body-wrapper">
            <Sidebar />
            <div class="main-panel">
                <form class="formQOR" @submit.prevent="updateMonthlyRating">

                    <div class="content-wrapper">
                        <BreadCrumbs />
                        <div class="card">
                            <div class="card-body">

                                <div class="card-title d-flex justify-content-between align-items-center">
                                    <h5 class="card-title">
                                        <font-awesome-icon :icon="['fas', 'list']"></font-awesome-icon>&nbsp;QMS Quality
                                        Procedures
                                    </h5>
                                    <div class="d-flex">
                                        <button type="button" @click="Return()"
                                            class="btn btn-outline-primary btn-fw btn-icon-text mx-2">
                                            Return
                                        </button>
                                        <button type="submit" class="btn btn-outline-primary btn-fw btn-icon-text mx-2"
                                            :disabled="status != 0">
                                            Submit
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>Target (%):</label>
                                            <input type="text" class="form-control" v-model="form.target_percentage"
                                                id="target_percentage" disabled />
                                        </div>
                                        <div class="col-md-6">
                                            <label>Objectives Met?:</label>
                                            <br>
                                            <label class="switch">
                                                <input type="checkbox" v-model="form.is_gap_analysis" :checked="form.is_gap_analysis==1"
                                                    @change="toggleGapAnalysis">
                                                <span class="slider round">
                                                    <span class="slider-text off">No</span>
                                                    <span class="slider-text on">Yes</span>
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>Quality Objective:</label>

                                            <textarea rows="3" col="100" style="height:110px !important;" id="objective"
                                                class="form-control" v-model="form.objective" disabled></textarea>
                                        </div>
                                        <div class="col-md-6">
                                            <label>Gap Analysis:</label>

                                            <textarea rows="3" col="100" style="height:110px !important;"
                                                id="gap_analysis" class="form-control" v-model="form.gap_analysis"
                                                :disabled="form.is_gap_analysis"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- INDICATOR 1 -->
                        <div class="card" style="margin-top:1%;" v-if="form.indicator_a !== null">
                            <div class="card-body">
                                <table id="tb1" class="table table-striped table-responsive table-bordered dropbox">
                                    <thead>
                                        <tr style="background-color: #367fa9; color: white;">
                                            <th class="text-center" colspan="13">Indicator A: {{ form.indicator_a }}
                                            </th>
                                        </tr>
                                        <tr style="background-color: #ffa500a3;">
                                            <th class="text-center" width="7.5%">JAN</th>
                                            <th class="text-center" width="7.5%">FEB</th>
                                            <th class="text-center" width="7.5%">MAR</th>
                                            <th class="text-center" width="7.5%">APR</th>
                                            <th class="text-center" width="7.5%">MAY</th>
                                            <th class="text-center" width="7.5%">JUN</th>
                                            <th class="text-center" width="7.5%">JUL</th>
                                            <th class="text-center" width="7.5%">AUG</th>
                                            <th class="text-center" width="7.5%">SEP</th>
                                            <th class="text-center" width="7.5%">OCT</th>
                                            <th class="text-center" width="7.5%">NOV</th>
                                            <th class="text-center" width="7.5%">DEC</th>
                                            <!-- <th rowspan="2" class="text-center" width="7.5%"
                                                style="vertical-align: middle;">TOTAL</th> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control" v-model="monthlyData[0]['01']"
                                                    :disabled="qp_covered !== 'January'" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control" v-model="monthlyData[0]['02']"
                                                    :disabled="qp_covered !== 'February'" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control" v-model="monthlyData[0]['03']"
                                                    :disabled="qp_covered !== 'March'" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control" v-model="monthlyData[0]['04']"
                                                    :disabled="qp_covered !== 'April'" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control" v-model="monthlyData[0]['05']"
                                                    :disabled="qp_covered !== 'May'" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control" v-model="monthlyData[0]['06']"
                                                    :disabled="qp_covered !== 'June'" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control" v-model="monthlyData[0]['07']"
                                                    :disabled="qp_covered !== 'July'" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control" v-model="monthlyData[0]['08']"
                                                    :disabled="qp_covered !== 'August'" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control" v-model="monthlyData[0]['09']"
                                                    :disabled="qp_covered !== 'September'" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control" v-model="monthlyData[0]['10']"
                                                    :disabled="qp_covered !== 'October'" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control" v-model="monthlyData[0]['11']"
                                                    :disabled="qp_covered !== 'November'" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control" v-model="monthlyData[0]['12']"
                                                    :disabled="qp_covered !== 'December'" />
                                            </td>
                                            <!-- <td rowspan="2" class="text-center" width="7.5%" style="vertical-align: middle;">00.0</td> -->
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- INDICATOR 2-->
                        <div class="card" style="margin-top:1%;" v-if="form.indicator_b !== null">
                            <div class="card-body">
                                <table id="tb1" class="table table-striped table-responsive table-bordered dropbox">
                                    <thead>
                                        <tr style="background-color: #367fa9; color: white;">
                                            <th class="text-center" colspan="13">Indicator B: {{ form.indicator_b }}
                                            </th>
                                        </tr>
                                        <tr style="background-color: #ffa500a3;">
                                            <th class="text-center" width="7.5%">JAN</th>
                                            <th class="text-center" width="7.5%">FEB</th>
                                            <th class="text-center" width="7.5%">MAR</th>
                                            <th class="text-center" width="7.5%">APR</th>
                                            <th class="text-center" width="7.5%">MAY</th>
                                            <th class="text-center" width="7.5%">JUN</th>
                                            <th class="text-center" width="7.5%">JUL</th>
                                            <th class="text-center" width="7.5%">AUG</th>
                                            <th class="text-center" width="7.5%">SEP</th>
                                            <th class="text-center" width="7.5%">OCT</th>
                                            <th class="text-center" width="7.5%">NOV</th>
                                            <th class="text-center" width="7.5%">DEC</th>
                                            <!-- <th rowspan="2" class="text-center" width="7.5%"
                                                style="vertical-align: middle;">TOTAL</th> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control" v-model="monthlyData[1]['01']"
                                                    :disabled="qp_covered !== 'January'" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control" v-model="monthlyData[1]['02']"
                                                    :disabled="qp_covered !== 'February'" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control" v-model="monthlyData[1]['03']"
                                                    :disabled="qp_covered !== 'March'" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control" v-model="monthlyData[1]['04']"
                                                    :disabled="qp_covered !== 'April'" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control" v-model="monthlyData[1]['05']"
                                                    :disabled="qp_covered !== 'May'" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control" v-model="monthlyData[1]['06']"
                                                    :disabled="qp_covered !== 'June'" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control" v-model="monthlyData[1]['07']"
                                                    :disabled="qp_covered !== 'July'" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control" v-model="monthlyData[1]['08']"
                                                    :disabled="qp_covered !== 'August'" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control" v-model="monthlyData[1]['09']"
                                                    :disabled="qp_covered !== 'September'" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control" v-model="monthlyData[1]['10']"
                                                    :disabled="qp_covered !== 'October'" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control" v-model="monthlyData[1]['11']"
                                                    :disabled="qp_covered !== 'November'" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control" v-model="monthlyData[1]['12']"
                                                    :disabled="qp_covered !== 'December'" />
                                            </td>
                                            <!-- <td rowspan="2" class="text-center" width="7.5%"
                                                style="vertical-align: middle;">00.0</td> -->
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!--INDICATOR 3-->
                        <div class="card" style="margin-top:1%;" v-if="form.indicator_c !== null">

                            <div class="card-body">
                                <table id="tb1" class="table table-striped table-responsive table-bordered dropbox">
                                    <thead>
                                        <tr style="background-color: #367fa9; color: white;">
                                            <th class="text-center" colspan="13">Indicator C: {{ form.indicator_c }}
                                            </th>
                                        </tr>
                                        <tr style="background-color: #ffa500a3;">
                                            <th class="text-center" width="7.5%">JAN</th>
                                            <th class="text-center" width="7.5%">FEB</th>
                                            <th class="text-center" width="7.5%">MAR</th>
                                            <th class="text-center" width="7.5%">APR</th>
                                            <th class="text-center" width="7.5%">MAY</th>
                                            <th class="text-center" width="7.5%">JUN</th>
                                            <th class="text-center" width="7.5%">JUL</th>
                                            <th class="text-center" width="7.5%">AUG</th>
                                            <th class="text-center" width="7.5%">SEP</th>
                                            <th class="text-center" width="7.5%">OCT</th>
                                            <th class="text-center" width="7.5%">NOV</th>
                                            <th class="text-center" width="7.5%">DEC</th>
                                            <!-- <th rowspan="2" class="text-center" width="7.5%"
                                                style="vertical-align: middle;">TOTAL</th> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control" v-model="monthlyData[2]['01']"
                                                    :disabled="qp_covered !== 'January'" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control" v-model="monthlyData[2]['02']"
                                                    :disabled="qp_covered !== 'February'" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control" v-model="monthlyData[2]['03']"
                                                    :disabled="qp_covered !== 'March'" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control" v-model="monthlyData[2]['04']"
                                                    :disabled="qp_covered !== 'April'" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control" v-model="monthlyData[2]['05']"
                                                    :disabled="qp_covered !== 'May'" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control" v-model="monthlyData[2]['06']"
                                                    :disabled="qp_covered !== 'June'" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control" v-model="monthlyData[2]['07']"
                                                    :disabled="qp_covered !== 'July'" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control" v-model="monthlyData[2]['08']"
                                                    :disabled="qp_covered !== 'August'" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control" v-model="monthlyData[2]['09']"
                                                    :disabled="qp_covered !== 'September'" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control" v-model="monthlyData[2]['10']"
                                                    :disabled="qp_covered !== 'October'" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control" v-model="monthlyData[2]['11']"
                                                    :disabled="qp_covered !== 'November'" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control" v-model="monthlyData[2]['12']"
                                                    :disabled="qp_covered !== 'December'" />
                                            </td>
                                            <!-- <td rowspan="2" class="text-center" width="7.5%"
                                                style="vertical-align: middle;">00.0</td> -->
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- INDICATOR 4 -->
                        <div class="card" style="margin-top:1%;" v-if="form.indicator_d !== null">
                            <div class="card-body">
                                <table id="tb1" class="table table-striped table-responsive table-bordered dropbox">
                                    <thead>
                                        <tr style="background-color: #367fa9; color: white;">
                                            <th class="text-center" colspan="13">Indicator D: {{ form.indicator_d }}
                                            </th>
                                        </tr>
                                        <tr style="background-color: #ffa500a3;">
                                            <th class="text-center" width="7.5%">JAN</th>
                                            <th class="text-center" width="7.5%">FEB</th>
                                            <th class="text-center" width="7.5%">MAR</th>
                                            <th class="text-center" width="7.5%">APR</th>
                                            <th class="text-center" width="7.5%">MAY</th>
                                            <th class="text-center" width="7.5%">JUN</th>
                                            <th class="text-center" width="7.5%">JUL</th>
                                            <th class="text-center" width="7.5%">AUG</th>
                                            <th class="text-center" width="7.5%">SEP</th>
                                            <th class="text-center" width="7.5%">OCT</th>
                                            <th class="text-center" width="7.5%">NOV</th>
                                            <th class="text-center" width="7.5%">DEC</th>
                                            <!-- <th rowspan="2" class="text-center" width="7.5%"
                                                style="vertical-align: middle;">TOTAL</th> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control" v-model="monthlyData[3]['01']"
                                                    :disabled="qp_covered !== 'January'" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control" v-model="monthlyData[3]['02']"
                                                    :disabled="qp_covered !== 'February'" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control" v-model="monthlyData[3]['03']"
                                                    :disabled="qp_covered !== 'March'" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control" v-model="monthlyData[3]['04']"
                                                    :disabled="qp_covered !== 'April'" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control" v-model="monthlyData[3]['05']"
                                                    :disabled="qp_covered !== 'May'" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control" v-model="monthlyData[3]['06']"
                                                    :disabled="qp_covered !== 'June'" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control" v-model="monthlyData[3]['07']"
                                                    :disabled="qp_covered !== 'July'" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control" v-model="monthlyData[3]['08']"
                                                    :disabled="qp_covered !== 'August'" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control" v-model="monthlyData[3]['09']"
                                                    :disabled="qp_covered !== 'September'" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control" v-model="monthlyData[3]['10']"
                                                    :disabled="qp_covered !== 'October'" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control" v-model="monthlyData[3]['11']"
                                                    :disabled="qp_covered !== 'November'" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control" v-model="monthlyData[3]['12']"
                                                    :disabled="qp_covered !== 'December'" />
                                            </td>
                                            <!-- <td rowspan="2" class="text-center" width="7.5%"
                                                style="vertical-align: middle;">00.0</td> -->
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- INDICATOR 5: FORMULA -->
                        <div class="card" style="margin-top:1%;" v-if="form.formula !== null">
                            <div class="card-body">
                                <table id="tb1" class="table table-striped table-responsive table-bordered dropbox">
                                    <thead>
                                        <tr style="background-color: #367fa9; color: white;">
                                            <th class="text-center" colspan="13">Formula: {{ form.formula }}
                                            </th>
                                        </tr>
                                        <tr style="background-color: #ffa500a3;">
                                            <th class="text-center" width="7.5%">JAN</th>
                                            <th class="text-center" width="7.5%">FEB</th>
                                            <th class="text-center" width="7.5%">MAR</th>
                                            <th class="text-center" width="7.5%">APR</th>
                                            <th class="text-center" width="7.5%">MAY</th>
                                            <th class="text-center" width="7.5%">JUN</th>
                                            <th class="text-center" width="7.5%">JUL</th>
                                            <th class="text-center" width="7.5%">AUG</th>
                                            <th class="text-center" width="7.5%">SEP</th>
                                            <th class="text-center" width="7.5%">OCT</th>
                                            <th class="text-center" width="7.5%">NOV</th>
                                            <th class="text-center" width="7.5%">DEC</th>
                                            <!-- <th rowspan="2" class="text-center" width="7.5%"
                                                style="vertical-align: middle;">TOTAL</th> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control" v-model="monthlyData[4]['01']"
                                                    :disabled="qp_covered !== 'January'" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control" v-model="monthlyData[4]['02']"
                                                    :disabled="qp_covered !== 'February'" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control" v-model="monthlyData[4]['03']"
                                                    :disabled="qp_covered !== 'March'" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control" v-model="monthlyData[4]['04']"
                                                    :disabled="qp_covered !== 'April'" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control" v-model="monthlyData[4]['05']"
                                                    :disabled="qp_covered !== 'May'" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control" v-model="monthlyData[4]['06']"
                                                    :disabled="qp_covered !== 'June'" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control" v-model="monthlyData[4]['07']"
                                                    :disabled="qp_covered !== 'July'" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control" v-model="monthlyData[4]['08']"
                                                    :disabled="qp_covered !== 'August'" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control" v-model="monthlyData[4]['09']"
                                                    :disabled="qp_covered !== 'September'" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control" v-model="monthlyData[4]['10']"
                                                    :disabled="qp_covered !== 'October'" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control" v-model="monthlyData[4]['11']"
                                                    :disabled="qp_covered !== 'November'" />
                                            </td>
                                            <td class="text-center" width="7.5%">
                                                <input type="text" class="form-control" v-model="monthlyData[4]['12']"
                                                    :disabled="qp_covered !== 'December'" />
                                            </td>
                                            <!-- <td rowspan="2" class="text-center" width="7.5%"
                                                style="vertical-align: middle;">00.0</td> -->
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>



                    </div>
                </form>

                <FooterVue />
            </div>
        </div>
    </div>
</template>
<script>
import Multiselect from 'vue-multiselect';
import Navbar from "../../layout/Navbar.vue";
import Sidebar from "../../layout/Sidebar.vue";
import FooterVue from "../../layout/Footer.vue";
import BreadCrumbs from "../../dashboard_tiles/BreadCrumbs.vue";
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import Pagination from '../../procurement/Pagination.vue';
import { library } from '@fortawesome/fontawesome-svg-core';
import { toast } from "vue3-toastify";





import { faEye, faLayerGroup, faCircleCheck, faSquarePollVertical, faTrash, faPenToSquare, faFolderOpen } from '@fortawesome/free-solid-svg-icons';
import axios, { Axios } from 'axios';
library.add(faEye, faLayerGroup, faCircleCheck, faSquarePollVertical, faTrash, faPenToSquare, faFolderOpen);

export default {
    components: {
        Multiselect,
        Navbar,
        Sidebar,
        FooterVue,
        BreadCrumbs,
        Pagination,
        FontAwesomeIcon
    },
    data() {
        return {
            qp_covered: this.$route.query.pq,
            status: Number(this.$route.query.stat),
            monthlyData: [
                { id: '', indicator: '', qop_entry_id: this.$route.params.id, qoe_id: this.$route.params.qoe_id1, '01': '', '02': '', '03': '', '04': '', '05': '', '06': '', '07': '', '08': '', '09': '', '10': '', '11': '', '12': '' },
                { id: '', indicator: '', qop_entry_id: this.$route.params.id, qoe_id: this.$route.params.qoe_id1, '01': '', '02': '', '03': '', '04': '', '05': '', '06': '', '07': '', '08': '', '09': '', '10': '', '11': '', '12': '' },
                { id: '', indicator: '', qop_entry_id: this.$route.params.id, qoe_id: this.$route.params.qoe_id1, '01': '', '02': '', '03': '', '04': '', '05': '', '06': '', '07': '', '08': '', '09': '', '10': '', '11': '', '12': '' },
                { id: '', indicator: '', qop_entry_id: this.$route.params.id, qoe_id: this.$route.params.qoe_id1, '01': '', '02': '', '03': '', '04': '', '05': '', '06': '', '07': '', '08': '', '09': '', '10': '', '11': '', '12': '' },
                { id: '', indicator: '', qop_entry_id: this.$route.params.id, qoe_id: this.$route.params.qoe_id1, '01': '', '02': '', '03': '', '04': '', '05': '', '06': '', '07': '', '08': '', '09': '', '10': '', '11': '', '12': '' }
            ],
            form: {
                target_percentage: '',
                objective: '',
                gap_analysis: '',
                indicator_b: '',
                indicator_c: '',
                indicator_d: '',
                indicator_e: '',
                formula: ''
            },
        }
    },
    created() {
        this.fetchQOPRUserData();
        this.fetchData();
        // console.log(this.quarterData)
    },
    methods: {
        Return() {

            Swal.fire({
                title: 'Are you sure you want to return?',
                text: 'Make sure to submit the form to avoid losing data.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, return',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    let id = this.$route.params.id;
                    this.$router.push({ path: `/qms/reports_submission/rs_update/${id}` });
                }
            });


        },
        toggleGapAnalysis() {
            if (this.form.is_gap_analysis) {
                this.form.gap_analysis = '';
            }
        },
        fetchQOPRUserData() {
            let qoe_id = this.$route.params.qoe_id1;
            let id = this.$route.params.id;
            // console.log("tbl_qoe ID:", qoe_id)
            // console.log("tbl_qop_report ID:", id)
            axios.get(`/api/fetchQOPRUserData/${id}/${qoe_id}`)
                .then(response => {
                    // console.log(response.data)
                    if (Array.isArray(response.data) && response.data.length > 0) {
                        this.form = response.data[0];
                        console.log(this.form)
                    } else {
                        console.error("Unexpected response format:", response.data);
                    }
                    // this.form = response.data
                    // console.log(this.form[0])
                    // console.log(response.data)
                })
                .catch(error => {
                    console.error('Error Fetching items:', error)
                })
        },
        updateMonthlyRating() {

            Swal.fire({
                title: 'Do you want to Continue?',
                // text: "You won't be able to revert this!",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.isConfirmed) {

                    if (this.form.is_gap_analysis === true) {
                        this.form.is_gap_analysis = '1';
                    } else {
                        this.form.is_gap_analysis = '0';
                    }
                    axios.post(`/api/saveMonthlyData`, {
                        formData: this.form,
                        monthlyData: this.monthlyData
                    })
                        .then(response => {

                            Swal.fire({
                                icon: 'success',
                                title: 'Report Successfully Submitted!',
                                showConfirmButton: false,
                                timer: 1000
                            });
                            setTimeout(() => {
                                this.fetchQOPRUserData();
                                this.fetchData();
                            }, 200);
                        })
                        .catch(error => {
                            console.error('Error updating:', error);
                            // Optionally, handle error response
                        });

                }
            });
        },
        fetchData() {
            let qoe_id = this.$route.params.qoe_id1;
            let id = this.$route.params.id;

            axios.get(`/api/fetchMonthlyData/${id}/${qoe_id}`)
                .then(response => {
                    console.log('API Response:', response.data);
                    this.monthlyData = response.data.monthly; // Assign quarters array to monthlyData
                    this.sqlQuery = response.data.sql_query;   // Assign SQL query to sqlQuery for debugging
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                });
        }
    }
}
</script>



























<!-- 
<template>
    <div class="card" style="margin-top:1%;">
    <div class="card-body">
        <table id="tb1" class="table table-striped table-responsive table-bordered dropbox">
            <thead>
				<tr style="background-color: #367fa9; color: white;">
					<th class="text-center" colspan="13">Indicator A:
					</th>
				</tr>
				<tr style="background-color: #ffa500a3;">
					<th class="text-center" width="7.5%">JAN</th>
					<th class="text-center" width="7.5%">FEB</th>
					<th class="text-center" width="7.5%">MAR</th>
					<th class="text-center" width="7.5%">APR</th>
					<th class="text-center" width="7.5%">MAY</th>
					<th class="text-center" width="7.5%">JUN</th>
					<th class="text-center" width="7.5%">JUL</th>
					<th class="text-center" width="7.5%">AUG</th>
					<th class="text-center" width="7.5%">SEP</th>
					<th class="text-center" width="7.5%">OCT</th>
					<th class="text-center" width="7.5%">NOV</th>
					<th class="text-center" width="7.5%">DEC</th>
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
                    <td rowspan="2" class="text-center" width="7.5%"
                        style="vertical-align: middle;">00.0</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="card" style="margin-top:1%;">
    <div class="card-body">
        <table id="tb1" class="table table-striped table-responsive table-bordered dropbox">
            <thead>
				<tr style="background-color: #367fa9; color: white;">
					<th class="text-center" colspan="13">Indicator B:
					</th>
				</tr>
				<tr style="background-color: #ffa500a3;">
					<th class="text-center" width="7.5%">JAN</th>
					<th class="text-center" width="7.5%">FEB</th>
					<th class="text-center" width="7.5%">MAR</th>
					<th class="text-center" width="7.5%">APR</th>
					<th class="text-center" width="7.5%">MAY</th>
					<th class="text-center" width="7.5%">JUN</th>
					<th class="text-center" width="7.5%">JUL</th>
					<th class="text-center" width="7.5%">AUG</th>
					<th class="text-center" width="7.5%">SEP</th>
					<th class="text-center" width="7.5%">OCT</th>
					<th class="text-center" width="7.5%">NOV</th>
					<th class="text-center" width="7.5%">DEC</th>
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
                    <td rowspan="2" class="text-center" width="7.5%"
                        style="vertical-align: middle;">00.0</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="card" style="margin-top:1%;">
    <div class="card-body">
        <table id="tb1" class="table table-striped table-responsive table-bordered dropbox">
            <thead>
				<tr style="background-color: #367fa9; color: white;">
					<th class="text-center" colspan="13">Indicator C:
					</th>
				</tr>
				<tr style="background-color: #ffa500a3;">
					<th class="text-center" width="7.5%">JAN</th>
					<th class="text-center" width="7.5%">FEB</th>
					<th class="text-center" width="7.5%">MAR</th>
					<th class="text-center" width="7.5%">APR</th>
					<th class="text-center" width="7.5%">MAY</th>
					<th class="text-center" width="7.5%">JUN</th>
					<th class="text-center" width="7.5%">JUL</th>
					<th class="text-center" width="7.5%">AUG</th>
					<th class="text-center" width="7.5%">SEP</th>
					<th class="text-center" width="7.5%">OCT</th>
					<th class="text-center" width="7.5%">NOV</th>
					<th class="text-center" width="7.5%">DEC</th>
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
                    <td rowspan="2" class="text-center" width="7.5%"
                        style="vertical-align: middle;">00.0</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="card" style="margin-top:1%;">
    <div class="card-body">
        <table id="tb1" class="table table-striped table-responsive table-bordered dropbox">
            <thead>
				<tr style="background-color: #367fa9; color: white;">
					<th class="text-center" colspan="13">Indicator D:
					</th>
				</tr>
				<tr style="background-color: #ffa500a3;">
					<th class="text-center" width="7.5%">JAN</th>
					<th class="text-center" width="7.5%">FEB</th>
					<th class="text-center" width="7.5%">MAR</th>
					<th class="text-center" width="7.5%">APR</th>
					<th class="text-center" width="7.5%">MAY</th>
					<th class="text-center" width="7.5%">JUN</th>
					<th class="text-center" width="7.5%">JUL</th>
					<th class="text-center" width="7.5%">AUG</th>
					<th class="text-center" width="7.5%">SEP</th>
					<th class="text-center" width="7.5%">OCT</th>
					<th class="text-center" width="7.5%">NOV</th>
					<th class="text-center" width="7.5%">DEC</th>
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
                    <td rowspan="2" class="text-center" width="7.5%"
                        style="vertical-align: middle;">00.0</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="card" style="margin-top:1%;">
    <div class="card-body">
        <table id="tb1" class="table table-striped table-responsive table-bordered dropbox">
            <thead>
				<tr style="background-color: #367fa9; color: white;">
					<th class="text-center" colspan="13">Indicator E:
					</th>
				</tr>
				<tr style="background-color: #ffa500a3;">
					<th class="text-center" width="7.5%">JAN</th>
					<th class="text-center" width="7.5%">FEB</th>
					<th class="text-center" width="7.5%">MAR</th>
					<th class="text-center" width="7.5%">APR</th>
					<th class="text-center" width="7.5%">MAY</th>
					<th class="text-center" width="7.5%">JUN</th>
					<th class="text-center" width="7.5%">JUL</th>
					<th class="text-center" width="7.5%">AUG</th>
					<th class="text-center" width="7.5%">SEP</th>
					<th class="text-center" width="7.5%">OCT</th>
					<th class="text-center" width="7.5%">NOV</th>
					<th class="text-center" width="7.5%">DEC</th>
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
                    <td rowspan="2" class="text-center" width="7.5%"
                        style="vertical-align: middle;">00.0</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
</template> -->