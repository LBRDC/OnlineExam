function fetchExamId() {
    //const urlParams = new URLSearchParams(window.location.search);
    //const id = urlParams.get('id');
    var id = document.getElementById("exam_id").value;
    id = id ? id : "0"; // If id is null or "0", set it to "0"
    console.log("[SYS] ID = " + id); //DEBUG
    return id;
}

let examCompleted = false;
let camWorking;
let examCheck = fetchExamId();

//Check if exam is completed
var checkData = {
    'check_Id': examCheck
};

$.ajax({
    url: 'query/checkExam.php',
    type: 'POST',
    dataType : "json",
    data: checkData,
    success: function(response) {
        //console.log(response); //DEBUG
        //console.log(checkData); //DEBUG
        if (response.res == "complete") {
            Swal.fire({
                icon: "error",
                title: "Completed",
                text: "You have already completed the exam.",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            }).then(function() {
                window.location.href = 'home.php';
            });
            examCompleted = true;
            return;
        } else if (response.res == "completeCurr") {
            Swal.fire({
                icon: "success",
                title: "Completed",
                text: "You have already completed this test.",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            }).then(function() {
                //window.location.href = 'home.php';
                // Create a form element
                if (response.res == "incomplete" && response.practice_st == 'yes') {
                    // Create a form element
                    var form = document.createElement('form');
                    form.method = 'POST';
                    form.action = 'practice.php';
      
                    // Create an input field for the exam ID
                    var hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = 'fetchid';
                    hiddenInput.id = 'fetchid';
                    hiddenInput.value = response.examId;
      
                    // Append the hidden input to the form
                    form.appendChild(hiddenInput);
      
                    // Append the form to the body (or any other container element)
                    document.body.appendChild(form);
      
                    // Submit the form
                    form.submit();
                } else {
                    // Create a form element
                    var form = document.createElement('form');
                    form.method = 'POST';
                    form.action = 'exam.php';
        
                    // Create an input field for the exam ID
                    var hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = 'fetchid';
                    hiddenInput.id = 'fetchid';
                    hiddenInput.value = response.examId;
        
                    // Append the hidden input to the form
                    form.appendChild(hiddenInput);
        
                    // Append the form to the body (or any other container element)
                    document.body.appendChild(form);
        
                    // Submit the form
                    form.submit();
                }
            });
            examCompleted = true;
            return;
        } else if (response.res == "unknown") {
            Swal.fire({
                icon: "error",
                title: "Unknown Exam",
                text: "Returning to Dashboard.",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            }).then(function() {
                window.location.href = 'home.php';
            });
            examCompleted = true;
            return;
        }
    },
    error: function(jqXHR, textStatus, errorThrown) {
        alert('A script error occured. Please try again.');
        console.error(textStatus, errorThrown);
        console.log(jqXHR.responseText);
        window.location.href = 'home.php';
    }
});

// Check if camera is working
if (sessionStorage.getItem('camWorking') === 'true') {
    console.log("Camera Working");
    camWorking = 'true';
} else if (sessionStorage.getItem('camWorking') === 'disabled') {
    console.log("Camera Disabled");
    camWorking = 'disabled';
} else {
    console.log("Camera Not Working");
    camWorking = 'false';
    Swal.fire({
        icon: "error",
        title: "Camera Access",
        text: "Please test camera before proceeding with exam.",
        showConfirmButton: false,
        timer: 5000,
        timerProgressBar: true,
    }).then(function() {
        window.location.href = 'home.php';
    });
}

//Exam JS
if (!examCompleted && (camWorking == 'true' || camWorking == 'disabled')) {
    // Exam Timer
    var minutes, seconds;
    var timerInterval;
    var instanceSwalNotification;
    var isInternetDownNotifShown = false;
    var exId = fetchExamId();
    var user = fetchUserId();
    var anticheatsts = 'disabled';
    var examSubmitted = false;

    function fetchUserId() {
        const user = document.getElementById('examUser').value;
        return user;
    }

    function init() {
        var savedTimeKey = 'countTimer_user' + user + '_exam' + exId;
        //var savedTimeKey = 'Debug_TIMER'; //DEBUG
        var savedTime = localStorage.getItem(savedTimeKey);
        //console.log(savedTimeKey); //Debug
        if (savedTime) {
        var objLocalStorageTimer = JSON.parse(savedTime);
        minutes = objLocalStorageTimer.minutes;
        seconds = objLocalStorageTimer.seconds;
        } else {
        var timeLimit = $('#timeLimit').val();
        console.log("[SYS] Time Limit: " + timeLimit);
        minutes = parseInt(timeLimit);
        seconds = 0;
        }
    
        startTimer();
        updateDisplay();
    }

    function startTimer() {
        timerInterval = setInterval(updateTimer, 1000);
    }

    function stopTimer() {
        clearInterval(timerInterval);
    }

    function updateTimer() {
        if (!navigator.onLine) {
            stopTimer();
            isInternetDownNotifShown = true;
            anticheatsts = 'disabled';
            instanceSwalNotification = Swal.fire({
            title: 'No Internet Connection',
            text: 'Please check your internet connection.',
            icon: 'question',
            allowOutsideClick: false,
            showConfirmButton: false,
            timer: null
            });
            return;
        } else {
            if (isInternetDownNotifShown) {
            instanceSwalNotification.close();
            isInternetDownNotifShown = false;
            anticheatsts = 'enabled';
            }
        }

        if (minutes === 0 && seconds === 0) {
            document.getElementById('examAction').value = "timeout";
            $('#submitAnswerFrm').submit();
            return;
        }

        if (seconds === 0) {
            seconds = 59;
            minutes--;
        } else {
            seconds--;
        }

        updateDisplay();

        var currentTime = { minutes: minutes, seconds: seconds };
        localStorage.setItem('countTimer_user' + user + '_exam' + exId, JSON.stringify(currentTime));
    }

    function updateDisplay() {
        var timerInput = document.getElementById("disp_clock");
        var timerInputm = document.getElementById("disp_clock_mobile");
        timerInput.value = minutes + ":" + (seconds < 10 ? "0" + seconds : seconds);
        timerInputm.value = minutes + ":" + (seconds < 10 ? "0" + seconds : seconds);
    }
    
    window.onload = init();

    /* OTHER SCRIPTS */
    // Disable Refresh
    document.addEventListener('keydown', function (event) {
        // Prevent F5 key
        if (event.key === 'F5') {
            event.preventDefault();
        }
        // DEBUG
        /*if ((event.ctrlKey || event.metaKey) && event.key === 'r' && !event.shiftKey) {
            event.preventDefault();
        }*/
        // Prevent Keyboard Shortcuts
        if ((event.ctrlKey || event.metaKey) && (event.key === 'r' || (event.key === 'R' && event.shiftKey))) {
            event.preventDefault();
        }
    });

    // Prevent page refresh from close or reload
    window.addEventListener('beforeunload', function (event) {
        //console.log("Allow Exit: " + examSubmitted); //DEBUG
        if (window.location.href.includes("exam.php") && !examSubmitted == true) {
            event.preventDefault();
            event.returnValue = '';
            //examSubmitted = false;
        }
    });

    // Check Internet
    window.addEventListener('online', function () {
        if (isInternetDownNotifShown) {
        startTimer();
        }
    });

    function fetchDispLimit() {
        const exLimit = document.getElementById('examLimit').value;
        return exLimit;
    }


    
    // Function to show the card
    function showCard() {
        document.getElementById('examCard').classList.remove('d-none');
    }

    //Function Camera
    let mediaRecorder;
    async function startRecording() {
        try {
            const stream = await navigator.mediaDevices.getUserMedia({ video: true, audio: true });

            // Specify options for MediaRecorder
            const options = {
                mimeType: 'video/webm; codecs=vp9',
                videoBitsPerSecond: 200000
            };

            // Check if the specified options are supported
            if (!MediaRecorder.isTypeSupported(options.mimeType)) {
                console.error(`The MIME type ${options.mimeType} is not supported.`);
                options.mimeType = 'video/webm'; 
            }
            
            // Start recording after the video stream is ready
            mediaRecorder = new MediaRecorder(stream);
            let recordedChunks = [];

            mediaRecorder.ondataavailable = (e) => {
                if (e.data.size > 0) {
                    recordedChunks.push(e.data);
                    saveRecording(e.data);
                    console.log('Recording pending.');
                }
            };

            mediaRecorder.onstop = () => {
                saveRecording(recordedChunks);
                console.log('Recording stopped.');
            };

            // Handle recording errors
            mediaRecorder.onerror = (e) => {
                console.error('Recording error:', e);
                if (recordedChunks.length > 0) {
                    saveRecording(recordedChunks);
                }
            };

            mediaRecorder.start();
        } catch (err) {
            console.error('Error accessing camera:', err);
            stopTimer();
            anticheatsts = 'disabled';
            swalCamera = Swal.fire({
                title: 'No Camera Access',
                text: 'Camera is required',
                icon: 'info',
                allowOutsideClick: false,
                showConfirmButton: false,
                timer: null
            });
        }
    }

    function stopRecording() {
        if (mediaRecorder && mediaRecorder.state === 'recording') {
            mediaRecorder.stop();
        }
    }

    function saveRecording(chunk) {
        const blob = new Blob([chunk], { type: 'video/webm' });
        const formData = new FormData();
        formData.append('video', blob, 'recorded-video.webm');
        formData.append('ex_id', exId);

        // Send the video file to the server
        fetch('query/uploadVideo.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            console.log('Video saved successfully:', data);
        })
        .catch(error => {
            console.error('Error saving video:', error);
        });
    }

    var display_Limit = fetchDispLimit();

    document.addEventListener('DOMContentLoaded', function() {
        var pgActive = 0;
        var anticheatCnt = 0;
        //Display Instructions
        stopTimer();

        Swal.fire({
            icon: 'warning',
            title: 'Ready',
            text: 'Starting...',
            allowOutsideClick: false,
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        }).then(function() {
            table.page.len(display_Limit).draw();
            startTimer();
            updateDisplay();
            showCard();
            pgActive = 1;
            anticheatsts = 'enabled';
            if (camWorking != 'disabled') {
                startRecording();
            }
        });

        //Anticheat OLD
        /*document.addEventListener("visibilitychange", (event) => {
            if (document.visibilityState != "visible" && anticheatsts == 'enabled') {
                //anticheatCnt++;
                anticheatCnt = 0; // DEBUG
                localStorage.setItem("anticheatCnt", anticheatCnt);
                document.getElementById('examAC').value = anticheatCnt;
            }
            
            if (document.visibilityState != "visible" && pgActive == 1 && anticheatsts == 'enabled') {
                console.log("tab inactive");
                pgActive = 0;
                $.ajax({
                    type: "POST",
                    url: "query/page_Message.php",
                    dataType: "json",
                    success: function(response) {
                        Swal.fire({
                            title: 'WARNING',
                            html: `
                                    Avoid using other tabs or windows while exam is in progress.
                                    <br>
                                    <br>
                                    <i>${response['msg_txt']} -${response['msg_src']}</i>
                                `,
                            icon: 'warning',
                            allowOutsideClick: false,
                        }).then((result) => {
                            if (localStorage.getItem("anticheatCnt") >= 3) {
                                stopTimer();
                                document.getElementById('examAction').value = "cheat";
                                $('#submitAnswerFrm').submit();
                            }
                            pgActive = 1;
                        });
                    }
                });
            }
        });*/

        // Anticheat NEW
        function handleInactivity() {
            if (anticheatsts == 'enabled') {
                anticheatCnt++;
                //anticheatCnt = 0; // DEBUG
                localStorage.setItem("anticheatCnt", anticheatCnt);
                document.getElementById('examAC').value = anticheatCnt;
                
                if (pgActive == 1) {
                    console.log("tab inactive or window out of focus");
                    pgActive = 0;
                    $.ajax({
                        type: "POST",
                        url: "query/page_Message.php",
                        dataType: "json",
                        success: function(response) {
                            Swal.fire({
                                title: 'WARNING',
                                html: `
                                        Avoid using other tabs, windows, or leaving the window while the exam is in progress.
                                        <br>
                                        <br>
                                        <i>${response['msg_txt']} -${response['msg_src']}</i>
                                    `,
                                icon: 'warning',
                                allowOutsideClick: false,
                            }).then((result) => {
                                if (localStorage.getItem("anticheatCnt") >= 3) {
                                    stopTimer();
                                    document.getElementById('examAction').value = "cheat";
                                    $('#submitAnswerFrm').submit();
                                }
                                pgActive = 1;
                            });
                        }
                    });
                }
            }
        }

        // Detect when the document visibility changes (e.g., switching tabs)
        document.addEventListener("visibilitychange", (event) => {
            if (document.visibilityState != "visible") {
                handleInactivity();
            }
        });

        // Detect when the window loses focus (e.g., clicking on taskbar or start menu)
        window.addEventListener("blur", (event) => {
            handleInactivity();
        });

        // Reset the state when the window or tab becomes active again
        window.addEventListener("focus", (event) => {
            pgActive = 1;
        });
        
        //Variable
        const disableBtn = document.getElementById('disablePrevBtn').value;

        //Datatable
        var table = $('.dt-sort').DataTable({
            lengthChange: false,
            pageLength: 1, 
            ordering: false, 
            searching: false, 
            info: false,
            paging: true,
            pagingType: 'simple_modified',
            order: [],
            //responsive: true,
            drawCallback: function() {
                const radioButtons = document.querySelectorAll('.question-container input[type="radio"]');
                radioButtons.forEach(function(radioButton) {
                    radioButton.addEventListener('click', function() {
                        // Find the current question container
                        const currentQuestionContainer = this.closest('.question-container');

                        // Find the next question container
                        const nextQuestionContainer = currentQuestionContainer.nextElementSibling;

                        // Check if there is a next question container
                        if (nextQuestionContainer) {
                            // Calculate the position to scroll to
                            // Get the position of the next question container
                            const nextQuestionPosition = nextQuestionContainer.getBoundingClientRect().top + window.pageYOffset;
                            // Calculate the center position
                            const centerPosition = nextQuestionPosition - (window.innerHeight / 5);

                            // Scroll to the calculated position
                            window.scrollTo({
                                top: centerPosition,
                                behavior: 'smooth'
                            });
                        } else {
                            // Scroll to the bottom of the page
                            window.scrollTo({
                                top: document.body.scrollHeight,
                                behavior: 'smooth'
                            });
                        }
                    });
                });

                var pageInfo = this.api().page.info();
                $('.current-page').text(pageInfo.page + 1);
                $('.total-pages').text(pageInfo.pages);

                // Previous Button
                if (pageInfo.page == 0 || disableBtn == "yes") {
                $('#prev-btn').prop('disabled', true); 
                $('#prev-btn').removeClass('btn-primary').addClass('btn-secondary'); 
                } else {
                $('#prev-btn').prop('disabled', false);
                $('#prev-btn').removeClass('btn-secondary').addClass('btn-primary'); 
                }

                // Next Button
                if (pageInfo.page == pageInfo.pages - 1) {
                $('#nxt-btn').prop('disabled', true); 
                $('#nxt-btn').removeClass('btn-primary').addClass('btn-secondary');
                $('#submit-btn').prop('disabled', false);
                $('#submit-btn').removeClass('btn-secondary').addClass('btn-success');
                } else {
                $('#submit-btn').prop('disabled', true);
                $('#submit-btn').removeClass('btn-success').addClass('btn-secondary');
                $('#nxt-btn').prop('disabled', false); 
                $('#nxt-btn').removeClass('btn-secondary').addClass('btn-primary');
                }    
            }
        });

        $('#prev-btn').click(function() {
            var currentPage = table.page.info().page;
            if (currentPage > 0) {
                table.page(currentPage - 1).draw('page');
            }
        });

        $('#nxt-btn').click(function() {
            var currentPage = table.page.info().page;
            var totalPages = table.page.info().pages;
            if (currentPage < totalPages - 1) {
                table.page(currentPage + 1).draw('page');
            }
        });

        var submitBtn = document.getElementById('submit-btn');
        submitBtn.addEventListener('click', function() {
            document.getElementById('examAction').value = "ontime";
            $('#submitAnswerFrm').submit();
        });
    });


    /* ##### EXAM AJAX ##### */
    // exam SUBMIT
    $(document).on("submit","#submitAnswerFrm" , function(event) {
        event.preventDefault();

        var examAction = $('#examAction').val();
        //console.log("Exam Submitted: " + examSubmitted); //DEBUG

        if (examAction == 'timeout') {
            stopTimer();
            anticheatsts = 'disabled';
            stopRecording();
            localStorage.setItem("anticheatCnt", 0);
            currentTime = { minutes: 0, seconds: 0 };
            localStorage.setItem('countTimer_user' + user + '_exam' + exId, JSON.stringify(currentTime));
            Swal.fire({
                icon: 'warning',
                title: 'Exam Over',
                text: 'You ran out of time...',
                allowOutsideClick: false,
                showConfirmButton: false,
                timer: 10000,
                timerProgressBar: true,
            }).then(function() {
                examSubmitted = true;
                $.post("query/submit_AnswerExe.php", $('#submitAnswerFrm').serialize(), function (data) {
                    var response = JSON.parse(data);
                    if (response.res == "finished") {
                        $.ajax({
                            type: "POST",
                            url: "query/page_Message.php",
                            dataType: "json",
                            success: function(msg) {
                                Swal.fire({
                                    title: 'Finished',
                                    html: `
                                            Congratulations! You have finished all the exams.
                                            <br>
                                            <br>
                                            <i>${msg['msg_txt']} -${msg['msg_src']}</i>
                                        `,
                                    icon: 'success',
                                    allowOutsideClick: false,
                                    showConfirmButton: false,
                                    timer: 10000,
                                    timerProgressBar: true,
                                }).then(function() {
                                    window.location.href = 'home.php';
                                });
                            }
                        });
                    } else if (response.res == "notFinished") {
                        $.ajax({
                            type: "POST",
                            url: "query/page_Message.php",
                            dataType: "json",
                            success: function(msg) {
                                Swal.fire({
                                    title: 'Loading...',
                                    html: `
                                            Proceeding to next exam...
                                            <br>
                                            <br>
                                            <i>${msg['msg_txt']} -${msg['msg_src']}</i>
                                        `,
                                    icon: 'info',
                                    allowOutsideClick: false,
                                    showConfirmButton: false,
                                    timer: 5000,
                                    timerProgressBar: true,
                                }).then(function() {
                                    //window.location.href = 'exam.php?id=' + response.examId;
                                    if (response.practice_st == 'yes') {
                                        // Create a form element
                                        var form = document.createElement('form');
                                        form.method = 'POST';
                                        form.action = 'practice.php';
                          
                                        // Create an input field for the exam ID
                                        var hiddenInput = document.createElement('input');
                                        hiddenInput.type = 'hidden';
                                        hiddenInput.name = 'fetchid';
                                        hiddenInput.id = 'fetchid';
                                        hiddenInput.value = response.examId;
                          
                                        // Append the hidden input to the form
                                        form.appendChild(hiddenInput);
                          
                                        // Append the form to the body (or any other container element)
                                        document.body.appendChild(form);
                          
                                        // Submit the form
                                        form.submit();
                                      } else {
                                        // Create a form element
                                        var form = document.createElement('form');
                                        form.method = 'POST';
                                        form.action = 'exam.php';
                          
                                        // Create an input field for the exam ID
                                        var hiddenInput = document.createElement('input');
                                        hiddenInput.type = 'hidden';
                                        hiddenInput.name = 'fetchid';
                                        hiddenInput.id = 'fetchid';
                                        hiddenInput.value = response.examId;
                          
                                        // Append the hidden input to the form
                                        form.appendChild(hiddenInput);
                          
                                        // Append the form to the body (or any other container element)
                                        document.body.appendChild(form);
                          
                                        // Submit the form
                                        form.submit();
                                      }
                                });
                            }
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
                    localStorage.setItem("anticheatCnt", 0);
                    stopTimer();
                    anticheatsts = 'disabled';
                    stopRecording();
                    examSubmitted = true;
                    currentTime = { minutes: 0, seconds: 0 };
                    localStorage.setItem('countTimer_user' + user + '_exam' + exId, JSON.stringify(currentTime));
                    $.post("query/submit_AnswerExe.php", $('#submitAnswerFrm').serialize(), function (data) {
                        var response = JSON.parse(data);
                        if (response.res == "finished") {
                            $.ajax({
                                type: "POST",
                                url: "query/page_Message.php",
                                dataType: "json",
                                success: function(msg) {
                                    Swal.fire({
                                        title: 'Finished',
                                        html: `
                                                Congratulations! You have finished all the exams.
                                                <br>
                                                <br>
                                                <i>${msg['msg_txt']} -${msg['msg_src']}</i>
                                            `,
                                        icon: 'success',
                                        allowOutsideClick: false,
                                        showConfirmButton: false,
                                        timer: 10000,
                                        timerProgressBar: true,
                                    }).then(function() {
                                        window.location.href = 'home.php';
                                    });
                                }
                            });
                        } else if (response.res == "notFinished") {
                            $.ajax({
                                type: "POST",
                                url: "query/page_Message.php",
                                dataType: "json",
                                success: function(msg) {
                                    Swal.fire({
                                        title: 'Loading...',
                                        html: `
                                                Proceeding to next exam...
                                                <br>
                                                <br>
                                                <i>${msg['msg_txt']} -${msg['msg_src']}</i>
                                            `,
                                        icon: 'info',
                                        allowOutsideClick: false,
                                        showConfirmButton: false,
                                        timer: 5000,
                                        timerProgressBar: true,
                                    }).then(function() {
                                        //window.location.href = 'exam.php?id=' + response.examId;
                                        if (response.practice_st == 'yes') {
                                            // Create a form element
                                            var form = document.createElement('form');
                                            form.method = 'POST';
                                            form.action = 'practice.php';
                                
                                            // Create an input field for the exam ID
                                            var hiddenInput = document.createElement('input');
                                            hiddenInput.type = 'hidden';
                                            hiddenInput.name = 'fetchid';
                                            hiddenInput.id = 'fetchid';
                                            hiddenInput.value = response.examId;
                                
                                            // Append the hidden input to the form
                                            form.appendChild(hiddenInput);
                                
                                            // Append the form to the body (or any other container element)
                                            document.body.appendChild(form);
                                
                                            // Submit the form
                                            form.submit();
                                        } else {
                                            // Create a form element
                                            var form = document.createElement('form');
                                            form.method = 'POST';
                                            form.action = 'exam.php';
                                
                                            // Create an input field for the exam ID
                                            var hiddenInput = document.createElement('input');
                                            hiddenInput.type = 'hidden';
                                            hiddenInput.name = 'fetchid';
                                            hiddenInput.id = 'fetchid';
                                            hiddenInput.value = response.examId;
                                
                                            // Append the hidden input to the form
                                            form.appendChild(hiddenInput);
                                
                                            // Append the form to the body (or any other container element)
                                            document.body.appendChild(form);
                                
                                            // Submit the form
                                            form.submit();
                                        }
                                    });
                                }
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
            stopTimer();
            anticheatsts = 'disabled';
            stopRecording();
            localStorage.setItem("anticheatCnt", 0);
            currentTime = { minutes: 0, seconds: 0 };
            localStorage.setItem('countTimer_user' + user + '_exam' + exId, JSON.stringify(currentTime));
            Swal.fire({
                icon: 'warning',
                title: 'Exam Terminated',
                text: 'System detected cheating...',
                allowOutsideClick: false,
                showConfirmButton: false,
                timer: 10000,
                timerProgressBar: true,
            }).then(function() {
                examSubmitted = true;
                $.post("query/submit_AnswerExe.php", $('#submitAnswerFrm').serialize(), function (data) {
                    var response = JSON.parse(data);
                    if (response.res == "finished") {
                        $.ajax({
                            type: "POST",
                            url: "query/page_Message.php",
                            dataType: "json",
                            success: function(msg) {
                                Swal.fire({
                                    title: 'Finished',
                                    html: `
                                            Congratulations! You have finished all the exams.
                                            <br>
                                            <br>
                                            <i>${msg['msg_txt']} -${msg['msg_src']}</i>
                                        `,
                                    icon: 'success',
                                    allowOutsideClick: false,
                                    showConfirmButton: false,
                                    timer: 10000,
                                    timerProgressBar: true,
                                }).then(function() {
                                    window.location.href = 'home.php';
                                });
                            }
                        });
                    } else if (response.res == "notFinished") {
                        $.ajax({
                            type: "POST",
                            url: "query/page_Message.php",
                            dataType: "json",
                            success: function(msg) {
                                Swal.fire({
                                    title: 'Loading...',
                                    html: `
                                            Proceeding to next exam...
                                            <br>
                                            <br>
                                            <i>${msg['msg_txt']} -${msg['msg_src']}</i>
                                        `,
                                    icon: 'info',
                                    allowOutsideClick: false,
                                    showConfirmButton: false,
                                    timer: 5000,
                                    timerProgressBar: true,
                                }).then(function() {
                                    //window.location.href = 'exam.php?id=' + response.examId;
                                    if (response.practice_st == 'yes') {
                                        // Create a form element
                                        var form = document.createElement('form');
                                        form.method = 'POST';
                                        form.action = 'practice.php';
                            
                                        // Create an input field for the exam ID
                                        var hiddenInput = document.createElement('input');
                                        hiddenInput.type = 'hidden';
                                        hiddenInput.name = 'fetchid';
                                        hiddenInput.id = 'fetchid';
                                        hiddenInput.value = response.examId;
                            
                                        // Append the hidden input to the form
                                        form.appendChild(hiddenInput);
                            
                                        // Append the form to the body (or any other container element)
                                        document.body.appendChild(form);
                            
                                        // Submit the form
                                        form.submit();
                                    } else {
                                        // Create a form element
                                        var form = document.createElement('form');
                                        form.method = 'POST';
                                        form.action = 'exam.php';
                            
                                        // Create an input field for the exam ID
                                        var hiddenInput = document.createElement('input');
                                        hiddenInput.type = 'hidden';
                                        hiddenInput.name = 'fetchid';
                                        hiddenInput.id = 'fetchid';
                                        hiddenInput.value = response.examId;
                            
                                        // Append the hidden input to the form
                                        form.appendChild(hiddenInput);
                            
                                        // Append the form to the body (or any other container element)
                                        document.body.appendChild(form);
                            
                                        // Submit the form
                                        form.submit();
                                    }
                                });
                            }
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
    });
    /* ##### END EXAM AJAX ##### */
}