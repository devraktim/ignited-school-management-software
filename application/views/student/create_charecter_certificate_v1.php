<?php $this->load->view("inc/app_header.php"); ?>
    <div class="row mb-5">
        <h1>Generate Charecter Certificate</h1>
    </div>

    <?php if($saved_data->charecter_certificate != "") {
        $saved_data = json_decode($saved_data->charecter_certificate);
    } ?>

    <div class="card card-flush h-xl-100 w-50">
        <div class="card-body py-9">
            <?php echo form_open(base_url("students/withdrawn/generate/charecter-certificate"), array("method" => "POST" , "target" => "print_popup", "onsubmit"=> "window.open('about:blank','print_popup','width=1000,height=500');")) ?> 
                
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td>TC No.</td>
                                <td>
                                    <input class="form-control form-sm" type="text" value="<?php echo $tc_no ?>" disabled />
                                </td>
                            </tr>
                            <tr>
                                <td>Student No.</td>
                                <td>
                                    <input class="form-control form-sm" type="text" value="<?php echo $student_data['student_no'] ?>" disabled />
                                </td>
                            </tr>
                            
                            
                            <tr>
                                <td>This is to certify that <?php echo $student_data["sex"] == "male" ? "Mr" : "Miss" ?></td>
                                <td>
                                    <input class="form-control form-sm" type="text" name="field_1" value="<?php echo $student_data["f_name"] . " " . $student_data["m_name"] . " " . $student_data["l_name"] ?>" readonly />
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo $student_data["sex"] == "male" ? "Son" : "Daughter" ?> of</td>
                                <td>
                                    <input class="form-control form-sm" type="text" name="field_2" value="<?php echo $student_data["father_name"] ?>" readonly />
                                </td>
                            </tr>
                            <tr>
                                <td>resident of	</td>
                                <td>
                                    <input class="form-control form-sm" type="text" name="field_3" value="<?php if(isset($saved_data->field_3)) { echo $saved_data->field_3; } ?>" />
                                </td>
                            </tr>
                            <tr>
                                <td rowspan=1>was a bonafide student of this institution</td>
                            </tr>
                            <tr>
                                <td>The character of the above student was</td>
                                <td>
                                    <input class="form-control form-sm" type="text" name="field_4" value="<?php if(isset($saved_data->field_4)) { echo $saved_data->field_4; } ?>"  />
                                </td>
                            </tr>
                            <tr>
                                <td>Academically the Student was</td>
                                <td>
                                    <input class="form-control form-sm" type="text" name="field_5" value="<?php if(isset($saved_data->field_5)) { echo $saved_data->field_5; } ?>"  />
                                </td>
                            </tr>
                            <tr>
                                <td>Date</td>
                                <td>
                                    <input class="form-control form-sm" type="text" name="field_6" value="<?php echo date("d-m-Y", time()) ?>"  />
                                </td>
                            </tr>
                        </tbody>    
                    </table>
                </div>
                <input type="text" class="d-none" name="student_id" value="<?php echo $student_id; ?>" />
                <input type="text" class="d-none" name="version" value="<?php echo $version; ?>" />

                <button class="btn btn-success" type="submit">Save</button>
            
            <?php echo form_close() ?> 
        </div>
    </div>
<?php $this->load->view("inc/app_footer.php"); ?>