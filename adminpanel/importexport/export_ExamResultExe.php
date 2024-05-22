<?php
include("../../conn.php");
require '../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Default values for date range
$defaultStartDate = '1970-01-01';
$defaultEndDate = '9999-12-31';

// Variables
$save_datefrom = isset($_POST['save_datefrom']) &&!empty($_POST['save_datefrom'])? $_POST['save_datefrom'] : $defaultStartDate;
$save_dateto = isset($_POST['save_dateto']) &&!empty($_POST['save_dateto'])? $_POST['save_dateto'] : $defaultEndDate;

// Assign File Name
$timestamp = time();
$file_name = "Exam-Results_" . $timestamp . ".xlsx";

// Create Spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Set column headers
$sheet->setCellValue('A1', 'Name');
$sheet->setCellValue('B1', 'Exam Name');
$sheet->setCellValue('C1', 'Score');
$sheet->setCellValue('D1', 'Total');
$sheet->setCellValue('E1', 'Percentage');
$sheet->setCellValue('F1', 'Date');

//Fetch Exam Attempts
$stmt1 = $conn->prepare("SELECT * FROM examinee_attempt ORDER BY exatmpt_date DESC");
$stmt1->execute();

$rowIndex = 2;
while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
    //$exatmpt_id = $row['exatmpt_id'];
    $exmne_id = $row['exmne_id'];
    $ex_id = $row['ex_id'];
    $ex_score = $row['ex_score'];
    $ex_total = $row['ex_total'];
    //$exatmpt_no = $row['exatmpt_no'];
    $exatmpt_date = $row['exatmpt_date'];
    //$exatmpt_time = $row['exatmpt_time'];
    //$exatmpt_created = $row['exatmpt_created'];

    $stmt2 = $conn->prepare("SELECT * FROM examinee_tbl WHERE exmne_id = :exmne_id");
    $stmt2->bindParam(':exmne_id', $exmne_id);
    $stmt2->execute();
    if ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
        // Prepare examinee name
        $exmne_fname = $row['exmne_fname'] != '' ? $row['exmne_fname'] : 'null';
        $exmne_mname = $row['exmne_mname'] != '' ? substr($row['exmne_mname'], 0, 1) . ". " : '_ ';
        $exmne_lname = $row['exmne_lname'] != '' ? $row['exmne_lname'] : 'null';
        $exmne_sfname = $row['exmne_sfname'] != '' ? $row['exmne_sfname'] : '';
        $exmne_name = $exmne_lname . ', ' . $exmne_fname . ' ' . $exmne_mname . $exmne_sfname;
    }

    $stmt3 = $conn->prepare("SELECT * FROM exam_tbl WHERE ex_id = :ex_id");
    $stmt3->bindParam(':ex_id', $ex_id);
    $stmt3->execute();
    if ($row = $stmt3->fetch(PDO::FETCH_ASSOC)) {
        $ex_title = isset($row['ex_title']) ? $row['ex_title'] : 'null';
    }
    
    $percentage = number_format(($ex_total > 0? ($ex_score / $ex_total) * 100 : 0), 2);

    // Insert data into the spreadsheet
    $sheet->setCellValue('A'. $rowIndex, $exmne_name);
    $sheet->setCellValue('B'. $rowIndex, $ex_title);
    $sheet->setCellValue('C'. $rowIndex, $ex_score);
    $sheet->setCellValue('D'. $rowIndex, $ex_total);
    $sheet->setCellValue('E'. $rowIndex, $percentage);
    $sheet->setCellValue('F'. $rowIndex, $exatmpt_date);
    $rowIndex++;
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

exit();