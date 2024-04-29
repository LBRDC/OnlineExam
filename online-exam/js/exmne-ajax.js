//FUNCTIONS
//Submit Answer
function submitAnswer() {
    $.post("query/submitAnswerExe.php", $('#submitAnswerFrm').serialize(), function (data) {
        if (data.res == "finished") {
            Swal.fire({
                icon: 'success',
                title: 'Finished',
                text: 'Congratulations! You have finished all the exams.',
            }).then(function() {
                window.location.href = 'home.php';
            });
        } else if (data.res == "notFinished") {
            Swal.fire({
                icon: 'info',
                title: 'Loading...',
                text: 'Proceeding to next exam...',
                timer: 5000,
                timerProgressBar: true,
            }).then(function() {
                window.location.href = 'exam.php?id=' + data.examId;
            });
        } else if (data.res == "failed") {
            Swal.fire({
                icon: 'error',
                title: 'Failed',
                text: 'An error occured while submitting your answers. Please try again.',
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Failed',
                text: 'System error occurred.',
            });
        }
    }).fail(function(jqXHR, textStatus, errorThrown) {
        alert('A script error occured. Please try again.');
        console.error(textStatus, errorThrown);
        console.log(jqXHR.responseText);
    });
}


// exam SUBMIT
$(document).on("submit","#submitAnswerFrm" , function(event) {
    event.preventDefault();
    /*
        If time out = Show time out Alert
        If submitted = Show Processing

        Fetch Inputs
        Ajax Submit_AnswerExe

        If res finished = h.ref home.php
        If res nextexam = h.ref exam.php?id=
    */

    var examAction = $('#examAction').val();
    examSubmitted = true;
    //console.log("Exam Submitted: " + examSubmitted); //DEBUG

    if (examAction == 'time out') {
        Swal.fire({
            icon: 'warning',
            title: 'Exam Over',
            text: 'You ran out of time...',
            showCancelButton: false,
            allowOutsideClick: false,
            showConfirmButton: false,
            timer: 10000,
            timerProgressBar: true,
        }).then(function() {
            submitAnswer();
        });
    } else if (examAction == 'ontime') {
        Swal.fire({
            icon: 'warning',
            title: 'Submit Exam',
            text: 'Are you sure you want to submit?',
            showCancelButton: true,
            allowOutsideClick: false,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then(function(result) {
            if (result.isConfirmed) {
                submitAnswer();
            }
        });
    } else {
        alert('A system error occured. Please try again.');
    }
});