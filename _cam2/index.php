<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Webcam Recorder</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="text-center my-4">Webcam Recorder</h1>
        <video id="webcam" autoplay playsinline></video>
        <div class="text-center">
            <button id="startRecording" class="btn btn-primary mx-2">Start Recording</button>
            <button id="stopRecording" class="btn btn-danger mx-2" disabled>Stop Recording</button>
            <a id="downloadLink" href="#" class="btn btn-success mx-2" download="recorded.webm">Download</a>
        </div>
    </div>

    <!-- Include Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
    <script src="camera.js"></script>
</body>
</html>
