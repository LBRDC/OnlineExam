<?php 
//DB Connection
include("../../conn.php");

//Variables
$edit_QstnId = isset($_POST['edit_PracId']) ? $_POST['edit_PracId'] : '';
$edit_QstnExamId = isset($_POST['edit_PracExamId']) ? $_POST['edit_PracExamId'] : '';
$edit_ImgStatus = isset($_POST['edit_PracImgStatus']) ? $_POST['edit_PracImgStatus'] : '';
$edit_Guide = isset($_POST['edit_Guide']) ? $_POST['edit_Guide'] : '';
$edit_Question = isset($_POST['edit_Practice']) ? $_POST['edit_Practice'] : '';
$edit_QstnCh1 = isset($_POST['edit_PracCh1']) ? $_POST['edit_PracCh1'] : '';
$edit_QstnCh2 = isset($_POST['edit_PracCh2']) ? $_POST['edit_PracCh2'] : '';
$edit_QstnCh3 = isset($_POST['edit_PracCh3']) ? $_POST['edit_PracCh3'] : '';
$edit_QstnCh4 = isset($_POST['edit_PracCh4']) ? $_POST['edit_PracCh4'] : '';
$edit_QstnCh5 = isset($_POST['edit_PracCh5']) ? $_POST['edit_PracCh5'] : '';
$edit_QstnCh6 = isset($_POST['edit_PracCh6']) ? $_POST['edit_PracCh6'] : '';
$edit_QstnCh7 = isset($_POST['edit_PracCh7']) ? $_POST['edit_PracCh7'] : '';
$edit_QstnCh8 = isset($_POST['edit_PracCh8']) ? $_POST['edit_PracCh8'] : '';
$edit_QstnCh9 = isset($_POST['edit_PracCh9']) ? $_POST['edit_PracCh9'] : '';
$edit_QstnCh10 = isset($_POST['edit_PracCh10']) ? $_POST['edit_PracCh10'] : '';
$edit_QstnAns = isset($_POST['edit_PracAns']) ? $_POST['edit_PracAns'] : '';

// Check if variables contain values
if($edit_QstnId == '' || $edit_QstnExamId == '' || $edit_Guide == '' || $edit_Question == '' || $edit_QstnAns == '') {
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
$stmt2 = $conn->prepare("SELECT * FROM exam_practice_tbl WHERE prqstn_id = :edit_QstnId");
$stmt2->bindParam(':edit_QstnId', $edit_QstnId);
$stmt2->execute();
// Define upload directory
$upload_dir = '../../uploads/exam_question/'; 
// Define temporary directory
$temp_dir = '../../uploads/_temp/';

if (isset($_FILES['edit_PracImg'])) {
    // Check if there's an error with the file upload
    if ($_FILES['edit_PracImg']['error'] != UPLOAD_ERR_OK) {
        $res = array("res" => "fileerror", "msg" => isset($_FILES['edit_PracImg']));
        echo json_encode($res);
        exit();
    } else {
        // Get the file's MIME type
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($_FILES['edit_PracImg']['tmp_name']);

        // Check if the file is an image
        $allowed_mime_types = ['image/png', 'image/jpeg', 'image/webp'];
        if (in_array($mime, $allowed_mime_types)) {
            switch ($edit_ImgStatus) {
                case 'img_Replace':
                    if ($stmt2->rowCount() > 0) { // File exists
                        $row = $stmt2->fetch(PDO::FETCH_ASSOC);
                        $new_ExamImg = $row['prac_image'];

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
                        
                        $filename = pathinfo($_FILES['edit_PracImg']['name'], PATHINFO_FILENAME);
                        $extension = pathinfo($_FILES['edit_PracImg']['name'], PATHINFO_EXTENSION);
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
                        $filename = pathinfo($_FILES['edit_PracImg']['name'], PATHINFO_FILENAME);
                        $extension = pathinfo($_FILES['edit_PracImg']['name'], PATHINFO_EXTENSION);
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
                    $filename = pathinfo($_FILES['edit_PracImg']['name'], PATHINFO_FILENAME);
                    $extension = pathinfo($_FILES['edit_PracImg']['name'], PATHINFO_EXTENSION);
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
                        $edit_ExamImg = $row['prac_image'];
                    }
                    break;
                default:
                    $filename = pathinfo($_FILES['edit_PracImg']['name'], PATHINFO_FILENAME);
                    $extension = pathinfo($_FILES['edit_PracImg']['name'], PATHINFO_EXTENSION);
                    
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
} else if (!isset($_FILES['edit_PracImg']) && $edit_ImgStatus == 'img_Delete') {
    if ($stmt2->rowCount() > 0) { // File exists
        $del_file = $stmt2->fetch(PDO::FETCH_ASSOC);
        $existing_file_path = $upload_dir . $del_file['prac_image'];
        
        if (file_exists($existing_file_path)) {
            $existing_files = glob($temp_dir . '*');
    
            $file_info = pathinfo($existing_file_path);
            $filename = $file_info['filename'];
            $extension = $file_info['extension'];
    
            $file_exists_in_temp = false;
            foreach ($existing_files as $file) {
                if (basename($file) == $del_file['prac_image']) {
                    $file_exists_in_temp = true;
                    break;
                }
            }
    
            if ($file_exists_in_temp) {
                $timestamp = time();
                $unique_filename = $filename . '_' . $timestamp . '.' . $extension;
                $temp_file_path = $temp_dir . $unique_filename;
            } else {
                $temp_file_path = $temp_dir . $del_file['prac_image'];
            }
            rename($existing_file_path, $temp_file_path);
        }
        $edit_ExamImg = '';
    }    
} else {
    if ($stmt2->rowCount() > 0) {
        $row = $stmt2->fetch(PDO::FETCH_ASSOC);
        $edit_ExamImg = $row['prac_image'];
    }
}

// update question based on exqstn_id
$stmt3 = $conn->prepare("UPDATE exam_practice_tbl SET prac_image = :edit_ExamImg, prac_question = :edit_Question, prac_ch1 = :edit_QstnCh1, prac_ch2 = :edit_QstnCh2, prac_ch3 = :edit_QstnCh3, prac_ch4 = :edit_QstnCh4, prac_ch5 = :edit_QstnCh5, prac_ch6 = :edit_QstnCh6, prac_ch7 = :edit_QstnCh7, prac_ch8 = :edit_QstnCh8, prac_ch9 = :edit_QstnCh9, prac_ch10 = :edit_QstnCh10, prqstn_answer = :edit_QstnAns, prac_guide = :edit_Guide WHERE prqstn_id = :edit_QstnId");
$stmt3->bindParam(':edit_ExamImg', $edit_ExamImg);
$stmt3->bindParam(':edit_Guide', $edit_Guide);
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
    if (isset($_FILES['edit_PracImg'])) {
        move_uploaded_file($_FILES['edit_PracImg']['tmp_name'], $upload_file);
    } 
    $res = array("res" => "success", "msg" => $ex_title);
} else {
    $res = array("res" => "failed", "msg" => $ex_title);
}

echo json_encode($res);
exit();
