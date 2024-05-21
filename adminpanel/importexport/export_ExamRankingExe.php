<?php
include("../../conn.php");
require '../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Default values for date range
$defaultStartDate = '1970-01-01';
$defaultEndDate = '9999-12-31';

// Variables
$save_examId = isset($_POST['save_examId'])? $_POST['save_examId'] : '';
$save_datefrom = isset($_POST['save_datefrom']) &&!empty($_POST['save_datefrom'])? $_POST['save_datefrom'] : $defaultStartDate;
$save_dateto = isset($_POST['save_dateto']) &&!empty($_POST['save_dateto'])? $_POST['save_dateto'] : $defaultEndDate;

// Fetch Exam Data
$stmt1 = $conn->prepare("SELECT * FROM exam_tbl WHERE ex_id = :ex_id");
$stmt1->bindParam(':ex_id', $save_examId);
$stmt1->execute();

if ($stmt1->rowCount() == 0) {
    $res = array("res" => "norecord", "msg" => $save_examId);
    echo json_encode($res);
    exit();
}

// Assign File Name
$row = $stmt1->fetch(PDO::FETCH_ASSOC);
$ex_Title = $row['ex_title'];
$timestamp = time();
$file_name = "Ranking_" . $ex_Title . "_" . $timestamp . ".xlsx";

// Create Spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Set column headers
$sheet->setCellValue('A1', 'Ranking');
$sheet->setCellValue('B1', 'Name');
$sheet->setCellValue('C1', 'Cluster');
$sheet->setCellValue('D1', 'Score');
$sheet->setCellValue('E1', 'Total');
$sheet->setCellValue('F1', 'Percentage');
$sheet->setCellValue('G1', 'Date');

// Fetch Exam Attempts with ex_id and datefrom and dateto
$stmt2 = $conn->prepare("SELECT * FROM examinee_attempt WHERE ex_id = :ex_id AND exatmpt_date BETWEEN :datefrom AND :dateto");
$stmt2->bindParam(':ex_id', $save_examId);
$stmt2->bindParam(':datefrom', $save_datefrom);
$stmt2->bindParam(':dateto', $save_dateto);
$stmt2->execute();

if ($stmt2->rowCount() == 0) {
    $res = array("res" => "nodata", "msg" => $save_examId);
    echo json_encode($res);
    exit();
}

//Insert to Spreadsheet HERE
$rowIndex = 2; // Start inserting data from the second row (first row is headers)
while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
    $exatmpt_id = $row['exatmpt_id'];
    $exmne_id = $row['exmne_id'];
    $ex_id = $row['ex_id'];
    $ex_score = $row['ex_score'];
    $ex_total = $row['ex_total'];
    $exatmpt_no = $row['exatmpt_no'];
    $exatmpt_date = $row['exatmpt_date'];
    $exatmpt_time = $row['exatmpt_time'];
    $exatmpt_created = $row['exatmpt_created'];

    // Fetch Examinee Details
    $stmt3 = $conn->prepare("SELECT * FROM examinee_tbl WHERE exmne_id = :exmne_id");
    $stmt3->bindParam(':exmne_id', $exmne_id);
    $stmt3->execute();
    $exmne = $stmt3->fetch(PDO::FETCH_ASSOC);
    $exmne_fname = $exmne['exmne_fname'] != '' ? $exmne['exmne_fname'] : 'null';
    $exmne_mname = $exmne['exmne_mname'] != '' ? substr($exmne['exmne_mname'], 0, 1). ". " : '_ ';
    $exmne_lname = $exmne['exmne_lname'] != '' ? $exmne['exmne_lname'] : 'null';
    $exmne_sfname = $exmne['exmne_sfname'] != '' ? $exmne['exmne_sfname'] : '';
    $exmne_name = $exmne_fname. ' '. $exmne_mname. $exmne_lname. ' '. $exmne_sfname;
    $exmne_clu_id = $exmne['exmne_clu_id'] != '' ? $exmne['exmne_clu_id'] : 'null';

    // Fetch Cluster Details
    $stmt4 = $conn->prepare("SELECT clu_name, clu_status FROM cluster_tbl WHERE clu_id = :clu_id");
    $stmt4->bindParam(':clu_id', $ex_id);
    $stmt4->execute();
    $clu = $stmt4->fetch(PDO::FETCH_ASSOC);
    $clu_name = isset($clu['clu_name'])? $clu['clu_name'] : 'null';

    $percentage = number_format(($ex_total > 0? ($ex_score / $ex_total) * 100 : 0), 2);

    // Determine the ranking based on percentage
    $ranking = '';
    if ($percentage < 50) {
        $ranking = 'Failed';
    } elseif ($percentage >= 90) {
        $ranking = 'Excellent';
    } elseif ($percentage >= 80) {
        $ranking = 'Very Good';
    } elseif ($percentage >= 50) {
        $ranking = 'Good';
    } else {
        $ranking = 'Null';
    }

    // Insert data into the spreadsheet
    $sheet->setCellValue('A'. $rowIndex, $ranking);
    $sheet->setCellValue('B'. $rowIndex, $exmne_name);
    $sheet->setCellValue('C'. $rowIndex, $exmne_clu_id);
    $sheet->setCellValue('D'. $rowIndex, $ex_score);
    $sheet->setCellValue('E'. $rowIndex, $ex_total);
    $sheet->setCellValue('F'. $rowIndex, $percentage);
    $sheet->setCellValue('G'. $rowIndex, $exatmpt_date);

    $rowIndex++; // Move to the next row
}

// Create a new Writer
$writer = new Xlsx($spreadsheet);

// Save the file temporarily
$writer->save($file_name);

// Read the file content into a variable
$file_content = file_get_contents($file_name);

// Return the file name, content type, and file content as part of a JSON response
$res = array(
    "res" => "success",
    "msg" => $file_name, // This will be the file name
    "content_type" => "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
    "data" => base64_encode($file_content) // Encode the file content in base64 format
);
echo json_encode($res);

// Clean up the temporary file
unlink($file_name);

//$res = array("res" => "success", "msg" => $file_name);
//echo json_encode($res);
exit();
