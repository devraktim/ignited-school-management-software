<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Leave Applications Report</title>

<style>

body{
    font-family: Arial;
}

.BigHeader {
    text-align:center;
    font-family: 'MS Sans Serif', Serif;
    font-weight:bold;
    font-size:16pt;
}

.SmallHeader {
    width:98%;
    text-align:center;
    font-family:Arial;
    font-size:12pt;    
    margin-left:10px;
    border-bottom: 1px #000 double;
}

.GridTable {
    border: 2px #000 solid;
    border-collapse: collapse;   
}

.GridTable th {
    border: 1px #000 solid;
    text-align:center;
    font-family:"Times New Roman", Georgia;
    font-size:10pt;
    font-weight:bold;
    font-variant: small-caps;
    background: #EEE;
    color:#000;
}

.GridTable td {
    border: 1px #000 solid;
    text-align:center;
    font-family:"Courier New", Arial;
    font-size:10pt;    
    padding:5px;
}

@page{
    size:A4;
    margin:20mm;
}

</style>

</head>

<body>

<?php

$total = count($leaves);

if($total == 0){

?>

<table style="width:98%;border-collapse:collapse;margin-left:10px;border-bottom:2px solid #000;">
<tr>

<td style="vertical-align:top" rowspan="2">
<img src="<?php echo base_url()?>assets/media/logos/logol.png" style="height:70px;width:70px;">
</td>

<td style="text-align:center;vertical-align:top">
<div style="font-family:Arial;font-size:30pt">
St. Francis School
</div>
</td>

<td style="vertical-align:top;text-align:end;" rowspan="2">
<img src="<?php echo base_url()?>assets/media/logos/logol.png" style="height:70px;width:70px;">
</td>

</tr>

<tr>
<td style="text-align:center;font-size:10pt;font-family:Arial;font-style:italic;">
Jorethang
</td>
</tr>

</table>

<div class="BigHeader" style="width:90%;margin:20px auto;">
Leave Applications Report
</div>

<table class="GridTable" style="width:94%;margin:0 auto;margin-top:30px">

<tr>
<th style="width:3%">Sl</th>
<th>Emp Code</th>
<th>Name</th>
<th>Department</th>
<th>Designation</th>
<th>Application Date</th>
<th>Leave Period</th>
</tr>

<tr>
<td colspan="7" style="padding:20px;font-weight:bold;">
No Data Found
</td>
</tr>

</table>

<?php

}else{

$sl_no = 0;
$i = 0;

while ($i < $total) {

$chunk = array_slice($leaves,$i,25);
$i += 25;

?>

<table style="width:98%;border-collapse:collapse;margin-left:10px;border-bottom:2px solid #000;">
<tr>

<td style="vertical-align:top" rowspan="2">
<img src="<?php echo base_url()?>assets/media/logos/logol.png" style="height:70px;width:70px;">
</td>

<td style="text-align:center;vertical-align:top">
<div style="font-family:Arial;font-size:30pt">
St. Francis School
</div>
</td>

<td style="vertical-align:top;text-align:end;" rowspan="2">
<img src="<?php echo base_url()?>assets/media/logos/logol.png" style="height:70px;width:70px;">
</td>

</tr>

<tr>
<td style="text-align:center;font-size:10pt;font-family:Arial;font-style:italic;">
Jorethang
</td>
</tr>

</table>

<div class="BigHeader" style="width:90%;margin:20px auto;">
Leave Applications Report
</div>

<table class="GridTable" style="width:94%;margin:0 auto;margin-top:30px">

<tr>
<th style="width:3%">Sl</th>
<th>Emp Code</th>
<th>Name</th>
<th>Department</th>
<th>Designation</th>
<th>Application Date</th>
<th>Leave Period</th>
</tr>

<?php foreach($chunk as $leave){

$sl_no++;

$app = json_decode($leave['application'],true);

$application_date = isset($app['application_date']) ? $app['application_date'] : '';
$from_date = isset($app['from_date']) ? $app['from_date'] : '';
$to_date = isset($app['to_date']) ? $app['to_date'] : '';

$application_date = !empty($application_date) ? date('d-m-Y',strtotime($application_date)) : '';
$from_date = !empty($from_date) ? date('d-m-Y',strtotime($from_date)) : '';
$to_date = !empty($to_date) ? date('d-m-Y',strtotime($to_date)) : '';

$leave_period = $from_date;

if(!empty($from_date) && !empty($to_date)){
$leave_period = $from_date." to ".$to_date;
}

?>

<tr>

<td><?php echo $sl_no;?></td>

<td><?php echo $leave['employee']['emp_code'];?></td>

<td>
<?php 
echo $leave['employee']['f_name']." ".
$leave['employee']['m_name']." ".
$leave['employee']['l_name'];
?>
</td>

<td><?php echo $leave['employee']['department'];?></td>

<td><?php echo $leave['employee']['designation'];?></td>

<td><?php echo $application_date;?></td>

<td><?php echo $leave_period;?></td>

</tr>

<?php } ?>

</table>

<div style="page-break-before:always;"></div>

<?php } } ?>

</body>
</html>