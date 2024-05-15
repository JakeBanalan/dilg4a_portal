<style>
.profile_img {
    width: 100px;
    height: 100px;
    padding: 1px;
    margin-bottom: 15%;
    border-radius: 100%;
    border: 1px solid rgb(18, 15, 76);
}

.user_info {
    display: flex;
    justify-content: space-between;
    margin: 0px;
    vertical-align: middle;
    width: 100%;
}

.rank_banner {
    background-color: rgb(104, 34, 142);
    color: rgb(255, 255, 255);
    font-family: Barlow, sans-serif;
    font-size: 1.25rem;
    font-weight: 400;
    line-height: 1.5;
    margin: 0px;
    text-decoration: none;
}

.rank_banner2 {
    background-color: rgb(128, 22, 22);
    color: rgb(255, 255, 255);
    font-family: Barlow, sans-serif;
    font-size: 1.25rem;
    font-weight: 400;
    line-height: 1.5;
    margin: 0px;
    text-decoration: none;
}

.rank_banner3 {
    background-color: rgb(45, 2, 85);
    color: rgb(255, 255, 255);
    font-family: Barlow, sans-serif;
    font-size: 1.25rem;
    font-weight: 400;
    line-height: 1.5;
    margin: 0px;
    text-decoration: none;
}

.rank_wrapper {
    -webkit-clip-path: polygon(100% 0px, 0px 0px, 100% 100%);
    clip-path: polygon(100% 0px, 0px 0px, 100% 100%);
    height: 4.5rem;
    padding-right: 4px;
    padding-top: 2px;
    position: absolute;
    right: 0px;
    text-align: right;
    top: 0px;
    width: 4.5rem;
}

.card_shadow {
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    /* Change box shadow on hover for an interactive effect */

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
                        <div class="col-md-12 grid-margin mb-4">
                            <div class="card card_shadow">
                                <div class="card-body">
                                    <div id="detailedReports"
                                        class="carousel slide detailed-report-carousel position-static pt-2"
                                        data-ride="carousel">
                                        <div class="carousel-inner">
                                            <div class="carousel-item active">
                                                <div class="row">
                                                    <div
                                                        class="col-md-12 col-xl-3 d-flex flex-column justify-content-start">
                                                        <div class="ml-xl-4 mt-3">
                                                            <p class="card-title">Detailed Reports</p>
                                                            <h1 class="text-primary">$34040</h1>
                                                            <h3 class="font-weight-500 mb-xl-4 text-primary">North
                                                                America
                                                            </h3>
                                                            <p class="mb-2 mb-xl-0">The total number of sessions within
                                                                the
                                                                date range. It is the period time a user is actively
                                                                engaged
                                                                with your website, page or app, etc</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-xl-9">
                                                        <div class="row">
                                                            <div class="col-md-6 border-right">
                                                                <div class="table-responsive mb-3 mb-md-0 mt-3">
                                                                    <table class="table table-borderless report-table">
                                                                        <tr>
                                                                            <td class="text-muted">Illinois</td>
                                                                            <td class="w-100 px-0">
                                                                                <div class="progress progress-md mx-4">
                                                                                    <div class="progress-bar bg-primary"
                                                                                        role="progressbar"
                                                                                        style="width: 70%"
                                                                                        aria-valuenow="70"
                                                                                        aria-valuemin="0"
                                                                                        aria-valuemax="100"></div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <h5 class="font-weight-bold mb-0">713
                                                                                </h5>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="text-muted">Washington</td>
                                                                            <td class="w-100 px-0">
                                                                                <div class="progress progress-md mx-4">
                                                                                    <div class="progress-bar bg-warning"
                                                                                        role="progressbar"
                                                                                        style="width: 30%"
                                                                                        aria-valuenow="30"
                                                                                        aria-valuemin="0"
                                                                                        aria-valuemax="100"></div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <h5 class="font-weight-bold mb-0">583
                                                                                </h5>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="text-muted">Mississippi</td>
                                                                            <td class="w-100 px-0">
                                                                                <div class="progress progress-md mx-4">
                                                                                    <div class="progress-bar bg-danger"
                                                                                        role="progressbar"
                                                                                        style="width: 95%"
                                                                                        aria-valuenow="95"
                                                                                        aria-valuemin="0"
                                                                                        aria-valuemax="100"></div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <h5 class="font-weight-bold mb-0">924
                                                                                </h5>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="text-muted">California</td>
                                                                            <td class="w-100 px-0">
                                                                                <div class="progress progress-md mx-4">
                                                                                    <div class="progress-bar bg-info"
                                                                                        role="progressbar"
                                                                                        style="width: 60%"
                                                                                        aria-valuenow="60"
                                                                                        aria-valuemin="0"
                                                                                        aria-valuemax="100"></div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <h5 class="font-weight-bold mb-0">664
                                                                                </h5>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="text-muted">Maryland</td>
                                                                            <td class="w-100 px-0">
                                                                                <div class="progress progress-md mx-4">
                                                                                    <div class="progress-bar bg-primary"
                                                                                        role="progressbar"
                                                                                        style="width: 40%"
                                                                                        aria-valuenow="40"
                                                                                        aria-valuemin="0"
                                                                                        aria-valuemax="100"></div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <h5 class="font-weight-bold mb-0">560
                                                                                </h5>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="text-muted">Alaska</td>
                                                                            <td class="w-100 px-0">
                                                                                <div class="progress progress-md mx-4">
                                                                                    <div class="progress-bar bg-danger"
                                                                                        role="progressbar"
                                                                                        style="width: 75%"
                                                                                        aria-valuenow="75"
                                                                                        aria-valuemin="0"
                                                                                        aria-valuemax="100"></div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <h5 class="font-weight-bold mb-0">793
                                                                                </h5>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 mt-3">
                                                                <canvas id="north-america-chart"></canvas>
                                                                <div id="north-america-legend"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="carousel-item">
                                                <div class="row">
                                                    <div
                                                        class="col-md-12 col-xl-3 d-flex flex-column justify-content-start">
                                                        <div class="ml-xl-4 mt-3">
                                                            <p class="card-title">Detailed Reports</p>
                                                            <h1 class="text-primary">$34040</h1>
                                                            <h3 class="font-weight-500 mb-xl-4 text-primary">North
                                                                America
                                                            </h3>
                                                            <p class="mb-2 mb-xl-0">The total number of sessions within
                                                                the
                                                                date range. It is the period time a user is actively
                                                                engaged
                                                                with your website, page or app, etc</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-xl-9">
                                                        <div class="row">
                                                            <div class="col-md-6 border-right">
                                                                <div class="table-responsive mb-3 mb-md-0 mt-3">
                                                                    <table class="table table-borderless report-table">
                                                                        <tr>
                                                                            <td class="text-muted">Illinois</td>
                                                                            <td class="w-100 px-0">
                                                                                <div class="progress progress-md mx-4">
                                                                                    <div class="progress-bar bg-primary"
                                                                                        role="progressbar"
                                                                                        style="width: 70%"
                                                                                        aria-valuenow="70"
                                                                                        aria-valuemin="0"
                                                                                        aria-valuemax="100"></div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <h5 class="font-weight-bold mb-0">713
                                                                                </h5>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="text-muted">Washington</td>
                                                                            <td class="w-100 px-0">
                                                                                <div class="progress progress-md mx-4">
                                                                                    <div class="progress-bar bg-warning"
                                                                                        role="progressbar"
                                                                                        style="width: 30%"
                                                                                        aria-valuenow="30"
                                                                                        aria-valuemin="0"
                                                                                        aria-valuemax="100"></div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <h5 class="font-weight-bold mb-0">583
                                                                                </h5>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="text-muted">Mississippi</td>
                                                                            <td class="w-100 px-0">
                                                                                <div class="progress progress-md mx-4">
                                                                                    <div class="progress-bar bg-danger"
                                                                                        role="progressbar"
                                                                                        style="width: 95%"
                                                                                        aria-valuenow="95"
                                                                                        aria-valuemin="0"
                                                                                        aria-valuemax="100"></div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <h5 class="font-weight-bold mb-0">924
                                                                                </h5>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="text-muted">California</td>
                                                                            <td class="w-100 px-0">
                                                                                <div class="progress progress-md mx-4">
                                                                                    <div class="progress-bar bg-info"
                                                                                        role="progressbar"
                                                                                        style="width: 60%"
                                                                                        aria-valuenow="60"
                                                                                        aria-valuemin="0"
                                                                                        aria-valuemax="100"></div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <h5 class="font-weight-bold mb-0">664
                                                                                </h5>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="text-muted">Maryland</td>
                                                                            <td class="w-100 px-0">
                                                                                <div class="progress progress-md mx-4">
                                                                                    <div class="progress-bar bg-primary"
                                                                                        role="progressbar"
                                                                                        style="width: 40%"
                                                                                        aria-valuenow="40"
                                                                                        aria-valuemin="0"
                                                                                        aria-valuemax="100"></div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <h5 class="font-weight-bold mb-0">560
                                                                                </h5>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="text-muted">Alaska</td>
                                                                            <td class="w-100 px-0">
                                                                                <div class="progress progress-md mx-4">
                                                                                    <div class="progress-bar bg-danger"
                                                                                        role="progressbar"
                                                                                        style="width: 75%"
                                                                                        aria-valuenow="75"
                                                                                        aria-valuemin="0"
                                                                                        aria-valuemax="100"></div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <h5 class="font-weight-bold mb-0">793
                                                                                </h5>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 mt-3">
                                                                <canvas id="south-america-chart"></canvas>
                                                                <div id="south-america-legend"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <a class="carousel-control-prev" href="#detailedReports" role="button"
                                            data-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="sr-only">Previous</span>
                                        </a>
                                        <a class="carousel-control-next" href="#detailedReports" role="button"
                                            data-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="sr-only">Next</span>
                                        </a>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 mt-4">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h5 class="card-title"><font-awesome-icon
                                            :icon="['fas', 'list']"></font-awesome-icon>&nbsp;Procurement Progress
                                    </h5>
                                    <div class="table-responsive">
                                        <ul class="cd-breadcrumb triangle nav nav-tabs" role="tablist">
                                          <li role="presentation" :class="{ 'active': activeTab === 'tab1' }">
                                            <a @click="changeTab('tab1')" href="#Ideate" aria-controls="ideate" role="tab" data-toggle="tab" aria-expanded="false">
                                                <i class="fa fa-list" aria-hidden="true"></i> Purchase Request Type per Division
                                            </a>
                                          </li>
                                          <li role="presentation" :class="{ 'active': activeTab === 'tab2' }">
                                            <a @click="changeTab('tab2')" href="#Ideate" aria-controls="ideate" role="tab" data-toggle="tab" aria-expanded="false">
                                                <i class="fa fa-list" aria-hidden="true"></i>Purchase Request per Month
                                            </a>
                                          </li>
                                          <li role="presentation" :class="{ 'active': activeTab === 'tab3' }">
                                            <a @click="changeTab('tab3')" href="#Ideate" aria-controls="ideate" role="tab" data-toggle="tab" aria-expanded="false">
                                                <i class="fa fa-list" aria-hidden="true"></i> Top 20 Purchase Request
                                            </a>
                                          </li>
                                          
                                        </ul>
                                        <div class="tab-content">
                                            <div role="tabpanel" :class="{ 'tab-pane active': activeTab === 'tab1', 'tab-pane': activeTab !== 'tab1' }"  id="tab1">
                          
                                            <table class="table table-bordered" style="font-size:10pt;">
                                              <thead>
                                                <tr>
                                                  <th rowspan="2" width="15%" class="header_pink" style="vertical-align: middle;text-align:center;">Division</th>
                                                  <th rowspan="2" class="header_pink" style="vertical-align: middle;">Total No. of Catering Services</th>
                                                  <th rowspan="2" class="header_yellow" style="vertical-align: middle;">Total No. of Meals, Venue and Accomodation </th>
                                                  <th rowspan="2" class="header_yellow" style="vertical-align: middle;">Total No. of Repair and Maintenance</th>
                                                  <th rowspan="2" class="header_yellow" style="vertical-align: middle;">Total No. of Supplies, Materials and Devices</th>
                                                  <th rowspan="2" class="header_yellow" style="vertical-align: middle;">Total No. of Other Services</th>
                                                  <th rowspan="2" class="header_yellow" style="vertical-align: middle;">Total No. of Reimbursement and Petty Cash</th>
                                                </tr>
                          
                          
                                              </thead>
                                              <tbody id="list_body">
                                                <tr style="background-color: #8ae38a;">
                                                  <td style="text-align: center; vertical-align: middle;"><b>TOTAL</b></td>
                                                  <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>45</b></td>
                                                  <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>96</b></td>
                                                  <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>33</b></td>
                                                  <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>147</b></td>
                                                  <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>63</b></td>
                                                  <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>95</b></td>
                                                </tr>
                                                <tr>
                                                  <td style="text-align: center; vertical-align: middle;"><b>FAD</b></td>
                                                  <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>17</b></td>
                                                  <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>13</b></td>
                                                  <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>33</b></td>
                                                  <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>24</b></td>
                                                  <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>20</b></td>
                                                  <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>77</b></td>
                                                </tr>
                                                <tr>
                                                  <td style="text-align: center; vertical-align: middle;"><b>LGCDD</b></td>
                                                  <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>23</b></td>
                                                  <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>35</b></td>
                                                  <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>0</b></td>
                                                  <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>45</b></td>
                                                  <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>29</b></td>
                                                  <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>1</b></td>
                                                </tr>
                                                <tr>
                                                  <td style="text-align: center; vertical-align: middle;"><b>LGMED</b></td>
                                                  <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>4</b></td>
                                                  <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>44</b></td>
                                                  <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>0</b></td>
                                                  <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>73</b></td>
                                                  <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>12</b></td>
                                                  <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>17</b></td>
                                                </tr>
                                                <tr>
                                                  <td style="text-align: center; vertical-align: middle;"><b>ORD</b></td>
                                                  <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>1</b></td>
                                                  <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>4</b></td>
                                                  <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>0</b></td>
                                                  <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>5</b></td>
                                                  <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>2</b></td>
                                                  <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>0</b></td>
                                                </tr>
                          
                          
                          
                                              </tbody>
                                            </table>
                          
                                          </div>
                                          <div role="tabpanel" :class="{ 'tab-pane active': activeTab === 'tab2', 'tab-pane': activeTab !== 'tab2' }"  id="tab2" style="">
                                            <span class="pull-right hidden-xs"><small>
                                                <input type="radio" name="mychart" class="mychart" id="column" value="column" onclick="chartfunc()">Column
                                                <input type="radio" name="mychart" class="mychart" id="bar" value="bar" onclick="chartfunc()" checked="">Bar
                                                <input type="radio" name="mychart" class="mychart" id="pie" value="pie" onclick="chartfunc()">Pie
                                                <input type="radio" name="mychart" class="mychart" id="line" value="line" onclick="chartfunc()">Line
                                              </small></span>
                          
                          
                          
                          
                                            <div id="container" style="min-width: 310px; height: 400px; margin: 0px auto; overflow: hidden;" data-highcharts-chart="0"><div id="highcharts-i2sc7y8-0" dir="ltr" style="position: relative; overflow: hidden; width: 498px; height: 400px; text-align: left; line-height: normal; z-index: 0; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); user-select: none; touch-action: manipulation; outline: none;" class="highcharts-container "><svg version="1.1" class="highcharts-root" style="font-family: Helvetica, Arial, sans-serif; font-size: 1rem;" xmlns="http://www.w3.org/2000/svg" width="498" height="400" viewBox="0 0 498 400" role="img" aria-label="Purchase Request per Division"><desc>Created with Highcharts 11.4.1</desc><defs><filter id="highcharts-drop-shadow-0"><feDropShadow dx="1" dy="1" flood-color="#000000" flood-opacity="0.75" stdDeviation="2.5"></feDropShadow></filter><clipPath id="highcharts-i2sc7y8-5-"><rect x="0" y="0" width="257" height="434" fill="none"></rect></clipPath><filter id="highcharts-drop-shadow-0-offsetx--1-offsety--1"><feDropShadow dx="-1" dy="-1" flood-color="#000000" flood-opacity="0.75" stdDeviation="2.5"></feDropShadow></filter></defs><rect fill="#ffffff" class="highcharts-background" filter="none" x="0" y="0" width="498" height="400" rx="0" ry="0"></rect><rect fill="none" class="highcharts-plot-background" x="54" y="47" width="434" height="257" filter="none"></rect><g class="highcharts-grid highcharts-yaxis-grid" data-z-index="1"><path fill="none" stroke="#e6e6e6" stroke-width="1" stroke-dasharray="none" data-z-index="1" class="highcharts-grid-line" d="M 53.5 47 L 53.5 304" opacity="1"></path><path fill="none" stroke="#e6e6e6" stroke-width="1" stroke-dasharray="none" data-z-index="1" class="highcharts-grid-line" d="M 270.5 47 L 270.5 304" opacity="1"></path><path fill="none" stroke="#e6e6e6" stroke-width="1" stroke-dasharray="none" data-z-index="1" class="highcharts-grid-line" d="M 488.5 47 L 488.5 304" opacity="1"></path><path fill="none" stroke="#e6e6e6" stroke-width="1" stroke-dasharray="none" data-z-index="1" class="highcharts-grid-line" d="M 107.5 47 L 107.5 304" opacity="1"></path><path fill="none" stroke="#e6e6e6" stroke-width="1" stroke-dasharray="none" data-z-index="1" class="highcharts-grid-line" d="M 162.5 47 L 162.5 304" opacity="1"></path><path fill="none" stroke="#e6e6e6" stroke-width="1" stroke-dasharray="none" data-z-index="1" class="highcharts-grid-line" d="M 216.5 47 L 216.5 304" opacity="1"></path><path fill="none" stroke="#e6e6e6" stroke-width="1" stroke-dasharray="none" data-z-index="1" class="highcharts-grid-line" d="M 324.5 47 L 324.5 304" opacity="1"></path><path fill="none" stroke="#e6e6e6" stroke-width="1" stroke-dasharray="none" data-z-index="1" class="highcharts-grid-line" d="M 379.5 47 L 379.5 304" opacity="1"></path><path fill="none" stroke="#e6e6e6" stroke-width="1" stroke-dasharray="none" data-z-index="1" class="highcharts-grid-line" d="M 433.5 47 L 433.5 304" opacity="1"></path></g><g class="highcharts-grid highcharts-xaxis-grid" data-z-index="1"><path fill="none" stroke="#e6e6e6" stroke-width="0" stroke-dasharray="none" data-z-index="1" class="highcharts-grid-line" d="M 54 111.5 L 488 111.5" opacity="1"></path><path fill="none" stroke="#e6e6e6" stroke-width="0" stroke-dasharray="none" data-z-index="1" class="highcharts-grid-line" d="M 54 176.5 L 488 176.5" opacity="1"></path><path fill="none" stroke="#e6e6e6" stroke-width="0" stroke-dasharray="none" data-z-index="1" class="highcharts-grid-line" d="M 54 240.5 L 488 240.5" opacity="1"></path><path fill="none" stroke="#e6e6e6" stroke-width="0" stroke-dasharray="none" data-z-index="1" class="highcharts-grid-line" d="M 54 304.5 L 488 304.5" opacity="1"></path><path fill="none" stroke="#e6e6e6" stroke-width="0" stroke-dasharray="none" data-z-index="1" class="highcharts-grid-line" d="M 54 47.5 L 488 47.5" opacity="1"></path></g><rect fill="none" class="highcharts-plot-border" data-z-index="1" stroke="#cccccc" stroke-width="0" x="54" y="47" width="434" height="257"></rect><g class="highcharts-axis highcharts-yaxis" data-z-index="2"><text x="271" data-z-index="7" text-anchor="middle" transform="translate(0,0)" class="highcharts-axis-title" style="color: rgb(102, 102, 102); font-size: 0.8em; fill: rgb(102, 102, 102);" y="345.88914585113525">Values</text><path fill="none" class="highcharts-axis-line" stroke="#333333" stroke-width="0" data-z-index="7" d="M 54 304 L 488 304"></path></g><g class="highcharts-axis highcharts-xaxis" data-z-index="2"><path fill="none" class="highcharts-axis-line" stroke="#333333" stroke-width="1" data-z-index="7" d="M 53.5 47 L 53.5 304"></path></g><g class="highcharts-series-group" data-z-index="3" filter="none"><g class="highcharts-series highcharts-series-0 highcharts-bar-series highcharts-tracker" data-z-index="0.1" opacity="1" transform="translate(54,47) rotate(90 88.5 345.5) scale(-1 1)" clip-path="url(#highcharts-i2sc7y8-5-)"><path fill="#2caffe" d="M 216 31 L 234 31 A 3 3 0 0 1 237 34 L 237 435 A 0 0 0 0 1 237 435 L 213 435 A 0 0 0 0 1 213 435 L 213 34 A 3 3 0 0 1 216 31 Z" stroke="#ffffff" stroke-width="0" opacity="1" filter="none" class="highcharts-point highcharts-color-0"></path><path fill="#544fc5" d="M 152 140 L 170 140 A 3 3 0 0 1 173 143 L 173 435 A 0 0 0 0 1 173 435 L 149 435 A 0 0 0 0 1 149 435 L 149 143 A 3 3 0 0 1 152 140 Z" stroke="#ffffff" stroke-width="0" opacity="1" filter="none" class="highcharts-point highcharts-color-1"></path><path fill="#00e272" d="M 88 105 L 106 105 A 3 3 0 0 1 109 108 L 109 435 A 0 0 0 0 1 109 435 L 85 435 A 0 0 0 0 1 85 435 L 85 108 A 3 3 0 0 1 88 105 Z" stroke="#ffffff" stroke-width="0" opacity="1" filter="none" class="highcharts-point highcharts-color-2"></path><path fill="#fe6a35" d="M 24 409 L 42 409 A 3 3 0 0 1 45 412 L 45 435 A 0 0 0 0 1 45 435 L 21 435 A 0 0 0 0 1 21 435 L 21 412 A 3 3 0 0 1 24 409 Z" stroke="#ffffff" stroke-width="0" opacity="1" filter="none" class="highcharts-point highcharts-color-3"></path></g><g class="highcharts-markers highcharts-series-0 highcharts-bar-series" data-z-index="0.1" opacity="1" transform="translate(54,47) scale(1 1)" clip-path="none"></g></g><g class="highcharts-exporting-group" data-z-index="3"><g class="highcharts-no-tooltip highcharts-button highcharts-contextbutton" stroke-linecap="round" style="cursor: pointer;" transform="translate(460,10)"><title>Chart context menu</title><rect fill="#ffffff" class="highcharts-button-box" x="0.5" y="0.5" width="28" height="28" rx="2" ry="2" stroke="none" stroke-width="1"></rect><path fill="#666666" d="M 8 9.5 L 22 9.5 M 8 14.5 L 22 14.5 M 8 19.5 L 22 19.5" class="highcharts-button-symbol" data-z-index="1" stroke="#666666" stroke-width="3"></path><text x="0" data-z-index="1" y="17.5" style="color: rgb(51, 51, 51); font-size: 0.8em; font-weight: normal; fill: rgb(51, 51, 51);"></text></g></g><text x="249" text-anchor="middle" class="highcharts-title" data-z-index="4" style="font-size: 1.2em; color: rgb(51, 51, 51); font-weight: bold; fill: rgb(51, 51, 51);" y="19">Purchase Request per Division</text><text x="249" text-anchor="middle" class="highcharts-subtitle" data-z-index="4" style="color: rgb(102, 102, 102); font-size: 0.8em; fill: rgb(102, 102, 102);" y="34">Procurement</text><text x="10" text-anchor="start" class="highcharts-caption" data-z-index="4" style="color: rgb(102, 102, 102); font-size: 0.8em; fill: rgb(102, 102, 102);" y="394"></text><g class="highcharts-data-labels highcharts-series-0 highcharts-bar-series highcharts-tracker" data-z-index="6" opacity="1" transform="translate(54,47) scale(1 1)"><g class="highcharts-label highcharts-data-label highcharts-data-label-color-0" data-z-index="1" filter="none" transform="translate(403,23)"><text x="5" data-z-index="1" y="13" style="color: rgb(0, 0, 0); font-size: 0.7em; font-weight: bold; fill: rgb(0, 0, 0);"><tspan class="highcharts-text-outline" fill="#FFFFFF" stroke="#FFFFFF" stroke-width="2px" stroke-linejoin="round">186<tspan x="5" dy="0">&ZeroWidthSpace;</tspan></tspan>186</text></g><g class="highcharts-label highcharts-data-label highcharts-data-label-color-1" data-z-index="1" filter="none" transform="translate(294,87)"><text x="5" data-z-index="1" y="13" style="color: rgb(0, 0, 0); font-size: 0.7em; font-weight: bold; fill: rgb(0, 0, 0);"><tspan class="highcharts-text-outline" fill="#FFFFFF" stroke="#FFFFFF" stroke-width="2px" stroke-linejoin="round">136<tspan x="5" dy="0">&ZeroWidthSpace;</tspan></tspan>136</text></g><g class="highcharts-label highcharts-data-label highcharts-data-label-color-2" data-z-index="1" filter="none" transform="translate(329,151)"><text x="5" data-z-index="1" y="13" style="color: rgb(0, 0, 0); font-size: 0.7em; font-weight: bold; fill: rgb(0, 0, 0);"><tspan class="highcharts-text-outline" fill="#FFFFFF" stroke="#FFFFFF" stroke-width="2px" stroke-linejoin="round">152<tspan x="5" dy="0">&ZeroWidthSpace;</tspan></tspan>152</text></g><g class="highcharts-label highcharts-data-label highcharts-data-label-color-3" data-z-index="1" filter="none" transform="translate(25,215)"><text x="5" data-z-index="1" y="13" style="color: rgb(0, 0, 0); font-size: 0.7em; font-weight: bold; fill: rgb(0, 0, 0);"><tspan class="highcharts-text-outline" fill="#FFFFFF" stroke="#FFFFFF" stroke-width="2px" stroke-linejoin="round">12<tspan x="5" dy="0">&ZeroWidthSpace;</tspan></tspan>12</text></g></g><g class="highcharts-legend highcharts-no-tooltip" data-z-index="7" transform="translate(216,359)"><rect fill="none" class="highcharts-legend-box" rx="0" ry="0" stroke="#999999" stroke-width="0" filter="none" x="0" y="0" width="66" height="26"></rect><g data-z-index="1"><g><g class="highcharts-legend-item highcharts-bar-series highcharts-color-undefined highcharts-series-0" data-z-index="1" transform="translate(8,3)"><text x="21" text-anchor="start" data-z-index="2" style="color: rgb(51, 51, 51); cursor: pointer; font-size: 0.8em; text-decoration: none; fill: rgb(51, 51, 51);" y="13">Series 1</text><rect x="4" y="6" rx="4" ry="4" width="8" height="8" fill="#cccccc" class="highcharts-point" data-z-index="3"></rect></g></g></g></g><g class="highcharts-axis-labels highcharts-yaxis-labels" data-z-index="7"><text x="54" text-anchor="middle" transform="translate(0,0)" style="color: rgb(51, 51, 51); cursor: default; font-size: 0.8em; fill: rgb(51, 51, 51);" y="328" opacity="1">0</text><text x="271" text-anchor="middle" transform="translate(0,0)" style="color: rgb(51, 51, 51); cursor: default; font-size: 0.8em; fill: rgb(51, 51, 51);" y="328" opacity="1">100</text><text x="481.32735300064087" text-anchor="middle" transform="translate(0,0)" style="color: rgb(51, 51, 51); cursor: default; font-size: 0.8em; fill: rgb(51, 51, 51);" y="328" opacity="1">200</text><text x="108.25" text-anchor="middle" transform="translate(0,0)" style="color: rgb(51, 51, 51); cursor: default; font-size: 0.8em; fill: rgb(51, 51, 51);" y="328" opacity="1">25</text><text x="162.5" text-anchor="middle" transform="translate(0,0)" style="color: rgb(51, 51, 51); cursor: default; font-size: 0.8em; fill: rgb(51, 51, 51);" y="328" opacity="1">50</text><text x="216.75" text-anchor="middle" transform="translate(0,0)" style="color: rgb(51, 51, 51); cursor: default; font-size: 0.8em; fill: rgb(51, 51, 51);" y="328" opacity="1">75</text><text x="325.25" text-anchor="middle" transform="translate(0,0)" style="color: rgb(51, 51, 51); cursor: default; font-size: 0.8em; fill: rgb(51, 51, 51);" y="328" opacity="1">125</text><text x="379.5" text-anchor="middle" transform="translate(0,0)" style="color: rgb(51, 51, 51); cursor: default; font-size: 0.8em; fill: rgb(51, 51, 51);" y="328" opacity="1">150</text><text x="433.75" text-anchor="middle" transform="translate(0,0)" style="color: rgb(51, 51, 51); cursor: default; font-size: 0.8em; fill: rgb(51, 51, 51);" y="328" opacity="1">175</text></g><g class="highcharts-axis-labels highcharts-xaxis-labels" data-z-index="7"><text x="39" text-anchor="end" transform="translate(0,0)" style="color: rgb(51, 51, 51); cursor: default; font-size: 0.8em; fill: rgb(51, 51, 51);" y="84" opacity="1">FAD</text><text x="39" text-anchor="end" transform="translate(0,0)" style="color: rgb(51, 51, 51); cursor: default; font-size: 0.8em; fill: rgb(51, 51, 51);" y="148" opacity="1">LGCDD</text><text x="39" text-anchor="end" transform="translate(0,0)" style="color: rgb(51, 51, 51); cursor: default; font-size: 0.8em; fill: rgb(51, 51, 51);" y="212" opacity="1">LGMED</text><text x="39" text-anchor="end" transform="translate(0,0)" style="color: rgb(51, 51, 51); cursor: default; font-size: 0.8em; fill: rgb(51, 51, 51);" y="276" opacity="1">ORD</text></g><text x="488" class="highcharts-credits" text-anchor="end" data-z-index="8" y="395" style="cursor: pointer; color: rgb(153, 153, 153); font-size: 0.6em; fill: rgb(153, 153, 153);">Highcharts.com</text><g class="highcharts-label highcharts-tooltip highcharts-color-0" data-z-index="8" filter="url(#highcharts-drop-shadow-0)" style="cursor: default; pointer-events: none;" transform="translate(753,62)" opacity="0" visibility="hidden"><path fill="#ffffff" class="highcharts-label-box highcharts-tooltip-box" d="M 3 0 L 67 0 A 3 3 0 0 1 70 3 L 70 11 L 76 17 L 70 23 L 70 31 A 3 3 0 0 1 67 34 L 3 34 A 3 3 0 0 1 0 31 L 0 3 A 3 3 0 0 1 3 0 Z" stroke-width="0" stroke="#2caffe"></path><text x="8" data-z-index="1" y="15" style="color: rgb(51, 51, 51); font-size: 0.8em; fill: rgb(51, 51, 51);"><tspan style="font-size: 0.8em;">FAD</tspan><tspan class="highcharts-br" dy="11" x="8">&ZeroWidthSpace;</tspan><tspan style="color: rgb(44, 175, 254); fill: rgb(44, 175, 254);">●</tspan> Series 1: <tspan style="font-weight: bold;">186</tspan><tspan class="highcharts-br">&ZeroWidthSpace;</tspan></text></g></svg></div></div>
                          
                          
                          
                          
                                          </div>
                                          <div role="tabpanel" :class="{ 'tab-pane active': activeTab === 'tab3', 'tab-pane': activeTab !== 'tab3' }"  id="tab3" style="font-size:10pt;overflow-y:auto;max-height:350px;">
                                            <table class="table table-bordered">
                                              <thead>
                                                <tr>
                                                  <th rowspan="2" width="15%" class="header_pink" style="font-size:22pt;vertical-align: middle;text-align:center;background-color:#B71C1C;color:#fff;">Rank</th>
                          
                                                  <th rowspan="2" class="header_yellow" style="font-size:22pt;vertical-align: middle;text-align:center;background-color:#B71C1C;color:#fff;">Purchase No.</th>
                                                  <th rowspan="2" class="header_yellow" style="font-size:22pt;vertical-align: middle;text-align:center;background-color:#B71C1C;color:#fff;">Purchase Date</th>
                                                  <th rowspan="2" class="header_yellow" style="font-size:22pt;vertical-align: middle;text-align:center;background-color:#B71C1C;color:#fff;">Office</th>
                                                  <th rowspan="2" class="header_yellow" style="font-size:22pt;vertical-align: middle;text-align:center;background-color:#B71C1C;color:#fff;">Amount</th>
                                                </tr>
                          
                          
                                              </thead>
                                              <tbody id="list_body">
                                                                                              <tr>
                                                                                <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>1</b></td>
                          
                                                                              <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b><a href="procurement_purchase_request_view.php?&amp;id=2521&amp;pr_no=2023-10-0520">2023-10-0520</a></b></td>
                                                    <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>October 24, 2023</b></td>
                                                    <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>FAD</b></td>
                                                    <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>Php7,360,974.96</b></td>
                                                  </tr>
                                                                        <tr>
                                                                                <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>2</b></td>
                          
                                                                              <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b><a href="procurement_purchase_request_view.php?&amp;id=2549&amp;pr_no=2023-11-0548">2023-11-0548</a></b></td>
                                                    <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>November 06, 2023</b></td>
                                                    <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>FAD</b></td>
                                                    <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>Php6,720,000.00</b></td>
                                                  </tr>
                                                                        <tr>
                                                                                <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>3</b></td>
                          
                                                                              <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b><a href="procurement_purchase_request_view.php?&amp;id=2531&amp;pr_no=2023-10-0530">2023-10-0530</a></b></td>
                                                    <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>October 25, 2023</b></td>
                                                    <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>FAD</b></td>
                                                    <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>Php1,032,625.92</b></td>
                                                  </tr>
                                                                        <tr>
                                                                                <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>4</b></td>
                          
                                                                              <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b><a href="procurement_purchase_request_view.php?&amp;id=2564&amp;pr_no=2023-11-0563">2023-11-0563</a></b></td>
                                                    <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>November 07, 2023</b></td>
                                                    <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>LGCDD</b></td>
                                                    <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>Php918,000.00</b></td>
                                                  </tr>
                                                                        <tr>
                                                                                <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>5</b></td>
                          
                                                                              <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b><a href="procurement_purchase_request_view.php?&amp;id=2530&amp;pr_no=2023-10-0529">2023-10-0529</a></b></td>
                                                    <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>October 25, 2023</b></td>
                                                    <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>FAD</b></td>
                                                    <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>Php871,041.18</b></td>
                                                  </tr>
                                                                        <tr>
                                                                                <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>6</b></td>
                          
                                                                              <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b><a href="procurement_purchase_request_view.php?&amp;id=2505&amp;pr_no=2023-10-0504">2023-10-0504</a></b></td>
                                                    <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>October 20, 2023</b></td>
                                                    <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>LGCDD</b></td>
                                                    <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>Php760,500.00</b></td>
                                                  </tr>
                                                                        <tr>
                                                                                <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>7</b></td>
                          
                                                                              <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b><a href="procurement_purchase_request_view.php?&amp;id=2539&amp;pr_no=2023-10-0538">2023-10-0538</a></b></td>
                                                    <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>October 27, 2023</b></td>
                                                    <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>LGMED</b></td>
                                                    <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>Php725,466.00</b></td>
                                                  </tr>
                                                                        <tr>
                                                                                <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>8</b></td>
                          
                                                                              <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b><a href="procurement_purchase_request_view.php?&amp;id=2548&amp;pr_no=2023-11-0547">2023-11-0547</a></b></td>
                                                    <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>November 06, 2023</b></td>
                                                    <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>FAD</b></td>
                                                    <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>Php719,955.25</b></td>
                                                  </tr>
                                                                        <tr>
                                                                                <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>9</b></td>
                          
                                                                              <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b><a href="procurement_purchase_request_view.php?&amp;id=2267&amp;pr_no=2023-06-0267">2023-06-0267</a></b></td>
                                                    <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>June 08, 2023</b></td>
                                                    <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>FAD</b></td>
                                                    <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>Php715,500.00</b></td>
                                                  </tr>
                                                                        <tr>
                                                                                <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>10</b></td>
                          
                                                                              <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b><a href="procurement_purchase_request_view.php?&amp;id=2556&amp;pr_no=2023-11-0555">2023-11-0555</a></b></td>
                                                    <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>November 07, 2023</b></td>
                                                    <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>LGCDD</b></td>
                                                    <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>Php647,500.00</b></td>
                                                  </tr>
                                                                        <tr>
                                                                                <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>11</b></td>
                          
                                                                              <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b><a href="procurement_purchase_request_view.php?&amp;id=2551&amp;pr_no=2023-11-0550">2023-11-0550</a></b></td>
                                                    <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>November 06, 2023</b></td>
                                                    <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>LGMED</b></td>
                                                    <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>Php631,000.00</b></td>
                                                  </tr>
                                                                        <tr>
                                                                                <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>12</b></td>
                          
                                                                              <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b><a href="procurement_purchase_request_view.php?&amp;id=2452&amp;pr_no=2023-09-0451">2023-09-0451</a></b></td>
                                                    <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>September 20, 2023</b></td>
                                                    <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>FAD</b></td>
                                                    <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>Php600,000.00</b></td>
                                                  </tr>
                                                                        <tr>
                                                                                <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>13</b></td>
                          
                                                                              <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b><a href="procurement_purchase_request_view.php?&amp;id=2195&amp;pr_no=2023-05-0195">2023-05-0195</a></b></td>
                                                    <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>May 10, 2023</b></td>
                                                    <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>LGCDD</b></td>
                                                    <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>Php580,000.00</b></td>
                                                  </tr>
                                                                        <tr>
                                                                                <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>14</b></td>
                          
                                                                              <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b><a href="procurement_purchase_request_view.php?&amp;id=2237&amp;pr_no=2023-05-0237">2023-05-0237</a></b></td>
                                                    <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>May 29, 2023</b></td>
                                                    <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>LGCDD</b></td>
                                                    <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>Php550,000.00</b></td>
                                                  </tr>
                                                                        <tr>
                                                                                <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>15</b></td>
                          
                                                                              <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b><a href="procurement_purchase_request_view.php?&amp;id=2378&amp;pr_no=2023-08-0378">2023-08-0378</a></b></td>
                                                    <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>August 29, 2023</b></td>
                                                    <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>FAD</b></td>
                                                    <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>Php549,998.00</b></td>
                                                  </tr>
                                                                        <tr>
                                                                                <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>16</b></td>
                          
                                                                              <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b><a href="procurement_purchase_request_view.php?&amp;id=2196&amp;pr_no=2023-05-0196">2023-05-0196</a></b></td>
                                                    <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>May 12, 2023</b></td>
                                                    <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>LGCDD</b></td>
                                                    <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>Php540,000.00</b></td>
                                                  </tr>
                                                                        <tr>
                                                                                <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>17</b></td>
                          
                                                                              <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b><a href="procurement_purchase_request_view.php?&amp;id=2462&amp;pr_no=2023-10-0461">2023-10-0461</a></b></td>
                                                    <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>October 02, 2023</b></td>
                                                    <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>FAD</b></td>
                                                    <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>Php535,500.00</b></td>
                                                  </tr>
                                                                        <tr>
                                                                                <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>18</b></td>
                          
                                                                              <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b><a href="procurement_purchase_request_view.php?&amp;id=2529&amp;pr_no=2023-10-0528">2023-10-0528</a></b></td>
                                                    <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>October 25, 2023</b></td>
                                                    <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>FAD</b></td>
                                                    <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>Php507,466.56</b></td>
                                                  </tr>
                                                                        <tr>
                                                                                <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>19</b></td>
                          
                                                                              <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b><a href="procurement_purchase_request_view.php?&amp;id=2390&amp;pr_no=2023-09-0389">2023-09-0389</a></b></td>
                                                    <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>September 01, 2023</b></td>
                                                    <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>LGMED</b></td>
                                                    <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>Php484,500.00</b></td>
                                                  </tr>
                                                                        <tr>
                                                                                <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>20</b></td>
                          
                                                                              <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b><a href="procurement_purchase_request_view.php?&amp;id=2126&amp;pr_no=2023-03-0127">2023-03-0127</a></b></td>
                                                    <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>March 30, 2023</b></td>
                                                    <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>LGCDD</b></td>
                                                    <td style="font-size:20pt; text-align: center; vertical-align: middle;"><b>Php477,600.00</b></td>
                                                  </tr>
                                                
                          
                          
                          
                          
                                              </tbody>
                                            </table>
                                            
                                          </div>
                          
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
import Navbar from '../layout/Navbar.vue';
import Sidebar from '../layout/Sidebar.vue';
import FooterVue from '../layout/Footer.vue';
import BreadCrumbs from '../dashboard_tiles/BreadCrumbs.vue';
import DetailedReport from '../dashboard_tiles/DetailedReport.vue';
import axios from 'axios';

export default {
    name: 'Procurement',
    data() {
        return {
            appItem: {
                app_total: null
            },
            activeTab:'tab1'
        }
    },
    components: {
        Navbar,
        Sidebar,
        FooterVue,
        BreadCrumbs,
        DetailedReport

    },
    mounted() {
        this.renderDetailedReportChart();
    },
    methods: {
        changeTab(tabName) {
      this.activeTab = tabName; // Update active tab
    },
        toCreatePR() {
            this.$router.push("/gss/create_pr");
        },
        renderDetailedReportChart() {
            if ($("#north-america-chart").length) {
                var areaData = {
                    labels: ["Jan", "Feb", "Mar"],
                    datasets: [{
                        data: [100, 50, 50],
                        backgroundColor: [
                            "#4B49AC", "#FFC100", "#248AFD",
                        ],
                        borderColor: "rgba(0,0,0,0)"
                    }]
                };
                var areaOptions = {
                    responsive: true,
                    maintainAspectRatio: true,
                    segmentShowStroke: false,
                    cutoutPercentage: 78,
                    elements: {
                        arc: {
                            borderWidth: 4
                        }
                    },
                    legend: {
                        display: false
                    },
                    tooltips: {
                        enabled: true
                    },
                    legendCallback: function (chart) {
                        var text = [];
                        text.push('<div class="report-chart">');
                        text.push('<div class="d-flex justify-content-between mx-4 mx-xl-5 mt-3"><div class="d-flex align-items-center"><div class="mr-3" style="width:20px; height:20px; border-radius: 50%; background-color: ' + chart.data.datasets[0].backgroundColor[0] + '"></div><p class="mb-0">Offline sales</p></div>');
                        text.push('<p class="mb-0">88333</p>');
                        text.push('</div>');
                        text.push('<div class="d-flex justify-content-between mx-4 mx-xl-5 mt-3"><div class="d-flex align-items-center"><div class="mr-3" style="width:20px; height:20px; border-radius: 50%; background-color: ' + chart.data.datasets[0].backgroundColor[1] + '"></div><p class="mb-0">Online sales</p></div>');
                        text.push('<p class="mb-0">66093</p>');
                        text.push('</div>');
                        text.push('<div class="d-flex justify-content-between mx-4 mx-xl-5 mt-3"><div class="d-flex align-items-center"><div class="mr-3" style="width:20px; height:20px; border-radius: 50%; background-color: ' + chart.data.datasets[0].backgroundColor[2] + '"></div><p class="mb-0">Returns</p></div>');
                        text.push('<p class="mb-0">39836</p>');
                        text.push('</div>');
                        text.push('</div>');
                        return text.join("");
                    },
                }
                var northAmericaChartPlugins = {
                    beforeDraw: function (chart) {
                        var width = chart.chart.width,
                            height = chart.chart.height,
                            ctx = chart.chart.ctx;

                        ctx.restore();
                        var fontSize = 3.125;
                        ctx.font = "500 " + fontSize + "em sans-serif";
                        ctx.textBaseline = "middle";
                        ctx.fillStyle = "#13381B";

                        var text = "90",
                            textX = Math.round((width - ctx.measureText(text).width) / 2),
                            textY = height / 2;

                        ctx.fillText(text, textX, textY);
                        ctx.save();
                    }
                }
                var northAmericaChartCanvas = $("#north-america-chart").get(0).getContext("2d");
                var northAmericaChart = new Chart(northAmericaChartCanvas, {
                    type: 'doughnut',
                    data: areaData,
                    options: areaOptions,
                    plugins: northAmericaChartPlugins
                });
                document.getElementById('north-america-legend').innerHTML = northAmericaChart.generateLegend();
            }

            if ($("#order-chart-dark").length) {
                var areaData = {
                    labels: ["10", "", "", "20", "", "", "30", "", "", "40", "", "", "50", "", "", "60", "", "", "70"],
                    datasets: [{
                        data: [200, 480, 700, 600, 620, 350, 380, 350, 850, "600", "650", "350", "590", "350", "620", "500", "990", "780", "650"],
                        borderColor: [
                            '#4747A1'
                        ],
                        borderWidth: 2,
                        fill: false,
                        label: "Orders"
                    },
                    {
                        data: [400, 450, 410, 500, 480, 600, 450, 550, 460, "560", "450", "700", "450", "640", "550", "650", "400", "850", "800"],
                        borderColor: [
                            '#F09397'
                        ],
                        borderWidth: 2,
                        fill: false,
                        label: "Downloads"
                    }
                    ]
                };
                var areaOptions = {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        filler: {
                            propagate: false
                        }
                    },
                    scales: {
                        xAxes: [{
                            display: true,
                            ticks: {
                                display: true,
                                padding: 10,
                                fontColor: "#fff"
                            },
                            gridLines: {
                                display: false,
                                drawBorder: false,
                                color: 'transparent',
                                zeroLineColor: '#575757'
                            }
                        }],
                        yAxes: [{
                            display: true,
                            ticks: {
                                display: true,
                                autoSkip: false,
                                maxRotation: 0,
                                stepSize: 200,
                                min: 200,
                                max: 1200,
                                padding: 18,
                                fontColor: "#fff"
                            },
                            gridLines: {
                                display: true,
                                color: "#575757",
                                drawBorder: false
                            }
                        }]
                    },
                    legend: {
                        display: false
                    },
                    tooltips: {
                        enabled: true
                    },
                    elements: {
                        line: {
                            tension: .35
                        },
                        point: {
                            radius: 0
                        }
                    }
                }
                var revenueChartCanvas = $("#order-chart-dark").get(0).getContext("2d");
                var revenueChart = new Chart(revenueChartCanvas, {
                    type: 'line',
                    data: areaData,
                    options: areaOptions
                });
                document.getElementById('order-legend').innerHTML = revenueChart.generateLegend();

            }

            if ($("#sales-chart-dark").length) {
                var SalesChartCanvas = $("#sales-chart-dark").get(0).getContext("2d");
                var SalesChart = new Chart(SalesChartCanvas, {
                    type: 'bar',
                    data: {
                        labels: ["Jan", "Feb", "Mar", "Apr", "May"],
                        datasets: [{
                            label: 'Offline Sales',
                            data: [480, 230, 470, 210, 330],
                            backgroundColor: '#98BDFF'
                        },
                        {
                            label: 'Online Sales',
                            data: [400, 340, 550, 480, 170],
                            backgroundColor: '#4B49AC'
                        }
                        ]
                    },
                    options: {
                        cornerRadius: 5,
                        responsive: true,
                        maintainAspectRatio: true,
                        layout: {
                            padding: {
                                left: 0,
                                right: 0,
                                top: 20,
                                bottom: 0
                            }
                        },
                        scales: {
                            yAxes: [{
                                display: true,
                                gridLines: {
                                    display: true,
                                    drawBorder: false,
                                    color: "#575757"
                                },
                                ticks: {
                                    display: true,
                                    min: 0,
                                    max: 500,
                                    callback: function (value, index, values) {
                                        return value + '$';
                                    },
                                    autoSkip: true,
                                    maxTicksLimit: 10,
                                    fontColor: "#F0F0F0"
                                }
                            }],
                            xAxes: [{
                                stacked: false,
                                ticks: {
                                    beginAtZero: true,
                                    fontColor: "#F0F0F0"
                                },
                                gridLines: {
                                    color: "#575757",
                                    display: false
                                },
                                barPercentage: 1
                            }]
                        },
                        legend: {
                            display: false
                        },
                        elements: {
                            point: {
                                radius: 0
                            }
                        }
                    },
                });
                document.getElementById('sales-legend').innerHTML = SalesChart.generateLegend();
            }

            if ($("#south-america-chart").length) {
                var areaData = {
                    labels: ["Jan", "Feb", "Mar"],
                    datasets: [{
                        data: [60, 70, 70],
                        backgroundColor: [
                            "#4B49AC", "#FFC100", "#248AFD",
                        ],
                        borderColor: "rgba(0,0,0,0)"
                    }]
                };
                var areaOptions = {
                    responsive: true,
                    maintainAspectRatio: true,
                    segmentShowStroke: false,
                    cutoutPercentage: 78,
                    elements: {
                        arc: {
                            borderWidth: 4
                        }
                    },
                    legend: {
                        display: false
                    },
                    tooltips: {
                        enabled: true
                    },
                    legendCallback: function (chart) {
                        var text = [];
                        text.push('<div class="report-chart">');
                        text.push('<div class="d-flex justify-content-between mx-4 mx-xl-5 mt-3"><div class="d-flex align-items-center"><div class="mr-3" style="width:20px; height:20px; border-radius: 50%; background-color: ' + chart.data.datasets[0].backgroundColor[0] + '"></div><p class="mb-0">Offline sales</p></div>');
                        text.push('<p class="mb-0">495343</p>');
                        text.push('</div>');
                        text.push('<div class="d-flex justify-content-between mx-4 mx-xl-5 mt-3"><div class="d-flex align-items-center"><div class="mr-3" style="width:20px; height:20px; border-radius: 50%; background-color: ' + chart.data.datasets[0].backgroundColor[1] + '"></div><p class="mb-0">Online sales</p></div>');
                        text.push('<p class="mb-0">630983</p>');
                        text.push('</div>');
                        text.push('<div class="d-flex justify-content-between mx-4 mx-xl-5 mt-3"><div class="d-flex align-items-center"><div class="mr-3" style="width:20px; height:20px; border-radius: 50%; background-color: ' + chart.data.datasets[0].backgroundColor[2] + '"></div><p class="mb-0">Returns</p></div>');
                        text.push('<p class="mb-0">290831</p>');
                        text.push('</div>');
                        text.push('</div>');
                        return text.join("");
                    },
                }
                var southAmericaChartPlugins = {
                    beforeDraw: function (chart) {
                        var width = chart.chart.width,
                            height = chart.chart.height,
                            ctx = chart.chart.ctx;

                        ctx.restore();
                        var fontSize = 3.125;
                        ctx.font = "600 " + fontSize + "em sans-serif";
                        ctx.textBaseline = "middle";
                        ctx.fillStyle = "#000";

                        var text = "76",
                            textX = Math.round((width - ctx.measureText(text).width) / 2),
                            textY = height / 2;

                        ctx.fillText(text, textX, textY);
                        ctx.save();
                    }
                }
                var southAmericaChartCanvas = $("#south-america-chart").get(0).getContext("2d");
                var southAmericaChart = new Chart(southAmericaChartCanvas, {
                    type: 'doughnut',
                    data: areaData,
                    options: areaOptions,
                    plugins: southAmericaChartPlugins
                });
                document.getElementById('south-america-legend').innerHTML = southAmericaChart.generateLegend();
            }
            if ($("#south-america-chart-dark").length) {
                var areaData = {
                    labels: ["Jan", "Feb", "Mar"],
                    datasets: [{
                        data: [60, 70, 70],
                        backgroundColor: [
                            "#4B49AC", "#FFC100", "#248AFD",
                        ],
                        borderColor: "rgba(0,0,0,0)"
                    }]
                };
                var areaOptions = {
                    responsive: true,
                    maintainAspectRatio: true,
                    segmentShowStroke: false,
                    cutoutPercentage: 78,
                    elements: {
                        arc: {
                            borderWidth: 4
                        }
                    },
                    legend: {
                        display: false
                    },
                    tooltips: {
                        enabled: true
                    },
                    legendCallback: function (chart) {
                        var text = [];
                        text.push('<div class="report-chart">');
                        text.push('<div class="d-flex justify-content-between mx-4 mx-xl-5 mt-3"><div class="d-flex align-items-center"><div class="mr-3" style="width:20px; height:20px; border-radius: 50%; background-color: ' + chart.data.datasets[0].backgroundColor[0] + '"></div><p class="mb-0">Offline sales</p></div>');
                        text.push('<p class="mb-0">495343</p>');
                        text.push('</div>');
                        text.push('<div class="d-flex justify-content-between mx-4 mx-xl-5 mt-3"><div class="d-flex align-items-center"><div class="mr-3" style="width:20px; height:20px; border-radius: 50%; background-color: ' + chart.data.datasets[0].backgroundColor[1] + '"></div><p class="mb-0">Online sales</p></div>');
                        text.push('<p class="mb-0">630983</p>');
                        text.push('</div>');
                        text.push('<div class="d-flex justify-content-between mx-4 mx-xl-5 mt-3"><div class="d-flex align-items-center"><div class="mr-3" style="width:20px; height:20px; border-radius: 50%; background-color: ' + chart.data.datasets[0].backgroundColor[2] + '"></div><p class="mb-0">Returns</p></div>');
                        text.push('<p class="mb-0">290831</p>');
                        text.push('</div>');
                        text.push('</div>');
                        return text.join("");
                    },
                }
                var southAmericaChartPlugins = {
                    beforeDraw: function (chart) {
                        var width = chart.chart.width,
                            height = chart.chart.height,
                            ctx = chart.chart.ctx;

                        ctx.restore();
                        var fontSize = 3.125;
                        ctx.font = "600 " + fontSize + "em sans-serif";
                        ctx.textBaseline = "middle";
                        ctx.fillStyle = "#fff";

                        var text = "76",
                            textX = Math.round((width - ctx.measureText(text).width) / 2),
                            textY = height / 2;

                        ctx.fillText(text, textX, textY);
                        ctx.save();
                    }
                }
                var southAmericaChartCanvas = $("#south-america-chart-dark").get(0).getContext("2d");
                var southAmericaChart = new Chart(southAmericaChartCanvas, {
                    type: 'doughnut',
                    data: areaData,
                    options: areaOptions,
                    plugins: southAmericaChartPlugins
                });
                document.getElementById('south-america-legend').innerHTML = southAmericaChart.generateLegend();
            }

        }


    },

}
</script>
