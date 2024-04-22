<?php 
include("../../conn.php");

$edit_CluId = isset($_POST['edit_CluId']) ? $_POST['edit_CluId'] : '';
$edit_CluName = isset($_POST['edit_CluName']) ? $_POST['edit_CluName'] : '';
$edit_CluDesc = isset($_POST['edit_CluDesc']) ? $_POST['edit_CluDesc'] : '';
$edit_CluStatus = isset($_POST['edit_CluStatus']) ? $_POST['edit_CluStatus'] : '';

if(empty($edit_CluId) || empty($edit_CluName) || $edit_CluStatus == '') {
    $res = array("res" => "incomplete" , "msg" => $edit_CluId . $edit_CluName . $edit_CluStatus);
    echo json_encode($res);
    exit();
}

// Check if the ID exists
$stmt1 = $conn->prepare("SELECT * FROM cluster_tbl WHERE clu_id = :edit_CluId");
$stmt1->bindParam(':edit_CluId', $edit_CluId);
$stmt1->execute();

if($stmt1->rowCount() == 0){
    // If the ID does not exist, return an error response
    $res = array("res" => "norecord", "msg" => $edit_CluId);
    echo json_encode($res);
    exit();
} else {
    // If the ID exists, proceed with checking if the name exists excluding the current record
    $stmt2 = $conn->prepare("SELECT * FROM cluster_tbl WHERE clu_name = :edit_CluName AND clu_id != :edit_CluId");
    $stmt2->bindParam(':edit_CluName', $edit_CluName);
    $stmt2->bindParam(':edit_CluId', $edit_CluId);
    $stmt2->execute();

    if($stmt2->rowCount() > 0){
        $res = array("res" => "exists", "msg" => $edit_CluName);
        echo json_encode($res);
        exit();
    } else {
        $stmt3 = $conn->prepare("UPDATE cluster_tbl SET clu_name = :edit_CluName, clu_description = :edit_CluDesc, clu_status = :edit_CluStatus WHERE clu_id = :edit_CluId");
        $stmt3->bindParam(':edit_CluName', $edit_CluName);
        $stmt3->bindParam(':edit_CluDesc', $edit_CluDesc);
        $stmt3->bindParam(':edit_CluStatus', $edit_CluStatus);
        $stmt3->bindParam(':edit_CluId', $edit_CluId);

        if($stmt3->execute()) {
            $res = array("res" => "success", "msg" => $edit_CluName);
        } else {
            $res = array("res" => "failed", "msg" => $edit_CluName);
        }

        echo json_encode($res);
        exit();
    }
}
