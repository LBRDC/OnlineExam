<?php
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

// Fetch clusters with exam id
$stmt2 = $conn->prepare("SELECT * FROM exam_cluster_tbl WHERE ex_id = :ex_id");
$stmt2->bindParam(':ex_id', $save_examId);
$stmt2->execute();

// Iterate through each cluster
$rankCnt = 2;
while ($cluster = $stmt2->fetch(PDO::FETCH_ASSOC)) {
    $exmne_clu_id = $cluster['clu_id'];

    // Fetch examinees for each cluster
    $stmt3 = $conn->prepare("SELECT * FROM examinee_tbl WHERE exmne_clu_id = :exmne_clu_id");
    $stmt3->bindParam(':exmne_clu_id', $exmne_clu_id);
    $stmt3->execute();

    // Iterate through each examinee in the cluster
    // Iterate through each examinee in the cluster
while ($examinee = $stmt3->fetch(PDO::FETCH_ASSOC)) {
    // Prepare examinee name
    $exmne_fname = isset($examinee['exmne_fname'])? $examinee['exmne_fname'] : 'null';
    $exmne_mname = isset($examinee['exmne_mname'])? substr($examinee['exmne_mname'], 0, 1). ". " : '_ ';
    $exmne_lname = isset($examinee['exmne_lname'])? $examinee['exmne_lname'] : 'null';
    $exmne_name = $exmne_fname. ' '. $exmne_mname. $exmne_lname;

    // Fetch cluster name
    $stmt4 = $conn->prepare("SELECT * FROM cluster_tbl WHERE clu_id = :clu_id");
    $stmt4->bindParam(':clu_id', $exmne_clu_id);
    $stmt4->execute();
    $cluster_name = $stmt4->fetch(PDO::FETCH_ASSOC)['clu_name'];

    // Fetch score and total for the current examinee based on date range
    $stmt5 = $conn->prepare("SELECT * FROM examinee_attempt WHERE ex_id = :ex_id AND exmne_id = :exmne_id AND exatmpt_date BETWEEN :datefrom AND :dateto");
    $stmt5->bindParam(':ex_id', $save_examId);
    $stmt5->bindParam(':exmne_id', $examinee['exmne_id']);
    $stmt5->bindParam(':datefrom', $save_datefrom);
    $stmt5->bindParam(':dateto', $save_dateto);
    $stmt5->execute();
    $result = $stmt5->fetch(PDO::FETCH_ASSOC);

    // Check if there are no attempts for the examinee
    if (empty($result)) {
        $score = '';
        $total = '';
        $percentage = '';
        $date = ''; 
        $ranking = 'Not Answered';
    } else {
        // Attempts found, calculate score, total, and percentage
        $score = isset($result['ex_score'])? $result['ex_score'] : 0;
        $total = isset($result['ex_total'])? $result['ex_total'] : 0;
        $date = isset($result['exatmpt_date'])? $result['exatmpt_date'] : '';
        $percentage = $total > 0? ($score / $total) * 100 : 0;
        
        // Determine the ranking based on percentage
        if ($percentage < 50) {
            $ranking = 'Failed';
        } elseif ($percentage >= 90) {
            $ranking = 'Excellent';
        } elseif ($percentage >= 80) {
            $ranking = 'Very Good';
        } elseif ($percentage >= 50) {
            $ranking = 'Good';
        }
    }

    // Populate the Spreadsheet
    $sheet->setCellValue('A'. $rankCnt, $ranking);
    $sheet->setCellValue('B'. $rankCnt, $exmne_name);
    $sheet->setCellValue('C'. $rankCnt, $cluster_name);
    $sheet->setCellValue('D'. $rankCnt, $score);
    $sheet->setCellValue('E'. $rankCnt, $total);
    $sheet->setCellValue('F'. $rankCnt, $percentage);
    $sheet->setCellValue('G'. $rankCnt, $date);

    $rankCnt++;
}
}

// Create a new Writer
$writer = new Xlsx($spreadsheet);

// Save the file to ../../uploads/_tempDL
$writer->save('../../uploads/_tempDL/' . $file_name);

$res = array("res" => "success", "msg" => $file_name);
echo json_encode($res);
exit();
