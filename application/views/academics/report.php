<?php $this->load->view("inc/app_header.php"); ?>

    <div class="row mb-5">
        <div class="col-md-6">
            <h1>Report</h1>
        </div>
        <div class="col-md-2"></div>
        <div class="col-md-4 text-center">
            <?php if($this->session->flashdata('success'))  {?>
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    <strong><?php echo $this->session->flashdata('success')?></strong>
                </div>
            <?php } ?>
        </div>
    </div>

    <div class="card card-flush h-xl-100 mb-5">
        <div class="card-body py-9">
            <form action="<?php echo base_url() ?>academics/result" method="POST" target="print_popup" onsubmit="window.open('about:blank','print_popup','width=1000,height=500');">
                <div class="row">
                    <div class="col-md-2 mb-3">
                        <div class="form-group">
                            <label class="form-label">Class</label>
                            <select class="form-select" name="class_id" id="class_id" required>
                                <option value="">Please Select</option>
                                <?php foreach ($classes as $class) { ?>
                                    <option value="<?php echo $class["id"] ?>" <?php if(isset($class_id) && $class_id == $class["id"]) {echo "selected";}?>><?php echo $class["name"]  ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2 mb-3">
                        <div class="form-group">
                            <label class="form-label">Section</label>
                            <select class="form-select" id="section_id" name="section_id" required>
                                <option value="">Please Select</option>
                                <?php foreach ($sections as $section) { ?>
                                    <option value="<?php echo $section["id"] ?>" <?php if(isset($section_id) && $section_id == $section["id"]) {echo "selected";}?>><?php echo $section["name"] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    
                   
                    
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="form-label">Exams</label>
                            <select class="form-select" id="exam_id" name="exam_id" required <?php if(!isset($exam_id)) {  }?>>
                                <option value="">Please Select</option>
                                <?php foreach ($exams as $exam) { ?>
                                    <option value="<?php echo $exam["id"] ?>" <?php if(isset($exam_id) && $exam_id == $exam["id"]) {echo "selected";}?>> <?php echo $exam['name'] ?> (<?php echo $exam['short_name'] ?>) </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="form-label">Report For</label>
                            <select class="form-select" id="report_for" name="report_for" required>
                                <option value="all">All</option>
                                <option value="individual">Individual</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-2 mb-3">
                        <div class="form-group">
                          <label class="form-label">Student No</label>
                          <select class="form-select" id="student_id" name="student_id" disabled>
            
                          </select>
                        </div>
                    </div>


                    <div class="col-md-2 mb-3">
                        <div class="form-group">
                          <label class="form-label">Report Type</label>
                          <select class="form-select" name="result_type">
                            <option value="result">Result</option>
                            <option value="tabulation">Tabulation</option>
                          </select>
                        </div>
                    </div>
                    
                    <div class="col-md-2 mb-3">
                        <div class="form-group">
                          <label class="form-label">Header</label>
                          <select class="form-select" name="header">
                            <option value="yes">With Header</option>
                            <option value="no">Without Header</option>
                          </select>
                        </div>
                    </div>

                    <div class="col-md-8 mb-3" style="margin-top: 25px;">
                        <button id="btn_save" class="btn btn-success" type="submit" <?php if(!isset($sections)) { echo "disabled"; }?>><i class="fa fa-search"></i> Search</button>
                        
                        <button class="btn btn-primary ms-3" type="button" id="generate_result_for_website" <?php if(!isset($sections)) { echo "disabled"; }?>>Generate Result for Website</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Modal Structure -->
    <div class="modal fade" id="loadingModal" tabindex="-1" aria-labelledby="loadingModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="loadingModalLabel">Generating Result for Website...</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
              <!-- Initial Circular loading spinner (hidden initially) -->
              <div id="loadingSpinner">
                <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                  
                <!-- Message below the spinner -->
                <p class="mt-3">Please wait, your request is being processed.</p>
              </div>
              
              <!-- Success message hidden initially -->
              <div id="successMessage" style="display: none;">
                <i class="bi bi-check-circle-fill text-success" style="font-size: 3rem;"></i>
                <p class="mt-3">Processing completed successfully!</p>
              </div>
            </div>
          </div>
        </div>
    </div>
    
    <script>
        $(document).ready(function () {
            $("#generate_result_for_website").on("click", function () {
                const form = document.querySelector("form");
                const formData = new FormData(form);
                formData.append('store', 'yes'); 
                
                let exam_id = $("select[name='exam_id']").val()
                let name = ""
                
                if(exam_id == 2)
                    name = "first_term"    
                if(exam_id == 4)
                    name = "annual_term"

                const url = `<?php echo base_url() ?>academics/result/${name}`;
    
                // Show loading modal
                const myModal = new bootstrap.Modal(document.getElementById('loadingModal'));
                document.getElementById('loadingSpinner').style.display = 'block';
                document.getElementById('successMessage').style.display = 'none';
                myModal.show();
    
                fetch(url, {
                    method: "POST",
                    body: formData
                })
                .then(response => response.text())
                .then(data => {
                    // You can log or process `data` as needed
                    // For now just simulate a success after delay
                    document.getElementById('loadingSpinner').style.display = 'none';
                    document.getElementById('successMessage').style.display = 'block';
                    
                })
                .catch(error => {
                    console.error("Error submitting form:", error);
                    myModal.hide();
                    alert("There was an error generating the result.");
                });
            });
        });
    </script>
    
    <script>
        $("#class_id").change(function(event) {
            $("#class_id").val()

            fetch("<?php echo base_url('academics/report?class_id=') ?>" + $("#class_id").val())
            .then(response => response.json())
            .then(data => {
                // Set Section Options
                $("#section_id").empty()

                $("#section_id").append(`
                    <option value=''>Please Select</option>
                `)
                
                data.sections.forEach((section) => {
                    $("#section_id").append(`
                        <option value=${section.id}>${section.name}</option>
                    `)
                })

                // Set Exam Options
                $("#exam_id").empty()

                $("#exam_id").append(`
                    <option value=''>Please Select</option>
                `)
                
                // data.exams.forEach((exam) => {
                //     $("#exam_id").append(`
                //         <option value=${exam.id}>${exam.name}</option>
                //     `)
                // })
                
                // Initialize an empty array to track already added exams by their ID
                const addedExamIds = new Set();
                
                // Loop through exams and add unique ones to the select element
                data.exams.forEach((exam) => {
                    if (!addedExamIds.has(exam.id)) {
                        $("#exam_id").append(`
                            <option value="${exam.id}">${exam.name}</option>
                        `);
                        addedExamIds.add(exam.id);  // Mark this exam ID as added
                    }
                });

                $("#section_id").prop("disabled", false)
                $("#exam_id").prop("disabled", false)
                $("#btn_save").prop("disabled", false)
                $("#generate_result_for_website").prop("disabled", false)
            })
        })
        
        $("#section_id").change(function(event) {
            fetch("<?php echo base_url('academics/report/get-students?class_id=') ?>" + $("#class_id").val() + "&section_id=" + $("#section_id").val())
            .then(response => response.json())
            .then(data => {
                $("#student_id").empty()
                $("#student_id").append(`<option value="">Please Select</option>`)
                data.data.forEach((student) => {
                    $("#student_id").append(`
                        <option value=${student.id}>${student.student_no}</option>
                    `)
                })
            })
        })
        
        $("#report_for").change(function(event) {
            if($("#report_for").val() == "individual") {
                $('#student_id').prop("required", true);
                $('#student_id').removeAttr("disabled");
            }
            else {
                $('#student_id').prop("required", false);
                $('#student_id').prop("disabled", true); 
            }
        })
        
        $("#btn_save").on("click", function(event) {
            event.preventDefault()
            let exam_id = $("select[name='exam_id']").val()
            let name = ""
            
            if(exam_id == 2)
                name = "first_term"    
            if(exam_id == 4)
                name = "annual_term"
                
            $("form").attr('action', `<?php echo base_url() ?>academics/result/${name}`).submit();
            
        })
    </script>
<?php $this->load->view("inc/app_footer.php"); ?>