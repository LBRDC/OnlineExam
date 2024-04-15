<?php 
include("../../conn.php");

// Variables
$edit_ExamId = isset($_POST['edit_ExamId']) ? $_POST['edit_ExamId'] : '';
$edit_ExamTitle = isset($_POST['edit_ExamTitle']) ? $_POST['edit_ExamTitle'] : '';
$edit_ExamDesc = isset($_POST['edit_ExamDesc']) ? $_POST['edit_ExamDesc'] : '';
$edit_ExamCluster = isset($_POST['edit_ExamCluster']) ? $_POST['edit_ExamCluster'] : array(); // Ensure it's an array
$edit_ExamQuestLimit = isset($_POST['edit_ExamQuestLimit']) ? $_POST['edit_ExamQuestLimit'] : '';
$edit_ExamTimeLimit = isset($_POST['edit_ExamTimeLimit']) ? $_POST['edit_ExamTimeLimit'] : '';
$edit_ExamRandom = isset($_POST['edit_ExamRandom']) ? $_POST['edit_ExamRandom'] : '';
$edit_ExamNoPrev = isset($_POST['edit_ExamNoPrev']) ? $_POST['edit_ExamNoPrev'] : '';
$edit_ExamStatus = isset($_POST['edit_ExamStatus']) ? $_POST['edit_ExamStatus'] : '';

// Check if all variables contain values
if(empty($edit_ExamTitle) || empty($edit_ExamCluster) || empty($edit_ExamQuestLimit) || empty($edit_ExamTimeLimit)) {
    $res = array("res" => "incomplete");
    echo json_encode($res);
    exit();
}

$stmt1 = $conn->prepare("SELECT * FROM exam_tbl WHERE ex_id = :edit_ExamId");
$stmt1->bindParam(':edit_ExamId', $edit_ExamId);
$stmt1->execute();

// Check if the exam id exists
if($stmt1->rowCount() == 0){
    $res = array("res" => "norecord", "msg" => $edit_ExamTitle);
    echo json_encode($res);
    exit();
} else {
    //assign old exam title
    $check_ExamTitle = $stmt1->fetch(PDO::FETCH_ASSOC)['ex_title'];
}

$stmt2 = $conn->prepare("SELECT * FROM exam_tbl WHERE ex_title = :edit_ExamTitle");
$stmt2->bindParam(':edit_ExamTitle', $edit_ExamTitle);
$stmt2->execute();

// Check if the exam name exists and not equal to the exam title
if($stmt2->rowCount() > 0 && $check_ExamTitle != $edit_ExamTitle){
    $res = array("res" => "exists", "msg" => $edit_ExamTitle);
    echo json_encode($res);
    exit();
}

// Prepare and execute the statement to update the exam
$stmt3 = $conn->prepare("UPDATE exam_tbl SET ex_title = :edit_ExamTitle, ex_description = :edit_ExamDesc, ex_time_limit = :edit_ExamTimeLimit, ex_qstn_limit = :edit_ExamQuestLimit, ex_disable_prv = :edit_ExamNoPrev, ex_random_qstn = :edit_ExamRandom, ex_status = :edit_ExamStatus WHERE ex_id = :edit_ExamId");
$stmt3->bindParam(':edit_ExamTitle', $edit_ExamTitle);
$stmt3->bindParam(':edit_ExamDesc', $edit_ExamDesc);
$stmt3->bindParam(':edit_ExamTimeLimit', $edit_ExamTimeLimit);
$stmt3->bindParam(':edit_ExamQuestLimit', $edit_ExamQuestLimit);
$stmt3->bindParam(':edit_ExamNoPrev', $edit_ExamNoPrev);
$stmt3->bindParam(':edit_ExamRandom', $edit_ExamRandom);
$stmt3->bindParam(':edit_ExamStatus', $edit_ExamStatus);
$stmt3->bindParam(':edit_ExamId', $edit_ExamId);

// Execute the statement and check if it was successful
if($stmt3->execute()) {
    // Prepare and execute the statement to delete old clusters
    $stmt4 = $conn->prepare("DELETE FROM exam_cluster_tbl WHERE ex_id = :edit_ExamId");
    $stmt4->bindParam(':edit_ExamId', $edit_ExamId);
    $stmt4->execute();

    // Prepare and execute the statement to insert new clusters
    $stmt5 = $conn->prepare("INSERT INTO exam_cluster_tbl(ex_id, clu_id) VALUES (:ex_id, :clu_id)");
    foreach ($edit_ExamCluster as $clu_id) {
        $stmt5->bindParam(':ex_id', $edit_ExamId);
        $stmt5->bindParam(':clu_id', $clu_id);
        $stmt5->execute();
    }

    $res = array("res" => "success", "msg" => $edit_ExamTitle);
} else {
    $res = array("res" => "failed", "msg" => $edit_ExamTitle);
}

echo json_encode($res);
exit();
