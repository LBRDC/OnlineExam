<?php
session_start(); 
include("../../conn.php");

//Select one Random
$stmt1 = $conn->prepare("SELECT * FROM `page_messages` ORDER BY RAND() LIMIT 1");

if ($stmt1->execute()) {
    $msg = $stmt1->fetch(PDO::FETCH_ASSOC);
    $msg_txt = $msg['msg_text'];
    $msg_src = $msg['src_text'];
} else {
    $msg_txt = "The LORD makes firm the steps of the one who delights in him; though he may stumble, he will not fall, for the LORD upholds him with his hand.";
    $msg_src = "Psalm 37:23-24";
}

$res = array('msg_txt' => $msg_txt, 'msg_src' => $msg_src);
echo json_encode($res);
exit();