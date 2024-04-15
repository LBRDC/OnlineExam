<?php
include("../../conn.php");

// Check if the exam ID is provided
if (!isset($_GET['id'])) {
    echo json_encode(array("error" => "Exam ID not provided"));
    exit;
}

$examId = $_GET['id'];

// Fetch the selected cluster for the given exam ID
$stmt = $conn->prepare("SELECT clu_id FROM exam_cluster_tbl WHERE ex_id = :examId");
$stmt->bindParam(':examId', $examId, PDO::PARAM_INT);
$stmt->execute();

$selectedClusters = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Convert the selected cluster into an array of cluster IDs
$clusterIds = array_map(function($cluster) {
    return $cluster['clu_id'];
}, $selectedClusters);

// Return the selected cluster as a JSON response
echo json_encode($clusterIds);
