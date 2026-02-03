<?php $this->load->view("inc/app_header.php"); ?>

    <div class="row mb-5">
        <div class="col-md-6">
            <h1>New Employee</h1>
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

    <form action="<?php echo base_url() ?>personnel/employee/store" method="POST" enctype="multipart/form-data">
        <div class="row mb-5">
            <div class="col-md-12 mb-5">
                <div class="card card-flush h-xl-100">
                    <div class="card-body py-9">
                        <div class="row">
                            <h2 class="mb-3">Employee Details</h2>
                        </div>

                        <div class="row justify-content-center mb-5">
                            <div class="col-md-2">
                                <img 
                                    id="img_preview" 
                                    class="border border-dark border-3 rounded-circle p-1" 
                                    style="width: 90%; display: none;"
                                    src=""
                                />
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-2">
                                <label class="col-form-label required">Employee code</label>
                            </div>
                            <div class="col-md-2">
                                <input type="text" class="form-control" name="emp_code" required value="<?php echo set_value('emp_code'); ?>">
                                <div class="invalid-feedback d-block">
                                    <?php echo form_error('emp_code');  ?>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <label class="col-form-label required">Date Of Joining</label>
                            </div>
                            <div class="col-md-2">
                                <input type="date" class="form-control" name="since" required value="<?php echo set_value('since'); ?>">
                                <div class="invalid-feedback d-block">
                                    <?php echo form_error('since');  ?>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <label class="col-form-label">Image</label>
                            </div>
                            <div class="col-md-2">
                                <input type="file" class="form-control" name="image" value="<?php echo set_value('image'); ?>" onchange="preview(event)">
                                <div class="invalid-feedback d-block">
                                    <?php echo form_error('image');  ?>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <label class="col-form-label required">First Name</label>
                            </div>
                            <div class="col-md-2">
                                <input type="text" class="form-control" name="f_name" required value="<?php echo set_value('f_name'); ?>">
                                <div class="invalid-feedback d-block">
                                    <?php echo form_error('f_name');  ?>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <label class="col-form-label">Middle Name</label>
                            </div>
                            <div class="col-md-2">
                                <input type="text" class="form-control" name="m_name" value="<?php echo set_value('m_name'); ?>">
                                <div class="invalid-feedback d-block">
                                    <?php echo form_error('m_name');  ?>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <label class="col-form-label required">Last Name</label>
                            </div>
                            <div class="col-md-2">
                                <input type="text" class="form-control" name="l_name" required value="<?php echo set_value('l_name'); ?>">
                                <div class="invalid-feedback d-block">
                                    <?php echo form_error('l_name');  ?>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <label class="col-form-label required">Sex</label>
                            </div>
                            <div class="col-md-2">
                                <select class="form-select" name="sex" required value="<?php echo set_value('sex'); ?>">
                                    <option value="">Please Select</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="other">Other</option>
                                </select>
                                <div class="invalid-feedback d-block">
                                    <?php echo form_error('sex');  ?>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <label class="col-form-label required">Date of Birth</label>
                            </div>
                            <div class="col-md-2">
                                <input type="date" class="form-control" name="dob" required value="<?php echo set_value('dob'); ?>">
                                <div class="invalid-feedback d-block">
                                    <?php echo form_error('dob');  ?>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <label class="col-form-label required">Employee Type</label>
                            </div>
                            <div class="col-md-2">
                                <select class="form-select" required name="emp_type_id" value="<?php echo set_value('emp_type_id'); ?>">
                                    <option value="">Please Select</option>
                                    <?php foreach ($employee_types as $employee_type) { ?>
                                        <option value="<?php echo $employee_type["id"] ?>"><?php echo $employee_type["name"] ?></option>
                                    <?php } ?>
                                </select>
                                <div class="invalid-feedback d-block">
                                    <?php echo form_error('emp_type_id'); ?>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <label class="col-form-label required">Department</label>
                            </div>
                            <div class="col-md-2">
                                <select class="form-select" required name="department_id" value="<?php echo set_value('department_id'); ?>">
                                    <option value="">Please Select</option>
                                    <?php foreach ($departments as $department) { ?>
                                        <option value="<?php echo $department["id"] ?>"><?php echo $department["name"] ?></option>
                                    <?php } ?>
                                </select>
                                <div class="invalid-feedback d-block">
                                    <?php echo form_error('department_id'); ?>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <label class="col-form-label required">Designation</label>
                            </div>
                            <div class="col-md-2">
                                <select class="form-select" required name="designation_id" value="<?php echo set_value('designation_id'); ?>">
                                    <option value="">Please Select</option>
                                    <?php foreach ($designations as $designation) { ?>
                                        <option value="<?php echo $designation["id"] ?>"><?php echo $designation["name"] ?></option>
                                    <?php } ?>
                                </select>
                                <div class="invalid-feedback d-block">
                                    <?php echo form_error('designation_id'); ?>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <label class="col-form-label required">Job Status</label>
                            </div>
                            <div class="col-md-2">
                                <select class="form-select" required name="job_status_id" value="<?php echo set_value('job_status_id'); ?>">
                                    <option value="">Please Select</option>
                                    <?php foreach ($job_status as $status) { ?>
                                        <option value="<?php echo $status["id"] ?>"><?php echo $status["name"] ?></option>
                                    <?php } ?>
                                </select>
                                <div class="invalid-feedback d-block">
                                    <?php echo form_error('job_status_id'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-5">
            <div class="col-md-12 mb-5">
                <div class="card card-flush h-xl-100">
                    <div class="card-body py-9">
                        <div class="row">
                            <ul class="nav nav-pills nav-justified mb-3" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link tab-button" id="pills-tab-1" data-bs-toggle="pill" data-bs-target="#tab-1" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Personal Details</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link tab-button" id="pills-tab-2" data-bs-toggle="pill" data-bs-target="#tab-2" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Local Address</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link tab-button" id="pills-tab-2" data-bs-toggle="pill" data-bs-target="#tab-3" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Permanent Address</button>
                                </li>
                            </ul>
                            
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade" id="tab-1" role="tabpanel" aria-labelledby="personal-details-tab">
                                   <h4>Personal Details</h4>
                                    <div class="row my-3">
                                        <div class="col-md-2">
                                            <label class="col-form-label required">Mobile No</label>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="text" class="form-control" name="mobile_no" required value="<?php echo set_value('mobile_no'); ?>">
                                            <div class="invalid-feedback d-block">
                                                <?php echo form_error('mobile_no');  ?>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <label class="col-form-label">Email</label>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="text" class="form-control" name="email" value="<?php echo set_value('email'); ?>">
                                            <div class="invalid-feedback d-block">
                                                <?php echo form_error('email');  ?>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <label class="col-form-label required">Category</label>
                                        </div>
                                        <div class="col-md-2">
                                            <select class="form-select" name="category_id" value="<?php echo set_value('category_id'); ?>" required>
                                                <option value="">Please Select</option>
                                                <?php foreach ($categories as $category) { ?>
                                                    <option value="<?php echo $category["id"] ?>"><?php echo $category["name"] ?></option>
                                                <?php } ?>
                                            </select>
                                            <div class="invalid-feedback d-block">
                                                <?php echo form_error('category_id'); ?>
                                            </div>
                                        </div>


                                        <div class="col-md-2">
                                            <label class="col-form-label">Father Name</label>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="text" class="form-control" name="father" value="<?php echo set_value('father'); ?>">
                                            <div class="invalid-feedback d-block">
                                                <?php echo form_error('father');  ?>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <label class="col-form-label">Mother Name</label>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="text" class="form-control" name="mother" value="<?php echo set_value('mother'); ?>">
                                            <div class="invalid-feedback d-block">
                                                <?php echo form_error('mother');  ?>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <label class="col-form-label">Marital Status</label>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="text" class="form-control" name="marital_status" value="<?php echo set_value('marital_status'); ?>">
                                            <div class="invalid-feedback d-block">
                                                <?php echo form_error('marital_status');  ?>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <label class="col-form-label">Spouse</label>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="text" class="form-control" name="spouse" value="<?php echo set_value('spouse'); ?>">
                                            <div class="invalid-feedback d-block">
                                                <?php echo form_error('spouse');  ?>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <label class="col-form-label required">Religion</label>
                                        </div>
                                        <div class="col-md-2">
                                            <select class="form-select" name="religion_id" value="<?php echo set_value('religion_id'); ?>" required>
                                                <option value="">Please Select</option>
                                                <?php foreach ($religions as $religion) { ?>
                                                    <option value="<?php echo $religion["id"] ?>"><?php echo $religion["name"] ?></option>
                                                <?php } ?>
                                            </select>
                                            <div class="invalid-feedback d-block">
                                                <?php echo form_error('religion_id'); ?>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <label class="col-form-label required">Nationality</label>
                                        </div>
                                        <div class="col-md-2">
                                            <select class="form-select" name="nationality_id" value="<?php echo set_value('nationality_id'); ?>" required>
                                                <option value="">Please Select</option>
                                                <?php foreach ($nationalities as $nationality) { ?>
                                                    <option value="<?php echo $nationality["id"] ?>"><?php echo $nationality["name"] ?></option>
                                                <?php } ?>
                                            </select>
                                            <div class="invalid-feedback d-block">
                                                <?php echo form_error('nationality_id'); ?>
                                            </div>
                                        </div>


                                        <div class="col-md-2">
                                            <label class="col-form-label">PAN No</label>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="text" class="form-control" name="pan_no" value="<?php echo set_value('pan_no'); ?>">
                                            <div class="invalid-feedback d-block">
                                                <?php echo form_error('pan_no');  ?>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <label class="col-form-label">Voter ID</label>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="text" class="form-control" name="voter_id" value="<?php echo set_value('voter_id'); ?>">
                                            <div class="invalid-feedback d-block">
                                                <?php echo form_error('voter_id');  ?>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <label class="col-form-label required">Aadhaar Card</label>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="text" class="form-control" name="aadhar_no" required value="<?php echo set_value('aadhar_no'); ?>">
                                            <div class="invalid-feedback d-block">
                                                <?php echo form_error('aadhar_no');  ?>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <label class="col-form-label">Miscellaneous</label>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="text" class="form-control" name="miscellaneous" value="<?php echo set_value('miscellaneous'); ?>">
                                            <div class="invalid-feedback d-block">
                                                <?php echo form_error('miscellaneous');  ?>
                                            </div>
                                        </div>
                                    </div> 
                                </div>

                                
                                <div class="tab-pane fade" id="tab-2" role="tabpanel" aria-labelledby="local-address-tab">
                                    <h4 class="my-3">Local Address Details</h4>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label class="col-form-label">Address</label>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="local_address" value="<?php echo set_value('local_address'); ?>">
                                            <div class="invalid-feedback d-block">
                                                <?php echo form_error('local_address');  ?>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <label class="col-form-label">Phone</label>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="local_phone" value="<?php echo set_value('local_phone'); ?>">
                                            <div class="invalid-feedback d-block">
                                                <?php echo form_error('local_phone');  ?>
                                            </div>
                                        </div>
                                    </div> 
                                </div>

                                <div class="tab-pane fade" id="tab-3" role="tabpanel" aria-labelledby="permanent-address-tab">
                                    <h4 class="my-3">Permanent Address Details</h4>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label class="col-form-label">Address</label>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="permanent_address" value="<?php echo set_value('permanent_address'); ?>">
                                            <div class="invalid-feedback d-block">
                                                <?php echo form_error('permanent_address');  ?>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <label class="col-form-label">Phone</label>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="permanent_phone" value="<?php echo set_value('permanent_phone'); ?>">
                                            <div class="invalid-feedback d-block">
                                                <?php echo form_error('permanent_phone');  ?>
                                            </div>
                                        </div>             
                                    </div> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <button type="submit" class="btn btn-success rounded rounded-pill"><i class="fa fa-plus"></i> Save</button>
    </form>

    <script>
        var preview = function(event) {
            var output = document.getElementById('img_preview');
            output.src = URL.createObjectURL(event.target.files[0]);
            output.style.display = "block";
            output.onload = function() {
            URL.revokeObjectURL(output.src) // free memory
            }
        };
    </script>

<?php $this->load->view("inc/app_footer.php"); ?>