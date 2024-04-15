document.addEventListener('DOMContentLoaded', function() {
    //DataTable
    var table = $('.dt-sort').DataTable({
        //lengthChange: false,
        //pageLength:   5, // Set the default number of entries to display per page
        //ordering: false, // Disable sorting
        //searching: false, // Disable searching
        //info: false,
        //pagingType: 'simple',
        order: [],
        columnDefs: [
            { targets: 2, visible: false }
        ]
    });


    //Select2
    $('#add_ExamCluster').select2({
        dropdownParent: $('#mdlAddExam'),
        placeholder: 'Select...',
        closeOnSelect: false
    });


    //Filter Table
    $('#filter-btn').click(function() {
        var filterStatus = $('#filter_status').val().toLowerCase();
        var filterCluster = $('#filter_cluster').val().toLowerCase();

        table.columns().search('').draw();

        // If a specific status is selected, apply the filter
        if (filterStatus !== '') {
            table.column(7).search(function(value, index) {
                return filterStatus === '2' ? true : filterStatus === '1' ? value.toLowerCase() === 'active' : filterStatus === '0' ? value.toLowerCase() === 'inactive' : true;
            }).draw();
        }
        // If a specific cluster is selected, apply the filter
        if (filterCluster !== '') {
            table.column(2).search(filterCluster).draw(); // Assuming the cluster column is the 8th column
        }

        // Clear the DataTables default search input
        table.search('').draw();
    });


    //Reset Filters
    $('#reset-btn').click(function() {
        $('#filter_status').val('');
        $('#filter_cluster').val('');
        table.columns().search('').draw();
        // Clear the DataTables default search input
        table.search('').draw();
    });


    //Disable Btn
    document.querySelectorAll('#disable-btn').forEach(function(disableBtn) {
        disableBtn.addEventListener('click', function() {
            // Get the data attributes from the clicked button
            var examId = this.getAttribute('data-disable-id');
            var examName = this.getAttribute('data-disable-name');
            var examStatus = this.getAttribute('data-disable-status');

            // Populate the modal's form fields
            document.getElementById('disable_ExamId').value = examId;
            document.getElementById('disable_ExamName').value = examName;
            document.getElementById('disable_ExamStatus').value = examStatus;

            // Update the modal title with the cluster name
            var modalTitle = document.querySelector('#mdlDisableExam .modal-title span');
            modalTitle.textContent = examName;

            // Update the name in the modal body
            var modalBodyName = document.querySelector('#mdlDisableExam .modal-body span.font-weight-bold');
            modalBodyName.textContent = examName;

            // ERROR
            //$('#mdlDisableCluster').modal('show');
        });
    });


    //Enable Btn 
    document.querySelectorAll('#enable-btn').forEach(function(enableBtn) {
        enableBtn.addEventListener('click', function() {
            // Get the data attributes from the clicked button
            var examId = this.getAttribute('data-enable-id');
            var examName = this.getAttribute('data-enable-name');
            var examStatus = this.getAttribute('data-enable-status');

            // Populate the modal's form fields
            document.getElementById('enable_ExamId').value = examId;
            document.getElementById('enable_ExamName').value = examName;
            document.getElementById('enable_ExamStatus').value = examStatus;

            // Update the modal title with the cluster name
            var modalTitle = document.querySelector('#mdlEnableExam .modal-title span');
            modalTitle.textContent = examName;

            // Update the name in the modal body
            var modalBodyName = document.querySelector('#mdlEnableExam .modal-body span.font-weight-bold');
            modalBodyName.textContent = examName;

            // ERROR
            //$('#mdlEnableCluster').modal('show');
        });
    });

});
