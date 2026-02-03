<?php $this->load->view("inc/app_header.php"); ?>

<div class="row mb-5">
	<div class="col-md-6">
		<h1>New User</h1>
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

<form action="<?php echo base_url() ?>security/users/store" method="POST" enctype="multipart/form-data">
	<div class="row mb-5">
		<div class="col-md-6 mb-5">
			<div class="card card-flush h-xl-100">
				<div class="card-body py-9">
					<h4 class="mb-3">Create User</h4>
					<div class="form-group">
						<label class="form-label">Select Employee</label>
						<select class="form-select" name="employee_id" id="employee" data-live-search="true" onchange="loadData()">
							<option value="">Please Select</option>
							<?php foreach($employees as $employee) { ?>
								<option value="<?php echo $employee["id"] ?>"><?php echo $employee["f_name"] . " " . $employee["m_name"] . " " . $employee["l_name"] ?></option>
							<?php } ?>
						</select>
					</div>

					<div class="row justify-content-center align-items-center mt-5" id="loader" style="display: none;">
						<div class="text-center">
							<div class="spinner-border text-info" style="width: 3rem; height: 3rem; border-width: 4px;" role="status">
								<span class="visually-hidden">Loading...</span>
							</div>
						</div>
					</div>

					<div class="row justify-content-center align-items-center px-2 mt-5" id="data">

					</div>	
				</div>
			</div>
		</div>

		<div class="col-md-6 mb-5">
			<div class="card card-flush h-xl-100">
				<div class="card-body py-9">
					<h4 class="mb-3">Privilege Details</h4>

					<div class="table-responsive">
						<table class="table table-bordered">
							<tbody>
								<tr>
									<td class="table-primary p-2" style="color: black;">Viewer</td>
									<td class="table-warning" style="color: black;">Can View Records and Reports</td>
								</tr>
								<tr>
									<td class="table-primary p-2" style="color: black;">Operator
									</td>
									<td class="table-warning" style="color: black;">Can Add Records. <br>Cannot Edit Or Delete Records or
										Change Settings</td>
								</tr>
								<tr>
									<td class="table-primary p-2" style="color: black;">User</td>
									<td class="table-warning" style="color: black;">Can Add and Edit Records. <br>Cannot Delete Records or
										Change Settings</td>
								</tr>
								<tr>
									<td class="table-primary p-2" style="color: black;">Administrator</td>
									<td class="table-warning" style="color: black;">Has Full Control Over the Module</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>

		<div class="col-md-12 mb-5">
			<div class="card card-flush h-xl-100">
				<div class="card-body py-9">
					<h4 class="mb-3">Privileges</h4>
					<div class="table-responsive">
						<table class="table tabele-bordered">
							<tbody>
								<tr>
									<td style="vertical-align: middle;">Student Module</td>
									<td style="vertical-align: middle;">
										<select class="form-select" name="student_module">
											<option value="NO ACCESS">No Access</option>
											<option value="VIEWER">Viewer</option>
											<option value="OPERATOR">Operator</option>
											<option value="USER">User</option>
											<option value="ADMIN">Administrator</option>
										</select>
									</td>
									<td style="vertical-align: middle;">Academics Module</td>
									<td style="vertical-align: middle;">
										<select class="form-select" name="academics_module">
											<option value="NO ACCESS">No Access</option>
											<option value="VIEWER">Viewer</option>
											<option value="OPERATOR">Operator</option>
											<option value="USER">User</option>
											<option value="ADMIN">Administrator</option>
										</select>
									</td>
									<td style="vertical-align: middle;">Fees Module</td>
									<td style="vertical-align: middle;">
										<select class="form-select" name="fees_module">
											<option value="NO ACCESS">No Access</option>
											<option value="VIEWER">Viewer</option>
											<option value="OPERATOR">Operator</option>
											<option value="USER">User</option>
											<option value="ADMIN">Administrator</option>
										</select>
									</td>
									<td style="vertical-align: middle;">Hostel Module</td>
									<td style="vertical-align: middle;">
										<select class="form-select" name="hostel_module">
											<option value="NO ACCESS">No Access</option>
											<option value="VIEWER">Viewer</option>
											<option value="OPERATOR">Operator</option>
											<option value="USER">User</option>
											<option value="ADMIN">Administrator</option>
										</select>
									</td>
								</tr>
								<tr>
									<td style="vertical-align: middle;">Personnel Module</td>
									<td style="vertical-align: middle;">
										<select class="form-select" name="personnel_module">
											<option value="NO ACCESS">No Access</option>
											<option value="VIEWER">Viewer</option>
											<option value="OPERATOR">Operator</option>
											<option value="USER">User</option>
											<option value="ADMIN">Administrator</option>
										</select>
									</td>
									<td style="vertical-align: middle;">Leave Module</td>
									<td style="vertical-align: middle;">
										<select class="form-select" name="leave_module">
											<option value="NO ACCESS">No Access</option>
											<option value="VIEWER">Viewer</option>
											<option value="OPERATOR">Operator</option>
											<option value="USER">User</option>
											<option value="ADMIN">Administrator</option>
										</select>
									</td>
									<td style="vertical-align: middle;">Payroll Module</td>
									<td style="vertical-align: middle;">
										<select class="form-select" name="payroll_module">
											<option value="NO ACCESS">No Access</option>
											<option value="VIEWER">Viewer</option>
											<option value="OPERATOR">Operator</option>
											<option value="USER">User</option>
											<option value="ADMIN">Administrator</option>
										</select>
									</td>
									<td style="vertical-align: middle;">Library Module</td>
									<td style="vertical-align: middle;">
										<select class="form-select" name="library_module">
											<option value="NO ACCESS">No Access</option>
											<option value="VIEWER">Viewer</option>
											<option value="OPERATOR">Operator</option>
											<option value="USER">User</option>
											<option value="ADMIN">Administrator</option>
										</select>
									</td>
								</tr>
								<tr>
									<td style="vertical-align: middle;">Inventory Module</td>
									<td style="vertical-align: middle;">
										<select class="form-select" name="inventory_module">
											<option value="NO ACCESS">No Access</option>
											<option value="VIEWER">Viewer</option>
											<option value="OPERATOR">Operator</option>
											<option value="USER">User</option>
											<option value="ADMIN">Administrator</option>
										</select>
									</td>
									<td style="vertical-align: middle;">Mess Module</td>
									<td style="vertical-align: middle;">
										<select class="form-select" name="mess_module">
											<option value="NO ACCESS">No Access</option>
											<option value="VIEWER">Viewer</option>
											<option value="OPERATOR">Operator</option>
											<option value="USER">User</option>
											<option value="ADMIN">Administrator</option>
										</select>
									</td>
									<td style="vertical-align: middle;">Infirmary Module</td>
									<td style="vertical-align: middle;">
										<select class="form-select" name="infirmary_module">
											<option value="NO ACCESS">No Access</option>
											<option value="VIEWER">Viewer</option>
											<option value="OPERATOR">Operator</option>
											<option value="USER">User</option>
											<option value="ADMIN">Administrator</option>
										</select></td>
									<td style="vertical-align: middle;">System Administrator</td>
									<td style="vertical-align: middle;">
										<select class="form-select" name="system_administrator">
											<option value="NO">No</option>
											<option value="YES">Yes</option>
										</select>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<button type="submit" class="btn btn-success rounded rounded-pill"><i class="fa fa-plus"></i> Save</button>
</form>

<script>
	function loadData () {
		const id = document.getElementById('employee').value;
		
		$("#loader").show()
		$("#data").empty()
		
		fetch(`<?php echo base_url() ?>security/users/show/${id}`)
		.then(response => response.json())
		.then(data => {
			const {employee} = data;
			$("#loader").hide()
			$("#data").append(`
				<div class="col-md-12">
				<div class="table-responsive">
					<table class="table table-bordered">
						<tbody>
							<tr>
								<td class="table-primary p-2" style="color: black;">Username</td>
								<td class="table-warning p-2" style="color: black;">
									<input type="text" class="form-control" name="username" minlength="1" maxlength="20" required />
								</td>
							</tr>
							<tr>
								<td class="table-primary p-2" style="color: black;">Employee Code</td>
								<td class="table-warning p-2" style="color: black;">${employee.emp_code}</td>
							</tr>
							<tr>
								<td class="table-primary p-2" style="color: black;">Department</td>
								<td class="table-warning p-2" style="color: black;">${employee.department}</td>
							</tr>
							<tr>
								<td class="table-primary p-2" style="color: black;">Designation</td>
								<td class="table-warning p-2" style="color: black;">${employee.designation}</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="col-md-6 text-end">
				<div class="border border-2 border-dark rounded text-center">
					<img src="<?php echo base_url() ?>storage/employees/${employee.image}" style="width: 80%; height: 80%;" />
				</div>
			</div>`)
		})
		.catch(console.log)
	}

</script>

<?php $this->load->view("inc/app_footer.php"); ?>
