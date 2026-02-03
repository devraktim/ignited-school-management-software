<?php $this->load->view("inc/app_header.php"); ?>

    <style>
        .hidden {
            display: none;
        }
    </style>

    <div class="row mb-5">
        <h1>Retire & Resign List</h1>
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
    
<div class="row mb-5">
    <div class="col-12">
        <div class="card card-flush h-xl-100">
            <div class="card-body py-9">

                <ul class="nav nav-pills nav-justified mb-3">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#tab1">Retired Employees</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#tab2">Resigned Employees</a>
                    </li>
                </ul>

                <div class="tab-content">
                    <!-- RETIRED -->
                    <div class="tab-pane fade show active" id="tab1">
                        <table class="table table-bordered table-hover mt-3">
                            <thead class="table-dark text-center">
                                <tr>
                                    <th>SL</th>
                                    <th>EMP Code</th>
                                    <th>Name</th>
                                    <th>Designation</th>
                                    <th>Retirement Date</th>
                                    <th width="220">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $i=0; foreach($retired_employees as $r){ $i++; ?>
                                <tr class="text-center">
                                    <td><?= $i ?></td>
                                    <td><?= $r['emp_code'] ?></td>
                                    <td><?= $r['f_name'].' '.$r['m_name'].' '.$r['l_name'] ?></td>
                                    <td><?= $designations[$r['designation_id']]['name'] ?></td>
                                    <td><?= date('d-m-Y',strtotime($r['retired_date'])) ?></td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-sm btn-primary action-btn"
                                                data-action="view"
                                                data-type="retire"
                                                data-name="<?= $r['f_name'].' '.$r['m_name'].' '.$r['l_name'] ?>"
                                                data-department="<?= $departments[$r['department_id']-1]['name'] ?>"
                                                data-designation="<?= $designations[$r['designation_id']-1]['name'] ?>"
                                                data-emp-type="<?= $employee_types[$r['emp_type_id']-1]['name'] ?>"
                                                data-job-status="<?= $job_statuses[$r['job_status_id']-1]['name'] ?>"
                                                data-since="<?= date('d-m-Y', strtotime($r['since'])) ?>"
                                                data-address="<?= $r['permanenet_address'] ?>"
                                                data-phone="<?= $r['mobile_no'] ?>"
                                                data-date="<?= date('d-m-Y', strtotime($r['retired_date'])) ?>">
                                                Check Details
                                            </button>
                                    
                                            <button type="button" class="btn btn-sm btn-secondary action-btn"
                                                data-action="print"
                                                data-type="retire"
                                                data-name="<?= $r['f_name'].' '.$r['m_name'].' '.$r['l_name'] ?>"
                                                data-department="<?= $departments[$r['department_id']-1]['name'] ?>"
                                                data-designation="<?= $designations[$r['designation_id']-1]['name'] ?>"
                                                data-emp-type="<?= $employee_types[$r['emp_type_id']-1]['name'] ?>"
                                                data-job-status="<?= $job_statuses[$r['job_status_id']-1]['name'] ?>"
                                                data-since="<?= date('d-m-Y', strtotime($r['since'])) ?>"
                                                data-address="<?= $r['permanenet_address'] ?>"
                                                data-phone="<?= $r['mobile_no'] ?>"
                                                data-date="<?= date('d-m-Y', strtotime($r['retired_date'])) ?>">
                                                Print Details
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- RESIGNED -->
                    <div class="tab-pane fade" id="tab2">
                        <table class="table table-bordered table-hover mt-3">
                            <thead class="table-dark text-center">
                                <tr>
                                    <th>SL</th>
                                    <th>EMP Code</th>
                                    <th>Name</th>
                                    <th>Designation</th>
                                    <th>Date</th>
                                    <th>Reason</th>
                                    <th width="220">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $i=0; foreach($resigned_employees as $r){ $i++; ?>
                                <tr class="text-center">
                                    <td><?= $i ?></td>
                                    <td><?= $r['emp_code'] ?></td>
                                    <td><?= $r['f_name'].' '.$r['m_name'].' '.$r['l_name'] ?></td>
                                    <td><?= $designations[$r['designation_id']]['name'] ?></td>
                                    <td><?= date('d-m-Y',strtotime($r['resigned_date'])) ?></td>
                                    <td><?= $r['resigned_reason'] ?></td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-sm btn-primary action-btn"
                                                data-action="view"
                                                data-type="resign"
                                                data-name="<?= $r['f_name'].' '.$r['m_name'].' '.$r['l_name'] ?>"
                                                data-department="<?= $departments[$r['department_id']-1]['name'] ?>"
                                                data-designation="<?= $designations[$r['designation_id']-1]['name'] ?>"
                                                data-emp-type="<?= $employee_types[$r['emp_type_id']-1]['name'] ?>"
                                                data-job-status="<?= $job_statuses[$r['job_status_id']-1]['name'] ?>"
                                                data-since="<?= date('d-m-Y', strtotime($r['since'])) ?>"
                                                data-address="<?= $r['permanenet_address'] ?>"
                                                data-phone="<?= $r['mobile_no'] ?>"
                                                data-date="<?= date('d-m-Y', strtotime($r['resigned_date'])) ?>"
                                                data-reason="<?= $r['resigned_reason'] ?>">
                                                Check Details
                                            </button>
                                    
                                            <button type="button" class="btn btn-sm btn-secondary action-btn"
                                                data-action="print"
                                                data-type="resign"
                                                data-name="<?= $r['f_name'].' '.$r['m_name'].' '.$r['l_name'] ?>"
                                                data-department="<?= $departments[$r['department_id']-1]['name'] ?>"
                                                data-designation="<?= $designations[$r['designation_id']-1]['name'] ?>"
                                                data-emp-type="<?= $employee_types[$r['emp_type_id']-1]['name'] ?>"
                                                data-job-status="<?= $job_statuses[$r['job_status_id']-1]['name'] ?>"
                                                data-since="<?= date('d-m-Y', strtotime($r['since'])) ?>"
                                                data-address="<?= $r['permanenet_address'] ?>"
                                                data-phone="<?= $r['mobile_no'] ?>"
                                                data-date="<?= date('d-m-Y', strtotime($r['resigned_date'])) ?>"
                                                data-reason="<?= $r['resigned_reason'] ?>">
                                                Print Details
                                            </button>
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
    </div>
</div>


<div class="modal fade" id="detailsModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Employee Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label>Name</label>
                        <input type="text" id="m_name" class="form-control" readonly>
                    </div>
                    <div class="col-md-6">
                        <label>Department</label>
                        <input type="text" id="m_department" class="form-control" readonly>
                    </div>
                    <div class="col-md-6">
                        <label>Designation</label>
                        <input type="text" id="m_designation" class="form-control" readonly>
                    </div>
                    <div class="col-md-6">
                        <label>Employee Type</label>
                        <input type="text" id="m_empType" class="form-control" readonly>
                    </div>
                    <div class="col-md-6">
                        <label>Job Status</label>
                        <input type="text" id="m_jobStatus" class="form-control" readonly>
                    </div>
                    <div class="col-md-6">
                        <label>Date of Joining</label>
                        <input type="text" id="m_since" class="form-control" readonly>
                    </div>
                    <div class="col-12">
                        <label>Address</label>
                        <input type="text" id="m_address" class="form-control" readonly>
                    </div>
                    <div class="col-md-6">
                        <label>Phone</label>
                        <input type="text" id="m_phone" class="form-control" readonly>
                    </div>

                    <div class="col-md-6" id="m_date_group">
                        <label id="m_date_label"></label>
                        <input type="text" id="m_date" class="form-control" readonly>
                    </div>

                    <div class="col-12 d-none" id="m_reason_group">
                        <label>Reason</label>
                        <textarea id="m_reason" class="form-control" rows="2" readonly></textarea>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>



    
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
                var since = $(this).data('since');
                var address = $(this).data('address');
                var phone = $(this).data('phone');
                var retiredDate = $(this).data('date-retirement');
                var resignationDate = $(this).data('date-resignation');
                var resignationReason = $(this).data('reason-resignation');
    
                // Populate the input fields
                $('#emp_id').val(id);
                $('#emp-code').val(empCode).prop('disabled', true);
                $('#name').val(name).prop('disabled', true);
                $('#department').val(department).prop('disabled', true);
                $('#designation').val(designation).prop('disabled', true);
                $('#employee-type').val(empType).prop('disabled', true);
                $('#job-status').val(jobStatus).prop('disabled', true);
                $('#date-joining').val(dateJoining).prop('disabled', true);
                
                $('#date-retirement').val(retiredDate).prop('disabled', true);
                $('#date-resignation').val(resignationDate).prop('disabled', true);
                $('#reason-resignation').val(resignationReason).prop('disabled', true);
                
                $('#since').val(since).prop('disabled', true);
                $('#address').val(address).prop('disabled', true);
                $('#phone').val(phone).prop('disabled', true);
    
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
    
<script>
$(document).on('click', '.action-btn', function () {

    let d = $(this).data();

    // Fill modal
    $('#m_name').val(d.name);
    $('#m_department').val(d.department);
    $('#m_designation').val(d.designation);
    $('#m_empType').val(d.empType);
    $('#m_jobStatus').val(d.jobStatus);
    $('#m_since').val(d.since);
    $('#m_address').val(d.address);
    $('#m_phone').val(d.phone);

    $('#m_reason_group').addClass('d-none');

    if (d.type === 'retire') {
        $('#m_date_label').text('Date of Retirement');
        $('#m_date').val(d.date);
    } else {
        $('#m_date_label').text('Date of Resignation');
        $('#m_date').val(d.date);
        $('#m_reason').val(d.reason);
        $('#m_reason_group').removeClass('d-none');
    }

    // VIEW → MODAL
    if (d.action === 'view') {
        new bootstrap.Modal(document.getElementById('detailsModal')).show();
    }

    // PRINT
    if (d.action === 'print') {

        let html = `
        <html>
        <head>
            <title>Employee Details</title>
            <style>
                body { font-family: Arial; padding: 40px; }
                h2 { text-align: center; margin-bottom: 30px; }
                table { width: 100%; border-collapse: collapse; }
                td { padding: 10px; border: 1px solid #000; font-size: 14px; }
                td:first-child { width: 35%; font-weight: bold; }
                @page { size: A4; margin: 20mm; }
            </style>
        </head>
        <body>
            <h2>Employee Details</h2>
            <table>
                <tr><td>Name</td><td>${d.name}</td></tr>
                <tr><td>Department</td><td>${d.department}</td></tr>
                <tr><td>Designation</td><td>${d.designation}</td></tr>
                <tr><td>Employee Type</td><td>${d.empType}</td></tr>
                <tr><td>Job Status</td><td>${d.jobStatus}</td></tr>
                <tr><td>Date of Joining</td><td>${d.since}</td></tr>
                <tr><td>Address</td><td>${d.address}</td></tr>
                <tr><td>Phone</td><td>${d.phone}</td></tr>
                <tr><td>${d.type === 'retire' ? 'Date of Retirement' : 'Date of Resignation'}</td><td>${d.date}</td></tr>
                ${d.reason ? `<tr><td>Reason</td><td>${d.reason}</td></tr>` : ``}
            </table>

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
});
</script>



<?php $this->load->view("inc/app_footer.php"); ?>