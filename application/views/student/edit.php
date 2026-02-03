<?php $this->load->view("inc/app_header.php"); ?>

    <div class="row mb-5">
        <div class="col-md-6">
            <h1>Edit Student Record</h1>
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

    <form action="<?php echo base_url() ?>students/update" method="POST" enctype="multipart/form-data">
        <div class="row mb-5">
            <div class="col-md-12 mb-5">
                <div class="card card-flush h-xl-100">
                    <div class="card-body py-9">
                        <div class="row">
                            <h2 class="mb-3">Student Details</h2>
                        </div>
                        
                        <div class="row justify-content-center">
                            <div class="col-md-2">
                                <img 
                                    id="img_preview" 
                                    class="border border-dark border-3 rounded-circle p-1" 
                                    style="width: 90%; opacity: <?php echo $student['status'] == "ACTIVE" ? '1' : '0.3' ?>"
                                    src="<?php 
                                        if($student["image"]) { 
                                            echo base_url('storage/students/') . $student['image'];
                                        } else { 
                                            echo base_url('assets/media/avatar/') ?><?php echo $student['sex'] == 'male' ? 'male.jpg' : 'female.jpg';
                                        }?>"
                                />
                            </div>
                        </div>

                        <div class="row g-3 mb-3 align-items-center">
                            <div class="col-md-6">
                                <p><span class="text-danger font-weight-bold" style="font-size: 18px;">*</span> mark are require field</p>
                            </div>
                            <div class="col-md-2"></div>
                            <div class="col-md-2">
                                <label class="col-form-label">Student image</label>
                            </div>
                            <div class="col-md-2">
                                <input type="file" class="form-control" name="image" onchange="preview(event)">
                            </div>
                        </div>

                        <div class="row g-3 mb-3 align-items-center">
                            <div class="col-md-2">
                                <label class="col-form-label required">Student No</label>
                            </div>
                            <div class="col-md-2">
                                <input type="text" class="form-control" name="student_no" required value="<?php if(isset($student)) {echo $student['student_no'];} else {echo set_value('student_no'); }?>" readonly >
                                <div class="invalid-feedback d-block">
                                    <?php echo form_error('student_no');  ?>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label class="col-form-label">Roll No</label>
                            </div>
                            <div class="col-md-2">
                                <input type="text" class="form-control" name="roll_no" value="<?php if(isset($student)) {echo $student['roll_no'];} else {echo set_value('roll_no'); }?>">
                                <div class="invalid-feedback d-block">
                                    <?php echo form_error('roll_no'); ?>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label class="col-form-label required">Class of Admission</label>
                            </div>
                            <div class="col-md-2">
                                <select class="form-select" id="class_of_admission" name="class_of_admission" required>
                                    <option value="">Please Select</option>
                                    <?php foreach ($classes as $class) { ?>
                                        <option value="<?php echo $class["id"] ?>" <?php if(isset($student) && $student['class_of_admission'] == $class['id']) {echo "selected";} else {echo set_select('class_of_admission', $class['id']); }?>><?php echo $class["name"] ?></option>
                                    <?php } ?>
                                </select>
                                <div class="invalid-feedback d-block">
                                    <?php echo form_error('class_of_admission'); ?>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label class="col-form-label required">Date of Admission</label>
                            </div>
                            <div class="col-md-2">
                                <input type="date" class="form-control" name="admission_date" required value="<?php if(isset($student)) {echo $student['admission_date'];} else {echo set_value('admission_date'); }?>">
                                <div class="invalid-feedback d-block">
                                    <?php echo form_error('admission_date'); ?>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <label class="col-form-label required">First Name</label>
                            </div>
                            <div class="col-md-2">
                                <input type="text" class="form-control" name="f_name" required value="<?php if(isset($student)) {echo $student['f_name'];} else {echo set_value('f_name'); }?>">
                                <div class="invalid-feedback d-block">
                                    <?php echo form_error('f_name'); ?>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label class="col-form-label">Middle Name</label>
                            </div>
                            <div class="col-md-2">
                                <input type="text" class="form-control" name="m_name" value="<?php if(isset($student)) {echo $student['m_name'];} else {echo set_value('m_name'); }?>">
                                <div class="invalid-feedback d-block">
                                    <?php echo form_error('m_name'); ?>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label class="col-form-label">Last Name</label>
                            </div>
                            <div class="col-md-2">
                                <input type="text" class="form-control" name="l_name" value="<?php if(isset($student)) {echo $student['l_name'];} else {echo set_value('l_name'); }?>">
                                <div class="invalid-feedback d-block">
                                    <?php echo form_error('l_name'); ?>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <label class="col-form-label required">Sex</label>
                            </div>
                            <div class="col-md-2">
                                <select class="form-select" name="sex" required>
                                    <option value="">Please Select</option>
                                    <option value="male" <?php if(isset($student) && $student['sex'] == "male") {echo "selected";} else {echo set_select('sex', 'male'); }?>>Male</option>
                                    <option value="female" <?php if(isset($student) && $student['sex'] == "female") {echo "selected";} else {echo set_select('sex', 'female'); }?>>Female</option>
                                    <option value="other" <?php if(isset($student) && $student['sex'] == "other") {echo "selected";} else {echo set_select('sex', 'other'); }?>>Other</option>
                                </select>
                                <div class="invalid-feedback d-block">
                                    <?php echo form_error('sex'); ?>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label class="col-form-label required">Date Of Birth</label>
                            </div>
                            <div class="col-md-2">
                                <input type="date" class="form-control" name="dob" required value="<?php if(isset($student)) {echo $student['dob'];} else {echo set_value('dob'); }?>">
                                <div class="invalid-feedback d-block">
                                    <?php echo form_error('dob'); ?>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label class="col-form-label">Blood Group</label>
                            </div>
                            <div class="col-md-2">
                                <input type="text" class="form-control" name="blood_group" value="<?php if(isset($student)) {echo $student['blood_group'];} else {echo set_value('blood_group'); }?>">
                                <div class="invalid-feedback d-block">
                                    <?php echo form_error('blood_group'); ?>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <label class="col-form-label required">House</label>
                            </div>
                            <div class="col-md-2">
                                <select class="form-select" required name="house_id">
                                    <option value="">Please Select</option>
                                    <?php foreach ($houses as $house) { ?>
                                        <option value="<?php echo $house["id"] ?>" <?php if(isset($student) && $student['house_id'] == $house['id']) {echo "selected";} else {echo set_select('house_id', $house['id']); }?>><?php echo $house["name"] ?></option>
                                    <?php } ?>
                                </select>
                                <div class="invalid-feedback d-block">
                                    <?php echo form_error('house_id'); ?>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label class="col-form-label required">Category</label>
                            </div>
                            <div class="col-md-2">
                                <select class="form-select" name="category_id" required>
                                    <option value="">Please Select</option>
                                    <?php foreach ($categories as $category) { ?>
                                        <option value="<?php echo $category["id"] ?>" <?php if(isset($student) && $student['category_id'] == $category['id']) {echo "selected";} else {echo set_select('category_id', $category['id']); }?>><?php echo $category["name"] ?></option>
                                    <?php } ?>
                                </select>
                                <div class="invalid-feedback d-block">
                                    <?php echo form_error('category_id'); ?>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label class="col-form-label required">Student Type</label>
                            </div>
                            <div class="col-md-2">
                                <select class="form-select" name="student_type_id" required>
                                    <option value="">Please Select</option>
                                    <?php foreach ($student_types as $type) { ?>
                                        <option value="<?php echo $type["id"] ?>" <?php if(isset($student) && $student['student_type_id'] == $type['id']) {echo "selected";} else {echo set_select('student_type_id', $type['id']); }?>><?php echo $type["name"] ?></option>
                                    <?php } ?>
                                </select>
                                <div class="invalid-feedback d-block">
                                    <?php echo form_error('student_type_id'); ?>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label class="col-form-label required">Religion</label>
                            </div>
                            <div class="col-md-2">
                                <select class="form-select" name="religion_id" required>
                                    <option value="">Please Select</option>
                                    <?php foreach ($religions as $religion) { ?>
                                        <option value="<?php echo $religion["id"] ?>" <?php if(isset($student) && $student['religion_id'] == $religion['id']) {echo "selected";} else {echo set_select('religion_id', $religion['id']); }?>><?php echo $religion["name"] ?></option>
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
                                <select class="form-select" name="nationality_id" required>
                                    <option value="">Please Select</option>
                                    <?php foreach ($nationalities as $nationality) { ?>
                                        <option value="<?php echo $nationality["id"] ?>" <?php if(isset($student) && $student['nationality_id'] == $nationality['id']) {echo "selected";} else {echo set_select('nationality_id', $nationality['id']); }?>><?php echo $nationality["name"] ?></option>
                                    <?php } ?>
                                </select>
                                <div class="invalid-feedback d-block">
                                    <?php echo form_error('nationality_id'); ?>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label class="col-form-label required">State</label>
                            </div>
                            <div class="col-md-2">
                                <select class="form-select" name="state_id" required>
                                    <option value="">Please Select</option>
                                    <?php foreach ($states as $state) { ?>
                                        <option value="<?php echo $state["id"] ?>" <?php if(isset($student) && $student['state_id'] == $state['id']) {echo "selected";} else {echo set_select('state_id', $state['id']); }?>><?php echo $state["name"] ?></option>
                                    <?php } ?>
                                </select>
                                <div class="invalid-feedback d-block">
                                    <?php echo form_error('state_id'); ?>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label class="col-form-label">Medical Status</label>
                            </div>
                            <div class="col-md-2">
                                <select class="form-select" name="medical_status">
                                    <option value="">Please Select</option>
                                    <option value="fit" <?php if(isset($student) && $student['medical_status'] == "fit") {echo "selected";} else {echo set_select('medical_status', 'fit'); }?>>Fit</option>
                                    <option value="differently_abled" <?php if(isset($student) && $student['medical_status'] == "differently_abled") {echo "selected";} else {echo set_select('medical_status', 'differently_abled'); }?>>Differently Abled</option>
                                </select>
                                <div class="invalid-feedback d-block">
                                    <?php echo form_error('medical_status'); ?>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label class="col-form-label required">Class</label>
                            </div>
                            <div class="col-md-2">
                                <select class="form-select" id="class_id" name="class_id" required>
                                    <option value="">Please Select</option>
                                    <?php foreach ($classes as $class) { ?>
                                        <option value="<?php echo $class["id"] ?>" <?php if(isset($student) && $student['class_id'] == $class['id']) {echo "selected";} else {echo set_select('class_id', $class['id']); }?>><?php echo $class["name"] ?></option>
                                    <?php } ?>
                                </select>
                                <div class="invalid-feedback d-block">
                                    <?php echo form_error('class_id'); ?>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label class="col-form-label required">Section</label>
                            </div>
                            <div class="col-md-2">
                                <select class="form-select" id="section_id" name="section_id" required>
                                    <option value="">Please Select</option>
                                    <?php foreach ($sections as $section) { ?>
                                        <option value="<?php echo $section["id"] ?>" <?php if(isset($student) && $student['section_id'] == $section['id']) {echo "selected";} else {echo set_select('section_id', $section['id']); }?>><?php echo $section["name"] ?></option>
                                    <?php } ?>
                                </select>
                                <div class="invalid-feedback d-block">
                                    <?php echo form_error('section_id'); ?>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <label class="col-form-label">SSID</label>
                            </div>
                            <div class="col-md-2">
                                <input type="text" class="form-control" name="ssid" value="<?php if(isset($student)) {echo $student['ssid'];} else {echo set_value('ssid'); }?>">
                                <div class="invalid-feedback d-block">
                                    <?php echo form_error('ssid'); ?>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <label class="col-form-label required">Phone</label>
                            </div>
                            <div class="col-md-2">
                                <input type="text" class="form-control" name="phone" required value="<?php if(isset($student)) {echo $student['phone'];} else {echo set_value('phone'); }?>">
                                <div class="invalid-feedback d-block">
                                    <?php echo form_error('phone'); ?>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <label class="col-form-label">Email</label>
                            </div>
                            <div class="col-md-2">
                                <input type="text" class="form-control" name="email" value="<?php if(isset($student)) {echo $student['email'];} else {echo set_value('email'); }?>">
                                <div class="invalid-feedback d-block">
                                    <?php echo form_error('email'); ?>
                                </div>
                            </div>
                            
                            <div class="col-md-2">
                                <label class="col-form-label">Board Registration No.</label>
                            </div>
                            <div class="col-md-2">
                                <input type="text" class="form-control" name="board_registration_no" value="<?php if(isset($student)) {echo $student['board_registration_no'];} else {echo set_value('board_registration_no'); }?>">
                                <div class="invalid-feedback d-block">
                                    <?php echo form_error('board_registration_no'); ?>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <label class="col-form-label">Aadhaar Card No.</label>
                            </div>
                            <div class="col-md-2">
                                <input type="text" class="form-control" name="aadhaar_no" value="<?php if(isset($student)) {echo $student['aadhaar_no'];} else {echo set_value('aadhaar_no'); }?>">
                                <div class="invalid-feedback d-block">
                                    <?php echo form_error('aadhaar_no'); ?>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <label class="col-form-label">Passport No.</label>
                            </div>
                            <div class="col-md-2">
                                <input type="text" class="form-control" name="passport_no" value="<?php if(isset($student)) {echo $student['passport_no'];} else {echo set_value('passport_no'); }?>">
                                <div class="invalid-feedback d-block">
                                    <?php echo form_error('passport_no'); ?>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <label class="col-form-label">Passport Date of Issue</label>
                            </div>
                            <div class="col-md-2">
                                <input type="date" class="form-control" name="passport_date_of_issue" value="<?php if(isset($student)) {echo $student['passport_date_of_issue'];} else {echo set_value('passport_date_of_issue'); }?>">
                                <div class="invalid-feedback d-block">
                                    <?php echo form_error('passport_date_of_issue'); ?>
                                </div>
                            </div>


                            <div class="col-md-2">
                                <label class="col-form-label">Passport Valid From</label>
                            </div>
                            <div class="col-md-2">
                                <input type="date" class="form-control" name="passport_valid_from" value="<?php if(isset($student)) {echo $student['passport_valid_from'];} else {echo set_value('passport_valid_from'); }?>">
                                <div class="invalid-feedback d-block">
                                    <?php echo form_error('passport_valid_from'); ?>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <label class="col-form-label">Passport Valid To</label>
                            </div>
                            <div class="col-md-2">
                                <input type="date" class="form-control" name="passport_valid_to" value="<?php if(isset($student)) {echo $student['passport_valid_to'];} else {echo set_value('passport_valid_to'); }?>">
                                <div class="invalid-feedback d-block">
                                    <?php echo form_error('passport_valid_to'); ?>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <label class="col-form-label">Status</label>
                            </div>
                            <div class="col-md-2">
                                <select class="form-select" name="status">
                                    <option value="ACTIVE"   <?php if($student['status'] == "ACTIVE") {echo "selected";} ?>>Active</option>
                                    <option value="INACTIVE" <?php if($student['status'] == "INACTIVE") {echo "selected";} ?>>Inactive</option>
                                </select>
                                <div class="invalid-feedback d-block">
                                    <?php echo form_error('status'); ?>
                                </div>
                            </div>
                            
                        </div>

                    </div>
                </div>
            </div>
        <div>
        
        <div class="row">
            <div class="col-md-12 mb-5">
                <div class="card card-flush h-xl-100">
                    <div class="card-body py-9">
                        <ul class="nav nav-pills nav-justified mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link tab-button" id="pills-tab-1" data-bs-toggle="pill" data-bs-target="#tab-1" type="button" role="tab" aria-controls="pills-home" aria-selected="false">Family Details</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link tab-button" id="pills-tab-2" data-bs-toggle="pill" data-bs-target="#tab-2" type="button" role="tab" aria-controls="pills-fees" aria-selected="false">Address</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link tab-button" id="pills-tab-3" data-bs-toggle="pill" data-bs-target="#tab-3" type="button" role="tab" aria-controls="pills-family" aria-selected="false">Local Guardian</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link tab-button" id="pills-tab-4" data-bs-toggle="pill" data-bs-target="#tab-4" type="button" role="tab" aria-controls="pills-curricular" aria-selected="false">Previous School Details</button>
                            </li>
                        </ul>

                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade" id="tab-1" role="tabpanel">
                                <h2 class="mb-3">Family Details</h2>
                                <div class="table-responsive">
                                    <table class="table table-borderd">
                                        <thead class="table-dark text-center">
                                            <tr>
                                                <th></th>
                                                <th>Father</th>
                                                <th>Mother</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <label class="form-label">Name</label>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="father_name" value="<?php if(isset($student)) {echo $student['father_name'];} else {echo set_value('father_name'); }?>">
                                                    <div class="invalid-feedback d-block">
                                                        <?php echo form_error('father_name'); ?>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="mother_name" value="<?php if(isset($student)) {echo $student['mother_name'];} else {echo set_value('mother_name'); }?>">
                                                    <div class="invalid-feedback d-block">
                                                        <?php echo form_error('mother_name'); ?>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label class="form-label">Employee Code</label>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="father_emp_no" value="<?php if(isset($student)) {echo $student['father_emp_no'];} else {echo set_value('father_emp_no'); }?>">
                                                    <div class="invalid-feedback d-block">
                                                        <?php echo form_error('father_emp_no'); ?>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="mother_emp_no" value="<?php if(isset($student)) {echo $student['mother_emp_no'];} else {echo set_value('mother_emp_no'); }?>">
                                                    <div class="invalid-feedback d-block">
                                                        <?php echo form_error('mother_emp_no'); ?>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label class="form-label">School Staff</label>    
                                                </td>
                                                <td>
                                                    <select class="form-select" name="father_school_stuff" value="<?php if(isset($student)) {echo $student['father_school_stuff'];} else {echo set_value('father_school_stuff'); }?>">
                                                        <option value="">Please Select</option>
                                                        <option value="1" <?php if(isset($student) && $student['father_school_stuff'] == "1") {echo "selected";} else {echo set_select('father_school_stuff', '1'); }?>>Yes</option>
                                                        <option value="0" <?php if(isset($student) && $student['father_school_stuff'] == "0") {echo "selected";} else {echo set_select('father_school_stuff', '0'); }?>>No</option>
                                                    </select>
                                                    <div class="invalid-feedback d-block">
                                                        <?php echo form_error('father_school_stuff'); ?>
                                                    </div>
                                                </td>
                                                <td>
                                                    <select class="form-select" name="mother_school_stuff" value="<?php if(isset($student)) {echo $student['mother_school_stuff'];} else {echo set_value('mother_school_stuff'); }?>">
                                                        <option value="">Please Select</option>
                                                        <option value="1" <?php if(isset($student) && $student['mother_school_stuff'] == "1") {echo "selected";} else {echo set_select('mother_school_stuff', '1'); }?>>Yes</option>
                                                        <option value="0" <?php if(isset($student) && $student['mother_school_stuff'] == "0") {echo "selected";} else {echo set_select('mother_school_stuff', '0'); }?>>No</option>
                                                    </select>
                                                    <div class="invalid-feedback d-block">
                                                        <?php echo form_error('mother_school_stuff'); ?>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label class="form-label">Profession</label>    
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="father_profession" value="<?php if(isset($student)) {echo $student['father_profession'];} else {echo set_value('father_profession'); }?>">
                                                    <div class="invalid-feedback d-block">
                                                        <?php echo form_error('father_profession'); ?>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="mother_profession" value="<?php if(isset($student)) {echo $student['mother_profession'];} else {echo set_value('mother_profession'); }?>">
                                                    <div class="invalid-feedback d-block">
                                                        <?php echo form_error('mother_profession'); ?>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label class="form-label">Education</label>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="father_education" value="<?php if(isset($student)) {echo $student['father_education'];} else {echo set_value('father_education'); }?>">
                                                    <div class="invalid-feedback d-block">
                                                        <?php echo form_error('father_education'); ?>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="mother_education" value="<?php if(isset($student)) {echo $student['mother_education'];} else {echo set_value('mother_education'); }?>">
                                                    <div class="invalid-feedback d-block">
                                                        <?php echo form_error('mother_education'); ?>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label class="form-label">Year of Passing</label>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="father_year_of_passing" value="<?php if(isset($student)) {echo $student['father_year_of_passing'];} else {echo set_value('father_year_of_passing'); }?>">
                                                    <div class="invalid-feedback d-block">
                                                        <?php echo form_error('father_year_of_passing'); ?>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="mother_year_of_passing" value="<?php if(isset($student)) {echo $student['mother_year_of_passing'];} else {echo set_value('mother_year_of_passing'); }?>">
                                                    <div class="invalid-feedback d-block">
                                                        <?php echo form_error('mother_year_of_passing'); ?>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label class="form-label">Board</label>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="father_board" value="<?php if(isset($student)) {echo $student['father_board'];} else {echo set_value('father_board'); }?>">
                                                    <div class="invalid-feedback d-block">
                                                        <?php echo form_error('father_board'); ?>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="mother_board" value="<?php if(isset($student)) {echo $student['mother_board'];} else {echo set_value('mother_board'); }?>">
                                                    <div class="invalid-feedback d-block">
                                                        <?php echo form_error('mother_board'); ?>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label class="form-label">Ex-Student</label>
                                                </td>
                                                <td>
                                                    <select class="form-select" name="father_ex_student" value="<?php if(isset($student)) {echo $student['father_ex_student'];} else {echo set_value('father_ex_student'); }?>">
                                                        <option value="">Please Select</option>
                                                        <option value="1" <?php if(isset($student) && $student['father_ex_student'] == "1") {echo "selected";} else {echo set_select('father_ex_student', '1'); }?>>Yes</option>
                                                        <option value="0" <?php if(isset($student) && $student['father_ex_student'] == "0") {echo "selected";} else {echo set_select('father_ex_student', '0'); }?>>No</option>
                                                    </select>
                                                    <div class="invalid-feedback d-block">
                                                        <?php echo form_error('father_ex_student'); ?>
                                                    </div>
                                                </td>
                                                <td>
                                                    <select class="form-select" name="mother_ex_student" value="<?php if(isset($student)) {echo $student['mother_ex_student'];} else {echo set_value('mother_ex_student'); }?>">
                                                        <option value="">Please Select</option>
                                                        <option value="1" <?php if(isset($student) && $student['mother_ex_student'] == "1") {echo "selected";} else {echo set_select('mother_ex_student', '1'); }?>>Yes</option>
                                                        <option value="0" <?php if(isset($student) && $student['mother_ex_student'] == "0") {echo "selected";} else {echo set_select('mother_ex_student', '0'); }?>>No</option>
                                                    </select>
                                                    <div class="invalid-feedback d-block">
                                                        <?php echo form_error('mother_ex_student'); ?>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label class="form-label">Mobile</label>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="father_mobile" value="<?php if(isset($student)) {echo $student['father_mobile'];} else {echo set_value('father_mobile'); }?>">
                                                    <div class="invalid-feedback d-block">
                                                        <?php echo form_error('father_mobile'); ?>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="mother_mobile" value="<?php if(isset($student)) {echo $student['mother_mobile'];} else {echo set_value('mother_mobile'); }?>">
                                                    <div class="invalid-feedback d-block">
                                                        <?php echo form_error('mother_mobile'); ?>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label class="form-label">Email</label>    
                                                </td>
                                                <td>
                                                    <input type="email" class="form-control" name="father_email" value="<?php if(isset($student)) {echo $student['father_email'];} else {echo set_value('father_email'); }?>">
                                                    <div class="invalid-feedback d-block">
                                                        <?php echo form_error('father_email'); ?>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="email" class="form-control" name="mother_email" value="<?php if(isset($student)) {echo $student['mother_email'];} else {echo set_value('mother_email'); }?>">
                                                    <div class="invalid-feedback d-block">
                                                        <?php echo form_error('mother_email'); ?>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label class="form-label">Passport No</label>    
                                                </td>
                                                <td>
                                                    <input type="email" class="form-control" name="father_passport_no" value="<?php if(isset($student)) {echo $student['father_passport_no'];} else {echo set_value('father_passport_no'); }?>">
                                                    <div class="invalid-feedback d-block">
                                                        <?php echo form_error('father_passport_no'); ?>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="email" class="form-control" name="mother_passport_no" value="<?php if(isset($student)) {echo $student['mother_passport_no'];} else {echo set_value('mother_passport_no'); }?>">
                                                    <div class="invalid-feedback d-block">
                                                        <?php echo form_error('mother_passport_no'); ?>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label class="form-label">Passport Date of Issue</label>    
                                                </td>
                                                <td>
                                                    <input type="date" class="form-control" name="father_passport_date_of_issue" value="<?php if(isset($student)) {echo $student['father_passport_date_of_issue'];} else {echo set_value('father_passport_date_of_issue'); }?>">
                                                    <div class="invalid-feedback d-block">
                                                        <?php echo form_error('father_passport_date_of_issue'); ?>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="date" class="form-control" name="mother_passport_date_of_issue" value="<?php if(isset($student)) {echo $student['mother_passport_date_of_issue'];} else {echo set_value('mother_passport_date_of_issue'); }?>">
                                                    <div class="invalid-feedback d-block">
                                                        <?php echo form_error('mother_passport_date_of_issue'); ?>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label class="form-label">Passport Valid From</label>    
                                                </td>
                                                <td>
                                                    <input type="date" class="form-control" name="father_passport_valid_from" value="<?php if(isset($student)) {echo $student['father_passport_valid_from'];} else {echo set_value('father_passport_valid_from'); }?>">
                                                    <div class="invalid-feedback d-block">
                                                        <?php echo form_error('father_passport_valid_from'); ?>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="date" class="form-control" name="mother_passport_valid_from" value="<?php if(isset($student)) {echo $student['mother_passport_valid_from'];} else {echo set_value('mother_passport_valid_from'); }?>">
                                                    <div class="invalid-feedback d-block">
                                                        <?php echo form_error('mother_passport_valid_from'); ?>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label class="form-label">Passport Valid To</label>    
                                                </td>
                                                <td>
                                                    <input type="date" class="form-control" name="father_passport_valid_to" value="<?php if(isset($student)) {echo $student['father_passport_valid_to'];} else {echo set_value('father_passport_valid_to'); }?>">
                                                    <div class="invalid-feedback d-block">
                                                        <?php echo form_error('father_passport_valid_to'); ?>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="date" class="form-control" name="mother_passport_valid_to" value="<?php if(isset($student)) {echo $student['mother_passport_valid_to'];} else {echo set_value('mother_passport_valid_to'); }?>">
                                                    <div class="invalid-feedback d-block">
                                                        <?php echo form_error('mother_passport_valid_to'); ?>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="tab-2" role="tabpanel">
                                <h2 class="mb-3">Address</h2>
                                <div class="table-responsive">
                                    <table class="table table-borderd">
                                        <thead class="table-dark text-center">
                                            <tr>
                                                <th></th>
                                                <th>Local</th>
                                                <th>Permanent</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <label class="col-form-label">Address</label> 
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="local_address" value="<?php if(isset($student)) {echo $student['local_address'];} else {echo set_value('local_address'); }?>">
                                                    <div class="invalid-feedback d-block">
                                                        <?php echo form_error('local_address'); ?>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="permanent_address" value="<?php if(isset($student)) {echo $student['permanent_address'];} else {echo set_value('permanent_address'); }?>">
                                                    <div class="invalid-feedback d-block">
                                                        <?php echo form_error('permanent_address'); ?>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label class="col-form-label">Phone</label> 
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="local_phone" value="<?php if(isset($student)) {echo $student['local_phone'];} else {echo set_value('local_phone'); }?>">
                                                    <div class="invalid-feedback d-block">
                                                        <?php echo form_error('local_phone'); ?>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="permanent_phone" value="<?php if(isset($student)) {echo $student['permanent_phone'];} else {echo set_value('permanent_phone'); }?>">
                                                    <div class="invalid-feedback d-block">
                                                        <?php echo form_error('permanent_phone'); ?>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="tab-3" role="tabpanel">
                                <h2 class="mb-3">Local Guardian</h2>
                                <div class="row g-3 align-items-center">
                                    <div class="col-md-2">
                                        <label class="col-form-label">Name</label>
                                    </div>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" name="local_gurdian_name" value="<?php if(isset($student)) {echo $student['local_gurdian_name'];} else {echo set_value('local_gurdian_name'); }?>">
                                        <div class="invalid-feedback d-block">
                                            <?php echo form_error('local_gurdian_name'); ?>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <label class="col-form-label">Mobile</label>
                                    </div>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" name="local_gurdian_mobile" value="<?php if(isset($student)) {echo $student['local_gurdian_mobile'];} else {echo set_value('local_gurdian_mobile'); }?>">
                                        <div class="invalid-feedback d-block">
                                            <?php echo form_error('local_gurdian_mobile'); ?>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <label class="col-form-label">Address</label>
                                    </div>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" name="local_gurdian_address" value="<?php if(isset($student)) {echo $student['local_gurdian_address'];} else {echo set_value('local_gurdian_address'); }?>">
                                        <div class="invalid-feedback d-block">
                                            <?php echo form_error('local_gurdian_address'); ?>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <label class="col-form-label">Email</label>
                                    </div>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" name="local_gurdian_email" value="<?php if(isset($student)) {echo $student['local_gurdian_email'];} else {echo set_value('local_gurdian_email'); }?>">
                                        <div class="invalid-feedback d-block">
                                            <?php echo form_error('local_gurdian_email'); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="tab-4" role="tabpanel">
                                <h2 class="mb-3">Previous School Details</h2>
                                <div class="row g-3 align-items-center">
                                    <div class="col-md-2">
                                        <label class="col-form-label">School Name</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="previous_school_name" value="<?php if(isset($student)) {echo $student['previous_school_name'];} else {echo set_value('previous_school_name'); }?>">
                                        <div class="invalid-feedback d-block">
                                            <?php echo form_error('previous_school_name'); ?>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <label class="col-form-label">Address</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="previous_school_address" value="<?php if(isset($student)) {echo $student['previous_school_address'];} else {echo set_value('previous_school_address'); }?>">
                                        <div class="invalid-feedback d-block">
                                            <?php echo form_error('previous_school_address'); ?>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <label class="col-form-label">Phone</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="previous_school_phone" value="<?php if(isset($student)) {echo $student['previous_school_phone'];} else {echo set_value('previous_school_phone'); }?>">
                                        <div class="invalid-feedback d-block">
                                            <?php echo form_error('previous_school_phone'); ?>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <label class="col-form-label">Last Class Attended</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="previous_school_last_class_attend" value="<?php if(isset($student)) {echo $student['previous_school_last_class_attend'];} else {echo set_value('previous_school_last_class_attend'); }?>">
                                        <div class="invalid-feedback d-block">
                                            <?php echo form_error('previous_school_last_class_attend'); ?>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <label class="col-form-label">Year of Leaving</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="previous_school_year_of_leaving" value="<?php if(isset($student)) {echo $student['previous_school_year_of_leaving'];} else {echo set_value('previous_school_year_of_leaving'); }?>">
                                        <div class="invalid-feedback d-block">
                                            <?php echo form_error('previous_school_year_of_leaving'); ?>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <label class="col-form-label">Remarks</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="previous_school_remarks" value="<?php if(isset($student)) {echo $student['previous_school_remarks'];} else {echo set_value('previous_school_remarks'); }?>">
                                        <div class="invalid-feedback d-block">
                                            <?php echo form_error('previous_school_remarks'); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <input type="text" class="d-none" name="prev_image" value="<?php if(isset($student)) {echo $student['image'];} else {echo set_value('image');}?>" />
        <input type="text" class="d-none" name="id" value="<?php if(isset($student)) {echo $student['id'];} else {echo set_value('id');}?>" />
        <button type="submit" class="btn btn-success rounded rounded-pill"><i class="fa fa-plus"></i> Save</button>
    </form>

    <script>
        var preview = function(event) {
            var output = document.getElementById('img_preview');
            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function() {
            URL.revokeObjectURL(output.src) // free memory
            }
        };

        function fetch_section() {
            $("#class_id").val()
            fetch("<?php echo base_url('students?class_id=') ?>" + $("#class_id").val())
            .then(response => response.json())
            .then(data => {
                $("#section_id").empty()

                $("#section_id").append(`
                    <option value=''>Please Select</option>
                `)
                
                data.sections.forEach((section) => {
                    $("#section_id").append(`
                        <option value=${section.id}>${section.name}</option>
                    `)
                })

                $("#section_id").prop("disabled", false)
            })
        }


        $(document).ready(function () {
            $("#class_id").change(function(event) {
                fetch_section()
            })
        })
    </script>

<?php $this->load->view("inc/app_footer.php"); ?>