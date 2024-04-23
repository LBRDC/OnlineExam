<?php 
session_start();
include("../../conn.php");

extract($_POST);

$stmt = $conn->prepare("SELECT * FROM examinee_tbl WHERE exmne_email = :ex_username AND exmne_pass = :ex_password ");
$stmt->bindParam(':ex_username', $username);
$stmt->bindParam(':ex_password', $pass);
$stmt->execute();

$admin_Acc = $stmt->fetch(PDO::FETCH_ASSOC);

if ($admin_Acc) {
    $_SESSION['user'] = array(
        'admin_fname' => $admin_Acc['admin_fname'],
        'admin_lname' => $admin_Acc['admin_lname'],
        'admin_pos' => $admin_Acc['admin_pos'],
        'admin_super' => $admin_Acc['admin_super']
    );
    $res = array("res" => "success");
} else {
    $res = array("res" => "failed");
}

echo json_encode($res);
