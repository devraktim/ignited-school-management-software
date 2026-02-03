<?php $this->load->view("inc/app_header.php"); ?>
<link href="https://unpkg.com/bootstrap-table@1.22.0/dist/extensions/reorder-rows/bootstrap-table-reorder-rows.css" rel="stylesheet">

    <div class="row mb-5">
        <h1>User Defined Report</h1>
    </div>

    <form id="form" method="GET" action="<?php echo base_url() ?>students/user-defined-report/get-students">
        <div class="row mb-5">
            <div class="col-md-12">
                <div class="card card-flush h-xl-100">
                    <div class="card-body py-9">
                        <h4 class="text-center text-dark bg-secondary py-3 mb-3">Report Criteria</h4>
                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td style="vertical-align: middle;">Class</td>
                                        <td>
                                            <select class="form-select" id="class_id" name="ss.class_id"  value="<?php echo set_value('class_id'); ?>">
                                                <option value="">Any</option>
                                                <?php foreach ($classes as $class) { ?>
                                                    <option value="<?php echo $class["id"] ?>" <?php if(isset($_GET['ss_class_id']) && ($_GET['ss_class_id'] == $class['id'])) {echo "selected";} ?>><?php echo $class["name"] ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        <td style="vertical-align: middle;">Section</td>
                                        <td>
                                            <select class="form-select" id="section_id" name="ss.section_id"  value="<?php echo set_value('section_id'); ?>">
                                                <option value="">Any</option>
                                                <?php foreach ($sections as $section) { ?>
                                                    <option value="<?php echo $section["id"] ?>" <?php if(isset($_GET['ss_section_id']) && ($_GET['ss_section_id'] == $section['id'])) {echo "selected";} ?>><?php echo $section["name"] ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        <td style="vertical-align: middle;">Student Type</td>
                                        <td>
                                            <select class="form-select" name="s.student_type_id"  value="<?php echo set_value('student_type_id'); ?>">
                                                <option value="">Any</option>
                                                <?php foreach ($student_types as $type) { ?>
                                                    <option value="<?php echo $type["id"] ?>" <?php if(isset($_GET['s_student_type_id']) && ($_GET['s_student_type_id'] == $type['id'])) {echo "selected";} ?>><?php echo $type["name"] ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        <td style="vertical-align: middle;">House</td>
                                        <td>
                                            <select class="form-select"  name="s.house_id" value="<?php echo set_value('house_id'); ?>">
                                                <option value="">Any</option>
                                                <?php foreach ($houses as $house) { ?>
                                                    <option value="<?php echo $house["id"] ?>" <?php if(isset($_GET['s_house_id']) && ($_GET['s_house_id'] == $house['id'])) {echo "selected";} ?>><?php echo $house["name"] ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="vertical-align: middle;">Sex</td>
                                        <td>
                                            <select class="form-select" name="s.sex"  value="<?php echo set_value('sex'); ?>">
                                                <option value="">Any</option>
                                                <option value="male" <?php if(isset($_GET['s_sex']) && ($_GET['s_sex'] == 'male')) {echo "selected";} ?>>Male</option>
                                                <option value="female" <?php if(isset($_GET['s_sex']) && ($_GET['s_sex'] == 'female')) {echo "selected";} ?>>Female</option>
                                                <option value="other" <?php if(isset($_GET['s_sex']) && ($_GET['s_sex'] == 'other')) {echo "selected";} ?>>Other</option>
                                            </select>
                                        </td>
                                        <td style="vertical-align: middle;">Medical Status</td>
                                        <td>
                                            <select class="form-select" name="s.medical_status" value="<?php echo set_value('medical_status'); ?>">
                                                <option value="">Any</option>
                                                <option value="fit" <?php if(isset($_GET['s_medical_status']) && ($_GET['s_medical_status'] == 'fit')) {echo "selected";} ?>>Fit</option>
                                                <option value="differently_abled" <?php if(isset($_GET['s_medical_status']) && ($_GET['s_medical_status'] == 'differently_abled')) {echo "selected";} ?>>Differently Abled</option>
                                            </select>
                                        </td>
                                        <td style="vertical-align: middle;">Category</td>
                                        <td>
                                            <select class="form-select" name="s.category_id" value="<?php echo set_value('category_id'); ?>">
                                                <option value="">Any</option>
                                                <?php foreach ($categories as $category) { ?>
                                                    <option value="<?php echo $category["id"] ?>" <?php if(isset($_GET['s_category_id']) && ($_GET['s_category_id'] == $category['id'])) {echo "selected";} ?>><?php echo $category["name"] ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        <td style="vertical-align: middle;">Religion</td>
                                        <td>
                                            <select class="form-select" name="s.religion_id" value="<?php echo set_value('religion_id'); ?>">
                                                <option value="">Any</option>
                                                <?php foreach ($religions as $religion) { ?>
                                                    <option value="<?php echo $religion["id"] ?>" <?php if(isset($_GET['s_religion_id']) && ($_GET['s_religion_id'] == $religion['id'])) {echo "selected";} ?>><?php echo $religion["name"] ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="vertical-align: middle;">Nationality</td>
                                        <td>
                                            <select class="form-select" name="s.nationality_id" value="<?php echo set_value('nationality_id'); ?>">
                                                <option value="">Any</option>
                                                <?php foreach ($nationalities as $nationality) { ?>
                                                    <option value="<?php echo $nationality["id"] ?>" <?php if(isset($_GET['s_nationality_id']) && ($_GET['s_nationality_id'] == $nationality['id'])) {echo "selected";} ?>><?php echo $nationality["name"] ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        <td style="vertical-align: middle;">State</td>
                                        <td>
                                            <select class="form-select" name="s.state_id" value="<?php echo set_value('state_id'); ?>">
                                                <option value="">Any</option>
                                                <?php foreach ($states as $state) { ?>
                                                    <option value="<?php echo $state["id"] ?>" <?php if(isset($_GET['s_state_id']) && ($_GET['s_state_id'] == $state['id'])) {echo "selected";} ?>><?php echo $state["name"] ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        <button type="submit" class="btn btn-success">Get Students</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    
    <?php if(isset($students) && count($students) == 0) { ?>
        <div class="card card-flush h-xl-100 mt-5">
            <div class="card-body py-9">
                <h4 class="text-center">No Students Found</h4>
            </div>
        </div>
    <?php } ?>

    <?php if(isset($students) && count($students) > 0) { ?>

    <form action="<?php echo base_url() ?>students/user-defined-report" method="POST" enctype="multipart/form-data">
        <div class="row mb-5">
            <div class="col-md-6 mb-5">
                <div class="card card-flush h-xl-100 mt-5">
                    <div class="card-body py-9">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="table-dark text-light">
                                        <th>
                                            <input type="checkbox" id="check-all" class="form-check-input ms-2" checked />
                                        </th>
                                        <th>Student No</th>
                                        <th>Name</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $sl_no = 0; foreach($students as $student) { $sl_no++; ?>
                                        <tr>
                                            <td class="table-primary text-dark p-2">
                                                <input type="checkbox" name="student_ids[]" value="<?php echo $student['id'] ?>" class="form-check-input" checked />
                                            </td>
                                            <td><?php echo $student['student_no'] ?></td>
                                            <td>
                                                <?php echo $student['f_name'] . " " . $student['m_name'] . " " . $student['l_name'] ?>
                                                <!--<input type="hidden" name="student_id" value="<?php echo $student['id'] ?>">-->
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-5">
                <div class="card card-flush h-xl-100 mt-5">
                    <div class="card-body py-9">
                        <div class="form-group">
                            <label for="heading" class="form-label">Heading</label>
                            <input type="text" class="form-control" name="heading" required />
                        </div>
                        
                        <div class="form-group mt-4">
                            <label for="subheading" class="form-label">Sub Heading</label>
                            <input type="text" class="form-control" name="subheading" />
                        </div>
                        
                        <div class="table-responsive mt-4">
                            <table class="table table-bordered" id="columns">
                                <thead>
                                    <tr class="table-dark text-light" >
                                        <th>
                                            <input type="checkbox" id="check-all-fields" class="form-check-input ms-2" />
                                        </th>
                                        <th>Column</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="border border-1 border-dark">
                                        <td class="table-primary text-dark p-2"><input type="checkbox" name="fields[]" value="roll_no" class="form-check-input" /></td>
                                        <td>Roll No</td>
                                    </tr>
                                    <tr class="border border-1 border-dark">
                                        <td class="table-primary text-dark p-2"><input type="checkbox" name="fields[]" value="student_type" class="form-check-input" /></td>
                                        <td>Student Type</td>
                                    </tr>
                                    <tr class="border border-1 border-dark">
                                        <td class="table-primary text-dark p-2"><input type="checkbox" name="fields[]" value="house" class="form-check-input" /></td>
                                        <td>House</td>
                                    </tr>
                                    <tr class="border border-1 border-dark">
                                        <td class="table-primary text-dark p-2"><input type="checkbox" name="fields[]" value="dob" class="form-check-input" /></td>
                                        <td>Date of Birth</td>
                                    </tr>
                                    <tr class="border border-1 border-dark">
                                        <td class="table-primary text-dark p-2"><input type="checkbox" name="fields[]" value="admission_date" class="form-check-input" /></td>
                                        <td>Date of Admission</td>
                                    </tr>
                                    <tr class="border border-1 border-dark">
                                        <td class="table-primary text-dark p-2"><input type="checkbox" name="fields[]" value="class_of_admission" class="form-check-input" /></td>
                                        <td>Class of Admission</td>
                                    </tr>
                                    <tr class="border border-1 border-dark">
                                        <td class="table-primary text-dark p-2"><input type="checkbox" name="fields[]" value="sex" class="form-check-input" /></td>
                                        <td>Sex</td>
                                    </tr>
                                    <tr class="border border-1 border-dark">
                                        <td class="table-primary text-dark p-2"><input type="checkbox" name="fields[]" value="category" class="form-check-input" /></td>
                                        <td>Category</td>
                                    </tr>
                                    <tr class="border border-1 border-dark">
                                        <td class="table-primary text-dark p-2"><input type="checkbox" name="fields[]" value="religion" class="form-check-input" /></td>
                                        <td>Religion</td>
                                    </tr>
                                    <tr class="border border-1 border-dark">
                                        <td class="table-primary text-dark p-2"><input type="checkbox" name="fields[]" value="state" class="form-check-input" /></td>
                                        <td>State</td>
                                    </tr>
                                    <tr class="border border-1 border-dark">
                                        <td class="table-primary text-dark p-2"><input type="checkbox" name="fields[]" value="nationality" class="form-check-input" /></td>
                                        <td>Nationality</td>
                                    </tr>
                                    <tr class="border border-1 border-dark">
                                        <td class="table-primary text-dark p-2"><input type="checkbox" name="fields[]" value="medical_status" class="form-check-input" /></td>
                                        <td>Medical Status</td>
                                    </tr>
                                    <tr class="border border-1 border-dark">
                                        <td class="table-primary text-dark p-2"><input type="checkbox" name="fields[]" value="blood_group" class="form-check-input" /></td>
                                        <td>Blood Group</td>
                                    </tr>
                                    <tr class="border border-1 border-dark">
                                        <td class="table-primary text-dark p-2"><input type="checkbox" name="fields[]" value="ssid" class="form-check-input" /></td>
                                        <td>SSID</td>
                                    </tr>
                                    <tr class="border border-1 border-dark">
                                        <td class="table-primary text-dark p-2"><input type="checkbox" name="fields[]" value="board_registration_no" class="form-check-input" /></td>
                                        <td>Board Registration No</td>
                                    </tr>
                                    <tr class="border border-1 border-dark">
                                        <td class="table-primary text-dark p-2"><input type="checkbox" name="fields[]" value="phone" class="form-check-input" /></td>
                                        <td>Phone</td>
                                    </tr>
                                    <tr class="border border-1 border-dark">
                                        <td class="table-primary text-dark p-2"><input type="checkbox" name="fields[]" value="email" class="form-check-input" /></td>
                                        <td>Email</td>
                                    </tr>
                                    <tr class="border border-1 border-dark">
                                        <td class="table-primary text-dark p-2"><input type="checkbox" name="fields[]" value="aadhaar_no" class="form-check-input" /></td>
                                        <td>Aadhaar Card No</td>
                                    </tr>
                                    <tr class="border border-1 border-dark">
                                        <td class="table-primary text-dark p-2"><input type="checkbox" name="fields[]" value="father_name" class="form-check-input" /></td>
                                        <td>Father</td>
                                    </tr>
                                    <tr class="border border-1 border-dark">
                                        <td class="table-primary text-dark p-2"><input type="checkbox" name="fields[]" value="father_mobile" class="form-check-input" /></td>
                                        <td>Father's Phone</td>
                                    </tr>
                                    <tr class="border border-1 border-dark">
                                        <td class="table-primary text-dark p-2"><input type="checkbox" name="fields[]" value="father_email" class="form-check-input" /></td>
                                        <td>Father's Email</td>
                                    </tr>
                                    <tr class="border border-1 border-dark">
                                        <td class="table-primary text-dark p-2"><input type="checkbox" name="fields[]" value="mother_name" class="form-check-input" /></td>
                                        <td>Mother</td>
                                    </tr>
                                    <tr class="border border-1 border-dark">
                                        <td class="table-primary text-dark p-2"><input type="checkbox" name="fields[]" value="mother_mobile" class="form-check-input" /></td>
                                        <td>Mother's Phone</td>
                                    </tr>
                                    <tr class="border border-1 border-dark">
                                        <td class="table-primary text-dark p-2"><input type="checkbox" name="fields[]" value="mother_email" class="form-check-input" /></td>
                                        <td>Mother's Email</td>
                                    </tr>
                                    <tr class="border border-1 border-dark">
                                        <td class="table-primary text-dark p-2"><input type="checkbox" name="fields[]" value="local_gurdian_name" class="form-check-input" /></td>
                                        <td>Local Guardian</td>
                                    </tr>
                                    <tr class="border border-1 border-dark">
                                        <td class="table-primary text-dark p-2"><input type="checkbox" name="fields[]" value="local_gurdian_mobile" class="form-check-input" /></td>
                                        <td>Guardian's Phone</td>
                                    </tr>
                                    <tr class="border border-1 border-dark">
                                        <td class="table-primary text-dark p-2"><input type="checkbox" name="fields[]" value="local_gurdian_email" class="form-check-input" /></td>
                                        <td>Guardian's Email</td>
                                    </tr>
                                    <tr class="border border-1 border-dark">
                                        <td class="table-primary text-dark p-2"><input type="checkbox" name="fields[]" value="local_address" class="form-check-input" /></td>
                                        <td>Local Address</td>
                                    </tr>
                                    <tr class="border border-1 border-dark">
                                        <td class="table-primary text-dark p-2"><input type="checkbox" name="fields[]" value="permanent_address" class="form-check-input" /></td>
                                        <td>Permanent Address</td>
                                    </tr>
                                    <tr class="border border-1 border-dark">
                                        <td class="table-primary text-dark p-2"><input type="checkbox" name="fields[]" value="previous_school_name" class="form-check-input" /></td>
                                        <td>Previous School</td>
                                    </tr>
            
                                    <?php foreach($subject_types as $subject_type) {  ?>
                                    
                                    <tr class="border border-1 border-dark">
                                        <td class="table-primary text-dark p-2">
                                            <input type="checkbox" name="fields[]" value="subjecttype_<?php echo $subject_type['id'] ?>" class="form-check-input" />
                                        </td>
                                        <td><?php echo $subject_type['name'] ?></td>
                                    </tr>
                                    
                                    <?php } ?>
                                    
                                    <tr class="border border-1 border-dark">
                                        <td class="table-primary text-dark p-2"><input type="checkbox" name="fields[]" value="blank_columns" class="form-check-input" /></td>
                                        <td>Blank Columns</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        <div id="blank-columns-table" style="display: none;">
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="table-dark text-light">
                                        <th>Column</th>
                                        <th>Heading</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="blank-columns-body">
                                    <!-- Initial Row -->
                                    <tr>
                                        <td>Blank Column 1</td>
                                        <td><input type="text" class="form-control" name="blank_column[]" /></td>
                                        <td><button type="button" class="btn btn-danger btn-sm delete-row">Delete</button></td>
                                    </tr>
                                </tbody>
                            </table>
                            <button type="button" id="add-new-column" class="btn btn-secondary mt-4">Add New Column</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <button type="submit" class="btn btn-success rounded rounded-pill"><i class="fa fa-plus"></i> Generate Report</button>
    </form>
    
    <?php } ?>
    
    <!-- jQuery UI JavaScript -->
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    
    <!-- jQuery UI CSS -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    
    <script>
        $(document).ready(function() {
            // Handle check-all-fields checkbox
            $('#check-all-fields').on('change', function() {
                $('input[name="fields[]"]').prop('checked', $(this).prop('checked'));
                toggleBlankColumnsTable();
            });
        
            // Handle individual checkboxes
            $('input[name="fields[]"]').on('change', function() {
                toggleBlankColumnsTable();
            });
        
            // Toggle visibility of the blank columns table
            function toggleBlankColumnsTable() {
                if ($('input[name="fields[]"][value="blank_columns"]').is(':checked')) {
                    $('#blank-columns-table').show();
                } else {
                    $('#blank-columns-table').hide();
                }
            }
        
            // Add new column row
            $('#add-new-column').on('click', function() {
                var rowCount = $('#blank-columns-body tr').length + 1;
                var newRow = `
                    <tr>
                        <td>Blank Column ${rowCount}</td>
                        <td><input type="text" class="form-control" name="blank_column[]" /></td>
                        <td><button class="btn btn-danger btn-sm delete-row">Delete</button></td>
                    </tr>
                `;
                $('#blank-columns-body').append(newRow);
            });
        
            // Delete a row
            $('#blank-columns-body').on('click', '.delete-row', function() {
                var $row = $(this).closest('tr');
                if ($('#blank-columns-body tr').length > 1) {
                    $row.remove();
                    updateBlankColumnNumbers();
                }
            });
        
            // Update blank column numbers
            function updateBlankColumnNumbers() {
                $('#blank-columns-body tr').each(function(index) {
                    $(this).find('td').first().text(`Blank Column ${index + 1}`);
                });
            }
        });
        
        $(document).ready(function() {
            $('#check-all').on('change', function() {
                var isChecked = $(this).is(':checked');
                $('input[name="student_ids[]"]').each(function() {
                    $(this).prop('checked', isChecked);
                });
            });
            
            $('#check-all-fields').on('change', function() {
                var isChecked = $(this).is(':checked');
                $('input[name="fields[]"]').each(function() {
                    $(this).prop('checked', isChecked);
                });
            });
        });
        
        function fetch_section() {
            $("#class_id").val()
            fetch("<?php echo base_url('students?class_id=') ?>" + $("#class_id").val())
            .then(response => response.json())
            .then(data => {
                $("#section_id").empty()

                $("#section_id").append(`
                    <option value=''>Any</option>
                `)
                
                data.sections.forEach((section) => {
                    $("#section_id").append(`
                        <option value=${section.id}>${section.name}</option>
                    `)
                })

                $("#section_id").prop("disabled", false)
            })
        }


        $(document).ready(function () {
            $("#section_id").prop("disabled", true)

            fetch_section()
            
            $("#class_id").change(function(event) {
                fetch_section()
            })
        })
    </script>

<?php $this->load->view("inc/app_footer.php"); ?>

<script type="text/javascript">
    $(document).ready(function() {
        // Initialise the table
        $("#columns").tableDnD();
    });
</script>