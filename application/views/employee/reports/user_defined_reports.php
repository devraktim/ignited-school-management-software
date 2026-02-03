<?php $this->load->view("inc/app_header.php"); ?>

    <div class="row mb-5">
        <h1>User Defined Report</h1>
    </div>

    <form id="form" method="GET" action="<?php echo base_url() ?>personnel/report/user-defined-report/get-employees">
        <div class="row mb-5">
            <div class="col-md-12">
                <div class="card card-flush h-xl-100">
                    <div class="card-body py-9">
                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <!-- Department -->
                                        <td style="vertical-align: middle;">Department</td>
                                        <td>
                                            <select class="form-select" id="department" name="department_id">
                                                <option value="">Any</option>
                                                <?php foreach ($departments as $department) { ?>
                                                    <option value="<?php echo $department["id"] ?>" <?php if(isset($_GET['department_id']) && ($_GET['department_id'] == $department['id'])) {echo "selected";} ?>><?php echo $department["name"] ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        
                                        <!-- Designation -->
                                        <td style="vertical-align: middle;">Designation</td>
                                        <td>
                                            <select class="form-select" id="designation" name="designation_id">
                                                <option value="">Any</option>
                                                <?php foreach ($designations as $designation) { ?>
                                                    <option value="<?php echo $designation["id"] ?>" <?php if(isset($_GET['designation_id']) && ($_GET['designation_id'] == $designation['id'])) {echo "selected";} ?>><?php echo $designation["name"] ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        
                                        <!-- Employee Type -->
                                        <td style="vertical-align: middle;">Employee Type</td>
                                        <td>
                                            <select class="form-select" id="employee_type" name="emp_type_id">
                                                <option value="">Any</option>
                                                <?php foreach ($employee_types as $employee_type) { ?>
                                                    <option value="<?php echo $employee_type["id"] ?>" <?php if(isset($_GET['emp_type_id']) && ($_GET['emp_type_id'] == $employee_type['id'])) {echo "selected";} ?>><?php echo $employee_type["name"] ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        
                                        <!-- Job Status -->
                                        <td style="vertical-align: middle;">Job Status</td>
                                        <td>
                                            <select class="form-select" id="job_status" name="job_status_id">
                                                <option value="">Any</option>
                                                <?php foreach ($job_statuses as $job_status) { ?>
                                                    <option value="<?php echo $job_status["id"] ?>" <?php if(isset($_GET['job_status_id']) && ($_GET['job_status_id'] == $job_status['id'])) {echo "selected";} ?>><?php echo $job_status["name"] ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        
                                        <td colspan=2>
                                            <button type="submit" class="btn btn-success">Search</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    
        <?php if(isset($employees) && count($employees) == 0) { ?>
        <div class="card card-flush h-xl-100 mt-5">
            <div class="card-body py-9">
                <h4 class="text-center">No Employees Found</h4>
            </div>
        </div>
    <?php } ?>

    <?php if(isset($employees) && count($employees) > 0) { ?>

    <form action="<?php echo base_url() ?>personnel/report/user-defined-report" method="POST" enctype="multipart/form-data">
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
                                        <th>EMP Code</th>
                                        <th>Name</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $sl_no = 0; foreach($employees as $employe) { $sl_no++; ?>
                                        <tr>
                                            <td class="table-primary text-dark p-2">
                                                <input type="checkbox" name="emp_ids[]" value="<?php echo $employe['id'] ?>" class="form-check-input" checked />
                                            </td>
                                            <td><?php echo $employe['emp_code'] ?></td>
                                            <td>
                                                <?php echo $employe['f_name'] . " " . $employe['m_name'] . " " . $employe['l_name'] ?>
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
                            <input type="text" class="form-control" name="heading" />
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
                                        <td class="table-primary text-dark p-2"><input type="checkbox" name="fields[]" value="emp_code" class="form-check-input" /></td>
                                        <td>Employee Code</td>
                                    </tr>
                                    <tr class="border border-1 border-dark">
                                        <td class="table-primary text-dark p-2"><input type="checkbox" name="fields[]" value="sex" class="form-check-input" /></td>
                                        <td>Gender</td>
                                    </tr>
                                    <tr class="border border-1 border-dark">
                                        <td class="table-primary text-dark p-2"><input type="checkbox" name="fields[]" value="dob" class="form-check-input" /></td>
                                        <td>Date of Birth</td>
                                    </tr>
                                    <tr class="border border-1 border-dark">
                                        <td class="table-primary text-dark p-2"><input type="checkbox" name="fields[]" value="since" class="form-check-input" /></td>
                                        <td>Date of Joining</td>
                                    </tr>
                                    <tr class="border border-1 border-dark">
                                        <td class="table-primary text-dark p-2"><input type="checkbox" name="fields[]" value="emp_type" class="form-check-input" /></td>
                                        <td>Employee Type</td>
                                    </tr>
                                    <tr class="border border-1 border-dark">
                                        <td class="table-primary text-dark p-2"><input type="checkbox" name="fields[]" value="department" class="form-check-input" /></td>
                                        <td>Department</td>
                                    </tr>
                                    <tr class="border border-1 border-dark">
                                        <td class="table-primary text-dark p-2"><input type="checkbox" name="fields[]" value="designation" class="form-check-input" /></td>
                                        <td>Designation</td>
                                    </tr>
                                    <tr class="border border-1 border-dark">
                                        <td class="table-primary text-dark p-2"><input type="checkbox" name="fields[]" value="job_status" class="form-check-input" /></td>
                                        <td>Job Status</td>
                                    </tr>
                                    <tr class="border border-1 border-dark">
                                        <td class="table-primary text-dark p-2"><input type="checkbox" name="fields[]" value="mobile_no" class="form-check-input" /></td>
                                        <td>Mobile Number</td>
                                    </tr>
                                    <tr class="border border-1 border-dark">
                                        <td class="table-primary text-dark p-2"><input type="checkbox" name="fields[]" value="email" class="form-check-input" /></td>
                                        <td>Email Address</td>
                                    </tr>
                                    <tr class="border border-1 border-dark">
                                        <td class="table-primary text-dark p-2"><input type="checkbox" name="fields[]" value="category" class="form-check-input" /></td>
                                        <td>Category</td>
                                    </tr>
                                    <tr class="border border-1 border-dark">
                                        <td class="table-primary text-dark p-2"><input type="checkbox" name="fields[]" value="father" class="form-check-input" /></td>
                                        <td>Father's Name</td>
                                    </tr>
                                    <tr class="border border-1 border-dark">
                                        <td class="table-primary text-dark p-2"><input type="checkbox" name="fields[]" value="mother" class="form-check-input" /></td>
                                        <td>Mother's Name</td>
                                    </tr>
                                    <tr class="border border-1 border-dark">
                                        <td class="table-primary text-dark p-2"><input type="checkbox" name="fields[]" value="spouse" class="form-check-input" /></td>
                                        <td>Spouse's Name</td>
                                    </tr>
                                    <tr class="border border-1 border-dark">
                                        <td class="table-primary text-dark p-2"><input type="checkbox" name="fields[]" value="religion" class="form-check-input" /></td>
                                        <td>Religion</td>
                                    </tr>
                                    <tr class="border border-1 border-dark">
                                        <td class="table-primary text-dark p-2"><input type="checkbox" name="fields[]" value="nationality" class="form-check-input" /></td>
                                        <td>Nationality</td>
                                    </tr>
                                    <tr class="border border-1 border-dark">
                                        <td class="table-primary text-dark p-2"><input type="checkbox" name="fields[]" value="pan_no" class="form-check-input" /></td>
                                        <td>PAN Number</td>
                                    </tr>
                                    <tr class="border border-1 border-dark">
                                        <td class="table-primary text-dark p-2"><input type="checkbox" name="fields[]" value="voter_id" class="form-check-input" /></td>
                                        <td>Voter ID</td>
                                    </tr>
                                    <tr class="border border-1 border-dark">
                                        <td class="table-primary text-dark p-2"><input type="checkbox" name="fields[]" value="aadhar_no" class="form-check-input" /></td>
                                        <td>Aadhar Number</td>
                                    </tr>
                                    <tr class="border border-1 border-dark">
                                        <td class="table-primary text-dark p-2"><input type="checkbox" name="fields[]" value="miscellaneous" class="form-check-input" /></td>
                                        <td>Miscellaneous Information</td>
                                    </tr>
                                    <tr class="border border-1 border-dark">
                                        <td class="table-primary text-dark p-2"><input type="checkbox" name="fields[]" value="local_address" class="form-check-input" /></td>
                                        <td>Local Address</td>
                                    </tr>
                                    <tr class="border border-1 border-dark">
                                        <td class="table-primary text-dark p-2"><input type="checkbox" name="fields[]" value="local_phone" class="form-check-input" /></td>
                                        <td>Local Phone Number</td>
                                    </tr>
                                    <tr class="border border-1 border-dark">
                                        <td class="table-primary text-dark p-2"><input type="checkbox" name="fields[]" value="permanent_address" class="form-check-input" /></td>
                                        <td>Permanent Address</td>
                                    </tr>
                                    <tr class="border border-1 border-dark">
                                        <td class="table-primary text-dark p-2"><input type="checkbox" name="fields[]" value="permanent_phone" class="form-check-input" /></td>
                                        <td>Permanent Phone Number</td>
                                    </tr>
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
                $('input[name="emp_ids[]"]').each(function() {
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