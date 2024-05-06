/*
HTTPS/SSL Required
*/
document.getElementById('startRecording').addEventListener('click', async () => {
    try {
        const stream = await navigator.mediaDevices.getUserMedia({ video: true });
        const video = document.getElementById('preview');
        video.srcObject = stream;

        // Start recording after the video stream is ready
        const mediaRecorder = new MediaRecorder(stream);
        let recordedChunks = [];

        mediaRecorder.ondataavailable = (e) => {
            if (e.data.size > 0) {
                recordedChunks.push(e.data);
            }
        };

        mediaRecorder.onstop = () => {
            const blob = new Blob(recordedChunks, { type: 'video/webm' });
            const url = URL.createObjectURL(blob);
            const link = document.createElement('a');
            link.href = url;
            link.download = 'recorded_video.webm';
            link.click();
        };

        mediaRecorder.start();

     
        setTimeout(() => {
            mediaRecorder.stop();
        }, 10000);
    } catch (err) {
        console.error('Error accessing the camera:', err);
    }
});