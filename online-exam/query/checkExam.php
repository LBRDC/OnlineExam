<?php
session_start(); 
include("../../conn.php");

$exmne_id = $_SESSION['ex_user']['exmne_id'];
$exmne_clu_id = $_SESSION['ex_user']['exmne_clu_id'];
$check_id = isset($_POST['check_Id']) && !empty($_POST['check_Id']) ? $_POST['check_Id'] : 0;
//$test_id = $_POST['test_Id'];

if ($check_id == 0) {
    $res = array("res" => "unknown", "debugid" => $check_id);
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
    $stmt1 = $conn->prepare("SELECT ex_id FROM exam_cluster_tbl WHERE clu_id = ?");
    $stmt1->execute([$fe_clu_id]);

    $examIds = $stmt1->fetchAll(PDO::FETCH_COLUMN, 0);

    // If no exams are found, handle this case
    if (empty($examIds)) {
        $unattemptedExamsData = [];
        //echo "No exams found for the given cluster.";
        return; // Or exit, depending on your application logic
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
            return 1; // $a should be last
        }
        if ($bTitle === 'APPLICANT RISK PROFILER (ARP)' && $aTitle !== 'APPLICANT RISK PROFILER (ARP)') {
            return -1; // $b should be last
        }

        // Extract the numeric part of the title for sorting
        preg_match('/TEST (\d+)/', $aTitle, $aMatch);
        preg_match('/TEST (\d+)/', $bTitle, $bMatch);
        $aNumber = isset($aMatch[1]) ? (int)$aMatch[1] : 0;
        $bNumber = isset($bMatch[1]) ? (int)$bMatch[1] : 0;

        // If both titles are tests, sort by the number
        if ($aNumber > 0 && $bNumber > 0) {
            return $aNumber - $bNumber; // Sort numerically in ascending order
        }

        // For non-test titles, or if one is a test and the other is not, sort alphabetically
        return strcmp($aTitle, $bTitle);
    });

    // DEBUG: Print details of unattempted exams
    foreach ($unattemptedExams as $row) {
        echo "Exam Title: " . htmlspecialchars($row['ex_title']) . "<br>";
        echo "Exam ID: " . htmlspecialchars($row['ex_id']) . "<br>";
        echo "Exam Practice: " . htmlspecialchars($row['ex_practice']) . "<br>";
    }

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

$testStatus = checkTest($exmne_id, $check_id);
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

$res = array("res" => "incomplete", "examId" => $nextExam['ex_id'], "practice_st" => $nextExam['ex_practice']);
echo json_encode($res);
exit();