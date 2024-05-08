document.addEventListener('DOMContentLoaded', function() {
    const webcamElement = document.getElementById('webcam');
    const startRecordingButton = document.getElementById('startRecording');
    const stopRecordingButton = document.getElementById('stopRecording');
    const downloadLink = document.getElementById('downloadLink');

    let mediaRecorder;
    let recordedChunks = [];

    // Access the webcam
    navigator.mediaDevices.getUserMedia({ video: true, audio: true })
        .then(function(stream) {
            webcamElement.srcObject = stream;
        })
        .catch(function(err) {
            console.error('An error occurred: ' + err);
        });

    startRecordingButton.addEventListener('click', function() {
        startRecordingButton.disabled = true;
        stopRecordingButton.disabled = false;

        const mediaStream = webcamElement.srcObject;
        mediaRecorder = new MediaRecorder(mediaStream);
        mediaRecorder.start();

        mediaRecorder.ondataavailable = function(e) {
            if (e.data.size > 0) {
                recordedChunks.push(e.data);
            }
        };

        mediaRecorder.onstop = function() {
            const blob = new Blob(recordedChunks, {
                type: 'video/mp4'
            });
            downloadLink.href = URL.createObjectURL(blob);
            downloadLink.download = 'recorded.mp4';
        };
    });

    stopRecordingButton.addEventListener('click', function() {
        mediaRecorder.stop();
        startRecordingButton.disabled = false;
        stopRecordingButton.disabled = true;
    });
});
