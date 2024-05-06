<?php 
include("../../conn.php");

$delete_UserId = isset($_POST['delete_UserId']) ? $_POST['delete_UserId'] : '';

if(empty($delete_UserId)) {
    $res = array("res" => "incomplete");
    echo json_encode($res);
    exit();
}

$stmt1 = $conn->prepare("SELECT * FROM admin_user WHERE admin_id = :delete_UserId");
$stmt1->bindParam(':delete_UserId', $delete_UserId);
$stmt1->execute();

if($stmt1->rowCount() == 0){
    $res = array("res" => "norecord", "msg" => $delete_UserId);
    echo json_encode($res);
    exit();
}

$stmt2 = $conn->prepare("DELETE FROM admin_user WHERE admin_id = :delete_UserId");
$stmt2->bindParam(':delete_UserId', $delete_UserId);

if($stmt2->execute()) {
    $res = array("res" => "success");
} else {
    $res = array("res" => "failed");
}

echo json_encode($res);
exit();
