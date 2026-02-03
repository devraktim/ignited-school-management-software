<!DOCTYPE html>
<html lang="en">
<head>
		<title>Login</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="canonical" href="https://preview.keenthemes.com/metronic8" />
		<link rel="shortcut icon" href="../../../<?php echo base_url() ?>assets/media/logos/favicon.ico" />
		<!--begin::Fonts(mandatory for all pages)-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
		<!--end::Fonts-->
		<!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
		<link href="<?php echo base_url() ?>assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url() ?>assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
		<!--end::Global Stylesheets Bundle-->
	</head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_body" class="app-blank app-blank bgi-size-cover bgi-position-center bgi-no-repeat">
		<!--begin::Root-->
		<div class="d-flex flex-column flex-root" id="kt_app_root">
			<!--begin::Page bg image-->
			<style>body { background-image: url('<?php echo base_url() ?>assets/media/auth/bg5.jpg'); } [data-theme="dark"] body { background-image: url('../../../<?php echo base_url() ?>assets/media/auth/bg4-dark.jpg'); }</style>
			<!--end::Page bg image-->
			<!--begin::Authentication - Sign-in -->
			<div class="d-flex flex-column flex-column-fluid flex-lg-row">
				<!--begin::Aside-->
				<div class="d-flex flex-center w-lg-50 pt-15 pt-lg-0 px-10">
					<!--begin::Aside-->
					<div class="d-flex flex-center flex-lg-start flex-column">
						<!--begin::Logo-->
						<a href="index.html" class="mb-7">
							<div class="d-flex flex-row">
								<div>
									<h1 class="d-inline-block">
										<img alt="Logo" src="<?php echo base_url() ?>assets/media/logos/sfs-logo.png" style="height: 100px; width: 100px;" />
									</h1>
								</div>
								<div class="d-flex flex-column justify-content-center ms-3">
									<h3 class="d-inline-block text-light" style="font-size: 35px;">St. Francis School, Jorethang</h3>
								</div>
							</div>
						</a>
						<!--end::Logo-->
					</div>
					<!--begin::Aside-->
				</div>
				<!--begin::Aside-->
				<!--begin::Body-->
				<div class="d-flex flex-center w-lg-50 p-10">
					<!--begin::Card-->
					<div class="card rounded-3 w-md-550px">
						<!--begin::Card body-->
						<div class="card-body p-10 p-lg-20">
							<!--begin::Form-->
							<form class="form w-100" id="kt_sign_in_form" action="<?php echo base_url() ?>login" method="POST">
								<!--begin::Heading-->
								<div class="text-center mb-11">
									<!--begin::Title-->
									<h1 class="text-dark fw-bolder mb-3">Sign In</h1>
									<!--end::Title-->
									<!--begin::Subtitle-->
									<div class="text-gray-500 fw-semibold fs-6">School Management System</div>
									<!--end::Subtitle=-->
								</div>
								<!--begin::Heading-->

								<?php if($this->session->flashdata('error')) { ?>
									<div class="alert alert-danger alert-dismissible fade show" role="alert">
										<?php echo $this->session->flashdata('error') ?>
										<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
									</div>
								<?php } ?>

								<!--begin::Input group=-->
								<div class="fv-row mb-8">
									<!--begin::Username-->
                                    <label for="username" class="form-label">Username</label>
									<input type="text" name="username" autocomplete="off" class="form-control bg-transparent" />
									<!--end::Username-->
									<div class="invalid-feedback d-block">
										<?php echo form_error('username'); ?>
									</div>
								</div>
								<!--end::Input group=-->
								<div class="fv-row mb-8">
									<!--begin::Password-->
                                    <label for="password" class="form-label">Password</label>
									<input type="password" name="password" autocomplete="off" class="form-control bg-transparent" />
									<!--end::Password-->
									<div class="invalid-feedback d-block">
										<?php echo form_error('password'); ?>
									</div>
								</div>

                                <div class="fv-row mb-3">
									<!--begin::Session-->
                                    <label for="session" class="form-label">Session</label>
                                    <select class="form-control bg-transparent" name="session">
										<?php foreach($academy_sessions as $academy_session) { 
										    $start_date = date('Y',  strtotime($academy_session['start'])); 
										    $end_date   = date('Y',  strtotime($academy_session['end']));
										    
										    $show_date = "";
										    
										    if($start_date == $end_date) {
										        $show_date = $start_date;
										    }
										    else {
										        $show_date = $start_date . "-" . $end_date;										    }
										    
									    ?>
											<option value="<?php echo $academy_session['id']?>"><?php echo $show_date; ?></option>
										<?php } ?>
									</select>
									<div class="invalid-feedback d-block">
										<?php echo form_error('session'); ?>
									</div>
									<!--end::Session-->
								</div>
								<!--end::Input group=-->
								<!--begin::Wrapper-->
								<div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
									<div></div>
								</div>
								<!--end::Wrapper-->
								<button class="btn btn-primary w-100" type="submit">Signin</button>
							</form>
							<!--end::Form-->
						</div>
						<!--end::Card body-->
					</div>
					<!--end::Card-->
				</div>
				<!--end::Body-->
			</div>
			<!--end::Authentication - Sign-in-->
		</div>
		<h6 class="text-light text-center">Copyright<span style="font-size: 16px;"> © </span>2023 Ignited</h6>
		<!--end::Root-->
		<!--begin::Javascript-->
		<!--begin::Global Javascript Bundle(mandatory for all pages)-->
		<script src="<?php echo base_url() ?>assets/plugins/global/plugins.bundle.js"></script>
		<script src="<?php echo base_url() ?>assets/js/scripts.bundle.js"></script>
		<!--end::Global Javascript Bundle-->
		<!--begin::Custom Javascript(used for this page only)-->
		<script src="<?php echo base_url() ?>assets/js/custom/authentication/sign-in/general.js"></script>
		<!--end::Custom Javascript-->
		<!--end::Javascript-->
	</body>
	<!--end::Body-->
</html>