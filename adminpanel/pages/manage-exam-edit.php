<?php
    /* ########## EXAM INFORMATION ########## */
    if (!isset($_GET['id'])) {
        echo "<script>swal('Error', 'Exam ID not provided', 'error');";
        echo "window.location.href = '?page=manage-exam';</script>";
    } else {
        $ex_id = $_GET['id'];
    }
    
    if (isset($_GET['tab'])) {
        if ($_GET['tab'] == 'exam-info') {
            $tab = 0;
        } else if ($_GET['tab'] == 'exam-questions') {
            $tab = 1;
        }
    } else {
        $tab = 0;
    }
    
    $stmtei1 = $conn->prepare("SELECT * FROM exam_tbl WHERE ex_id = :ex_id");
    $stmtei1->bindParam(':ex_id', $ex_id);
    $stmtei1->execute();

    // Fetch the result
    $resultei1 = $stmtei1->fetch(PDO::FETCH_ASSOC);

    // Check if the result is not empty to avoid errors
    if ($resultei1) {
        $ex_title = $resultei1['ex_title'];
        $ex_description = $resultei1['ex_description'];
        $ex_time_limit = $resultei1['ex_time_limit'];
        $ex_qstn_limit = $resultei1['ex_qstn_limit'];
        $ex_disable_prv = $resultei1['ex_disable_prv'];
        $ex_random_qstn = $resultei1['ex_random_qstn'];
        $ex_status = $resultei1['ex_status'];
        $ex_status_txt = ($ex_status == 1) ? 'Active' : 'Inactive';
    } else {
        // Handle the case where no exam is found with the given ID
        echo "<script>alert('Exam not found.')";
        echo "window.location.href = '?page=manage-exam';</script>";
        $ex_title = "";
        $ex_description = "";
        $ex_time_limit = "";
        $ex_qstn_limit = "";
        $ex_disable_prv = "";
        $ex_random_qstn = "";
        $ex_status = "";
    }

    // Fetch all clusters
    $stmtei2 = $conn->prepare("SELECT * FROM cluster_tbl ORDER BY clu_id ASC");
    $stmtei2->execute();

    // Separate active and inactive clusters
    $activeClusters = [];
    $inactiveClusters = [];

    $resultei2 = $stmtei2->fetchAll(PDO::FETCH_ASSOC);
    foreach ($resultei2 as $row) {
        if ($row['clu_status'] == 1) {
            $activeClusters[] = $row;
        } else {
            $inactiveClusters[] = $row;
        }
    }

    /* ########## EXAM QUESTIONS ########## */
    //Fetch Exam Questions
    $stmteq1 = $conn->prepare("SELECT * FROM exam_question_tbl WHERE ex_id=:ex_id ORDER BY exqstn_id ASC");
    $stmteq1->bindParam(':ex_id', $ex_id);
    $stmteq1->execute();
    $resulteq1 = $stmteq1->fetchAll(PDO::FETCH_ASSOC);

    //count questions
    $counteq1 = $stmteq1->rowCount();
?>

<!-- #START# manage-exam.php -->
                <!-- ### Exam PAGE ### -->
                <div class="app-main__inner">
                    <!-- Page Title -->
                    <div class="app-page-title">
                        <div class="page-title-wrapper">
                            <div class="page-title-heading">
                                <div class="page-title-icon">
                                    <i class="pe-7s-news-paper icon-gradient bg-sunny-morning">
                                    </i>
                                </div>
                                <div>Manage "<span class="text-warning font-weight-bold"><?php echo htmlspecialchars($ex_title); ?></span>"
                                    <div class="page-title-subheading">
                                        Edit Exam Information and Manage Exam Questions
                                    </div>
                                </div>
                            </div>
                            <div class="page-title-actions">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                                <li class="breadcrumb-item">Management</li>
                                <li class="breadcrumb-item"><a href="?page=manage-exam">Exam</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Edit</li>
                            </ol>
                            </div>
                        </div>
                    </div> <!-- END Page Title -->
                    <!-- Page Tabs -->
                    <a href="?page=manage-exam" class="btn btn-lg btn-dark"><i class="fa fa-arrow-circle-left"></i> Back</a>
                    <ul class="body-tabs body-tabs-layout tabs-animated body-tabs-animated nav" id="exam_tabs">
                        <li class="nav-item">
                            <a role="tab" class="nav-link <?php if($tab==0){echo'active';} ?>" id="tab-0" data-toggle="tab" href="#tab-content-0">
                                <span>Exam Information</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a role="tab" class="nav-link <?php if($tab==1){echo'active';} ?>" id="tab-1" data-toggle="tab" href="#tab-content-1">
                                <span>Exam Questions</span>
                            </a>
                        </li>
                    </ul> <!-- END Page Tabs -->
                    <div class="tab-content">
                        <!-- Exam Information -->
                        <div class="tab-pane tabs-animation fade <?php if($tab==0){echo'show active';} ?>" id="tab-content-0" role="tabpanel">
                            <div class="row justify-content-center">
                                <div class="col-md-11">
                                    <div class="main-card mb-3 card">
                                        <div class="card-body">
                                            <h5 class="card-title">Exam Information</h5>
                                            <div class="m-3">
                                                <form id="editExamFrm" name="editExamFrm" method="post">
                                                    <input type="hidden" name="edit_ExamId" id="edit_ExamId" value="<?php echo $ex_id; ?>">
                                                    <div class="row mb-2">
                                                        <div class="col-md-12">
                                                            <label for="edit_ExamTitle">Exam Title<span class="text-danger">*</span></label>
                                                            <input type="text" name="edit_ExamTitle" id="edit_ExamTitle" class="form-control" placeholder="" value="<?php echo htmlspecialchars($ex_title); ?>" required>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-md-12">
                                                            <label for="edit_ExamDesc">Exam Description</label>
                                                            <textarea name="edit_ExamDesc" id="edit_ExamDesc" class="form-control" rows="5" placeholder=""><?php echo htmlspecialchars($ex_description); ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-md-12">
                                                            <label for="edit_ExamCluster">Cluster<span class="text-danger">*</span></label>
                                                            <select class="form-control" name="edit_ExamCluster[]" id="edit_ExamCluster" multiple="multiple" style="width: 100%;" required>
                                                                <option value="">Select...</option>
                                                                <?php if (!empty($activeClusters)): ?>
                                                                    <optgroup label="Active Clusters">
                                                                        <?php foreach ($activeClusters as $row): ?>
                                                                            <option value="<?= htmlspecialchars($row['clu_id']) ?>"><?= htmlspecialchars($row['clu_name']) ?></option>
                                                                        <?php endforeach; ?>
                                                                    </optgroup>
                                                                <?php else: ?>
                                                                    <optgroup label="Active Clusters">
                                                                        <option value="" disabled="disabled">No active clusters available</option>
                                                                    </optgroup>
                                                                <?php endif; ?>

                                                                <?php if (!empty($inactiveClusters)): ?>
                                                                    <optgroup label="Inactive Clusters">
                                                                        <?php foreach ($inactiveClusters as $row): ?>
                                                                            <option value="<?= htmlspecialchars($row['clu_id']) ?>"><?= htmlspecialchars($row['clu_name']) ?>(disabled)</option>
                                                                        <?php endforeach; ?>
                                                                    </optgroup>
                                                                <?php else: ?>
                                                                    <optgroup label="Inactive Clusters">
                                                                        <option value="" disabled="disabled">No inactive clusters available</option>
                                                                    </optgroup>
                                                                <?php endif; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-md-6">
                                                            <label for="edit_ExamQuestLimit">Question Limit<span class="text-danger">*</span></label>
                                                            <select class="form-control" name="edit_ExamQuestLimit" id="edit_ExamQuestLimit" required>
                                                                <option value="">Select...</option>
                                                                <option value="<?php echo htmlspecialchars($ex_qstn_limit); ?>" selected hidden><?php echo htmlspecialchars($ex_qstn_limit); ?> Questions</option>
                                                                <option value="1">1 Question</option>
                                                                <option value="5">5 Questions</option>
                                                                <option value="10">10 Questions</option>
                                                                <option value="20">20 Questions</option>
                                                                <option value="30">30 Questions</option>
                                                                <option value="40">40 Questions</option>
                                                                <option value="50">50 Questions</option>
                                                                <option value="60">60 Questions</option>
                                                                <option value="70">70 Questions</option>
                                                                <option value="80">80 Questions</option>
                                                                <option value="90">90 Questions</option>
                                                                <option value="100">100 Questions</option>
                                                                <option value="150">150 Questions</option>
                                                                <option value="200">200 Questions</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="edit_ExamTimeLimit">Time Limit<span class="text-danger">*</span></label>
                                                            <select class="form-control" name="edit_ExamTimeLimit" id="edit_ExamTimeLimit" required>
                                                                <option value=""disabled>Select...</option>
                                                                <option value="<?php echo htmlspecialchars($ex_time_limit); ?>" selected hidden><?php echo htmlspecialchars($ex_time_limit); ?> Minutes</option>
                                                                <option value="1">1 Minute</option> 
                                                                <option value="2">2 Minutes</option> 
                                                                <option value="3">3 Minutes</option> 
                                                                <option value="4">4 Minutes</option> 
                                                                <option value="5">5 Minutes</option> 
                                                                <option value="6">6 Minutes</option> 
                                                                <option value="7">7 Minutes</option> 
                                                                <option value="8">8 Minutes</option> 
                                                                <option value="9">9 Minutes</option> 
                                                                <option value="10">10 Minutes</option> 
                                                                <option value="20">20 Minutes</option> 
                                                                <option value="30">30 Minutes</option> 
                                                                <option value="40">40 Minutes</option> 
                                                                <option value="50">50 Minutes</option> 
                                                                <option value="60">60 Minutes</option> 
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-md-12">
                                                            <label>Exam Options</label>
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input" id="edit_ExamRandom" <?php if($ex_random_qstn=='yes'){echo'checked';} ?>>
                                                                <label class="custom-control-label" for="edit_ExamRandom">Randomize Questions</label>
                                                            </div>
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input" id="edit_ExamNoPrev" <?php if($ex_disable_prv=='yes'){echo'checked';} ?>>
                                                                <label class="custom-control-label" for="edit_ExamNoPrev">Disable Previous</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-4">
                                                        <div class="col-md-12">
                                                            <label for="edit_ExamStatus">Status<span class="text-danger">*</span></label>
                                                            <select class="form-control" name="edit_ExamStatus" id="edit_ExamStatus" required>
                                                                <option value="" disabled>Select...</option>
                                                                <option value="<?php echo htmlspecialchars($ex_status); ?>" selected hidden><?php echo htmlspecialchars($ex_status_txt); ?></option>
                                                                <option value="1">Active</option>
                                                                <option value="0">Inactive</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2 justify-content-center">
                                                        <button type="submit" class="btn btn-lg btn-warning">Update</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- END Exam Information -->
                        <!-- Exam Questions -->
                        <div class="tab-pane tabs-animation fade <?php if($tab==1){echo'show active';} ?>" id="tab-content-1" role="tabpanel">
                            <!-- Actions -->
                            <div class="row justify-content-center">
                                <div class="col-md-11">
                                    <div class="main-card mb-3 card">
                                        <div class="card-body">
                                            <h5 class="card-title">Exam Actions</h5>
                                            <a href="javascript:void(0);">
                                                <div class="font-icon-wrapper font-icon-lg btn" id="add-btn" data-toggle="modal" data-target="#mdlAddQuestion" data-toggle="tooltip" data-placement="bottom" title="Add Question" data-add-id="<?php echo htmlspecialchars($ex_id); ?>">
                                                    <i class="fa fa-plus-circle icon-gradient bg-grow-early"></i>
                                                </div>
                                            </a>
                                            <a href="javascript:void(0);">
                                                <div class="font-icon-wrapper font-icon-lg btn" data-toggle="tooltip" data-placement="bottom" title="Save Questions">
                                                    <i class="fa fa-save icon-gradient bg-vicious-stance"></i>
                                                </div>
                                            </a>
                                            <a href="javascript:void(0);">
                                                <div class="font-icon-wrapper font-icon-lg btn" data-toggle="tooltip" data-placement="bottom" title="Import Questions">
                                                    <i class="fa fa-upload icon-gradient bg-deep-blue"></i>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- END Actions -->                                   
                            
                            <!-- Questions -->
                            <div class="row justify-content-center">
                                <div class="col-md-11">
                                    <div class="main-card mb-3 card">
                                        <div class="card-body">
                                            <h5 class="card-title">Exam Questions<span class="ml-2 mb-2 mr-2 badge badge-pill badge-success"><?php echo htmlspecialchars($counteq1); ?></span></h5>
                                            <div class="m-3 scroll-area-lg">
                                                <div class="scrollbar-container ps--active-y">
                                                <table class="mb-0 table table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>Question</th>
                                                            <th style="width: 30%;">Image</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tfoot>
                                                        <tr>
                                                            <th>Question</th>
                                                            <th>Image</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </tfoot>
                                                    <tbody>
                                                        <?php
                                                        if ($resulteq1) {
                                                            $counter = 1;
                                                            foreach ($resulteq1 as $row) {
                                                                $exqstn_id = $row['exqstn_id'];
                                                                $ex_id = $row['ex_id'];
                                                                $exam_image = $row['exam_image'];
                                                                $exam_question = $row['exam_question'];
                                                                $ex_ch1 = $row['exam_ch1'];
                                                                $ex_ch2 = $row['exam_ch2'];
                                                                $ex_ch3 = $row['exam_ch3'];
                                                                $ex_ch4 = $row['exam_ch4'];
                                                                $ex_ch5 = $row['exam_ch5'];
                                                                $ex_ch6 = $row['exam_ch6'];
                                                                $ex_ch7 = $row['exam_ch7'];
                                                                $ex_ch8 = $row['exam_ch8'];
                                                                $ex_ch9 = $row['exam_ch9'];
                                                                $ex_ch10 = $row['exam_ch10'];
                                                                $exqstn_answer = $row['exqstn_answer'];
                                                                ?>
                                                                <tr id="<?php echo $exqstn_id; ?>">
                                                                    <td>
                                                                        <strong><?php echo $counter; ?>).</strong> <?php echo htmlspecialchars($exam_question); ?><br>
                                                                        <?php
                                                                        $choices = [
                                                                            'A' => $ex_ch1,
                                                                            'B' => $ex_ch2,
                                                                            'C' => $ex_ch3,
                                                                            'D' => $ex_ch4,
                                                                            'E' => $ex_ch5,
                                                                            'F' => $ex_ch6,
                                                                            'G' => $ex_ch7,
                                                                            'H' => $ex_ch8,
                                                                            'I' => $ex_ch9,
                                                                            'J' => $ex_ch10
                                                                        ];
                                                                        $correctLetters = array_keys($choices, $exqstn_answer); // Find the keys (letters) for the correct answer
                                                                        if (!empty($correctLetters)) {
                                                                            $correctLetter = $correctLetters[0]; // Use the first correct letter if found
                                                                        } else {
                                                                            $correctLetter = null; // Set to null if no correct answer is found
                                                                        }
                                                                        // Debugging: Print the correct answer for this question
                                                                        //echo "<strong>Correct Answer:</strong> " . htmlspecialchars($correctLetter) . "<br>";
                                                                        foreach ($choices as $letter => $choice) {
                                                                            $isCorrect = $letter == $correctLetter;
                                                                            echo ($isCorrect ? '<span class="pl-4 font-weight-bold text-success">' : '<span class="pl-4">') . $letter . '. ' . htmlspecialchars($choice) . ($isCorrect ? '</span>' : '') . "<br>";
                                                                        }
                                                                        ?>
                                                                    </td>

                                                                    <td>
                                                                        <?php if (!empty($exam_image)) { ?>
                                                                        <a href="javascript:void(0);" id="viewimg-btn" data-toggle="modal" data-target="#mdlViewImage" data-view-img="<?php echo htmlspecialchars($exam_image); ?>">
                                                                        <img src="../uploads/exam_question/<?php echo htmlspecialchars($exam_image); ?>" alt="<?php echo htmlspecialchars($exam_image); ?>" style="width: 50%; height: 50%;">
                                                                        </a>
                                                                        <?php } ?>
                                                                    </td>
                                                                    <td>
                                                                        <a href="javascript:void(0);" class="btn btn-warning m-1" id="edit-btn" data-toggle="modal" data-target="#mdlEditQuestion" data-toggle="tooltip" data-placement="bottom" title="Edit" 
                                                                        data-edit-id="<?php echo htmlspecialchars($exqstn_id); ?>" 
                                                                        data-edit-img="<?php echo htmlspecialchars($exam_image); ?>" 
                                                                        data-edit-question="<?php echo htmlspecialchars($exam_question); ?>" 
                                                                        data-edit-ch1="<?php echo htmlspecialchars($ex_ch1); ?>"
                                                                        data-edit-ch2="<?php echo htmlspecialchars($ex_ch2); ?>"
                                                                        data-edit-ch3="<?php echo htmlspecialchars($ex_ch3); ?>"
                                                                        data-edit-ch4="<?php echo htmlspecialchars($ex_ch4); ?>"
                                                                        data-edit-ch5="<?php echo htmlspecialchars($ex_ch5); ?>"
                                                                        data-edit-ch6="<?php echo htmlspecialchars($ex_ch6); ?>"
                                                                        data-edit-ch7="<?php echo htmlspecialchars($ex_ch7); ?>"
                                                                        data-edit-ch8="<?php echo htmlspecialchars($ex_ch8); ?>"
                                                                        data-edit-ch9="<?php echo htmlspecialchars($ex_ch9); ?>"
                                                                        data-edit-ch10="<?php echo htmlspecialchars($ex_ch10); ?>"
                                                                        data-edit-answer="<?php echo htmlspecialchars($exqstn_answer); ?>">
                                                                            <i class="fas fa-edit"></i>
                                                                        </a>
                                                                        <a href="javascript:void(0);" class="btn btn-danger m-1" id="delete-btn" data-toggle="modal" data-target="#mdlDeleteQuestion" data-toggle="tooltip" data-placement="bottom" title="Delete" 
                                                                        data-delete-id="<?php echo htmlspecialchars($exqstn_id); ?>">
                                                                            <i class="fas fa-trash"></i>
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                                <?php
                                                                $counter++;
                                                            }
                                                        } else {
                                                            echo '<tr><td colspan="4" class="text-center">No Questions Found</td></tr>';
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- END Questions -->
                        </div> <!-- END Exam Questions -->
                    </div>
                </div> <!-- #END# Exam PAGE -->
<!-- #END# manage-exam.php -->
