<?php 
include("../../conn.php");

//Variables
$edit_ExmneId = isset($_POST['edit_ExmneId']) ? $_POST['edit_ExmneId'] : '';
$edit_ExmneFname = isset($_POST['edit_ExmneFname']) ? $_POST['edit_ExmneFname'] : '';
$edit_ExmneMname = isset($_POST['edit_ExmneMname']) ? $_POST['edit_ExmneMname'] : '';
$edit_ExmneLname = isset($_POST['edit_ExmneLname']) ? $_POST['edit_ExmneLname'] : '';
$edit_ExmneSfname = isset($_POST['edit_ExmneSfname']) ? $_POST['edit_ExmneSfname'] : '';
$edit_ExmneCluster = isset($_POST['edit_ExmneCluster']) ? $_POST['edit_ExmneCluster'] : '';
$edit_ExmneSex = isset($_POST['edit_ExmneSex']) ? $_POST['edit_ExmneSex'] : '';
$edit_ExmneBirth = isset($_POST['edit_ExmneBirth']) ? $_POST['edit_ExmneBirth'] : '';
$edit_ExmneEmail = isset($_POST['edit_ExmneEmail']) ? $_POST['edit_ExmneEmail'] : '';
$edit_ExmnePass = isset($_POST['edit_ExmnePass']) ? $_POST['edit_ExmnePass'] : '';
$edit_exmneStatus = isset($_POST['edit_ExmneStatus']) ? $_POST['edit_ExmneStatus'] : '';

// Check if variables contain values
if(empty($edit_ExmneId) || empty($edit_ExmneFname) || empty($edit_ExmneLname) || empty($edit_ExmneCluster) || empty($edit_ExmneEmail) || empty($edit_ExmnePass) || $edit_exmneStatus == ''){
    $res = array("res" => "incomplete");
    echo json_encode($res);
    exit();
}

// Prepare and execute the SELECT statement to check for records
$stmt1 = $conn->prepare("SELECT * FROM examinee_tbl WHERE exmne_id = :edit_ExmneId");
$stmt1->bindParam(':edit_ExmneId', $edit_ExmneId);
$stmt1->execute();

// Check if the record exists
if($stmt1->rowCount() == 0){
    $res = array("res" => "norecord");
    echo json_encode($res);
    exit();
}

// Prepare and execute the SELECT statement to check for existing records
$stmt2 = $conn->prepare("SELECT * FROM examinee_tbl WHERE NOT exmne_id = :edit_ExmneId AND ((exmne_fname = :edit_ExmneFname AND exmne_lname = :edit_ExmneLname) OR exmne_email = :edit_ExmneEmail)");
$stmt2->bindParam(':edit_ExmneId', $edit_ExmneId);
$stmt2->bindParam(':edit_ExmneFname', $edit_ExmneFname);
$stmt2->bindParam(':edit_ExmneLname', $edit_ExmneLname);
$stmt2->bindParam(':edit_ExmneEmail', $edit_ExmneEmail);
$stmt2->execute();

// Check if the record already exists
if($stmt2->rowCount() > 0){
    $res = array("res" => "exists");
    echo json_encode($res);
    exit();
}

// If no similar records found, proceed with the update
$stmt3 = $conn->prepare("UPDATE examinee_tbl SET exmne_clu_id = :edit_ExmneCluster, exmne_fname = :edit_ExmneFname, exmne_mname = :edit_ExmneMname, exmne_lname = :edit_ExmneLname, exmne_sfname = :edit_ExmneSfname, exmne_sex = :edit_ExmneSex, exmne_birthdate = :edit_ExmneBirth, exmne_email = :edit_ExmneEmail, exmne_pass = :edit_ExmnePass, exmne_status = :edit_exmneStatus WHERE exmne_id = :edit_ExmneId");
$stmt3->bindParam(':edit_ExmneCluster', $edit_ExmneCluster);
$stmt3->bindParam(':edit_ExmneFname', $edit_ExmneFname);
$stmt3->bindParam(':edit_ExmneMname', $edit_ExmneMname);
$stmt3->bindParam(':edit_ExmneLname', $edit_ExmneLname);
$stmt3->bindParam(':edit_ExmneSfname', $edit_ExmneSfname);
$stmt3->bindParam(':edit_ExmneSex', $edit_ExmneSex);
$stmt3->bindParam(':edit_ExmneBirth', $edit_ExmneBirth);
$stmt3->bindParam(':edit_ExmneEmail', $edit_ExmneEmail);
$stmt3->bindParam(':edit_ExmnePass', $edit_ExmnePass);
$stmt3->bindParam(':edit_exmneStatus', $edit_exmneStatus);
$stmt3->bindParam(':edit_ExmneId', $edit_ExmneId);

// Execute the statement and check if it was successful
if($stmt3->execute()) {
    $res = array("res" => "success", "msg" => $edit_ExmneFname . " " . $edit_ExmneLname);
} else {
    $res = array("res" => "failed", "msg" => $edit_ExmneFname . " " . $edit_ExmneLname);
}

echo json_encode($res);
exit();
