document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('feedback-btn').addEventListener('click', function() {
        var exmne_Id = this.getAttribute('data-feedback-id');
        var feedback_Txt = this.getAttribute('data-feedback-txt');
        var feedback_Anon = this.getAttribute('data-feedback-anon');

        document.getElementById('add_ExmneId').value = exmne_Id;
        document.getElementById('add_Feedback').innerHTML = feedback_Txt;
        if (feedback_Anon === "Anonymous") {
            document.getElementById('add_Anonymous').setAttribute('checked', 'checked');
        } else {
            document.getElementById('add_Anonymous').removeAttribute('checked');
        }
    });
});