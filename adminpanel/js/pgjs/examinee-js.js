document.addEventListener('DOMContentLoaded', function() {
    var table = $('.dt-sort').DataTable({
        //lengthChange: false,
        //pageLength:   5, // Set the default number of entries to display per page
        //ordering: false, // Disable sorting
        //searching: false, // Disable searching
        //info: false,
        //pagingType: 'simple',
        order: [],
    });

    //Select2
    $('#add_ExmneCluster').select2({
        dropdownParent: $('#mdlAddExaminee'),
        //placeholder: 'Select...',
        theme: 'bootstrap4'
    });

    $('#add_ExmneSfname').select2({
        dropdownParent: $('#mdlAddExaminee'),
        //placeholder: 'Select...',
        theme: 'bootstrap4',
        minimumResultsForSearch: Infinity
    });
    $('#add_ExmneSex').select2({
        dropdownParent: $('#mdlAddExaminee'),
        //placeholder: 'Select...',
        theme: 'bootstrap4',
        minimumResultsForSearch: Infinity
    });

    $('#edit_ExmneCluster').select2({
        dropdownParent: $('#mdlEditExaminee'),
        //placeholder: 'Select...',
        theme: 'bootstrap4'
    });
    $('#edit_ExmneSfname').select2({
        dropdownParent: $('#mdlEditExaminee'),
        //placeholder: 'Select...',
        theme: 'bootstrap4',
        minimumResultsForSearch: Infinity
    });
    $('#edit_ExmneSex').select2({
        dropdownParent: $('#mdlEditExaminee'),
        //placeholder: 'Select...',
        theme: 'bootstrap4',
        minimumResultsForSearch: Infinity
    });

    $('#view_ExmneCluster').select2({
        dropdownParent: $('#mdlViewExaminee'),
        //placeholder: 'Select...',
        theme: 'bootstrap4'
    });
    $('#view_ExmneSfname').select2({
        dropdownParent: $('#mdlViewExaminee'),
        //placeholder: 'Select...',
        theme: 'bootstrap4',
        minimumResultsForSearch: Infinity
    });
    $('#view_ExmneSex').select2({
        dropdownParent: $('#mdlViewExaminee'),
        //placeholder: 'Select...',
        theme: 'bootstrap4',
        minimumResultsForSearch: Infinity
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


    /*document.querySelectorAll('#edit-btn').forEach(function(editBtn) {
        editBtn.addEventListener('click', function() {
            var cluId = this.getAttribute('data-edit-id');
            var cluName = this.getAttribute('data-edit-name');
            var cluDescription = this.getAttribute('data-edit-description');
            var cluStatus = this.getAttribute('data-edit-status');

            document.getElementById('edit_CluId').value = cluId;
            document.getElementById('edit_CluName').value = cluName;
            document.getElementById('edit_CluDesc').value = cluDescription;
            document.getElementById('edit_CluStatus').value = cluStatus;

            var modalTitle = document.querySelector('#mdlEditCluster .modal-title span');
            modalTitle.textContent = cluName;

            // ERROR
            //$('#mdlEditCluster').modal('show');
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

    function assignSelectValue(selectId, value) {
        var selectElement = document.getElementById(selectId);
        var selectedOption = selectElement.querySelector(`option[value="${value}"]`);
    
        // If the option doesn't exist, create it
        if (!selectedOption) {
            selectedOption = document.createElement('option');
            selectedOption.value = value;
            selectedOption.textContent = value; // Or any other text you want to display
            selectElement.appendChild(selectedOption);
        }
    
        // Set the selected option
        selectElement.value = value;
    }

    document.querySelectorAll('#view-btn').forEach(function(viewBtn) {
        viewBtn.addEventListener('click', function() {
            var viewId = this.getAttribute('data-view-id');
            var view_fName = this.getAttribute('data-view-fname');
            var view_mName = this.getAttribute('data-view-mname');
            var view_lName = this.getAttribute('data-view-lname');
            var view_sfName = this.getAttribute('data-view-sfname');
            var view_cluster = this.getAttribute('data-view-cluster');
            var view_sex = this.getAttribute('data-view-sex');
            var view_birth = this.getAttribute('data-view-birth');
            var view_email = this.getAttribute('data-view-email');
            var view_pass = this.getAttribute('data-view-pass');

            document.getElementById('view_ExmneFname').value = view_fName;
            document.getElementById('view_ExmneMname').value = view_mName;
            document.getElementById('view_ExmneLname').value = view_lName;
            document.getElementById('view_ExmneBirth').value = view_birth;
            document.getElementById('view_ExmneEmail').value = view_email;
            document.getElementById('view_ExmnePass').value = view_pass;

            $('#view_ExmneSfname').val(view_sfName).trigger('change');
            $('#view_ExmneCluster').val(view_cluster).trigger('change');
            $('#view_ExmneSex').val(view_sex).trigger('change');

            var modalTitle = document.querySelector('#mdlViewExaminee .modal-title span');
            modalTitle.textContent = view_fName + ' ' + view_lName;
        });
    });

    $('#togglePassword').on('mousedown', function() {
        $('#view_ExmnePass').attr('type', 'text');
        //$('#revealIcon').removeClass('fa-eye').addClass('fa-eye-slash');
    });

    $('#togglePassword').on('mouseup', function() {
        $('#view_ExmnePass').attr('type', 'password');
        //$('#revealIcon').removeClass('fa-eye-slash').addClass('fa-eye');
    });

    document.querySelectorAll('#edit-btn').forEach(function(editBtn) {
        editBtn.addEventListener('click', function() {
            var editId = this.getAttribute('data-edit-id');
            var edit_fName = this.getAttribute('data-edit-fname');
            var edit_mName = this.getAttribute('data-edit-mname');
            var edit_lName = this.getAttribute('data-edit-lname');
            var edit_sfName = this.getAttribute('data-edit-sfname');
            var edit_cluster = this.getAttribute('data-edit-cluster');
            var edit_sex = this.getAttribute('data-edit-sex');
            var edit_birth = this.getAttribute('data-edit-birth');
            var edit_email = this.getAttribute('data-edit-email');
            var edit_pass = this.getAttribute('data-edit-pass');

            document.getElementById('edit_ExmneFname').value = edit_fName;
            document.getElementById('edit_ExmneMname').value = edit_mName;
            document.getElementById('edit_ExmneLname').value = edit_lName;
            document.getElementById('edit_ExmneSfname').value = edit_sfName;
            document.getElementById('edit_ExmneCluster').value = edit_cluster;
            document.getElementById('edit_ExmneSex').value = edit_sex;
            document.getElementById('edit_ExmneBirth').value = edit_birth;
            document.getElementById('edit_ExmneEmail').value = edit_email;
            document.getElementById('edit_ExmnePass').value = edit_pass;

            $('#edit_ExmneSfname').val(edit_sfName).trigger('change');
            $('#edit_ExmneCluster').val(edit_cluster).trigger('change');
            $('#edit_ExmneSex').val(edit_sex).trigger('change');

            var modalTitle = document.querySelector('#mdlEditExaminee .modal-title span');
            modalTitle.textContent = edit_fName + ' ' + edit_lName;
        });
    });

});
