<?php $this->load->view("inc/app_header.php"); ?>

    <div class="row mb-5">
        <div class="col-md-6">
            <h1>Student Records</h1>
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

    <div class="row mb-5">
        <div class="card card-flush h-xl-100">
            <div class="card-body py-9">
                <div class="row">
                    <div class="col-md-10">
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm">
                                <tbody>
                                    <tr>
                                        <td style="font-weight: bold;">Student No</td>
                                        <td><?php echo $student["student_no"] ?></td>
                                        <td style="font-weight: bold;">Name</td>
                                        <td><?php echo $student["f_name"] . " " . $student["m_name"] . " " . $student["l_name"]?></td>
                                        <td style="font-weight: bold;">Student Type</td>
                                        <td><?php echo $student["student_type"] ?></td>                                                                                                
                                    </tr>
                                    <tr>
                                        <td style="font-weight: bold;">Class</td>
                                        <td><?php echo $student["student_session_class_name"] ?></td>
                                        <td style="font-weight: bold;">Roll No</td>
                                        <td><?php echo $student["roll_no"] ?></td>
                                        <td style="font-weight: bold;">House</td>
                                        <td><?php echo $student["house"] ?></td>
                                    </tr>
                                    <tr>    
                                        <td style="font-weight: bold;">Date Of Birth</td>
                                        <td><?php echo $student["dob"] ?></td>                            
                                        <td style="font-weight: bold;">Date of Admission</td>
                                        <td><?php echo $student["admission_date"] ?></td>
                                        <td style="font-weight: bold;">Class Of Admission</td>
                                        <td><?php echo $student["student_class_of_admission_name"] ?></td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: bold;">Sex</td>
                                        <td><?php echo $student["sex"] ?></td>
                                        <td style="font-weight: bold;">Blood Group</td>
                                        <td><?php echo $student["blood_group"] ?></td>
                                        <td style="font-weight: bold;">Medical Status</td>
                                        <td><?php echo $student["medical_status"] ?></td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: bold;">Phone</td>
                                        <td><?php echo $student["phone"] ?></td>
                                        <td style="font-weight: bold;">Email</td>
                                        <td><?php echo $student["email"] ?></td>
                                        <td style="font-weight: bold;">Category</td>
                                        <td><?php echo $student["category"] ?></td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: bold;">Religion</td>
                                        <td><?php echo $student["religion"] ?></td>
                                        <td style="font-weight: bold;">Nationality</td>
                                        <td><?php echo $student["nationality"] ?></td>
                                        <td style="font-weight: bold;">State</td>
                                        <td><?php echo $student["state"] ?></td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: bold;">Board Reg. No</td>
                                        <td><?php echo $student["board_registration_no"] ?></td>
                                        <td style="font-weight: bold;">SSID</td>
                                        <td><?php echo $student["ssid"] ?></td>
                                        <td style="font-weight: bold;">Adhaar Card No</td>
                                        <td><?php echo $student["aadhaar_no"] ?></td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: bold;">Status</td>
                                        <td><?php echo $student["status"] ?></td>
                                        <td colspan="4">&nbsp;</td>
                                    </tr>                            
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="row justify-content-center">
                            <img 
                                id="img_preview" 
                                class="border border-dark border-3 rounded-circle p-1" 
                                style="width: 90%; opacity: <?php echo $student['status'] == "ACTIVE" ? '1' : '0.5' ?>"
                                src="<?php 
                                    if($student["image"]) { 
                                        echo base_url('storage/students/') . $student['image'];
                                    } else { 
                                        echo base_url('assets/media/avatar/') ?><?php echo $student['sex'] == 'male' ? 'male.jpg' : 'female.jpg';
                                    }?>"
                            />
                        </div>
                        
                        <?php if($this->session->user['permissions'][0]['student_module'] != "VIEWER" && 
                                 $this->session->user['permissions'][0]['student_module'] != "OPERATOR") { ?>
                        <a href="<?php echo base_url() ?>students/edit/<?php echo $student['id']?>" class="btn btn-sm btn-info w-100 mt-3"><i class="fa fa-edit"></i>Edit</a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-5">
        <div class="card card-flush h-xl-100">
            <div class="card-body py-9">
                <div class="row">
                    <ul class="nav nav-pills nav-justified mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link tab-button" id="pills-tab-1" data-bs-toggle="pill" data-bs-target="#tab-1" type="button" role="tab" aria-controls="pills-home" aria-selected="false">Academics</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link tab-button" id="pills-tab-2" data-bs-toggle="pill" data-bs-target="#tab-2" type="button" role="tab" aria-controls="pills-fees" aria-selected="false">Fee Details</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link tab-button" id="pills-tab-3" data-bs-toggle="pill" data-bs-target="#tab-3" type="button" role="tab" aria-controls="pills-family" aria-selected="false">Family</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link tab-button" id="pills-tab-4" data-bs-toggle="pill" data-bs-target="#tab-4" type="button" role="tab" aria-controls="pills-curricular" aria-selected="false">Extra Curricular</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link tab-button" id="pills-tab-5" data-bs-toggle="pill" data-bs-target="#tab-5" type="button" role="tab" aria-controls="pills-discipline" aria-selected="false">Discipline</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link tab-button" id="pills-tab-6" data-bs-toggle="pill" data-bs-target="#tab-6" type="button" role="tab" aria-controls="pills-miscellaneous" aria-selected="false">Miscellaneous</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link tab-button" id="pills-tab-7" data-bs-toggle="pill" data-bs-target="#tab-7" type="button" role="tab" aria-controls="pills-address" aria-selected="false">Address</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link tab-button" id="pills-tab-8" data-bs-toggle="pill" data-bs-target="#tab-8" type="button" role="tab" aria-controls="pills-local_guardian" aria-selected="false">Local Guardian</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link tab-button" id="pills-tab-9" data-bs-toggle="pill" data-bs-target="#tab-9" type="button" role="tab" aria-controls="pills-previous_school" aria-selected="false">Previous School</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade" id="tab-3" role="tabpanel">
                            <h4>Family</h4>
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="table-dark text-light">
                                        <th></th>
                                        <th>Name</th>
                                        <th>Employee Code</th>
                                        <th>School Staff</th>
                                        <th>Profession</th>
                                        <th>Education</th>
                                        <th>Year of Passing</th>
                                        <th>Board</th>
                                        <th>Ex-Student</th>
                                        <th>Mobile</th>
                                        <th>Email</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="table-primary text-dark p-2"><strong>Father</strong></td>
                                        <td><?php echo $student["father_name"] ?></td>
                                        <td><?php echo $student["father_emp_no"] ?></td>
                                        <td><?php echo $student["father_school_stuff"] ? "Yes" : "No"  ?></td>
                                        <td><?php echo $student["father_profession"] ?></td>
                                        <td><?php echo $student["father_education"] ?></td>
                                        <td><?php echo $student["father_year_of_passing"] ?></td>
                                        <td><?php echo $student["father_board"] ?></td>
                                        <td><?php echo $student["father_ex_student"] ? "Yes" : "No" ?></td>
                                        <td><?php echo $student["father_mobile"] ?></td>
                                        <td><?php echo $student["father_email"] ?></td>

                                    </tr>
                                    <tr>
                                        <td class="table-primary text-dark p-2"><strong>Mother</strong></td>
                                        <td><?php echo $student["mother_name"] ?></td>
                                        <td><?php echo $student["mother_emp_no"] ?></td>
                                        <td><?php echo $student["mother_school_stuff"] ? "Yes" : "No" ?></td>
                                        <td><?php echo $student["mother_profession"] ?></td>
                                        <td><?php echo $student["mother_education"] ?></td>
                                        <td><?php echo $student["mother_year_of_passing"] ?></td>
                                        <td><?php echo $student["mother_board"] ?></td>
                                        <td><?php echo $student["mother_ex_student"] ? "Yes" : "No" ?></td>
                                        <td><?php echo $student["mother_mobile"] ?></td>
                                        <td><?php echo $student["mother_email"] ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="tab-pane fade" id="tab-7" role="tabpanel">
                            <h4 class="my-3">Address</h4>
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm">
                                    <thead>
                                        <tr class="table-dark text-light">
                                            <th></th>
                                            <th>Locale</th>
                                            <th>Permanent</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="table-primary text-dark text-center"><strong>Address</strong></td>
                                            <td><?php echo $student['local_address'] ?></td>
                                            <td><?php echo $student['permanent_address'] ?></td>
                                        </tr>
                                        <tr>
                                            <td class="table-primary text-dark text-center"><strong>Phone</strong></td>
                                            <td><?php echo $student['local_phone'] ?></td>
                                            <td><?php echo $student['permanent_phone'] ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>      
                        </div>

                        <div class="tab-pane fade" id="tab-8" role="tabpanel">
                            <h4 class="my-3">Previous School</h4>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-sm">
                                            <tbody>
                                                <tr>
                                                    <td class="table-primary text-dark p-2"><strong>Name</strong></td>
                                                    <td><?php echo $student['local_gurdian_name'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="table-primary text-dark p-2"><strong>Mobile</strong></td>
                                                    <td><?php echo $student['local_gurdian_mobile'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="table-primary text-dark p-2"><strong>Address</strong></td>
                                                    <td><?php echo $student['local_gurdian_address'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="table-primary text-dark p-2"><strong>Email</strong></td>
                                                    <td><?php echo $student['local_gurdian_email'] ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>  
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="tab-9" role="tabpanel">
                            <h4 class="my-3">Previous School</h4>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-sm">
                                            <tbody>
                                                <tr>
                                                    <td class="table-primary text-dark p-2"><strong>School Name</strong></td>
                                                    <td><?php echo $student['previous_school_name'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="table-primary text-dark p-2"><strong>Address</strong></td>
                                                    <td><?php echo $student['previous_school_address'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="table-primary text-dark p-2"><strong>Phone</strong></td>
                                                    <td><?php echo $student['previous_school_phone'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="table-primary text-dark p-2"><strong>Last Class Attended</strong></td>
                                                    <td><?php echo $student['previous_school_last_class_attend'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="table-primary text-dark p-2"><strong>Year of Leaving</strong></td>
                                                    <td><?php echo $student['previous_school_year_of_leaving'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="table-primary text-dark p-2"><strong>Remarks</strong></td>
                                                    <td><?php echo $student['previous_school_remarks'] ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>   
                                </div>
                            </div>   
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php $this->load->view("inc/app_footer.php"); ?>