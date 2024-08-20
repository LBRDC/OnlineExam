<?php
session_start(); 
include("../../conn.php");

$exmne_id = $_SESSION['ex_user']['exmne_id'];
$exmne_clu_id = $_SESSION['ex_user']['exmne_clu_id'];
$test_id = isset($_POST['test_Id']) && !empty($_POST['test_Id']) ? $_POST['test_Id'] : 0;
//$test_id = $_POST['test_Id'];
if ($test_id == 0) {
    $res = array("res" => "unknown", "debugid" => $test_id);
    echo json_encode($res);
    exit();
}

//Check Exams
function checkExam($ce_clu_id, $ce_exmne_id) {
    global $conn;
    // Fetch Exam IDs based on cluster
    $stmtCE1 = $conn->prepare("SELECT et.ex_id FROM exam_cluster_tbl ect JOIN exam_tbl et ON ect.ex_id = et.ex_id WHERE ect.clu_id = :clu_id AND et.ex_status = 1");
    $stmtCE1->bindParam(':clu_id', $ce_clu_id);
    $stmtCE1->execute();

    $unattemptedExamIds = [];

    // Loop through each exam ID fetched from exam_cluster_tbl and check if it has been attempted
    while ($row = $stmtCE1->fetch(PDO::FETCH_ASSOC)) {
        $ex_id = $row['ex_id'];

        // Check if the exam has been attempted
        $stmtCE2 = $conn->prepare("SELECT * FROM examinee_attempt WHERE ex_id = :ex_id AND exmne_id = :exmne_id");
        $stmtCE2->bindParam(':ex_id', $ex_id);
        $stmtCE2->bindParam(':exmne_id', $ce_exmne_id);
        $stmtCE2->execute();
        $attempts = $stmtCE2->rowCount();

        // If the exam has not been attempted, add it to the list
        if ($attempts == 0) {
            $unattemptedExamIds[] = $ex_id;
        }
    }

    if (count($unattemptedExamIds) > 0) {
        return $unattemptedExamIds[0];
    } else {
        return "noexam";
    }
}

//Check Current Test
function checkTest($ce_exmne_id, $tst_id) {
    global $conn;
    // Check if the exam has been attempted
    $stmtCT1 = $conn->prepare("SELECT * FROM examinee_attempt WHERE ex_id = :ex_id AND exmne_id = :exmne_id");
    $stmtCT1->bindParam(':ex_id', $tst_id);
    $stmtCT1->bindParam(':exmne_id', $ce_exmne_id);
    $stmtCT1->execute();
    $attempt = $stmtCT1->rowCount();

    return $attempt;
}

//Fetch Next Exam
function fetchExam($fe_clu_id, $fe_exmne_id) {
    global $conn;
    // Fetch Exam IDs based on cluster
    $stmtFE1 = $conn->prepare("SELECT et.ex_id FROM exam_cluster_tbl ect JOIN exam_tbl et ON ect.ex_id = et.ex_id WHERE ect.clu_id = :clu_id AND et.ex_status = 1");
    $stmtFE1->bindParam(':clu_id', $fe_clu_id);
    $stmtFE1->execute();

    $unattemptedExamIds = [];

    // Loop through each exam ID fetched from exam_cluster_tbl and check if it has been attempted
    while ($row = $stmtFE1->fetch(PDO::FETCH_ASSOC)) {
        $ex_id = $row['ex_id'];

        // Check if the exam has been attempted
        $stmtFE2 = $conn->prepare("SELECT * FROM examinee_attempt WHERE ex_id = :ex_id AND exmne_id = :exmne_id");
        $stmtFE2->bindParam(':ex_id', $ex_id);
        $stmtFE2->bindParam(':exmne_id', $fe_exmne_id);
        $stmtFE2->execute();
        $attempts = $stmtFE2->rowCount();

        // If the exam has not been attempted, add it to the list
        if ($attempts == 0) {
            $unattemptedExamIds[] = $ex_id;
        }
    }

    if (count($unattemptedExamIds) > 0) {
        return $unattemptedExamIds[0];
    } else {
        return "noexam";
    }
}

$examStatus = checkExam($exmne_clu_id, $exmne_id);
$testStatus = checkTest($exmne_id, $test_id);
$nextExam = fetchExam($exmne_clu_id, $exmne_id);

if ($examStatus === "noexam") {
    $res = array("res" => "complete");
    echo json_encode($res);
    exit();
} 

if ($testStatus > 0) {
    $res = array("res" => "completeCurr", "examId" => $nextExam);
    echo json_encode($res);
    exit();
} 

$res = array("res" => "incomplete");
echo json_encode($res);
exit();