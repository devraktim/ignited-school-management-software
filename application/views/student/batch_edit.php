<?php $this->load->view("inc/app_header.php"); ?>

    <div class="row mb-5">
        <div class="col-md-6">
            <h1>Batch Edit Students</h1>
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
            <?php echo form_open(base_url("students/batch/edits"), array("method" => "GET")) ?> 
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
                                <?php foreach ($sections as $section) { ?>
                                    <option value="<?php echo $section["id"] ?>" <?php if(isset($_GET["section_id"]) && $_GET["section_id"] == $section["id"]) {echo "selected";}?>><?php echo $section["name"] ?></option>
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

    <?php if(isset($students) && count($students) == 0) { ?>
        <div class="card card-flush h-xl-100 mt-5">
            <div class="card-body py-9">
                <h4 class="text-center">No Students Found</h4>
            </div>
        </div>
    <?php } ?>

    <?php if(isset($students) && count($students) > 0) { ?>
        <form action="<?php echo base_url() ?>students/batch/updates" method="POST" enctype="multipart/form-data">
            <div class="row mb-5">
                <div class="col-md-8 mb-5">
                    <div class="card card-flush h-xl-100 mt-5">
                        <div class="card-body py-9">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr class="table-dark text-light">
                                            <th></th>
                                            <th>Student No</th>
                                            <th>Name</th>
                                            <th>Roll No</th>
                                            <th>Section</th>
                                            <th>House</th>
                                            <th>Student Type</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $sl_no = 0 ; foreach($students as $student) { $sl_no++;?>
                                            <tr>
                                                <td class="table-primary text-dark p-2"><?php echo $sl_no ?></td>
                                                <td><?php echo $student['student_no'] ?></td>
                                                <td><?php echo $student['f_name'] . " " . $student['m_name'] . " " . $student['l_name'] ?></td>
                                                <td>
                                                    <input type="text" class="form-control roll" name="roll_no[]" value="<?php echo $student['roll_no'] ?>" style="width: 100px;" />
                                                </td>
                                                <td>
                                                    <select class="form-control section" name="section_id[]">
                                                        <?php foreach ($sections as $section) { ?>
                                                            <option value="<?php echo $section["id"] ?>" <?php if($section["id"]==$_GET["section_id"]) {echo "selected";} ?>><?php echo $section["name"] ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select class="form-control house" name="house_id[]">
                                                        <?php foreach ($houses as $house) { ?>
                                                            <option value="<?php echo $house["id"] ?>" <?php if($house["id"]==$student["house_id"]) {echo "selected";} ?>><?php echo $house["name"] ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select class="form-control student_type" name="student_type_id[]">
                                                        <?php foreach ($student_types as $type) { ?>
                                                            <option value="<?php echo $type["id"] ?>" <?php if($type["id"]==$student["student_type_id"]) {echo "selected";} ?>><?php echo $type["name"] ?></option>
                                                        <?php } ?>
                                                    </select>
                                                    <input class="d-none" type="text" name="id[]" value="<?php echo $student["id"] ?>">
                                                    <input class="d-none" type="text" name="class_id[]" value="<?php echo $_GET['class_id'] ?>">
                                                </td>
                                            </tr>    
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-5">
                    <div class="card card-flush h-xl-100 mt-5">
                        <div class="card-body py-9">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <td style="vertical-align: middle;">Section</td>
                                            <td>
                                                <select class="form-select" id="default_section">
                                                    <?php foreach ($sections as $section) { ?>
                                                        <option value="<?php echo $section["id"] ?>"><?php echo $section["name"] ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-primary" onclick="setDefaultSection()">Set</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="vertical-align: middle;">House</td>
                                            <td>
                                                <select class="form-select" id="default_house">
                                                    <?php foreach ($houses as $house) { ?>
                                                        <option value="<?php echo $house["id"] ?>"><?php echo $house["name"] ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-primary" onclick="setDefaultHouse()">Set</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="vertical-align: middle;">Student Type</td>
                                            <td>
                                                <select class="form-select" id="default_student_type">
                                                    <?php foreach ($student_types as $type) { ?>
                                                        <option value="<?php echo $type["id"] ?>"><?php echo $type["name"] ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-primary" onclick="setDefaultStudentType()">Set</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="vertical-align: middle;" colspan="2">Continuous Roll No</td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-primary" onclick="setContinuousRollNo()">Set</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-success rounded rounded-pill"><i class="fa fa-plus"></i> Save</button>
        </form>
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

        function setDefaultSection() {
            $(".section").val($("#default_section").val())
        }

        function setDefaultHouse() {
            $(".house").val($("#default_house").val())
        }

        function setDefaultStudentType() {
            $(".student_type").val($("#default_student_type").val())
        }

        function setContinuousRollNo() {
            const rolls = document.getElementsByClassName('roll')

            for(let i = 0; i < rolls.length; i++) {
                rolls[i].value = i+1
            }

            // $(".roll").val($("#default_student_type").val())
        }
    </script>

<?php $this->load->view("inc/app_footer.php"); ?>