<?php $this->load->view("inc/app_header.php"); ?>

    <style>
        .hidden {
            display: none;
        }
    </style>

    <div class="row mb-5">
        <h1>Retire & Resign</h1>
    </div>

    <form id="form" method="GET" action="<?php echo base_url() ?>personnel/resign-retire">
        <div class="row mb-5">
            <div class="col-md-12">
                <div class="card card-flush h-xl-100">
                    <div class="card-body py-9">
                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td style="vertical-align: middle;">EMP Code</td>
                                        <td>
                                            <input type="text" class="form-control" name="emp_code" />
                                        </td>
                                        
                                        <td style="vertical-align: middle;">Name</td>
                                        <td>
                                            <input type="text" class="form-control" name="f_name" />
                                        </td>
                                        
                                        <td style="vertical-align: middle;">Department</td>
                                        <td>
                                            <select class="form-select" id="department_id" name="department_id" value="<?php echo set_value('department_id'); ?>">
                                                <option value="">Any</option>
                                                <?php foreach ($departments as $department) { ?>
                                                    <option value="<?php echo $department["id"]; ?>" <?php if (isset($_GET['department_id']) && ($_GET['department_id'] == $department['id'])) { echo "selected"; } ?>><?php echo $department["name"]; ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        <td style="vertical-align: middle;">Designation</td>
                                        <td>
                                            <select class="form-select" id="designation_id" name="designation_id" value="<?php echo set_value('designation_id'); ?>">
                                                <option value="">Any</option>
                                                <?php foreach ($designations as $designation) { ?>
                                                    <option value="<?php echo $designation["id"]; ?>" <?php if (isset($_GET['designation_id']) && ($_GET['designation_id'] == $designation['id'])) { echo "selected"; } ?>><?php echo $designation["name"]; ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        <td style="vertical-align: middle;">Employee Type</td>
                                        <td>
                                            <select class="form-select" id="emp_type_id" name="emp_type_id" value="<?php echo set_value('employee_type_id'); ?>">
                                                <option value="">Any</option>
                                                <?php foreach ($employee_types as $type) { ?>
                                                    <option value="<?php echo $type["id"]; ?>" <?php if (isset($_GET['employee_type_id']) && ($_GET['employee_type_id'] == $type['id'])) { echo "selected"; } ?>><?php echo $type["name"]; ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                    
                                        <td colspan="2">
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
    
    <?php if(count($records) > 0) { ?>
    <div class="row mb-5">
        <div class="col-md-8">
            <div class="card card-flush h-xl-100">
                <div class="card-body py-9">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr class="text-center table-dark text-light">
                                    <th>SL</th>
                                    <th>EMP COde</th>
                                    <th>Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 0; foreach($records as $record) { $i++; ?>
                                    <tr class="text-center">
                                        <td class="table-primary text-dark p-2"><?php echo $i; ?></td>
                                        <td><?php echo $record['emp_code'] ?></td>
                                        <td><?php echo $record['f_name'] . ' ' . $record['m_name'] . ' ' . $record['l_name']; ?></td>
                                        <td>
                                            <div class="btn-group">
                                                <button 
                                                    class="btn btn-primary mx-1 retire-btn"
                                                    data-id="<?php echo $record['id']; ?>"
                                                    data-emp-code="<?php echo $record['emp_code']; ?>"
                                                    data-name="<?php echo htmlspecialchars($record['f_name'] . ' ' . $record['m_name'] . ' ' . $record['l_name']); ?>"
                                                    data-department="<?php echo htmlspecialchars($departments[$record['department_id'] - 1]['name']); ?>"
                                                    data-designation="<?php echo htmlspecialchars($designations[$record['designation_id'] - 1]['name']); ?>"
                                                    data-emp-type="<?php echo htmlspecialchars($employee_types[$record['emp_type_id'] - 1]['name']); ?>"
                                                    data-job-status="<?php echo htmlspecialchars($job_statuses[$record['job_status_id'] - 1]['name']); ?>"
                                                    data-date-joining="<?php echo $record['since']; ?>"
                                                    data-date-retirement=""
                                                    data-date-resignation=""
                                                    data-reason-resignation="">Retire</button>

                                                <button 
                                                    class="btn btn-primary mx-1 resign-btn"
                                                    data-id="<?php echo $record['id']; ?>"
                                                    data-emp-code="<?php echo $record['emp_code']; ?>"
                                                    data-name="<?php echo htmlspecialchars($record['f_name'] . ' ' . $record['m_name'] . ' ' . $record['l_name']); ?>"
                                                    data-department="<?php echo htmlspecialchars($departments[$record['department_id'] - 1]['name']); ?>"
                                                    data-designation="<?php echo htmlspecialchars($designations[$record['designation_id'] - 1]['name']); ?>"
                                                    data-emp-type="<?php echo htmlspecialchars($employee_types[$record['emp_type_id'] - 1]['name']); ?>"
                                                    data-job-status="<?php echo htmlspecialchars($job_statuses[$record['job_status_id'] - 1]['name']); ?>"
                                                    data-date-joining="<?php echo $record['since']; ?>"
                                                    data-date-retirement=""
                                                    data-date-resignation=""
                                                    data-reason-resignation="">Resign</button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    
        <div class="col-4">
            <div class="card card-flush h-xl-100">
                <div class="card-body py-9">
                    <form action="<?php echo base_url() ?>personnel/resign-retire" method="POST">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Enter name">
                        </div>
                
                        <div class="mb-3">
                            <label for="department" class="form-label">Department</label>
                            <input type="text" class="form-control" name="department" id="department" placeholder="Enter department">
                        </div>
                
                        <div class="mb-3">
                            <label for="designation" class="form-label">Designation</label>
                            <input type="text" class="form-control" name="designation" id="designation" placeholder="Enter designation">
                        </div>
                
                        <div class="mb-3">
                            <label for="employee-type" class="form-label">Employee Type</label>
                            <input type="text" class="form-control" name="employee-type" id="employee-type" placeholder="Enter employee type">
                        </div>
                
                        <div class="mb-3">
                            <label for="job-status" class="form-label">Job Status</label>
                            <input type="text" class="form-control" name="job-status" id="job-status" placeholder="Enter job status">
                        </div>
                
                        <div class="mb-3 hidden" id="date-retirement-group">
                            <label for="date-retirement" class="form-label">Date of Retirement</label>
                            <input type="date" class="form-control" name="date-retirement" id="date-retirement">
                        </div>
                
                        <div class="mb-3 hidden" id="date-resignation-group">
                            <label for="date-resignation" class="form-label">Date of Resignation</label>
                            <input type="date" class="form-control" name="date-resignation" id="date-resignation">
                        </div>
                
                        <div class="mb-3 hidden" id="reason-resignation-group">
                            <label for="reason-resignation" class="form-label">Reason for Resignation</label>
                            <textarea class="form-control" name="reason-resignation" id="reason-resignation" rows="3"></textarea>
                        </div>
                
                        <input type="text" class="d-none" name="employee_id" id="emp_id" />
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
    
    <script>
        $(document).ready(function() {
            $('.retire-btn, .resign-btn').click(function() {
                // Get data attributes from the button
                
                var id = $(this).data('id');
                var empCode = $(this).data('emp-code');
                var name = $(this).data('name');
                var department = $(this).data('department');
                var designation = $(this).data('designation');
                var empType = $(this).data('emp-type');
                var jobStatus = $(this).data('job-status');
                var dateJoining = $(this).data('date-joining');
    
                // Populate the input fields
                $('#emp_id').val(id);
                $('#emp-code').val(empCode).prop('disabled', true);
                $('#name').val(name).prop('disabled', true);
                $('#department').val(department).prop('disabled', true);
                $('#designation').val(designation).prop('disabled', true);
                $('#employee-type').val(empType).prop('disabled', true);
                $('#job-status').val(jobStatus).prop('disabled', true);
                $('#date-joining').val(dateJoining).prop('disabled', true);
    
                // Reset and toggle visibility based on the button clicked
                if ($(this).hasClass('retire-btn')) {
                    $('#date-retirement-group').removeClass('hidden').find('input').prop('disabled', false);
                    $('#date-resignation-group').addClass('hidden').find('input').prop('disabled', true);
                    $('#reason-resignation-group').addClass('hidden').find('textarea').val('').prop('disabled', true);
                } else if ($(this).hasClass('resign-btn')) {
                    $('#date-retirement-group').addClass('hidden').find('input').val('').prop('disabled', true);
                    $('#date-resignation-group').removeClass('hidden').find('input').prop('disabled', false);
                    $('#reason-resignation-group').removeClass('hidden').find('textarea').prop('disabled', false);
                }
            });
        });
    </script>
<?php $this->load->view("inc/app_footer.php"); ?>