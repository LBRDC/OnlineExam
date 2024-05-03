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


    document.querySelectorAll('#edit-btn').forEach(function(editBtn) {
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
    });


    document.querySelectorAll('#disable-btn').forEach(function(disableBtn) {
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
    });


    document.querySelectorAll('#enable-btn').forEach(function(enableBtn) {
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
    });
});
