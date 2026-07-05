<?php $this->load->view("inc/app_header.php"); ?>

    <div class="row mb-5">
        <div class="col-md-6">
            <h1>Student Subjects</h1>
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

    <div class="card card-flush h-xl-100">
        <div class="card-body py-9">
            <?php echo form_open(base_url("academics/student-subjects"), array("method" => "GET")) ?> 
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <div class="form-group">
                            <label class="form-label">Select Class</label>
                            <select class="form-select" name="class_id" id="class_id" required>
                                <option value="">Please Select</option> 
                                <?php foreach ($classes as $class) { ?>
                                    <option value="<?php echo $class["id"] ?>" <?php if(isset($_GET["class_id"]) && $_GET["class_id"] == $class["id"]) {echo "selected";}?>><?php echo $class["name"] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="form-group">
                            <label class="form-label">Select Section</label>
                            <select class="form-select" id="section_id" name="section_id" <?php if(!isset($sections)) { echo "disabled"; }?> required>
                                <option value="">Please Select</option>
                                <?php foreach ($sections as $section) { ?>
                                    <option value="<?php echo $section["id"] ?>" <?php if(isset($_GET["section_id"]) && $_GET["section_id"] == $section["id"]) {echo "selected";}?>><?php echo $section["name"] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="form-group">
                            <label class="form-label">Select Subject Type</label>
                            <select class="form-select" id="subject_type_id" name="subject_type_id" <?php if(!isset($sections)) { echo "disabled"; }?> required>
                                <option value="">Please Select</option>
                                <?php foreach ($subject_types as $subject_type) { ?>
                                    <option value="<?php echo $subject_type["id"] ?>" <?php if(isset($_GET['subject_type_id']) && $_GET['subject_type_id'] == $subject_type['id']) { echo "selected" ;}?>><?php echo $subject_type["name"] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3" style="margin-top: 25px;">
                        <button id="btn_save" class="btn btn-success" <?php if(!isset($sections)) { echo "disabled"; }?>><i class="fa fa-search"></i> Search</button>
                    </div>
                </div>
            <?php echo form_close() ?> 
        </div>
    </div>

    <?php if(isset($students)) { ?>
        <div class="row mb-5">
            <div class="col-md-8">
                <div class="card card-flush h-xl-100 mt-5">
                    <div class="card-body py-9">
                        <div class="row">
                            <?php echo form_open(base_url("academics/student-subjects"), array("method" => "POST", "id" => "student_subjecttype_subjects")) ?>
                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered">
                                        <thead>
                                            <tr class="table-dark text-light">
                                                <th></th>
                                                <th>Student No</th>
                                                <th>Name</th>
                                                <th>Roll</th>
                                                <th>Subject</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 0; foreach($students as $student) { $i++; ?>
                                                <tr>
                                                    <td class="table-dark text-light" style="padding-left: 6px;"><?php echo $i; ?></td>
                                                    <td><?php echo $student['student_no']; ?></td>
                                                    <td><?php echo $student['f_name'] . " " . $student['m_name'] . " " . $student['l_name'] ?></td>
                                                    <td><?php echo $student['roll_no'] ?></td>
                                                    <td>
                                                        <select class="form-control subject" name="subject_id[]">
                                                            <option value="">Please Select</option>
                                                            <?php foreach($subjects as $subject) { ?>
                                                                <option value="<?php echo $subject['id'] ?>" <?php if($subject['id'] == $student['subject_id']) {echo "selected";} ?>><?php echo $subject['name'] ?></option>
                                                            <?php } ?>
                                                        </select>
                                                        <input type="text" class="d-none" name="student_id[]" value="<?php echo $student["id"] ?>" />
                                                        <input type="text" class="d-none subject_type_id" name="subject_type_id" value="<?php if(isset($_GET["subject_type_id"])) {echo $_GET["subject_type_id"];} ?>" />
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php echo form_close() ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-flush h-xl-100 mt-5">
                    <div class="card-body py-9">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <td style="vertical-align: middle;">Default Subject</td>
                                        <td>
                                            <select class="form-select" id="default_subject">
                                                <option value="">Please Select</option>
                                                <?php foreach($subjects as $subject) { ?>
                                                    <option value="<?php echo $subject['id'] ?>"><?php echo $subject['name'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-primary" onclick="setDefaultSubject()">Set</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php if($this->session->user['permissions'][0]['academics_module'] != "VIEWER") { ?>
        <button type="submit" class="btn btn-success rounded rounded-pill mt-4" onclick="submit()"><i class="fa fa-plus"></i> Save</button>
        <?php } ?>    
    <?php } ?>

    <script>
        $("#class_id").change(function(event) {
            $("#class_id").val()

            fetch("<?php echo base_url('students?class_id=') ?>" + $("#class_id").val())
            .then(response => response.json())
            .then(data => {
                $("#section_id").empty()

                $("#section_id").append(`
                    <option value=''>Please Select</option>
                `)
                
                data.sections.forEach((section) => {
                    $("#section_id").append(`
                        <option value=${section.id}>${section.name}</option>
                    `)
                })

                $("#section_id").prop("disabled", false)
                $("#btn_save").prop("disabled", false)

            })
        })

        $("#section_id").change(function (event) {
            $("#subject_type_id").prop("disabled", false)
        })

        $("#subject_type_id").change(function (event) {
            $(".subject_type_id").val($("#subject_type_id").val())
        })

        function setDefaultSubject() {
            $(".subject").val($("#default_subject").val())
        }

        function submit() {
            $("#student_subjecttype_subjects").submit()
        }
    </script>

<?php $this->load->view("inc/app_footer.php"); ?>