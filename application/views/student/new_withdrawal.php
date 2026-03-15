<?php $this->load->view("inc/app_header.php"); ?>
    <div class="row mb-5">
        <h1>Student Withdrawal</h1>
    </div>

    <div class="card card-flush h-xl-100">
        <div class="card-body py-9">
            <?php echo form_open(base_url("students/new-withdrawal"), array("method" => "GET")) ?> 
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <div class="form-group">
                            <label class="form-label">Select Class</label>
                            <select class="form-select" name="class_id" id="class_id" required>
                                <option value="">Please Select</option>
                                <?php foreach ($classes as $class) { ?>
                                    <option value="<?php echo $class["id"] ?>" <?php if(isset($_GET["class_id"]) && $_GET["class_id"] == $class["id"]) {echo "selected";}?>><?php echo $class["name"] ?></option>
                                <?php } ?>
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
            <div class="col-md-8">
                <div class="card card-flush h-xl-100">
                    <div class="card-body py-9">
                        <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr class="text-center table-dark text-light">
                                    <th>Sl No</th>                                    
                                    <th>Student No</th>
                                    <th>Name</th>
                                    <th>Roll No</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $sl_no = 0; foreach($students as $student) { $sl_no++;?>
                                    <tr class="text-center">
                                        <td class="table-primary text-dark p-2"><?php echo $sl_no ?></td>
                                        <td><?php echo $student['student_no'] ?></td>
                                        <td><?php echo $student['f_name'] . " " . $student['m_name'] . " " . $student['l_name'] ?></td>
                                        <td><?php echo $student['roll_no'] ?></td>
                                        <th>
                                            <button 
                                                class="btn btn-primary btn-sm withdraw_button" 
                                                data-id='<?php echo $student['id'] ?>'
                                                data-student_no='<?php echo $student['student_no'] ?>'
                                                data-student_name='<?php echo $student['f_name'] . " " . $student['m_name'] . " " . $student['l_name'] ?>'
                                                data-student_roll_no='<?php echo $student['roll_no']?>'>Withdraw</button>
                                        </th>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4" id="tc" style="display: none;">
                <div class="card card-flush h-xl-100">
                    <div class="card-body py-9">
                        <?php echo form_open(base_url("students/new-withdrawal"), array("method" => "POST")) ?> 
                            <div class="table-responsive">
                                <table class="table">
                                <tr>
                                    <td>Student No</td>
                                    <td id="student_no"></td>
                                </tr>
                                <tr>
                                    <td>Student Name</td>
                                    <td id="student_name"></td>
                                </tr>
                                <tr>
                                    <td>Roll No</td>
                                    <td id="student_roll"></td>
                                </tr>
                                <tr>
                                    <td>TC No</td>
                                    <td>
                                        <input type="text" class="form-control" name="tc_no" value="0000/23-24" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>EMMIS TC No</td>
                                    <td>
                                        <input type="text" class="form-control" name="emmis_tc_no" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>UDUSE PEN</td>
                                    <td>
                                        <input type="text" class="form-control" name="uduse_pen" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>TC Date</td>
                                    <td>
                                        <input type="date" class="form-control" name="tc_date" value="<?php echo date('Y-m-d') ?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>Date of Leaving</td>
                                    <td>
                                        <input type="text" class="form-control d-none" name="id" value="" />
                                        <input type="text" class="form-control d-none" name="class_id" value="<?php if(isset($_GET['class_id'])) {echo $_GET['class_id'];} ?>" />
                                        <input type="text" class="form-control d-none" name="section_id" value="<?php if(isset($_GET['section_id'])) {echo $_GET['section_id'];} ?>" />
                                        <input type="date" class="form-control" name="date_of_leaving" value="<?php echo date('Y-m-d') ?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>Reason</td>
                                    <td>
                                        <select class="form-select" name="reason">
                                            <?php foreach($reasons as $reason) { ?>
                                                <option value="<?php echo $reason['name'] ?>"><?php echo $reason['name'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                </tr>
                            </table>
                            </div>
                            <button class="btn btn-success">Save</button>
                        <?php echo form_close() ?> 
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
        
        $(".withdraw_button").on("click", function() {
            $("#tc").show()
            
            $("#student_no").text($(this).data('student_no'))  
            $("#student_name").text($(this).data('student_name'))  
            $("#student_roll").text($(this).data('student_roll_no'))  

            $("input[name='id']").val($(this).data('id'))
        })
    </script>


<?php $this->load->view("inc/app_footer.php"); ?>