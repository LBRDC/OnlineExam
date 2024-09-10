<?php
session_start(); 
include("../../conn.php");

$exmne_religion = isset($_SESSION['ex_user']['exmne_religion']) ? $_SESSION['ex_user']['exmne_religion'] : '';

// Assume $exmne_religion is already defined somewhere in your code
$query = "SELECT * FROM page_messages ";
                                            
if ($exmne_religion == 1 || $exmne_religion == 2) {
    $query .= "";
} else {
    $query .= " WHERE religion != 1 ";
}

$query .= " ORDER BY RAND() LIMIT 1";

// Prepare and execute the query
$stmt4 = $conn->prepare($query);
$stmt4->execute();

if ($stmt4->rowCount() > 0) {
    $msg = $stmt4->fetch(PDO::FETCH_ASSOC);
    $msg_txt = $msg['msg_text'];
    $msg_src = $msg['src_text'];
} else {
    $msg_txt = "There are no secrets to success. It is the result of preparation, hard work, and learning from failure.";
    $msg_src = "General Colin Powell, former US Secretary of State";
}

$res = array('msg_txt' => $msg_txt, 'msg_src' => $msg_src);
echo json_encode($res);
exit();