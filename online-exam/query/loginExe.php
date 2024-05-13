<?php 
session_start();
include("../../conn.php");

extract($_POST);
$ex_Status = 1;

$stmt = $conn->prepare("SELECT * FROM examinee_tbl WHERE (exmne_email = :ex_email AND exmne_pass = :ex_password) AND exmne_status = :ex_Status");
$stmt->bindParam(':ex_email', $username);
$stmt->bindParam(':ex_password', $pass);
$stmt->bindParam(':ex_Status', $ex_Status);
$stmt->execute();

$exmne_Acc = $stmt->fetch(PDO::FETCH_ASSOC);

if ($exmne_Acc) {
    $_SESSION['ex_user'] = array(
        'exmne_id' => $exmne_Acc['exmne_id'],
        'exmne_clu_id' => $exmne_Acc['exmne_clu_id'],
        'exmne_fname' => $exmne_Acc['exmne_fname'],
        'exmne_mname' => $exmne_Acc['exmne_mname'],
        'exmne_lname' => $exmne_Acc['exmne_lname'],
        'exmne_sfname' => $exmne_Acc['exmne_sfname'],
        'exmne_disablecam' => $exmne_Acc['exmne_disablecam'],
    );
    $res = array("res" => "success");
} else {
    $res = array("res" => "failed");
}

echo json_encode($res);