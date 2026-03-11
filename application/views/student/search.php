<?php $this->load->view("inc/app_header.php"); ?>

    <div class="row mb-5">
        <div class="col-md-6">
            <h1>Search Students</h1>
        </div>
    </div>

    <div class="row mb-5">
        <div class="col-md-12 mb-5">
            <div class="card card-flush h-xl-100">
                <div class="card-body py-9">
                    <div class="row">
                        <h4 class="mb-3">Search Parameters</h4>
                    </div>
                    <form action="<?php echo base_url() ?>students/search" method="GET">
                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td style="vertical-align: middle;">Student No</td>
                                        <td>
                                            <input class="form-control" type="text" name="student_no" value="<?php if(isset($_GET['student_no'])) echo $_GET['student_no']; ?>">
                                        </td>
                                        <td style="vertical-align: middle;">Name</td>
                                        <td>
                                            <input class="form-control" type="text" name="f_name" value="<?php if(isset($_GET['f_name'])) echo $_GET['f_name']; ?>">
                                        </td>
                                        <td style="vertical-align: middle;">Class</td>
                                        <td>
                                            <select class="form-select" name="class_id" id="class_id" >
                                                <option value="">Please Select</option>
                                                <?php foreach ($classes as $class) { ?>
                                                    <option value="<?php echo $class["id"] ?>" <?php if(isset($_GET["class_id"]) && $_GET["class_id"] == $class["id"]) {echo "selected";}?>><?php echo $class["name"] ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        <td style="vertical-align: middle;">Section</td>
                                        <td>
                                            <select class="form-select" id="section_id" name="section_id"  <?php if(!isset($sections)) { echo "disabled"; }?>>
                                                <option value="">Please Select</option>
                                                <?php foreach ($sections as $section) { ?>
                                                    <option value="<?php echo $section["id"] ?>" <?php if(isset($_GET["section_id"]) && $_GET["section_id"] == $section["id"]) {echo "selected";}?>><?php echo $section["name"] ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="vertical-align: middle;">Student Type</td>
                                        <td>
                                            <select class="form-select" name="student_type_id"  value="<?php echo set_value('student_type_id'); ?>">
                                                <option value="">Please Select</option>
                                                <?php foreach ($student_types as $type) { ?>
                                                    <option value="<?php echo $type["id"] ?>" <?php if(isset($_GET['student_type_id']) && ($_GET['student_type_id'] == $type['id'])) {echo "selected";} ?>><?php echo $type["name"] ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        <td style="vertical-align: middle;">House</td>
                                        <td>
                                            <select class="form-select"  name="house_id" value="<?php echo set_value('house_id'); ?>">
                                                <option value="">Please Select</option>
                                                <?php foreach ($houses as $house) { ?>
                                                    <option value="<?php echo $house["id"] ?>" <?php if(isset($_GET['house_id']) && ($_GET['house_id'] == $house['id'])) {echo "selected";} ?>><?php echo $house["name"] ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        <td style="vertical-align: middle;">Sex</td>
                                        <td>
                                            <select class="form-select" name="sex"  value="<?php echo set_value('sex'); ?>">
                                                <option value="">Please Select</option>
                                                <option value="male" <?php if(isset($_GET['sex']) && ($_GET['sex'] == 'male')) {echo "selected";} ?>>Male</option>
                                                <option value="female" <?php if(isset($_GET['sex']) && ($_GET['sex'] == 'female')) {echo "selected";} ?>>Female</option>
                                                <option value="other" <?php if(isset($_GET['sex']) && ($_GET['sex'] == 'other')) {echo "selected";} ?>>Other</option>
                                            </select>
                                        </td>
                                        <td style="vertical-align: middle;">Medical Status</td>
                                        <td>
                                            <select class="form-select" name="medical_status" value="<?php echo set_value('medical_status'); ?>">
                                                <option value="">Please Select</option>
                                                <option value="fit" <?php if(isset($_GET['medical_status']) && ($_GET['medical_status'] == 'fit')) {echo "selected";} ?>>Fit</option>
                                                <option value="differently_abled" <?php if(isset($_GET['medical_status']) && ($_GET['medical_status'] == 'differently_abled')) {echo "selected";} ?>>Differently Abled</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="vertical-align: middle;">Category</td>
                                        <td>
                                            <select class="form-select" name="category_id" value="<?php echo set_value('category_id'); ?>">
                                                <option value="">Please Select</option>
                                                <?php foreach ($categories as $category) { ?>
                                                    <option value="<?php echo $category["id"] ?>" <?php if(isset($_GET['category_id']) && ($_GET['category_id'] == $category['id'])) {echo "selected";} ?>><?php echo $category["name"] ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        <td style="vertical-align: middle;">Religion</td>
                                        <td>
                                            <select class="form-select" name="religion_id" value="<?php echo set_value('religion_id'); ?>">
                                                <option value="">Please Select</option>
                                                <?php foreach ($religions as $religion) { ?>
                                                    <option value="<?php echo $religion["id"] ?>" <?php if(isset($_GET['religion_id']) && ($_GET['religion_id'] == $religion['id'])) {echo "selected";} ?>><?php echo $religion["name"] ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        <td style="vertical-align: middle;">Nationality</td>
                                        <td>
                                            <select class="form-select" name="nationality_id" value="<?php echo set_value('nationality_id'); ?>">
                                                <option value="">Please Select</option>
                                                <?php foreach ($nationalities as $nationality) { ?>
                                                    <option value="<?php echo $nationality["id"] ?>" <?php if(isset($_GET['nationality_id']) && ($_GET['nationality_id'] == $nationality['id'])) {echo "selected";} ?>><?php echo $nationality["name"] ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        <td style="vertical-align: middle;">State</td>
                                        <td>
                                            <select class="form-select" name="state_id" value="<?php echo set_value('state_id'); ?>">
                                                <option value="">Please Select</option>
                                                <?php foreach ($states as $state) { ?>
                                                    <option value="<?php echo $state["id"] ?>" <?php if(isset($_GET['state_id']) && ($_GET['state_id'] == $state['id'])) {echo "selected";} ?>><?php echo $state["name"] ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="vertical-align: middle;">Phone</td>
                                        <td>
                                            <input type="text" class="form-control" name="phone" value="<?php if(isset($_GET['phone'])) echo $_GET['phone']; ?>">
                                        </td>
                                        <td style="vertical-align: middle;">Email</td>
                                        <td>
                                            <input type="text" class="form-control" name="email" value="<?php if(isset($_GET['email'])) echo $_GET['email']; ?>">
                                        </td>
                                        <td style="vertical-align: middle;">Status</td>
                                        <td>
                                            <select class="form-select" name="status">
                                                <option value="">Please Select</option>
                                                <option value="ACTIVE" <?php if(isset($_GET['status']) && ($_GET['status'] == 'ACTIVE')) {echo "selected";} ?>>Active</option>
                                                <option value="INACTIVE" <?php if(isset($_GET['status']) && ($_GET['status'] == 'INACTIVE')) {echo "selected";} ?>>Inactive</option>
                                                <option value="WITHDRAWN" <?php if(isset($_GET['status']) && ($_GET['status'] == 'WITHDRAWN')) {echo "selected";} ?>>Withdrawn</option>
                                                <option value="PASSED OUT" <?php if(isset($_GET['status']) && ($_GET['status'] == 'PASSED OUT')) {echo "selected";} ?>>Pass Out</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="8" class="text-center">
                                            <button type="submit" class="btn btn-success"><i class="fa fa-search"></i> Search</button> 
                                            <?php if(count($_GET) > 0) {?>
                                                <a href="<?php base_url()?>search" class="btn btn-warning">Reset</a>
                                            <?php } else { ?>
                                                <input type="reset" class="btn btn-warning" value="Reset">
                                            <?php } ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php if(isset($students)) { ?>
        <div class="row mb-5">
            <div class="col-md-12 mb-5">
                <div class="card card-flush h-xl-100">
                    <div class="card-body py-9">
                        <div class="row">
                            <h4 class="mb-3">Students</h4>
                        </div>
                        <div class="row">
                            <?php if(count($students) == 0) { ?>
                                <h4 class="text-center">No Students Found</h4>    
                            <?php } else { ?>
                                <div class="table-responsive table-bordered table-striped table-hover">
                                    <table class="table">
                                        <thead>
                                            <tr class="text-center table-dark text-light">
                                                <th></th>
                                                <th>Studnet No</th>
                                                <th>Name</th>
                                                <th>Class</th>
                                                <th>Section</th>
                                                <th>Student Type</th>
                                                <th>House</th>
                                                <th>Phone</th>
                                                <th>Email</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $sl_no = 0; foreach($students as $student) {  $sl_no++; ?>
                                                <tr class="text-center">
                                                    <td class="table-primary text-dark p-2"><?php echo $sl_no ?></td>
                                                    <td><?php echo $student["student_no"] ?></td>
                                                    <td>
                                                        <a href="<?php echo base_url() ?>students/show/<?php echo $student["id"]?>">
                                                            <?php echo $student["f_name"] . " " . $student["m_name"] . " " . $student["l_name"]?>
                                                        </a>
                                                    </td>
                                                    <td><?php 
                                                        foreach ($classes as $class) { 
                                                            
                                                            if(isset($_GET['class_id']) && ($_GET['class_id'] == $class["id"])) {
                                                                echo $class['name'];
                                                            }
                                                        }
                                                    ?></td>
                                                    <td><?php echo $student["section"] ?></td>
                                                    <td><?php echo $student["student_type"] ?></td>
                                                    <td><?php echo $student["house"] ?></td>
                                                    <td><?php echo $student["phone"] ?></td>
                                                    <td><?php echo $student["email"] ?></td>
                                                    <td><?php echo $student["status"] ?></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
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