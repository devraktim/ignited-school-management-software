<?php $this->load->view("inc/app_header.php"); ?>

    <div class="row mb-5">
    	<div class="col-md-6">
    		<h1>Users</h1>
    	</div>
    	<div class="col-md-2"></div>
    	<div class="col-md-4">
    		<?php if($this->session->flashdata('success'))  {?>
    		<div class="alert alert-success alert-dismissible">
    			<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    			<strong><?php echo $this->session->flashdata('success')?></strong>
    		</div>
    		<?php } ?>
    	</div>
    </div>

    <div class="row mb-5">
        <div class="col-md-12 mb-5">
            <div class="card card-flush h-xl-100">
                <div class="card-body py-9">
                    <div class="row">
                        <?php if(count($users) == 0) { ?>
                            <h4 class="text-center">No Users Found</h4>    
                        <?php } else { ?>
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered">
                                    <thead>
                                        <tr class="table-dark text-light">
                                            <th rowspan="2">&nbsp;</th>
                                            <th></th>
                                            <th></th>
                                            <th class="text-center" colspan="11" class="text-center">M O D U L E S</th>
                                            <th colspan="4"></th>
                                        </tr>
                                        <tr class="table-dark text-light">
                                            <th>Username</th>
                                            <th class="table-dark text-light p-3">Name</th>
                                            <th>Student</th>
                                            <th>Academics</th>
                                            <th>Fees</th>
                                            <th>Hostel</th>
                                            <th>Personnel</th>
                                            <th>Leave</th>
                                            <th>Payroll</th>
                                            <th>Library</th>
                                            <th>Inventory</th>
                                            <th>Mess</th>
                                            <th>Infirmary</th>
                                            <th>Admin</th>
                                            <th>Status</th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $sl_no = 0; foreach($users as $user) {  $sl_no++; ?>
                                            <tr>
                                                <td class="table-dark text-light p-3"><?php echo $sl_no; ?></td>
                                                <td><?php echo $user["username"] ?></td>
                                                <td><?php echo $user["f_name"] . " " . $user["m_name"] . " " . $user["l_name"]?></td>
                                                <td><?php echo $user["student_module"] ?></td>
                                                <td><?php echo $user["academics_module"] ?></td>
                                                <td><?php echo $user["fees_module"] ?></td>
                                                <td><?php echo $user["hostel_module"] ?></td>
                                                <td><?php echo $user["personnel_module"] ?></td>
                                                <td><?php echo $user["leave_module"] ?></td>
                                                <td><?php echo $user["payroll_module"] ?></td>
                                                <td><?php echo $user["library_module"] ?></td>
                                                <td><?php echo $user["inventory_module"] ?></td>
                                                <td><?php echo $user["mess_module"] ?></td>
                                                <td><?php echo $user["infirmary_module"] ?></td>
                                                <td><?php echo $user["system_administrator"] ?></td>
                                                <td><?php echo $user["status"] ?></td>
                                                
                                                <td>
                                                    <form action="<?php echo base_url() ?>reset-user-password" method="POST">
                                                        <button class="btn btn-primary btn-sm" type="button" onclick="if(confirm('Are you sure you want to reset the password? User will receive an email notification.')) { this.form.submit(); }">Reset Password</button>
                                                        <input type="text" class="d-none" name="id" value="<?php echo $user['id']; ?>" />
                                                    </form>
                                                </td>
                                                <td>
                                                    <a href="<?php echo base_url() ?>security/users/edit/<?php echo $user["employee_id"] ?>"  class="btn btn-sm btn-edit mx-1"><i class="fa fa-edit"></i></a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php $this->load->view("inc/app_footer.php"); ?>