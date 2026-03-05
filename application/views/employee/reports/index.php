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

                                    <tr>
                                        <td style="vertical-align: middle;">From Month</td>
                                        <td>
                                            <select class="form-control" name="from_month" required>
                                                <option value="">Select</option>
                                                <?php 
                                                $selectedFromMonth = isset($_GET['from_month']) ? (int)$_GET['from_month'] : null;
                                                for ($i = 1; $i <= 12; $i++) {
                                                    $monthName = date('F', mktime(0, 0, 0, $i, 1)); // Get month name
                                                    $selected = ($i === $selectedFromMonth) ? 'selected' : '';
                                                    echo "<option value=\"$i\" $selected>$monthName</option>";
                                                }
                                                ?>
                                            </select>
                                        </td>

                                        <td style="vertical-align: middle;">To Month</td>
                                        <td>
                                            <select class="form-control" name="to_month" required>
                                                <option value="">Select</option>
                                                <?php 
                                                $selectedToMonth = isset($_GET['to_month']) ? (int)$_GET['to_month'] : null;
                                                for ($i = 1; $i <= 12; $i++) {
                                                    $monthName = date('F', mktime(0, 0, 0, $i, 1)); // Get month name
                                                    $selected = ($i === $selectedToMonth) ? 'selected' : '';
                                                    echo "<option value=\"$i\" $selected>$monthName</option>";
                                                }
                                                ?>
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

                        <button type="button" target="_blank" href="<?php echo base_url() ?>personnel/report/retired-employee-list" class="btn btn-primary mb-3 w-100" onclick="report('retired-employee-list')">All Retired Employee List</button>
                        <button type="button" target="_blank" href="<?php echo base_url() ?>personnel/report/resigned-employee-list" class="btn btn-primary mb-3 w-100" onclick="report('resigned-employee-list')">All Resigned Employee List</button>

                        <button type="button" target="_blank" href="<?php echo base_url() ?>personnel/report/monthly-attendance-report" class="btn btn-primary mb-3 w-100" onclick="report('monthly-attendance-report')">Monthly Wise Attendance</button>
                        <button type="button" target="_blank" href="<?php echo base_url() ?>personnel/report/session-attendance-report" class="btn btn-primary mb-3 w-100" onclick="report('session-attendance-report')">Session Wise Attendance Report</button>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4 d-none">
                <div class="card card-flush h-xl-100">
                    <div class="card-body py-9">
                        <h4 class="text-center text-dark bg-secondary py-3 mb-3">
                            Other Eeports
                        </h4>

                        <select class="form-select mb-4" id="retired_employee_select">
                            <option value="">Select Retired Employee...</option>

                            <?php foreach ($retired_employees as $r) { ?>
                                <option value="<?= htmlspecialchars(json_encode([
                                    "name" => $r['f_name'].' '.$r['m_name'].' '.$r['l_name'],
                                    "department" => $departments[$r['department_id']-1]['name'],
                                    "designation" => $designations[$r['designation_id']-1]['name'],
                                    "empType" => $employee_types[$r['emp_type_id']-1]['name'],
                                    "jobStatus" => $job_statuses[$r['job_status_id']-1]['name'],
                                    "since" => date('d-m-Y', strtotime($r['since'])),
                                    "address" => $r['permanenet_address'],
                                    "phone" => $r['mobile_no'],
                                    "date" => date('d-m-Y', strtotime($r['retired_date']))
                                ])) ?>">
                                    <?= $r['emp_code'] ?> - <?= $r['f_name'].' '.$r['l_name'] ?>
                                </option>
                            <?php } ?>
                        </select>

                        <button class="btn btn-primary w-100 mb-3" onclick="printRetiredEmployee()">
                            Print Retired Employee Details
                        </button>

                        <select class="form-select mb-4" id="resigned_employee_select">
                            <option value="">Select Resigned Employee...</option>

                            <?php foreach ($resigned_employees as $r) { ?>
                                <option value="<?= htmlspecialchars(json_encode([
                                    "name" => $r['f_name'].' '.$r['m_name'].' '.$r['l_name'],
                                    "department" => $departments[$r['department_id']-1]['name'],
                                    "designation" => $designations[$r['designation_id']-1]['name'],
                                    "empType" => $employee_types[$r['emp_type_id']-1]['name'],
                                    "jobStatus" => $job_statuses[$r['job_status_id']-1]['name'],
                                    "since" => date('d-m-Y', strtotime($r['since'])),
                                    "address" => $r['permanenet_address'],
                                    "phone" => $r['mobile_no'],
                                    "date" => date('d-m-Y', strtotime($r['resigned_date'])),
                                    "reason" => $r['resigned_reason']
                                ])) ?>">
                                    <?= $r['emp_code'] ?> - <?= $r['f_name'].' '.$r['l_name'] ?>
                                </option>
                            <?php } ?>
                        </select>

                        <button class="btn btn-primary w-100 mb-3" onclick="printResignedEmployee()">
                            Print Resigned Employee Details
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <div class="modal fade" id="employeeModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Employee Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label>Name</label>
                            <input type="text" id="e_name" class="form-control" readonly>
                        </div>

                        <div class="col-md-6">
                            <label>Department</label>
                            <input type="text" id="e_department" class="form-control" readonly>
                        </div>

                        <div class="col-md-6">
                            <label>Designation</label>
                            <input type="text" id="e_designation" class="form-control" readonly>
                        </div>

                        <div class="col-md-6">
                            <label>Employee Type</label>
                            <input type="text" id="e_empType" class="form-control" readonly>
                        </div>

                        <div class="col-md-6">
                            <label>Job Status</label>
                            <input type="text" id="e_jobStatus" class="form-control" readonly>
                        </div>

                        <div class="col-md-6">
                            <label>Date of Joining</label>
                            <input type="text" id="e_since" class="form-control" readonly>
                        </div>

                        <div class="col-12">
                            <label>Address</label>
                            <input type="text" id="e_address" class="form-control" readonly>
                        </div>

                        <div class="col-md-6">
                            <label>Phone</label>
                            <input type="text" id="e_phone" class="form-control" readonly>
                        </div>

                        <div class="col-md-6">
                            <label id="e_date_label"></label>
                            <input type="text" id="e_date" class="form-control" readonly>
                        </div>

                        <div class="col-12 d-none" id="e_reason_group">
                            <label>Reason</label>
                            <textarea id="e_reason" class="form-control" rows="2" readonly></textarea>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

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
            else if(name == "retired-employee-list") {
                $("#form").attr("method", "GET");
                $("#form").attr("action", `<?php echo base_url() ?>personnel/report/${name}`);
            }
            else if(name == "resigned-employee-list") {
                $("#form").attr("method", "GET");
                $("#form").attr("action", `<?php echo base_url() ?>personnel/report/${name}`);
            }
            else if(name == "session-attendance-report") {
                $("#form").attr("method", "GET");
                $("#form").attr("action", `<?php echo base_url() ?>personnel/report/${name}`);
            }
            else if (name == "monthly-attendance-report") {

                let fromMonth = $("select[name='from_month']").val();
                let toMonth   = $("select[name='to_month']").val();

                // Validation
                if (!fromMonth) {
                    alert("Please select From Month");
                    $("select[name='from_month']").focus();
                    return false;
                }

                if (!toMonth) {
                    alert("Please select To Month");
                    $("select[name='to_month']").focus();
                    return false;
                }

                // Optional: Check logical error (From > To)
                if (parseInt(fromMonth) > parseInt(toMonth)) {
                    alert("From Month cannot be greater than To Month");
                    return false;
                }

                // If everything OK
                $("#form").attr("method", "GET");
                $("#form").attr("action", `<?php echo base_url() ?>personnel/report/${name}`);
                $("#form").submit();
            }
            $("#form").submit()
        }
    </script>

<script>

function printRetiredEmployee() {

    let selected = document.getElementById("retired_employee_select").value;
    if (!selected) {
        alert("Please select a retired employee");
        return;
    }

    let d = JSON.parse(selected);

    generatePrintHTML(d, 'retire');
}


function printResignedEmployee() {

    let selected = document.getElementById("resigned_employee_select").value;
    if (!selected) {
        alert("Please select a resigned employee");
        return;
    }

    let d = JSON.parse(selected);

    generatePrintHTML(d, 'resign');
}


function generatePrintHTML(d, type) {

    let headerImage = "<?php echo base_url()?>/assets/media/logos/result_header.png";

    let html = `
    <html>
    <head>
        <title>Employee Details</title>

        <style>

            @page {
                size: A4;
                margin: 15mm;
            }

            body {
                font-family: "Segoe UI", Arial, sans-serif;
                margin: 0;
                padding: 0;
                color: #000;
            }

            .print-container {
                width: 100%;
            }

            .print-header {
                text-align: center;
                margin-bottom: 20px;
            }

            .print-header img {
                width: 100%;
                max-height: 120px;
                object-fit: contain;
            }

            .report-title {
                text-align: center;
                font-size: 20px;
                font-weight: 600;
                margin: 15px 0 25px 0;
                text-transform: uppercase;
                letter-spacing: 1px;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                font-size: 14px;
            }

            td {
                padding: 10px 12px;
                border: 1px solid #222;
            }

            td:first-child {
                width: 35%;
                font-weight: 600;
                background-color: #f2f2f2;
            }

            .footer-space {
                margin-top: 60px;
            }

            .signature {
                width: 200px;
                text-align: center;
                border-top: 1px solid #000;
                padding-top: 5px;
                float: right;
                margin-top: 60px;
                font-size: 13px;
            }

        </style>

    </head>

    <body>

        <div class="print-container">

            <div class="print-header">
                <img src="${headerImage}" alt="Header Logo">
            </div>

            <div class="report-title">
                ${type === 'retire' ? 'Retired Employee Report' : 'Resigned Employee Report'}
            </div>

            <table>
                <tr><td>Name</td><td>${d.name}</td></tr>
                <tr><td>Department</td><td>${d.department}</td></tr>
                <tr><td>Designation</td><td>${d.designation}</td></tr>
                <tr><td>Employee Type</td><td>${d.empType}</td></tr>
                <tr><td>Job Status</td><td>${d.jobStatus}</td></tr>
                <tr><td>Date of Joining</td><td>${d.since}</td></tr>
                <tr><td>Address</td><td>${d.address}</td></tr>
                <tr><td>Phone</td><td>${d.phone}</td></tr>
                <tr>
                    <td>${type === 'retire' ? 'Date of Retirement' : 'Date of Resignation'}</td>
                    <td>${d.date}</td>
                </tr>
                ${d.reason ? `<tr><td>Reason</td><td>${d.reason}</td></tr>` : ``}
            </table>

            <div class="signature">
                Authorized Signature
            </div>

        </div>

        <script>
            window.onload = function(){
                window.print();
                window.close();
            }
        <\/script>

    </body>
    </html>`;

    let w = window.open('', '', 'width=900,height=1000');
    w.document.write(html);
    w.document.close();
}

</script>

<?php $this->load->view("inc/app_footer.php"); ?>