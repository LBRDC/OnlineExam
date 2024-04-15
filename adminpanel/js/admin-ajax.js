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
        url: 'query/disable_ClusterExe.php',
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
        url: 'query/enable_ClusterExe.php',
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


// manage-exam-edit EDIT
$(document).on("submit","#editExamFrm" , function(event) {
    event.preventDefault();

    var formData = {
        'edit_ExamId': $('#edit_ExamId').val(),
        'edit_ExamTitle': $('#edit_ExamTitle').val(),
        'edit_ExamDesc': $('#edit_ExamDesc').val(),
        'edit_ExamCluster': $('#edit_ExamCluster').val(), 
        'edit_ExamQuestLimit': $('#edit_ExamQuestLimit').val(),
        'edit_ExamTimeLimit': $('#edit_ExamTimeLimit').val(),
        'edit_ExamRandom': $('#edit_ExamRandom').is(':checked') ? 1 : 0, // Check if the checkbox is checked
        'edit_ExamNoPrev': $('#edit_ExamNoPrev').is(':checked') ? 1 : 0, // Check if the checkbox is checked
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