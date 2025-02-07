<template>
    <table id="app_table" style="width: 100%;" class="table table-striped table-borderless display expandable-table dataTable no-footer" role="grid">
        <thead>
            <tr role="row">
                <th class="select-checkbox sorting_disabled" rowspan="1" colspan="1" aria-label="Quote#"
                    style="width: 61px;">
                    Stock #</th>
                <th class="sorting_desc" tabindex="0" aria-controls="example" rowspan="1" colspan="1"
                    aria-label="Product: activate to sort column ascending" aria-sort="descending" style="width: 20px !important;">
                    Category</th>
                <th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1"
                    aria-label="Business type: activate to sort column ascending" style="width: 113px;">Item</th>
                <th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1"
                    aria-label="Policy holder: activate to sort column ascending" style="width: 107px;">Office</th>
                <th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1"
                    aria-label="Premium: activate to sort column ascending" style="width: 126px;">Mode of Procurement</th>
                <th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1"
                    aria-label="Status: activate to sort column ascending" style="width: 126px;">Source of Funds</th>
                <th class="sorting" tabindex="0" aria-controls="example" rowspan="1" colspan="1"
                    aria-label="Updated at: activate to sort column ascending" style="width: 93px;">App Price</th>
                <th class="details-control sorting_disabled" rowspan="1" colspan="1" aria-label="" style="width: 100px;">App
                    Year</th>
                <th class="details-control sorting_disabled" rowspan="1" colspan="1" aria-label="" style="width: 4px;">
                    Actions</th>
            </tr>
        </thead>

        <tbody>

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
