
<!-- TEST CAMERA MODAL -->
<div class="modal fade" id="mdlCameraTest" tabindex="-1" role="dialog" aria-labelledby="mdlCameraTestLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mdlCameraTestLabel">Test Camera</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row d-none" id="progressBarContainer">
                    <div class="col-md-12">
                        <div class="mb-3 progress">
                            <div class="progress-bar progress-bar-animated bg-success progress-bar-striped" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-center">
                        <button type="button" class="btn btn-primary mb-2" id="startTest">Test</button>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="text-center">
                        <video class="border" id="preview" autoplay width="100%" height="300px"></video>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-center">
                        RESULT: <span class="text-danger font-weight-bold" id="result"></span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div> <!-- #END# TEST CAMERA MODAL -->