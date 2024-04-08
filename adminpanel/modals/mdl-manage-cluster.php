
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
        </div>
    </div>
</div> <!-- #END# ADD CLUSTER MODAL -->