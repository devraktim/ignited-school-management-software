<?php

if(isset($saved_data->transfer_certificate) && $saved_data->transfer_certificate!=""){
    $saved_data = json_decode($saved_data->transfer_certificate);
}else{
    $saved_data = new stdClass();
}

function old_tc($saved_data,$field){
    return isset($saved_data->$field) ? $saved_data->$field : "";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<title>Transfer Certificate</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
background:#f5f5f5;
font-family:"Times New Roman",serif;
}

.certificate{
width:210mm;
min-height:297mm;
background:white;
margin:auto;
padding:40px 68px;
position:relative;
font-size:17px;
line-height:40px;
border:2px solid black;
}

.logo{width:80px;}

.school-title{
font-size:30px;
font-weight:700;
letter-spacing:1px;
}

.school-sub{
font-size:18px;
font-weight:600;
}

.cert-title{
font-size:20px;
font-weight:700;
text-decoration:underline;
text-underline-offset:5px;
margin-top:5px;
}

.field{
border:none;
border-bottom:1px solid #000;
outline:none;
background:transparent;
padding:0 4px;
height:24px;
font-size:15px;
}

.field-sm{width:120px;}
.field-md{width:200px;}
.field-lg{width:320px;}

.line{margin-bottom:10px;}

.signature{
position:absolute;
bottom:120px;
right:80px;
text-align:center;
font-size:14px;
}

.date{
position:absolute;
bottom:110px;
left:70px;
font-size:14px;
}

.no-print{margin-top:20px;}

@media print{

body{background:white;}

.certificate{
margin:0;
width:210mm;
height:297mm;
}

.no-print{
display:none;
}

}

</style>

</head>

<body>

<?php echo form_open(base_url("students/withdrawn/generate/transfer-certificate"),[
"method"=>"POST"
]); ?>

<div class="certificate">

<div class="row align-items-center mb-3">

<div class="col-2">
<img src="https://ignitedsoft.in/stfrancis/assets/sfs_new_logo.png" class="logo">
</div>

<div class="col-10 text-center">
<div class="school-title">ST. FRANCIS' SCHOOL</div>
<div class="school-sub">JORETHANG, SOUTH SIKKIM</div>
<div class="cert-title">TRANSFER CERTIFICATE</div>
</div>

</div>

<div class="row mt-4">

<div class="col-6">
Apaar ID :
<input class="field field-md" name="field_1" value="<?= old_tc($saved_data,'field_1') ?>">
</div>

<div class="col-6 text-end">
Admission No :
<input class="field field-md" name="field_2" value="<?= old_tc($saved_data,'field_2') ?: $student_data['student_no'] ?>">
</div>

</div>

<div class="row mt-2">

<div class="col-6">
TC No :
<input class="field field-md" name="field_3" value="<?= old_tc($saved_data,'field_3') ?: $tc_no ?>">
</div>

<div class="col-6 text-end">
UDISE PEN :
<input class="field field-md" name="field_4" value="<?= old_tc($saved_data,'field_4') ?>">
</div>

</div>

<div class="mt-5">

<div class="line">
THIS IS TO CERTIFY THAT
<input class="field field-lg" style="width:445px;"
name="field_5"
value="<?= old_tc($saved_data,'field_5') ?: $student_data['f_name'].' '.$student_data['m_name'].' '.$student_data['l_name'] ?>">
</div>

<div class="line">

<?php if ($student_data['sex'] == 'male') { ?>
    Son of / <s>Daughter of</s>
<?php } elseif ($student_data['sex'] == 'female') { ?>
    <s>Son of</s> / Daughter of
<?php } ?>


<input class="field field-lg" style="width:332px;"
name="field_6"
value="<?= old_tc($saved_data,'field_6') ?: $student_data['father_name'] ?>">

was admitted into this school on

<input class="field field-sm"
type="date"
style="width:197px;"
name="field_7"
value="<?= old_tc($saved_data,'field_7') ?: date('Y-m-d',strtotime($student_data['admission_date'])) ?>">

on a transfer from

<input class="field field-md"
style="width:225px;"
name="field_8"
value="<?= old_tc($saved_data,'field_8') ?>">

</div>

<div class="line">

and left on

<input class="field field-sm"
type="date"
style="width:197px;"
name="field_9"
value="<?= old_tc($saved_data,'field_9') ?: $date_of_leaving ?>">

with a

<input class="field field-sm"
name="field_10"
value="<?= old_tc($saved_data,'field_10') ?>">

Character.

</div>

<div class="line">

He / She was studying in the

<input class="field field-sm"
name="field_11"
style="width:100px;"
value="<?= old_tc($saved_data,'field_11') ?>">

class of the

<input class="field field-sm"
name="field_12"
value="<?= old_tc($saved_data,'field_12') ?>">

the school year being

</div>

<div class="line">

from

<select class="field field-sm" name="field_13" style="width:197px;">

<option value="">Month</option>

<?php
$months=["January","February","March","April","May","June","July","August","September","October","November","December"];

foreach($months as $m){

$sel = old_tc($saved_data,'field_13')==$m ? "selected":"";
echo "<option $sel>$m</option>";

}
?>

</select>

to

<select class="field field-sm" name="field_14" style="width:197px;">

<option value="">Month</option>

<?php

foreach($months as $m){

$sel = old_tc($saved_data,'field_14')==$m ? "selected":"";
echo "<option $sel>$m</option>";

}

?>

</select>

</div>

<div class="line">
All sums due to this school on his / her account has been remitted or satisfactorily arranged for.
</div>

<div class="line">

His / Her date of birth, according to the Admission Register is

<input class="field field-sm"
type="date"
style="width:197px;"
name="field_15"
value="<?= old_tc($saved_data,'field_15') ?: date('Y-m-d',strtotime($student_data['dob'])) ?>">

</div>

<div class="line">

Promotion has been

<input class="field field-sm"
style="width:250px;"
name="field_16"
value="<?= old_tc($saved_data,'field_16') ?>">

</div>

</div>

<div class="date">

Date :
<input class="field field-sm"
type="date"
name="field_17"
value="<?= old_tc($saved_data,'field_17') ?: $tc_date ?>">

</div>

<div class="signature">
Fr.Robin Kalikotey<br>
Principal
</div>

</div>

<input type="hidden" name="student_id" value="<?= $student_id ?>">
<input type="hidden" name="tc_no" value="<?= $tc_no ?>">
<input type="hidden" name="tc_date" value="<?= $tc_date ?>">
<input type="hidden" name="date_of_leaving" value="<?= $date_of_leaving ?>">
<input type="hidden" name="reason" value="<?= $reason ?>">
<input type="hidden" name="version" value="<?= $version ?>">

<div class="text-center no-print">
<button class="btn btn-success">Save</button>
</div>

<?php echo form_close(); ?>

</body>
</html>