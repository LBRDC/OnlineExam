<?php
session_start(); 
include("../../conn.php");

// Set the time zone to Manila, Philippines (Asia/Manila)
date_default_timezone_set('Asia/Manila');

extract($_POST);
//var_dump($_POST); //DEBUG
//exit(); //DEBUG

$exmne_id = $_SESSION['ex_user']['exmne_id'];
$exmne_clu_id = $_SESSION['ex_user']['exmne_clu_id'];

//Fetch Next Exam
function fetchExam($fe_clu_id, $fe_exmne_id) {
    global $conn;
    // Fetch Exam IDs based on cluster
    $stmt1 = $conn->prepare("SELECT ex_id FROM exam_cluster_tbl WHERE clu_id = ?");
    $stmt1->execute([$fe_clu_id]);

    $examIds = $stmt1->fetchAll(PDO::FETCH_COLUMN, 0);

    // If no exams are found, handle this case
    if (empty($examIds)) {
        $unattemptedExamsData = [];
        return;
    }

    // Fetch all exams for the given cluster
    $placeholders = implode(',', array_fill(0, count($examIds), '?'));
    $stmt2 = $conn->prepare("
        SELECT e.*, 
            CASE 
                WHEN ea.ex_id IS NOT NULL THEN 1 
                ELSE 0 
            END AS attempted
        FROM exam_tbl e
        LEFT JOIN examinee_attempt ea ON e.ex_id = ea.ex_id AND ea.exmne_id = ?
        WHERE e.ex_id IN ($placeholders) AND e.ex_status = 1
    ");
    $params = array_merge([$fe_exmne_id], $examIds);
    $stmt2->execute($params);

    $results = $stmt2->fetchAll(PDO::FETCH_ASSOC);

    // Filter out exams that have been attempted
    $unattemptedExams = array_filter($results, function ($exam) {
        return $exam['attempted'] == 0;
    });

    // Custom sorting function
    usort($unattemptedExams, function ($a, $b) {
        $aTitle = $a['ex_title'];
        $bTitle = $b['ex_title'];

        // Check if the title is "APPLICANT RISK PROFILER (ARP)"
        if ($aTitle === 'APPLICANT RISK PROFILER (ARP)' && $bTitle !== 'APPLICANT RISK PROFILER (ARP)') {
            return 1;
        }
        if ($bTitle === 'APPLICANT RISK PROFILER (ARP)' && $aTitle !== 'APPLICANT RISK PROFILER (ARP)') {
            return -1;
        }

        // Extract the numeric part of the title for sorting
        preg_match('/TEST (\d+)/', $aTitle, $aMatch);
        preg_match('/TEST (\d+)/', $bTitle, $bMatch);
        $aNumber = isset($aMatch[1]) ? (int)$aMatch[1] : 0;
        $bNumber = isset($bMatch[1]) ? (int)$bMatch[1] : 0;

        // If both titles are tests, sort by the number
        if ($aNumber > 0 && $bNumber > 0) {
            return $aNumber - $bNumber;
        }

        // For non-test titles, or if one is a test and the other is not, sort alphabetically
        return strcmp($aTitle, $bTitle);
    });

    // DEBUG: Print details of unattempted exams
    /*foreach ($unattemptedExams as $row) {
        echo "Exam Title: " . htmlspecialchars($row['ex_title']) . "<br>";
        echo "Exam ID: " . htmlspecialchars($row['ex_id']) . "<br>";
        echo "Exam Practice: " . htmlspecialchars($row['ex_practice']) . "<br>";
    }*/

    // Store unattempted exam IDs and practices
    $unattemptedExamsData = [];
    foreach ($unattemptedExams as $exam) {
        $unattemptedExamsData[] = [
            'ex_id' => $exam['ex_id'],
            'ex_practice' => $exam['ex_practice']
        ];
    }

    if (count($unattemptedExamsData) > 0) {
        return $unattemptedExamsData[0];
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
        $stmt4 = $conn->prepare("INSERT INTO examinee_attempt(exmne_id, ex_id, cheat_cnt, exatmpt_no, exatmpt_date, exatmpt_time) VALUES (:exmne_id, :exam_id, :exam_cheat, :exatmpt_no, :exatmpt_date, :exatmpt_time)");
        $stmt4->bindParam(':exmne_id', $exmne_id);
        $stmt4->bindParam(':exam_id', $exam_id);
        $stmt4->bindParam(':exam_cheat', $examAC);
        $stmt4->bindParam(':exatmpt_no', $no_Attempt);
        $stmt4->bindParam(':exatmpt_date', $date);
        $stmt4->bindParam(':exatmpt_time', $time);
        
        if ($stmt4->execute()) {
            //Compute Score
            computeScore($exmne_id, $exam_id);
            //Fetch Next Exam
            $nxtExam = fetchExam($exmne_clu_id, $exmne_id);
            if ($nxtExam !== "noexam") {
                $res = array("res" => "notFinished", "examId" => $nxtExam['ex_id'], "practice_st" => $nxtExam['ex_practice']);
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
