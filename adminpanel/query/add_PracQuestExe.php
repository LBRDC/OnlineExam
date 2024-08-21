<?php 
//DB Connection
include("../../conn.php");

//Variables
$add_PracExamId = isset($_POST['add_PracExamId']) ? $_POST['add_PracExamId'] : '';
$add_Practice = isset($_POST['add_Practice']) ? $_POST['add_Practice'] : '';
$add_PracCh1 = isset($_POST['add_PracCh1']) ? $_POST['add_PracCh1'] : '';
$add_PracCh2 = isset($_POST['add_PracCh2']) ? $_POST['add_PracCh2'] : '';
$add_PracCh3 = isset($_POST['add_PracCh3']) ? $_POST['add_PracCh3'] : '';
$add_PracCh4 = isset($_POST['add_PracCh4']) ? $_POST['add_PracCh4'] : '';
$add_PracCh5 = isset($_POST['add_PracCh5']) ? $_POST['add_PracCh5'] : '';
$add_PracCh6 = isset($_POST['add_PracCh6']) ? $_POST['add_PracCh6'] : '';
$add_PracCh7 = isset($_POST['add_PracCh7']) ? $_POST['add_PracCh7'] : '';
$add_PracCh8 = isset($_POST['add_PracCh8']) ? $_POST['add_PracCh8'] : '';
$add_PracCh9 = isset($_POST['add_PracCh9']) ? $_POST['add_PracCh9'] : '';
$add_PracCh10 = isset($_POST['add_PracCh10']) ? $_POST['add_PracCh10'] : '';
$add_PracAns = isset($_POST['add_PracAns']) ? $_POST['add_PracAns'] : '';

// Check if variables contain values
if($add_PracExamId == '' || $add_Practice == '' || $add_PracAns == '') {
    $res = array("res" => "incomplete" , "msg" => $add_PracExamId . $add_Practice . $add_PracAns);
    echo json_encode($res);
    exit();
}

$stmt1 = $conn->prepare("SELECT * FROM exam_tbl WHERE ex_id = :add_PracExamId");
$stmt1->bindParam(':add_PracExamId', $add_PracExamId);
$stmt1->execute();

//assign ex_title
$ex_title = $stmt1->fetch(PDO::FETCH_ASSOC)['ex_title'];

// Check if the examid exists
if($stmt1->rowCount() == 0){
    $res = array("res" => "norecord", "msg" => $add_PracExamId);
    echo json_encode($res);
    exit();
}

//Prepare File
if (isset($_FILES['add_PracImg']) && $_FILES['add_PracImg']['error'] == UPLOAD_ERR_OK) {
    // Get the file's MIME type
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($_FILES['add_PracImg']['tmp_name']);

    // Check if the file is an image
    $allowed_mime_types = ['image/png', 'image/jpeg', 'image/webp'];
    if (in_array($mime, $allowed_mime_types)) {
        // Define upload directory
        $upload_dir = '../../uploads/exam_question/'; 

        // Use the original filename and append the exam ID
        $filename = pathinfo($_FILES['add_PracImg']['name'], PATHINFO_FILENAME);
        $extension = pathinfo($_FILES['add_PracImg']['name'], PATHINFO_EXTENSION);
        $new_filename = 'id_' . $add_PracExamId . '-' . $filename . '.' . $extension;

        // Define File Name with original filename and appended exam ID
        $upload_file = $upload_dir . $new_filename;

        // Check if file already exists
        $i = 2;
        while (file_exists($upload_file)) {
            $new_filename = 'id_' . $add_PracExamId . '-' . $filename . '(' . $i . ').' . $extension;
            $upload_file = $upload_dir . $new_filename;
            $i++;
        }

        $add_PracImg = $new_filename;
    } 
} else {
    $add_PracImg = '';
}

// Prepare and execute the second statement to insert the new cluster
$stmt2 = $conn->prepare("INSERT INTO exam_practice_tbl (ex_id, prac_image, prac_question, prac_ch1, prac_ch2, prac_ch3, prac_ch4, prac_ch5, prac_ch6, prac_ch7, prac_ch8, prac_ch9, prac_ch10, prqstn_answer) VALUES (:add_PracExamId, :add_PracImg, :add_Practice, :add_PracCh1, :add_PracCh2, :add_PracCh3, :add_PracCh4, :add_PracCh5, :add_PracCh6, :add_PracCh7, :add_PracCh8, :add_PracCh9, :add_PracCh10, :add_PracAns)");
$stmt2->bindParam(':add_PracExamId', $add_PracExamId);
$stmt2->bindParam(':add_PracImg', $add_PracImg);
$stmt2->bindParam(':add_Practice', $add_Practice);
$stmt2->bindParam(':add_PracCh1', $add_PracCh1);
$stmt2->bindParam(':add_PracCh2', $add_PracCh2);
$stmt2->bindParam(':add_PracCh3', $add_PracCh3);
$stmt2->bindParam(':add_PracCh4', $add_PracCh4);
$stmt2->bindParam(':add_PracCh5', $add_PracCh5);
$stmt2->bindParam(':add_PracCh6', $add_PracCh6);
$stmt2->bindParam(':add_PracCh7', $add_PracCh7);
$stmt2->bindParam(':add_PracCh8', $add_PracCh8);
$stmt2->bindParam(':add_PracCh9', $add_PracCh9);
$stmt2->bindParam(':add_PracCh10', $add_PracCh10);
$stmt2->bindParam(':add_PracAns', $add_PracAns);

// Execute the statement and check if it was successful
if($stmt2->execute()) {
    //Upload File
    if (!empty($add_PracImg)) {
        move_uploaded_file($_FILES['add_PracImg']['tmp_name'], $upload_file);
    }
    $res = array("res" => "success", "msg" => $ex_title);
} else {
    $res = array("res" => "failed", "msg" => $ex_title);
}

echo json_encode($res);
exit();
