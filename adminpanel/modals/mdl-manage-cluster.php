
<!-- ADD CLUSTER MODAL -->
<div class="modal fade" id="mdlAddCluster" tabindex="-1" role="dialog" aria-labelledby="mdlAddClusterLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mdlAddClusterLabel">Add Employment Cluster</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="addClusterFrm" name="addClusterFrm" method="post">
                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="form-row mb-2">
                            <label for="add_CluName">Name<span class="text-danger">*</span></label>
                            <input type="text" name="add_CluName" id="add_CluName" class="form-control" placeholder="" autocomplete="off" required>
                        </div>
                        <div class="form-row">
                            <label for="add_CluDesc">Description</label>
                            <textarea class="form-control" name="add_CluDesc" id="add_CluDesc" rows="2"></textarea>
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


<!-- EDIT CLUSTER MODAL -->
<div class="modal fade" id="mdlEditCluster" tabindex="-1" role="dialog" aria-labelledby="mdlEditClusterLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mdlEditClusterLabel">Edit <span class="font-weight-bold">NAME</span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editClusterFrm" name="editClusterFrm" method="post">
                <div class="modal-body">
                    <div class="col-md-12">
                        <input type="text" name="edit_CluId" id="edit_CluId" value="" hidden required>
                        <div class="form-row mb-2">
                            <label for="edit_CluName">Name<span class="text-danger">*</span></label>
                            <input type="text" name="edit_CluName" id="edit_CluName" class="form-control" placeholder="" autocomplete="off" value="" required>
                        </div>
                        <div class="form-row mb-2">
                            <label for="edit_CluDesc">Description</label>
                            <textarea class="form-control" name="edit_CluDesc" id="edit_CluDesc" rows="2"></textarea>
                        </div>
                        <div class="form-row">
                            <label for="edit_CluStatus">Status<span class="text-danger">*</span></label>
                            <select class="form-control" name="edit_CluStatus" id="edit_CluStatus" required>
                                <option value="" disabled>Select...</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
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
</div> <!-- #END# EDIT CLUSTER MODAL -->


<!-- DISABLE CLUSTER MODAL -->
<div class="modal fade" id="mdlDisableCluster" tabindex="-1" role="dialog" aria-labelledby="mdlDisableClusterLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mdlDisableClusterLabel">Disable <span class="font-weight-bold">NAME</span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="disableClusterFrm" name="disableClusterFrm" method="post">
                <div class="modal-body">
                    <div class="col-md-12">
                        <input type="text" name="disable_CluId" id="disable_CluId" value="" hidden required>
                        <input type="text" name="disable_CluName" id="disable_CluName" value="" hidden required>
                        <input type="text" name="disable_CluStatus" id="disable_CluStatus" value="" hidden required>
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


<!-- ENABLE CLUSTER MODAL -->
<div class="modal fade" id="mdlEnableCluster" tabindex="-1" role="dialog" aria-labelledby="mdlEnableClusterLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mdlEnableClusterLabel">Enable <span class="font-weight-bold">NAME</span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="enableClusterFrm" name="enableClusterFrm" method="post">
                <div class="modal-body">
                    <div class="col-md-12">
                        <input type="text" name="enable_CluId" id="enable_CluId" value="" hidden required>
                        <input type="text" name="enable_CluName" id="enable_CluName" value="" hidden required>
                        <input type="text" name="enable_CluStatus" id="enable_CluStatus" value="" hidden required>
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