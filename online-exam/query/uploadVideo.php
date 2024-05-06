<?php
session_start();

// Check if the form data is set
if (isset($_FILES['video'])) {
    // Define the upload directory and the file name
    $uploadDir = '../../uploads/recordings/';
    $fileName = basename($_FILES['video']['name']);
    $uploadFile = $uploadDir . $fileName;

    // Check if the file was uploaded successfully
    if (move_uploaded_file($_FILES['video']['tmp_name'], $uploadFile)) {
        // File uploaded successfully
        echo json_encode(['status' => 'success', 'message' => 'Video uploaded successfully.']);
    } else {
        // File upload failed
        echo json_encode(['status' => 'error', 'message' => 'Failed to upload video.']);
    }
} else {
    // No file was uploaded
    echo json_encode(['status' => 'error', 'message' => 'No file was uploaded.']);
}