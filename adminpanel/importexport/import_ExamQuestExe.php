<?php
/*
    Import Exam Questions

    Read Zip archive
    Read Excel file in archive
    Import images in exam_images folder
*/
session_start();
include("../../conn.php");
require '../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$ex_id = isset($_POST['import_QstnExamId']) ? $_POST['import_QstnExamId'] : '';

$file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

if(isset($_FILES['import_QuestFile']['name']) && in_array($_FILES['import_QuestFile']['type'], $file_mimes)) {
    if (is_uploaded_file($_FILES['import_QuestFile']['tmp_name'])) {
        $arr_file = explode('.', $_FILES['import_QuestFile']['name']);
        $extension = end($arr_file);

        if('csv' == $extension) {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
        } else {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        }

        $spreadsheet = $reader->load($_FILES['import_QuestFile']['tmp_name']);
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

        // Now, safely check the headers
        $headers = ['Exam Image', 'Question', 'Choice 1', 'Choice 2', 'Choice 3', 'Choice 4', 'Choice 5', 'Choice 6', 'Choice 7', 'Choice 8', 'Choice 9', 'Choice 10', 'Answer'];

        // Assuming $sheetData[1] contains the headers since it starts indexing from 1 after conversion
        $actualHeaders = array_values($sheetData[1]);

        // Check if the actual headers match the expected headers
        if ($actualHeaders!== $headers) {
            // If headers do not match, return an error response
            $res = array("res" => "wrongformat");
            echo json_encode($res);
            exit();
        }


        if (!empty($sheetData)) {
            try {
                $conn->beginTransaction();
        
                // Prepare the SQL statement once outside the loop
                $stmt = $conn->prepare("INSERT INTO exam_question_tbl (ex_id, exam_image, exam_question, exam_ch1, exam_ch2, exam_ch3, exam_ch4, exam_ch5, exam_ch6, exam_ch7, exam_ch8, exam_ch9, exam_ch10, exqstn_answer) VALUES (:ex_id, :exam_image, :exam_question, :exam_ch1, :exam_ch2, :exam_ch3, :exam_ch4, :exam_ch5, :exam_ch6, :exam_ch7, :exam_ch8, :exam_ch9, :exam_ch10, :exqstn_answer)");
        
                for ($i = 2; $i <= count($sheetData); $i++) {
                    $exam_image = isset($sheetData[$i]['A'])? $sheetData[$i]['A'] : ""; // Assuming image URL or identifier is in column A
                    $exam_question = isset($sheetData[$i]['B'])? $sheetData[$i]['B'] : ""; // Question text is in column B
                    $exam_ch1 = isset($sheetData[$i]['C'])? $sheetData[$i]['C'] : "";
                    $exam_ch2 = isset($sheetData[$i]['D'])? $sheetData[$i]['D'] : "";
                    $exam_ch3 = isset($sheetData[$i]['E'])? $sheetData[$i]['E'] : "";
                    $exam_ch4 = isset($sheetData[$i]['F'])? $sheetData[$i]['F'] : "";
                    $exam_ch5 = isset($sheetData[$i]['G'])? $sheetData[$i]['G'] : ""; 
                    $exam_ch6 = isset($sheetData[$i]['H'])? $sheetData[$i]['H'] : ""; 
                    $exam_ch7 = isset($sheetData[$i]['I'])? $sheetData[$i]['I'] : ""; 
                    $exam_ch8 = isset($sheetData[$i]['J'])? $sheetData[$i]['J'] : ""; 
                    $exam_ch9 = isset($sheetData[$i]['K'])? $sheetData[$i]['K'] : ""; 
                    $exam_ch10 = isset($sheetData[$i]['L'])? $sheetData[$i]['L'] : ""; 
                    $exam_answer = isset($sheetData[$i]['M'])? $sheetData[$i]['M'] : "";

                    // Bind the parameters
                    $stmt->bindParam(':ex_id', $ex_id);
                    $stmt->bindParam(':exam_image', $exam_image);
                    $stmt->bindParam(':exam_question', $exam_question);
                    $stmt->bindParam(':exam_ch1', $exam_ch1);
                    $stmt->bindParam(':exam_ch2', $exam_ch2);
                    $stmt->bindParam(':exam_ch3', $exam_ch3);
                    $stmt->bindParam(':exam_ch4', $exam_ch4);
                    $stmt->bindParam(':exam_ch5', $exam_ch5);
                    $stmt->bindParam(':exam_ch6', $exam_ch6);
                    $stmt->bindParam(':exam_ch7', $exam_ch7);
                    $stmt->bindParam(':exam_ch8', $exam_ch8);
                    $stmt->bindParam(':exam_ch9', $exam_ch9);
                    $stmt->bindParam(':exam_ch10', $exam_ch10);
                    $stmt->bindParam(':exqstn_answer', $exam_answer);
        
                    // Execute the SQL statement
                    if (!$stmt->execute()) {
                        $errorCode = $stmt->errorCode();
                        $errorInfo = $stmt->errorInfo();
                        throw new Exception('Failed to insert row '. $i. ': Error Code: '.$errorCode.'; Error Info: '.print_r($errorInfo, true));
                    }
                }
        
                $conn->commit();
                $res = array("res" => "success");
            } catch (Exception $e) {
                $conn->rollback(); // Rollback in case of any exception
                $res = array("res" => "failed", "msg" => "An error occurred: ". $e->getMessage());
                echo json_encode($res);
                exit();
            }
        }
    } else {
        $res = array("res" => "failed", "msg" => "File upload failed. Is_uploaded_file check failed.");
    }
} else {
    $res = array("res" => "failed", "msg" => "Invalid file type or file not set.");
}

header('Content-Type: application/json');
echo json_encode($res);
exit();