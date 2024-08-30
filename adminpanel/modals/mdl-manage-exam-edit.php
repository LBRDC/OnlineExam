<!-- ADD QUESTION MODAL -->
<div class="modal fade" id="mdlAddQuestion" tabindex="-1" role="dialog" aria-labelledby="mdlAddQuestionLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mdlAddQuestionLabel">Add Question</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addQuestionFrm" name="addQuestionFrm" method="post">
            <div class="modal-body">
                <div class="scroll-area-lg">
                    <div class="col-md-12">
                        <input type="text" name="add_QstnExamId" id="add_QstnExamId" value="" hidden required>
                        <div class="form-row">
                            <label class="font-weight-bold">Exam Image</label>
                        </div>
                        <!--<div class="form-row mb-2"> NOT IMPLEMENTED
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="selImg_switch">
                                <label class="custom-control-label" for="selImg_switch">Select Existing</label>
                            </div>
                        </div>-->
                        <div class="form-row mb-2" id="uploadInput">
                            <input name="add_ExamImg" id="add_ExamImg" type="file" class="form-control-file" accept="image/png, image/jpeg, image/webp">
                            <small class="form-text text-muted">Upload png, jpg/jpeg, webp only. Max file size 4MB.</small>
                        </div>
                        <!--<div class="form-row mb-2" id="selectInput" style="display: none;"> NOT IMPLEMENTED
                            <select name="existingImages" id="existingImages" class="form-control">
                                <option value="">Select an existing image</option>
                                <option value="image1">Image 1</option>
                                <option value="image2">Image 2</option>
                            </select>
                        </div>-->
                        <div class="form-row mb-1 border justify-content-center" style="height: 220px" id="imgContainer">
                            <div id="imagePreview" class="form-group d-flex align-items-center m-0">
                                <i class="pe-7s-photo icon-gradient bg-premium-dark" style="font-size: 128px;"></i>
                            </div>
                        </div>
                        <div class="form-row mb-3">
                            <div class="d-flex justify-content-end w-100">
                                <button type="button" class="btn btn-secondary mr-2" id="add_ResetImgBtn" style="display:none">Reset</button>
                                <button type="button" class="btn btn-danger mr-1" id="add_DeleteImgBtn" style="display:none">Delete</button>
                            </div>
                        </div>
                        <div class="form-row mb-3">
                            <label for="add_Question" class="font-weight-bold">Question<span class="text-danger">*</span></label>
                            <textarea name="add_Question" id="add_Question" class="form-control" rows="3" placeholder=""></textarea>
                        </div>
                        <label class="font-weight-bold">
                            Choices<span class="text-danger">*</span>
                        </label>
                        <div class="form-row mb-2">
                            <label for="add_QstnCh1">Choice A</label>
                            <input type="text" name="add_QstnCh1" id="add_QstnCh1" class="form-control" placeholder="" autocomplete="off">
                        </div>
                        <div class="form-row mb-2">
                            <label for="add_QstnCh2">Choice B</label>
                            <input type="text" name="add_QstnCh2" id="add_QstnCh2" class="form-control" placeholder="" autocomplete="off">
                        </div>
                        <div class="form-row mb-2">
                            <label for="add_QstnCh3">Choice C</label>
                            <input type="text" name="add_QstnCh3" id="add_QstnCh3" class="form-control" placeholder="" autocomplete="off">
                        </div>
                        <div class="form-row mb-2">
                            <label for="add_QstnCh4">Choice D</label>
                            <input type="text" name="add_QstnCh4" id="add_QstnCh4" class="form-control" placeholder="" autocomplete="off">
                        </div>
                        <div class="form-row mb-2">
                            <label for="add_QstnCh5">Choice E</label>
                            <input type="text" name="add_QstnCh5" id="add_QstnCh5" class="form-control" placeholder="" autocomplete="off">
                        </div>
                        <div class="form-row mb-2">
                            <label for="add_QstnCh6">Choice F</label>
                            <input type="text" name="add_QstnCh6" id="add_QstnCh6" class="form-control" placeholder="" autocomplete="off">
                        </div>
                        <div class="form-row mb-2">
                            <label for="add_QstnCh7">Choice G</label>
                            <input type="text" name="add_QstnCh7" id="add_QstnCh7" class="form-control" placeholder="" autocomplete="off">
                        </div>
                        <div class="form-row mb-2">
                            <label for="add_QstnCh8">Choice H</label>
                            <input type="text" name="add_QstnCh8" id="add_QstnCh8" class="form-control" placeholder="" autocomplete="off">
                        </div>
                        <div class="form-row mb-2">
                            <label for="add_QstnCh9">Choice I</label>
                            <input type="text" name="add_QstnCh9" id="add_QstnCh9" class="form-control" placeholder="" autocomplete="off">
                        </div>
                        <div class="form-row mb-3">
                            <label for="add_QstnCh10">Choice J</label>
                            <input type="text" name="add_QstnCh10" id="add_QstnCh10" class="form-control" placeholder="" autocomplete="off">
                        </div>
                        <div class="form-row mb-2">
                            <label for="add_QstnAns" class="font-weight-bold">Answer<span class="text-danger">*</span></label>
                            <select class="form-control" name="add_QstnAns" id="add_QstnAns" required>
                                <option value="" hidden>Select...</option>
                                <option value="1">A</option>
                                <option value="2">B</option>
                                <option value="3">C</option>
                                <option value="4">D</option>
                                <option value="5">E</option>
                                <option value="6">F</option>
                                <option value="7">G</option>
                                <option value="8">H</option>
                                <option value="9">I</option>
                                <option value="10">J</option>
                                <option value="none">None</option>
                            </select>
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
</div> <!-- #END# ADD QUESTION MODAL -->


<!-- VIEW IMAGE MODAL -->
<div class="modal fade" id="mdlViewImage" tabindex="-1" role="dialog" aria-labelledby="mdlViewImageLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mdlViewImageLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 text-center" width="100%">  
                        <img class="img-fluid" src="" alt="">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div> <!-- #END# VIEW IMAGE MODAL -->


<!-- EDIT QUESTION MODAL -->
<div class="modal fade" id="mdlEditQuestion" tabindex="-1" role="dialog" aria-labelledby="mdlEditQuestionLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mdlEditQuestionLabel">Edit Question "<span class="text-warning font-weight-bold"></span>"</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="EditQuestionFrm" name="EditQuestionFrm" method="post">
            <div class="modal-body">
                <div class="scroll-area-lg">
                <div class="col-md-12">
                    <input type="text" name="edit_QstnId" id="edit_QstnId" value="" hidden required>
                    <input type="text" name="edit_QstnExamId" id="edit_QstnExamId" value="" hidden required>
                    <input type="text" name="edit_ImgStatus" id="edit_ImgStatus" value="" hidden required>
                    <div class="form-row">
                        <label class="font-weight-bold">Exam Image</label>
                    </div>
                    <!--<div class="form-row mb-2"> NOT IMPLEMENTED
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="selImg_switch">
                            <label class="custom-control-label" for="selImg_switch">Select Existing</label>
                        </div>
                    </div>-->
                    <div class="form-row mb-2" id="uploadInput">
                        <input name="edit_ExamImg" id="edit_ExamImg" type="file" class="form-control-file" accept="image/png, image/jpeg, image/webp">
                        <small class="form-text text-muted">Upload png, jpg/jpeg, webp only. Max file size 4MB.</small>
                    </div>
                    <!--<div class="form-row mb-2" id="selectInput" style="display: none;"> NOT IMPLEMENTED
                        <select name="existingImages" id="existingImages" class="form-control">
                            <option value="">Select an existing image</option>
                            <option value="image1">Image 1</option>
                            <option value="image2">Image 2</option>
                        </select>
                    </div>-->
                
                    <div class="form-row border justify-content-center mb-1" style="height: 220px; position: relative;">
                        <div class="row">
                            <div id="edit_imagePreview" class="row d-flex align-items-center">
                                <img src="" alt="" style="max-width:100%; max-height:200px;">
                                <i class="pe-7s-photo icon-gradient bg-premium-dark" style="font-size: 128px;"></i>
                            </div>
                        </div>
                    </div>
                    <div class="form-row mb-2">
                        <div class="d-flex justify-content-end w-100">
                            <button type="button" class="btn btn-secondary mr-2" id="edit_ResetImgBtn" style="display:none">Reset</button>
                            <button type="button" class="btn btn-danger mr-1" id="edit_DeleteImgBtn" style="display:none">Delete</button>
                        </div>
                    </div>

                    <div class="form-row mb-3">
                        <label for="edit_Question" class="font-weight-bold">Question<span class="text-danger">*</span></label>
                        <textarea name="edit_Question" id="edit_Question" class="form-control" rows="3" placeholder=""></textarea>
                    </div>
                    <label class="font-weight-bold">
                        Choices<span class="text-danger">*</span>
                    </label>
                    <div class="form-row mb-2">
                        <label for="edit_QstnCh1">Choice A</label>
                        <input type="text" name="edit_QstnCh1" id="edit_QstnCh1" class="form-control" placeholder="" autocomplete="off" value="">
                    </div>
                    <div class="form-row mb-2">
                        <label for="edit_QstnCh2">Choice B</label>
                        <input type="text" name="edit_QstnCh2" id="edit_QstnCh2" class="form-control" placeholder="" autocomplete="off" value="">
                    </div>
                    <div class="form-row mb-2">
                        <label for="edit_QstnCh3">Choice C</label>
                        <input type="text" name="edit_QstnCh3" id="edit_QstnCh3" class="form-control" placeholder="" autocomplete="off" value="">
                    </div>
                    <div class="form-row mb-2">
                        <label for="edit_QstnCh4">Choice D</label>
                        <input type="text" name="edit_QstnCh4" id="edit_QstnCh4" class="form-control" placeholder="" autocomplete="off" value="">
                    </div>
                    <div class="form-row mb-2">
                        <label for="edit_QstnCh5">Choice E</label>
                        <input type="text" name="edit_QstnCh5" id="edit_QstnCh5" class="form-control" placeholder="" autocomplete="off" value="">
                    </div>
                    <div class="form-row mb-2">
                        <label for="edit_QstnCh6">Choice F</label>
                        <input type="text" name="edit_QstnCh6" id="edit_QstnCh6" class="form-control" placeholder="" autocomplete="off" value="">
                    </div>
                    <div class="form-row mb-2">
                        <label for="edit_QstnCh7">Choice G</label>
                        <input type="text" name="edit_QstnCh7" id="edit_QstnCh7" class="form-control" placeholder="" autocomplete="off" value="">
                    </div>
                    <div class="form-row mb-2">
                        <label for="edit_QstnCh8">Choice H</label>
                        <input type="text" name="edit_QstnCh8" id="edit_QstnCh8" class="form-control" placeholder="" autocomplete="off" value="">
                    </div>
                    <div class="form-row mb-2">
                        <label for="edit_QstnCh9">Choice I</label>
                        <input type="text" name="edit_QstnCh9" id="edit_QstnCh9" class="form-control" placeholder="" autocomplete="off" value="">
                    </div>
                    <div class="form-row mb-3">
                        <label for="edit_QstnCh10">Choice J</label>
                        <input type="text" name="edit_QstnCh10" id="edit_QstnCh10" class="form-control" placeholder="" autocomplete="off" value="">
                    </div>
                    <div class="form-row mb-2">
                        <label for="edit_QstnAns" class="font-weight-bold">Answer<span class="text-danger">*</span></label>
                        <select class="form-control" name="edit_QstnAns" id="edit_QstnAns" required>
                            <option value="" disabled>Select...</option>
                            <option value="" selected hidden></option> <!-- selected -->
                            <option value="1">A</option>
                            <option value="2">B</option>
                            <option value="3">C</option>
                            <option value="4">D</option>
                            <option value="5">E</option>
                            <option value="6">F</option>
                            <option value="7">G</option>
                            <option value="8">H</option>
                            <option value="9">I</option>
                            <option value="10">J</option>
                            <option value="none">None</option>
                        </select>
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
</div> <!-- #END# EDIT QUESTION MODAL -->


<!-- DELETE QUESTION MODAL -->
<div class="modal fade" id="mdlDeleteQuestion" tabindex="-1" role="dialog" aria-labelledby="mdlDeleteQuestionLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mdlDeleteQuestionLabel">Delete "<span class="font-weight-bold text-danger">NAME</span>"</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="deleteQuestionFrm" name="deleteQuestionFrm" method="post">
            <div class="modal-body">
                <div class="col-md-12 text-center">
                    <input type="text" name="delete_QstnId" id="delete_QstnId" value="" hidden required>
                    <div class="form-row mb-2 justify-content-center">
                        <span></span>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-danger">DELETE</button>
            </div>
            </form>
        </div>
    </div>
</div> <!-- #END# DELETE QUESTION MODAL -->


<!-- IMPORT QUESTIONS MODAL -->
<div class="modal fade" id="mdlImportQuest" tabindex="-1" role="dialog" aria-labelledby="mdlImportQuest" aria-hidden="true">
    <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mdlImportQuest">Import Question</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="importQuestFrm" name="importQuestFrm" method="post">
                <div class="modal-body">
                    <input type="text" name="import_QuestId" id="import_QuestExamId" hidden required readonly>
                    <div class="row mb-2">
                        <div class="col-lg-12 col-md-12">
                            <label class="font-weight-bold" for="import_QuestFile">Excel File</label>
                            <div class="border rounded">
                                <input name="import_QuestFile" id="import_QuestFile" type="file" class="form-control-file m-1" accept=".xlsx,.xls" required>
                            </div>
                            <small class="form-text text-muted">Please upload xlsx file only.</small>
                            <div class="row">
                                <!--<button type="button" class="btn btn-secondary mr-2" id="import_ClearImportBtn" style="display:none">Clear</button>-->
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="d-flex justify-content-end w-100">
                            
                        </div>
                    </div>
                    <div class="row mt-2 justify-content-center">
                        <div class="col-lg-12 col-md-12 text-center">
                            <small>NOTE: Only Text will be imported, images must be uploaded manually.</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="import_ImportBtn">Import</button>
                </div>
                </form>
            </div>
    </div>
</div> <!-- #END# IMPORT QUESTIONS MODAL -->


<!-- ADD PRACTICE MODAL -->
<div class="modal fade" id="mdlAddPractice" tabindex="-1" role="dialog" aria-labelledby="mdlAddPractice" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mdlAddPractice">Add Practice Question</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addPracticeFrm" name="addPracticeFrm" method="post">
            <div class="modal-body">
                <div class="scroll-area-lg">
                    <div class="col-md-12">
                        <input type="text" name="add_PracExamId" id="add_PracExamId" value="" hidden required>
                        <div class="form-row">
                            <label class="font-weight-bold">Exam Image</label>
                        </div>
                        <!--<div class="form-row mb-2"> NOT IMPLEMENTED
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="selImg_switch">
                                <label class="custom-control-label" for="selImg_switch">Select Existing</label>
                            </div>
                        </div>-->
                        <div class="form-row mb-2" id="uploadInput">
                            <input name="add_PracImg" id="add_PracImg" type="file" class="form-control-file" accept="image/png, image/jpeg, image/webp">
                            <small class="form-text text-muted">Upload png, jpg/jpeg, webp only. Max file size 4MB.</small>
                        </div>
                        <!--<div class="form-row mb-2" id="selectInput" style="display: none;"> NOT IMPLEMENTED
                            <select name="existingImages" id="existingImages" class="form-control">
                                <option value="">Select an existing image</option>
                                <option value="image1">Image 1</option>
                                <option value="image2">Image 2</option>
                            </select>
                        </div>-->
                        <div class="form-row mb-1 border justify-content-center" style="height: 220px" id="prac_imgContainer">
                            <div id="prac_imagePreview" class="form-group d-flex align-items-center m-0">
                                <i class="pe-7s-photo icon-gradient bg-premium-dark" style="font-size: 128px;"></i>
                            </div>
                        </div>
                        <div class="form-row mb-3">
                            <div class="d-flex justify-content-end w-100">
                                <button type="button" class="btn btn-secondary mr-2" id="add_PracResetImgBtn" style="display:none">Reset</button>
                                <button type="button" class="btn btn-danger mr-1" id="add_PracDeleteImgBtn" style="display:none">Delete</button>
                            </div>
                        </div>
                        <div class="form-row mb-3">
                            <label for="add_Guide" class="font-weight-bold">Guide<span class="text-danger">*</span></label>
                            <textarea name="add_Guide" id="add_Guide" class="form-control" rows="5" placeholder=""></textarea>
                        </div>
                        <div class="form-row mb-3">
                            <label for="add_Practice" class="font-weight-bold">Question<span class="text-danger">*</span></label>
                            <textarea name="add_Practice" id="add_Practice" class="form-control" rows="3" placeholder=""></textarea>
                        </div>
                        <label class="font-weight-bold">
                            Choices<span class="text-danger">*</span>
                        </label>
                        <div class="form-row mb-2">
                            <label for="add_PracCh1">Choice A</label>
                            <input type="text" name="add_PracCh1" id="add_PracCh1" class="form-control" placeholder="" autocomplete="off">
                        </div>
                        <div class="form-row mb-2">
                            <label for="add_PracCh2">Choice B</label>
                            <input type="text" name="add_PracCh2" id="add_PracCh2" class="form-control" placeholder="" autocomplete="off">
                        </div>
                        <div class="form-row mb-2">
                            <label for="add_PracCh3">Choice C</label>
                            <input type="text" name="add_PracCh3" id="add_PracCh3" class="form-control" placeholder="" autocomplete="off">
                        </div>
                        <div class="form-row mb-2">
                            <label for="add_PracCh4">Choice D</label>
                            <input type="text" name="add_PracCh4" id="add_PracCh4" class="form-control" placeholder="" autocomplete="off">
                        </div>
                        <div class="form-row mb-2">
                            <label for="add_PracCh5">Choice E</label>
                            <input type="text" name="add_PracCh5" id="add_PracCh5" class="form-control" placeholder="" autocomplete="off">
                        </div>
                        <div class="form-row mb-2">
                            <label for="add_PracCh6">Choice F</label>
                            <input type="text" name="add_PracCh6" id="add_PracCh6" class="form-control" placeholder="" autocomplete="off">
                        </div>
                        <div class="form-row mb-2">
                            <label for="add_PracCh7">Choice G</label>
                            <input type="text" name="add_PracCh7" id="add_PracCh7" class="form-control" placeholder="" autocomplete="off">
                        </div>
                        <div class="form-row mb-2">
                            <label for="add_PracCh8">Choice H</label>
                            <input type="text" name="add_PracCh8" id="add_PracCh8" class="form-control" placeholder="" autocomplete="off">
                        </div>
                        <div class="form-row mb-2">
                            <label for="add_PracCh9">Choice I</label>
                            <input type="text" name="add_PracCh9" id="add_PracCh9" class="form-control" placeholder="" autocomplete="off">
                        </div>
                        <div class="form-row mb-3">
                            <label for="add_PracCh10">Choice J</label>
                            <input type="text" name="add_PracCh10" id="add_PracCh10" class="form-control" placeholder="" autocomplete="off">
                        </div>
                        <div class="form-row mb-2">
                            <label for="add_PracAns" class="font-weight-bold">Answer<span class="text-danger">*</span></label>
                            <select class="form-control" name="add_PracAns" id="add_PracAns" required>
                                <option value="" hidden>Select...</option>
                                <option value="1">A</option>
                                <option value="2">B</option>
                                <option value="3">C</option>
                                <option value="4">D</option>
                                <option value="5">E</option>
                                <option value="6">F</option>
                                <option value="7">G</option>
                                <option value="8">H</option>
                                <option value="9">I</option>
                                <option value="10">J</option>
                                <option value="none">None</option>
                            </select>
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
</div> <!-- #END# ADD PRACTICE MODAL -->


<!-- EDIT PRACTICE MODAL -->
<div class="modal fade" id="mdlEditPractice" tabindex="-1" role="dialog" aria-labelledby="mdlEditPracticeLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mdlEditPracticeLabel">Edit Question "<span class="text-warning font-weight-bold"></span>"</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="EditPracticeFrm" name="EditPracticeFrm" method="post">
            <div class="modal-body">
                <div class="scroll-area-lg">
                <div class="col-md-12">
                    <input type="text" name="edit_PracId" id="edit_PracId" value="" hidden required>
                    <input type="text" name="edit_PracExamId" id="edit_PracExamId" value="" hidden required>
                    <input type="text" name="edit_PracImgStatus" id="edit_PracImgStatus" value="" hidden required>
                    <div class="form-row">
                        <label class="font-weight-bold">Exam Image</label>
                    </div>
                    <!--<div class="form-row mb-2"> NOT IMPLEMENTED
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="selImg_switch">
                            <label class="custom-control-label" for="selImg_switch">Select Existing</label>
                        </div>
                    </div>-->
                    <div class="form-row mb-2" id="pracUploadInput">
                        <input name="edit_PracImg" id="edit_PracImg" type="file" class="form-control-file" accept="image/png, image/jpeg, image/webp">
                        <small class="form-text text-muted">Upload png, jpg/jpeg, webp only. Max file size 4MB.</small>
                    </div>
                    <!--<div class="form-row mb-2" id="selectInput" style="display: none;"> NOT IMPLEMENTED
                        <select name="existingImages" id="existingImages" class="form-control">
                            <option value="">Select an existing image</option>
                            <option value="image1">Image 1</option>
                            <option value="image2">Image 2</option>
                        </select>
                    </div>-->
                
                    <div class="form-row border justify-content-center mb-1" style="height: 220px; position: relative;">
                        <div class="row">
                            <div id="edit_pracImagePreview" class="row d-flex align-items-center">
                                <img src="" alt="" style="max-width:100%; max-height:200px;">
                                <i class="pe-7s-photo icon-gradient bg-premium-dark" style="font-size: 128px;"></i>
                            </div>
                        </div>
                    </div>
                    <div class="form-row mb-2">
                        <div class="d-flex justify-content-end w-100">
                            <button type="button" class="btn btn-secondary mr-2" id="edit_PracResetImgBtn" style="display:none">Reset</button>
                            <button type="button" class="btn btn-danger mr-1" id="edit_PracDeleteImgBtn" style="display:none">Delete</button>
                        </div>
                    </div>

                    <div class="form-row mb-3">
                        <label for="edit_Guide" class="font-weight-bold">Guide<span class="text-danger">*</span></label>
                        <textarea name="edit_Guide" id="edit_Guide" class="form-control" rows="5" placeholder=""></textarea>
                    </div>
                    <div class="form-row mb-3">
                        <label for="edit_Practice" class="font-weight-bold">Question<span class="text-danger">*</span></label>
                        <textarea name="edit_Practice" id="edit_Practice" class="form-control" rows="3" placeholder=""></textarea>
                    </div>
                    <label class="font-weight-bold">
                        Choices<span class="text-danger">*</span>
                    </label>
                    <div class="form-row mb-2">
                        <label for="edit_PracCh1">Choice A</label>
                        <input type="text" name="edit_PracCh1" id="edit_PracCh1" class="form-control" placeholder="" autocomplete="off" value="">
                    </div>
                    <div class="form-row mb-2">
                        <label for="edit_PracCh2">Choice B</label>
                        <input type="text" name="edit_PracCh2" id="edit_PracCh2" class="form-control" placeholder="" autocomplete="off" value="">
                    </div>
                    <div class="form-row mb-2">
                        <label for="edit_PracCh3">Choice C</label>
                        <input type="text" name="edit_PracCh3" id="edit_PracCh3" class="form-control" placeholder="" autocomplete="off" value="">
                    </div>
                    <div class="form-row mb-2">
                        <label for="edit_PracCh4">Choice D</label>
                        <input type="text" name="edit_PracCh4" id="edit_PracCh4" class="form-control" placeholder="" autocomplete="off" value="">
                    </div>
                    <div class="form-row mb-2">
                        <label for="edit_PracCh5">Choice E</label>
                        <input type="text" name="edit_PracCh5" id="edit_PracCh5" class="form-control" placeholder="" autocomplete="off" value="">
                    </div>
                    <div class="form-row mb-2">
                        <label for="edit_PracCh6">Choice F</label>
                        <input type="text" name="edit_PracCh6" id="edit_PracCh6" class="form-control" placeholder="" autocomplete="off" value="">
                    </div>
                    <div class="form-row mb-2">
                        <label for="edit_PracCh7">Choice G</label>
                        <input type="text" name="edit_PracCh7" id="edit_PracCh7" class="form-control" placeholder="" autocomplete="off" value="">
                    </div>
                    <div class="form-row mb-2">
                        <label for="edit_PracCh8">Choice H</label>
                        <input type="text" name="edit_PracCh8" id="edit_PracCh8" class="form-control" placeholder="" autocomplete="off" value="">
                    </div>
                    <div class="form-row mb-2">
                        <label for="edit_PracCh9">Choice I</label>
                        <input type="text" name="edit_PracCh9" id="edit_PracCh9" class="form-control" placeholder="" autocomplete="off" value="">
                    </div>
                    <div class="form-row mb-3">
                        <label for="edit_PracCh10">Choice J</label>
                        <input type="text" name="edit_PracCh10" id="edit_PracCh10" class="form-control" placeholder="" autocomplete="off" value="">
                    </div>
                    <div class="form-row mb-2">
                        <label for="edit_PracAns" class="font-weight-bold">Answer<span class="text-danger">*</span></label>
                        <select class="form-control" name="edit_PracAns" id="edit_PracAns" required>
                            <option value="" disabled>Select...</option>
                            <option value="" selected hidden></option> <!-- selected -->
                            <option value="1">A</option>
                            <option value="2">B</option>
                            <option value="3">C</option>
                            <option value="4">D</option>
                            <option value="5">E</option>
                            <option value="6">F</option>
                            <option value="7">G</option>
                            <option value="8">H</option>
                            <option value="9">I</option>
                            <option value="10">J</option>
                            <option value="none">None</option>
                        </select>
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
</div> <!-- #END# EDIT PRACTICE MODAL -->


<!-- DELETE PRACTICE MODAL -->
<div class="modal fade" id="mdlDeletePractice" tabindex="-1" role="dialog" aria-labelledby="mdlDeletePracticeLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mdlDeletePracticeLabel">Delete "<span class="font-weight-bold text-danger">NAME</span>"</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="deletePracticeFrm" name="deletePracticeFrm" method="post">
            <div class="modal-body">
                <div class="col-md-12 text-center">
                    <input type="text" name="delete_PracId" id="delete_PracId" value="" hidden required>
                    <div class="form-row mb-2 justify-content-center">
                        <span></span>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-danger">DELETE</button>
            </div>
            </form>
        </div>
    </div>
</div> <!-- #END# DELETE PRACTICE MODAL -->