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
                                            <button type="submit" class="btn btn-success">Search</button>
                                        </td>
                                        <!--<td style="vertical-align: middle;">Job Status</td>-->
                                        <!--<td>-->
                                        <!--    <select class="form-select" id="emp_type_id" name="emp_type_id" value="<?php echo set_value('emp_type_id'); ?>">-->
                                        <!--        <option value="">Any</option>-->
                                        <!--        <?php foreach ($employee_types as $type) { ?>-->
                                        <!--            <option value="<?php echo $type["id"]; ?>" <?php if (isset($_GET['emp_type_id']) && ($_GET['emp_type_id'] == $type['id'])) { echo "selected"; } ?>><?php echo $type["name"]; ?></option>-->
                                        <!--        <?php } ?>-->
                                        <!--    </select>-->
                                        <!--</td>-->
                                    </tr>
                                    <tr>
                                        <td class="d-none" style="vertical-align: middle;">Year</td>
                                        <td class="d-none">
                                            <?php
                                                $currentSessionId = $this->session->academy_session['current_session']['id'];
                                                $selectedYear = ($currentSessionId == 1) ? '2023' : '2024';
                                            ?>
                                            <select class="form-control" name="year" required>
                                                <option value="2023" <?php echo ($selectedYear == '2023') ? 'selected' : ''; ?>>2023</option>
                                                <option value="2024" <?php echo ($selectedYear == '2024') ? 'selected' : ''; ?>>2024</option>
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
    </form>
    
    <div class="row mb-5">
        <div class="col-md-12">
            <div class="card card-flush h-xl-100">
                <div class="card-body py-9">
                    <?php if (empty($employeeRecords)): ?>
    
                    <?php else: ?>
                        <?php
                            // Directly get the year from the GET request
                            $year = $this->session->academy_session['current_session']['id'] == 1 ? 2023 : 2024;;
                            
                            // Ensure that the year is a valid number and within a reasonable range
                            if (is_numeric($year) && $year >= 2000 && $year <= 2100) {
                                // Get the two-digit representation of the year
                                $y = substr($year, -2); // This will give you '27' for '2027'
                            } else {
                                // Handle invalid year input
                                $y = date('y'); // Fallback to the current year
                            }
                        ?>
                        
                        <div class="table-responsive table-bordered table-striped table-hover">
                            <table class="table">
                                <thead>
                                    <tr class="text-center table-dark text-light">
                                        <th>Sl. No.</th>
                                        <th>Emp Code</th>
                                        <th>Name</th>
                                        <th>Designation</th>
                                        <th>Jan '<?php echo $y; ?></th>
                                        <th>Feb '<?php echo $y; ?></th>
                                        <th>Mar '<?php echo $y; ?></th>
                                        <th>Apr '<?php echo $y; ?></th>
                                        <th>May '<?php echo $y; ?></th>
                                        <th>Jun '<?php echo $y; ?></th>
                                        <th>Jul '<?php echo $y; ?></th>
                                        <th>Aug '<?php echo $y; ?></th>
                                        <th>Sep '<?php echo $y; ?></th>
                                        <th>Oct '<?php echo $y; ?></th>
                                        <th>Nov '<?php echo $y; ?></th>
                                        <th>Dec '<?php echo $y; ?></th>
                                        <th>Total Working Days</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $slNo = 1; // Serial number
                                    foreach ($employeeRecords as $employee): 
                                        // Assuming you have a way to get the designation by ID
                                        $designation = $employee['designation_id']; // Placeholder for actual designation lookup
                                        $totalAttendance = 0; // Initialize total attendance
                                        $totalWorkingDays = 0; // Placeholder for actual total working days
                
                                        // Array to hold monthly attendance counts
                                        $monthlyAttendance = [];
                                        for ($month = 1; $month <= 12; $month++) {
                                            $monthKey = sprintf("%s-%02d", $_GET['year'], $month);
                                            $attendanceCount = isset($attendanceData[$monthKey]['employeeAttendance'][$employee['id']]) 
                                                ? count($attendanceData[$monthKey]['employeeAttendance'][$employee['id']]) 
                                                : 0;
                                            
                                            $monthlyAttendance[] = $attendanceCount;
                                            $totalAttendance += $attendanceCount; // Add to total attendance
                                        }
                                    ?>
                                        <tr class="text-center">
                                            <td class="table-primary text-dark p-2"><?php echo $slNo++; ?></td>
                                            <td><?php echo $employee['emp_code']; ?></td>
                                            <td><?php echo trim($employee['f_name'] . ' ' . $employee['m_name'] . ' ' . $employee['l_name']); ?></td>
                                            <td><?php echo $designations[$designation]['name']; // Replace with actual designation if needed ?></td>
                                            <?php foreach ($monthlyAttendance as $attendance): ?>
                                                <td><?php echo $attendance; ?></td>
                                            <?php endforeach; ?>
                                            <td><?php echo $totalAttendance; ?></td>
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