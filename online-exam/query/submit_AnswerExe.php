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
include("../../conn.php");

extract($_POST);
//var_dump($_POST);
//exit();

$exmne_id = $_SESSION['ex_user']['exmne_id'];
$exmne_clu_id = $_SESSION['ex_user']['exmne_clu_id'];

//Fetch Next Exam
function fetchExam($fe_clu_id, $fe_exmne_id) {
    global $conn;
    // Fetch Exam IDs based on cluster
    $stmtFE1 = $conn->prepare("SELECT et.ex_id FROM exam_cluster_tbl ect JOIN exam_tbl et ON ect.ex_id = et.ex_id WHERE ect.clu_id = :clu_id AND et.ex_status = 1");
    $stmtFE1->bindParam(':clu_id', $fe_clu_id);
    $stmtFE1->execute();

    $unattemptedExamIds = [];

    // Loop through each exam ID fetched from exam_cluster_tbl and check if it has been attempted
    while ($row = $stmtFE1->fetch(PDO::FETCH_ASSOC)) {
        $ex_id = $row['ex_id'];

        // Check if the exam has been attempted
        $stmtFE2 = $conn->prepare("SELECT * FROM examinee_attempt WHERE ex_id = :ex_id AND exmne_id = :exmne_id");
        $stmtFE2->bindParam(':ex_id', $ex_id);
        $stmtFE2->bindParam(':exmne_id', $fe_exmne_id);
        $stmtFE2->execute();
        $attempts = $stmtFE2->rowCount();

        // If the exam has not been attempted, add it to the list
        if ($attempts == 0) {
            $unattemptedExamIds[] = $ex_id;
        }
    }

    if (count($unattemptedExamIds) > 0) {
        return $unattemptedExamIds[0];
    } else {
        return "noexam";
    }
}

//Compute Score
function computeScore($exmne_id, $ex_id) {
    /*
        Fetch Examinee Answers
        Check Correct Answers
        Compute Correct / Total
    */
    global $conn;
    
    //Fetch Examinee Answers
    $stmtCS1 = $conn->prepare("SELECT * FROM examinee_answers WHERE exmne_id = :exmne_id AND exam_id = :ex_id AND exatmpt_no = '1'");
    $stmtCS1->bindParam(':exmne_id', $exmne_id);
    $stmtCS1->bindParam(':ex_id', $ex_id);
    $stmtCS1->execute();

    $stmtCS2 = $conn->query("SELECT * FROM exam_question_tbl eqt INNER JOIN examinee_answers ea ON eqt.exqstn_id = ea.exqstn_id AND eqt.exqstn_answer = ea.exmne_answer WHERE ea.exmne_id='$exmne_id' AND ea.exam_id='$ex_id' AND ea.exatmpt_no='1' ORDER BY ea.exans_id DESC");
    
    $over = $conn->query("SELECT * FROM exam_question_tbl WHERE ex_id='$ex_id' ")->rowCount();

    $score = $stmtCS2->rowCount();

    $exatmpt_no = 1;

    //Update Score
    $stmtCS3 = $conn->prepare("UPDATE examinee_attempt SET ex_score = :ex_score, ex_total = :ex_total WHERE exmne_id = :exmne_id AND ex_id = :ex_id AND exatmpt_no = :exatmpt_no");
    $stmtCS3->bindParam(':ex_score', $score);
    $stmtCS3->bindParam(':ex_total', $over);
    $stmtCS3->bindParam(':exmne_id', $exmne_id);
    $stmtCS3->bindParam(':ex_id', $ex_id);
    $stmtCS3->bindParam(':exatmpt_no', $exatmpt_no);
    $stmtCS3->execute();
}

//Check Exam Exist
$stmt1 = $conn->prepare("SELECT * FROM exam_tbl WHERE ex_id = :exam_id");
$stmt1->bindParam(':exam_id', $exam_id);
$stmt1->execute();

if ($stmt1->rowCount() > 0) {
    //Check Exam Attempt
    $stmt2 = $conn->prepare("SELECT * FROM examinee_attempt WHERE exmne_id = :exmne_id AND ex_id = :exam_id");
    $stmt2->bindParam(':exmne_id', $exmne_id);
    $stmt2->bindParam(':exam_id', $exam_id);
    $stmt2->execute();

    if ($stmt2->rowCount() > 0) { //Exist
        $nxtExam = fetchExam($exmne_clu_id, $exmne_id);
        if ($nxtExam !== "noexam") {
            $res = array("res" => "notFinished", "examId" => $nxtExam);
            echo json_encode($res);
            exit();
        } else {
            $res = array("res" => "finished");
            echo json_encode($res);
            exit();
        }
    } else { //None Exist
        $no_Attempt = 1;
        $date = date('Y-m-d');
        $time = date('H:i:s');
        
        //Insert Answers to examinee_answers
        $stmt3 = $conn->prepare("INSERT INTO examinee_answers(exmne_id, exam_id, exqstn_id, exatmpt_no, exmne_answer) VALUES (:exmne_id, :exam_id, :exqstn_id, :exatmpt_no, :exmne_answer)");

        if(isset($_REQUEST['answer']) && is_array($_REQUEST['answer'])) {
            foreach ($_REQUEST['answer'] as $key => $value) {
                //var_dump($value);
                // Check if the answer is provided and not empty
                if (isset($value['correct']) && !empty($value['correct'])) {
                    $ans = $value['correct'];
                    $stmt3->bindParam(':exmne_id', $exmne_id);
                    $stmt3->bindParam(':exam_id', $exam_id);
                    $stmt3->bindParam(':exqstn_id', $key);
                    $stmt3->bindParam(':exatmpt_no', $no_Attempt);
                    $stmt3->bindParam(':exmne_answer', $ans);
                    $stmt3->execute();
                }
            }
        }

        //Add Exam Attempt
        $stmt4 = $conn->prepare("INSERT INTO examinee_attempt(exmne_id, ex_id, exatmpt_no, exatmpt_date, exatmpt_time) VALUES (:exmne_id, :exam_id, :exatmpt_no, :exatmpt_date, :exatmpt_time)");
        $stmt4->bindParam(':exmne_id', $exmne_id);
        $stmt4->bindParam(':exam_id', $exam_id);
        $stmt4->bindParam(':exatmpt_no', $no_Attempt);
        $stmt4->bindParam(':exatmpt_date', $date);
        $stmt4->bindParam(':exatmpt_time', $time);
        
        if ($stmt4->execute()) {
            //Compute Score
            computeScore($exmne_id, $exam_id);
            //Fetch Next Exam
            $nxtExam = fetchExam($exmne_clu_id, $exmne_id);
            if ($nxtExam !== "noexam") {
                $res = array("res" => "notFinished", "examId" => $nxtExam);
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
