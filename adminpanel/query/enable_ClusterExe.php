<?php 
include("../../conn.php");

$enable_CluId = isset($_POST['enable_CluId']) ? $_POST['enable_CluId'] : '';
$enable_CluName = isset($_POST['enable_CluName']) ? $_POST['enable_CluName'] : '';
$enable_CluStatus = isset($_POST['enable_CluStatus']) ? $_POST['enable_CluStatus'] : '';

if(empty($enable_CluId) || empty($enable_CluName) || is_null($enable_CluStatus)) {
    $res = array("res" => "incomplete" , "msg" => $enable_CluId . ' ' . $enable_CluName . ' ' . $enable_CluStatus);
    echo json_encode($res);
    exit();
}

// Check if the ID exists
$stmt1 = $conn->prepare("SELECT * FROM cluster_tbl WHERE clu_id = :enable_CluId");
$stmt1->bindParam(':enable_CluId', $enable_CluId);
$stmt1->execute();

if($stmt1->rowCount() == 0){
    // If the ID does not exist, return an error response
    $res = array("res" => "norecord", "msg" => $enable_CluId);
    echo json_encode($res);
    exit();
} else {
    // Fetch the current status of the cluster
    $stmt2 = $conn->prepare("SELECT clu_status FROM cluster_tbl WHERE clu_id = :disable_CluId");
    $stmt2->bindParam(':disable_CluId', $enable_CluId);
    $stmt2->execute();
    $result = $stmt2->fetch(PDO::FETCH_ASSOC);
    $currentStatus = $result['clu_status'];

    // If the current status is already 0, return a message indicating the cluster is already enabled
    if ($currentStatus == 1) {
        $res = array("res" => "exists", "msg" => $enable_CluName);
        echo json_encode($res);
        exit();
    }

    // If enable_CluStatus is 1, set it to 0 before updating
    if ($enable_CluStatus == 0) {
        $enable_CluStatus = 1;
    }

    $stmt3 = $conn->prepare("UPDATE cluster_tbl SET clu_status = :enable_CluStatus WHERE clu_id = :enable_CluId");
    $stmt3->bindParam(':enable_CluStatus', $enable_CluStatus);
    $stmt3->bindParam(':enable_CluId', $enable_CluId);

    if($stmt3->execute()) {
        $res = array("res" => "success", "msg" => $enable_CluName);
    } else {
        $res = array("res" => "failed", "msg" => $enable_CluName);
    }

    echo json_encode($res);
    exit();
}
