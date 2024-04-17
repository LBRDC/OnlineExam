<?php 
//DB Connection
include("../../conn.php");

//Variables
$edit_QstnExamId = isset($_POST['edit_QstnExamId']) ? $_POST['edit_QstnExamId'] : '';
$edit_ImgStatus = isset($_POST['edit_ImgStatus']) ? $_POST['edit_ImgStatus'] : '';
$edit_Question = isset($_POST['edit_Question']) ? $_POST['edit_Question'] : '';
$edit_QstnCh1 = isset($_POST['edit_QstnCh1']) ? $_POST['edit_QstnCh1'] : '';
$edit_QstnCh2 = isset($_POST['edit_QstnCh2']) ? $_POST['edit_QstnCh2'] : '';
$edit_QstnCh3 = isset($_POST['edit_QstnCh3']) ? $_POST['edit_QstnCh3'] : '';
$edit_QstnCh4 = isset($_POST['edit_QstnCh4']) ? $_POST['edit_QstnCh4'] : '';
$edit_QstnCh5 = isset($_POST['edit_QstnCh5']) ? $_POST['edit_QstnCh5'] : '';
$edit_QstnCh6 = isset($_POST['edit_QstnCh6']) ? $_POST['edit_QstnCh6'] : '';
$edit_QstnCh7 = isset($_POST['edit_QstnCh7']) ? $_POST['edit_QstnCh7'] : '';
$edit_QstnCh8 = isset($_POST['edit_QstnCh8']) ? $_POST['edit_QstnCh8'] : '';
$edit_QstnCh9 = isset($_POST['edit_QstnCh9']) ? $_POST['edit_QstnCh9'] : '';
$edit_QstnCh10 = isset($_POST['edit_QstnCh10']) ? $_POST['edit_QstnCh10'] : '';
$edit_QstnAns = isset($_POST['edit_QstnAns']) ? $_POST['edit_QstnAns'] : '';

// Check if variables contain values
if(empty($edit_QstnExamId) || empty($edit_Question) || empty($edit_QstnAns)) {
    $res = array("res" => "incomplete");
    echo json_encode($res);
    exit();
}

$stmt1 = $conn->prepare("SELECT * FROM exam_tbl WHERE ex_id = :edit_QstnExamId");
$stmt1->bindParam(':edit_QstnExamId', $edit_QstnExamId);
$stmt1->execute();

//assign ex_title
$ex_title = $stmt1->fetch(PDO::FETCH_ASSOC)['ex_title'];

// Check if the examid exists
if($stmt1->rowCount() == 0){
    $res = array("res" => "norecord", "msg" => $edit_QstnExamId);
    echo json_encode($res);
    exit();
}

//Prepare File
if (isset($_FILES['edit_ExamImg']) && $_FILES['edit_ExamImg']['error'] == UPLOAD_ERR_OK) {
    // Get the file's MIME type
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($_FILES['edit_ExamImg']['tmp_name']);

    // Check if the file is an image
    $allowed_mime_types = ['image/png', 'image/jpeg', 'image/webp'];
    if (in_array($mime, $allowed_mime_types)) {
        // Define upload directory
        $upload_dir = '../../uploads/exam_question/'; 

        // Use the original filename and append the exam ID
        $filename = pathinfo($_FILES['edit_ExamImg']['name'], PATHINFO_FILENAME);
        $extension = pathinfo($_FILES['edit_ExamImg']['name'], PATHINFO_EXTENSION);
        $new_filename = 'id_' . $edit_QstnExamId . '-' . $filename . '.' . $extension;

        // Define File Name with original filename and appended exam ID
        $upload_file = $upload_dir . $new_filename;

        // Check if file already exists
        $i = 2;
        while (file_exists($upload_file)) {
            $new_filename = 'id_' . $edit_QstnExamId . '-' . $filename . '(' . $i . ').' . $extension;
            $upload_file = $upload_dir . $new_filename;
            $i++;
        }

        $edit_ExamImg = $new_filename;
    } 
} else {
    $edit_ExamImg = '';
}

// Prepare and execute the second statement to insert the new cluster
$stmt2 = $conn->prepare("INSERT INTO exam_question_tbl (ex_id, exam_image, exam_question, exam_ch1, exam_ch2, exam_ch3, exam_ch4, exam_ch5, exam_ch6, exam_ch7, exam_ch8, exam_ch9, exam_ch10, exqstn_answer) VALUES (:edit_QstnExamId, :edit_ExamImg, :edit_Question, :edit_QstnCh1, :edit_QstnCh2, :edit_QstnCh3, :edit_QstnCh4, :edit_QstnCh5, :edit_QstnCh6, :edit_QstnCh7, :edit_QstnCh8, :edit_QstnCh9, :edit_QstnCh10, :edit_QstnAns)");
$stmt2->bindParam(':edit_QstnExamId', $edit_QstnExamId);
$stmt2->bindParam(':edit_ExamImg', $edit_ExamImg);
$stmt2->bindParam(':edit_Question', $edit_Question);
$stmt2->bindParam(':edit_QstnCh1', $edit_QstnCh1);
$stmt2->bindParam(':edit_QstnCh2', $edit_QstnCh2);
$stmt2->bindParam(':edit_QstnCh3', $edit_QstnCh3);
$stmt2->bindParam(':edit_QstnCh4', $edit_QstnCh4);
$stmt2->bindParam(':edit_QstnCh5', $edit_QstnCh5);
$stmt2->bindParam(':edit_QstnCh6', $edit_QstnCh6);
$stmt2->bindParam(':edit_QstnCh7', $edit_QstnCh7);
$stmt2->bindParam(':edit_QstnCh8', $edit_QstnCh8);
$stmt2->bindParam(':edit_QstnCh9', $edit_QstnCh9);
$stmt2->bindParam(':edit_QstnCh10', $edit_QstnCh10);
$stmt2->bindParam(':edit_QstnAns', $edit_QstnAns);

// Execute the statement and check if it was successful
if($stmt2->execute()) {
    //Upload File
    if (!empty($edit_ExamImg)) {
        move_uploaded_file($_FILES['edit_ExamImg']['tmp_name'], $upload_file);
    }
    $res = array("res" => "success", "msg" => $ex_title);
} else {
    $res = array("res" => "failed", "msg" => $ex_title);
}

echo json_encode($res);
exit();
