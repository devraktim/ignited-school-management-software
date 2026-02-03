<?php 
    $title = strtoupper($student['sex']) == "MALE" ? "SHRI" : "MISS";
    $sex = strtoupper($student['sex']) == "MALE" ? "Son" : "Daughter";
    $gender = strtoupper($student['sex']) == "MALE" ? "He" : "She";
	$gender1 = strtoupper($student['sex']) == "MALE" ? "His" : "Her";
    $name = strtoupper($student['f_name'] . " " . $student['m_name'] . " " . $student['l_name']);
    $father = strtoupper($student['father_name']);
    $mother = strtoupper($student['mother_name']);
	$father_passport_no = strtoupper($student['father_passport_no']);
	$mother_passport_no = strtoupper($student['mother_passport_no']);
    $address = $student['local_gurdian_address'];
    $class = $student['class'];
    $nationality = strtoupper($student['nationality']);
    $passport_no = $student['passport_no'];
    $passport_valid_to = date("d-m-Y", strtotime($student['passport_valid_to']));

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Multiple Visa Letter 2 For Non Indian Student</title>
</head>
<body>
<body data-new-gr-c-s-check-loaded="14.1098.0" data-gr-ext-installed="">
		<div style="width:90%; margin: 0 auto; margin-top:150px;">
			
			<div style="font-family:Arial; font-size:10pt; font-style:italic">Ref.No. HBS/2022-2023/Multiple/98</div>
			
			<div style="font-size:12pt; font-weight:bold; margin-top:30px; text-align:center; text-transform:uppercase;">To Whom It May Concern</div>
			
			<div style="font-size:12pt; margin-top:30px; text-align:justify; line-height:25px;">
			
				This is to certify that <span style="text-transform:uppercase;"><?php echo $title ?> <?php echo $name ?> </span> 
				(Regn: 6714),
				<?php echo $sex?> of <?php echo $father ?> and <?php echo $mother?> , resident of <?php echo $address ?>, is a bonafide student of this Institution and is studying
				in Class <?php echo $class ?> for the academic session <?php echo date("d-m-Y", strtotime($session_start))?> - <?php echo date("d-m-Y", strtotime($session_end))?>.<p></p>
					
				She is a <?php echo $nationality ?> national holding Passport Number <?php echo $passport_no ?>  dated:  and valid up to <?php echo $passport_valid_to ?>.<p></p>
				
				<span style="font-weight:bold;">
				
				Her Father/ Mother/ Grandfather - mother/ Guardian / Brother / Sister have to come to school for the vacation specified by the school 
					according to the School ST. Joseph's Convent School to take their child.<p></p>
								
				
				Father : <?php echo $father ?><br>
				Passport No : <?php echo $father_passport_no ?><p></p>
				
				</span>

				Date of Issue : <?php echo date("d-m-Y", time()) ?>		
				<table style="width:100%; margin-top:80px;">
					<tbody><tr>
						<td style="width:40%; padding-top:5px;">Place of Issue : Kurseong</td>
						<td style="width:30%;">&nbsp;</td>
						<td style="border-top:1px #000 solid; text-align:right; padding-right:5px; padding-top:5px;">for ST. Joseph's Convent School</td>
					</tr>
					<tr>
						<td style="padding-top:40px;">Seal of the School</td>
						<td colspan="2">&nbsp;</td>
					</tr>
				</tbody></table>
		
			</div>
	
		</div>
	
    
    </body>
</body>
</html>