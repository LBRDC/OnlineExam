//Feedback Submit
$(document).on("submit","#feedbackFrm" , function(event) {
    event.preventDefault();

    var formData = {
        'add_ExmneId': $('#add_ExmneId').val(),
        'add_Feedback': $('#add_Feedback').val(),
        'add_Anonymous': $('#add_Anonymous').is(':checked') ? 'yes' : '',
    };

    //console.log(formData); //DEBUG
    
    var isValid;
    if (formData['add_ExmneId'] === '' || formData['add_Feedback'] === '') {
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
                    text: "Feedback submitted.",
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