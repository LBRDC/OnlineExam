document.addEventListener('DOMContentLoaded', function() {
    $('#exam_tabs .nav-link').on('click', function() {
        var tabId = $(this).attr('id'); // Get the ID of the clicked tab
        var tabName = $(this).text().trim().toLowerCase().replace(/\s+/g, '-'); // Generate a URL-friendly name
        var currentUrl = window.location.href;
        var baseUrl = currentUrl.split('?')[0]; // Get the base URL
        var newUrl = baseUrl + '?page=manage-exam-edit&id=8&tab=' + tabName; // Construct the new URL

        // Update the URL without reloading the page
        history.pushState({}, '', newUrl);
    });

    
    /* ########## EXAM INFO ########## */
    $('#edit_ExamCluster').select2({
        placeholder: 'Select...',
        closeOnSelect: false
    });

    function fetchCluList() {
        var urlParams = new URLSearchParams(window.location.search);
        var examId = urlParams.get('id');
        $.ajax({
            url: "query/edit_ClusterLoad.php",
            type: "GET",
            data: { id: examId },
            success: function (data) {
                var clusterIds = JSON.parse(data);
                $('#edit_ExamCluster').val(clusterIds).trigger('change');
            }
        });
    }
    
    fetchCluList();


    /* ########## EXAM QUESTION ########## */
    document.querySelectorAll('#add-btn').forEach(function(editBtn) {
        editBtn.addEventListener('click', function() {
            var examId = this.getAttribute('data-add-id');

            document.getElementById('add_QstnExamId').value = examId;

            // ERROR
            //$('#mdlEditCluster').modal('show');
        });
    });

    document.getElementById('add_ExamImg').addEventListener('change', function() {
        var file = this.files[0];
        var fileSize = file.size / (1024 * 1024) * 4; // in 5MB
        var allowedExtensions = /(\.png|\.jpg|\.jpeg|\.webp)$/i;
    
        if (!allowedExtensions.exec(file.name)) {
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "Wrong file type. Upload png, jpg, webp only!",
            }).then(function() {
                document.getElementById('add_ExamImg').value = ''; // Clear the input
            });
        } 
        
        if (fileSize > 2) {
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "File size exceeded. Max file size is 4MB only!",
            }).then(function() {
                document.getElementById('add_ExamImg').value = ''; // Clear the input
            });
        }
    });

    
});
