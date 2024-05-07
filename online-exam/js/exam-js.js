let examCompleted = false;
let camWorking = false;
//Check if exam is completed
$.ajax({
    url: 'query/checkExam.php',
    type: 'POST',
    dataType : "json",
    success: function(response) {
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
        }
    },
    error: function(jqXHR, textStatus, errorThrown) {
        alert('A script error occured. Please try again.');
        console.error(textStatus, errorThrown);
        console.log(jqXHR.responseText);
        window.location.href = 'home.php';
    }
});

//Check if camera is working
if (sessionStorage.getItem('camWorking') === 'true') {
    console.log("Camera Working");
    camWorking = true;
} else {
    camWorking = false;
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
if (!examCompleted && camWorking) {
    // Exam Timer
    var minutes, seconds;
    var timerInterval;
    var instanceSwalNotification;
    var isInternetDownNotifShown = false;
    var exId = fetchExamId();
    var user = fetchUserId();
    var anticheatsts = 'disabled';
    var examSubmitted = false;

    function fetchExamId() {
        const urlParams = new URLSearchParams(window.location.search);
        const id = urlParams.get('id');
        return id;
    }

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
            stopTimer();
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

    //Other Scripts
    // Disable Refresh
    document.addEventListener('keydown', function (event) {
        // Prevent F5 key
        if (event.key === 'F5') {
            event.preventDefault();
        }
        // Prevent Ctrl+R or Cmd+R (Mac)
        if ((event.ctrlKey || event.metaKey) && event.key === 'r') {
            event.preventDefault();
        }
    });

    // Check Internet
    window.addEventListener('online', function () {
        if (isInternetDownNotifShown) {
        startTimer();
        }
    });

    // Prevent Refresh/Unload Page
    window.addEventListener('beforeunload', function (event) {
        //console.log("Allow Exit: " + examSubmitted); //DEBUG
        if (window.location.href.includes("exam.php?id=") && !examSubmitted == true) {
            event.preventDefault();
            event.returnValue = '';
            //examSubmitted = false;
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
            const stream = await navigator.mediaDevices.getUserMedia({ video: true });

            // Specify options for the MediaRecorder
            const options = {
                mimeType: 'video/webm; codecs=vp9', // Use VP9 codec for better compression
                videoBitsPerSecond: 250000 // Lower bitrate for smaller file size
            };

            // Check if the specified options are supported
            if (!MediaRecorder.isTypeSupported(options.mimeType)) {
                console.error(`The MIME type ${options.mimeType} is not supported.`);
                options.mimeType = 'video/webm'; // Fallback to default codec
            }
            
            // Start recording after the video stream is ready
            mediaRecorder = new MediaRecorder(stream);
            let recordedChunks = [];

            mediaRecorder.ondataavailable = (e) => {
                if (e.data.size > 0) {
                    recordedChunks.push(e.data);
                }
            };

            mediaRecorder.onstop = () => {
                saveRecording(recordedChunks);
            };

            // Handle recording errors
            mediaRecorder.onerror = (e) => {
                console.error('Recording error:', e);
                // Attempt to save the recording even if an error occurs
                if (recordedChunks.length > 0) {
                    saveRecording(recordedChunks);
                }
            };

            mediaRecorder.start();

            //setTimeout(() => {
            //    mediaRecorder.stop();
            //}, 5000);
        } catch (err) {
            console.error('Error accessing camera:', err);
        }
    }

    function stopRecording() {
        if (mediaRecorder && mediaRecorder.state === 'recording') {
            mediaRecorder.stop();
        }
    }

    function saveRecording(recordedChunks) {
        const blob = new Blob(recordedChunks, { type: 'video/webm' });
        const formData = new FormData();
        formData.append('video', blob, 'recorded-video.webm');
        //append user id
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
        var exDesc = document.getElementById('exDesc').innerText;
        Swal.fire({
            title: 'Instructions',
            text: exDesc,
            icon: 'info',
            allowOutsideClick: false,
        }).then((result) => {
            if (result.value) {
                table.page.len(display_Limit).draw();
                startTimer();
                updateDisplay();
                showCard();
                pgActive = 1;
                anticheatsts = 'enabled';
                startRecording();
            }
        });

        //Anticheat
        document.addEventListener("visibilitychange", (event) => {
            if (document.visibilityState != "visible" && anticheatsts == 'enabled') {
                anticheatCnt++;
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
                                if (anticheatCnt >= 3) {
                                    stopTimer();
                                    document.getElementById('examAction').value = "cheat";
                                    $('#submitAnswerFrm').submit();
                                }
                                pgActive = 1;
                        });
                    }
                });
            }
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
        });
    });


    // exam SUBMIT
    $(document).on("submit","#submitAnswerFrm" , function(event) {
        event.preventDefault();
        anticheatsts = 'disabled';
        stopRecording();
        /*
            If time out = Show time out Alert
            If submitted = Show Processing

            Fetch Inputs
            Ajax Submit_AnswerExe

            If res finished = h.ref home.php
            If res nextexam = h.ref exam.php?id=
        */

        var examAction = $('#examAction').val();
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
                examSubmitted = true;
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
                                    window.location.href = 'exam.php?id=' + response.examId;
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
                    examSubmitted = true;
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
                                        window.location.href = 'exam.php?id=' + response.examId;
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
                                    window.location.href = 'exam.php?id=' + response.examId;
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
}