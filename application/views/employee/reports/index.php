<?php $this->load->view("inc/app_header.php"); ?>

    <div class="row mb-5">
        <h1>Employee Report</h1>
    </div>

    <form id="form" method="GET" action="" target="_blank">
        <div class="row mb-5">
            <div class="col-md-12">
                <div class="card card-flush h-xl-100">
                    <div class="card-body py-9">
                        <h4 class="text-center text-dark bg-secondary py-3 mb-3">Report Criteria</h4>
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
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-md-4">
                <div class="card card-flush h-xl-100">
                    <div class="card-body py-9">
                        <h4 class="text-center text-dark bg-secondary py-3 mb-3">List Report</h4>
                        <button type="button" target="_blank" href="<?php echo base_url() ?>personnel/report/employee-list" class="btn btn-primary mb-3 w-100" onclick="report('employee-list')">Employee List</button>
                        
                        <?php if($this->session->user['permissions'][0]['personnel_module'] != "VIEWER" && 
                                 $this->session->user['permissions'][0]['personnel_module'] != "OPERATOR") { ?>
                        <button type="button" target="_blank" href="<?php echo base_url() ?>personnel/report/inactive-employee-list" class="btn btn-primary mb-3 w-100" onclick="report('inactive-employee-list')">Inactive Employee List</button>
                        <?php } ?>
                        
                        <button type="button" target="_blank" href="<?php echo base_url() ?>personnel/report/employee-personal-details" class="btn btn-primary mb-3 w-100" onclick="report('employee-personal-details')">Employee Personal Details</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <script>
        function report(name) {
            if(name == "employee-list") {
                $("#form").attr("method", "GET");
                $("#form").attr("action", `<?php echo base_url() ?>personnel/report/${name}`);
            }
            else if(name == "inactive-employee-list") {
                $("#form").attr("method", "GET");
                $("#form").attr("action", `<?php echo base_url() ?>personnel/report/${name}`);
            }
            else if(name == "employee-personal-details") {
                $("#form").attr("method", "GET");
                $("#form").attr("action", `<?php echo base_url() ?>personnel/report/${name}`);
            }
            $("#form").submit()
        }
    </script>


<?php $this->load->view("inc/app_footer.php"); ?>