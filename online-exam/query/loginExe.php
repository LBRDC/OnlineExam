<?php 
//session_unset();
//session_destroy();
session_start();
include("../../conn.php");

// Set the time zone to Manila, Philippines (Asia/Manila)
date_default_timezone_set('Asia/Manila');

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
        'exmne_status' => $exmne_Acc['exmne_status'],
        'exmne_disablecam' => $exmne_Acc['exmne_disablecam'],
    );

    $check_id = $exmne_Acc['exmne_id'];
    $created = date("Y-m-d h:i:s A");
    $sessionid = session_create_id();

    //Check Session
    $stmt2 = $conn->prepare("SELECT * FROM examinee_session WHERE user_id = :exmne_id");
    $stmt2->bindParam(':exmne_id', $check_id);
    $stmt2->execute();

    $sess_check = $stmt2->fetch(PDO::FETCH_ASSOC);

    //if output is greateer than 0
    if ($stmt2->rowCount() > 0) {
        //Update database
        $stmt3 = $conn->prepare("UPDATE examinee_session SET active_session = :sessionid, created = :created WHERE user_id = :exmne_id");
        $stmt3->bindParam(':sessionid', $sessionid);
        $stmt3->bindParam(':created', $created);
        $stmt3->bindParam(':exmne_id', $check_id);
        $stmt3->execute();
    } else {
        $stmt4 = $conn->prepare("INSERT INTO examinee_session (user_id, active_session, created) VALUES (:exmne_id, :sessionid, :created)");
        $stmt4->bindParam(':sessionid', $sessionid);
        $stmt4->bindParam(':created', $created);
        $stmt4->bindParam(':exmne_id', $check_id);
        $stmt4->execute();
    }
    
    $_SESSION['sess'] = array(
        'time' => $created,
        'sessionid' => $sessionid
    );

    $res = array("res" => "success");
} else {
    $res = array("res" => "failed");
}

echo json_encode($res);