<?php 
include("../../conn.php");

// Set the time zone to Manila, Philippines (Asia/Manila)
date_default_timezone_set('Asia/Manila');

// Use $_POST directly instead of extract($_POST) for better security and clarity
$add_ExmneId = isset($_POST['add_ExmneId']) ? $_POST['add_ExmneId'] : '';
$add_Feedback = isset($_POST['add_Feedback']) ? $_POST['add_Feedback'] : '';
$add_Anonymous = isset($_POST['add_Anonymous']) ? $_POST['add_Anonymous'] : '';

// Check if all variables contain values
if(empty($add_ExmneId)) {
    $res = array("res" => "incomplete");
    echo json_encode($res);
    exit();
}

if ($add_Anonymous != "yes") {
    //Fetch Exmne Details
    $stmt1 = $conn->prepare("SELECT * FROM examinee_tbl WHERE exmne_id = :add_ExmneId");
    $stmt1->bindParam(':add_ExmneId', $add_ExmneId);
    $stmt1->execute();

    if ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
        // Prepare examinee name
        $exmne_fname = $row['exmne_fname'] != '' ? $row['exmne_fname'] : 'null';
        $exmne_mname = $row['exmne_mname'] != '' ? substr($row['exmne_mname'], 0, 1) . ". " : '_ ';
        $exmne_lname = $row['exmne_lname'] != '' ? $row['exmne_lname'] : 'null';
        $exmne_sfname = $row['exmne_sfname'] != '' ? $row['exmne_sfname'] : '';
        $exmne_name = $exmne_lname . ", " . $exmne_fname . " " . $exmne_mname . $exmne_sfname;
    }
} else {
    $exmne_name = "Anonymous";
}

//Current date
$add_Date = date("Y-m-d");

// check if user already submitted feedback
$stmt2 = $conn->prepare("SELECT * FROM feedback_tbl WHERE exmne_id = :add_ExmneId");
$stmt2->bindParam(':add_ExmneId', $add_ExmneId);
$stmt2->execute();

$stmt3 = $conn->prepare("UPDATE feedback_tbl SET fb_exmne_as = :add_ExmneName, fb_feedback = :add_Feedback, fb_date = :add_Date WHERE exmne_id = :add_ExmneId");
$stmt4 = $conn->prepare("INSERT INTO feedback_tbl (exmne_id, fb_exmne_as, fb_feedback, fb_date) VALUES (:add_ExmneId, :add_ExmneName, :add_Feedback, :add_Date)");

if ($stmt2->rowCount() > 0) {
    // Update
    $stmt3->bindParam(':add_ExmneId', $add_ExmneId);
    $stmt3->bindParam(':add_ExmneName', $exmne_name);
    $stmt3->bindParam(':add_Feedback', $add_Feedback);
    $stmt3->bindParam(':add_Date', $add_Date);
    $stmt3->execute();
    $fb_result = "success";
} else {
    // Add
    $stmt4->bindParam(':add_ExmneId', $add_ExmneId);
    $stmt4->bindParam(':add_ExmneName', $exmne_name);
    $stmt4->bindParam(':add_Feedback', $add_Feedback);
    $stmt4->bindParam(':add_Date', $add_Date);
    $stmt4->execute();
    $fb_result = "success";
}

// Execute the statement and check if it was successful
if($fb_result == "success") {
    $res = array("res" => "success", "msg" => $exmne_name . "|" . $add_Anonymous);
} else {
    $res = array("res" => "failed");
}

echo json_encode($res);
exit();
