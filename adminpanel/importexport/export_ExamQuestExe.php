<?php
include("../../conn.php");
require '../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$ex_id = $_GET['id'];

// Fetch Exam Information
$stmt1 = $conn->prepare("SELECT * FROM exam_tbl WHERE ex_id = :ex_id");
$stmt1->bindParam(':ex_id', $ex_id);
$stmt1->execute();
$res1 = $stmt1->fetch(PDO::FETCH_ASSOC);
$ex_title = $res1['ex_title'];

// Fetch Exam Questions
$stmt1 = $conn->prepare("SELECT exqstn_id, ex_id, exam_image, exam_question, exam_ch1, exam_ch2, exam_ch3, exam_ch4, exam_ch5, exam_ch6, exam_ch7, exam_ch8, exam_ch9, exam_ch10, exqstn_answer FROM exam_question_tbl WHERE ex_id = :ex_id");
$stmt1->bindParam(':ex_id', $ex_id);
$stmt1->execute();
$res2 = $stmt1->fetchAll(PDO::FETCH_ASSOC);

// Create a new Spreadsheet object
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Set the headers
$headers = ['Exam Image', 'Question', 'Choice 1', 'Choice 2', 'Choice 3', 'Choice 4', 'Choice 5', 'Choice 6', 'Choice 7', 'Choice 8', 'Choice 9', 'Choice 10', 'Answer'];
$sheet->fromArray($headers, NULL, 'A1');

// Write data to the Excel file
$row = 2; 
foreach ($res2 as $data) {
    $dataToWrite = [
        $data['exam_image'],
        $data['exam_question'],
        $data['exam_ch1'],
        $data['exam_ch2'],
        $data['exam_ch3'],
        $data['exam_ch4'],
        $data['exam_ch5'],
        $data['exam_ch6'],
        $data['exam_ch7'],
        $data['exam_ch8'],
        $data['exam_ch9'],
        $data['exam_ch10'],
        $data['exqstn_answer']
    ];
    $sheet->fromArray($dataToWrite, NULL, 'A'. $row);
    $row++;
}

// Set the file name for the Excel file
$timestamp = time();
$filename = $ex_title. '-questions_'. $timestamp. '.xlsx';

// Create a Writer object and save the Excel file
$writer = new Xlsx($spreadsheet);
$writer->save($filename);

// Set headers to force download of the Excel file
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="'. $filename. '"');
header('Cache-Control: max-age=0');

// Output the Excel file
readfile($filename);

// Delete the Excel file from the server
unlink($filename);
