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


    /*$('#filter-btn').click(function() {
        var filterStatus = $('#filter_status').val().toLowerCase();

        table.columns().search('').draw();

        if (filterStatus !== '') {
            table.column(2).search(function(value, index) {
                return filterStatus === '2' ? true : filterStatus === '1' ? value.toLowerCase() === 'active' : filterStatus === '0' ? value.toLowerCase() === 'inactive' : true;
            }).draw();
        }

        table.search('').draw();
    });*/


    /*$('#reset-btn').click(function() {
        $('#filter_status').val('');
        table.columns().search('').draw();
        table.search('').draw();
    });*/
});
