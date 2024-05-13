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
        sessionStorage.setItem('reminderShown', 'true');
        console.log("Reminder shown");
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
        window.location.href = "exam.php?id=" + examId;
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