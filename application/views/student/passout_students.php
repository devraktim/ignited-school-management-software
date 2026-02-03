<?php $this->load->view("inc/app_header.php"); ?>
    <div class="row mb-5">
        <h1>Passout Student List</h1>
    </div>

    <div class="card card-flush h-xl-100">
        <div class="card-body py-9">
            <?php echo form_open(base_url("students/passout-students"), array("method" => "GET")) ?> 
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <div class="form-group">
                            <label class="form-label">Select Class</label>
                            <select class="form-select" name="class_id" id="class_id" required>
                                <option value="">Please Select</option>
                                <option value="11">X</option>
                                <option value="12">XII</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="form-group">
                            <label class="form-label">Select Section</label>
                            <select class="form-select" id="section_id" name="section_id" required <?php if(!isset($sections)) { echo "disabled"; }?>>
                                <?php foreach ($sections as $section) { ?>
                                    <option value="<?php echo $section["id"] ?>" <?php if(isset($_GET["section_id"]) && $_GET["section_id"] == $section["id"]) {echo "selected";}?>><?php echo $section["name"] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3" style="margin-top: 25px;">
                        <button id="btn_save" class="btn btn-success" <?php if(!isset($sections)) { echo "disabled"; }?>><i class="fa fa-search"></i> Search</button>
                    </div>
                </div>
            <?php echo form_close() ?> 
        </div>
    </div>

    <?php if(isset($students)) { ?>
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card card-flush h-xl-100">
                    <div class="card-body py-9">
                        <?php if(count($students) > 0) { ?>
                        <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr class="text-center table-dark text-light">
                                    <th>Sl No</th>                                    
                                    <th>Student No</th>
                                    <th>Name</th>
                                    <th>Roll No</th>
                                    <th>TC No</th>
                                    <th>TC Date</th>
                                    <th>Date of Leaving</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $sl_no = 0; foreach($students as $student) { $sl_no++;?>
                                    <tr class="text-center">
                                        <td class="table-primary text-dark p-2"><?php echo $sl_no ?></td>
                                        <td><?php echo $student['student_no'] ?></td>
                                        <td><?php echo $student['f_name'] . " " . $student['m_name'] . " " . $student['l_name'] ?></td>
                                        <td><?php echo $student['roll_no'] ?></td>
                                        <td>
                                            <input type="text" class="form-control" name="student_tc_no" value="<?php echo $student['tc_no'] ?>" />
                                        </td>
                                        <td>
                                            <input type="date" class="form-control" name="student_tc_date" value="<?php echo $student['tc_date'] ?>" />
                                        </td>
                                        <td>
                                            <input type="date" class="form-control" name="student_date_of_leaving" value="<?php echo $student['date_of_leaving'] ?>" />
                                        </td>

                                        <td>
                                            <?php echo form_open(base_url("students/passout-students"), array("method" => "POST")) ?> 
                                                <input name="student_id" class="d-none" type="text" value="<?php echo $student["student_id"] ?>" />
                                                <input name="class_id" class="d-none" type="text" value="<?php echo $student["class_id"] ?>" />
                                                <input name="section_id" class="d-none" type="text" value="<?php echo $student["section_id"] ?>" />
                                                <input name="session_id" class="d-none" type="text" value="<?php echo $student["session_id"] ?>" />
                                                <input name="tc_no" class="d-none" type="text" value="<?php echo $student["tc_no"] ?>" />
                                                <input name="tc_date" class="d-none" type="text" value="<?php echo $student["tc_date"] ?>" />
                                                <input name="date_of_leaving" class="d-none" type="text" value="<?php echo $student["date_of_leaving"] ?>" />
                                
                                                <button type="submit" class="btn btn-sm btn-primary">Save</button>
                                            <?php echo form_close() ?> 
                                        </td>

                                        <td>
                                            <?php echo form_open(base_url("students/withdrawn/generate/transfer-certificate"), array("method" => "GET")) ?> 
                                                <input name="student_id" class="d-none" type="text" value="<?php echo $student["student_id"] ?>" />
                                                <input name="tc_no" class="d-none" type="text" value="<?php echo $student["tc_no"] ?>" />
                                                <input name="tc_date" class="d-none" type="text" value="<?php echo $student["tc_date"] ?>" />
                                                <input name="date_of_leaving" class="d-none" type="text" value="<?php echo $student["date_of_leaving"] ?>" />
                                                
                                                <button type="submit" class="btn btn-sm btn-primary">Transfer Certificate</button>
                                            <?php echo form_close() ?> 
                                        </td>
                                        
                                        <td>
                                            <?php echo form_open(base_url("students/withdrawn/generate/charecter-certificate"), array("method" => "GET")) ?> 
                                                <input name="student_id" class="d-none" type="text" value="<?php echo $student["student_id"] ?>" />
                                                <input name="tc_no" class="d-none" type="text" value="<?php echo $student["tc_no"] ?>" />
                                                <input name="tc_date" class="d-none" type="text" value="<?php echo $student["tc_date"] ?>" />
                                                <input name="date_of_leaving" class="d-none" type="text" value="<?php echo $student["date_of_leaving"] ?>" />
                                                
                                                <button type="submit" class="btn btn-sm btn-primary">Charecter Certificate</button>
                                            <?php echo form_close() ?>
                                        </td>
                                        
                                        <!--<th>-->
                                        <!--    <?php echo form_open(base_url("students/delete/withdrawn"), array("method" => "POST")) ?> -->
                                        <!--        <input name="id" class="d-none" type="text" value="<?php echo $student["id"] ?>" />-->
                                        <!--        <button type="submit" class="btn btn-sm btn-primary">Delete</button>-->
                                        <!--    <?php echo form_close() ?>-->
                                        <!--</th>-->
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                        <?php } else { ?>
                        <h2 class="text-muted text-center">No Students Found</h2>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>

    <script>
        $("#class_id").change(function(event) {
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
                $("#btn_save").prop("disabled", false)

            })
        })
        
        
        $("input[name='student_tc_no']").on("change", function() {
            $("input[name='student_tc_no']").parent().parent().find("input[name='tc_no']").val($(this).val())
        })
        
        $("input[name='student_tc_date']").on("change", function() {
            $("input[name='student_tc_date']").parent().parent().find("input[name='tc_date']").val($(this).val())
        })
        
        $("input[name='student_date_of_leaving']").on("change", function() {
            $("input[name='student_date_of_leaving']").parent().parent().find("input[name='date_of_leaving']").val($(this).val())
        })
    </script>


<?php $this->load->view("inc/app_footer.php"); ?>