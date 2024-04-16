document.addEventListener('DOMContentLoaded', function() {
    $('#exam_tabs .nav-link').on('click', function() {
        var tabId = $(this).attr('id'); // Get the ID of the clicked tab
        var tabName = $(this).text().trim().toLowerCase().replace(/\s+/g, '-'); // Generate a URL-friendly name
        var currentUrl = window.location.href;
        var baseUrl = currentUrl.split('?')[0]; // Get the base URL
        var newUrl = baseUrl + '?page=manage-exam-edit&id=8&tab=' + tabName; // Construct the new URL

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
            // Get the image filename from the data-view-img attribute
            var imageFilename = this.getAttribute('data-view-img');
    
            // Construct the image URL based on the filename
            // Assuming the images are stored in a publicly accessible directory
            var imageUrl = '../../uploads/exam_question/' + imageFilename;
    
            // Update the image source in the modal
            var modalImage = document.querySelector('#mdlViewImage .modal-body img');
            modalImage.src = imageUrl;
            modalImage.alt = 'Image for exam ID ' + imageFilename;
    
            // Show the modal
            //$('#mdlViewImage').modal('show');
        });
    });
    

    /* ADD Question */
    //add question btn
    document.querySelectorAll('#add-btn').forEach(function(addbtn) {
        addbtn.addEventListener('click', function() {
            var examId = this.getAttribute('data-add-id');

            document.getElementById('add_QstnExamId').value = examId;

            // ERROR
            //$('#mdlEditCluster').modal('show');
        });
    });

    // Function to reset the preview to the icon
    function resetPreviewToIcon() {
        var imagePreviewDiv = document.getElementById('imagePreview');
        imagePreviewDiv.innerHTML = '<i class="pe-7s-photo icon-gradient bg-premium-dark" style="font-size: 128px;"></i>';
    }

    // Event listener for the file input change
    document.getElementById('add_ExamImg').addEventListener('change', function() {
        var file = this.files[0];
        var fileSize = file.size / (1024 * 1024) * 4; // in 4MB
        var allowedExtensions = /(\.png|\.jpg|\.jpeg|\.webp)$/i;
    
        if (!allowedExtensions.exec(file.name)) {
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "Wrong file type. Upload png, jpg, webp only!",
            }).then(function() {
                document.getElementById('add_ExamImg').value = '';
                resetPreviewToIcon(); 
            });
        } else if (fileSize > 4) {
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "File size exceeded. Max file size is 4MB only!",
            }).then(function() {
                document.getElementById('add_ExamImg').value = ''; 
                resetPreviewToIcon();
            });
        } else {
            // If the file is valid, display a preview
            document.getElementById('imagePreview').innerHTML = '';
            var reader = new FileReader();
    
            reader.onload = function(e) {
                // Construct the HTML string for the container, image, and clear button
                var htmlString = `
                    <div style="position: relative; width: 100%; height: 200px; overflow: hidden;">
                        <img src="${e.target.result}" style="max-width: 100%; max-height: 100%;">
                        <button class="btn btn-secondary" style="position: absolute; bottom: 10px; right: 10px; padding: 5px 10px; cursor: pointer;">
                            Clear
                        </button>
                    </div>
                `;
    
                // Set the innerHTML of the imagePreview div
                document.getElementById('imagePreview').innerHTML = htmlString;
    
                // Add event listener to the clear button
                document.getElementById('imagePreview').querySelector('button').addEventListener('click', function() {
                    document.getElementById('imagePreview').innerHTML = '';
                    document.getElementById('add_ExamImg').value = '';
                    resetPreviewToIcon();
                });
            }
    
            // Read the file as a Data URL
            reader.readAsDataURL(file);
        }
    });
    
    // Event listener for the file input input event
    document.getElementById('add_ExamImg').addEventListener('input', function() {
        if (!this.value) {
            resetPreviewToIcon();
        }
    });


    /* EDIT Question */
    //edit question btn
    document.querySelectorAll('#edit-btn').forEach(function(editbtn) {
        editbtn.addEventListener('click', function() {
            var edit_examId = this.getAttribute('data-edit-id');
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

            document.getElementById('edit_QstnExamId').value = edit_examId;
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

            // Check if edit_exam_Answer is equal to the choices and set its value to the number of the choice if it matches
            var choices = [edit_exam_ch1, edit_exam_ch2, edit_exam_ch3, edit_exam_ch4, edit_exam_ch5, edit_exam_ch6, edit_exam_ch7, edit_exam_ch8, edit_exam_ch9, edit_exam_ch10];
            var answerFound = false; // Flag to check if a match was found
            for (var i = 0; i < choices.length; i++) {
                if (edit_exam_Answer === choices[i]) {
                    edit_exam_Answer = (i + 1).toString(); // Convert the index to a string since the value is expected to be a string
                    answerFound = true; // Set the flag to true since a match was found
                    break; // Exit the loop once a match is found
                }
            }

            // If no match was found, set edit_exam_Answer to 'none'
            if (!answerFound) {
                edit_exam_Answer = 'none';
            }

            document.getElementById('edit_QstnAns').value = edit_exam_Answer;

            // Display the image
            if (edit_exam_Image) {
                var edit_imagePreviewDiv = document.getElementById('edit_imagePreview');
                edit_imagePreviewDiv.innerHTML = '';
                document.getElementById('edit_imagePreview').innerHTML = '<img src="../../uploads/exam_question/' + edit_exam_Image + '" style="max-width:100%; max-height:200px;"/><button class="btn btn-secondary" style="position: absolute; bottom: 10px; right: 10px; padding: 5px 10px; cursor: pointer;">Clear</button>';
                document.getElementById('edit_ImgStatus').value = 'old';
            } else {
                document.getElementById('edit_imagePreview').innerHTML = '<i class="pe-7s-photo icon-gradient bg-premium-dark" style="font-size: 128px;"></i>';
                document.getElementById('edit_ImgStatus').value = 'old';
            }

            // Add event listener to the clear button
            document.getElementById('edit_imagePreview').querySelector('button').addEventListener('click', function() {
                document.getElementById('edit_imagePreview').innerHTML = '<i class="pe-7s-photo icon-gradient bg-premium-dark" style="font-size: 128px;"></i>';
                document.getElementById('edit_ExamImg').value = '';
                document.getElementById('edit_ImgStatus').value = 'clear';
            });

            var modalTitle = document.querySelector('#mdlEditQuestion .modal-title span');
            modalTitle.textContent = edit_examId;
        });
    });

    
    
    

    // TO DO: Add clear button
    /*document.getElementById('clearButton').addEventListener('click', function() {
        document.getElementById('add_ExamImg').value = ''; // Clear the file input
        resetPreviewToIcon(); // Reset the preview to the icon
    });*/

});
