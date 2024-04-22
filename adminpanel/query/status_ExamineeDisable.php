<?php 
//DB Connection
include("../../conn.php");

//Variables
$disable_ExmneId = isset($_POST['disable_ExmneId']) ? $_POST['disable_ExmneId'] : '';
$disable_ExmneFname = isset($_POST['disable_ExmneFname']) ? $_POST['disable_ExmneFname'] : '';
$disable_ExmneLname = isset($_POST['disable_ExmneLname']) ? $_POST['disable_ExmneLname'] : '';
$disable_ExmneStatus = isset($_POST['disable_ExmneStatus']) ? $_POST['disable_ExmneStatus'] : '';

// Check all variables are not empty
if(empty($disable_ExmneId) || empty($disable_ExmneFname) || empty($disable_ExmneLname) || $disable_ExmneStatus == '') {
    $res = array("res" => "incomplete" , "msg" => $disable_ExmneId . $disable_ExmneFname . $disable_ExmneLname . $disable_ExmneStatus);
    echo json_encode($res);
    exit();
}

// Check if ID exists
$stmt1 = $conn->prepare("SELECT * FROM examinee_tbl WHERE exmne_id = :disable_ExmneId");
$stmt1->bindParam(':disable_ExmneId', $disable_ExmneId);
$stmt1->execute();

if($stmt1->rowCount() == 0){
    $res = array("res" => "norecord", "msg" => $disable_ExmneId);
    echo json_encode($res);
    exit();
} else {
    // Fetch current status of cluster
    $stmt2 = $conn->prepare("SELECT exmne_status FROM examinee_tbl WHERE exmne_id = :disable_ExmneId");
    $stmt2->bindParam(':disable_ExmneId', $disable_ExmneId);
    $stmt2->execute();
    $result = $stmt2->fetch(PDO::FETCH_ASSOC);
    $currentStatus = $result['exmne_status'];

    if ($currentStatus == 0) {
        $res = array("res" => "exists", "msg" => $disable_ExmneFname . " " . $disable_ExmneLname);
        echo json_encode($res);
        exit();
    }

    // If Status is 1, set it to 0 before updating
    if ($disable_ExmneStatus == 1) {
        $disable_ExmneStatus = 0;
    }

    // Update Status
    $stmt3 = $conn->prepare("UPDATE examinee_tbl SET exmne_status = :disable_ExmneStatus WHERE exmne_id = :disable_ExmneId");
    $stmt3->bindParam(':disable_ExmneStatus', $disable_ExmneStatus);
    $stmt3->bindParam(':disable_ExmneId', $disable_ExmneId);

    if($stmt3->execute()) {
        $res = array("res" => "success", "msg" => $disable_ExmneFname . " " . $disable_ExmneLname);
    } else {
        $res = array("res" => "failed", "msg" => $disable_ExmneFname . " " . $disable_ExmneLname);
    }

    echo json_encode($res);
    exit();
}
