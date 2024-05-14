
<!-- SAVE RESULT MODAL -->
<div class="modal fade" id="mdlSaveResult" tabindex="-1" role="dialog" aria-labelledby="mdlSaveResultLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mdlSaveResultLabel">Save Exam Result</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="saveResultFrm" name="saveResultFrm" method="post">
                <div class="modal-body">
                    <input type="text" name="savRes_examId" id="savRes_examId" value="" required hidden readonly>
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <label for="savRes_datefrom">From</label>
                            <input type="date" class="form-control" name="savRes_datefrom" id="savRes_datefrom">
                        </div> 
                        <div class="col-lg-6 col-md-12">
                            <label for="savRes_dateto">To</label>
                            <input type="date" class="form-control" name="savRes_dateto" id="savRes_dateto">
                        </div> 
                    </div>
                    <div class="row mt-4 justify-content-center">
                        <div class="col-lg-6 col-md-12 text-center">
                            <small>NOT IMPLEMENTED</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" disabled>Save</button>
                </div>
                </form>
            </div>
    </div>
</div> <!-- #END# SAVE REPORT MODAL -->