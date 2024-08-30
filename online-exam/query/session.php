<?php
session_start();
include("../../conn.php");

// Set the time zone to Manila, Philippines (Asia/Manila)
date_default_timezone_set('Asia/Manila');

$exmne_id = isset($_SESSION['ex_user']['exmne_id']) ? $_SESSION['ex_user']['exmne_id'] : '';
$check_session_id = isset($_SESSION['sess']["sessionid"]) ? $_SESSION['sess']["sessionid"] : '';
$check_session_time = isset($_SESSION['sess']["time"]) ? $_SESSION['sess']["time"] : '';

// Check if the session variable 'user' is set
if ($check_session_id == '' || $check_session_time == '' || $exmne_id == '') {
    $res = array("res" => "invalid");
    echo json_encode($res);
    exit();
}

// check if session time is greater than 12 hours
// format: date("Y-m-d h:i:s A")
if (strtotime($check_session_time) < strtotime('-24 hours')) {
    $res = array("res" => "expired");
    echo json_encode($res);
    exit();
}

// check if session id match
$stmt = $conn->prepare("SELECT * FROM examinee_session WHERE user_id = :exmne_id AND active_session = :sessionid");
$stmt->bindParam(':sessionid', $check_session_id);
$stmt->bindParam(':exmne_id', $exmne_id);
$stmt->execute();

//check if 0
if ($stmt->rowCount() == 0) {
    //Session mismatch
    $res = array("res" => "mismatch");
    echo json_encode($res);
    exit();
}

$res = array("res" => "valid");
echo json_encode($res);
?>
