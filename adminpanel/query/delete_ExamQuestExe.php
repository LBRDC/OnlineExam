<?php 
//DB Connection
include("../../conn.php");

//Variables
$delete_QstnId = isset($_POST['delete_QstnId']) ? $_POST['delete_QstnId'] : '';

// Check all variables are not empty
if(empty($delete_QstnId)) {
    $res = array("res" => "incomplete" , "msg" => $delete_QstnId);
    echo json_encode($res);
    exit();
}

// Check if ID exists
$stmt1 = $conn->prepare("SELECT * FROM exam_question_tbl WHERE exqstn_id = :delete_QstnId");
$stmt1->bindParam(':delete_QstnId', $delete_QstnId);
$stmt1->execute();

//Image
$result = $stmt1->fetch(PDO::FETCH_ASSOC);
$imgForDel = $result['exam_image'];

if($stmt1->rowCount() == 0){
    $res = array("res" => "norecord", "msg" => $delete_QstnId);
    echo json_encode($res);
    exit();
} 

// Check file
$stmt2 = $conn->prepare("SELECT exam_image FROM exam_question_tbl WHERE exam_image = :imgForDel AND exqstn_id <> :delete_QstnId");
$stmt2->bindParam(':imgForDel', $imgForDel);
$stmt2->bindParam(':delete_QstnId', $delete_QstnId);
$stmt2->execute();

if ($stmt2->rowCount() > 1) {
    //File not deleted
} else if ($stmt2->rowCount() == 0) {
    $upload_dir = '../../uploads/exam_question/'; 
    $del_dir = '../../uploads/_delete/';

    $existing_file_path = $upload_dir . $imgForDel;

    // Check if the file exists
    if (file_exists($existing_file_path)) {
        if (!file_exists($del_dir)) {
            mkdir($del_dir, 0777, true);
        }

        $existing_files = glob($del_dir . '*');
        
        $file_info = pathinfo($existing_file_path);
        $filename = $file_info['filename'];
        $extension = $file_info['extension'];

        $file_exists_in_del = false;
        foreach ($existing_files as $file) {
            if (basename($file) == $imgForDel) {
                $file_exists_in_del = true;
                break;
            }
        }

        // If the file exists in the delete directory, generate a unique filename
        if ($file_exists_in_del) {
            $timestamp = time();
            $unique_filename = $filename . '_' . $timestamp . '.' . $extension;
            $del_file_path = $del_dir . $unique_filename;
        } else {
            $del_file_path = $del_dir . $imgForDel;
        }

        $del_file = rename($existing_file_path, $del_file_path);
    }
}

//Delete from exam_question_tbl
$stmt3 = $conn->prepare("DELETE FROM exam_question_tbl WHERE exqstn_id = :delete_QstnId");
$stmt3->bindParam(':delete_QstnId', $delete_QstnId);

if($stmt3->execute()) {
    $res = array("res" => "success", "msg" => $delete_QstnId);
} else {
    $res = array("res" => "failed", "msg" => $delete_QstnId);
}

echo json_encode($res);
exit();

