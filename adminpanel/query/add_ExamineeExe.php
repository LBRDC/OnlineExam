<?php 
include("../../conn.php");

//Variables
$add_ExmneFname = isset($_POST['add_ExmneFname']) ? $_POST['add_ExmneFname'] : '';
$add_ExmneMname = isset($_POST['add_ExmneMname']) ? $_POST['add_ExmneMname'] : '';
$add_ExmneLname = isset($_POST['add_ExmneLname']) ? $_POST['add_ExmneLname'] : '';
$add_ExmneSfname = isset($_POST['add_ExmneSfname']) ? $_POST['add_ExmneSfname'] : '';
$add_ExmneCluster = isset($_POST['add_ExmneCluster']) ? $_POST['add_ExmneCluster'] : '';
$add_ExmneSex = isset($_POST['add_ExmneSex']) ? $_POST['add_ExmneSex'] : '';
$add_ExmneBirth = isset($_POST['add_ExmneBirth']) ? $_POST['add_ExmneBirth'] : '';
$add_ExmneReligion = isset($_POST['add_ExmneReligion']) ? $_POST['add_ExmneReligion'] : '';
$add_DisableCam = isset($_POST['add_DisableCam']) ? $_POST['add_DisableCam'] : '';
$add_ExmneEmail = isset($_POST['add_ExmneEmail']) ? $_POST['add_ExmneEmail'] : '';
$add_ExmnePass = isset($_POST['add_ExmnePass']) ? $_POST['add_ExmnePass'] : '';
$add_exmneStatus = 1;

// Check if all variables contain values
if(empty($add_ExmneFname) || empty($add_ExmneLname) || empty($add_ExmneCluster) || empty($add_ExmneEmail) || empty($add_ExmnePass)){
    $res = array("res" => "incomplete");
    echo json_encode($res);
    exit();
}

// Prepare and execute the SELECT statement to check for existing records
$stmt1 = $conn->prepare("SELECT * FROM examinee_tbl WHERE (exmne_fname = :add_ExmneFname AND exmne_lname = :add_ExmneLname AND exmne_sfname = :add_ExmneSfname) OR exmne_email = :add_ExmneEmail");
$stmt1->bindParam(':add_ExmneFname', $add_ExmneFname);
$stmt1->bindParam(':add_ExmneSfname', $add_ExmneSfname);
$stmt1->bindParam(':add_ExmneLname', $add_ExmneLname);
$stmt1->bindParam(':add_ExmneEmail', $add_ExmneEmail);
$stmt1->execute();

// Check if the record already exists
if($stmt1->rowCount() > 0){
    $res = array("res" => "exists");
    echo json_encode($res);
    exit();
}

$stmt2 = $conn->prepare("INSERT INTO examinee_tbl (exmne_clu_id, exmne_fname, exmne_mname, exmne_lname, exmne_sfname, exmne_sex, exmne_birthdate, exmne_religion, exmne_disablecam, exmne_email, exmne_pass, exmne_status) VALUES (:add_ExmneCluster, :add_ExmneFname, :add_ExmneMname, :add_ExmneLname, :add_ExmneSfname, :add_ExmneSex, :add_ExmneBirth, :add_ExmneReligion, :add_DisableCam, :add_ExmneEmail, :add_ExmnePass, :add_exmneStatus)");
$stmt2->bindParam(':add_ExmneCluster', $add_ExmneCluster);
$stmt2->bindParam(':add_ExmneFname', $add_ExmneFname);
$stmt2->bindParam(':add_ExmneMname', $add_ExmneMname);
$stmt2->bindParam(':add_ExmneLname', $add_ExmneLname);
$stmt2->bindParam(':add_ExmneSfname', $add_ExmneSfname);
$stmt2->bindParam(':add_ExmneSex', $add_ExmneSex);
$stmt2->bindParam(':add_ExmneBirth', $add_ExmneBirth);
$stmt2->bindParam(':add_ExmneReligion', $add_ExmneReligion);
$stmt2->bindParam(':add_DisableCam', $add_DisableCam);
$stmt2->bindParam(':add_ExmneEmail', $add_ExmneEmail);
$stmt2->bindParam(':add_ExmnePass', $add_ExmnePass);
$stmt2->bindParam(':add_exmneStatus', $add_exmneStatus);

// Execute the statement and check if it was successful
if($stmt2->execute()) {
    $res = array("res" => "success", "msg" => $add_ExmneFname . " " . $add_ExmneLname);
} else {
    $res = array("res" => "failed", "msg" => $add_ExmneFname . " " . $add_ExmneLname);
}

echo json_encode($res);
exit();
