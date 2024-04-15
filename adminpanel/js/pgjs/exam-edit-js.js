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
});
