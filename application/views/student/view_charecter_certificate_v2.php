<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
		<title>Certificate</title>
		<style>
			body {
				background: #e9ecef;
			}

			/* A4 Landscape */
			.page {
				width: 297mm;
				height: 210mm;
				margin: auto;
				background: white;
				border: 4px solid #6f9dc7;
				padding: 40px 80px;
				position: relative;
				overflow: hidden;
			}

			/* Header */
			.school-title {
				font-size: 40px;
				font-weight: bold;
				letter-spacing: 2px;
			}

			.school-subtitle {
				font-size: 22px;
			}

			.cert-title {
				font-size: 34px;
				color: #2c55c7;
				font-weight: bold;
			}

			.cert-sub {
				font-size: 26px;
				color: #2c55c7;
				font-style: italic;
			}

			/* Input styling */
			.form-control {
				border: none;
				border-bottom: 1px solid black;
				border-radius: 0;
				padding: 2px 4px;
			}

			/* Principal section */
			.principal {
				position: absolute;
				bottom: 60px;
				left: 50%;
				transform: translateX(-50%);
				text-align: center;
				font-weight: bold;
			}

			/* Logo */
			.logo {
				position: absolute;
				right: 60px;
				bottom: 40px;
				width: 90px;
			}

			/* Abstract bottom design */
			.bottom-design {
				position: absolute;
				bottom: 0;
				left: 0;
				width: 100%;
				height: 70px;
				background: #7fa7cf;
				clip-path: polygon(0 40%,
						8% 65%,
						92% 65%,
						100% 40%,
						100% 100%,
						0 100%);
			}

			/* Print settings */
			@media print {
				body {
					background: white;
				}

				.page {
					border: none;
					margin: 0;
				}

				.no-print {
					display: none;
				}

				input {
					border: none;
				}
			}
		</style>
	</head>
	<body>
		<div class="container my-4">
			<?php echo form_open(base_url("students/withdrawn/generate/charecter-certificate"), array("method" => "POST" , "target" => "print_popup", "onsubmit"=> "window.open('about:blank','print_popup','width=1000,height=500');")) ?> 
				<div class="page">
					<div class="text-center">
						<div class="school-title"> ST. FRANCIS’ SCHOOL </div>
						<div class="school-subtitle"> JORETHANG, SOUTH SIKKIM </div>
						<br>
						<div class="cert-title">This Certificate Proudly Acknowledges</div>
						<br>
						<!-- <div class="cert-sub"> of Good Character </div> -->
					</div>
					<br>
					<!-- <p class="text-center fs-5"> </p> -->
					<div class="text-center mb-4">
						<input type="text" name="field_1" class="form-control text-center fw-bold fs-4" placeholder="Student Name" value="<?php echo $data['field_1'] ?>" readonly>
					</div>
					
					<p class="fs-5"> 
						<?php if ($student_data['sex'] == 'male') { ?>
							Son of / <s>Daughter of</s>
						<?php } elseif ($student_data['sex'] == 'female') { ?>
							<s>Son of</s> / Daughter of
						<?php } ?>
						<input type="text" name="field_2" class="form-control d-inline w-25 mx-2" value="<?php echo $data['field_2'] ?>" readonly> resident of <input type="text" name="field_3" class="form-control d-inline w-25 mx-2" value="<?php echo $data['field_3'] ?>" readonly> was a bonafide-student of this esteemed institution. 
					</p>

					<p class="fs-5"> The Character of the above mentioned student was <input type="text" name="field_4" class="form-control d-inline w-25 mx-2" value="<?php echo $data['field_4'] ?>" required readonly> . </p>
					<p class="fs-5"> Academically the student was <input type="text" name="academic" class="form-control d-inline w-25 mx-2" value="<?php echo $data['field_5'] ?>" required readonly> . </p>
					<br>
					<p class="fs-5"> Date : <input type="date" name="field_5" class="form-control d-inline w-25 mx-2" value="<?php echo $data['field_6'] ?>" required readonly>
					</p>
					<!-- Principal Signature -->
					<div class="principal">
						<div style="height:50px">
							<!-- <input type="text" name="principal_signature" class="form-control text-center" placeholder="Principal Signature"> -->
						</div> Principal <br> St. Francis’ School, Jorethang
					</div>
					<!-- Logo -->
					<img src="https://ignitedsoft.in/stfrancis/assets/sfs_new_logo.png" class="logo" >
					<!-- Bottom abstract design -->
					<div class="bottom-design"></div>
				</div>
				<div class="text-center mt-3 no-print d-none">
					<button type="button" class="btn btn-primary" onclick="window.print()"> Save </button>
				</div>

				<input type="text" class="d-none" name="field_6" value="" />
				<input type="text" class="d-none" name="student_id" value="<?php echo $student_id; ?>" />
				<input type="text" class="d-none" name="version" value="<?php echo $version; ?>" />
			<?php echo form_close() ?> 
		</div>
	</body>
    <script>
        window.onload = function() {
            setTimeout(function() {
                window.print();
            }, 500); // 500ms = 0.5 second
        };
    </script>
</html>