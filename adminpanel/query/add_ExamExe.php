<?php 
include("../../conn.php");

// Variables
$add_ExamTitle = isset($_POST['add_ExamTitle']) ? $_POST['add_ExamTitle'] : '';
$add_ExamDesc = isset($_POST['add_ExamDesc']) ? $_POST['add_ExamDesc'] : '';
$add_ExamCluster = isset($_POST['add_ExamCluster']) ? $_POST['add_ExamCluster'] : array(); // Ensure it's an array
$add_ExamQuestLimit = isset($_POST['add_ExamQuestLimit']) ? $_POST['add_ExamQuestLimit'] : '';
$add_ExamTimeLimit = isset($_POST['add_ExamTimeLimit']) ? $_POST['add_ExamTimeLimit'] : '';
$add_ExamRandom = isset($_POST['add_ExamRandom']) ? $_POST['add_ExamRandom'] : '';
$add_ExamNoPrev = isset($_POST['add_ExamNoPrev']) ? $_POST['add_ExamNoPrev'] : '';
$ex_status = 1;

// Check if all variables contain values
if(empty($add_ExamTitle) || empty($add_ExamCluster) || empty($add_ExamQuestLimit) || empty($add_ExamTimeLimit)) {
    $res = array("res" => "incomplete");
    echo json_encode($res);
    exit();
}

$stmt1 = $conn->prepare("SELECT * FROM exam_tbl WHERE ex_title = :add_ExamTitle");
$stmt1->bindParam(':add_ExamTitle', $add_ExamTitle);
$stmt1->execute();

// Check if the exam name already exists
if($stmt1->rowCount() > 0){
    $res = array("res" => "exists", "msg" => $add_ExamTitle);
    echo json_encode($res);
    exit();
}

// Prepare and execute the second statement to insert the new exam
$stmt2 = $conn->prepare("INSERT INTO exam_tbl(ex_title, ex_description, ex_time_limit, ex_qstn_limit, ex_disable_prv, ex_random_qstn, ex_status) VALUES (:add_ExamTitle, :add_ExamDesc, :add_ExamTimeLimit, :add_ExamQuestLimit, :add_ExamNoPrev, :add_ExamRandom, :ex_status)");
$stmt2->bindParam(':add_ExamTitle', $add_ExamTitle);
$stmt2->bindParam(':add_ExamDesc', $add_ExamDesc);
$stmt2->bindParam(':add_ExamTimeLimit', $add_ExamTimeLimit);
$stmt2->bindParam(':add_ExamQuestLimit', $add_ExamQuestLimit);
$stmt2->bindParam(':add_ExamNoPrev', $add_ExamNoPrev);
$stmt2->bindParam(':add_ExamRandom', $add_ExamRandom);
$stmt2->bindParam(':ex_status', $ex_status);

// Execute the statement and check if it was successful
if($stmt2->execute()) {
    // FETCH EXAM ID HERE 
    $stmt3 = $conn->prepare("SELECT * FROM exam_tbl WHERE ex_title = :add_ExamTitle");
    $stmt3->bindParam(':add_ExamTitle', $add_ExamTitle);
    $stmt3->execute();

    
    // Check if the exam name already exists
    if($stmt3->rowCount() > 0){
        $result = $stmt3->fetch(PDO::FETCH_ASSOC);
        $checkExam = $result['ex_id'];
    } else {
        $res = array("res" => "norecord", "msg" => $add_ExamTitle);
        echo json_encode($res);
        exit();
    }

    // Prepare and execute the statement to insert clusters
    $stmt4 = $conn->prepare("INSERT INTO exam_cluster_tbl(ex_id, clu_id) VALUES (:ex_id, :clu_id)");
    foreach ($add_ExamCluster as $clu_id) {
        $stmt4->bindParam(':ex_id', $checkExam);
        $stmt4->bindParam(':clu_id', $clu_id);
        $stmt4->execute();
    }

    $res = array("res" => "success", "msg" => $add_ExamTitle);
} else {
    $res = array("res" => "failed", "msg" => $add_ExamTitle);
}

echo json_encode($res);
exit();