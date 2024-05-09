let swalLoad;

/* ########## CLUSTER ########## */
// manage-cluster ADD 
$(document).on("submit","#addClusterFrm" , function(event) {
    event.preventDefault();

    var formData = {
        'add_CluName': $('#add_CluName').val(),
        'add_CluDesc': $('#add_CluDesc').val()
    };

    //console.log(formData); //DEBUG
    
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

    //console.log("INPUT VALIDATED " + isValid); //DEBUG
    //console.log(formData); //DEBUG

    $.ajax({
        url: 'query/add_ClusterExe.php',
        type: 'POST',
        dataType : "json",
        data: formData,
        beforeSend: function() {
            swalLoad = Swal.fire({
                title: 'Loading...',
                html: 'Please wait while your query is being processed.',
                allowOutsideClick: false,
                onBeforeOpen: () => {
                    Swal.showLoading();
                }
            });
        },
        success: function(response) {
            swalLoad.close();
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
                    text: response.msg + " already exists.",
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
            swalLoad.close();
            alert('A script error occured. Please try again.');
            console.error(textStatus, errorThrown);
            console.log(jqXHR.responseText);
            location.reload();
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

    //console.log("INPUT VALIDATED"); //DEBUG
    //console.log(formData); //DEBUG

    $.ajax({
        url: 'query/edit_ClusterExe.php',
        type: 'POST',
        dataType : "json",
        data: formData,
        beforeSend: function() {
            swalLoad = Swal.fire({
                title: 'Loading...',
                html: 'Please wait while your query is being processed.',
                allowOutsideClick: false,
                onBeforeOpen: () => {
                    Swal.showLoading();
                }
            });
        },
        success: function(response) {
            swalLoad.close();
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
            swalLoad.close();
            alert('A script error occured. Please try again.');
            console.error(textStatus, errorThrown);
            console.log(jqXHR.responseText);
            location.reload();
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

    //console.log("INPUT VALIDATED"); //DEBUG
    //console.log(formData); //DEBUG

    $.ajax({
        url: 'query/status_ClusterDisable.php',
        type: 'POST',
        dataType : "json",
        data: formData,
        beforeSend: function() {
            swalLoad = Swal.fire({
                title: 'Loading...',
                html: 'Please wait while your query is being processed.',
                allowOutsideClick: false,
                onBeforeOpen: () => {
                    Swal.showLoading();
                }
            });
        },
        success: function(response) {
            swalLoad.close();
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
            swalLoad.close();
            alert('A script error occured. Please try again.');
            console.error(textStatus, errorThrown);
            console.log(jqXHR.responseText);
            location.reload();
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

    //console.log("INPUT VALIDATED " + isValid); //DEBUG
    //console.log(formData); //DEBUG

    $.ajax({
        url: 'query/status_ClusterEnable.php',
        type: 'POST',
        dataType : "json",
        data: formData,
        beforeSend: function() {
            swalLoad = Swal.fire({
                title: 'Loading...',
                html: 'Please wait while your query is being processed.',
                allowOutsideClick: false,
                onBeforeOpen: () => {
                    Swal.showLoading();
                }
            });
        },
        success: function(response) {
            swalLoad.close();
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
            swalLoad.close();
            alert('A script error occured. Please try again.');
            console.error(textStatus, errorThrown);
            console.log(jqXHR.responseText);
            location.reload();
        }
    });
});
/* ########## END CLUSTER ########## */



/* ########## EXAM ########## */
//Function
function currentPg(){
    var currentUrl = window.location.href;
    var id = new URL(currentUrl).searchParams.get('id');
    return id;
}

// manage-exam ADD
$(document).on("submit","#addExamFrm" , function(event) {
    event.preventDefault();

    var formData = {
        'add_ExamTitle': $('#add_ExamTitle').val(),
        'add_ExamDesc': $('#add_ExamDesc').val(),
        'add_ExamCluster': $('#add_ExamCluster').val(), 
        'add_ExamQuestLimit': $('#add_ExamQuestLimit').val(),
        'add_ExamTimeLimit': $('#add_ExamTimeLimit').val(),
        'add_ExamRandom': $('#add_ExamRandom').is(':checked') ? 'yes' : '', 
        'add_ExamNoPrev': $('#add_ExamNoPrev').is(':checked') ? 'yes' : '', 
    };

    //console.log(formData); //DEBUG
    
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

    //console.log("INPUT VALIDATED " + isValid); //DEBUG
    //console.log(formData); //DEBUG

    $.ajax({
        url: 'query/add_ExamExe.php',
        type: 'POST',
        dataType : "json",
        data: formData,
        beforeSend: function() {
            swalLoad = Swal.fire({
                title: 'Loading...',
                html: 'Please wait while your query is being processed.',
                allowOutsideClick: false,
                onBeforeOpen: () => {
                    Swal.showLoading();
                }
            });
        },
        success: function(response) {
            swalLoad.close();
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
                    text: response.msg + " already exists.",
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
            swalLoad.close();
            alert('A script error occured. Please try again.');
            console.error(textStatus, errorThrown);
            console.log(jqXHR.responseText);
            location.reload();
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

    //console.log("INPUT VALIDATED"); //DEBUG
    //console.log(formData); //DEBUG

    $.ajax({
        url: 'query/status_ExamDisable.php',
        type: 'POST',
        dataType : "json",
        data: formData,
        beforeSend: function() {
            swalLoad = Swal.fire({
                title: 'Loading...',
                html: 'Please wait while your query is being processed.',
                allowOutsideClick: false,
                onBeforeOpen: () => {
                    Swal.showLoading();
                }
            });
        },
        success: function(response) {
            swalLoad.close();
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
            swalLoad.close();
            alert('A script error occured. Please try again.');
            console.error(textStatus, errorThrown);
            console.log(jqXHR.responseText);
            location.reload();
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

    //console.log("INPUT VALIDATED " + isValid); //DEBUG
    //console.log(formData); //DEBUG

    $.ajax({
        url: 'query/status_ExamEnable.php',
        type: 'POST',
        dataType : "json",
        data: formData,
        beforeSend: function() {
            swalLoad = Swal.fire({
                title: 'Loading...',
                html: 'Please wait while your query is being processed.',
                allowOutsideClick: false,
                onBeforeOpen: () => {
                    Swal.showLoading();
                }
            });
        },
        success: function(response) {
            swalLoad.close();
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
            swalLoad.close();
            alert('A script error occured. Please try again.');
            console.error(textStatus, errorThrown);
            console.log(jqXHR.responseText);
            location.reload();
        }
    });
});

// manage-exam-edit INFO EDIT
$(document).on("submit","#editExamFrm" , function(event) {
    event.preventDefault();

    var page = currentPg();

    var formData = {
        'edit_ExamId': $('#edit_ExamId').val(),
        'edit_ExamTitle': $('#edit_ExamTitle').val(),
        'edit_ExamDesc': $('#edit_ExamDesc').val(),
        'edit_ExamCluster': $('#edit_ExamCluster').val(), 
        'edit_ExamQuestLimit': $('#edit_ExamQuestLimit').val(),
        'edit_ExamTimeLimit': $('#edit_ExamTimeLimit').val(),
        'edit_ExamRandom': $('#edit_ExamRandom').val(),
        'edit_ExamNoPrev': $('#edit_ExamNoPrev').val(),
        'edit_ExamRandom': $('#edit_ExamRandom').is(':checked') ? 'yes' : '',
        'edit_ExamNoPrev': $('#edit_ExamNoPrev').is(':checked') ? 'yes' : '',
        'edit_ExamStatus': $('#edit_ExamStatus').val()
    };
    
    //console.log(formData); //DEBUG
    
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

    //console.log("INPUT VALIDATED " + isValid); //DEBUG
    //console.log(formData); //DEBUG

    $.ajax({
        url: 'query/edit_ExamExe.php',
        type: 'POST',
        dataType : "json",
        data: formData,
        beforeSend: function() {
            swalLoad = Swal.fire({
                title: 'Loading...',
                html: 'Please wait while your query is being processed.',
                allowOutsideClick: false,
                onBeforeOpen: () => {
                    Swal.showLoading();
                }
            });
        },
        success: function(response) {
            swalLoad.close();
            if (response.res == "success") {
                Swal.fire({
                    icon: "success",
                    title: "Success",
                    text: response.msg + " updated.",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                }).then(function() {
                    window.location.href = 'home.php?page=manage-exam-edit&id=' + page + '&tab=exam-information';
                    //location.reload(); //Alternative
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
            swalLoad.close();
            alert('A script error occured. Please try again.');
            console.error(textStatus, errorThrown);
            console.log(jqXHR.responseText);
            location.reload();
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
    /*for (var pair of formData.entries()) { //DEBUG
        console.log(pair[0]+ ', ' + pair[1]); 
    }*/

    // Check if a file has been selected for add_ExamImg
    var examImgInput = $('#add_ExamImg')[0];
    if (examImgInput.files.length > 0) {
        var examImgFile = examImgInput.files[0];
        formData.append('add_ExamImg', examImgFile);
    }

    var isValid = formData.get('add_Question') !== '' && formData.get('add_QstnAns') !== '' && formData.get('add_QstnExamId') !== '';
    if (!isValid) {
        Swal.fire({
            icon: "warning",
            title: "Incomplete",
            text: "Please fill in the required field.",
        });
        return;
    }

    //console.log("INPUT VALIDATED " + isValid); //DEBUG
    //console.log(formData); //DEBUG

    $.ajax({
        url: 'query/add_ExamQuestExe.php',
        type: 'POST',
        dataType : "json",
        data: formData,
        processData: false, 
        contentType: false,
        beforeSend: function() {
            swalLoad = Swal.fire({
                title: 'Loading...',
                html: 'Please wait while your question is being processed.',
                allowOutsideClick: false,
                onBeforeOpen: () => {
                    Swal.showLoading();
                }
            });
        },
        success: function(response) {
            swalLoad.close(); 
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
                    //location.reload(); //Alternative
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
            swalLoad.close();
            alert('A script error occured. Please try again.');
            console.error(textStatus, errorThrown);
            console.log(jqXHR.responseText);
            location.reload();
        }
    });
});

// manage-exam-edit QUESTION EDIT
$(document).on("submit","#EditQuestionFrm" , function(event) {
    event.preventDefault();

    var page = currentPg();

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
    
	// Append edit_QstnAns based on selection
    var selectedValue = $('#edit_QstnAns').val();
    var key = 'edit_QstnCh' + selectedValue;

    // Check if the selected answer is not empty or undefined, or if it is 'none'
    if (selectedValue && (formData.get(key) || selectedValue === 'none')) {
        formData.append('edit_QstnAns', formData.get(key) || selectedValue);
    } else {
        Swal.fire({
            icon: "warning",
            title: "Incomplete",
            text: "Please select an answer.",
        });
        return;
    }


    // DEBUG: Display the appended values in the console
    /*for (var pair of formData.entries()) { //DEBUG
        console.log(pair[0]+ ', ' + pair[1]); 
    }*/

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

    //console.log("INPUT VALIDATED " + isValid); //DEBUG
    //console.log(formData); //DEBUG

    $.ajax({
        url: 'query/edit_ExamQuestExe.php',
        type: 'POST',
        dataType : "json",
        data: formData,
        processData: false, 
        contentType: false,
        beforeSend: function() {
            swalLoad = Swal.fire({
                title: 'Loading...',
                html: 'Please wait while your question is being processed.',
                allowOutsideClick: false,
                onBeforeOpen: () => {
                    Swal.showLoading();
                }
            });
        },
        success: function(response) {
            swalLoad.close(); 
            if (response.res == "success") {
                Swal.fire({
                    icon: "success",
                    title: "Success",
                    text: "Question updated.",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                }).then(function() {
                    window.location.href = 'home.php?page=manage-exam-edit&id=' + page + '&tab=exam-questions';
                    //location.reload(); //Alternative
                });
            } else if (response.res == "fileerror") {
                Swal.fire({
                    icon: "error",
                    title: "Failed",
                    text: "There was an error uploading the image.",
                });
            } else if (response.res == "filetypeerror") {
                Swal.fire({
                    icon: "error",
                    title: "Failed",
                    text: "Wrong File Type. Only PNG, JPG, JPEG and WEBP files are allowed.",
                });
            } else if (response.res == "filemodify") {
                Swal.fire({
                    icon: "error",
                    title: "Failed",
                    text: "There was an error modifying the image. Please try again.",
                });
            } else if (response.res == "failed") {
                Swal.fire({
                    icon: "error",
                    title: "Failed",
                    text: "An error occurred while updating Question. Please try again.",
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
            swalLoad.close();
            alert('A script error occured. Please try again.');
            console.error(textStatus, errorThrown);
            console.log(jqXHR.responseText);
            location.reload();
        }
    });
});

// manage-exam-edit QUESTION DELETE
$(document).on("submit","#deleteQuestionFrm" , function(event) {
    event.preventDefault();

    var page = currentPg();
    
    var formData = {
        'delete_QstnId': $('#delete_QstnId').val()
    };
    
    var isValid;
    if (formData['delete_QstnId'] === '') {
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

    //console.log("INPUT VALIDATED"); //DEBUG
    //console.log(formData); //DEBUG

    $.ajax({
        url: 'query/delete_ExamQuestExe.php',
        type: 'POST',
        dataType : "json",
        data: formData,
        beforeSend: function() {
            swalLoad = Swal.fire({
                title: 'Loading...',
                html: 'Please wait while your query is being processed.',
                allowOutsideClick: false,
                onBeforeOpen: () => {
                    Swal.showLoading();
                }
            });
        },
        success: function(response) {
            swalLoad.close();
            if (response.res == "success") {
                Swal.fire({
                    icon: "success",
                    title: "Success",
                    text: "Question deleted.",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                }).then(function() {
                    window.location.href = 'home.php?page=manage-exam-edit&id=' + page + '&tab=exam-questions';
                });
            } else if (response.res == "failed") {
                Swal.fire({
                    icon: "error",
                    title: "Failed",
                    text: "An error occurred while Deleting Question. Please try again.",
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
                    text: "No record of Question " + response.msg + " found.",
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
            swalLoad.close();
            alert('A script error occured. Please try again.');
            console.error(textStatus, errorThrown);
            console.log(jqXHR.responseText);
            location.reload();
        }
    });
});
/* ########## END EXAM ########## */



/* ########## EXAMINEE ########## */
// manage-examinee ADD 
$(document).on("submit","#addExamineeFrm" , function(event) {
    event.preventDefault();

    var formData = {
        'add_ExmneFname': $('#add_ExmneFname').val(),
        'add_ExmneMname': $('#add_ExmneMname').val(),
        'add_ExmneLname': $('#add_ExmneLname').val(),
        'add_ExmneSfname': $('#add_ExmneSfname').val(),
        'add_ExmneCluster': $('#add_ExmneCluster').val(),
        'add_ExmneSex': $('#add_ExmneSex').val(),
        'add_ExmneBirth': $('#add_ExmneBirth').val(),
        'add_ExmneEmail': $('#add_ExmneEmail').val(),
        'add_ExmnePass': $('#add_ExmnePass').val()
    };
    
    var isValid;
    if (formData['add_ExmneFname'] === '' || formData['add_ExmneLname'] === '' || formData['add_ExmneCluster'] === '' || formData['add_ExmneEmail'] === '' || formData['add_ExmnePass'] === '') {
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

    //console.log("INPUT VALIDATED " + isValid); //DEBUG
    //console.log(formData); //DEBUG

    $.ajax({
        url: 'query/add_ExamineeExe.php',
        type: 'POST',
        dataType : "json",
        data: formData,
        beforeSend: function() {
            swalLoad = Swal.fire({
                title: 'Loading...',
                html: 'Please wait while your query is being processed.',
                allowOutsideClick: false,
                onBeforeOpen: () => {
                    Swal.showLoading();
                }
            });
        },
        success: function(response) {
            swalLoad.close();
            if (response.res == "success") {
                Swal.fire({
                    icon: "success",
                    title: "Success",
                    text: response.msg + " added.",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                }).then(function() {
                    window.location.href = 'home.php?page=manage-examinee';
                });
            } else if (response.res == "exists") {
                Swal.fire({
                    icon: "error",
                    title: "Failed",
                    text: "Existing Data Found. Please input different details.",
                });
            } else if (response.res == "failed") {
                Swal.fire({
                    icon: "error",
                    title: "Failed",
                    text: "An error occurred while adding Examinee. Please try again.",
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
            swalLoad.close();
            alert('A script error occured. Please try again.');
            console.error(textStatus, errorThrown);
            console.log(jqXHR.responseText);
            location.reload();
        }
    });
});

// manage-examinee EDIT 
$(document).on("submit","#EditExamineeFrm" , function(event) {
    event.preventDefault();

    var formData = {
        'edit_ExmneId': $('#edit_ExmneId').val(),
        'edit_ExmneFname': $('#edit_ExmneFname').val(),
        'edit_ExmneMname': $('#edit_ExmneMname').val(),
        'edit_ExmneLname': $('#edit_ExmneLname').val(),
        'edit_ExmneSfname': $('#edit_ExmneSfname').val(),
        'edit_ExmneCluster': $('#edit_ExmneCluster').val(),
        'edit_ExmneSex': $('#edit_ExmneSex').val(),
        'edit_ExmneBirth': $('#edit_ExmneBirth').val(),
        'edit_ExmneStatus': $('#edit_ExmneStatus').val(),
        'edit_ExmneEmail': $('#edit_ExmneEmail').val(),
        'edit_ExmnePass': $('#edit_ExmnePass').val()
    };
    
    var isValid;
    if (formData['edit_ExmneId'] === '' || formData['edit_ExmneFname'] === '' || formData['edit_ExmneLname'] === '' || formData['edit_ExmneCluster'] === '' || formData['edit_ExmneStatus'] === '' || formData['edit_ExmneEmail'] === '' || formData['edit_ExmnePass'] === '') {
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

    //console.log("INPUT VALIDATED " + isValid); //DEBUG
    //console.log(formData); //DEBUG

    $.ajax({
        url: 'query/edit_ExamineeExe.php',
        type: 'POST',
        dataType : "json",
        data: formData,
        beforeSend: function() {
            swalLoad = Swal.fire({
                title: 'Loading...',
                html: 'Please wait while your query is being processed.',
                allowOutsideClick: false,
                onBeforeOpen: () => {
                    Swal.showLoading();
                }
            });
        },
        success: function(response) {
            swalLoad.close();
            if (response.res == "success") {
                Swal.fire({
                    icon: "success",
                    title: "Success",
                    text: response.msg + " updated.",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                }).then(function() {
                    window.location.href = 'home.php?page=manage-examinee';
                });
            } else if (response.res == "exists") {
                Swal.fire({
                    icon: "error",
                    title: "Failed",
                    text: "Similar Data Found.",
                });
            } else if (response.res == "failed") {
                Swal.fire({
                    icon: "error",
                    title: "Failed",
                    text: "An error occurred while updating Examinee. Please try again.",
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
            swalLoad.close();
            alert('A script error occured. Please try again.');
            console.error(textStatus, errorThrown);
            console.log(jqXHR.responseText);
            location.reload();
        }
    });
});

// manage-examinee DISABLE 
$(document).on("submit","#disableExamineeFrm" , function(event) {
    event.preventDefault();

    var formData = {
        'disable_ExmneId': $('#disable_ExmneId').val(),
        'disable_ExmneFname': $('#disable_ExmneFname').val(),
        'disable_ExmneLname': $('#disable_ExmneLname').val(),
        'disable_ExmneStatus': $('#disable_ExmneStatus').val()
    };
    
    var isValid;
    if (formData['disable_ExmneId'] === '' || formData['disable_ExmneFname'] === '' || formData['disable_ExmneLname'] === '' || formData['disable_ExmneStatus'] === '') {
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
        url: 'query/status_ExamineeDisable.php',
        type: 'POST',
        dataType : "json",
        data: formData,
        beforeSend: function() {
            swalLoad = Swal.fire({
                title: 'Loading...',
                html: 'Please wait while your query is being processed.',
                allowOutsideClick: false,
                onBeforeOpen: () => {
                    Swal.showLoading();
                }
            });
        },
        success: function(response) {
            swalLoad.close();
            if (response.res == "success") {
                Swal.fire({
                    icon: "success",
                    title: "Success",
                    text: response.msg + " disabled.",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                }).then(function() {
                    window.location.href = 'home.php?page=manage-examinee';
                });
            } else if (response.res == "failed") {
                Swal.fire({
                    icon: "error",
                    title: "Failed",
                    text: "An error occurred while disabling Examinee. Please try again.",
                });
            } else if (response.res == "exists") {
                Swal.fire({
                    icon: "info",
                    title: "Disabled",
                    text: "Examinee " + response.msg + " already disabled.",
                }).then(function() {
                    window.location.href = 'home.php?page=manage-examinee';
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
                    text: "No record of examinee" + response.msg + " found.",
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
            swalLoad.close();
            alert('A script error occured. Please try again.');
            console.error(textStatus, errorThrown);
            console.log(jqXHR.responseText);
            location.reload();
        }
    });
});

// manage-examinee ENABLE 
$(document).on("submit","#enableExamineeFrm" , function(event) {
    event.preventDefault();

    var formData = {
        'enable_ExmneId': $('#enable_ExmneId').val(),
        'enable_ExmneFname': $('#enable_ExmneFname').val(),
        'enable_ExmneLname': $('#enable_ExmneLname').val(),
        'enable_ExmneStatus': $('#enable_ExmneStatus').val()
    };
    
    var isValid;
    if (formData['enable_ExmneId'] === '' || formData['enable_ExmneFname'] === '' || formData['enable_ExmneLname'] === '' || formData['enable_ExmneStatus'] === '') {
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
        url: 'query/status_ExamineeEnable.php',
        type: 'POST',
        dataType : "json",
        data: formData,
        beforeSend: function() {
            swalLoad = Swal.fire({
                title: 'Loading...',
                html: 'Please wait while your query is being processed.',
                allowOutsideClick: false,
                onBeforeOpen: () => {
                    Swal.showLoading();
                }
            });
        },
        success: function(response) {
            swalLoad.close();
            if (response.res == "success") {
                Swal.fire({
                    icon: "success",
                    title: "Success",
                    text: response.msg + " enabled.",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                }).then(function() {
                    window.location.href = 'home.php?page=manage-examinee';
                });
            } else if (response.res == "failed") {
                Swal.fire({
                    icon: "error",
                    title: "Failed",
                    text: "An error occurred while enabling Examinee. Please try again.",
                });
            } else if (response.res == "exists") {
                Swal.fire({
                    icon: "info",
                    title: "Disabled",
                    text: "Examinee " + response.msg + " already enabled.",
                }).then(function() {
                    window.location.href = 'home.php?page=manage-examinee';
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
                    text: "No record of examinee " + response.msg + " found.",
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
            swalLoad.close();
            alert('A script error occured. Please try again.');
            console.error(textStatus, errorThrown);
            console.log(jqXHR.responseText);
            location.reload();
        }
    });
});
/* ########## END EXAMINEE ########## */



/* ########## RANKING ########## */
// report-ranking-exam SAVE
$(document).on("submit","#saveRankingFrm" , function(event) {
    event.preventDefault();

    var formData = {
        'save_examId': $('#save_examId').val(),
        'save_datefrom' : $('#save_datefrom').val(),
        'save_dateto' : $('#save_dateto').val(),
    }

    var isValid;
    if (formData['save_examId'] == '') {
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

    //console.log("INPUT VALIDATED"); //DEBUG
    //console.log(formData); //DEBUG

    //Save Exam Ranking
    /*$.ajax({ //NOT IMPLEMENTED
        url: 'query/save_ExamRankingExe.php',
        type: 'POST',
        dataType : "json",
        data: formData,
        beforeSend: function() {
            swalLoad = Swal.fire({
                title: 'Loading...',
                html: 'Please wait while your query is being processed.',
                allowOutsideClick: false,
                onBeforeOpen: () => {
                    Swal.showLoading();
                }
            });
        },
        success: function(response) {
            swalLoad.close();
            if (response.res == "success") {
                Swal.fire({
                    icon: "success",
                    title: "Success",
                    text: response.msg + " exported.",
                    showConfirmButton: false,
                    timer: 5000,
                    timerProgressBar: true,
                }).then(function() {
                    location.reload();
                });
            } else if (response.res == "failed") {
                Swal.fire({
                    icon: "error",
                    title: "Failed",
                    text: "An error occurred while exporting Rankings. Please try again.",
                });
            } else if (response.res == "nodata") {
                Swal.fire({
                    icon: "info",
                    title: "Disabled",
                    text: "Date Range resulted in no records. Please try different range.",
                })
            } else if (response.res == "norecord") {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "No record of Exam" + response.msg + " found.",
                });
            } else if (response.res == "incomplete") {
                Swal.fire({
                    icon: "warning",
                    title: "Incomplete",
                    text: "required fields missing.",
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
            swalLoad.close();
            alert('A script error occured. Please try again.');
            console.error(textStatus, errorThrown);
            console.log(jqXHR.responseText);
            location.reload();
        }
    });*/
});
/* ########## END RANKING ########## */



/* ########## ADMIN ########## */
// manage-admin ADD 
$(document).on("submit","#addUserFrm" , function(event) {
    event.preventDefault();

    var formData = {
        'add_UserFname': $('#add_UserFname').val(),
        'add_UserLname': $('#add_UserLname').val(),
        'add_UserPosition': $('#add_UserPosition').val(),
        'add_UserSuper': $('#add_UserSuper').val(),
        'add_UserName': $('#add_UserName').val(),
        'add_UserPass': $('#add_UserPass').val()
    };

    //console.log(formData); //DEBUG
    
    var isValid;
    if (formData['add_UserFname'] === '' || formData['add_UserLname'] === '' || formData['add_UserName'] === '' || formData['add_UserPass'] === '') {
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

    //console.log("INPUT VALIDATED " + isValid); //DEBUG
    //console.log(formData); //DEBUG

    $.ajax({
        url: 'query/add_UserExe.php',
        type: 'POST',
        dataType : "json",
        data: formData,
        beforeSend: function() {
            swalLoad = Swal.fire({
                title: 'Loading...',
                html: 'Please wait while your query is being processed.',
                allowOutsideClick: false,
                onBeforeOpen: () => {
                    Swal.showLoading();
                }
            });
        },
        success: function(response) {
            swalLoad.close();
            if (response.res == "success") {
                Swal.fire({
                    icon: "success",
                    title: "Success",
                    text: response.msg + " added.",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                }).then(function() {
                    window.location.href = 'home.php?page=manage-admin';
                });
            } else if (response.res == "exists") {
                Swal.fire({
                    icon: "error",
                    title: "Failed",
                    text: response.msg + " already exists.",
                });
            } else if (response.res == "failed") {
                Swal.fire({
                    icon: "error",
                    title: "Failed",
                    text: "An error occurred while adding User. Please try again.",
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
            swalLoad.close();
            alert('A script error occured. Please try again.');
            console.error(textStatus, errorThrown);
            console.log(jqXHR.responseText);
            location.reload();
        }
    });
});

// manage-admin EDIT 
$(document).on("submit","#editUserFrm" , function(event) {
    event.preventDefault();

    var formData = {
        'edit_UserId': $('#edit_UserId').val(),
        'edit_UserFname': $('#edit_UserFname').val(),
        'edit_UserLname': $('#edit_UserLname').val(),
        'edit_UserPosition': $('#edit_UserPosition').val(),
        'edit_UserSuper': $('#edit_UserSuper').val(),
        'edit_UserName': $('#edit_UserName').val(),
        'edit_UserPass': $('#edit_UserPass').val()
    };

    //console.log(formData); //DEBUG
    
    var isValid;
    if (formData['edit_UserId'] === '' || formData['edit_UserFname'] === '' || formData['edit_UserLname'] === '' || formData['edit_UserName'] === '' || formData['edit_UserPass'] === '') {
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

    //console.log("INPUT VALIDATED " + isValid); //DEBUG
    //console.log(formData); //DEBUG

    $.ajax({
        url: 'query/edit_UserExe.php',
        type: 'POST',
        dataType : "json",
        data: formData,
        beforeSend: function() {
            swalLoad = Swal.fire({
                title: 'Loading...',
                html: 'Please wait while your query is being processed.',
                allowOutsideClick: false,
                onBeforeOpen: () => {
                    Swal.showLoading();
                }
            });
        },
        success: function(response) {
            swalLoad.close();
            if (response.res == "success") {
                Swal.fire({
                    icon: "success",
                    title: "Success",
                    text: response.msg + " updated.",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                }).then(function() {
                    window.location.href = 'home.php?page=manage-admin';
                });
            } else if (response.res == "exists") {
                Swal.fire({
                    icon: "error",
                    title: "Failed",
                    text: response.msg + " already exists.",
                });
            } else if (response.res == "failed") {
                Swal.fire({
                    icon: "error",
                    title: "Failed",
                    text: "An error occurred while updating User. Please try again.",
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
            swalLoad.close();
            alert('A script error occured. Please try again.');
            console.error(textStatus, errorThrown);
            console.log(jqXHR.responseText);
            location.reload();
        }
    });
});

// manage-admin DELETE 
$(document).on("submit","#deleteUserFrm" , function(event) {
    event.preventDefault();

    var formData = {
        'delete_UserId': $('#delete_UserId').val()
    };

    //console.log(formData); //DEBUG
    
    var isValid;
    if (formData['delete_UserId'] === '') {
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

    //console.log("INPUT VALIDATED " + isValid); //DEBUG
    //console.log(formData); //DEBUG

    $.ajax({
        url: 'query/delete_UserExe.php',
        type: 'POST',
        dataType : "json",
        data: formData,
        beforeSend: function() {
            swalLoad = Swal.fire({
                title: 'Loading...',
                html: 'Please wait while your query is being processed.',
                allowOutsideClick: false,
                onBeforeOpen: () => {
                    Swal.showLoading();
                }
            });
        },
        success: function(response) {
            swalLoad.close();
            if (response.res == "success") {
                Swal.fire({
                    icon: "success",
                    title: "Success",
                    text: "User deleted.",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                }).then(function() {
                    window.location.href = 'home.php?page=manage-admin';
                });
            } else if (response.res == "norecord") {
                Swal.fire({
                    icon: "error",
                    title: "Failed",
                    text: "User does not exist.",
                }).then(function() {
                    window.location.href = 'home.php?page=manage-admin';
                });
            } else if (response.res == "failed") {
                Swal.fire({
                    icon: "error",
                    title: "Failed",
                    text: "An error occurred while updating User. Please try again.",
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
            swalLoad.close();
            alert('A script error occured. Please try again.');
            console.error(textStatus, errorThrown);
            console.log(jqXHR.responseText);
            location.reload();
        }
    });
});
/* ########## END ADMIN ########## */