<?php
/*
    Fetch Attempts
    If > 1 = Output Already Taken
    Else = 

    Fetch Answers
    Check Correct Answers
    Compute Correct / Total
    Input Database

    Fetch Exams
    Check for Not Completed

    If All Complete = Output Finished
    If Not Complete = Output exam_Id
*/

session_start(); 
include("../conn.php");

extract($_POST);

$exmne_id = $_SESSION['ex_user']['exmne_id'];
$exmne_clu_id = $_SESSION['ex_user']['exmne_clu_id'];

//Fetch Next Exam
function fetchExam($clu_id) {
    global $conn;
    // Fetch Exam IDs based on cluster
    $stmtFE1 = $conn->prepare("SELECT ex_id FROM exam_cluster_tbl WHERE clu_id = :clu_id");
    $stmtFE1->bindParam(':clu_id', $clu_id);
    $stmtFE1->execute();

    $unattemptedExamIds = [];

    // Loop through each exam ID fetched from exam_cluster_tbl and check if it has been attempted
    while ($row = $stmtFE1->fetch(PDO::FETCH_ASSOC)) {
        $ex_id = $row['ex_id'];

        // Check if the exam has been attempted
        $stmtFE2 = $conn->prepare("SELECT * FROM examinee_attempt WHERE ex_id = :ex_id");
        $stmtFE2->bindParam(':ex_id', $ex_id);
        $stmtFE2->execute();
        $attempts = $stmtFE2->rowCount();

        // If the exam has not been attempted, add it to the list
        if ($attempts == 0) {
            $unattemptedExamIds[] = $ex_id;
        }
    }

    if (count($unattemptedExamIds) > 0) {
        return $unattemptedExamIds;
    } else {
        return "noexam";
    }
}

//Check Exam Exist
$stmt1 = $conn->prepare("SELECT * FROM exam_tbl WHERE ex_id = :exam_id");
$stmt1->bindParam(':exam_id', $exam_id);
$stmt1->execute();

if ($stmt1->rowCount() > 0) {
    //Check Exam Attempt
    $stmt2 = $conn->prepare("SELECT * FROM exam_attempt WHERE exmne_id = :exmne_id AND ex_id = :exam_id");
    $stmt2->bindParam(':exmne_id', $exmne_id);
    $stmt2->bindParam(':exam_id', $exam_id);
    $stmt2->execute();

    if ($stmt2->rowCount() > 0) {
        $nxtExam = fetchExam($exmne_clu_id);
        if ($nxtExam !== "noexam") {
            $res = array("res" => "notFinised", "examId" => $nxtExam);
            echo json_encode($res);
            exit();
        } else {
            $res = array("res" => "finished");
            echo json_encode($res);
            exit();
        }
    } else {
        $no_Attempt = 1;
        //date
        $date = date('Y-m-d');
        //time
        $time = date('H:i:s');
        
        //Insert Answers to examinee_answers
        $stmt3 = $conn->prepare("INSERT INTO examinee_answers(exmne_id, exam_id, exqstn_id, exmne_answer) VALUES (:exmne_id, :exam_id, :exqstn_id, :exmne_answer)");

        foreach ($_REQUEST['answer'] as $key => $value) {
            // Check if the answer is provided and not empty
            if (isset($value['correct']) && !empty($value['correct'])) {
                $ans = $value['correct'];
                $stmt3->bindParam(':exmne_id', $exmne_id);
                $stmt3->bindParam(':ex_id', $exam_id);
                $stmt3->bindParam(':exqstn_id', $key);
                $stmt3->bindParam(':exmne_answer', $value);
                $stmt3->execute();
            }
        }

        //Add Exam Attempt
        $stmt4 = $conn->prepare("INSERT INTO examinee_attempt(exmne_id, exam_id, exatmpt_no, exatmpt_date, exatmpt_time) VALUES (:exmne_id, :exam_id, :exatmpt_no, :exatmpt_date, :exatmpt_time)");
        $stmt4->bindParam(':exmne_id', $exmne_id);
        $stmt4->bindParam(':exam_id', $exam_id);
        $stmt4->bindParam(':exatmpt_no', $no_Attempt);
        $stmt4->bindParam(':exatmpt_date', $date);
        $stmt4->bindParam(':exatmpt_time', $time);
        
        if ($stmt4->execute()) {
            //Fetch Next Exam
            $nxtExam = fetchExam($exmne_clu_id);
            if ($nxtExam !== "noexam") {
                $res = array("res" => "notFinised", "examId" => $nxtExam);
                echo json_encode($res);
                exit();
            } else {
                $res = array("res" => "finished");
                echo json_encode($res);
                exit();
            }
        } else {
            $res = array("res" => "failedAttempt");
            echo json_encode($res);
            exit();
        }
    }
} else {
    $res = array("res" => "failed", "msg" => "Exam not found.");
    echo json_encode($res);
    exit();
}