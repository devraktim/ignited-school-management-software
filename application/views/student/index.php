<?php $this->load->view("inc/app_header.php"); ?>

    <div class="row mb-5">
        <h1>Student List</h1>
    </div>

    <div class="card card-flush h-xl-100">
        <div class="card-body py-9">
            <?php echo form_open(base_url("students"), array("method" => "GET")) ?> 
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
                            <select class="form-select" id="section_id" name="section_id" required <?php if(!isset($sections)) { echo "disabled"; }?>>
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


    <?php 
        if (isset($students)) {
            $total_students = count($students);
            $total_active_students = 0;
            $total_inactive_students = 0;
            $total_withdrawn_students = 0;
            $total_dayscholar_students = 0;
            $total_dayborders_students = 0;
            $total_borders_students = 0;
            $total_male_students = 0;
            $total_female_students = 0;
            $total_other_students = 0;


            foreach($students as $student) {
                if($student['status'] == 'ACTIVE') {$total_active_students++;}
                if($student['status'] == 'INACTIVE') {$total_inactive_students++;}
                if($student['status'] == 'WITHDRAWN') {$total_withdrawn_students++;}
                if($student['sex'] == 'male') {$total_male_students++;}
                if($student['sex'] == 'female') {$total_female_students++;}
                if($student['sex'] == 'other') {$total_other_students++;}
                if($student['student_type_id'] == 1) {$total_dayscholar_students++;}
                if($student['student_type_id'] == 2) {$total_dayborders_students++;}
                if($student['student_type_id'] == 3) {$total_borders_students++;}
            }

        }       
    ?>

    <?php if(isset($students)) { ?>
        <div class="card card-flush h-xl-100 mt-5">
            <div class="card-body py-9">
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <td rowspan="3" style="text-align:center; vertical-align: middle; color: black; font-weight: bold;" class="text-center table-danger">Total<br>Students</br><span style="font-size: 22px;"><?php echo $total_students; ?></span></td>
                                        <td class="text-center table-warning" style="color: black; font-weight: bold;">Active Students</td>
                                        <td class="text-center table-primary" style="color: black;"><?php echo $total_active_students; ?></td>
                                        <td class="text-center table-warning" style="color: black; font-weight: bold;">Inactive Students</td>
                                        <td class="text-center table-primary" style="color: black;"><?php echo $total_inactive_students; ?></td>
                                        <td class="text-center table-warning" style="color: black; font-weight: bold;">Withdrawn Students</td>
                                        <td class="text-center table-primary" style="color: black;"><?php echo $total_withdrawn_students; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="text-center table-warning" style="color: black; font-weight: bold;">Day Scholars</td>
                                        <td class="text-center table-primary" style="color: black;"><?php echo $total_dayscholar_students; ?></td>
                                        <td class="text-center table-warning" style="color: black; font-weight: bold;">Day Boarders</td>
                                        <td class="text-center table-primary" style="color: black;"><?php echo $total_dayborders_students; ?></td>
                                        <td class="text-center table-warning" style="color: black; font-weight: bold;">Boarders</td>
                                        <td class="text-center table-primary" style="color: black;"><?php echo $total_borders_students; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="text-center table-warning" style="color: black; font-weight: bold;">Male Students</td>
                                        <td class="text-center table-primary" style="color: black;"><?php echo $total_male_students; ?></td>
                                        <td class="text-center table-warning" style="color: black; font-weight: bold;">Female Students</td>
                                        <td class="text-center table-primary" style="color: black;"><?php echo $total_female_students; ?></td>
                                        <td class="text-center table-warning" style="color: black; font-weight: bold;">Other Students</td>
                                        <td class="text-center table-primary" style="color: black;"><?php echo $total_other_students; ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    

    <?php if(isset($students)) { ?>
        <div class="card card-flush h-xl-100 mt-5">
            <div class="card-body py-9">
                <?php if(count($students) > 0) { ?>
                    <div class="row justify-content-center">
                        <?php foreach($students as $student) { ?>
                            <div class="col-md-3 p-md-4 p-sm-2">
                                <a href="<?php echo base_url() ?>students/show/<?php echo $student["id"]?>">
                                    <div class="card" style="width: 80%; cursor: pointer; box-shadow: 1px 7px 11px 0px #b5b5b5;">
                                        <div class="row justify-content-center">
                                            <?php if($student["image"]) { ?>
                                                <img class="card-img-top" src="<?php echo base_url('storage/students/') . $student['image'] ?>" style="opacity: <?php echo $student['status'] == "ACTIVE" ? '1' : '0.3' ?>">
                                            <?php } else { ?>
                                                <img class="card-img-top" src="<?php echo base_url('assets/media/avatar/') ?><?php echo $student['sex'] == 'male' ? 'male.jpg' : 'female.jpg' ?>" style="height: 200px; width: fit-content; opacity: <?php echo $student['status'] == "ACTIVE" ? '1' : '0.3' ?>">
                                            <?php } ?>
                                        </div>
                                        <div class="card-body" style="padding: 0; padding-top: 10px;">
                                            <h4 class="card-title text-center"><?php echo $student['f_name'] . " " . $student['m_name'] . " " . $student['l_name'] ?></h4>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        <?php } ?>
                    </div>
                <?php } else { ?>
                    <div class="row justify-content-center">
                        <h3 class="text-center">No Student Found</h3>
                    </div>
                <?php } ?>
            </div>
        </div>
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
    </script>

<?php $this->load->view("inc/app_footer.php"); ?>