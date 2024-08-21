<?php
session_start(); 
include("../../conn.php");

$exmne_id = $_SESSION['ex_user']['exmne_id'];
$exmne_clu_id = $_SESSION['ex_user']['exmne_clu_id'];
$check_id = isset($_POST['check_Id']) && !empty($_POST['check_Id']) ? $_POST['check_Id'] : 0;
//$test_id = $_POST['test_Id'];

if ($test_id == 0) {
    $res = array("res" => "unknown", "debugid" => $test_id);
    echo json_encode($res);
    exit();
}

//Check Current Test
function checkTest($ce_exmne_id, $tst_id) {
    global $conn;
    // Check if the exam has been attempted
    $stmtCT1 = $conn->prepare("SELECT * FROM examinee_attempt WHERE ex_id = :ex_id AND exmne_id = :exmne_id");
    $stmtCT1->bindParam(':ex_id', $tst_id);
    $stmtCT1->bindParam(':exmne_id', $ce_exmne_id);
    $stmtCT1->execute();
    $attempt = $stmtCT1->rowCount();

    return $attempt;
}

//Fetch Next Exam
function fetchExam($fe_clu_id, $fe_exmne_id) {
    global $conn;
    // Fetch Exam IDs based on cluster
    $stmt1 = $conn->prepare("SELECT * FROM exam_cluster_tbl WHERE clu_id = :clu_id");
    $stmt1->bindParam(':clu_id', $fe_clu_id);
    $stmt1->execute();

    $unattemptedExams = [];

    while ($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)) {
        $ex_id = $row1['ex_id'];

        // Fetch all exam titles and check if the exam has been attempted
        $stmt2 = $conn->prepare("
        SELECT e.*, 
            CASE 
                WHEN ea.ex_id IS NOT NULL THEN 1 
                ELSE 0 
            END AS attempted
        FROM exam_tbl e
        LEFT JOIN examinee_attempt ea ON e.ex_id = ea.ex_id AND ea.exmne_id = :exmne_id
        WHERE e.ex_id = :ex_id AND e.ex_status = 1
        ");
        $stmt2->bindParam(':ex_id', $ex_id);
        $stmt2->bindParam(':exmne_id', $fe_exmne_id);
        $stmt2->execute();
        $results = $stmt2->fetchAll(PDO::FETCH_ASSOC);

        // Filter out exams that have been attempted
        $unattemptedExamsForCluster = array_filter($results, function ($exam) {
            return $exam['attempted'] == 0;
        });

        // Custom sort function
        usort($unattemptedExamsForCluster, function ($a, $b) {
            $a_title = $a['ex_title'];
            $b_title = $b['ex_title'];

            // If a title contains "APPLICANT RISK", it should go last
            if (stripos($a_title, 'APPLICANT RISK') !== false) return 1;
            if (stripos($b_title, 'APPLICANT RISK') !== false) return -1;

            // Extract the number from "TEST X: ..." titles
            preg_match('/^TEST (\d+):/', $a_title, $a_match);
            preg_match('/^TEST (\d+):/', $b_title, $b_match);

            if ($a_match && $b_match) {
                // Compare numbers if both are "TEST X: ..."
                return (int)$a_match[1] <=> (int)$b_match[1];
            } elseif ($a_match) {
                // TEST entries should come before non-TEST entries
                return -1;
            } elseif ($b_match) {
                return 1;
            }

            // Fallback to a default string comparison
            return strcmp($a_title, $b_title);
        });

        // Store unattempted exam IDs and practices
        foreach ($unattemptedExamsForCluster as $exam) {
            $unattemptedExams[] = [
                'ex_id' => $exam['ex_id'],
                'ex_practice' => $exam['ex_practice']
            ];
        }
    }

    if (count($unattemptedExams) > 0) {
        return $unattemptedExams[0];
    } else {
        return "noexam";
    }
}

$testStatus = checkTest($exmne_id, $test_id);
$nextExam = fetchExam($exmne_clu_id, $exmne_id);

if ($testStatus > 0 && $nextExam !== "noexam") {
    $res = array("res" => "completeCurr", "examId" => $nextExam);
    echo json_encode($res);
    exit();
} 

if ($nextExam === "noexam") {
    $res = array("res" => "complete");
    echo json_encode($res);
    exit();
} 

$res = array("res" => "incomplete", "examId" => $nextExam[0]['ex_id'], "practice_st" => $nextExam[0]['ex_practice']);
echo json_encode($res);
exit();