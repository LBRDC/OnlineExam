<?php 
    $stmtmdl1 = $conn->prepare("SELECT * FROM cluster_tbl WHERE clu_status=1 ORDER BY clu_id ASC");
    $stmtmdl1->execute();
?>


<!-- ADD EXAM MODAL -->
<div class="modal fade" id="mdlAddExam" tabindex="-1" role="dialog" aria-labelledby="mdlAddExamLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mdlAddExamLabel">Add Exam</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addExamFrm" name="addExamFrm" method="post">
            <div class="modal-body">
                <div class="row mb-2">
                    <div class="col-md-12">
                        <label for="add_ExamTitle">Exam Title<span class="text-danger">*</span></label>
                        <input type="text" name="add_ExamTitle" id="add_ExamTitle" class="form-control" placeholder="" required>
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
                        <label for="add_ExamCluster">Cluster<span class="text-danger">*</span></label>
                        <select class="form-control" name="add_ExamCluster[]" id="add_ExamCluster" multiple="multiple" style="width: 100%;" required>
                            <option value="">Select...</option>
                            <?php 
                                $result = $stmtmdl1->fetchAll(PDO::FETCH_ASSOC);
                                
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
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Add</button>
            </div>
            </form>
        </div>
    </div>
</div> <!-- #END# ADD CLUSTER MODAL -->


<!-- DISABLE EXAM MODAL -->
<div class="modal fade" id="mdlDisableExam" tabindex="-1" role="dialog" aria-labelledby="mdlDisableExamLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mdlDisableExamLabel">Disable <span class="font-weight-bold">NAME</span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="disableExamFrm" name="disableExamFrm" method="post">
            <div class="modal-body">
                <div class="col-md-12">
                    <input type="text" name="disable_ExamId" id="disable_ExamId" value="" hidden required>
                    <input type="text" name="disable_ExamName" id="disable_ExamName" value="" hidden required>
                    <input type="text" name="disable_ExamStatus" id="disable_ExamStatus" value="" hidden required>
                    <div class="form-row mb-2">
                        Are you sure you want to DISABLE&nbsp;<span class="font-weight-bold"></span>?
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-danger">DISABLE</button>
            </div>
            </form>
        </div>
    </div>
</div> <!-- #END# DISABLE EXAM MODAL -->


<!-- ENABLE EXAM MODAL -->
<div class="modal fade" id="mdlEnableExam" tabindex="-1" role="dialog" aria-labelledby="mdlEnableExamLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mdlEnableExamLabel">Enable <span class="font-weight-bold">NAME</span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="enableExamFrm" name="enableExamFrm" method="post">
                <div class="modal-body">
                    <div class="col-md-12">
                        <input type="text" name="enable_ExamId" id="enable_ExamId" value="" hidden required>
                        <input type="text" name="enable_ExamName" id="enable_ExamName" value="" hidden required>
                        <input type="text" name="enable_ExamStatus" id="enable_ExamStatus" value="" hidden required>
                        <div class="form-row mb-2">
                            Are you sure you want to ENABLE&nbsp;<span class="font-weight-bold"></span>?
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">ENABLE</button>
                </div>
                </form>
            </div>
    </div>
</div> <!-- #END# ENABLE CLUSTER MODAL -->