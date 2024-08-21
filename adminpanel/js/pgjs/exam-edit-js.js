document.addEventListener('DOMContentLoaded', function() {
    $('#exam_tabs .nav-link').on('click', function() {
        var tabName = $(this).text().trim().toLowerCase().replace(/\s+/g, '-'); 
        var currentUrl = window.location.href;
        var baseUrl = currentUrl.split('?')[0]; // Get the base URL
    
        // Extract the 'id' parameter from the URL
        var urlParams = new URLSearchParams(window.location.search);
        var tabId = urlParams.get('id'); 
    
        var newUrl = baseUrl + '?page=manage-exam-edit&id=' + tabId + '&tab=' + tabName; 
    
        // Update the URL without reloading the page
        history.pushState({}, '', newUrl);
    });
    
    
    /* ########## EXAM INFO ########## */
    $('#edit_ExamCluster').select2({
        placeholder: 'Select...',
        closeOnSelect: false
    });

    function fetchCluList() {
        var urlParams = new URLSearchParams(window.location.search);
        var examId = urlParams.get('id');
        $.ajax({
            url: "query/edit_ClusterLoad.php",
            type: "GET",
            data: { id: examId },
            success: function (data) {
                var clusterIds = JSON.parse(data);
                $('#edit_ExamCluster').val(clusterIds).trigger('change');
            }
        });
    }
    
    fetchCluList();


    /* ########## EXAM QUESTION ########## */
    // View Image
    document.querySelectorAll('#viewimg-btn').forEach(function(viewimgbtn) {
        viewimgbtn.addEventListener('click', function() {
            var imageFilename = this.getAttribute('data-view-img');
    
            var imageUrl = '../../uploads/exam_question/' + imageFilename;
    
            // Update the image source in the modal
            var modalImage = document.querySelector('#mdlViewImage .modal-body img');
            modalImage.src = imageUrl;
            modalImage.alt = 'Image for exam ID ' + imageFilename;
        });
    });
    

    /* &&&&&&&&&&&& ADD Question &&&&&&&&&&&& */
    //Functions
    function ad_resetImg () {
        document.getElementById('imagePreview').innerHTML = '<i class="pe-7s-photo icon-gradient bg-premium-dark" style="font-size: 128px;"></i>';
        document.getElementById('add_DeleteImgBtn').style.display = 'none';
        document.getElementById('add_ExamImg').value = '';
    }

    //add question btn
    document.querySelectorAll('#add-btn').forEach(function(addbtn) {
        addbtn.addEventListener('click', function() {
            var examId = this.getAttribute('data-add-id');

            document.getElementById('add_QstnExamId').value = examId;
            
            //Select Existing Image NOT IMPLEMENTED
            /*document.getElementById('selImg_switch').addEventListener('change', function() {
                var uploadInput = document.getElementById('uploadInput');
                var selectInput = document.getElementById('selectInput');
        
                if (this.checked) {
                    // If the switch is checked, hide the upload input and show the select input
                    uploadInput.style.display = 'none';
                    selectInput.style.display = 'block';
                } else {
                    // If the switch is unchecked, show the upload input and hide the select input
                    uploadInput.style.display = 'block';
                    selectInput.style.display = 'none';
                }
            });*/
            
            document.getElementById('add_ExamImg').addEventListener('input', function() {
                if (!this.value) {
                    ad_resetImg();
                }
            });

            // Event listener for the file input change
            document.getElementById('add_ExamImg').addEventListener('change', function() {
                var file = this.files[0];
                var fileSize = file.size / (1024 * 1024); // in 4MB
                var allowedExtensions = /(\.png|\.jpg|\.jpeg|\.webp)$/i;
            
                if (!allowedExtensions.exec(file.name)) {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "Wrong file type. Upload png, jpg, webp only!",
                    }).then(function() {
                        ad_resetImg(); 
                    });
                } else if (fileSize > 4) {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "File size exceeded. Max file size is 4MB only!",
                    }).then(function() {
                        ad_resetImg();
                    });
                } else {
                    document.getElementById('imagePreview').innerHTML = '';
                    var reader = new FileReader();
            
                    reader.onload = function(e) {
                        document.getElementById('imagePreview').innerHTML = '<img src="' + e.target.result + '" style="max-width:100%; max-height:200px;"/>';
                        document.getElementById('add_DeleteImgBtn').style.display = 'inline-block';
                    }

                    reader.readAsDataURL(file);
                }
            });

            document.querySelector('#add_DeleteImgBtn').addEventListener('click', function() {
                ad_resetImg();
                document.getElementById('add_ExamImg').value = '';
            });
        });
    });


    /* &&&&&&&&&&&& EDIT Question &&&&&&&&&&&& */
    // Functions
    function ed_setImg (edit_exam_Image, img_Status) {
        if (edit_exam_Image) {
            document.getElementById('edit_imagePreview').innerHTML = '';
            document.getElementById('edit_imagePreview').innerHTML = '<img src="../../uploads/exam_question/' + edit_exam_Image + '" style="max-width:100%; max-height:200px;"/>';
            document.getElementById('edit_ImgStatus').value = img_Status;
            document.getElementById('edit_DeleteImgBtn').style.display = 'inline-block';
            document.getElementById('edit_ResetImgBtn').style.display = 'none';
        } else {
            document.getElementById('edit_imagePreview').innerHTML = '';
            document.getElementById('edit_imagePreview').innerHTML = '<i class="pe-7s-photo icon-gradient bg-premium-dark" style="font-size: 128px;"></i>';
            document.getElementById('edit_ImgStatus').value = img_Status;
            document.getElementById('edit_DeleteImgBtn').style.display = 'none';
            document.getElementById('edit_ResetImgBtn').style.display = 'none';
        }
    }

    function ed_deleteImg (img_Status) {
        document.getElementById('edit_imagePreview').innerHTML = '<i class="pe-7s-photo icon-gradient bg-premium-dark" style="font-size: 128px;"></i>';
        document.getElementById('edit_ImgStatus').value = img_Status;
        document.getElementById('edit_DeleteImgBtn').style.display = 'none';
        document.getElementById('edit_ResetImgBtn').style.display = 'inline-block';
    }

    function ed_newImg () {
        document.getElementById('edit_DeleteImgBtn').style.display = 'inline-block';
        document.getElementById('edit_ResetImgBtn').style.display = 'inline-block';
    }

    //edit question btn
    document.querySelectorAll('#edit-btn').forEach(function(editbtn) {
        editbtn.addEventListener('click', function() {
            var edit_examCount = this.getAttribute('data-edit-count');
            var edit_QstnId = this.getAttribute('data-edit-id');
            var edit_ExamId = this.getAttribute('data-edit-exid');
            var edit_exam_Image = this.getAttribute('data-edit-img');
            var edit_exam_Question = this.getAttribute('data-edit-question');
            var edit_exam_ch1 = this.getAttribute('data-edit-ch1');
            var edit_exam_ch2 = this.getAttribute('data-edit-ch2');
            var edit_exam_ch3 = this.getAttribute('data-edit-ch3');
            var edit_exam_ch4 = this.getAttribute('data-edit-ch4');
            var edit_exam_ch5 = this.getAttribute('data-edit-ch5');
            var edit_exam_ch6 = this.getAttribute('data-edit-ch6');
            var edit_exam_ch7 = this.getAttribute('data-edit-ch7');
            var edit_exam_ch8 = this.getAttribute('data-edit-ch8');
            var edit_exam_ch9 = this.getAttribute('data-edit-ch9');
            var edit_exam_ch10 = this.getAttribute('data-edit-ch10');
            var edit_exam_Answer = this.getAttribute('data-edit-answer');

            document.getElementById('edit_QstnId').value = edit_QstnId;
            document.getElementById('edit_QstnExamId').value = edit_ExamId;
            document.getElementById('edit_Question').value = edit_exam_Question;
            document.getElementById('edit_QstnCh1').value = edit_exam_ch1;
            document.getElementById('edit_QstnCh2').value = edit_exam_ch2;
            document.getElementById('edit_QstnCh3').value = edit_exam_ch3;
            document.getElementById('edit_QstnCh4').value = edit_exam_ch4;
            document.getElementById('edit_QstnCh5').value = edit_exam_ch5;
            document.getElementById('edit_QstnCh6').value = edit_exam_ch6;
            document.getElementById('edit_QstnCh7').value = edit_exam_ch7;
            document.getElementById('edit_QstnCh8').value = edit_exam_ch8;
            document.getElementById('edit_QstnCh9').value = edit_exam_ch9;
            document.getElementById('edit_QstnCh10').value = edit_exam_ch10;

            var modalTitle = document.querySelector('#mdlEditQuestion .modal-title span');
            modalTitle.textContent = edit_examCount;

            var choices = [edit_exam_ch1, edit_exam_ch2, edit_exam_ch3, edit_exam_ch4, edit_exam_ch5, edit_exam_ch6, edit_exam_ch7, edit_exam_ch8, edit_exam_ch9, edit_exam_ch10];
            var answerFound = false; 
            for (var i = 0; i < choices.length; i++) {
                if (edit_exam_Answer === choices[i]) {
                    edit_exam_Answer = (i + 1).toString(); 
                    answerFound = true; 
                    break; 
                }
            }

            if (!answerFound) {
                edit_exam_Answer = 'none';
            }

            document.getElementById('edit_QstnAns').value = edit_exam_Answer;

            ed_setImg(edit_exam_Image, 'img_Old');

            document.querySelector('#edit_DeleteImgBtn').addEventListener('click', function() {
                ed_deleteImg('img_Delete');
                document.getElementById('edit_ExamImg').value = '';
            });

            document.querySelector('#edit_ResetImgBtn').addEventListener('click', function() {
                ed_setImg(edit_exam_Image, 'img_Old');
                document.getElementById('edit_ExamImg').value = '';
            });

            // Event listener for the file input change
            document.getElementById('edit_ExamImg').addEventListener('change', function() {
                var file = this.files[0];
                var fileSize = file.size / (1024 * 1024); // in MB
                var allowedExtensions = /(\.png|\.jpg|\.jpeg|\.webp)$/i;
            
                if (!allowedExtensions.exec(file.name)) {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "Wrong file type. Upload png, jpg, webp only!",
                    }).then(function() {
                        document.getElementById('edit_ExamImg').value = '';
                        ed_setImg(edit_exam_Image, 'img_Old');
                    });
                } else if (fileSize > 4) {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "File size exceeded. Max file size is 4MB only!",
                    }).then(function() {
                        document.getElementById('edit_ExamImg').value = ''; 
                        ed_setImg(edit_exam_Image, 'img_Old');
                    });
                } else {
                    document.getElementById('edit_imagePreview').innerHTML = '';
                    var reader = new FileReader();
            
                    reader.onload = function(e) {
                        document.getElementById('edit_imagePreview').innerHTML = '<img src="'+e.target.result+'" style="max-width:100%; max-height:200px;"/>';
                        ed_newImg();
                        
                        // if there is existing file set to img_Replace else img_new
                        if (edit_exam_Image) {
                            document.getElementById('edit_ImgStatus').value = 'img_Replace';
                        } else {
                            document.getElementById('edit_ImgStatus').value = 'img_New';
                        }
                    }
            
                    reader.readAsDataURL(file);
                }
            });

            // Event listener for the file input input event
            document.getElementById('edit_ExamImg').addEventListener('input', function() {
                if (!this.value) {
                    ed_setImg(edit_exam_Image, 'img_Old');
                }
            });
        });
    });

    //Delete question
    document.querySelectorAll('#delete-btn').forEach(function(deleteBtn) {
        deleteBtn.addEventListener('click', function() {
            var QstnId = this.getAttribute('data-delete-id');
            var count = this.getAttribute('data-delete-count');
        
            document.getElementById('delete_QstnId').value = QstnId;
        
            var modalTitle = document.querySelector('#mdlDeleteQuestion .modal-title span');
            modalTitle.textContent = count;
        
            var modalBodyName = document.querySelector('#mdlDeleteQuestion .modal-body span');
            modalBodyName.innerHTML = "Are you sure you want to DELETE Question <span class='font-weight-bold text-danger'>" + count + "</span>?<br><br> <span class='font-weight-bold'>This action is IRREVERSIBLE!</span>";
        });
    });


    /* &&&&&&&&&&&& IMPORT QUESTION &&&&&&&&&&&& */
    //Functions
    function imp_resetFile () {
        //document.getElementById('import_ClearImportBtn').style.display = 'none';
        document.getElementById('import_QuestFile').value = '';
    }

    //Import question
    document.querySelectorAll('#import-btn').forEach(function(importBtn) {
        importBtn.addEventListener('click', function() {
            var ex_Id = this.getAttribute('data-import-id');
        
            document.getElementById('import_QuestExamId').value = ex_Id;

            // Event listener for the file input change
            document.getElementById('import_QuestFile').addEventListener('change', function() {
                var file = this.files[0];
                var fileSize = file.size / (1024 * 1024);
                var allowedExtensions = /\.(xlsx|xls)$/i;
            
                if (!allowedExtensions.exec(file.name)) {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "Wrong file type. Upload xlsx only!",
                    }).then(function() {
                        imp_resetFile(); 
                    });
                } else if (fileSize > 25) {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "File size exceeded. Max file size is 4MB only!",
                    }).then(function() {
                        imp_resetFile();
                    });
                } else {
                    //Allowed
                }
            });
        });
    });


    /* &&&&&&&&&&&& ADD PRACTICE &&&&&&&&&&&& */
    //Functions
    function ad_pracResetImg () {
        document.getElementById('prac_imagePreview').innerHTML = '<i class="pe-7s-photo icon-gradient bg-premium-dark" style="font-size: 128px;"></i>';
        document.getElementById('add_PracDeleteImgBtn').style.display = 'none';
        document.getElementById('add_PracImg').value = '';
    }

    //add practice btn
    document.querySelectorAll('#add-prac-btn').forEach(function(addbtn) {
        addbtn.addEventListener('click', function() {
            var examId = this.getAttribute('data-add-id');

            document.getElementById('add_PracExamId').value = examId;
            
            //Select Existing Image NOT IMPLEMENTED
            /*document.getElementById('selImg_switch').addEventListener('change', function() {
                var uploadInput = document.getElementById('uploadInput');
                var selectInput = document.getElementById('selectInput');
        
                if (this.checked) {
                    // If the switch is checked, hide the upload input and show the select input
                    uploadInput.style.display = 'none';
                    selectInput.style.display = 'block';
                } else {
                    // If the switch is unchecked, show the upload input and hide the select input
                    uploadInput.style.display = 'block';
                    selectInput.style.display = 'none';
                }
            });*/
            
            document.getElementById('add_PracImg').addEventListener('input', function() {
                if (!this.value) {
                    ad_pracResetImg();
                }
            });

            // Event listener for the file input change
            document.getElementById('add_PracImg').addEventListener('change', function() {
                var file = this.files[0];
                var fileSize = file.size / (1024 * 1024); // in 4MB
                var allowedExtensions = /(\.png|\.jpg|\.jpeg|\.webp)$/i;
            
                if (!allowedExtensions.exec(file.name)) {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "Wrong file type. Upload png, jpg, webp only!",
                    }).then(function() {
                        ad_pracResetImg(); 
                    });
                } else if (fileSize > 4) {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "File size exceeded. Max file size is 4MB only!",
                    }).then(function() {
                        ad_pracResetImg();
                    });
                } else {
                    document.getElementById('prac_imagePreview').innerHTML = '';
                    var reader = new FileReader();
            
                    reader.onload = function(e) {
                        document.getElementById('prac_imagePreview').innerHTML = '<img src="' + e.target.result + '" style="max-width:100%; max-height:200px;"/>';
                        document.getElementById('add_PracDeleteImgBtn').style.display = 'inline-block';
                    }

                    reader.readAsDataURL(file);
                }
            });

            document.querySelector('#add_PracDeleteImgBtn').addEventListener('click', function() {
                ad_pracResetImg();
                document.getElementById('add_PracImg').value = '';
            });
        });
    });


    /* &&&&&&&&&&&& EDIT PRACTICE &&&&&&&&&&&& */
    // Functions
    function ed_prsetImg (edit_prac_Image, img_pracStatus) {
        if (edit_prac_Image) {
            document.getElementById('edit_pracImagePreview').innerHTML = '';
            document.getElementById('edit_pracImagePreview').innerHTML = '<img src="../../uploads/exam_question/' + edit_prac_Image + '" style="max-width:100%; max-height:200px;"/>';
            document.getElementById('edit_PracImgStatus').value = img_pracStatus;
            document.getElementById('edit_PracDeleteImgBtn').style.display = 'inline-block';
            document.getElementById('edit_PracResetImgBtn').style.display = 'none';
        } else {
            document.getElementById('edit_pracImagePreview').innerHTML = '';
            document.getElementById('edit_pracImagePreview').innerHTML = '<i class="pe-7s-photo icon-gradient bg-premium-dark" style="font-size: 128px;"></i>';
            document.getElementById('edit_PracImgStatus').value = img_pracStatus;
            document.getElementById('edit_PracDeleteImgBtn').style.display = 'none';
            document.getElementById('edit_PracResetImgBtn').style.display = 'none';
        }
    }

    function ed_prdeleteImg (img_pracStatus) {
        document.getElementById('edit_pracImagePreview').innerHTML = '<i class="pe-7s-photo icon-gradient bg-premium-dark" style="font-size: 128px;"></i>';
        document.getElementById('edit_PracImgStatus').value = img_pracStatus;
        document.getElementById('edit_PracDeleteImgBtn').style.display = 'none';
        document.getElementById('edit_PracResetImgBtn').style.display = 'inline-block';
    }

    function ed_prnewImg () {
        document.getElementById('edit_PracDeleteImgBtn').style.display = 'inline-block';
        document.getElementById('edit_PracResetImgBtn').style.display = 'inline-block';
    }

    //edit practice btn
    document.querySelectorAll('#edit-prac-btn').forEach(function(editbtn) {
        editbtn.addEventListener('click', function() {
            var edit_pracCount = this.getAttribute('data-edit-prcount');
            var edit_PracId = this.getAttribute('data-edit-prid');
            var edit_PracExamId = this.getAttribute('data-edit-prexid');
            var edit_PracImg = this.getAttribute('data-edit-primg');
            var edit_Practice = this.getAttribute('data-edit-prquestion');
            var edit_prac_ch1 = this.getAttribute('data-edit-prch1');
            var edit_prac_ch2 = this.getAttribute('data-edit-prch2');
            var edit_prac_ch3 = this.getAttribute('data-edit-prch3');
            var edit_prac_ch4 = this.getAttribute('data-edit-prch4');
            var edit_prac_ch5 = this.getAttribute('data-edit-prch5');
            var edit_prac_ch6 = this.getAttribute('data-edit-prch6');
            var edit_prac_ch7 = this.getAttribute('data-edit-prch7');
            var edit_prac_ch8 = this.getAttribute('data-edit-prch8');
            var edit_prac_ch9 = this.getAttribute('data-edit-prch9');
            var edit_prac_ch10 = this.getAttribute('data-edit-prch10');
            var edit_prac_Answer = this.getAttribute('data-edit-pranswer');

            document.getElementById('edit_PracId').value = edit_PracId;
            document.getElementById('edit_PracExamId').value = edit_PracExamId;
            document.getElementById('edit_Practice').value = edit_Practice;
            document.getElementById('edit_PracCh1').value = edit_prac_ch1;
            document.getElementById('edit_PracCh2').value = edit_prac_ch2;
            document.getElementById('edit_PracCh3').value = edit_prac_ch3;
            document.getElementById('edit_PracCh4').value = edit_prac_ch4;
            document.getElementById('edit_PracCh5').value = edit_prac_ch5;
            document.getElementById('edit_PracCh6').value = edit_prac_ch6;
            document.getElementById('edit_PracCh7').value = edit_prac_ch7;
            document.getElementById('edit_PracCh8').value = edit_prac_ch8;
            document.getElementById('edit_PracCh9').value = edit_prac_ch9;
            document.getElementById('edit_PracCh10').value = edit_prac_ch10;

            var modalTitle = document.querySelector('#mdlEditPractice .modal-title span');
            modalTitle.textContent = edit_pracCount;

            var choices = [edit_prac_ch1, edit_prac_ch2, edit_prac_ch3, edit_prac_ch4, edit_prac_ch5, edit_prac_ch6, edit_prac_ch7, edit_prac_ch8, edit_prac_ch9, edit_prac_ch10];
            var answerFound = false; 
            for (var i = 0; i < choices.length; i++) {
                if (edit_prac_Answer === choices[i]) {
                    edit_prac_Answer = (i + 1).toString(); 
                    answerFound = true; 
                    break; 
                }
            }

            if (!answerFound) {
                edit_prac_Answer = 'none';
            }

            document.getElementById('edit_PracAns').value = edit_prac_Answer;

            ed_prsetImg(edit_PracImg, 'img_Old');

            document.querySelector('#edit_PracDeleteImgBtn').addEventListener('click', function() {
                ed_prdeleteImg('img_Delete');
                document.getElementById('edit_PracImg').value = '';
            });

            document.querySelector('#edit_PracResetImgBtn').addEventListener('click', function() {
                ed_prsetImg(edit_PracImg, 'img_Old');
                document.getElementById('edit_PracImg').value = '';
            });

            // Event listener for the file input change
            document.getElementById('edit_PracImg').addEventListener('change', function() {
                var file = this.files[0];
                var fileSize = file.size / (1024 * 1024); // in MB
                var allowedExtensions = /(\.png|\.jpg|\.jpeg|\.webp)$/i;
            
                if (!allowedExtensions.exec(file.name)) {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "Wrong file type. Upload png, jpg, webp only!",
                    }).then(function() {
                        document.getElementById('edit_PracImg').value = '';
                        ed_prsetImg(edit_PracImg, 'img_Old');
                    });
                } else if (fileSize > 4) {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "File size exceeded. Max file size is 4MB only!",
                    }).then(function() {
                        document.getElementById('edit_PracImg').value = ''; 
                        ed_prsetImg(edit_PracImg, 'img_Old');
                    });
                } else {
                    document.getElementById('edit_pracImagePreview').innerHTML = '';
                    var reader = new FileReader();
            
                    reader.onload = function(e) {
                        document.getElementById('edit_pracImagePreview').innerHTML = '<img src="'+e.target.result+'" style="max-width:100%; max-height:200px;"/>';
                        ed_prnewImg();
                        
                        // if there is existing file set to img_Replace else img_new
                        if (edit_PracImg) {
                            document.getElementById('edit_PracImgStatus').value = 'img_Replace';
                        } else {
                            document.getElementById('edit_PracImgStatus').value = 'img_New';
                        }
                    }
            
                    reader.readAsDataURL(file);
                }
            });

            // Event listener for the file input input event
            document.getElementById('edit_PracImg').addEventListener('input', function() {
                if (!this.value) {
                    ed_prsetImg(edit_PracImg, 'img_Old');
                }
            });
        });
    });

    //Delete practice
    document.querySelectorAll('#delete-prac-btn').forEach(function(deleteBtn) {
        deleteBtn.addEventListener('click', function() {
            var PracId = this.getAttribute('data-delete-prid');
            var Praccount = this.getAttribute('data-delete-prcount');
        
            document.getElementById('delete_PracId').value = PracId;
        
            var modalTitle = document.querySelector('#mdlDeletePractice .modal-title span');
            modalTitle.textContent = Praccount;
        
            var modalBodyName = document.querySelector('#mdlDeletePractice .modal-body span');
            modalBodyName.innerHTML = "Are you sure you want to DELETE Question <span class='font-weight-bold text-danger'>" + Praccount + "</span>?<br><br> <span class='font-weight-bold'>This action is IRREVERSIBLE!</span>";
        });
    });
});
