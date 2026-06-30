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

.logo{
width:80px;
}

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
display:inline-block;
padding:0 4px;
min-height:22px;
/* line-height:22px; */
vertical-align:bottom;
font-size:15px;
}

.field-sm{width:120px;}
.field-md{width:200px;}
.field-lg{width:320px;}

.line{
margin-bottom:10px;
}

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

@media print{

body{
background:white;
}

.certificate{
margin:0;
width:210mm;
height:297mm;
}

}

</style>

</head>

<body onload="window.print()">

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
<span class="field field-md"><?php echo $data["field_1"] ?? "" ?></span>
</div>

<div class="col-6 text-end">
Admission No :
<span class="field field-md"><?php echo $data["field_2"] ?? $student_data["student_no"] ?></span>
</div>

</div>


<div class="row mt-2">

<div class="col-6">
TC No :
<span class="field field-md"><?php echo $data["field_3"] ?? $tc_no ?></span>
</div>

<div class="col-6 text-end">
UDISE PEN :
<span class="field field-md"><?php echo $data["field_4"] ?? "" ?></span>
</div>

</div>


<div class="mt-5">

<div class="line">
THIS IS TO CERTIFY THAT
<span class="field field-lg" style="width:445px;">
<?php echo $data["field_5"] ?? "" ?>
</span>
</div>


<div class="line">

<?php if ($student_data['sex'] == 'male') { ?>
    Son of / <s>Daughter of</s>
<?php } elseif ($student_data['sex'] == 'female') { ?>
    <s>Son of</s> / Daughter of
<?php } ?>

<span class="field field-lg" style="width:332px;">
<?php echo $data["field_6"] ?? "" ?>
</span>

was admitted into this school on

<span class="field field-sm" style="width:197px;">
<?php echo isset($data["field_7"]) ? date("d-m-Y",strtotime($data["field_7"])) : "" ?>
</span>

on a transfer from

<span class="field field-md" style="width:225px;">
<?php echo $data["field_8"] ?? "" ?>
</span>

and left on

</div>


<div class="line">

<span class="field field-sm" style="width:197px;">
<?php echo isset($data["field_9"]) ? date("d-m-Y",strtotime($data["field_9"])) : "" ?>
</span>

with a

<span class="field field-sm">
<?php echo $data["field_10"] ?? "" ?>
</span>

Character.

</div>


<div class="line">

He / She was studying in the

<span class="field field-sm" style="width:100px;">
<?php echo $data["field_11"] ?? "" ?>
</span>

class of the

<span class="field field-sm">
<?php echo $data["field_12"] ?? "" ?>
</span>

the school year being

</div>


<div class="line">

from

<span class="field field-sm" style="width:197px;">
<?php echo $data["field_13"] ?? "" ?>
</span>

to

<span class="field field-sm" style="width:197px;">
<?php echo $data["field_14"] ?? "" ?>
</span>

</div>


<div class="line">
All sums due to this school on his / her account has been remitted or satisfactorily arranged for.
</div>


<div class="line">

His / Her date of birth, according to the Admission Register is

<span class="field field-sm" style="width:197px;">
<?php echo isset($data["field_15"]) ? date("d-m-Y",strtotime($data["field_15"])) : "" ?>
</span>

</div>


<div class="line">

Promotion has been

<span class="field field-sm" style="width:250px;">
<?php echo $data["field_16"] ?? "" ?>
</span>

</div>

</div>


<div class="date">

Date :
<span class="field field-sm">
<?php echo isset($data["field_17"]) ? date("d-m-Y",strtotime($data["field_17"])) : date("d-m-Y") ?>
</span>

</div>


<div class="signature">
Fr.Robin Kalikotey <br>
Principal
</div>


</div>

</body>
</html>