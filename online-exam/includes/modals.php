<!-- FEEDBACK MODAL -->
<div class="modal fade" id="mdlFeedback" tabindex="-1" role="dialog" aria-labelledby="mdlFeedbackLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mdlFeedbackLabel">Feedback</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="feedbackFrm" name="feedbackFrm" method="post">
            <div class="modal-body">
                <input type="text" name="add_ExmneId" id="add_ExmneId" value="" hidden required readonly>
                <div class="row mb-2">
                    <div class="col-md-12">
                        <label for="add_Feedback">Feedback</label>
                        <textarea name="add_Feedback" id="add_Feedback" class="form-control" rows="5" placeholder=""></textarea>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-12">
                        <label>Options</label>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="add_Anonymous" value="yes">
                            <label class="custom-control-label" for="add_Anonymous">Anonymous</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            </form>
        </div>
    </div>
</div> <!-- #END# FEEDBACK MODAL -->


<!-- System Info MODAL -->
<div class="modal fade" id="mdlSystemInfo" tabindex="-1" role="dialog" aria-labelledby="mdlSystemInfoLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mdlSystemInfoLabel">System Information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row m-2">
                    <div class="col-md-12">
                        <h5 class="font-weight-bold text-center">Online Exam Management System</h5>
                        <div class="text-justify">
                            The "Online Exam Management System" is a web-based application tailored to enhance the administrative processes associated with examinations. 
                            The system enables easy creation, modification, and conducting of examinations, simplifying applicant management improving the user experience and administrative operations. 
                            A dedicated examination page supports a seamless online testing experience, optimized for performance and usability. 
                        </div>
                    </div>
                </div>
                <div class="row m-2">
                    <div class="col-md-12">
                        <div class="divider"></div>
                    </div>
                </div>
                <div class="row m-2">
                    <div class="col-md-6">
                        <div class="mb-2">Lead Developer:</div>
                        <div class="font-weight-bold text-center">Mark Aldrin J. Fule</div>
                        <div class="text-center">IT Specialist</div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-2">Assistant Developer:</div>
                        <div class="font-weight-bold text-center">George S. De Vera Jr.</div>
                        <div class="text-center">IT Intern</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> <!-- #END# System Info MODAL -->


<!-- LOGOUT MODAL -->
<div class="modal fade" id="mdlLogout" tabindex="-1" role="dialog" aria-labelledby="mdlLogoutLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mdlLogoutLabel">Logout</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <div class="form-row mb-2 justify-content-center">
                        Are you sure you want to LOGOUT?
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <a href="query/logoutExe.php" class="btn btn-primary">Logout</a>
            </div>
        </div>
    </div>
</div> <!-- #END# LOGOUT MODAL -->

