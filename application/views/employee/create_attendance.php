<?php $this->load->view("inc/app_header.php"); ?>

<div class="row mb-5">
    <h1>Employee Attendance</h1>
</div>

<form id="form" method="GET" action="">
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
                                        <input type="text" name="emp_code" class="form-control" />
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
                                </tr>
                                <tr>
                                    <td style="vertical-align: middle;">Employee Type</td>
                                    <td>
                                        <select class="form-select" id="emp_type_id" name="emp_type_id" value="<?php echo set_value('emp_type_id'); ?>">
                                            <option value="">Any</option>
                                            <?php foreach ($employee_types as $type) { ?>
                                                <option value="<?php echo $type["id"]; ?>" <?php if (isset($_GET['emp_type_id']) && ($_GET['emp_type_id'] == $type['id'])) { echo "selected"; } ?>><?php echo $type["name"]; ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    
                                    <td style="vertical-align: middle;">Date</td>
                                    <td>
                                        <?php
                                            $dateValue = isset($_GET['date']) && !empty($_GET['date']) ? htmlspecialchars($_GET['date']) : date('Y-m-d');
                                            $today = date('Y-m-d'); // Get today's date
                                        ?>
                                        <input type="date" class="form-control" name="date" value="<?php echo $dateValue; ?>" max="<?php echo $today; ?>" />
                                    </td>
                                </tr>
                                <tr>
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

<?php if ($holiday) { ?>
    <div style="
        position: relative;
        padding: 30px 40px;
        border-left: 8px solid #e74c3c;
        background: #fdecea;
        color: #a94442;
        border-radius: 8px;
        font-family: Arial, sans-serif;
        text-align: center;
        box-shadow: 0 0 20px rgba(231, 76, 60, 0.4);
        z-index: 9999;
        max-width: 100%;
    ">
        <div style="
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 10px;
        ">
            🎉 Holiday Notice
        </div>

        <div style="
            font-size: 22px;
            background: #fff3f3;
            padding: 15px 20px;
            border-radius: 6px;
            display: inline-block;
        ">
            <?php echo htmlspecialchars(date('d-m-Y', strtotime($holiday_date))); ?> is a holiday:<br>
            <strong style="font-size: 26px;">
                <?php echo htmlspecialchars($holiday); ?>
            </strong>
        </div>
    </div>
<?php } ?>

<?php if(isset($records) && $holiday == false) { ?>
    <div class="row mb-5">
        <div class="col-md-12 mb-5">
            <div class="card card-flush h-xl-100">
                <div class="card-body py-9">
                    <div class="row">
                        <?php if(count($records) == 0) { ?>
                            <h4 class="text-center">No Employee Found</h4>    
                        <?php } else { ?>
                        
                            <form action="<?php echo base_url(); ?>personnel/attendance" method="POST">
                                <input type="date" class="d-none" name="date" value="<?php echo $dateValue; ?>" max="<?php echo $today; ?>" />
                                
                                <?php
                                // Get the date from GET or default to today
                                $dateValue = isset($_GET['date']) && !empty($_GET['date']) ? htmlspecialchars($_GET['date']) : date('Y-m-d');
                                $today = date('Y-m-d'); // For reference, not strictly needed
                                ?>
                                
                                <!-- Highlighted Attendance Sheet Title -->
                                <h4 class="mb-3 text-end">
                                    Attendance Sheet for 
                                    <span class="px-2 py-1 bg-warning text-dark fw-bold rounded">
                                        <?= date('d M, Y', strtotime($dateValue)); ?>
                                    </span>
                                </h4>
                                
                                <div class="table-responsive table-bordered table-striped table-hover">
                                    <table class="table">
                                        <thead>
                                            <tr class="text-center table-dark text-light">
                                                <th></th>
                                                <th>EMP Code</th>
                                                <th>Name</th>
                                                <th>Designation</th>
                                                <th>Attendance</th>
                                                <th>Check-in Time</th>
                                                <th>Reason</th>
                                                <th>Remarks</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php 
                                        // Reindex attendance data by employee_id for easy mapping
                                        $attendanceByEmp = [];
                                        foreach ($attendance_data as $a) {
                                            if (!empty($a['employee_id'])) {
                                                $attendanceByEmp[$a['employee_id']] = $a;
                                            }
                                        }
                                        
                                        $sl_no = 0;
                                        foreach ($records as $record) { 
                                            $sl_no++;
                                            $empId = $record['id'];
                                            $att = $attendanceByEmp[$empId] ?? null;
                                        ?>
                                        <tr class="text-center">
                                        
                                            <td class="table-primary text-dark p-2"><?= $sl_no; ?></td>
                                            <td><?= htmlspecialchars($record["emp_code"]); ?></td>
                                            <td><?= htmlspecialchars($record["f_name"] . ' ' . $record["m_name"] . ' ' . $record["l_name"]); ?></td>
                                            <td><?= htmlspecialchars($designations[$record["designation_id"] - 1]['name']); ?></td>
                                        
                                            <!-- Attendance -->
                                            <td>
                                                <select class="form-control attendance-select"
                                                        name="attendance[<?= $empId; ?>]">
                                                    <option value="P" <?= ($att && $att['attendance'] == 'P') ? 'selected' : ''; ?>>Present</option>
                                                    <option value="A" <?= ($att && $att['attendance'] == 'A') ? 'selected' : ''; ?>>Absent</option>
                                                </select>
                                            </td>
                                        
                                            <!-- Check-in Time -->
                                            <td>
                                                <input type="time"
                                                       class="form-control checkin-time"
                                                       name="checkin_time[<?= $empId; ?>]"
                                                      value="<?= ($att && $att['attendance'] == 'P') 
                                                                        ? (!empty($att['attendance_date']) 
                                                                            ? date('H:i', strtotime($att['attendance_date'])) 
                                                                            : '08:30') 
                                                                        : ''; ?>"
                                                            <?= ($att && $att['attendance'] == 'A') ? 'disabled' : ''; ?>>
                                            </td>
                                        
                                            <!-- Absent Reason -->
                                            <td>
                                                <select class="form-control reason-select"
                                                        name="reason[<?= $empId; ?>]"
                                                        <?= ($att && $att['attendance'] == 'P') ? 'disabled' : ''; ?>>
                                                    <option value="">Select Reason</option>
                                                    <?php foreach ($absent_reasons as $reason) { ?>
                                                        <option value="<?= htmlspecialchars($reason['name']); ?>"
                                                            <?= ($att && $att['reason'] == $reason['name']) ? 'selected' : ''; ?>>
                                                            <?= htmlspecialchars($reason['name']); ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                        
                                           <!-- Remarks -->
                                            <td>
                                                <input type="text"
                                                       class="form-control remarks-input"
                                                       name="remarks[<?= $empId; ?>]"
                                                       value="<?= htmlspecialchars($att['remarks'] ?? ''); ?>"
                                                       <?= ($att && $att['attendance'] == 'P') ? 'readonly' : ''; ?>>
                                            </td>
                                        
                                        </tr>
                                        <?php } ?>
                                        </tbody>

                                    </table>
                                </div>
                                
                                <button type="submit" class="btn btn-success">Save</button>
                            </form>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<script>
$(document).ready(function () {

    function handleAttendanceChange(select, clearValues = false) {
        var row = select.closest('tr');

        var reasonSelect = row.find('.reason-select');
        var remarksInput = row.find('.remarks-input');
        var checkinInput = row.find('.checkin-time');

        if (select.val() === 'A') {
            // Absent → enable reason & remarks, disable check-in
            reasonSelect.prop('disabled', false);
            remarksInput.prop('readonly', false);
            checkinInput.prop('disabled', true);

            if (clearValues) {
                reasonSelect.val('');
                remarksInput.val('');
                checkinInput.val('');
            }

        } else {
            // Present → disable reason & remarks, enable check-in
            reasonSelect.prop('disabled', true);
            remarksInput.prop('readonly', true);
            checkinInput.prop('disabled', false);

            if (clearValues) {
                reasonSelect.val('');
                remarksInput.val('');
            }
        }
    }

    // On change by user → clear values
    $(document).on('change', '.attendance-select', function () {
        handleAttendanceChange($(this), true); // clearValues = true
    });

    // Initial page load setup → do NOT clear values
    $('.attendance-select').each(function () {
        handleAttendanceChange($(this), false); // clearValues = false
    });

});
</script>



<?php $this->load->view("inc/app_footer.php"); ?>
