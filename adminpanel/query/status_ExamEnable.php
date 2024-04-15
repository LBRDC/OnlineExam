<?php 
//DB Connection
include("../../conn.php");

//Variables
$enable_ExamId = isset($_POST['enable_ExamId']) ? $_POST['enable_ExamId'] : '';
$enable_ExamName = isset($_POST['enable_ExamName']) ? $_POST['enable_ExamName'] : '';
$enable_ExamStatus = isset($_POST['enable_ExamStatus']) ? $_POST['enable_ExamStatus'] : '';

// Check all variables are not empty
if(empty($enable_ExamId) || empty($enable_ExamName) || is_null($enable_ExamStatus)) {
    $res = array("res" => "incomplete" , "msg" => $enable_ExamId . $enable_ExamName . $enable_ExamStatus);
    echo json_encode($res);
    exit();
}

// Check if ID exists
$stmt1 = $conn->prepare("SELECT * FROM exam_tbl WHERE ex_id = :enable_ExamId");
$stmt1->bindParam(':enable_ExamId', $enable_ExamId);
$stmt1->execute();

if($stmt1->rowCount() == 0){
    $res = array("res" => "norecord", "msg" => $enable_ExamId);
    echo json_encode($res);
    exit();
} else {
    // Fetch current status of exam
    $stmt2 = $conn->prepare("SELECT ex_status FROM exam_tbl WHERE ex_id = :enable_ExamId");
    $stmt2->bindParam(':enable_ExamId', $enable_ExamId);
    $stmt2->execute();
    $result = $stmt2->fetch(PDO::FETCH_ASSOC);
    $currentStatus = $result['ex_status'];

    if ($currentStatus == 1) {
        $res = array("res" => "exists", "msg" => $enable_ExamName);
        echo json_encode($res);
        exit();
    }

    // If Status is 0, set it to 1 before updating
    if ($enable_ExamStatus == 0) {
        $enable_ExamStatus = 1;
    }

    $stmt3 = $conn->prepare("UPDATE exam_tbl SET ex_status = :enable_ExamStatus WHERE ex_id = :enable_ExamId");
    $stmt3->bindParam(':enable_ExamStatus', $enable_ExamStatus);
    $stmt3->bindParam(':enable_ExamId', $enable_ExamId);

    if($stmt3->execute()) {
        $res = array("res" => "success", "msg" => $enable_ExamName);
    } else {
        $res = array("res" => "failed", "msg" => $enable_ExamName);
    }

    echo json_encode($res);
    exit();
}
