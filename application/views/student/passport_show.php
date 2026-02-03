<?php $this->load->view("inc/app_header.php"); ?>

<div class="row mb-5">
    <div class="col-md-6">
        <h1>Passport</h1>
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

<form action="<?php echo base_url() ?>students/passport/update" method="POST">
    <div class="row mb-5">
        <div class="col-md-12 mb-5">
            <div class="card card-flush h-xl-100">
                <div class="card-body py-9">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm">
                                    <tbody>
                                        <tr>
                                            <td><strong>Student No</strong></td>
                                            <td><?php echo $student['student_no']?></td>
                                            <td><strong>Name</strong></td>
                                            <td><?php echo $student['f_name'] . " " . $student['m_name'] . " " . $student['l_name'] ?></td>
                                            <td><strong>Student Type</strong></td>
                                            <td><?php echo $student['student_type'] ?></td>   
                                        </tr>
                                        <tr>
                                            <td><strong>Class</strong></td>
                                            <td><?php echo $student['class'] ?></td>
                                            <td><strong>Roll No</strong></td>
                                            <td><?php echo $student['roll_no'] ?></td>     
                                            <td><strong>Nationality</strong></td>
                                            <td><?php echo $student['nationality'] ?></td>                                                                                        
                                        </tr>
                                        <tr>
                                            <td colspan="8">
                                                <h5 class="text-center mt-3">Student Passport</h5>
                                            </td>
                                        </tr>
                                        <tr>    
                                            <td style="vertical-align: middle;">Passport No</td>
                                            <td>
                                                <input type="text" class="form-control" name="passport_no" value="<?php echo $student['passport_no'] ?>" />
                                            </td>                            
                                            <td style="vertical-align: middle;">Date of Issue</td>
                                            <td>
                                                <input type="date" class="form-control" name="passport_date_of_issue" value="<?php echo $student['passport_date_of_issue'] ?>" />
                                            </td>
                                            <td style="vertical-align: middle;">Valid From</td>
                                            <td>
                                                <input type="date" class="form-control" name="passport_valid_from" value="<?php echo $student['passport_valid_from'] ?>" />
                                            </td>
                                            <td style="vertical-align: middle;">Valid To</td>
                                            <td>
                                                <input type="date" class="form-control" name="passport_valid_to" value="<?php echo $student['passport_valid_to'] ?>" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="8">
                                                <h5 class="text-center mt-3">Father Passport</h5>
                                            </td>
                                        </tr>
                                        <tr>    
                                            <td style="vertical-align: middle;">Passport No</td>
                                            <td>
                                                <input type="text" class="form-control" name="father_passport_no" value="<?php echo $student['father_passport_no'] ?>" />
                                            </td>                            
                                            <td style="vertical-align: middle;">Date of Issue</td>
                                            <td>
                                                <input type="date" class="form-control" name="father_passport_date_of_issue" value="<?php echo $student['father_passport_date_of_issue'] ?>" />
                                            </td>
                                            <td style="vertical-align: middle;">Valid From</td>
                                            <td>
                                                <input type="date" class="form-control" name="father_passport_valid_from" value="<?php echo $student['father_passport_valid_from'] ?>" />
                                            </td>
                                            <td style="vertical-align: middle;">Valid To</td>
                                            <td>
                                                <input type="date" class="form-control" name="father_passport_valid_to" value="<?php echo $student['father_passport_valid_to'] ?>" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="8">
                                                <h5 class="text-center mt-3">Mother Passport</h5>
                                            </td>
                                        </tr>
                                        <tr>    
                                            <td style="vertical-align: middle;">Passport No</td>
                                            <td>
                                                <input type="text" class="form-control" name="mother_passport_no" value="<?php echo $student['mother_passport_no'] ?>" />
                                            </td>                            
                                            <td style="vertical-align: middle;">Date of Issue</td>
                                            <td>
                                                <input type="date" class="form-control" name="mother_passport_date_of_issue" value="<?php echo $student['mother_passport_date_of_issue'] ?>" />
                                            </td>
                                            <td style="vertical-align: middle;">Valid From</td>
                                            <td>
                                                <input type="date" class="form-control" name="mother_passport_valid_from" value="<?php echo $student['mother_passport_valid_from'] ?>" />
                                            </td>
                                            <td style="vertical-align: middle;">Valid To</td>
                                            <td>
                                                <input type="date" class="form-control" name="mother_passport_valid_to" value="<?php echo $student['mother_passport_valid_to'] ?>" />
                                            </td>
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
    <input type="text" name="id" class="d-none" value="<?php echo $student['id'] ?>">
    <button type="submit" class="btn btn-success rounded rounded-pill mb-5"><i class="fa fa-plus"></i> Save</button>
</form>



<div class="row mb-5 <?php if(strtolower($student['nationality']) == "india") {echo "d-none";}?>">
    <div class="col-md-12 mb-5">
        <div class="card card-flush h-xl-100">
            <div class="card-body py-9">
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-2">
                        <label class="form-label">Serial No.</label>
                        <input type="text" id="serial_no" class="form-control" />
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">No. of Years</label>
                        <input type="text" id="total_years" class="form-control" />
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Session Start Year</label>
                        <input type="text" id="start_year" class="form-control" />
                    </div>
                    <div class="col-md-3"></div>
                </div>
                <div class="row my-4">
                    <div class="col-md-6">
                        <div class="buttons">
                            <button id="1" class="btn btn-primary" style="width: 100%;">Bonafide Certificate for Non Indian Existing Students</button>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="buttons">
                            <button id="2" class="btn btn-primary" style="width: 100%;">Bonafide Certificate for Non Indian New Students</button>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="buttons">
                            <button id="3" class="btn btn-primary" style="width: 100%;">Multiple Visa Letter 1 for Non Indian Students</button>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="buttons">
                            <button id="4" class="btn btn-primary" style="width: 100%;">Multiple Visa Letter 2 for Non Indian Students</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    
<script>
    function check() {
        if($("#serial_no").val() == "") {
            alert("Enter Serial Number")
            return false
        }
        else{
            if($("#serial_no").val() != "<?php echo $student['passport_no'][-2] . $student['passport_no'][-1]?>") {
                alert("Enter Valid Serial Number")
                return  false
            }
        }
        
        if($("#total_years").val() == "") {
            alert("Enter Total Years")
            return  false
        }

        if($("#start_year").val() == "") {
            alert("Enter Start Year")
            return  false
        }
    }
    
    $("#1").click(function(){
        if(check() == false){
            return false;
        }
        window.open(`<?php echo base_url() ?>students/passport/report?report_id=1&student_id=<?php echo $student['id']?>&serial_no=${$("#serial_no").val()}&total_years=${$("#total_years").val()}&start_year=${$("#start_year").val()}`,'name','width=800,height=600')
    })

    $("#2").click(function(){
        if(check() == false){
            return false;
        }
        window.open(`<?php echo base_url() ?>students/passport/report?report_id=2&student_id=<?php echo $student['id']?>&serial_no=${$("#serial_no").val()}&total_year=${$("#total_years").val()}&start_year=${$("#start_year").val()}`,'name','width=800,height=600')
    })
    $("#3").click(function(){
        if(check() == false){
            return false;
        }
        window.open(`<?php echo base_url() ?>students/passport/report?report_id=3&student_id=<?php echo $student['id']?>&serial_no=${$("#serial_no").val()}&total_years=${$("#total_years").val()}&start_year=${$("#start_year").val()}`,'name','width=800,height=600')
    })
    $("#4").click(function(){
        if(check() == false){
            return false;
        }
        window.open(`<?php echo base_url() ?>students/passport/report?report_id=4&student_id=<?php echo $student['id']?>&serial_no=${$("#serial_no").val()}&total_years=${$("#total_years").val()}&start_year=${$("#start_year").val()}`,'name','width=800,height=600')
    })
</script>

<?php $this->load->view("inc/app_footer.php"); ?>