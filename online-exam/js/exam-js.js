
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
//console.log(user); //Debug
return user;
}

function init() {
    //var savedTimeKey = 'countTimer_user' + user + '_exam' + exId;
    var savedTimeKey = 'Debug_TIMER'; //DEBUG
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
        document.getElementById('examAction').value = "time out";
        //$('#submitAnswerFrm').submit();
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
    //localStorage.setItem('countTimer_user' + user + '_exam' + exId, JSON.stringify(currentTime));
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
    if (event.keyCode === 116) { // 116 is for F5 in keyboard
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
    //console.log(user); //Debug
    return exLimit;
}

var display_Limit = fetchDispLimit();

document.addEventListener('DOMContentLoaded', function() {
    //Display Instructions
    stopTimer();
    var exDesc = document.getElementById('exDesc').innerText;
    console.log("Description: " + exDesc); //DEBUG
    Swal.fire({
        title: 'Instructions',
        text: exDesc,
        icon: 'info',
        showCancelButton: false,
        allowOutsideClick: false,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ok'
    }).then((result) => {
        if (result.value) {
            table.page.len(display_Limit).draw();
            startTimer();
            updateDisplay();
        }
    });
    
    //Variable
    const disableBtn = document.getElementById('disablePrevBtn').value;

    //Datatable
    var table = $('.dt-sort').DataTable({
        lengthChange: false,
        pageLength: 0, 
        ordering: false, 
        searching: false, 
        info: false,
        paging: true,
        pagingType: 'simple_modified',
        order: [],
        //responsive: true,
        drawCallback: function() {
          var pageInfo = this.api().page.info();
          $('.current-page').text(pageInfo.page + 1); // Adding 1 to convert zero-based index to 1-based index
          $('.total-pages').text(pageInfo.pages);
  
          // Previous Button
          if (pageInfo.page == 0 || disableBtn == "yes") {
            $('#prev-btn').hide();
          } else {
            $('#prev-btn').show();
          }
  
          // Next Button
          if (pageInfo.page == pageInfo.pages - 1) {
            $('#nxt-btn').hide();
            $('#submit-btn').show();
          } else {
            $('#submit-btn').hide();
            $('#nxt-btn').show();
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
    
    // View Image Modal
    document.querySelectorAll('#viewimg-btn').forEach(function(viewimgbtn) {
        viewimgbtn.addEventListener('click', function() {
            var imageFilename = this.getAttribute('data-view-img');

            var imageUrl = '../uploads/exam_question/' + imageFilename;

            // Update the image source in the modal
            var modalImage = document.querySelector('#mdlViewImage .modal-body img');
            modalImage.src = imageUrl;
            modalImage.alt = 'Image for exam ID ' + imageFilename;
        });
    });

    // Select all radio buttons
    var radioButtons = document.querySelectorAll('#questionsContainer input[type="radio"]');

    // Add event listener to each radio button
    radioButtons.forEach(function(radioButton) {
        radioButton.addEventListener('change', function() {
            // Find the next question
            var nextQuestion = this.closest('.col-md-6').nextElementSibling;
            if (nextQuestion) {
                // Scroll to the next question
                nextQuestion.scrollIntoView({ behavior: 'smooth' });
            }
        });
    });
});




