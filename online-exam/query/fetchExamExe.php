<?php
include("../../conn.php");

// Use $_POST directly instead of extract($_POST) for better security and clarity
$clu_id = $_SESSION['ex_user']['exmne_clu_id'];

// Fetch Exam IDs based on cluster
$stmt1 = $conn->prepare("SELECT ex_id FROM exam_cluster_tbl WHERE clu_id = :clu_id");
$stmt1->bindParam(':clu_id', $clu_id);
$stmt1->execute();

// Fetch Attempt
$stmt3 = $conn->prepare("SELECT * FROM examinee_attempt WHERE ex_id = :ex_id");

// Loop through each exam ID fetched from exam_cluster_tbl
while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
    $ex_id = $row['ex_id'];

    // Fetch Exam Details for each exam ID
    $stmt2 = $conn->prepare("SELECT * FROM exam_tbl WHERE ex_id = :ex_id");
    $stmt2->bindParam(':ex_id', $ex_id);
    $stmt2->execute();

    if ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
        $ex_title = $row['ex_title'];
        $ex_status = $row['ex_status'];

        // Fetch the number of attempts for the current exam
        $stmt3->bindParam(':ex_id', $ex_id);
        $stmt3->execute();
        $attempts = $stmt3->rowCount();

        // Determine if the exam is completed
        $completed = $attempts > 0 ? 'Completed' : 'Not Completed';

        if ($completed != 'Completed') {
            $res = array("res" => "success", "msg" => $add_CluName);
        } else {
            $res = array("res" => "complete", "msg" => $add_CluName);
        }
    } 
    
    // End of if statement checking if exam details are fetched
} // End of while loop for exam IDs

// echo json_encode($completed);
