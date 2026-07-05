<?php $this->load->view("inc/app_header.php"); ?>

<div class="row mb-5">
	<h1>Edit User Details</h1>
</div>

<form action="<?php echo base_url() ?>security/users/update" method="POST">
	<div class="row mb-5">
		<div class="col-md-6 mb-5">
			<div class="card card-flush h-xl-100">
				<div class="card-body py-9">
                    <h4 class="mb-3">User Details</h4>
					<div class="row">
                        <div class="col-md-6">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <td class="table-primary p-2" style="color: black;">Username</td>
                                            <td class="table-warning p-2" style="color: black;">
                                                <input type="text" class="form-control" name="username" required value="<?php echo $user["username"] ?>" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="table-primary p-2" style="color: black;">Employee Code</td>
                                            <td class="table-warning p-2" style="color: black;"><?php echo $user["emp_code"]?></td>
                                        </tr>
                                        <tr>
                                            <td class="table-primary p-2" style="color: black;">Department</td>
                                            <td class="table-warning p-2" style="color: black;"><?php echo $user["department"]?></td>
                                        </tr>
                                        <tr>
                                            <td class="table-primary p-2" style="color: black;">Designation</td>
                                            <td class="table-warning p-2" style="color: black;"><?php echo $user["designation"]?></td>
                                        </tr>
										<tr>
                                            <td class="table-primary p-2" style="color: black;">Active/ Inactive</td>
                                            <td class="table-warning p-2" style="color: black;">
												<select class="form-select" name="status">
													<option value="ACTIVE" <?php if("ACTIVE" == $user["status"]) {echo "selected"; }?>>Active</option>
													<option value="INACTIVE" <?php if("INACTIVE" == $user["status"]) {echo "selected"; }?>>In active</option>
												</select>
											</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-6 text-end">
                            <div class="border border-2 border-dark rounded text-center">
                                <img src="<?php echo base_url() ?>storage/employees/<?php echo $user["image"] ?>" style="width: 80%; height: 80%;" />
                            </div>
                        </div>
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
											<option value="NO ACCESS" <?php if("NO ACCESS" == $user["student_module"]) {echo "selected"; }?>>No Access</option>
											<option value="VIEWER" <?php if("VIEWER" == $user["student_module"]) {echo "selected"; }?>>Viewer</option>
											<option value="OPERATOR" <?php if("OPERATOR" == $user["student_module"]) {echo "selected"; }?>>Operator</option>
											<option value="USER" <?php if("USER" == $user["student_module"]) {echo "selected"; }?>>User</option>
											<option value="ADMIN" <?php if("ADMIN" == $user["student_module"]) {echo "selected"; }?>>Administrator</option>
										</select>
									</td>
									<td style="vertical-align: middle;">Academics Module</td>
									<td style="vertical-align: middle;">
										<select class="form-select" name="academics_module">
											<option value="NO ACCESS" <?php if("NO ACCESS" == $user["academics_module"]) {echo "selected"; }?>>No Access</option>
											<option value="VIEWER" <?php if("VIEWER" == $user["academics_module"]) {echo "selected"; }?>>Viewer</option>
											<option value="OPERATOR" <?php if("OPERATOR" == $user["academics_module"]) {echo "selected"; }?>>Operator</option>
											<option value="USER" <?php if("USER" == $user["academics_module"]) {echo "selected"; }?>>User</option>
											<option value="ADMIN" <?php if("ADMIN" == $user["academics_module"]) {echo "selected"; }?>>Administrator</option>
										</select>
									</td>
									<td style="vertical-align: middle;">Fees Module</td>
									<td style="vertical-align: middle;">
										<select class="form-select" name="fees_module">
											<option value="NO ACCESS" <?php if("NO ACCESS" == $user["fees_module"]) {echo "selected"; }?>>No Access</option>
											<option value="VIEWER" <?php if("VIEWER" == $user["fees_module"]) {echo "selected"; }?>>Viewer</option>
											<option value="OPERATOR" <?php if("OPERATOR" == $user["fees_module"]) {echo "selected"; }?>>Operator</option>
											<option value="USER" <?php if("USER" == $user["fees_module"]) {echo "selected"; }?>>User</option>
											<option value="ADMIN" <?php if("ADMIN" == $user["fees_module"]) {echo "selected"; }?>>Administrator</option>
										</select>
									</td>
									<td style="vertical-align: middle;">Hostel Module</td>
									<td style="vertical-align: middle;">
										<select class="form-select" name="hostel_module">
											<option value="NO ACCESS" <?php if("NO ACCESS" == $user["hostel_module"]) {echo "selected"; }?>>No Access</option>
											<option value="VIEWER" <?php if("VIEWER" == $user["hostel_module"]) {echo "selected"; }?>>Viewer</option>
											<option value="OPERATOR" <?php if("OPERATOR" == $user["hostel_module"]) {echo "selected"; }?>>Operator</option>
											<option value="USER" <?php if("USER" == $user["hostel_module"]) {echo "selected"; }?>>User</option>
											<option value="ADMIN" <?php if("ADMIN" == $user["hostel_module"]) {echo "selected"; }?>>Administrator</option>
										</select>
									</td>
								</tr>
								<tr>
									<td style="vertical-align: middle;">Personnel Module</td>
									<td style="vertical-align: middle;">
										<select class="form-select" name="personnel_module">
											<option value="NO ACCESS" <?php if("NO ACCESS" == $user["personnel_module"]) {echo "selected"; }?>>No Access</option>
											<option value="VIEWER" <?php if("VIEWER" == $user["personnel_module"]) {echo "selected"; }?>>Viewer</option>
											<option value="OPERATOR" <?php if("OPERATOR" == $user["personnel_module"]) {echo "selected"; }?>>Operator</option>
											<option value="USER" <?php if("USER" == $user["personnel_module"]) {echo "selected"; }?>>User</option>
											<option value="ADMIN" <?php if("ADMIN" == $user["personnel_module"]) {echo "selected"; }?>>Administrator</option>
										</select>
									</td>
									<td style="vertical-align: middle;">Leave Module</td>
									<td style="vertical-align: middle;">
										<select class="form-select" name="leave_module">
											<option value="NO ACCESS" <?php if("NO ACCESS" == $user["leave_module"]) {echo "selected"; }?>>No Access</option>
											<option value="VIEWER" <?php if("VIEWER" == $user["leave_module"]) {echo "selected"; }?>>Viewer</option>
											<option value="OPERATOR" <?php if("OPERATOR" == $user["leave_module"]) {echo "selected"; }?>>Operator</option>
											<option value="USER" <?php if("USER" == $user["leave_module"]) {echo "selected"; }?>>User</option>
											<option value="ADMIN" <?php if("ADMIN" == $user["leave_module"]) {echo "selected"; }?>>Administrator</option>
										</select>
									</td>
									<td style="vertical-align: middle;">Payroll Module</td>
									<td style="vertical-align: middle;">
										<select class="form-select" name="payroll_module">
											<option value="NO ACCESS" <?php if("NO ACCESS" == $user["payroll_module"]) {echo "selected"; }?>>No Access</option>
											<option value="VIEWER" <?php if("VIEWER" == $user["payroll_module"]) {echo "selected"; }?>>Viewer</option>
											<option value="OPERATOR" <?php if("OPERATOR" == $user["payroll_module"]) {echo "selected"; }?>>Operator</option>
											<option value="USER" <?php if("USER" == $user["payroll_module"]) {echo "selected"; }?>>User</option>
											<option value="ADMIN" <?php if("ADMIN" == $user["payroll_module"]) {echo "selected"; }?>>Administrator</option>
										</select>
									</td>
									<td style="vertical-align: middle;">Library Module</td>
									<td style="vertical-align: middle;">
										<select class="form-select" name="library_module">
											<option value="NO ACCESS" <?php if("NO ACCESS" == $user["library_module"]) {echo "selected"; }?>>No Access</option>
											<option value="VIEWER" <?php if("VIEWER" == $user["library_module"]) {echo "selected"; }?>>Viewer</option>
											<option value="OPERATOR" <?php if("OPERATOR" == $user["library_module"]) {echo "selected"; }?>>Operator</option>
											<option value="USER" <?php if("USER" == $user["library_module"]) {echo "selected"; }?>>User</option>
											<option value="ADMIN" <?php if("ADMIN" == $user["library_module"]) {echo "selected"; }?>>Administrator</option>
										</select>
									</td>
								</tr>
								<tr>
									<td style="vertical-align: middle;">Inventory Module</td>
									<td style="vertical-align: middle;">
										<select class="form-select" name="inventory_module">
											<option value="NO ACCESS" <?php if("NO ACCESS" == $user["inventory_module"]) {echo "selected"; }?>>No Access</option>
											<option value="VIEWER" <?php if("VIEWER" == $user["inventory_module"]) {echo "selected"; }?>>Viewer</option>
											<option value="OPERATOR" <?php if("OPERATOR" == $user["inventory_module"]) {echo "selected"; }?>>Operator</option>
											<option value="USER" <?php if("USER" == $user["inventory_module"]) {echo "selected"; }?>>User</option>
											<option value="ADMIN" <?php if("ADMIN" == $user["inventory_module"]) {echo "selected"; }?>>Administrator</option>
										</select>
									</td>
									<td style="vertical-align: middle;">Mess Module</td>
									<td style="vertical-align: middle;">
										<select class="form-select" name="mess_module">
											<option value="NO ACCESS" <?php if("NO ACCESS" == $user["mess_module"]) {echo "selected"; }?>>No Access</option>
											<option value="VIEWER" <?php if("VIEWER" == $user["mess_module"]) {echo "selected"; }?>>Viewer</option>
											<option value="OPERATOR" <?php if("OPERATOR" == $user["mess_module"]) {echo "selected"; }?>>Operator</option>
											<option value="USER" <?php if("USER" == $user["mess_module"]) {echo "selected"; }?>>User</option>
											<option value="ADMIN" <?php if("ADMIN" == $user["mess_module"]) {echo "selected"; }?>>Administrator</option>
										</select>
									</td>
									<td style="vertical-align: middle;">Infirmary Module</td>
									<td style="vertical-align: middle;">
										<select class="form-select" name="infirmary_module">
											<option value="NO ACCESS" <?php if("NO ACCESS" == $user["infirmary_module"]) {echo "selected"; }?>>No Access</option>
											<option value="VIEWER" <?php if("VIEWER" == $user["infirmary_module"]) {echo "selected"; }?>>Viewer</option>
											<option value="OPERATOR" <?php if("OPERATOR" == $user["infirmary_module"]) {echo "selected"; }?>>Operator</option>
											<option value="USER" <?php if("USER" == $user["infirmary_module"]) {echo "selected"; }?>>User</option>
											<option value="ADMIN" <?php if("ADMIN" == $user["infirmary_module"]) {echo "selected"; }?>>Administrator</option>
										</select></td>
									<td style="vertical-align: middle;">System Administrator</td>
									<td style="vertical-align: middle;">
										<select class="form-select" name="system_administrator">
											<option value="NO" <?php if("NO" == $user["system_administrator"]) {echo "selected"; }?>>No</option>
											<option value="YES" <?php if("YES" == $user["system_administrator"]) {echo "selected"; }?>>Yes</option>
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
    <input type="text" class="d-none" name="employee_id" value="<?php echo $user["employee_id"] ?>" />
	<input type="text" class="d-none" name="user_id" value="<?php echo $user["user_id"] ?>" />
	<button type="submit" class="btn btn-success rounded rounded-pill"><i class="fa fa-plus"></i> Save</button>
</form>


<?php $this->load->view("inc/app_footer.php"); ?>
