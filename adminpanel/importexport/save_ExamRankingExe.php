<?php
/*
    Check Exam ID
    Assign File Name
    Create Spreadsheet
    
    Fetch Examinee Attempt with ex_id and datefrom and dateto
    Fetch Examinee Details
    Fetch Cluster Name 
    Fetch Score, Total, percentage
    save to spreadsheet
*/
include("../../conn.php");
require '../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Variables
$save_examId = isset($_POST['save_examId'])? $_POST['save_examId'] : '';
$save_datefrom = isset($_POST['save_datefrom'])? $_POST['save_datefrom'] : '';
$save_dateto = isset($_POST['save_dateto'])? $_POST['save_dateto'] : '';

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
$file_name = "Ranking_". $ex_Title. "_". $save_datefrom. "-". $save_dateto. ".xlsx";

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
//exatmpt_id, exmne_id, ex_id, ex_score, ex_total, exatmpt_no, exatmpt_date, exatmpt_time, exatmpt_created
$stmt2 = $conn->prepare("SELECT * FROM examinee_attempt WHERE ex_id = :ex_id AND date BETWEEN :datefrom AND :dateto");
$stmt2->bindParam(':ex_id', $save_examId);
$stmt2->execute();

if ($stmt2->rowCount() == 0) {
    $res = array("res" => "nodata", "msg" => $save_examId);
    echo json_encode($res);
    exit();
}

//Insert to Spreadsheet HERE
$rowIndex = 2;
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

    //Fetch Examinee Details
    //exmne_id, exmne_clu_id, exmne_fname, exmne_mname, exmne_lname, exmne_sfname, exmne_sex, exmne_birthdate, exmne_email, exmne_pass, exmne_status, exmne_created
    $stmt3 = $conn->prepare("SELECT * FROM examinee_tbl WHERE exmne_id = :exmne_id");
    $stmt3->bindParam(':exmne_id', $exmne_id);
    $stmt3->execute();
    $exmne = $stmt3->fetch(PDO::FETCH_ASSOC);
    $exmne_fname = isset($exmne['exmne_fname']) ? $exmne['exmne_fname'] : 'null';
    $exmne_mname = isset($exmne['exmne_mname']) ? substr($exmne['exmne_mname'], 0, 1) . ". " : '_ ';
    $exmne_lname = isset($exmne['exmne_lname']) ? $exmne['exmne_lname'] : 'null';
    $exmne_sfname = isset($exmne['exmne_sfname']) ? $exmne['exmne_sfname'] : '';
    $exmne_name = $exmne_fname . ' ' . $exmne_mname . $exmne_lname . ' ' . $exmne_sfname;
    $exmne_clu_id = isset($exmne['exmne_clu_id']) ? $exmne['exmne_clu_id'] : 'null';

    //Fetch Cluster Details
    //clu_id, clu_name, clu_description, clu_status, clu_created
    $stmt4 = $conn->prepare("SELECT clu_name, clu_status FROM cluster_tbl WHERE clu_id = :clu_id");
    $stmt4->bindParam(':clu_id', $ex_id);
    $stmt4->execute();
    $clu = $stmt4->fetch(PDO::FETCH_ASSOC);
    $clu_name = isset($cl['clu_name']) ? $cl['clu_name'] : 'null';
}
// Create a new Writer
$writer = new Xlsx($spreadsheet);

// Save the file to ../../uploads/_tempDL
$writer->save('../../uploads/_tempDL/' . $file_name);

$res = array("res" => "success", "msg" => $file_name);
echo json_encode($res);
exit();
