//MYJS
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('feedback-btn').addEventListener('click', function() {
        var exmne_Id = this.getAttribute('data-feedback-id');

        document.getElementById('add_ExmneId').value = exmne_Id;
    })
})