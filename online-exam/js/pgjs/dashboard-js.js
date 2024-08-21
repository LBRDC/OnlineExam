let mediaRecorder;
function stopRecording() {
  if (mediaRecorder && mediaRecorder.state === 'recording') {
      mediaRecorder.stop();
  }
}

document.addEventListener('DOMContentLoaded', function() {
  // Check if the reminder has been shown in this session
  if (!sessionStorage.getItem('reminderShown')) {
    console.log("Reminder not shown yet");
    Swal.fire({
        icon: "warning",
        title: "NOTE",
        text: "Please Read all reminders before proceeding with the exam.",
    }).then(() => {
        //sessionStorage.setItem('reminderShown', 'true');
        //console.log("Reminder shown");
        Swal.fire({
          icon: "info",
          allowOutsideClick: false,
          showCancelButton: true,
          confirmButtonColor: '#008000',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Agree',
          cancelButtonText: 'Decline',
          width: 800,
          title: "Data Privacy Consent",
          html: ` <div class="m-3 text-justify">
By selecting agree in this consent form, I (as “Data Subject”) grant my
free, voluntary and unconditional consent, without need of notice, to the collection
and processing of all Personal Data and Personal Information (as defined in the
sections below), and account or transaction information or records
(collectively, the "Information") relating to me
disclosed/transmitted by me in person to the human resource information
database system of the Land Bank of the Philippines Resource and Development
Corporation (LBRDC) and/or any of its authorized agent/s or representative/s as
Information controller, by whatever means in accordance with Republic Act (R.A.)
10173, otherwise known as the “Data Privacy Act of 2012” of the Republic of the
Philippines, including its Implementing Rules and Regulations (IRR) as well as
all other guidelines and issuances by the National Privacy Commission (NPC).
<br>
<br>
<b>Section 1: I hereby acknowledge that for the
purpose of my inclusion within the LBRDC recruitment and applicant pooling portal, I
consent with the collection of the following Personal Data and Personal
Information:</b>
<br>
<br>
a) Name;<br>
b) Sex;<br>
c) Birthdate;<br>
d) E-Mail Address;<br>
<br>
<b>Section 2: I understand that in compliance with the
Data Privacy Act (R.A. No. 10173), Land Bank of the Philippines Resource
Development Corporation (LBRDC) must keep my information private and
confidential and will retain my information solely for the fulfillment of the
aforementioned purposes:</b>
<br>
<br>
a) Screening for vacant job positions;<br>
b) Re-profiling and re-classification of my
application to other vacant job positions;<br>
<br>
<b>Section 3: I understand and consent that my personal
data and personal information may also be used for the following purposes:</b>
<br>
<br>
a) Inclusion in the pool of LBRDC Database of applicants for a maximum of one (1)
year so that I can be reclassified for other vacancies that I may be qualified
for;<br>
b) Reference for the recruitment process that I will undergo which includes
background investigation and legitimate institutional interests required or
permitted by law if I choose to pursue my application upon my selection;<br>
c) Reference for the Human Resource and Administrative personnel concerned with my
application to verify the truthfulness of my qualifications;<br>
d) Inclusion of my personal data and personal information for statistical purposes
in researches/studies/evaluation conducted by LBRDC and/or its outsourced
service provider related to human resource recruitment; wherein it is limited
to my age, address, educational attainment, and position applied for and, will
not compromise my identity and personal security;<br>
<br>
<b>Section 4: I further acknowledge that without any legal
requirement unless otherwise required or permitted by law, I can withdraw my data
privacy consent and request for the deletion of my personal data and personal
information.</b>
<br>
<br>
<b>Section 5: I hereby grant my free, voluntary and
unconditional consent, without need of notice, to the recording, use, storage,
consultation, updating, blocking, erasure, destruction, disclosure and
processing of my Personal Data and Personal Information where a legitimate
educational or institutional interest exists in its determination as required
or permitted by law.</b>
<br>
<br>
<b>Section 6: I hereby agree that any issue that may arise
in connection with the use, disclosure or processing of my Personal Data and
Personal Information will be settled amicably with LBRDC before resorting to
the appropriate or proper body, tribunal or court. </b>
          </div>`,
        }).then((result) => {
            if (result.dismiss === Swal.DismissReason.cancel) {
              window.location.href = "query/logoutExe.php";
            } else {
              sessionStorage.setItem('reminderShown', 'true');
              console.log("Reminder shown");
            }
        });
    });
  } else {
    console.log("Reminder already shown");
  }

  document.getElementById('strt-btn').addEventListener('click', function() {
    var examId = this.getAttribute('data-exam-id');
    var disabledCam = this.getAttribute('data-exam-disablecam');

    if (disabledCam === 'yes') {
      sessionStorage.setItem('camWorking', 'disabled');
    }

    Swal.fire({
      title: 'Are you sure?',
      text: 'You want to take the exam now? Timer will start automatically.',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, start now!'
    }).then((result) => {
      if (result.value) {
        stopRecording();
        //window.location.href = "exam.php?id=" + examId;

        var checkData = {
          'check_Id': examId
        };

        //ajax query/checkExam.php
        $.ajax({
          url: 'query/checkExam.php',
          type: 'POST',
          dataType : "json",
          data: checkData,
          success: function(response) {
            //console.log(response); // DEBUG
            //console.log(checkData); // DEBUG
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
              return;
            } else if (response.res == "unknown") {
              Swal.fire({
                  icon: "error",
                  title: "Unknown Exam",
                  text: "Exam Not Found.",
                  showConfirmButton: false,
                  timer: 3000,
                  timerProgressBar: true,
              }).then(function() {
                  window.location.href = 'home.php';
              });
              return;
            }
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
          },
          error: function(jqXHR, textStatus, errorThrown) {
              alert('A script error occured. Please try again.');
              console.error(textStatus, errorThrown);
              console.log(jqXHR.responseText);
              window.location.href = 'home.php';
          }
        });
      }
    });
  });

  //Camera Test
  document.getElementById('startTest').addEventListener('click', async () => {
    document.getElementById('startTest').disabled = true;
    
    // Reset result
    const progressBar = document.querySelector('.progress-bar');
    progressBar.style.width = '0%';
    progressBar.setAttribute('aria-valuenow', '0');
    document.getElementById('progressBarContainer').classList.remove('d-none');
    document.getElementById('result').textContent = '';
    document.getElementById('result').classList.remove('text-success', 'text-danger');
    
    try {
      document.getElementById('progressBarContainer').classList.remove('d-none');

      // Request access to the camera
      const stream = await navigator.mediaDevices.getUserMedia({ video: true, audio: true });
      const video = document.getElementById('preview');
      video.srcObject = stream;
      video.play();
      // Add event listener to stop the stream when the video is paused or ended
      video.addEventListener('pause', () => {
          stream.getTracks().forEach(track => track.stop());
      });
      // Update progress bar
      const progressBar = document.querySelector('.progress-bar');
      let progress = 0;
      const interval = setInterval(() => {
          progress += 1;
          progressBar.style.width = `${progress}%`;
          progressBar.setAttribute('aria-valuenow', progress);
          if (progress >= 100) {
              clearInterval(interval);
              // Stop stream after 10 seconds
              document.getElementById('result').textContent = 'WORKING';
              document.getElementById('result').classList.remove('text-danger');
              document.getElementById('result').classList.add('text-success');
              sessionStorage.setItem('camWorking', 'true');
              // Hide progress bar after 3 seconds
              setTimeout(() => {document.getElementById('progressBarContainer').classList.add('d-none'); }, 3000);
              $('#strt-btn').prop('disabled', false);
          }
      }, 100);
    } catch (err) {
      console.error('Error accessing the camera:', err);
      // Show result
      document.getElementById('progressBarContainer').classList.add('d-none');
      document.getElementById('result').textContent = err;
      document.getElementById('result').classList.remove('text-success');
      document.getElementById('result').classList.add('text-danger');
      document.getElementById('startTest').disabled = false;
      sessionStorage.setItem('camWorking', 'false');
      $('#strt-btn').prop('disabled', true);
      Swal.fire({
        icon: "warning",
        title: "NOTE",
        text: "Webcam access is required before proceeding with exam.",
      })
    }
  });
});

