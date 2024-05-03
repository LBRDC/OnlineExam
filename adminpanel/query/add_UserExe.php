<?php 
include("../../conn.php");

$add_UserFname = isset($_POST['add_UserFname']) ? $_POST['add_UserFname'] : '';
$add_UserLname = isset($_POST['add_UserLname']) ? $_POST['add_UserLname'] : '';
$add_UserPosition = isset($_POST['add_UserPosition']) ? $_POST['add_UserPosition'] : '';
$add_UserSuper = isset($_POST['add_UserSuper']) ? $_POST['add_UserSuper'] : '';
$add_UserName = isset($_POST['add_UserName']) ? $_POST['add_UserName'] : '';
$add_UserPass = isset($_POST['add_UserPass']) ? $_POST['add_UserPass'] : '';

if(empty($add_UserFname) || empty($add_UserLname) || empty($add_UserName) || empty($add_UserPass)) {
    $res = array("res" => "incomplete");
    echo json_encode($res);
    exit();
}

$stmt1 = $conn->prepare("SELECT * FROM admin_user WHERE admin_username = :add_UserName");
$stmt1->bindParam(':add_UserName', $add_UserName);
$stmt1->execute();

if($stmt1->rowCount() > 0){
    $res = array("res" => "exists", "msg" => $add_UserName);
    echo json_encode($res);
    exit();
}

$stmt2 = $conn->prepare("INSERT INTO admin_user (admin_fname, admin_lname, admin_pos, admin_username, admin_password, admin_super) VALUES (:add_UserFname, :add_UserLname, :add_UserPosition, :add_UserName, :add_UserPass, :add_UserSuper)");
$stmt2->bindParam(':add_UserFname', $add_UserFname);
$stmt2->bindParam(':add_UserLname', $add_UserLname);
$stmt2->bindParam(':add_UserPosition', $add_UserPosition);
$stmt2->bindParam(':add_UserName', $add_UserName);
$stmt2->bindParam(':add_UserPass', $add_UserPass);
$stmt2->bindParam(':add_UserSuper', $add_UserSuper);

if($stmt2->execute()) {
    $res = array("res" => "success", "msg" => $add_UserName);
} else {
    $res = array("res" => "failed", "msg" => $add_UserName);
}

echo json_encode($res);
exit();
