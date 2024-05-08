<?php
session_start();
include("../../conn.php");

// Check if the form data is set
if (isset($_FILES['video'])) {
    if(isset($_SESSION['ex_user']['exmne_lname']) && isset($_SESSION['ex_user']['exmne_fname']) && isset($_SESSION['ex_user']['exmne_id'])) {
        $exmne_name = $_SESSION['ex_user']['exmne_lname'] . '-' . $_SESSION['ex_user']['exmne_fname'];
        $exmne_id = $_SESSION['ex_user']['exmne_id'];
    } else {
        $exmne_name = 'null';
    }
    if(isset($_POST['ex_id'])) {
        $ex_id = $_POST['ex_id'];
    }
    
    // Define the upload directory and the file name
    $uploadDir = '../../uploads/recordings/';
    $fileName = basename($_FILES['video']['name']);
    $baseName = 'ID-' . $ex_id . '_' . $exmne_name . '_' . $fileName;
    $uploadFile = $uploadDir . $baseName;

    // Check if the file already exists
    $counter = 1;
    while (file_exists($uploadFile)) {
        // Append a number to the filename
        $uploadFile = $uploadDir . $baseName . '(' . $counter . ')';
        $counter++;
    }

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