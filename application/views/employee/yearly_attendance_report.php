<?php $this->load->view("inc/app_header.php"); ?>

    <div class="row mb-5">
        <h1>Session Wise Attendance</h1>
    </div>
    <form id="form" method="GET" action="<?php echo base_url() ?>personnel/attendance/session-wise-report">
        <div class="row mb-5">
            <div class="col-md-12">
                <div class="card card-flush h-xl-100">
                    <div class="card-body py-9">
                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
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
                                            <select class="form-select" id="emp_type_id" name="emp_type_id">
                                                <option value="">Any</option>
                                                <?php foreach ($employee_types as $type) { ?>
                                                    <option value="<?php echo $type["id"]; ?>" <?php echo (isset($_GET['emp_type_id']) && $_GET['emp_type_id'] == $type['id']) ? 'selected' : (set_value('emp_type_id') == $type['id'] ? 'selected' : ''); ?>>
                                                        <?php echo $type["name"]; ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </td>

                                        
                                        <td colspan="2">
                                            <button type="submit" class="btn btn-success">Generate Report</button>
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
        <div class="col-md-12">
            <div class="card card-flush h-xl-100">
                <div class="card-body py-9">
    
                <?php if (empty($employeeRecords)): ?>
                    <p class="text-center text-muted">No records found</p>
                <?php else: ?>
    
                <?php
                    $year = $_GET['year'] ?? date('Y');
                    $y = substr($year, -2);
    
                    $monthNames = [
                        1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr',
                        5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Aug',
                        9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec'
                    ];
                ?>
    
                <div class="table-responsive table-bordered">
                    <table class="table">
                        <thead>
                            <!-- ROW 1 : MONTH NAMES -->
                            <tr class="text-center table-dark text-light">
                                <th rowspan="2" class="p-2" style="vertical-align: middle;">Sl. No.</th>
                                <th rowspan="2" style="vertical-align: middle;">Emp Code</th>
                                <th rowspan="2" style="vertical-align: middle;">Name</th>
                                <th rowspan="2" style="vertical-align: middle;">Designation</th>
                        
                                <?php for ($m = 1; $m <= 12; $m++): ?>
                                    <th class="bg-primary"><?php echo $monthNames[$m]; ?></th>
                                <?php endfor; ?>
                        
                                <th class="bg-primary">Total</th>
                            </tr>
                        
                            <!-- ROW 2 : WORKING DAYS -->
                            <tr class="text-center">
                                <?php for ($m = 1; $m <= 12; $m++): 
                                    $monthKey = sprintf('%s-%02d', $year, $m);
                                    $workingDays = $monthlyWorkingDays[$monthKey] ?? 0;
                                ?>
                                    <th style="background-color: #FFC107; color: black;"><?php echo $workingDays; ?>D</th>
                                <?php endfor; ?>
                        
                                <th style="background-color: #FFC107; color: black;"><?php echo $yearlyWorkingDays; ?>D</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                        <?php 
                        $slNo = 1;
    
                        foreach ($employeeRecords as $employee):
    
                            $empId = $employee['id'];
                            $designationId = $employee['designation_id'];
    
                            $yearlyTotal = $attendanceData[$empId]['yearly_total'] ?? 0;
                        ?>
                            <tr class="text-center">
                                <td class="table-primary text-dark"><?php echo $slNo++; ?></td>
                                <td><?php echo $employee['emp_code']; ?></td>
                                <td><?php echo trim($employee['f_name'].' '.$employee['m_name'].' '.$employee['l_name']); ?></td>
                                <td><?php echo $designations[$designationId - 1]['name'] ?? ''; ?></td>
    
                                <?php for ($m = 1; $m <= 12; $m++): 
                                    $monthKey = sprintf('%s-%02d', $year, $m);
                                    $present = $attendanceData[$empId]['monthly'][$monthKey] ?? 0;
                                ?>
                                    <td><?php echo $present; ?></td>
                                <?php endfor; ?>
    
                                <td class="fw-bold"><?php echo $yearlyTotal; ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
    
                <?php endif; ?>
    
                </div>
            </div>
        </div>
    </div>

<?php $this->load->view("inc/app_footer.php"); ?>