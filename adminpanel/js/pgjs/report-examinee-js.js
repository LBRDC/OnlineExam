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
    });


    $('#filter-btn').click(function() {
        var filterDateFrom = $('#filter_datefrom').val();
        var filterDateTo = $('#filter_dateto').val();
    
        // Clear any existing search
        table.columns().search('').draw();
    
        // Apply date range filter if at least one date is provided
        if (filterDateFrom || filterDateTo) {
            // Convert date strings to Date objects for comparison
            var fromDate = filterDateFrom ? new Date(filterDateFrom) : null;
            var toDate = filterDateTo ? new Date(filterDateTo) : null;
    
            // Apply the date range filter
            table.column(4).search(function(value, index) {
                var dateValue = new Date(value);
                // Check if the date is within the range or matches the single provided date
                var isWithinRange = true;
                if (fromDate) {
                    isWithinRange = dateValue >= fromDate;
                }
                if (toDate && isWithinRange) {
                    isWithinRange = dateValue <= toDate;
                }
                return isWithinRange;
            }).draw();
        }
    });


    $('#reset-btn').click(function() {
        $('#filter_datefrom').val('');
        $('#filter_dateto').val('');
        table.columns().search('').draw();
        table.search('').draw();
    });
});
