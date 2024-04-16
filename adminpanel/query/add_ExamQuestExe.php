<?php 
//DB Connection
include("../../conn.php");

//Variables
$add_QstnExamId = isset($_POST['add_QstnExamId']) ? $_POST['add_QstnExamId'] : '';
$add_Question = isset($_POST['add_Question']) ? $_POST['add_Question'] : '';
$add_QstnCh1 = isset($_POST['add_QstnCh1']) ? $_POST['add_QstnCh1'] : '';
$add_QstnCh2 = isset($_POST['add_QstnCh2']) ? $_POST['add_QstnCh2'] : '';
$add_QstnCh3 = isset($_POST['add_QstnCh3']) ? $_POST['add_QstnCh3'] : '';
$add_QstnCh4 = isset($_POST['add_QstnCh4']) ? $_POST['add_QstnCh4'] : '';
$add_QstnCh5 = isset($_POST['add_QstnCh5']) ? $_POST['add_QstnCh5'] : '';
$add_QstnCh6 = isset($_POST['add_QstnCh6']) ? $_POST['add_QstnCh6'] : '';
$add_QstnCh7 = isset($_POST['add_QstnCh7']) ? $_POST['add_QstnCh7'] : '';
$add_QstnCh8 = isset($_POST['add_QstnCh8']) ? $_POST['add_QstnCh8'] : '';
$add_QstnCh9 = isset($_POST['add_QstnCh9']) ? $_POST['add_QstnCh9'] : '';
$add_QstnCh10 = isset($_POST['add_QstnCh10']) ? $_POST['add_QstnCh10'] : '';
$add_QstnAns = isset($_POST['add_QstnAns']) ? $_POST['add_QstnAns'] : '';

// Check if variables contain values
if(empty($add_QstnExamId) || empty($add_Question) || empty($add_QstnAns)) {
    $res = array("res" => "incomplete");
    echo json_encode($res);
    exit();
}

$stmt1 = $conn->prepare("SELECT * FROM exam_tbl WHERE ex_id = :add_QstnExamId");
$stmt1->bindParam(':add_QstnExamId', $add_QstnExamId);
$stmt1->execute();

//assign ex_title
$ex_title = $stmt1->fetch(PDO::FETCH_ASSOC)['ex_title'];

// Check if the examid exists
if($stmt1->rowCount() == 0){
    $res = array("res" => "norecord", "msg" => $add_QstnExamId);
    echo json_encode($res);
    exit();
}

//Prepare File
if (isset($_FILES['add_ExamImg']) && $_FILES['add_ExamImg']['error'] == UPLOAD_ERR_OK) {
    // Get the file's MIME type
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($_FILES['add_ExamImg']['tmp_name']);

    // Check if the file is an image
    $allowed_mime_types = ['image/png', 'image/jpeg', 'image/webp'];
    if (in_array($mime, $allowed_mime_types)) {
        // Define upload directory
        $upload_dir = '../../uploads/exam_question/'; 

        // Use the original filename and append the exam ID
        $filename = pathinfo($_FILES['add_ExamImg']['name'], PATHINFO_FILENAME);
        $extension = pathinfo($_FILES['add_ExamImg']['name'], PATHINFO_EXTENSION);
        $new_filename = 'id_' . $add_QstnExamId . '-' . $filename . '.' . $extension;

        // Define File Name with original filename and appended exam ID
        $upload_file = $upload_dir . $new_filename;

        // Check if file already exists
        $i = 2;
        while (file_exists($upload_file)) {
            $new_filename = 'id_' . $add_QstnExamId . '-' . $filename . '(' . $i . ').' . $extension;
            $upload_file = $upload_dir . $new_filename;
            $i++;
        }

        $add_ExamImg = $new_filename;
    } 
} else {
    $add_ExamImg = '';
}

// Prepare and execute the second statement to insert the new cluster
$stmt2 = $conn->prepare("INSERT INTO exam_question_tbl (ex_id, exam_image, exam_question, exam_ch1, exam_ch2, exam_ch3, exam_ch4, exam_ch5, exam_ch6, exam_ch7, exam_ch8, exam_ch9, exam_ch10, exqstn_answer) VALUES (:add_QstnExamId, :add_ExamImg, :add_Question, :add_QstnCh1, :add_QstnCh2, :add_QstnCh3, :add_QstnCh4, :add_QstnCh5, :add_QstnCh6, :add_QstnCh7, :add_QstnCh8, :add_QstnCh9, :add_QstnCh10, :add_QstnAns)");
$stmt2->bindParam(':add_QstnExamId', $add_QstnExamId);
$stmt2->bindParam(':add_ExamImg', $add_ExamImg);
$stmt2->bindParam(':add_Question', $add_Question);
$stmt2->bindParam(':add_QstnCh1', $add_QstnCh1);
$stmt2->bindParam(':add_QstnCh2', $add_QstnCh2);
$stmt2->bindParam(':add_QstnCh3', $add_QstnCh3);
$stmt2->bindParam(':add_QstnCh4', $add_QstnCh4);
$stmt2->bindParam(':add_QstnCh5', $add_QstnCh5);
$stmt2->bindParam(':add_QstnCh6', $add_QstnCh6);
$stmt2->bindParam(':add_QstnCh7', $add_QstnCh7);
$stmt2->bindParam(':add_QstnCh8', $add_QstnCh8);
$stmt2->bindParam(':add_QstnCh9', $add_QstnCh9);
$stmt2->bindParam(':add_QstnCh10', $add_QstnCh10);
$stmt2->bindParam(':add_QstnAns', $add_QstnAns);

// Execute the statement and check if it was successful
if($stmt2->execute()) {
    //Upload File
    if (!empty($add_ExamImg)) {
        move_uploaded_file($_FILES['add_ExamImg']['tmp_name'], $upload_file);
    }
    $res = array("res" => "success", "msg" => $ex_title);
} else {
    $res = array("res" => "failed", "msg" => $ex_title);
}

echo json_encode($res);
exit();
