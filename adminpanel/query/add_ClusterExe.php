<?php 
include("../../conn.php");

// Use $_POST directly instead of extract($_POST) for better security and clarity
$add_CluName = isset($_POST['add_CluName']) ? $_POST['add_CluName'] : '';
$add_CluDesc = isset($_POST['add_CluDesc']) ? $_POST['add_CluDesc'] : '';

// Check if all variables contain values
if(empty($add_CluName)) {
    $res = array("res" => "incomplete");
    echo json_encode($res);
    exit();
}

// Prepare and execute the first statement
$stmt1 = $conn->prepare("SELECT * FROM cluster_tbl WHERE clu_name = :add_CluName");
$stmt1->bindParam(':add_CluName', $add_CluName);
$stmt1->execute();

// Check if the cluster name already exists
if($stmt1->rowCount() > 0){
    $res = array("res" => "exists", "msg" => $add_CluName . " already exists.");
    echo json_encode($res);
    exit();
}

// Set the cluster status to 1 (active)
$clu_status = 1;
// Prepare and execute the second statement to insert the new cluster
$stmt2 = $conn->prepare("INSERT INTO cluster_tbl (clu_name, clu_description, clu_status) VALUES (:add_CluName, :add_CluDesc, :clu_status)");
$stmt2->bindParam(':add_CluName', $add_CluName);
$stmt2->bindParam(':add_CluDesc', $add_CluDesc);
$stmt2->bindParam(':clu_status', $clu_status);

// Execute the statement and check if it was successful
if($stmt2->execute()) {
    $res = array("res" => "success", "msg" => $add_CluName);
} else {
    $res = array("res" => "failed", "msg" => $add_CluName);
}

echo json_encode($res);
exit();
