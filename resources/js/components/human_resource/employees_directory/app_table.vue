<template>
    <table id="example" class="table table-striped table-borderless display expandable-table dataTable no-footer" role="grid">
        <thead>
            <tr role="row">
                <th class="select-checkbox sorting_disabled" rowspan="1" colspan="1" aria-label="Quote#"
                    style="width: 61px;"> </th>
                <th class="sorting_desc" tabindex="0" aria-controls="example" rowspan="1" colspan="1"
                    aria-label="Product: activate to sort column ascending" aria-sort="descending" style="width: 20px !important;">
                    Employee Code</th>
                <th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1"
                    aria-label="Business type: activate to sort column ascending" style="width: 113px;">Name</th>
                <th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1"
                    aria-label="Policy holder: activate to sort column ascending" style="width: 107px;">Office</th>
                <th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1"
                    aria-label="Premium: activate to sort column ascending" style="width: 126px;">Position</th>
                <th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1"
                    aria-label="Status: activate to sort column ascending" style="width: 126px;">Office Email Add</th>
                <th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1"
                    aria-label="Updated at: activate to sort column ascending" style="width: 93px;">Percentage</th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td></td>
                <td>FF-5107</td>
                <td>ROMULO, JOHN MENARD Q</td>
                <td>ORD</td>
                <td>Data Analyst</td>
                <td>jmromulo25@gmail.com</td>
                <td>0%</td>
            </tr>
            <tr>
                <td></td>
                <td>F-4940</td>
                <td>SACLUTI, MARK KIM A</td>
                <td>ORD</td>
                <td>Network Administrator</td>
                <td>markkimsacluti@yahoo.com</td>
                <td>81.82%</td>
            </tr>
            <tr>
                <td></td>
                <td>F-4941</td>
                <td>BANALAN, LOUIE JAKE P</td>
                <td>ORD</td>
                <td>Database Administrator</td>
                <td>ljbanalan@yahoo.com</td>
                <td>100.00%</td>
            </tr>
        </tbody>
    </table>
</template>
<script>
export default {
    name: 'app_table',
    components: {

    }
}
</script>