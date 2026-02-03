<?php 
    $title = strtoupper($student['sex']) == "MALE" ? "SHRI" : "MISS";
    $sex = strtoupper($student['sex']) == "MALE" ? "Son" : "Daughter";
    $gender = strtoupper($student['sex']) == "MALE" ? "He" : "She";
    $name = strtoupper($student['f_name'] . " " . $student['m_name'] . " " . $student['l_name']);
    $father = strtoupper($student['father_name']);
    $mother = strtoupper($student['mother_name']);
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
    <title>Non Indian New Student Bonafide</title>
</head>
<body>
<body data-new-gr-c-s-check-loaded="14.1098.0" data-gr-ext-installed="">
		<div style="width:90%; margin: 0 auto; margin-top:150px;">
			
			<div style="font-family:Arial; font-size:10pt; font-style:italic">Ref.No. HBS/BS/98/2022-2023</div>
			
			<div style="font-size:12pt; font-weight:bold; margin-top:30px; text-align:center; text-transform:uppercase;">To Whom It May Concern</div>
			
			<div style="font-size:12pt; margin-top:30px; text-align:justify; line-height:25px;">
			
				This is to certify that <span style="text-transform:uppercase"><?php echo $title; ?> <?php echo $name; ?> </span> (Regn: 6714),
				<?php echo $sex?> of <span style="text-transform:uppercase"> <?php echo $father; ?></span>
				 and <span style="text-transform:uppercase"><?php echo $mother ?></span>				, resident of <span style="text-transform:uppercase"> <?php echo $address; ?></span>, is admitted in this institution and studying in Class
					<?php echo $class; ?> for the academic session 2022-2023.<p></p>
					
				<?php echo $gender?> is a <?php echo $nationality ?> national holding Passport Number <?php echo $passport_no ?>  dated:  and valid up to <?php echo $passport_valid_to ?><p></p>
				
				The academic session of the school begins from <?php echo date("d-m-Y", strtotime($session_start)) ?> and ends in <?php echo date("d-m-Y", strtotime($session_end)) ?>.<p></p>
				
				The School is recognized by The Council for the Indian School Certificate Examination - New Delhi - (I.C.S.E/I.S.C New Delhi). <span style="font-style:italic">
				("I.G.C.S.E" - "A" LEVEL - CAMBRIDGE UNIVERSITY, U.K.) </span> <p></p>
				
				<!-- Student visa may be issued for (3) Three Years for the academic session 2023-2025<p></p> -->
				Student visa may be issued for (<?php echo $total_years; ?>) Years.<p></p>

				Date of Issue : <?php echo date("d-m-Y", time()) ?>		
				<table style="width:100%; margin-top:80px;">
					<tbody><tr>
						<td style="width:40%; padding-top:5px;">Place of Issue : Kurseong</td>
						<td style="width:30%;">&nbsp;</td>
						<td style="border-top: 1px solid rgb(0, 0, 0); text-align: right; padding-right: 5px; padding-top: 5px; --darkreader-inline-border-top:#7e7669;" data-darkreader-inline-border-top="">for ST. Joseph's Convent School</td>
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