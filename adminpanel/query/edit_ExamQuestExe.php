<?php 
//DB Connection
include("../../conn.php");

//Variables
$edit_QstnId = isset($_POST['edit_QstnId']) ? $_POST['edit_QstnId'] : '';
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
if(empty($edit_QstnId) || empty($edit_QstnExamId) || empty($edit_Question) || empty($edit_QstnAns)) {
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

//fetch filename from database
$stmt2 = $conn->prepare("SELECT * FROM exam_question_tbl WHERE exqstn_id = :edit_QstnId");
$stmt2->bindParam(':edit_QstnId', $edit_QstnId);
$stmt2->execute();
// Define upload directory
$upload_dir = '../../uploads/exam_question/'; 
// Define temporary directory
$temp_dir = '../../uploads/_temp/';

if (isset($_FILES['edit_ExamImg'])) {
    // Check if there's an error with the file upload
    if ($_FILES['edit_ExamImg']['error'] != UPLOAD_ERR_OK) {
        $res = array("res" => "fileerror", "msg" => isset($_FILES['edit_ExamImg']));
        echo json_encode($res);
        exit();
    } else {
        // Get the file's MIME type
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($_FILES['edit_ExamImg']['tmp_name']);

        // Check if the file is an image
        $allowed_mime_types = ['image/png', 'image/jpeg', 'image/webp'];
        if (in_array($mime, $allowed_mime_types)) {
            switch ($edit_ImgStatus) {
                case 'img_Replace':
                    if ($stmt2->rowCount() > 0) { // File exists
                        $row = $stmt2->fetch(PDO::FETCH_ASSOC);
                        $new_ExamImg = $row['exam_image'];

                        $existing_file_path = $upload_dir . $new_ExamImg;

                        // Check if the file exists and move it to the temp folder
                        if (file_exists($existing_file_path)) {
                            $existing_files = glob($temp_dir . '*');
        
                            $file_info = pathinfo($existing_file_path);
                            $filename = $file_info['filename'];
                            $extension = $file_info['extension'];
        
                            $file_exists_in_temp = false;
                            foreach ($existing_files as $file) {
                                if (basename($file) == $new_ExamImg) {
                                    $file_exists_in_temp = true;
                                    break;
                                }
                            }
        
                            // If the file exists in the temp directory, generate a unique filename
                            if ($file_exists_in_temp) {
                                $timestamp = time();
                                $unique_filename = $filename . '_' . $timestamp . '.' . $extension;
                                $temp_file_path = $temp_dir . $unique_filename;
                            } else {
                                $temp_file_path = $temp_dir . $new_ExamImg;
                            }

                            rename($existing_file_path, $temp_file_path);
                        }
                        
                        $filename = pathinfo($_FILES['edit_ExamImg']['name'], PATHINFO_FILENAME);
                        $extension = pathinfo($_FILES['edit_ExamImg']['name'], PATHINFO_EXTENSION);
                        $new_filename = 'id_' . $edit_QstnExamId . '-' . $filename . '.' . $extension;

                        $upload_file = $upload_dir . $new_filename;

                        // Check if file already exists
                        $i = 2;
                        while (file_exists($upload_file)) {
                            $new_filename = 'id_' . $edit_QstnExamId . '-' . $filename . '(' . $i . ').' . $extension;
                            $upload_file = $upload_dir . $new_filename;
                            $i++;
                        }

                        $edit_ExamImg = $new_filename;
                    } else { // File does not exist OBSOLETE
                        $filename = pathinfo($_FILES['edit_ExamImg']['name'], PATHINFO_FILENAME);
                        $extension = pathinfo($_FILES['edit_ExamImg']['name'], PATHINFO_EXTENSION);
                        $new_filename = 'id_' . $edit_QstnExamId . '-' . $filename . '.' . $extension;

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
                    break;
                case 'img_New':
                    $filename = pathinfo($_FILES['edit_ExamImg']['name'], PATHINFO_FILENAME);
                    $extension = pathinfo($_FILES['edit_ExamImg']['name'], PATHINFO_EXTENSION);
                    $new_filename = 'id_' . $edit_QstnExamId . '-' . $filename . '.' . $extension;

                    $upload_file = $upload_dir . $new_filename;

                    // Check if file already exists
                    $i = 2;
                    while (file_exists($upload_file)) {
                        $new_filename = 'id_' . $edit_QstnExamId . '-' . $filename . '(' . $i . ').' . $extension;
                        $upload_file = $upload_dir . $new_filename;
                        $i++;
                    }

                    $edit_ExamImg = $new_filename;
                    break;
                case 'img_Old':
                    if ($stmt2->rowCount() > 0) {
                        $row = $stmt2->fetch(PDO::FETCH_ASSOC);
                        $edit_ExamImg = $row['exam_image'];
                    }
                    break;
                default:
                    $filename = pathinfo($_FILES['edit_ExamImg']['name'], PATHINFO_FILENAME);
                    $extension = pathinfo($_FILES['edit_ExamImg']['name'], PATHINFO_EXTENSION);
                    
                    $res = array("res" => "filemodify", "msg" => $filename . '.' . $extension);
                    echo json_encode($res);
                    exit();
                    break;
            }
        } else {
            $res = array("res" => "filetypeerror");
            echo json_encode($res);
            exit();
        }
    }
} else if (!isset($_FILES['edit_ExamImg']) && $edit_ImgStatus == 'img_Delete') {
    if ($stmt2->rowCount() > 0) { // File exists
        $del_file = $stmt2->fetch(PDO::FETCH_ASSOC);
        $existing_file_path = $upload_dir . $del_file['exam_image'];
        
        if (file_exists($existing_file_path)) {
            $existing_files = glob($temp_dir . '*');
    
            $file_info = pathinfo($existing_file_path);
            $filename = $file_info['filename'];
            $extension = $file_info['extension'];
    
            $file_exists_in_temp = false;
            foreach ($existing_files as $file) {
                if (basename($file) == $del_file['exam_image']) {
                    $file_exists_in_temp = true;
                    break;
                }
            }
    
            if ($file_exists_in_temp) {
                $timestamp = time();
                $unique_filename = $filename . '_' . $timestamp . '.' . $extension;
                $temp_file_path = $temp_dir . $unique_filename;
            } else {
                $temp_file_path = $temp_dir . $del_file['exam_image'];
            }
            rename($existing_file_path, $temp_file_path);
        }
        $edit_ExamImg = '';
    }    
} else {
    if ($stmt2->rowCount() > 0) {
        $row = $stmt2->fetch(PDO::FETCH_ASSOC);
        $edit_ExamImg = $row['exam_image'];
    }
}

// update question based on exqstn_id
$stmt3 = $conn->prepare("UPDATE exam_question_tbl SET exam_image = :edit_ExamImg, exam_question = :edit_Question, exam_ch1 = :edit_QstnCh1, exam_ch2 = :edit_QstnCh2, exam_ch3 = :edit_QstnCh3, exam_ch4 = :edit_QstnCh4, exam_ch5 = :edit_QstnCh5, exam_ch6 = :edit_QstnCh6, exam_ch7 = :edit_QstnCh7, exam_ch8 = :edit_QstnCh8, exam_ch9 = :edit_QstnCh9, exam_ch10 = :edit_QstnCh10, exqstn_answer = :edit_QstnAns WHERE exqstn_id = :edit_QstnId");
$stmt3->bindParam(':edit_ExamImg', $edit_ExamImg);
$stmt3->bindParam(':edit_Question', $edit_Question);
$stmt3->bindParam(':edit_QstnCh1', $edit_QstnCh1);
$stmt3->bindParam(':edit_QstnCh2', $edit_QstnCh2);
$stmt3->bindParam(':edit_QstnCh3', $edit_QstnCh3);
$stmt3->bindParam(':edit_QstnCh4', $edit_QstnCh4);
$stmt3->bindParam(':edit_QstnCh5', $edit_QstnCh5);
$stmt3->bindParam(':edit_QstnCh6', $edit_QstnCh6);
$stmt3->bindParam(':edit_QstnCh7', $edit_QstnCh7);
$stmt3->bindParam(':edit_QstnCh8', $edit_QstnCh8);
$stmt3->bindParam(':edit_QstnCh9', $edit_QstnCh9);
$stmt3->bindParam(':edit_QstnCh10', $edit_QstnCh10);
$stmt3->bindParam(':edit_QstnAns', $edit_QstnAns);
$stmt3->bindParam(':edit_QstnId', $edit_QstnId);

// Execute the statement and check if it was successful
if($stmt3->execute()) {
    //Upload File
    if (isset($_FILES['edit_ExamImg'])) {
        move_uploaded_file($_FILES['edit_ExamImg']['tmp_name'], $upload_file);
    } 
    $res = array("res" => "success", "msg" => $ex_title);
} else {
    $res = array("res" => "failed", "msg" => $ex_title);
}

echo json_encode($res);
exit();
