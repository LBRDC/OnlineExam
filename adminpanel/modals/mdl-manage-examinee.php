<?php
// Fetch all clusters
$stmtmdl1 = $conn->prepare("SELECT * FROM cluster_tbl ORDER BY clu_id ASC");
$stmtmdl1->execute();

// Separate active and inactive clusters
$activeClusters = [];
$inactiveClusters = [];

$resultmdl1 = $stmtmdl1->fetchAll(PDO::FETCH_ASSOC);
foreach ($resultmdl1 as $row) {
    if ($row['clu_status'] == 1) {
        $activeClusters[] = $row;
    } else {
        $inactiveClusters[] = $row;
    }
}

?>
<!-- ADD EXAMINEE MODAL -->
<div class="modal fade" id="mdlAddExaminee" tabindex="-1" role="dialog" aria-labelledby="mdlAddExamineeLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mdlAddExamineeLabel">Add Examinee</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addExamineeFrm" name="addExamineeFrm" method="post">
            <div class="modal-body">
                <div class="">
                    <div class="row justify-content-center m-2">
                        <h6 class="font-weight-bold text-muted">Examinee Information</h6>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-3 col-md-12 mb-1">
                            <div class="form-row">
                                <label for="add_ExmneFname">First Name<span class="text-danger">*</span></label>
                                <input type="text" name="add_ExmneFname" id="add_ExmneFname" class="form-control" placeholder="" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-12 mb-1">
                            <div class="form-row">
                                <label for="add_ExmneMname">Middle Name</label>
                                <input type="text" name="add_ExmneMname" id="add_ExmneMname" class="form-control" placeholder="" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-12 mb-1">
                            <div class="form-row">
                                <label for="add_ExmneLname">Last Name<span class="text-danger">*</span></label>
                                <input type="text" name="add_ExmneLname" id="add_ExmneLname" class="form-control" placeholder="" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-12">
                            <div class="form-row">
                                <label for="add_ExmneSfname">Suffix</label>
                                <select class="form-control" name="add_ExmneSfname" id="add_ExmneSfname" style="width: 100%">
                                    <option value="">Select...</option>
                                    <option value="Sr.">Sr.</option>
                                    <option value="Jr.">Jr.</option>
                                    <option value="III">III</option>
                                    <option value="IV">IV</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-12 col-md-12">
                            <div class="form-row">
                                <label for="add_ExmneCluster">Employment Cluster<span class="text-danger">*</span></label>
                                <select class="form-control-lg" name="add_ExmneCluster" id="add_ExmneCluster" style="width: 100%">
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
                                                <option value="<?= htmlspecialchars($row['clu_id']) ?>"><?= htmlspecialchars($row['clu_name']) ?>(inactive)</option>
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
                    </div>
                    <div class="row mb-4">
                        <div class="col-lg-6 col-md-12">
                            <div class="form-row">
                                <label for="add_ExmneSex">Sex</label>
                                <select class="form-control-lg" name="add_ExmneSex" id="add_ExmneSex" style="width: 100%">
                                    <option value="">Select...</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="form-row">
                                <label for="add_ExmneBirth">Birthdate</label>
                                <input type="date" name="add_ExmneBirth" id="add_ExmneBirth" class="form-control" placeholder="" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center m-2">
                        <h6 class="font-weight-bold text-muted">Login Credentials</h6>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-6 col-md-12">
                            <div class="form-row">
                                <label for="add_ExmneEmail">Email<span class="text-danger">*</span></label>
                                <input type="email" name="add_ExmneEmail" id="add_ExmneEmail" class="form-control" placeholder="" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="form-row">
                                <label for="add_ExmnePass">Password<span class="text-danger">*</span></label>
                                <input type="password" name="add_ExmnePass" id="add_ExmnePass" class="form-control" placeholder="" autocomplete="off" requried>
                            </div>
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
</div> <!-- #END# ADD EXAMINEE MODAL -->


<!-- VIEW EXAMINEE MODAL -->
<div class="modal fade" id="mdlViewExaminee" tabindex="-1" role="dialog" aria-labelledby="mdlViewExamineeLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mdlViewExamineeLabel">View "<span class="font-weight-bold text-info">NAME</span>"</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="">
                    <div class="row justify-content-center m-2">
                        <h6 class="font-weight-bold text-muted">Examinee Information</h6>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-3 col-md-12 mb-1">
                            <div class="form-row">
                                <label for="view_ExmneFname">First Name<span class="text-danger">*</span></label>
                                <input type="text" name="view_ExmneFname" id="view_ExmneFname" class="form-control" placeholder="" autocomplete="off" value="" required disabled>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-12 mb-1">
                            <div class="form-row">
                                <label for="view_ExmneMname">Middle Name</label>
                                <input type="text" name="view_ExmneMname" id="view_ExmneMname" class="form-control" placeholder="" autocomplete="off" value="" disabled>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-12 mb-1">
                            <div class="form-row">
                                <label for="view_ExmneLname">Last Name<span class="text-danger">*</span></label>
                                <input type="text" name="view_ExmneLname" id="view_ExmneLname" class="form-control" placeholder="" autocomplete="off" value="" required disabled>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-12">
                            <div class="form-row">
                                <label for="view_ExmneSfname">Suffix</label>
                                <select class="form-control" name="view_ExmneSfname" id="view_ExmneSfname" style="width: 100%" disabled>
                                    <option value=""></option>
                                    <option value="Sr.">Sr.</option>
                                    <option value="Jr.">Jr.</option>
                                    <option value="III">III</option>
                                    <option value="IV">IV</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-12 col-md-12">
                            <div class="form-row">
                                <label for="view_ExmneCluster">Employment Cluster<span class="text-danger">*</span></label>
                                <select class="form-control-lg" name="view_ExmneCluster" id="view_ExmneCluster" style="width: 100%" disabled>
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
                                                <option value="<?= htmlspecialchars($row['clu_id']) ?>"><?= htmlspecialchars($row['clu_name']) ?>(inactive)</option>
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
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-6 col-md-12">
                            <div class="form-row">
                                <label for="view_ExmneSex">Sex</label>
                                <select class="form-control-lg" name="view_ExmneSex" id="view_ExmneSex" style="width: 100%" disabled>
                                    <option value="">Select...</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="form-row">
                                <label for="view_ExmneBirth">Birthdate</label>
                                <input type="date" name="view_ExmneBirth" id="view_ExmneBirth" class="form-control" placeholder="" autocomplete="off" value="" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-4 justify-content-center">
                        <div class="col-lg-4 col-md-12">
                            <label for="view_ExmneStatus">Status<span class="text-danger">*</span></label>
                            <select class="form-control" name="view_ExmneStatus" id="view_ExmneStatus" style="width: 100%" disabled>
                                <option value="">Select...</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                                <option value="3">Disabled</option>
                            </select>
                        </div>
                    </div>
                    <div class="row justify-content-center m-2">
                        <h6 class="font-weight-bold text-muted">Login Credentials</h6>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-6 col-md-12">
                            <div class="form-row">
                                <label for="view_ExmneEmail">Email<span class="text-danger">*</span></label>
                                <input type="email" name="view_ExmneEmail" id="view_ExmneEmail" class="form-control" placeholder="" autocomplete="off" value="" required disabled>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="form-row">
                                <label for="view_ExmnePass">Password<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="password" name="view_ExmnePass" id="view_ExmnePass" class="form-control" placeholder="" autocomplete="off" value="" required disabled>
                                    <div class="input-group-append" id="togglePassword">
                                        <button class="btn btn-outline-secondary"><i class="fas fa-eye" id="revealIcon"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div> <!-- #END# VIEW EXAMINEE MODAL -->


<!-- EDIT EXAMINEE MODAL -->
<div class="modal fade" id="mdlEditExaminee" tabindex="-1" role="dialog" aria-labelledby="mdlEditExamineeLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mdlEditExamineeLabel">Edit "<span class="font-weight-bold text-warning">NAME</span>"</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="EditExamineeFrm" name="EditExamineeFrm" method="post">
            <div class="modal-body">
                <div class="">
                    <input type="text" name="edit_ExmneId" id="edit_ExmneId" value="" hidden readonly>
                    <div class="row justify-content-center m-2">
                        <h6 class="font-weight-bold text-muted">Examinee Information</h6>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-3 col-md-12 mb-1">
                            <div class="form-row">
                                <label for="edit_ExmneFname">First Name<span class="text-danger">*</span></label>
                                <input type="text" name="edit_ExmneFname" id="edit_ExmneFname" class="form-control" placeholder="" autocomplete="off" value="" required>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-12 mb-1">
                            <div class="form-row">
                                <label for="edit_ExmneMname">Middle Name</label>
                                <input type="text" name="edit_ExmneMname" id="edit_ExmneMname" class="form-control" placeholder="" autocomplete="off" value="">
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-12 mb-1">
                            <div class="form-row">
                                <label for="edit_ExmneLname">Last Name<span class="text-danger">*</span></label>
                                <input type="text" name="edit_ExmneLname" id="edit_ExmneLname" class="form-control" placeholder="" autocomplete="off" value="" required>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-12">
                            <div class="form-row">
                                <label for="edit_ExmneSfname">Suffix</label>
                                <select class="form-control" name="edit_ExmneSfname" id="edit_ExmneSfname" style="width: 100%">
                                    <option value="">Select...</option>
                                    <option value="Sr.">Sr.</option>
                                    <option value="Jr.">Jr.</option>
                                    <option value="III">III</option>
                                    <option value="IV">IV</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-12 col-md-12">
                            <div class="form-row">
                                <label for="edit_ExmneCluster">Employment Cluster<span class="text-danger">*</span></label>
                                <select class="form-control-lg" name="edit_ExmneCluster" id="edit_ExmneCluster" style="width: 100%">
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
                                                <option value="<?= htmlspecialchars($row['clu_id']) ?>"><?= htmlspecialchars($row['clu_name']) ?>(inactive)</option>
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
                    </div>
                    <div class="row mb-4">
                        <div class="col-lg-6 col-md-12">
                            <div class="form-row">
                                <label for="edit_ExmneSex">Sex</label>
                                <select class="form-control-lg" name="edit_ExmneSex" id="edit_ExmneSex" style="width: 100%">
                                    <option value="">Select...</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="form-row">
                                <label for="edit_ExmneBirth">Birthdate</label>
                                <input type="date" name="edit_ExmneBirth" id="edit_ExmneBirth" class="form-control" placeholder="" autocomplete="off" value="">
                            </div>
                        </div>
                    </div>
                    <div class="row mb-4 justify-content-center">
                        <div class="col-lg-4 col-md-12">
                            <label for="edit_ExmneStatus">Status<span class="text-danger">*</span></label>
                            <select class="form-control" name="edit_ExmneStatus" id="edit_ExmneStatus" style="width: 100%" required>
                                <option value="">Select...</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                                <option value="3" hidden>Disabled</option>
                            </select>
                        </div>
                    </div>
                    <div class="row justify-content-center m-2">
                        <h6 class="font-weight-bold text-muted">Login Credentials</h6>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-6 col-md-12">
                            <div class="form-row">
                                <label for="edit_ExmneEmail">Email<span class="text-danger">*</span></label>
                                <input type="email" name="edit_ExmneEmail" id="edit_ExmneEmail" class="form-control" placeholder="" autocomplete="off" value="" required>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="form-row">
                                <label for="edit_ExmnePass">Password<span class="text-danger">*</span></label>
                                <input type="password" name="edit_ExmnePass" id="edit_ExmnePass" class="form-control" placeholder="" autocomplete="off" value="" required>
                                <!--<small class="form-text text-muted">Only Administrator can modify the password.</small>-->
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-warning">Update</button>
            </div>
            </form>
        </div>
    </div>
</div> <!-- #END# EDIT EXAMINEE MODAL -->


<!-- DISABLE EXAMINEE MODAL -->
<div class="modal fade" id="mdlDisableExaminee" tabindex="-1" role="dialog" aria-labelledby="mdlDisableExamineeLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mdlDisableExamineeLabel">Disable "<span class="font-weight-bold text-danger">NAME</span>"</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="disableExamineeFrm" name="disableExamineeFrm" method="post">
                <div class="modal-body">
                    <div class="col-md-12">
                        <input type="text" name="disable_ExmneId" id="disable_ExmneId" value=""  required>
                        <input type="text" name="disable_ExmneFname" id="disable_ExmneFname" value=""  required>
                        <input type="text" name="disable_ExmneLname" id="disable_ExmneLname" value=""  required>
                        <input type="text" name="disable_ExmneStatus" id="disable_ExmneStatus" value=""  required>
                        <div class="form-row mb-2">
                            Are you sure you want to DISABLE&nbsp;<span class="font-weight-bold text-danger"></span>?
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
</div> <!-- #END# DISABLE CLUSTER MODAL -->


<!-- DISABLE EXAMINEE MODAL -->
<div class="modal fade" id="mdlDisableExaminee" tabindex="-1" role="dialog" aria-labelledby="mdlDisableExamineeLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mdlDisableExamineeLabel">Disable <span class="font-weight-bold">NAME</span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="disableExamineeFrm" name="disableExamineeFrm" method="post">
                <div class="modal-body">
                    <div class="col-md-12">
                        <input type="text" name="disable_ExmneId" id="disable_ExmneId" value=""  required>
                        <input type="text" name="disable_ExmneFname" id="disable_ExmneFname" value=""  required>
                        <input type="text" name="disable_ExmneLname" id="disable_ExmneLname" value=""  required>
                        <input type="text" name="disable_ExmneStatus" id="disable_ExmneStatus" value=""  required>
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
</div> <!-- #END# DISABLE CLUSTER MODAL -->


<!-- ENABLE EXAMINEE MODAL -->
<div class="modal fade" id="mdlEnableExaminee" tabindex="-1" role="dialog" aria-labelledby="mdlEnableExamineeLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mdlEnableExamineeLabel">Enable "<span class="font-weight-bold text-success">NAME</span>"</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="enableExamineeFrm" name="enableExamineeFrm" method="post">
                <div class="modal-body">
                    <div class="col-md-12">
                        <input type="text" name="enable_ExmneId" id="enable_ExmneId" value=""  required>
                        <input type="text" name="enable_ExmneFname" id="enable_ExmneFname" value=""  required>
                        <input type="text" name="enable_ExmneLname" id="enable_ExmneLname" value=""  required>
                        <input type="text" name="enable_ExmneStatus" id="enable_ExmneStatus" value=""  required>
                        <div class="form-row mb-2">
                            Are you sure you want to ENABLE&nbsp;<span class="font-weight-bold text-success"></span>?
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