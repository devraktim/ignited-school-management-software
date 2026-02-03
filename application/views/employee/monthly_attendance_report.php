<?php $this->load->view("inc/app_header.php"); ?>
    <style>
        .absent-tooltip {
            cursor: pointer;
        }
        .table td {
            min-width: 38px;
        }
        .table-bordered {
            border: 1px solid black !important;
        }
        .table-bordered th {
            border: 1px solid black !important;
        }
        .table-bordered td {
            border: 1px solid black !important;
        }
        
        /* Tooltip background */
        .tooltip-inner {
            background-color: #000 !important;
            color: #fff;
            text-align: left !important;
            font-size: 14px;
            padding: 8px 10px;
            max-width: 250px;
        }
        
        /* Tooltip arrow color */
        .tooltip.bs-tooltip-top .tooltip-arrow::before,
        .tooltip.bs-tooltip-bottom .tooltip-arrow::before,
        .tooltip.bs-tooltip-start .tooltip-arrow::before,
        .tooltip.bs-tooltip-end .tooltip-arrow::before {
            border-top-color: #000 !important;
            border-bottom-color: #000 !important;
            border-left-color: #000 !important;
            border-right-color: #000 !important;
        }
    </style>

    <div class="row mb-5">
        <h1>Month Wise Employee Attendance Report</h1>
    </div>

    <form id="form" method="GET" action="<?php echo base_url() ?>personnel/attendance/month-wise-report">
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
                                            <select class="form-select" id="emp_type_id" name="emp_type_id" value="<?php echo set_value('employee_type_id'); ?>">
                                                <option value="">Any</option>
                                                <?php foreach ($employee_types as $type) { ?>
                                                    <option value="<?php echo $type["id"]; ?>" <?php if (isset($_GET['emp_type_id']) && ($_GET['emp_type_id'] == $type['id'])) { echo "selected"; } ?>><?php echo $type["name"]; ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        <td style="vertical-align: middle;">Job Status</td>
                                        <td>
                                            <select class="form-select" id="job_status_id" name="job_status_id" value="<?php echo set_value('employee_type_id'); ?>">
                                                <option value="">Any</option>
                                                <?php foreach ($job_statuses as $job_status) { ?>
                                                    <option value="<?php echo $job_status["id"]; ?>" <?php if (isset($_GET['job_status_id']) && ($_GET['job_status_id'] == $job_status['id'])) { echo "selected"; } ?>><?php echo $job_status["name"]; ?></option>
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
    
        <?php
        // Convert holidays array to date => name map
        $holidayMap = [];
        foreach ($holidays as $holiday) {
            $holidayMap[$holiday['holiday_date']] = $holiday['name'];
        }
        ?>
        
        <?php if (count($attendanceData) > 0) { ?>
        <div class="row mb-5">
            <div class="col-md-12">
                <div class="card card-flush h-xl-100">
                    <div class="card-body py-9">
        
        <?php
        function renderAttendanceSheet($attendanceData, $employeeRecords, $monthYear, $holidayMap) {
        
            $year  = (int) substr($monthYear, 0, 4);
            $month = (int) substr($monthYear, 5, 2);
        
            $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
            $monthName   = date("F", strtotime($monthYear));
        
            /* ---------- CALCULATE WORKING DAYS ---------- */
            $holidayCount = 0;
            for ($day = 1; $day <= $daysInMonth; $day++) {
                $date = sprintf('%04d-%02d-%02d', $year, $month, $day);
                if (isset($holidayMap[$date])) {
                    $holidayCount++;
                }
            }
            $workingDays = $daysInMonth - $holidayCount;
        ?>
        <h2 class="text-center my-4">
            Attendance Sheet for <?php echo $monthName; ?>
        </h2>
        
        <div class="table-responsive">
        <table class="table table-bordered">
        <thead class="table-light">
        <tr>
            <th class="px-3">Sl. No.</th>
            <th>Emp Code</th>
            <th>Name</th>
        
            <?php for ($day = 1; $day <= $daysInMonth; $day++) { ?>
                <th><?php echo $day; ?></th>
            <?php } ?>
        
            <th class="text-nowrap px-3">Total (<?php echo $workingDays; ?>)</th>
        </tr>
        </thead>
        
        <tbody>
        <?php
        $slNo = 1;
        foreach ($employeeRecords as $record) {
            $totalPresent = 0;
        ?>
        <tr>
            <td class="px-3"><?php echo $slNo++; ?></td>
            <td><?php echo htmlspecialchars($record['emp_code']); ?></td>
            <td class="text-nowrap">
                <?php echo htmlspecialchars($record['f_name'] . ' ' . $record['l_name']); ?>
            </td>
        
        <?php
        for ($day = 1; $day <= $daysInMonth; $day++) {
        
            $attendanceDate = sprintf('%04d-%02d-%02d', $year, $month, $day);
            $attendance = $attendanceData[$monthYear][$attendanceDate][$record['id']] ?? null;
        
            $cellContent = '';
        
            /* ---------- HOLIDAY CHECK FIRST ---------- */
            if (isset($holidayMap[$attendanceDate])) {
        
                $holidayName = $holidayMap[$attendanceDate];
                $tooltip = "Holiday: {$holidayName}";
        
                $cellContent = '
                    <span
                        class="fw-bold fs-5 text-danger"
                        data-bs-toggle="tooltip"
                        data-bs-html="true"
                        title="' . htmlspecialchars($tooltip, ENT_QUOTES, 'UTF-8') . '"
                    >H</span>';
        
            }
            /* ---------- ATTENDANCE CHECK ---------- */
            elseif ($attendance) {
        
                if ($attendance['attendance'] === 'P') {
                    $cellContent = '<span class="text-success fw-bold fs-5">✔</span>';
                    $totalPresent++;
                }
                elseif ($attendance['attendance'] === 'A') {
        
                    $reason  = $attendance['reason'] ?: 'Not specified';
                    $remarks = $attendance['remarks'] ?: 'Not specified';
        
                    $tooltip = "Reason: {$reason}<br>Remark: {$remarks}";
        
                    $cellContent = '
                        <span
                            class="text-danger fw-bold fs-5"
                            data-bs-toggle="tooltip"
                            data-bs-html="true"
                            title="' . htmlspecialchars($tooltip, ENT_QUOTES, 'UTF-8') . '"
                        >✖</span>';
                }
            }
        ?>
            <td class="text-center align-middle"><?php echo $cellContent; ?></td>
        <?php } ?>
        
            <td class="fw-bold px-3"><?php echo $totalPresent; ?></td>
        </tr>
        <?php } ?>
        </tbody>
        </table>
        </div>
        
        <?php } // function end ?>
        
        <?php
        foreach ($attendanceData as $monthYear => $data) {
            renderAttendanceSheet($attendanceData, $employeeRecords, $monthYear, $holidayMap);
        }
        ?>
    
                </div>
            </div>
        </div>
    </div>
    <?php } ?>

    
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })
        });
    </script>
<?php $this->load->view("inc/app_footer.php"); ?>