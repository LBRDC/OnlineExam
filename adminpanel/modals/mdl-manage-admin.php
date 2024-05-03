
<!-- ADD USER MODAL -->
<div class="modal fade" id="mdlAddUser" tabindex="-1" role="dialog" aria-labelledby="mdlAddUserLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mdlAddUserLabel">Add User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addUserFrm" name="addUserFrm" method="post">
            <div class="modal-body">
                <div class="">
                    <div class="row justify-content-center m-2">
                        <h6 class="font-weight-bold text-muted">User Information</h6>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-6 col-md-12 mb-1">
                            <div class="form-row">
                                <label for="add_UserFname">First Name<span class="text-danger">*</span></label>
                                <input type="text" name="add_UserFname" id="add_UserFname" class="form-control" placeholder="" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 mb-1">
                            <div class="form-row">
                                <label for="add_UserLname">Last Name<span class="text-danger">*</span></label>
                                <input type="text" name="add_UserLname" id="add_UserLname" class="form-control" placeholder="" autocomplete="off" required>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-6 col-md-12 mb-1">
                            <div class="form-row">
                                <label for="add_UserPosition">Position<span class="text-danger">*</span></label>
                                <input type="text" name="add_UserPosition" id="add_UserPosition" class="form-control" placeholder="" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 mb-1">
                                <label>Options</label>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="add_UserSuper" value="yes">
                                    <label class="custom-control-label" for="add_UserSuper">Superuser</label>
                                </div>
                        </div>
                    </div>
                    <div class="row justify-content-center m-2">
                        <h6 class="font-weight-bold text-muted">Login Credentials</h6>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-6 col-md-12">
                            <div class="form-row">
                                <label for="add_UserName">Username<span class="text-danger">*</span></label>
                                <input type="text" name="add_UserName" id="add_UserName" class="form-control" placeholder="" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="form-row">
                                <label for="add_UserPass">Password<span class="text-danger">*</span></label>
                                <input type="password" name="add_UserPass" id="add_UserPass" class="form-control" placeholder="" autocomplete="off" requried>
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
</div> <!-- #END# ADD USER MODAL -->