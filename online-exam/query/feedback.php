<?php 
include("../../conn.php");

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
        $exmne_fname = isset($row['exmne_fname']) ? $row['exmne_fname'] : 'null';
        $exmne_mname = isset($row['exmne_mname']) ? substr($row['exmne_mname'], 0, 1) . ". " : '_ ';
        $exmne_lname = isset($row['exmne_lname']) ? $row['exmne_lname'] : 'null';
        $exmne_sfname = isset($row['exmne_sfname']) ? $row['exmne_sfname'] : '';
        $exmne_name = $exmne_fname . ' ' . $exmne_mname . $exmne_lname . ' ' . $exmne_sfname;
    }
} else {
    $exmne_name = "Anonymous";
}

//Current date
$add_Date = date("Y-m-d");


// Prepare and execute the second statement to insert the new cluster
$stmt2 = $conn->prepare("INSERT INTO feedback_tbl (exmne_id, fb_exmne_as, fb_feedback, fb_date) VALUES (:add_ExmneId, :add_ExmneName, :add_Feedback, :add_Date)");
$stmt2->bindParam(':add_ExmneId', $add_ExmneId);
$stmt2->bindParam(':add_ExmneName', $exmne_name);
$stmt2->bindParam(':add_Feedback', $add_Feedback);
$stmt2->bindParam(':add_Date', $add_Date);

// Execute the statement and check if it was successful
if($stmt2->execute()) {
    $res = array("res" => "success", "msg" => $exmne_name . "|" . $add_Anonymous);
} else {
    $res = array("res" => "failed");
}

echo json_encode($res);
exit();
