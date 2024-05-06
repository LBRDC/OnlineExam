<?php 
include("../../conn.php");

$edit_UserId = isset($_POST['edit_UserId']) ? $_POST['edit_UserId'] : '';
$edit_UserFname = isset($_POST['edit_UserFname']) ? $_POST['edit_UserFname'] : '';
$edit_UserLname = isset($_POST['edit_UserLname']) ? $_POST['edit_UserLname'] : '';
$edit_UserPosition = isset($_POST['edit_UserPosition']) ? $_POST['edit_UserPosition'] : '';
$edit_UserSuper = isset($_POST['edit_UserSuper']) ? $_POST['edit_UserSuper'] : '';
$edit_UserName = isset($_POST['edit_UserName']) ? $_POST['edit_UserName'] : '';
$edit_UserPass = isset($_POST['edit_UserPass']) ? $_POST['edit_UserPass'] : '';

if($edit_UserId == '' || empty($edit_UserFname) || empty($edit_UserLname) || empty($edit_UserName) || empty($edit_UserPass)) {
    $res = array("res" => "incomplete");
    echo json_encode($res);
    exit();
}

$stmt1 = $conn->prepare("SELECT * FROM admin_user WHERE admin_username = :edit_UserName AND NOT admin_id = :edit_UserId");
$stmt1->bindParam(':edit_UserName', $edit_UserName);
$stmt1->bindParam(':edit_UserId', $edit_UserId);
$stmt1->execute();

if($stmt1->rowCount() > 0){
    $res = array("res" => "exists", "msg" => $edit_UserName);
    echo json_encode($res);
    exit();
}

$stmt2 = $conn->prepare("UPDATE admin_user SET admin_fname = :edit_UserFname, admin_lname = :edit_UserLname, admin_pos = :edit_UserPosition, admin_username = :edit_UserName, admin_password = :edit_UserPass, admin_super = :edit_UserSuper WHERE admin_id = :edit_UserId");
$stmt2->bindParam(':edit_UserFname', $edit_UserFname);
$stmt2->bindParam(':edit_UserLname', $edit_UserLname);
$stmt2->bindParam(':edit_UserPosition', $edit_UserPosition);
$stmt2->bindParam(':edit_UserName', $edit_UserName);
$stmt2->bindParam(':edit_UserPass', $edit_UserPass);
$stmt2->bindParam(':edit_UserSuper', $edit_UserSuper);
$stmt2->bindParam(':edit_UserId', $edit_UserId); 

if($stmt2->execute()) {
    $res = array("res" => "success", "msg" => $edit_UserName);
} else {
    $res = array("res" => "failed", "msg" => $edit_UserName);
}

echo json_encode($res);
exit();
