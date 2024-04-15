document.addEventListener('DOMContentLoaded', function() {
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

    $('#exam_tabs .nav-link').on('click', function() {
        var tabId = $(this).attr('id'); // Get the ID of the clicked tab
        var tabName = $(this).text().trim().toLowerCase().replace(/\s+/g, '-'); // Generate a URL-friendly name
        var currentUrl = window.location.href;
        var baseUrl = currentUrl.split('?')[0]; // Get the base URL
        var newUrl = baseUrl + '?page=manage-exam-edit&id=8&tab=' + tabName; // Construct the new URL

        // Update the URL without reloading the page
        history.pushState({}, '', newUrl);
    });
});
