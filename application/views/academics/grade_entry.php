<?php $this->load->view("inc/app_header.php"); ?>

    <div class="row mb-5">
        <div class="col-md-6">
            <h1>Grade Entry</h1>
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
            <form action="<?php echo base_url() ?>academics/exam-paper-student" method="POST">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <div class="form-group">
                            <label class="form-label">Select Class</label>
                            <select class="form-select" name="class_id" id="class_id" required>
                                <option value="">Please Select</option>
                                <?php foreach ($classes as $class) { ?>
                                    <option value="<?php echo $class["id"] ?>" <?php if(isset($class_id) && $class_id == $class["id"]) {echo "selected";}?>><?php echo $class["name"]  ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="form-group">
                            <label class="form-label">Select Section</label>
                            <select class="form-select" id="section_id" name="section_id" required <?php if(!isset($sections)) { echo "disabled"; }?>>
                                <?php foreach ($sections as $section) { ?>
                                    <option value="<?php echo $section["id"] ?>" <?php if(isset($section_id) && $section_id == $section["id"]) {echo "selected";}?>><?php echo $section["name"] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label">Select Exams</label>
                            <select class="form-select" id="exam_id" name="exam_id" required <?php if(!isset($exam_id)) { echo "disabled"; }?>>
                                <option value="">Please Select</option>
                                <?php foreach ($exams as $exam) { ?>
                                    <option value="<?php echo $exam["id"] ?>" <?php if(isset($exam_id) && $exam_id == $exam["id"]) {echo "selected";}?>> <?php echo $exam['name'] ?> (<?php echo $exam['short_name'] ?>) </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label">Select Subjects</label>
                            <select class="form-select" id="subject_id" name="subject_id" required <?php if(!isset($subjects)) { echo "disabled"; }?>>
                                <?php foreach ($subjects as $subject) { ?>
                                    <option value="<?php echo $subject["id"] ?>" <?php if(isset($subject_id) && $subject_id == $subject["id"]) {echo "selected";}?>><?php echo $subject["name"] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3" style="margin-top: 25px;">
                        <button id="btn_save" class="btn btn-success" <?php if(!isset($sections)) { echo "disabled"; }?>><i class="fa fa-search"></i> Search</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <?php if(isset($students)) { ?>
        <?php if(count($students) > 0) { ?>
            <div class="row">
                <form action="<?php echo base_url()?>academics/grade-store" method="POST">
                    <div class="col-md-8">
                        <div class="card card-flush h-xl-100">
                            <div class="card-body py-9">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr class="table-dark text-light">
                                                <th></th>
                                                <th>Student No</th>
                                                <th>Roll No</th>
                                                <th>Name</th>
                                                <th>Grades</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 0;foreach($students as $student) { $i++; ?>
                                                <tr>
                                                    <td class="table-primary text-dark p-2"><?php echo $i; ?></td>
                                                    <td><?php echo $student["student_no"]?> </td>
                                                    <td><?php echo $student["roll_no"]?> </td>
                                                    <td><?php echo $student["f_name"] . " " . $student["m_name"] . " " . $student["l_name"] ?></td>
                                                    <td>
                                                        <input type="text" class="form-control d-none" name="ids[]" value="<?php echo $student["id"]?>" />    
                                                        <select class="form-select" name="grades[]">
                                                            <option value="">Please Select</option>
                                                            <?php foreach($exam_grades as $exam_grade) { ?>
                                                                <option value="<?php echo $exam_grade['name'] ?>" <?php if($exam_grade["name"] ==  $student['grade']) {echo "selected";} ?>><?php echo $exam_grade['name'] ?></option>    
                                                            <?php } ?>
                                                        </select>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table> 
                                </div>
                            </div>
                        </div>
                    </div>

                    <input type="text" class="form-control d-none" name="class_id"     value="<?php echo $class_id ?>">
                    <input type="text" class="form-control d-none" name="section_id"   value="<?php echo $section_id ?>">
                    <input type="text" class="form-control d-none" name="exam_id"      value="<?php echo $exam_id ?>">
                    <input type="text" class="form-control d-none" name="subject_id"   value="<?php echo $subject_id ?>">

                    <?php if($this->session->user['permissions'][0]['academics_module'] != "VIEWER") { ?>
                    <button type="submit" class="btn btn-success rounded rounded-pill mt-4"><i class="fa fa-plus"></i> Save</button>
                    <?php } ?>
                </form>
            </div>
        <?php } else { ?>
            <div class="card card-flush h-xl-100">
                <div class="card-body py-9">
                    <h1 class="text-center text-muted">Students Not Found</h1>
                </div>
            </div>
        <?php } ?>
    <?php } ?>

    <script>
        $("#class_id").change(function(event) {
            $("#class_id").val()

            fetch("<?php echo base_url('academics/grade-entry?class_id=') ?>" + $("#class_id").val())
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
            })
        })

        $("#exam_id").change(function(event) {

            fetch("<?php echo base_url('academics/get-exam-paper?class_id=') ?>" + $("#class_id").val() + `&exam_id=${$("#exam_id").val()}&paper_type=grade`)
            .then(response => response.json())
            .then(data => {
                $("#subject_id").empty()

                $("#subject_id").append(`
                    <option value=''>Please Select</option>
                `)
                
                data.subjects.forEach((subject) => {
                    $("#subject_id").append(`
                        <option value=${subject.id}>${subject.name}</option>
                    `)
                })

                $("#subject_id").prop("disabled", false)
                $("#exam_id").prop("disabled", false)
                $("#btn_save").prop("disabled", false)

            })
        })
    </script>
<?php $this->load->view("inc/app_footer.php"); ?>