<?php
/*
    Import Exam Questions

    Read Zip archive
    Read Excel file in archive
    Import images in exam_images folder
*/
session_start();
include("../../conn.php");
require '../../vendor/autoload.php';

// Allowed file extensions for ZIP files
$allowedExtensions = ['zip', 'xlsx', 'jpg', 'jpeg', 'webm', 'png'];

// Maximum file size in bytes
$maxSize = 52428800; // 50MB

if (isset($_FILES['zipfile']) && $_FILES['zipfile']['error'] == 0) {
    $zipFilePath = $_FILES['zipfile']['tmp_name'];
    $zipFileName = $_FILES['zipfile']['name'];

    // Check file extension
    $extension = pathinfo($zipFileName, PATHINFO_EXTENSION);
    if (!in_array($extension, $allowedExtensions)) {
        echo "Invalid file extension.";
        exit;
    }

    // Check file size
    if ($_FILES['zipfile']['size'] > $maxSize) {
        echo "File size exceeds the limit.";
        exit;
    }

    $zip = new ZipArchive;
    if ($zip->open($zipFilePath) === TRUE) {
        if ($zip->numFiles > 0) {
            $zip->extractTo('uploads/'); 
            $zip->close();

            // Check if the Excel file exists in the extracted files
            $excelFiles = glob('uploads/*.{xlsx}', GLOB_BRACE);
            if (count($excelFiles) > 0) {
                $excelFilePath = $excelFiles[0];
                $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($excelFilePath);
                if ($spreadsheet->getSheetCount() > 0) {
                    $worksheet = $spreadsheet->getActiveSheet();
                    $rows = $worksheet->toArray();

                    foreach ($rows as $row) {
                        $exam_image = $row[0]; 
                        $exam_question = $row[1]; 
                        $exam_ch1 = $row[2]; 
                        $exam_ch2 = $row[3]; 
                        $exam_ch3 = $row[4]; 
                        $exam_ch4 = $row[5]; 
                        $exam_ch5 = $row[6]; 
                        $exam_ch6 = $row[7]; 
                        $exam_ch7 = $row[8]; 
                        $exam_ch8 = $row[9]; 
                        $exam_ch9 = $row[10]; 
                        $exam_ch10 = $row[11]; 
                        $exqstn_answer = $row[12];

                        $stmt = $conn->prepare("INSERT INTO exam_question_tbl (exam_image, exam_question, exam_ch1, exam_ch2, exam_ch3, exam_ch4, exam_ch5, exam_ch6, exam_ch7, exam_ch8, exam_ch9, exam_ch10, exqstn_answer) VALUES (:exam_image, :exam_question, :exam_ch1, :exam_ch2, :exam_ch3, :exam_ch4, :exam_ch5, :exam_ch6, :exam_ch7, :exam_ch8, :exam_ch9, :exam_ch10, :exqstn_answer)");
                        $stmt->bindParam(':exam_image', $exam_image);
                        $stmt->bindParam(':exam_question', $exam_question);
                        $stmt->bindParam(':exam_ch1', $exam_ch1);
                        $stmt->bindParam(':exam_ch2', $exam_ch2);
                        $stmt->bindParam(':exam_ch3', $exam_ch3);
                        $stmt->bindParam(':exam_ch4', $exam_ch4);
                        $stmt->bindParam(':exam_ch5', $exam_ch5);
                        $stmt->bindParam(':exam_ch6', $exam_ch6);
                        $stmt->bindParam(':exam_ch7', $exam_ch7);
                        $stmt->bindParam(':exam_ch8', $exam_ch8);
                        $stmt->bindParam(':exam_ch9', $exam_ch9);
                        $stmt->bindParam(':exam_ch10', $exam_ch10);
                        $stmt->bindParam(':exqstn_answer', $exqstn_answer);
                        $stmt->execute();
                    }
                }
            }

            // Check image files for validity
            $imageFiles = glob('uploads/*.{jpg,jpeg,webm,png}', GLOB_BRACE);
            foreach ($imageFiles as $imageFile) {
                // Attempt to open the image file to verify its integrity
                if (getimagesize($imageFile)) {
                    echo "Image file is valid.";
                } else {
                    echo "Image file is corrupted.";
                }
            }
        }
    }
}

echo json_encode();
exit();