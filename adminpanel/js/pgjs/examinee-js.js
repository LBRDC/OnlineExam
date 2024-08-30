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
    $('#edit_ExmneStatus').select2({
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
    $('#view_ExmneStatus').select2({
        dropdownParent: $('#mdlViewExaminee'),
        //placeholder: 'Select...',
        theme: 'bootstrap4',
        minimumResultsForSearch: Infinity
    });


    $('#filter-btn').click(function() {
        var filterStatus = $('#filter_status').val().toLowerCase();
        var filterCluster = $('#filter_cluster').val().toLowerCase();

        table.columns().search('').draw();

        // If a specific status is selected, apply the filter
        if (filterStatus !== '') {
            table.column(4).search(function(value, index) {
                return filterStatus === '2' ? value.toLowerCase() === 'finished' : filterStatus === '1' ? value.toLowerCase() === 'active' : filterStatus === '0' ? value.toLowerCase() === 'inactive' : true;
            }).draw();
        }
        // If a specific cluster is selected, apply the filter
        if (filterCluster !== '') {
            table.column(1).search(filterCluster).draw(); // Assuming the cluster column is the 8th column
        }

        // Clear the DataTables default search input
        table.search('').draw();
    });


    $('#reset-btn').click(function() {
        $('#filter_status').val('');
        $('#filter_cluster').val('');
        table.columns().search('').draw();
        table.search('').draw();
    });


    document.querySelectorAll('#view-btn').forEach(function(viewBtn) {
        viewBtn.addEventListener('click', function() {
            var view_fName = this.getAttribute('data-view-fname');
            var view_mName = this.getAttribute('data-view-mname');
            var view_lName = this.getAttribute('data-view-lname');
            var view_sfName = this.getAttribute('data-view-sfname');
            var view_cluster = this.getAttribute('data-view-cluster');
            var view_sex = this.getAttribute('data-view-sex');
            var view_birth = this.getAttribute('data-view-birth');
            var view_cam = this.getAttribute('data-view-cam');
            var view_status = this.getAttribute('data-view-status');
            var view_email = this.getAttribute('data-view-email');
            var view_pass = this.getAttribute('data-view-pass');

            document.getElementById('view_ExmneFname').value = view_fName;
            document.getElementById('view_ExmneMname').value = view_mName;
            document.getElementById('view_ExmneLname').value = view_lName;
            document.getElementById('view_ExmneBirth').value = view_birth;
            document.getElementById('view_DisableCam').checked = view_cam === 'yes';
            document.getElementById('view_ExmneEmail').value = view_email;
            document.getElementById('view_ExmnePass').value = view_pass;

            $('#view_ExmneSfname').val(view_sfName).trigger('change');
            $('#view_ExmneCluster').val(view_cluster).trigger('change');
            $('#view_ExmneSex').val(view_sex).trigger('change');
            $('#view_ExmneStatus').val(view_status).trigger('change');

            var modalTitle = document.querySelector('#mdlViewExaminee .modal-title span');
            modalTitle.textContent = view_fName + ' ' + view_lName;
        });
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
            var edit_cam = this.getAttribute('data-edit-cam');
            var edit_status = this.getAttribute('data-edit-status');
            var edit_email = this.getAttribute('data-edit-email');
            var edit_pass = this.getAttribute('data-edit-pass');

            document.getElementById('edit_ExmneId').value = editId;
            document.getElementById('edit_ExmneFname').value = edit_fName;
            document.getElementById('edit_ExmneMname').value = edit_mName;
            document.getElementById('edit_ExmneLname').value = edit_lName;
            document.getElementById('edit_ExmneSfname').value = edit_sfName;
            document.getElementById('edit_ExmneCluster').value = edit_cluster;
            document.getElementById('edit_ExmneSex').value = edit_sex;
            document.getElementById('edit_ExmneBirth').value = edit_birth;
            document.getElementById('edit_DisableCam').checked = edit_cam === 'yes';
            document.getElementById('edit_ExmneEmail').value = edit_email;
            document.getElementById('edit_ExmnePass').value = edit_pass;

            $('#edit_ExmneSfname').val(edit_sfName).trigger('change');
            $('#edit_ExmneCluster').val(edit_cluster).trigger('change');
            $('#edit_ExmneSex').val(edit_sex).trigger('change');
            $('#edit_ExmneStatus').val(edit_status).trigger('change');

            var modalTitle = document.querySelector('#mdlEditExaminee .modal-title span');
            modalTitle.textContent = edit_fName + ' ' + edit_lName;
        });
    });

    document.querySelectorAll('#disable-btn').forEach(function(disableBtn) {
        disableBtn.addEventListener('click', function() {
            var dis_ExmneId = this.getAttribute('data-disable-id');
            var dis_ExmneFname = this.getAttribute('data-disable-fname');
            var dis_ExmneLname = this.getAttribute('data-disable-lname');
            var dis_ExmneStatus = this.getAttribute('data-disable-status');

            document.getElementById('disable_ExmneId').value = dis_ExmneId;
            document.getElementById('disable_ExmneFname').value = dis_ExmneFname;
            document.getElementById('disable_ExmneLname').value = dis_ExmneLname;
            document.getElementById('disable_ExmneStatus').value = dis_ExmneStatus;


            var modalTitle = document.querySelector('#mdlDisableExaminee .modal-title span');
            modalTitle.textContent = dis_ExmneFname + ' ' + dis_ExmneLname;

            var modalBodyName = document.querySelector('#mdlDisableExaminee .modal-body span.font-weight-bold');
            modalBodyName.textContent = dis_ExmneFname + ' ' + dis_ExmneLname;
        });
    });

    document.querySelectorAll('#enable-btn').forEach(function(enableBtn) {
        enableBtn.addEventListener('click', function() {
            var en_ExmneId = this.getAttribute('data-enable-id');
            var en_ExmneFname = this.getAttribute('data-enable-fname');
            var en_ExmneLname = this.getAttribute('data-enable-lname');
            var en_ExmneStatus = this.getAttribute('data-enable-status');

            document.getElementById('enable_ExmneId').value = en_ExmneId;
            document.getElementById('enable_ExmneFname').value = en_ExmneFname;
            document.getElementById('enable_ExmneLname').value = en_ExmneLname;
            document.getElementById('enable_ExmneStatus').value = en_ExmneStatus;


            var modalTitle = document.querySelector('#mdlEnableExaminee .modal-title span');
            modalTitle.textContent = en_ExmneFname + ' ' + en_ExmneLname;

            var modalBodyName = document.querySelector('#mdlEnableExaminee .modal-body span.font-weight-bold');
            modalBodyName.textContent = en_ExmneFname + ' ' + en_ExmneLname;
        });
    });

    $('#toggleViewPass').on('click', function() {
        var currentType = $('#view_ExmnePass').attr('type');
        if (currentType === 'password') {
            $('#view_ExmnePass').attr('type', 'text');
            $('#viewRevealIcon').removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            $('#view_ExmnePass').attr('type', 'password');
            $('#viewRevealIcon').removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });

    $('#toggleAddPass').on('click', function() {
        var currentType = $('#add_ExmnePass').attr('type');
        if (currentType === 'password') {
            $('#add_ExmnePass').attr('type', 'text');
            $('#addRevealIcon').removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            $('#add_ExmnePass').attr('type', 'password');
            $('#addRevealIcon').removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });

    $('#toggleEditPass').on('click', function() {
        var currentType = $('#edit_ExmnePass').attr('type');
        if (currentType === 'password') {
            $('#edit_ExmnePass').attr('type', 'text');
            $('#editRevealIcon').removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            $('#edit_ExmnePass').attr('type', 'password');
            $('#editRevealIcon').removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });
});
