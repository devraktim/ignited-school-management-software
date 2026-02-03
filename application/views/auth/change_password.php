<?php $this->load->view("inc/app_header.php"); ?>

<div class="row mb-5">
	<div class="col-md-6">
		<h1>Change Password</h1>
	</div>
	<div class="col-md-2"></div>
	<div class="col-md-4 text-center">
		<?php if($this->session->flashdata('success'))  {?>
		<div class="alert alert-success alert-dismissible">
			<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
			<strong><?php echo $this->session->flashdata('success')?></strong>
		</div>
		<?php } ?>
	</div>
</div>

<form action="<?php echo base_url() ?>change-password" method="POST" id="form" enctype="multipart/form-data">
	<div class="row justify-content-center align-items-center h-100">
		<div class="col-md-6 mb-5">
			<div class="card card-flush h-xl-100">
				<div class="card-body py-9">
					<div class="row justify-content-center align-items-center">
						<?php if($this->session->user['image']) { ?>
							<img src="<?php echo base_url('storage/employees/') . $this->session->user['image'] ?>" class="border border-dark border-3 rounded-circle p-1" style="width: 200px;">
						<?php } else {?>
							<img src="<?php echo base_url('assets/media/avatar/') ?><?php echo $this->session->user['sex'] == 'male' ? 'male.jpg' : 'female.jpg' ?>" style="width: 200px;">
						<?php } ?>
					</div>	
					<div class="row">
						<div class="form-group">
							<label class="form-label">New Password</label>
							<input type="password" id="password" name="password" class="form-control" require />
						</div>
						<div class="form-group mt-5">
							<label class="form-label">Confirm Password</label>
							<input type="password" id="confirm_password" name="confirm_password" class="form-control" onkeydown="typing()" require />
							<div class="invalid-feedback d-block" id="confirm_password_error_block"></div>
						</div>
						<div class="form-group mt-5">
							<button type="submit" class="btn btn-success rounded rounded-pill" onclick="match_password(event)"><i class="fa fa-plus"></i> Save</button>
						</div>
					</div>	
				</div>
			</div>
		</div>
	</div>
</form>

<script>
	function match_password(event) {
		event.preventDefault();
		if($("#password").val() == $("#confirm_password").val()) {
			$("#form").submit();
		}
		else {
			$("#confirm_password_error_block").append("Passwords doesn't matched!")
		}
	}

	function typing() {
		$("#confirm_password_error_block").empty();
	}
</script>



<?php $this->load->view("inc/app_footer.php"); ?>
