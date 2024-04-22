<?php 
//DB Connection
include("../../conn.php");

//Variables
$enable_ExmneId = isset($_POST['enable_ExmneId']) ? $_POST['enable_ExmneId'] : '';
$enable_ExmneFname = isset($_POST['enable_ExmneFname']) ? $_POST['enable_ExmneFname'] : '';
$enable_ExmneLname = isset($_POST['enable_ExmneLname']) ? $_POST['enable_ExmneLname'] : '';
$enable_ExmneStatus = isset($_POST['enable_ExmneStatus']) ? $_POST['enable_ExmneStatus'] : '';

// Check all variables are not empty
if(empty($enable_ExmneId) || empty($enable_ExmneFname) || empty($enable_ExmneLname) || $enable_ExmneStatus =='') {
    $res = array("res" => "incomplete" , "msg" => $enable_ExmneId . $enable_ExmneFname . $enable_ExmneLname . $enable_ExmneStatus);
    echo json_encode($res);
    exit();
}

// Check if ID exists
$stmt1 = $conn->prepare("SELECT * FROM examinee_tbl WHERE exmne_id = :enable_ExmneId");
$stmt1->bindParam(':enable_ExmneId', $enable_ExmneId);
$stmt1->execute();

if($stmt1->rowCount() == 0){
    $res = array("res" => "norecord", "msg" => $enable_ExmneId);
    echo json_encode($res);
    exit();
} else {
    // Fetch current status of cluster
    $stmt2 = $conn->prepare("SELECT exmne_status FROM examinee_tbl WHERE exmne_id = :enable_ExmneId");
    $stmt2->bindParam(':enable_ExmneId', $enable_ExmneId);
    $stmt2->execute();
    $result = $stmt2->fetch(PDO::FETCH_ASSOC);
    $currentStatus = $result['exmne_status'];

    if ($currentStatus == 1) {
        $res = array("res" => "exists", "msg" => $enable_ExmneFname . " " . $enable_ExmneLname);
        echo json_encode($res);
        exit();
    }

    // If Status is 1, set it to 0 before updating
    if ($enable_ExmneStatus == 0) {
        $enable_ExmneStatus = 1;
    }

    // Update Status
    $stmt3 = $conn->prepare("UPDATE examinee_tbl SET exmne_status = :enable_ExmneStatus WHERE exmne_id = :enable_ExmneId");
    $stmt3->bindParam(':enable_ExmneStatus', $enable_ExmneStatus);
    $stmt3->bindParam(':enable_ExmneId', $enable_ExmneId);

    if($stmt3->execute()) {
        $res = array("res" => "success", "msg" => $enable_ExmneFname . " " . $enable_ExmneLname);
    } else {
        $res = array("res" => "failed", "msg" => $enable_ExmneFname . " " . $enable_ExmneLname);
    }

    echo json_encode($res);
    exit();
}
