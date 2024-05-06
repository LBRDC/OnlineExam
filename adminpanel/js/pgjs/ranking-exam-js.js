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
        var filterRanking = $('#filter_ranking').val().toLowerCase();
        var filterDateFrom = $('#filter_datefrom').val();
        var filterDateTo = $('#filter_dateto').val();
    
        // Clear any existing search
        table.columns().search('').draw();
    
        // Apply ranking filter if ranking is not empty
        if (filterRanking!== '') {
            table.column(0).search(function(value, index) {
                return value.toLowerCase() === filterRanking;
            }).draw();
        }
    
        // Apply date range filter if at least one date is provided
        if (filterDateFrom || filterDateTo) {
            // Convert date strings to Date objects for comparison
            var fromDate = filterDateFrom ? new Date(filterDateFrom) : null;
            var toDate = filterDateTo ? new Date(filterDateTo) : null;
    
            // Apply the date range filter
            table.column(6).search(function(value, index) {
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
        $('#filter_ranking').val('');
        $('#filter_datefrom').val('');
        $('#filter_dateto').val('');
        table.columns().search('').draw();
        table.search('').draw();
    });
    
    document.querySelector('#save-btn').addEventListener('click', function() {
       var examId = this.getAttribute('data-save-id');

       document.getElementById('save_examId').value = examId;
    });
    
    /*document.querySelectorAll('#save-btn').forEach(function(saveBtn) {
        saveBtn.addEventListener('click', function() {
            var examId = this.getAttribute('data-save-id');

            document.getElementById('save_ExamId').value = examId;
        });
    });*/


    /*document.querySelectorAll('#disable-btn').forEach(function(disableBtn) {
        disableBtn.addEventListener('click', function() {
            var cluId = this.getAttribute('data-disable-id');
            var cluName = this.getAttribute('data-disable-name');
            var cluStatus = this.getAttribute('data-disable-status');

            document.getElementById('disable_CluId').value = cluId;
            document.getElementById('disable_CluName').value = cluName;
            document.getElementById('disable_CluStatus').value = cluStatus;

            var modalTitle = document.querySelector('#mdlDisableCluster .modal-title span');
            modalTitle.textContent = cluName;

            var modalBodyName = document.querySelector('#mdlDisableCluster .modal-body span.font-weight-bold');
            modalBodyName.textContent = cluName;

            // ERROR
            //$('#mdlDisableCluster').modal('show');
        });
    });*/


    /*document.querySelectorAll('#enable-btn').forEach(function(enableBtn) {
        enableBtn.addEventListener('click', function() {
            var cluId = this.getAttribute('data-enable-id');
            var cluName = this.getAttribute('data-enable-name');
            var cluStatus = this.getAttribute('data-enable-status');

            document.getElementById('enable_CluId').value = cluId;
            document.getElementById('enable_CluName').value = cluName;
            document.getElementById('enable_CluStatus').value = cluStatus;

            var modalTitle = document.querySelector('#mdlEnableCluster .modal-title span');
            modalTitle.textContent = cluName;

            var modalBodyName = document.querySelector('#mdlEnableCluster .modal-body span.font-weight-bold');
            modalBodyName.textContent = cluName;

            // ERROR
            //$('#mdlEnableCluster').modal('show');
        });
    });*/
});
