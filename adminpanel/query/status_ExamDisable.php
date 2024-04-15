<?php 
//DB Connection
include("../../conn.php");

//Variables
$disable_ExamId = isset($_POST['disable_ExamId']) ? $_POST['disable_ExamId'] : '';
$disable_ExamName = isset($_POST['disable_ExamName']) ? $_POST['disable_ExamName'] : '';
$disable_ExamStatus = isset($_POST['disable_ExamStatus']) ? $_POST['disable_ExamStatus'] : '';

// Check all variables are not empty
if(empty($disable_ExamId) || empty($disable_ExamName) || is_null($disable_ExamStatus)) {
    $res = array("res" => "incomplete" , "msg" => $disable_ExamId . $disable_ExamName . $disable_ExamStatus);
    echo json_encode($res);
    exit();
}

//Check if ID exists
$stmt1 = $conn->prepare("SELECT * FROM exam_tbl WHERE ex_id = :disable_ExamId");
$stmt1->bindParam(':disable_ExamId', $disable_ExamId);
$stmt1->execute();

if($stmt1->rowCount() == 0){
    $res = array("res" => "norecord", "msg" => $disable_ExamName);
    echo json_encode($res);
    exit();
} else {
    //Fetch current status of Exam
    $stmt2 = $conn->prepare("SELECT ex_status FROM exam_tbl WHERE ex_id = :disable_ExamId");
    $stmt2->bindParam(':disable_ExamId', $disable_ExamId);
    $stmt2->execute();
    $result = $stmt2->fetch(PDO::FETCH_ASSOC);
    $currentStatus = $result['ex_status'];

    if ($currentStatus == 0) {
        $res = array("res" => "exists", "msg" => $disable_ExamName);
        echo json_encode($res);
        exit();
    }

    //If Status is 1, set to 0 before updating
    if ($disable_ExamStatus == 1) {
        $disable_ExamStatus = 0;
    }

    //Update exam status
    $stmt3 = $conn->prepare("UPDATE exam_tbl SET ex_status = :disable_ExamStatus WHERE ex_id = :disable_ExamId");
    $stmt3->bindParam(':disable_ExamStatus', $disable_ExamStatus);
    $stmt3->bindParam(':disable_ExamId', $disable_ExamId);

    if($stmt3->execute()) {
        $res = array("res" => "success", "msg" => $disable_ExamName);
    } else {
        $res = array("res" => "failed", "msg" => $disable_ExamName);
    }

    echo json_encode($res);
    exit();
}
