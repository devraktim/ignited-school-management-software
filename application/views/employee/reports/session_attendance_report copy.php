<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>

@page {
    size: A4;
    margin: 15mm;
}

body{
    font-family: Arial, sans-serif;
}

.BigHeader{
    text-align:center;
    font-size:18pt;
    font-weight:bold;
}

.SubHeader{
    text-align:center;
    font-size:11pt;
}

.GridTable{
    width:100%;
    border-collapse:collapse;
    margin-top:20px;
}

.GridTable th{
    border:1px solid #000;
    padding:6px;
    font-size:10pt;
    font-weight:bold;
    background:#f0f0f0;
}

.GridTable td{
    border:1px solid #000;
    padding:5px;
    font-size:9pt;
    text-align:center;
}

.headerTable{
    width:100%;
    border-bottom:2px solid #000;
    margin-bottom:10px;
}

.logo{
    height:70px;
    width:70px;
}

.schoolName{
    font-size:26pt;
    font-weight:bold;
}

.schoolAddress{
    font-size:11pt;
    font-style:italic;
}

</style>

</head>

<body>

<?php 
$sl_no = 0;
$i = 0;
$total = count($employeeRecords);

$currentSession = $this->session->academy_session['current_session'];

$sessionStart = $currentSession['start'];
$sessionEnd   = $currentSession['end'];

$year = $_GET['year'] ?? date('Y');

$monthNames = [
1=>'Jan',2=>'Feb',3=>'Mar',4=>'Apr',
5=>'May',6=>'Jun',7=>'Jul',8=>'Aug',
9=>'Sep',10=>'Oct',11=>'Nov',12=>'Dec'
];
?>

<!-- HEADER -->
<table class="headerTable">
<tr>

<td width="10%">
<img src="<?php echo base_url()?>assets/media/logos/logol.png" class="logo">
</td>

<td align="center">
<div class="schoolName">St. Francis School</div>
<div class="schoolAddress">Jorethang</div>
</td>

<td width="10%" align="right">
<img src="<?php echo base_url()?>assets/media/logos/logol.png" class="logo">
</td>

</tr>
</table>

<div class="BigHeader">
Session Wise Attendance Report
</div>

<div class="SubHeader">
(<?php echo date('d-m-Y', strtotime($sessionStart)); ?> to <?php echo date('d-m-Y', strtotime($sessionEnd)); ?>)
</div>


<?php if(empty($employeeRecords)): ?>

<p style="text-align:center">No Records Found</p>

<?php else: ?>


<table class="GridTable">

<thead>

<tr>
<th rowspan="2">Sl No</th>
<th rowspan="2">Emp Code</th>
<th rowspan="2">Name</th>
<th rowspan="2">Designation</th>

<?php for($m=1;$m<=12;$m++): ?>
<th><?php echo $monthNames[$m]; ?></th>
<?php endfor; ?>

<th>Total</th>
</tr>


<tr>

<?php for($m=1;$m<=12;$m++): 
$monthKey = sprintf('%s-%02d', $year, $m);
$workingDays = $monthlyWorkingDays[$monthKey] ?? 0;
?>

<th><?php echo $workingDays; ?>D</th>

<?php endfor; ?>

<th><?php echo $yearlyWorkingDays; ?>D</th>

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

<tr>

<td><?php echo $slNo++; ?></td>

<td><?php echo $employee['emp_code']; ?></td>

<td>
<?php echo trim($employee['f_name'].' '.$employee['m_name'].' '.$employee['l_name']); ?>
</td>

<td>
<?php echo $designations[$designationId - 1]['name'] ?? ''; ?>
</td>

<?php for($m=1;$m<=12;$m++): 
$monthKey = sprintf('%s-%02d', $year, $m);
$present = $attendanceData[$empId]['monthly'][$monthKey] ?? 0;
?>

<td><?php echo $present; ?></td>

<?php endfor; ?>

<td><strong><?php echo $yearlyTotal; ?></strong></td>

</tr>

<?php endforeach; ?>

</tbody>

</table>

<?php endif; ?>

</body>
</html>