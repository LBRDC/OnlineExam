
// Exam Timer
var minutes, seconds;
var timerInterval;
var instanceSwalNotification;
var isInternetDownNotifShown = false;
var exId = fetchExamId();
var user = fetchUserId();

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
// Disable Refresh Key (F5)
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



function fetchDispLimit() {
    const exLimit = document.getElementById('examLimit').value;
    return exLimit;
}

// Function to show the card
function showCard() {
    document.getElementById('examCard').classList.remove('d-none');
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
        }
    });

    //Anticheat
    document.addEventListener("visibilitychange", (event) => {
        if (document.visibilityState != "visible" && pgActive == 1 && anticheatCnt < 3) {
          console.log("tab inactive");
          pgActive = 0;
          anticheatCnt++;
          Swal.fire({
            title: 'WARNING',
            //text: 'Avoid using other tabs or windows while exam is in progress.',
            html: `
                    Avoid using other tabs or windows while exam is in progress.
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
