document.addEventListener('DOMContentLoaded', function() {
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

    $('#add_ExamCluster').select2({
        dropdownParent: $('#mdlAddExam'),
        placeholder: 'Select...',
        closeOnSelect: false
    });

    // Filter HERE
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

    $('#reset-btn').click(function() {
        $('#filter_status').val('');
        $('#filter_cluster').val('');
        table.columns().search('').draw();
        // Clear the DataTables default search input
        table.search('').draw();
    });

    //Edit Btn HERE
    /*document.querySelectorAll('#edit-btn').forEach(function(editBtn) {
        editBtn.addEventListener('click', function() {
            // Get the data attributes from the clicked button
            var cluId = this.getAttribute('data-edit-id');
            var cluName = this.getAttribute('data-edit-name');
            var cluDescription = this.getAttribute('data-edit-description');
            var cluStatus = this.getAttribute('data-edit-status');

            // Populate the modal's form fields
            document.getElementById('edit_CluId').value = cluId;
            document.getElementById('edit_CluName').value = cluName;
            document.getElementById('edit_CluDesc').value = cluDescription;
            document.getElementById('edit_CluStatus').value = cluStatus;

            // Update the modal title with the cluster name
            var modalTitle = document.querySelector('#mdlEditCluster .modal-title span');
            modalTitle.textContent = cluName;

            // ERROR
            //$('#mdlEditCluster').modal('show');
        });
    });*/

    //Disable Btn HERE
    /*document.querySelectorAll('#disable-btn').forEach(function(disableBtn) {
        disableBtn.addEventListener('click', function() {
            // Get the data attributes from the clicked button
            var cluId = this.getAttribute('data-disable-id');
            var cluName = this.getAttribute('data-disable-name');
            var cluStatus = this.getAttribute('data-disable-status');

            // Populate the modal's form fields
            document.getElementById('disable_CluId').value = cluId;
            document.getElementById('disable_CluName').value = cluName;
            document.getElementById('disable_CluStatus').value = cluStatus;

            // Update the modal title with the cluster name
            var modalTitle = document.querySelector('#mdlDisableCluster .modal-title span');
            modalTitle.textContent = cluName;

            // Update the name in the modal body
            var modalBodyName = document.querySelector('#mdlDisableCluster .modal-body span.font-weight-bold');
            modalBodyName.textContent = cluName;

            // ERROR
            //$('#mdlDisableCluster').modal('show');
        });
    });*/

    //Enable Btn HERE
    /*document.querySelectorAll('#enable-btn').forEach(function(enableBtn) {
        enableBtn.addEventListener('click', function() {
            // Get the data attributes from the clicked button
            var cluId = this.getAttribute('data-enable-id');
            var cluName = this.getAttribute('data-enable-name');
            var cluStatus = this.getAttribute('data-enable-status');

            // Populate the modal's form fields
            document.getElementById('enable_CluId').value = cluId;
            document.getElementById('enable_CluName').value = cluName;
            document.getElementById('enable_CluStatus').value = cluStatus;

            // Update the modal title with the cluster name
            var modalTitle = document.querySelector('#mdlEnableCluster .modal-title span');
            modalTitle.textContent = cluName;

            // Update the name in the modal body
            var modalBodyName = document.querySelector('#mdlEnableCluster .modal-body span.font-weight-bold');
            modalBodyName.textContent = cluName;

            // ERROR
            //$('#mdlEnableCluster').modal('show');
        });
    });*/

});
