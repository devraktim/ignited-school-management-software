<?php $this->load->view("inc/app_header.php"); ?>

<div class="row mb-5">
    <h1>Session Wise Attendance</h1>
</div>

<style>
    .table {
    font-size: 14px;
}

.table th,
.table td {
    padding: 4px 6px !important;
    vertical-align: middle;
}

.table thead th {
    font-size: 14px;
    padding: 5px 6px !important;
}

.table tbody td {
    font-size: 14px;
}

.table-responsive {
    overflow-x: auto;
}
</style>

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
<select class="form-select" id="department_id" name="department_id">
<option value="">Any</option>
<?php foreach ($departments as $department) { ?>
<option value="<?php echo $department["id"]; ?>" <?php if (isset($_GET['department_id']) && ($_GET['department_id'] == $department['id'])) { echo "selected"; } ?>>
<?php echo $department["name"]; ?>
</option>
<?php } ?>
</select>
</td>

<td style="vertical-align: middle;">Designation</td>
<td>
<select class="form-select" id="designation_id" name="designation_id">
<option value="">Any</option>
<?php foreach ($designations as $designation) { ?>
<option value="<?php echo $designation["id"]; ?>" <?php if (isset($_GET['designation_id']) && ($_GET['designation_id'] == $designation['id'])) { echo "selected"; } ?>>
<?php echo $designation["name"]; ?>
</option>
<?php } ?>
</select>
</td>

<td style="vertical-align: middle;">Employee Type</td>
<td>
<select class="form-select" id="emp_type_id" name="emp_type_id">
<option value="">Any</option>
<?php foreach ($employee_types as $type) { ?>
<option value="<?php echo $type["id"]; ?>" <?php echo (isset($_GET['emp_type_id']) && $_GET['emp_type_id'] == $type['id']) ? 'selected' : ''; ?>>
<?php echo $type["name"]; ?>
</option>
<?php } ?>
</select>
</td>

<td style="vertical-align: middle;">Job Status</td>
<td>
<select class="form-select" id="job_status_id" name="job_status_id">
<option value="">Any</option>
<?php foreach ($job_statuses as $job_status) { ?>
<option value="<?php echo $job_status["id"]; ?>" <?php if (isset($_GET['job_status_id']) && ($_GET['job_status_id'] == $job_status['id'])) { echo "selected"; } ?>>
<?php echo $job_status["name"]; ?>
</option>
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
<div class="col-md-12">
<div class="card card-flush h-xl-100">
<div class="card-body py-9">

<?php if (empty($employeeRecords)): ?>

<p class="text-center text-muted">No records found</p>

<?php else: ?>

<?php

/* SESSION BASED MONTH ORDER */

$currentSession = $this->session->academy_session['current_session'];

$sessionStart = new DateTime($currentSession['start']);
$sessionEnd   = new DateTime($currentSession['end']);

$months = [];

while ($sessionStart <= $sessionEnd) {

    $yearMonth = $sessionStart->format('Y-m');
    $monthName = $sessionStart->format('M');

    $months[] = [
        'key'  => $yearMonth,
        'name' => $monthName
    ];

    $sessionStart->modify('+1 month');
}

?>

<div class="table-responsive table-bordered">
<table class="table">

<thead>

<tr class="text-center table-dark text-light">

<th rowspan="2" class="p-2" style="vertical-align: middle;">Sl. No.</th>
<th rowspan="2" style="vertical-align: middle;">Emp Code</th>
<th rowspan="2" style="vertical-align: middle;">Name</th>
<th rowspan="2" style="vertical-align: middle;">Designation</th>

<?php foreach ($months as $month): ?>
<th class="bg-primary"><?php echo $month['name']; ?></th>
<?php endforeach; ?>

<th class="bg-primary">Total</th>

</tr>

<tr class="text-center">

<?php foreach ($months as $month): 

$monthKey = $month['key'];
$workingDays = $monthlyWorkingDays[$monthKey] ?? 0;

?>

<th style="background-color: #FFC107; color: black;">
<?php echo $workingDays; ?>D
</th>

<?php endforeach; ?>

<th style="background-color: #FFC107; color: black;">
<?php echo $yearlyWorkingDays; ?>D
</th>

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

<td>
<?php echo trim($employee['f_name'].' '.$employee['m_name'].' '.$employee['l_name']); ?>
</td>

<td>
<?php echo $designations[$designationId - 1]['name'] ?? ''; ?>
</td>

<?php foreach ($months as $month): 

$monthKey = $month['key'];
$present = $attendanceData[$empId]['monthly'][$monthKey] ?? 0;

?>

<td><?php echo $present; ?></td>

<?php endforeach; ?>

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
```
