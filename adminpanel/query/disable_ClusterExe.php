<?php 
include("../../conn.php");

$disable_CluId = isset($_POST['disable_CluId']) ? $_POST['disable_CluId'] : '';
$disable_CluName = isset($_POST['disable_CluName']) ? $_POST['disable_CluName'] : '';
$disable_CluStatus = isset($_POST['disable_CluStatus']) ? $_POST['disable_CluStatus'] : '';

if(empty($disable_CluId) || empty($disable_CluName) || empty($disable_CluStatus)) {
    $res = array("res" => "incomplete" , "msg" => $disable_CluId . $disable_CluName . $disable_CluStatus);
    echo json_encode($res);
    exit();
}

// Check if the ID exists
$stmt1 = $conn->prepare("SELECT * FROM cluster_tbl WHERE clu_id = :disable_CluId");
$stmt1->bindParam(':disable_CluId', $disable_CluId);
$stmt1->execute();

if($stmt1->rowCount() == 0){
    // If the ID does not exist, return an error response
    $res = array("res" => "norecord", "msg" => $disable_CluId);
    echo json_encode($res);
    exit();
} else {
    // Fetch the current status of the cluster
    $stmt2 = $conn->prepare("SELECT clu_status FROM cluster_tbl WHERE clu_id = :disable_CluId");
    $stmt2->bindParam(':disable_CluId', $disable_CluId);
    $stmt2->execute();
    $result = $stmt2->fetch(PDO::FETCH_ASSOC);
    $currentStatus = $result['clu_status'];

    // If the current status is already 0, return a message indicating the cluster is already disabled
    if ($currentStatus == 0) {
        $res = array("res" => "exists", "msg" => $disable_CluName);
        echo json_encode($res);
        exit();
    }

    // If disable_CluStatus is 1, set it to 0 before updating
    if ($disable_CluStatus == 1) {
        $disable_CluStatus = 0;
    }

    $stmt3 = $conn->prepare("UPDATE cluster_tbl SET clu_status = :disable_CluStatus WHERE clu_id = :disable_CluId");
    $stmt3->bindParam(':disable_CluStatus', $disable_CluStatus);
    $stmt3->bindParam(':disable_CluId', $disable_CluId);

    if($stmt3->execute()) {
        $res = array("res" => "success", "msg" => $disable_CluName);
    } else {
        $res = array("res" => "failed", "msg" => $disable_CluName);
    }

    echo json_encode($res);
    exit();
}
