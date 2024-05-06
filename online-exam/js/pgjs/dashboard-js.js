//Check Session
document.addEventListener('DOMContentLoaded', function() {
  // Check if the reminder has been shown in this session
  if (!sessionStorage.getItem('reminderShown')) {
    Swal.fire({
        icon: "warning",
        title: "NOTE",
        text: "Please Read all reminders before proceeding with the exam.",
    }).then(() => {
        sessionStorage.setItem('reminderShown', 'true');
    });
  }

  document.getElementById('strt-btn').addEventListener('click', function() {
    var examId = this.getAttribute('data-exam-id');
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
        window.location.href = "exam.php?id=" + examId;
      }
    });
  });

  //Camera Test
  document.getElementById('startTest').addEventListener('click', async () => {
    // Disable the Test button
    document.getElementById('startTest').disabled = true;
    
    // Reset progress bar and result
    const progressBar = document.querySelector('.progress-bar');
    progressBar.style.width = '0%';
    progressBar.setAttribute('aria-valuenow', '0');
    document.getElementById('progressBarContainer').classList.remove('d-none');
    document.getElementById('result').textContent = '';
    document.getElementById('result').classList.remove('text-success', 'text-danger');
    
    try {
        // Show the progress bar
        document.getElementById('progressBarContainer').classList.remove('d-none');

        // Request access to the camera
        const stream = await navigator.mediaDevices.getUserMedia({ video: true });
        const video = document.getElementById('preview');
        // Set the video source to the stream
        video.srcObject = stream;
        // Play the video automatically
        video.play();
        // Add event listener to stop the stream when the video is paused or ended
        video.addEventListener('pause', () => {
            stream.getTracks().forEach(track => track.stop());
        });
        // Stop the stream after 10 seconds
        setTimeout(() => {
            stream.getTracks().forEach(track => track.stop());
            video.pause(); // Pause the video element
            document.getElementById('progressBarContainer').classList.add('d-none');
            // Show result
            document.getElementById('result').textContent = 'WORKING';
            document.getElementById('result').classList.remove('text-danger');
            document.getElementById('result').classList.add('text-success');
            // Re-enable the Test button
            document.getElementById('startTest').disabled = false;
        }, 10000); // 10000 milliseconds = 10 seconds

        // Update progress bar
        const progressBar = document.querySelector('.progress-bar');
        let progress = 0;
        const interval = setInterval(() => {
            progress += 1;
            progressBar.style.width = `${progress}%`;
            progressBar.setAttribute('aria-valuenow', progress);
            if (progress >= 100) {
                clearInterval(interval);
            }
        }, 100); // Update every second
    } catch (err) {
        console.error('Error accessing the camera:', err);
        // Hide the progress bar
        document.getElementById('progressBarContainer').classList.add('d-none');
        // Show result
        document.getElementById('result').textContent = 'NOT WORKING';
        document.getElementById('result').classList.remove('text-success');
        document.getElementById('result').classList.add('text-danger');
        // Re-enable the Test button
        document.getElementById('startTest').disabled = false;
        // Optionally, inform the user that camera access is required
        //alert('Camera access is required to test the camera.');
        Swal.fire({
          icon: "warning",
          title: "NOTE",
          text: "Please Enable the Camera Access before proceeding with the exam.",
        })
    }
  });
});