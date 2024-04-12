<?php
    $stmt1 = $conn->prepare("SELECT * FROM cluster_tbl WHERE clu_status=1 ORDER BY clu_id ASC");
    $stmt1->execute();
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
                                <div>Exam Management
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
                    <ul class="body-tabs body-tabs-layout tabs-animated body-tabs-animated nav">
                        <li class="nav-item">
                            <a role="tab" class="nav-link active" id="tab-0" data-toggle="tab" href="#tab-content-0">
                                <span>Exam Information</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a role="tab" class="nav-link" id="tab-1" data-toggle="tab" href="#tab-content-1">
                                <span>Exam Questions</span>
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <!-- Exam Information -->
                        <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
                            <div class="row justify-content-center">
                                <div class="col-md-11">
                                    <div class="main-card mb-3 card">
                                        <div class="card-body">
                                            <h5 class="card-title">Exam Information</h5>
                                            <div class="m-3">
                                                <form id="editExamFrm" name="editExamFrm" method="post">
                                                    <div class="row mb-2">
                                                        <div class="col-md-12">
                                                            <label for="add_ExamTitle">Exam Title<span class="text-danger">*</span></label>
                                                            <input type="text" name="add_ExamTitle" id="add_ExamTitle" class="form-control" placeholder="" value="" required>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-md-12">
                                                            <label for="add_ExamDesc">Exam Description</label>
                                                            <textarea name="add_ExamDesc" id="add_ExamDesc" class="form-control" rows="5" placeholder=""></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-md-12">
                                                            <label for="edit_ExamCluster">Cluster<span class="text-danger">*</span></label>
                                                            <select class="form-control" name="edit_ExamCluster[]" id="edit_ExamCluster" multiple="multiple" style="width: 100%;" required>
                                                                <option value="">Select...</option>
                                                                <?php 
                                                                    $result = $stmt1->fetchAll(PDO::FETCH_ASSOC);
                                                                    
                                                                    // Check if there are any clusters
                                                                    if ($stmt1->rowCount() > 0) {
                                                                        foreach ($result as $row) {
                                                                            echo '<option value="' . htmlspecialchars($row['clu_id']) . '">' . htmlspecialchars($row['clu_name']) . '</option>';
                                                                        }
                                                                    } else {
                                                                        // Display a message if there are no clusters
                                                                        echo '<option value="" disabled="disabled">No clusters available</option>';
                                                                    }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-md-6">
                                                            <label for="add_ExamQuestLimit">Question Limit<span class="text-danger">*</span></label>
                                                            <select class="form-control" name="add_ExamQuestLimit" id="add_ExamQuestLimit" required>
                                                                <option value="">Select...</option>
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
                                                            <label for="add_ExamTimeLimit">Time Limit<span class="text-danger">*</span></label>
                                                            <select class="form-control" name="add_ExamTimeLimit" id="add_ExamTimeLimit" required>
                                                                <option value="">Select...</option>
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
                                                                <input type="checkbox" class="custom-control-input" id="add_ExamRandom">
                                                                <label class="custom-control-label" for="add_ExamRandom" value="yes">Randomize Questions</label>
                                                            </div>
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input" id="add_ExamNoPrev">
                                                                <label class="custom-control-label" for="add_ExamNoPrev" value="yes">Disable Previous</label>
                                                            </div>
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
                        <div class="tab-pane tabs-animation fade" id="tab-content-1" role="tabpanel">
                            <div class="row justify-content-center">
                                <div class="col-md-11">
                                    <div class="main-card mb-3 card">
                                        <div class="card-body">
                                            <h5 class="card-title">Exam Actions</h5>
                                            <a href="javascript:void(0);">
                                                <div class="font-icon-wrapper font-icon-lg btn" data-toggle="tooltip" data-placement="bottom" title="Add Question"><i class="fa fa-plus-circle icon-gradient bg-grow-early"> </i></div>
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
                            </div>                                        
                            
                            <div class="row justify-content-center">
                                <div class="col-md-11">
                                    <div class="main-card mb-3 card">
                                        <div class="card-body">
                                            <h5 class="card-title">Exam Questions<span class="ml-2 mb-2 mr-2 badge badge-pill badge-success">12</span></h5>
                                            <div class="m-3 scroll-area-lg">
                                                <div class="scrollbar-container ps--active-y">
                                                <table class="mb-0 table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Question</th>
                                                        <th>Image</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Question</th>
                                                        <th>Image</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </tfoot>
                                                <tbody>
                                                <tr>
                                                    <th >1</th>
                                                    <td>Question 1?</td>
                                                    <td>IMG</td>
                                                    <td>
                                                        <a href="?page=manage-exam-edit&id=<?php echo htmlspecialchars($ex_id); ?>" class="btn btn-warning m-1" id="edit-btn" data-toggle="tooltip" data-placement="bottom" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <a href="javascript:void(0);" class="btn btn-danger m-1" id="delete-btn" data-toggle="modal" data-target="#mdlDeleteQuestion" data-toggle="tooltip" data-placement="bottom" title="Delete" 
                                                        data-disable-id="<?php echo htmlspecialchars($ex_id); ?>" 
                                                        data-disable-name="<?php echo htmlspecialchars($ex_title); ?>" 
                                                        data-disable-status="<?php echo htmlspecialchars($ex_status); ?>">
                                                            <i class="fas fa-trash"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                                </tbody>
                                                </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- END Exam Questions -->
                    </div>
                </div> <!-- #END# Exam PAGE -->
<!-- #END# manage-exam.php -->
