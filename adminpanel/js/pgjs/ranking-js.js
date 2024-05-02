document.addEventListener('DOMContentLoaded', function() {
    var table = $('.dt-sort').DataTable({
        //lengthChange: false,
        //pageLength:   5, // Set the default number of entries to display per page
        //ordering: false, // Disable sorting
        //searching: false, // Disable searching
        //info: false,
        //pagingType: 'simple',
        order: [],
        responsive: true,
        columnDefs: [
            { targets: 2, visible: false }
        ],
    });


    $('#filter-btn').click(function() {
        var filterCluster = $('#filter_cluster').val().toLowerCase();

        table.columns().search('').draw();

        // If a specific cluster is selected, apply the filter
        if (filterCluster !== '') {
            table.column(2).search(filterCluster).draw(); // Assuming the cluster column is the 8th column
        }

        table.search('').draw();
    });


    $('#reset-btn').click(function() {
        $('#filter_cluster').val('');
        table.columns().search('').draw();
        table.search('').draw();
    });
});
