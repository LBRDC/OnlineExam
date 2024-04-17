/* ########## CLUSTER ########## */
// manage-cluster ADD 
$(document).on("submit","#addClusterFrm" , function(event) {
    event.preventDefault();

    var formData = {
        'add_CluName': $('#add_CluName').val(),
        'add_CluDesc': $('#add_CluDesc').val()
    };

    console.log(formData);
    
    var isValid;
    if (formData['add_CluName'] === '') {
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

    console.log("INPUT VALIDATED " + isValid);
    console.log(formData);

    $.ajax({
        url: 'query/add_ClusterExe.php',
        type: 'POST',
        dataType : "json",
        data: formData,
        success: function(response) {
            if (response.res == "success") {
                Swal.fire({
                    icon: "success",
                    title: "Success",
                    text: response.msg + " added.",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                }).then(function() {
                    window.location.href = 'home.php?page=manage-cluster';
                });
            } else if (response.res == "exists") {
                Swal.fire({
                    icon: "error",
                    title: "Failed",
                    text: response.msg + "already exists.",
                });
            } else if (response.res == "failed") {
                Swal.fire({
                    icon: "error",
                    title: "Failed",
                    text: "An error occurred while adding Cluster. Please try again.",
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
        }
    });
});


// manage-cluster EDIT 
$(document).on("submit","#editClusterFrm" , function(event) {
    event.preventDefault();

    var formData = {
        'edit_CluId': $('#edit_CluId').val(),
        'edit_CluName': $('#edit_CluName').val(),
        'edit_CluDesc': $('#edit_CluDesc').val(),
        'edit_CluStatus': $('#edit_CluStatus').val()
    };
    
    var isValid;
    if (formData['edit_CluId'] === '' || formData['add_CluName'] === '' || formData['edit_CluStatus'] === '') {
        isValid = false;
    } else {
        isValid = true;
    }
    
    if (!isValid) {
        Swal.fire({
            icon: "warning",
            title: "Incomplete",
            text: "Please fill in required field.",
        });
        return;
    }

    // For MANY Input
    /*var isValid;
    $.each(formData, function(key, value) {
        if (value === '') {
            isValid = false;
            return false;
        } else {
            isValid = true;
        }
    });

    if (!isValid) {
        Swal.fire({
            icon: "warning",
            title: "Incomplete",
            text: "Please fill in all fields.",
        });
        return;
    }*/

    //console.log("INPUT VALIDATED");
    //console.log(formData);

    $.ajax({
        url: 'query/edit_ClusterExe.php',
        type: 'POST',
        dataType : "json",
        data: formData,
        success: function(response) {
            if (response.res == "success") {
                Swal.fire({
                    icon: "success",
                    title: "Success",
                    text: response.msg + " updated.",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                }).then(function() {
                    window.location.href = 'home.php?page=manage-cluster';
                });
            } else if (response.res == "exists") {
                Swal.fire({
                    icon: "error",
                    title: "Failed",
                    text: "The name " + response.msg + " already exists.",
                });
            } else if (response.res == "failed") {
                Swal.fire({
                    icon: "error",
                    title: "Failed",
                    text: "An error occurred while updating Cluster. Please try again.",
                });
            } else if (response.res == "incomplete") {
                Swal.fire({
                    icon: "warning",
                    title: "Incomplete",
                    text: "Please fill in required fields.",
                });
            } else if (response.res == "norecord") {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "No record of Cluster" + response.msg + " found.",
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
        }
    });
});


// manage-cluster DISABLE 
$(document).on("submit","#disableClusterFrm" , function(event) {
    event.preventDefault();

    var formData = {
        'disable_CluId': $('#disable_CluId').val(),
        'disable_CluName': $('#disable_CluName').val(),
        'disable_CluStatus': $('#disable_CluStatus').val()
    };
    
    var isValid;
    if (formData['disable_CluId'] === '' || formData['disable_CluName'] === '' || formData['disable_CluStatus'] === '') {
        isValid = false;
    } else {
        isValid = true;
    }
    
    if (!isValid) {
        Swal.fire({
            icon: "warning",
            title: "Incomplete",
            text: "required field missing.",
        });
        return;
    }

    //console.log("INPUT VALIDATED");
    //console.log(formData);

    $.ajax({
        url: 'query/status_ClusterDisable.php',
        type: 'POST',
        dataType : "json",
        data: formData,
        success: function(response) {
            if (response.res == "success") {
                Swal.fire({
                    icon: "success",
                    title: "Success",
                    text: response.msg + " disabled.",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                }).then(function() {
                    window.location.href = 'home.php?page=manage-cluster';
                });
            } else if (response.res == "failed") {
                Swal.fire({
                    icon: "error",
                    title: "Failed",
                    text: "An error occurred while disabling Cluster. Please try again.",
                });
            } else if (response.res == "incomplete") {
                Swal.fire({
                    icon: "warning",
                    title: "Incomplete",
                    text: "required fields missing.",
                });
            } else if (response.res == "norecord") {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "No record of Cluster" + response.msg + " found.",
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
        }
    });
});


// manage-cluster ENABLE 
$(document).on("submit","#enableClusterFrm" , function(event) {
    event.preventDefault();

    var formData = {
        'enable_CluId': $('#enable_CluId').val(),
        'enable_CluName': $('#enable_CluName').val(),
        'enable_CluStatus': $('#enable_CluStatus').val()
    };
    
    var isValid;
    if (formData['enable_CluId'] === '' || formData['enable_CluName'] === '' || formData['enable_CluStatus'] === '') {
        isValid = false;
    } else {
        isValid = true;
    }
    
    if (!isValid) {
        Swal.fire({
            icon: "warning",
            title: "Incomplete",
            text: "required field missing.",
        });
        return;
    }

    console.log("INPUT VALIDATED " + isValid);
    console.log(formData);

    $.ajax({
        url: 'query/status_ClusterEnable.php',
        type: 'POST',
        dataType : "json",
        data: formData,
        success: function(response) {
            if (response.res == "success") {
                Swal.fire({
                    icon: "success",
                    title: "Success",
                    text: response.msg + " enabled.",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                }).then(function() {
                    window.location.href = 'home.php?page=manage-cluster';
                });
            } else if (response.res == "failed") {
                Swal.fire({
                    icon: "error",
                    title: "Failed",
                    text: "An error occurred while enabling Cluster. Please try again.",
                });
            } else if (response.res == "incomplete") {
                Swal.fire({
                    icon: "warning",
                    title: "Incomplete",
                    text: "required fields missing.",
                });
            } else if (response.res == "norecord") {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "No record of Cluster " + response.msg + " found.",
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
        }
    });
});
/* ########## END CLUSTER ########## */

/* ########## EXAM ########## */
//Function
function currentPg(){
    // Define the URL with the ID you want to fetch
    var currentUrl = window.location.href;

    // Extract the 'id' parameter in one line
    var id = new URL(currentUrl).searchParams.get('id');
    return id;
}

// manage-exam ADD
$(document).on("submit","#addExamFrm" , function(event) {
    event.preventDefault();

    var formData = {
        'add_ExamTitle': $('#add_ExamTitle').val(),
        'add_ExamDesc': $('#add_ExamDesc').val(),
        'add_ExamCluster': $('#add_ExamCluster').val(), //Array
        'add_ExamQuestLimit': $('#add_ExamQuestLimit').val(),
        'add_ExamTimeLimit': $('#add_ExamTimeLimit').val(),
        'add_ExamRandom': $('#add_ExamRandom').is(':checked') ? 'yes' : '', // Check if the checkbox is checked
        'add_ExamNoPrev': $('#add_ExamNoPrev').is(':checked') ? 'yes' : '', // Check if the checkbox is checked
    };

    console.log(formData);
    
    var isValid;
    if (formData['add_ExamTitle'] === '' || formData['add_ExamCluster'].length === 0 || formData['add_ExamQuestLimit'] === '' || formData['add_ExamTimeLimit'] === '') {
        isValid = false;
    } else {
        isValid = true;
    }
    
    if (!isValid) {
        Swal.fire({
            icon: "warning",
            title: "Incomplete",
            text: "Please fill in the required field.",
        });
        return;
    }

    console.log("INPUT VALIDATED " + isValid);
    console.log(formData);

    $.ajax({
        url: 'query/add_ExamExe.php',
        type: 'POST',
        dataType : "json",
        data: formData,
        success: function(response) {
            if (response.res == "success") {
                Swal.fire({
                    icon: "success",
                    title: "Success",
                    text: response.msg + " added.",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                }).then(function() {
                    window.location.href = 'home.php?page=manage-exam';
                });
            } else if (response.res == "exists") {
                Swal.fire({
                    icon: "error",
                    title: "Failed",
                    text: response.msg + "already exists.",
                });
            } else if (response.res == "failed") {
                Swal.fire({
                    icon: "error",
                    title: "Failed",
                    text: "An error occurred while adding Exam. Please try again.",
                });
            } else if (response.res == "incomplete") {
                Swal.fire({
                    icon: "warning",
                    title: "Incomplete",
                    text: "Please fill in required fields.",
                });
            } else if (response.res == "norecord") {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Unable to save clusters for " + response.msg,
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
        }
    });
});


// manage-exam DISABLE 
$(document).on("submit","#disableExamFrm" , function(event) {
    event.preventDefault();

    var formData = {
        'disable_ExamId': $('#disable_ExamId').val(),
        'disable_ExamName': $('#disable_ExamName').val(),
        'disable_ExamStatus': $('#disable_ExamStatus').val()
    };
    
    var isValid;
    if (formData['disable_ExamId'] === '' || formData['disable_ExamName'] === '' || formData['disable_ExamStatus'] === '') {
        isValid = false;
    } else {
        isValid = true;
    }
    
    if (!isValid) {
        Swal.fire({
            icon: "warning",
            title: "Incomplete",
            text: "required field missing.",
        });
        return;
    }

    //console.log("INPUT VALIDATED");
    //console.log(formData);

    $.ajax({
        url: 'query/status_ExamDisable.php',
        type: 'POST',
        dataType : "json",
        data: formData,
        success: function(response) {
            if (response.res == "success") {
                Swal.fire({
                    icon: "success",
                    title: "Success",
                    text: response.msg + " disabled.",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                }).then(function() {
                    window.location.href = 'home.php?page=manage-exam';
                });
            } else if (response.res == "failed") {
                Swal.fire({
                    icon: "error",
                    title: "Failed",
                    text: "An error occurred while disabling Exam. Please try again.",
                });
            } else if (response.res == "incomplete") {
                Swal.fire({
                    icon: "warning",
                    title: "Incomplete",
                    text: "required fields missing.",
                });
            } else if (response.res == "norecord") {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "No record of Exam" + response.msg + " found.",
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
        }
    });
});


// manage-exam ENABLE 
$(document).on("submit","#enableExamFrm" , function(event) {
    event.preventDefault();

    var formData = {
        'enable_ExamId': $('#enable_ExamId').val(),
        'enable_ExamName': $('#enable_ExamName').val(),
        'enable_ExamStatus': $('#enable_ExamStatus').val()
    };
    
    var isValid;
    if (formData['enable_ExamId'] === '' || formData['enable_ExamName'] === '' || formData['enable_ExamStatuss'] === '') {
        isValid = false;
    } else {
        isValid = true;
    }
    
    if (!isValid) {
        Swal.fire({
            icon: "warning",
            title: "Incomplete",
            text: "required field missing.",
        });
        return;
    }

    //console.log("INPUT VALIDATED " + isValid);
    //console.log(formData);

    $.ajax({
        url: 'query/status_ExamEnable.php',
        type: 'POST',
        dataType : "json",
        data: formData,
        success: function(response) {
            if (response.res == "success") {
                Swal.fire({
                    icon: "success",
                    title: "Success",
                    text: response.msg + " enabled.",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                }).then(function() {
                    window.location.href = 'home.php?page=manage-exam';
                });
            } else if (response.res == "failed") {
                Swal.fire({
                    icon: "error",
                    title: "Failed",
                    text: "An error occurred while enabling Exam. Please try again.",
                });
            } else if (response.res == "incomplete") {
                Swal.fire({
                    icon: "warning",
                    title: "Incomplete",
                    text: "required fields missing.",
                });
            } else if (response.res == "norecord") {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "No record of Exam " + response.msg + " found.",
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
        }
    });
});


// manage-exam-edit INFO EDIT
$(document).on("submit","#editExamFrm" , function(event) {
    event.preventDefault();

    // Define the URL with the ID you want to fetch
    const url = 'https://example.com/api/items/123'; // Replace with your actual URL

    // Use fetch to make a GET request
    fetch(url)
    .then(response => {
        // Check if the request was successful
        if (!response.ok) {
        throw new Error('Network response was not ok');
        }
        // Parse the response body as JSON
        return response.json();
    })
    .then(data => {
        // Handle the data
        console.log(data);
    })
    .catch(error => {
        // Handle the error
        console.error('There was a problem with the fetch operation:', error);
    });

    var formData = {
        'edit_ExamId': $('#edit_ExamId').val(),
        'edit_ExamTitle': $('#edit_ExamTitle').val(),
        'edit_ExamDesc': $('#edit_ExamDesc').val(),
        'edit_ExamCluster': $('#edit_ExamCluster').val(), 
        'edit_ExamQuestLimit': $('#edit_ExamQuestLimit').val(),
        'edit_ExamTimeLimit': $('#edit_ExamTimeLimit').val(),
        'edit_ExamRandom': $('#edit_ExamRandom').val(),
        'edit_ExamNoPrev': $('#edit_ExamNoPrev').val(),
        'edit_ExamRandom': $('#edit_ExamRandom').is(':checked') ? 'yes' : '', // Check if the checkbox is checked
        'edit_ExamNoPrev': $('#edit_ExamNoPrev').is(':checked') ? 'yes' : '', // Check if the checkbox is checked
        'edit_ExamStatus': $('#edit_ExamStatus').val()
    };
    

    console.log(formData);
    
    var isValid;
    if (formData['edit_ExamId'] === '' || formData['edit_ExamTitle'] === '' || formData['edit_ExamCluster'].length === 0 || formData['edit_ExamQuestLimit'] === '' || formData['edit_ExamTimeLimit'] === '') {
        isValid = false;
    } else {
        isValid = true;
    }
    
    if (!isValid) {
        Swal.fire({
            icon: "warning",
            title: "Incomplete",
            text: "Please fill in the required field.",
        });
        return;
    }

    console.log("INPUT VALIDATED " + isValid);
    console.log(formData);

    $.ajax({
        url: 'query/edit_ExamExe.php',
        type: 'POST',
        dataType : "json",
        data: formData,
        success: function(response) {
            if (response.res == "success") {
                Swal.fire({
                    icon: "success",
                    title: "Success",
                    text: response.msg + " updated.",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                }).then(function() {
                    // Assuming 'home.php?page=manage-exam' is the URL where the updated content is located
                    //$('.examContainer').load('home.php?page=manage-exam .examContainer');
                    location.reload();
                });
            } else if (response.res == "exists") {
                Swal.fire({
                    icon: "error",
                    title: "Failed",
                    text: "The name " + response.msg + " already exists.",
                });
            } else if (response.res == "failed") {
                Swal.fire({
                    icon: "error",
                    title: "Failed",
                    text: "An error occurred while updating exam. Please try again.",
                });
            } else if (response.res == "incomplete") {
                Swal.fire({
                    icon: "warning",
                    title: "Incomplete",
                    text: "Please fill in required fields.",
                });
            } else if (response.res == "norecord") {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Exam does not exist.",
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
        }
    });    
});


// manage-exam-edit QUESTION ADD
$(document).on("submit","#addQuestionFrm" , function(event) {
    event.preventDefault();

    var page = currentPg();

    //Append fields to formData
    var formData = new FormData();
    formData.append('add_QstnExamId', $('#add_QstnExamId').val()); 
    formData.append('add_Question', $('#add_Question').val()); 
    formData.append('add_QstnCh1', $('#add_QstnCh1').val());
    formData.append('add_QstnCh2', $('#add_QstnCh2').val());
    formData.append('add_QstnCh3', $('#add_QstnCh3').val());
    formData.append('add_QstnCh4', $('#add_QstnCh4').val());
    formData.append('add_QstnCh5', $('#add_QstnCh5').val());
    formData.append('add_QstnCh6', $('#add_QstnCh6').val());
    formData.append('add_QstnCh7', $('#add_QstnCh7').val());
    formData.append('add_QstnCh8', $('#add_QstnCh8').val());
    formData.append('add_QstnCh9', $('#add_QstnCh9').val());
    formData.append('add_QstnCh10', $('#add_QstnCh10').val());
    formData.append('add_ExamImg', $('#add_ExamImg')[0].files[0]);
    
	// Append add_QstnAns based on selection
    var selectedValue = $('#add_QstnAns').val();
    var key = 'add_QstnCh' + selectedValue;

    // Check if the selected answer is not empty or undefined
    if (selectedValue && formData.get(key)) {
        formData.append('add_QstnAns', formData.get(key));
    } else {
        Swal.fire({
            icon: "warning",
            title: "Incomplete",
            text: "Please select an answer.",
        });
        return;
    }


    // Display the appended values in the console
    for (var pair of formData.entries()) {
        console.log(pair[0]+ ', ' + pair[1]); 
    }

    // Check if a file has been selected for add_ExamImg
    var examImgInput = $('#add_ExamImg')[0];
    if (examImgInput.files.length > 0) {
        var examImgFile = examImgInput.files[0];
        formData.append('add_ExamImg', examImgFile);
    }

    // Validation
    var isValid = formData.get('add_Question') !== '' && formData.get('add_QstnAns') !== '' && formData.get('add_QstnExamId') !== '';
    if (!isValid) {
        Swal.fire({
            icon: "warning",
            title: "Incomplete",
            text: "Please fill in the required field.",
        });
        return;
    }

    //console.log("INPUT VALIDATED " + isValid);
    //console.log(formData);

    $.ajax({
        url: 'query/add_ExamQuestExe.php',
        type: 'POST',
        dataType : "json",
        data: formData,
        processData: false, 
        contentType: false,
        beforeSend: function() {
            Swal.fire({
                title: 'Uploading...',
                html: 'Please wait while your question is being processed.',
                allowOutsideClick: false,
                onBeforeOpen: () => {
                    Swal.showLoading();
                }
            });
        },
        success: function(response) {
            Swal.close(); 
            if (response.res == "success") {
                Swal.fire({
                    icon: "success",
                    title: "Success",
                    text: "Question added to " + response.msg + ".",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                }).then(function() {
                    window.location.href = 'home.php?page=manage-exam-edit&id=' + page + '&tab=exam-questions';
                    //location.reload();
                });
            } else if (response.res == "exists") {
                Swal.fire({
                    icon: "error",
                    title: "Failed",
                    text: response.msg + "already exists.",
                });
            } else if (response.res == "failed") {
                Swal.fire({
                    icon: "error",
                    title: "Failed",
                    text: "An error occurred while adding Question. Please try again.",
                });
            } else if (response.res == "incomplete") {
                Swal.fire({
                    icon: "warning",
                    title: "Incomplete",
                    text: "Please fill in required fields.",
                });
            } else if (response.res == "norecord") {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Exam not found " + response.msg,
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
            Swal.close();
            alert('A script error occured. Please try again.');
            console.error(textStatus, errorThrown);
            console.log(jqXHR.responseText);
        }
    });
});


// manage-exam-edit QUESTION EDIT
$(document).on("submit","#EditQuestionFrm" , function(event) {
    event.preventDefault();
    console.log("1");

    
    var page = currentPg();

    //Append fields to formData
    var formData = new FormData();
    formData.append('edit_QstnId', $('#edit_QstnId').val()); 
    formData.append('edit_QstnExamId', $('#edit_QstnExamId').val()); 
    formData.append('edit_ImgStatus', $('#edit_ImgStatus').val()); 
    formData.append('edit_Question', $('#edit_Question').val()); 
    formData.append('edit_QstnCh1', $('#edit_QstnCh1').val());
    formData.append('edit_QstnCh2', $('#edit_QstnCh2').val());
    formData.append('edit_QstnCh3', $('#edit_QstnCh3').val());
    formData.append('edit_QstnCh4', $('#edit_QstnCh4').val());
    formData.append('edit_QstnCh5', $('#edit_QstnCh5').val());
    formData.append('edit_QstnCh6', $('#edit_QstnCh6').val());
    formData.append('edit_QstnCh7', $('#edit_QstnCh7').val());
    formData.append('edit_QstnCh8', $('#edit_QstnCh8').val());
    formData.append('edit_QstnCh9', $('#edit_QstnCh9').val());
    formData.append('edit_QstnCh10', $('#edit_QstnCh10').val());
    formData.append('edit_ExamImg', $('#edit_ExamImg')[0].files[0]);  
    console.log("2");
    
	// Append edit_QstnAns based on selection
    var selectedValue = $('#edit_QstnAns').val();
    var key = 'edit_QstnCh' + selectedValue;

    // Check if the selected answer is not empty or undefined
    if (selectedValue && formData.get(key)) {
        formData.append('edit_QstnAns', formData.get(key));
    } else {
        Swal.fire({
            icon: "warning",
            title: "Incomplete",
            text: "Please select an answer.",
        });
        return;
    }

    // Display the appended values in the console
    for (var pair of formData.entries()) {
        console.log(pair[0]+ ', ' + pair[1]); 
    }

    // Check if a file has been selected for edit_ExamImg
    var examImgInput = $('#edit_ExamImg')[0];
    if (examImgInput.files.length > 0) {
        var examImgFile = examImgInput.files[0];
        formData.append('edit_ExamImg', examImgFile);
    }

    // Validation
    var isValid = formData.get('edit_Question') !== '' && formData.get('edit_QstnAns') !== '' && formData.get('edit_QstnId') !== '';
    if (!isValid) {
        Swal.fire({
            icon: "warning",
            title: "Incomplete",
            text: "Please fill in the required field.",
        });
        return;
    }

    //console.log("INPUT VALIDATED " + isValid);
    //console.log(formData);
    console.log("3");

    $.ajax({
        url: 'query/edit_ExamQuestExe.php',
        type: 'POST',
        dataType : "json",
        data: formData,
        processData: false, 
        contentType: false,
        beforeSend: function() {
            Swal.fire({
                title: 'Uploading...',
                html: 'Please wait while your question is being processed.',
                allowOutsideClick: false,
                onBeforeOpen: () => {
                    Swal.showLoading();
                }
            });
        },
        success: function(response) {
            Swal.close(); 
            if (response.res == "success") {
                Swal.fire({
                    icon: "success",
                    title: "Success",
                    text: "Question added to " + response.msg + ".",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                }).then(function() {
                    window.location.href = 'home.php?page=manage-exam-edit&id=' + page + '&tab=exam-questions';
                    //location.reload();
                });
            } else if (response.res == "exists") {
                Swal.fire({
                    icon: "error",
                    title: "Failed",
                    text: response.msg + "already exists.",
                });
            } else if (response.res == "failed") {
                Swal.fire({
                    icon: "error",
                    title: "Failed",
                    text: "An error occurred while adding Question. Please try again.",
                });
            } else if (response.res == "incomplete") {
                Swal.fire({
                    icon: "warning",
                    title: "Incomplete",
                    text: "Please fill in required fields.",
                });
            } else if (response.res == "norecord") {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Exam not found " + response.msg,
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
            Swal.close();
            alert('A script error occured. Please try again.');
            console.error(textStatus, errorThrown);
            console.log(jqXHR.responseText);
        }
    });
});
/* ########## END EXAM ########## */

/* ########## X ########## */
