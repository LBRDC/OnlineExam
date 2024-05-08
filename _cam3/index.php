<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Webcam Recording</title>
</head>
<body>
<video id="webcamVideo" autoplay playsinline></video>
<button id="startRecording">Start Recording</button>
<button id="stopRecording" disabled>Stop Recording</button>
<a id="downloadLink" href="#" download="RecordedVideo.webm">Download Video</a>

</body>
</html>

<script src="RecordRTC.min.js"></script>
<script>
    let mediaRecorder;
    let recordedBlobs;

    const video = document.querySelector('video');
    const startButton = document.getElementById('startRecording');
    const stopButton = document.getElementById('stopRecording');
    const downloadLink = document.getElementById('downloadLink');

    startButton.addEventListener('click', function() {
        startRecording();
    });

    stopButton.addEventListener('click', function() {
        stopRecording();
    });

    function startRecording() {
        startButton.disabled = true;
        stopButton.disabled = false;

        navigator.mediaDevices.getUserMedia({
            video: true,
            audio: true
        }).then(function(stream) {
            video.srcObject = stream;
            mediaRecorder = new MediaRecorder(stream);
            recordedBlobs = [];

            mediaRecorder.ondataavailable = function(event) {
                if (event.data && event.data.size > 0) {
                    recordedBlobs.push(event.data);
                }
            };

            mediaRecorder.start(10); // collect 10ms of data
        }).catch(function(err) {
            console.error('Error accessing media devices.', err);
        });
    }

    function stopRecording() {
        mediaRecorder.stop();
        stopButton.disabled = true;

        const blob = new Blob(recordedBlobs, {
            type: 'video/webm'
        });
        const url = window.URL.createObjectURL(blob);
        downloadLink.href = url;
        downloadLink.download = 'RecordedVideo.webm';
        downloadLink.style.display = 'block';
    }
</script>
