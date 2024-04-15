<!-- ADD QUESTION MODAL -->
<div class="modal fade" id="mdlAddQuestion" tabindex="-1" role="dialog" aria-labelledby="mdlAddQuestionLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mdlAddQuestionLabel">Add Question</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="addQuestionFrm" name="addQuestionFrm" method="post">
                <div class="modal-body">
                    <div class="col-md-12">
                        <input type="text" name="add_QstnExamId" id="add_QstnExamId" value="" hidden required>
                        <div class="form-row mb-2">
                            <label for="add_Question">Question<span class="text-danger">*</span></label>
                            <textarea name="add_Question" id="add_Question" class="form-control" rows="3" placeholder=""></textarea>
                        </div>
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
                        <div class="form-row mb-2">
                            <label for="add_QstnCh10">Choice J</label>
                            <input type="text" name="add_QstnCh10" id="add_QstnCh10" class="form-control" placeholder="" autocomplete="off">
                        </div>
                        <div class="form-row mb-2">
                            <label for="add_QstnAns">Answer<span class="text-danger">*</span></label>
                            <select class="form-control" name="add_QstnAns" id="add_QstnAns">
                                <option value="">Select...</option>
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
                        <div class="form-row mb-2">
                            <label for="" class="">Exam Image</label>
                            <input name="add_ExamImg" id="add_ExamImg" type="file" class="form-control-file" accept="image/png, image/jpeg, image/webp">
                            <small class="form-text text-muted">Upload png, jpg/jpeg, webp only. Max file size 4MB.</small>
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