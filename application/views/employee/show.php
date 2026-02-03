<?php $this->load->view("inc/app_header.php"); ?>

    <div class="row mb-5">
        <div class="col-md-6">
            <h1>Employee Details</h1>
        </div>
    </div>

    <div class="row mb-5">
        <div class="col-md-12 mb-5">
            <div class="card card-flush h-xl-100">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-10">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <td style="font-weight: bold;">Employee Code</td>                                    
                                            <td><?php echo $employee["emp_code"] ?></td>
                                            <td style="font-weight: bold;">Name</td>
                                            <td><?php echo $employee["f_name"] .  " " . $employee["m_name"] . " " . $employee["l_name"] ?></td>
                                            <td style="font-weight: bold;">Department</td>
                                            <td><?php echo $employee["department"]?></td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight: bold;">Designation</td>
                                            <td><?php echo $employee["designation"]?></td>
                                            <td style="font-weight: bold;">Sex</td>
                                            <td><?php echo $employee["sex"]?></td>
                                            <td style="font-weight: bold;">Date of Birth</td>
                                            <td><?php echo $employee["dob"]?></td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight: bold;">Date of Joining</td>
                                            <td><?php echo $employee["since"]?></td>
                                            <td style="font-weight: bold;">Employee Type</td>
                                            <td><?php echo $employee["emp_type"]?></td>
                                            <td style="font-weight: bold;">Job Status</td>
                                            <td><?php echo $employee["job_status"]?></td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight: bold;">Status</td>
                                            <td><?php echo $employee["status"]?></td>
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
                                    style="width: 90%; opacity: <?php echo $employee['status'] == "ACTIVE" ? '1' : '0.3' ?>"
                                    src="<?php 
                                        if($employee["image"]) { 
                                            echo base_url('storage/employees/') . $employee['image'];
                                        } else { 
                                            echo base_url('assets/media/avatar/') ?><?php echo $employee['sex'] == 'male' ? 'male.jpg' : 'female.jpg';
                                        }?>"
                                />
                            </div>
                            
                            <?php if($this->session->user['permissions'][0]['personnel_module'] != "VIEWER" &&
                                     $this->session->user['permissions'][0]['personnel_module'] != "OPERATOR" && 
                                     $this->session->user['permissions'][0]['personnel_module'] != "USER") { ?>
                            <a href="<?php echo base_url() ?>personnel/employee/edit/<?php echo $employee['id']?>" class="btn btn-sm btn-info w-100 mt-3"><i class="fa fa-edit"></i>Edit</a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row mb-5">
        <div class="col-md-12 mb-5">
            <div class="card card-flush h-xl-100">
                <div class="card-body">
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
                                <div class="table-responsive">
                                    <table class="table">
                                        <tbody>
                                        <tr>
                                            <td style="font-weight: bold;">Mobile No</td>                                    
                                            <td><?php echo $employee["mobile_no"] ?></td>
                                            <td style="font-weight: bold;">Email</td>
                                            <td><?php echo $employee["email"] ?></td>
                                            <td style="font-weight: bold;">Category</td>
                                            <td><?php echo $employee["category"]?></td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight: bold;">Father Name</td>
                                            <td><?php echo $employee["father"]?></td>
                                            <td style="font-weight: bold;">Mother Name</td>
                                            <td><?php echo $employee["mother"]?></td>
                                            <td style="font-weight: bold;">Marital Status</td>
                                            <td><?php echo $employee["marital_status"]?></td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight: bold;">Spouse</td>
                                            <td><?php echo $employee["spouse"]?></td>
                                            <td style="font-weight: bold;">Religion</td>
                                            <td><?php echo $employee["religion"]?></td>
                                            <td style="font-weight: bold;">Nationality</td>
                                            <td><?php echo $employee["nationality"]?></td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight: bold;">PAN No</td>
                                            <td><?php echo $employee["pan_no"]?></td>
                                            <td style="font-weight: bold;">Voter ID</td>
                                            <td><?php echo $employee["voter_id"]?></td>
                                            <td style="font-weight: bold;">Aadhaar Card</td>
                                            <td><?php echo $employee["aadhar_no"]?></td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight: bold;">Miscellaneous</td>
                                            <td><?php echo $employee["miscellaneous"]?></td>
                                            <td class="text-center" colspan="7">&nbsp;</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            
                            <div class="tab-pane fade" id="tab-2" role="tabpanel" aria-labelledby="local-address-tab">
                                <div class="table-responsive">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td style="font-weight: bold;">Address</td>
                                                <td><?php echo $employee["local_address"] ?></td>
                                                <td style="font-weight: bold;">Phone</td>
                                                <td><?php echo $employee["local_phone"] ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="tab-3" role="tabpanel" aria-labelledby="permanent-address-tab">
                                <div class="table-responsive">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td style="font-weight: bold;">Address</td>
                                                <td><?php echo $employee["permanent_address"] ?></td>
                                                <td style="font-weight: bold;">Phone</td>
                                                <td><?php echo $employee["permanent_phone"] ?></td>
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
<?php $this->load->view("inc/app_footer.php"); ?>