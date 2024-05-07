// exam SUBMIT
/*$(document).on("submit","#submitAnswerFrm" , function(event) {
    event.preventDefault();

    var examAction = $('#examAction').val();
    examSubmitted = true;
    //console.log("Exam Submitted: " + examSubmitted); //DEBUG

    if (examAction == 'timeout') {
        Swal.fire({
            icon: 'warning',
            title: 'Exam Over',
            text: 'You ran out of time...',
            allowOutsideClick: false,
            showConfirmButton: false,
            timer: 10000,
            timerProgressBar: true,
        }).then(function() {
            $.post("query/submit_AnswerExe.php", $('#submitAnswerFrm').serialize(), function (data) {
                // Manually parse the JSON if necessary
                var response = JSON.parse(data);
                if (response.res == "finished") {
                    Swal.fire({
                        icon: 'success',
                        title: 'Finished',
                        text: 'Congratulations! You have finished all the exams.',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                    }).then(function() {
                        window.location.href = 'home.php';
                    });
                } else if (response.res == "notFinished") {
                    Swal.fire({
                        icon: 'info',
                        title: 'Loading...',
                        text: 'Proceeding to next exam...',
                        showConfirmButton: false,
                        timer: 5000,
                        timerProgressBar: true,
                    }).then(function() {
                        window.location.href = 'exam.php?id=' + response.examId;
                    });
                } else if (response.res == "failed") {
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
            if (result.value) {
                $.post("query/submit_AnswerExe.php", $('#submitAnswerFrm').serialize(), function (data) {
                    // Manually parse the JSON if necessary
                    var response = JSON.parse(data);
                    if (response.res == "finished") {
                        Swal.fire({
                            icon: 'success',
                            title: 'Finished',
                            text: 'Congratulations! You have finished all the exams.',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                        }).then(function() {
                            window.location.href = 'home.php';
                        });
                    } else if (response.res == "notFinished") {
                        Swal.fire({
                            icon: 'info',
                            title: 'Loading...',
                            text: 'Proceeding to next exam...',
                            showConfirmButton: false,
                            timer: 5000,
                            timerProgressBar: true,
                        }).then(function() {
                            window.location.href = 'exam.php?id=' + response.examId;
                        });
                    } else if (response.res == "failed") {
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
        });
    } else if (examAction == 'cheat') {
        Swal.fire({
            icon: 'warning',
            title: 'Exam Over',
            text: 'System detected cheating...',
            allowOutsideClick: false,
            showConfirmButton: false,
            timer: 10000,
            timerProgressBar: true,
        }).then(function() {
            $.post("query/submit_AnswerExe.php", $('#submitAnswerFrm').serialize(), function (data) {
                // Manually parse the JSON if necessary
                var response = JSON.parse(data);
                if (response.res == "finished") {
                    Swal.fire({
                        icon: 'success',
                        title: 'Finished',
                        text: 'Congratulations! You have finished all the exams.',
                        showConfirmButton: false,
                        timer: 5000,
                        timerProgressBar: true,
                    }).then(function() {
                        window.location.href = 'home.php';
                    });
                } else if (response.res == "notFinished") {
                    Swal.fire({
                        icon: 'info',
                        title: 'Loading...',
                        text: 'Proceeding to next exam...',
                        showConfirmButton: false,
                        timer: 5000,
                        timerProgressBar: true,
                    }).then(function() {
                        window.location.href = 'exam.php?id=' + response.examId;
                    });
                } else if (response.res == "failed") {
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
        });
    } else {
        alert('A system error occured. Please try again.');
    }

    return false;
});*/


//Feedback Submit
$(document).on("submit","#feedbackFrm" , function(event) {
    event.preventDefault();

    var formData = {
        'add_ExmneId': $('#add_ExmneId').val(),
        'add_Feedback': $('#add_Feedback').val(),
        'add_Anonymous': $('#add_Anonymous').val()
    };

    console.log(formData);
    
    var isValid;
    if (formData['add_ExmneId'] === '') {
        isValid = false;
    } else {
        isValid = true;
    }
    
    if (!isValid) {
        Swal.fire({
            icon: "warning",
            title: "Incomplete",
            text: "Please fill in the required fields.",
        });
        return;
    }

    //console.log("INPUT VALIDATED " + isValid);
    //console.log(formData);

    $.ajax({
        url: 'query/feedback.php',
        type: 'POST',
        dataType : "json",
        data: formData,
        success: function(response) {
            if (response.res == "success") {
                Swal.fire({
                    icon: "success",
                    title: "Success",
                    text: " Feedback submitted.",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                }).then(function() {
                    location.reload();
                });
            } else if (response.res == "failed") {
                Swal.fire({
                    icon: "error",
                    title: "Failed",
                    text: "An error occurred while submitting Feedback. Please try again.",
                });
            } else if (response.res == "incomplete") {
                Swal.fire({
                    icon: "warning",
                    title: "Incomplete",
                    text: "Please fill in all fields.",
                });
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "System error occurred.",
                });
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert('A script error occured. Please try again.');
            console.error(textStatus, errorThrown);
            console.log(jqXHR.responseText);
            location.reload();
        }
    });
});