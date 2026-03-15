<?php $this->load->view("inc/app_header.php"); ?>

    <div class="row mb-5">
        <h1>Promotion</h1>
    </div>

    <div class="card card-flush h-xl-100">
        <div class="card-body py-9">
            <?php echo form_open(base_url("academics/promotion"), array("method" => "GET")) ?> 
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
        <?php echo form_open(base_url("academics/promotion"), array("method" => "POST")) ?> 
        <div class="row mt-4 mb-5">
            <div class="col-md-9">
                <div class="card card-flush h-xl-100">
                    <div class="card-body py-9">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                            <thead>
                                <tr class="table-dark text-light">
                                    <th></th>
                                    <th>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="check_all">
                                        </div>
                                    </th>
                                    <th>Student No</th>
                                    <th>Name</th>
                                    <th>Roll No</th>
                                    <th>Status</th>
                                    <th>New Class</th>
                                    <th>New Section</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $sl_no = 0; foreach($students as $student) { $sl_no++;?>
                                    <tr>
                                        <td class="table-primary text-dark p-2"><?php echo $sl_no ?></td>
                                        <td>
                                            <div class="form-check mb-4">
                                                <input class="form-check-input" type="checkbox" name="selected[]" value="<?php echo $student['id'] ?>">
                                            </div>
                                        </td>
                                        <td><?php echo $student['student_no'] ?></td>
                                        <td><?php echo $student['f_name'] . " " . $student['m_name'] . " " . $student['l_name'] ?></td>
                                        <td><?php echo $student['roll_no'] ?></td>
                                        <td>
                                            <select class="form-select" name="status[]">
                                                <?php if(isset($_GET["class_id"]) && $_GET["class_id"] != 13) { ?>
                                                <option value="Promote">Promote</option>
                                                <?php } ?>
                                                
                                                <option value="Continue">Continute</option>
                                                
                                                <?php if(isset($_GET["class_id"]) && ($_GET["class_id"] == 11 || $_GET["class_id"] == 13)) { ?>
                                                    <option value="Passout" <?php if(isset($_GET["class_id"]) && $_GET["class_id"] == 13) {echo "selected";}?>>Passout</option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        <td>
                                            <select class="form-select" name="promote_class_id[]" readonly disabled style="display: <?php if(isset($_GET["class_id"]) && $_GET["class_id"] == 13) {echo 'none';} else {echo 'block';}?>">
                                                <option value="">Please Select</option>
                                                <?php foreach ($classes as $class) { ?>
                                                    <option value="<?php echo $class["id"] ?>" <?php if(isset($_GET["class_id"]) && ($_GET["class_id"] != 13) && ($_GET["class_id"] + 1) == $class["id"]) {echo "selected";}?>><?php echo $class["name"] ?></option>
                                                <?php } ?>
                                            </select>
                                            
                                            <select class="form-select" name="continue_class_id[]" readonly disabled style="display: none;">
                                                <option value="">Please Select</option>
                                                <?php foreach ($classes as $class) { ?>
                                                    <option value="<?php echo $class["id"] ?>" <?php if(isset($_GET["class_id"]) && $_GET["class_id"] == $class["id"]) {echo "selected";}?>><?php echo $class["name"] ?></option>
                                                <?php } ?>
                                            </select>
                                            
                                            <select class="form-select" name="passout_class_id[]" readonly disabled style="display: <?php if(isset($_GET["class_id"]) && ($_GET["class_id"] == 13)) {echo 'block';} else {echo 'none';}?>">
                                                <option value=""></option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" class="d-none" name="id[]" value="<?php echo $student['id'] ?>" />
                                            
                                            <select class="form-select" name="promote_section_id[]" style="display: <?php if(isset($_GET["class_id"]) && ($_GET["class_id"] == 13)) {echo 'none';} else {echo 'block';}?>">
                                                <?php foreach ($next_class_sections as $next_section) { ?>
                                                    <option value="<?php echo $next_section["id"] ?>" <?php if(isset($_GET["section_id"]) && $_GET["section_id"] == $next_section["id"]) {echo "selected";}?>><?php echo $next_section["name"] ?></option>
                                                <?php } ?>
                                            </select>
                                            
                                            
                                            <select class="form-select" name="continue_section_id[]" style="display: none;">
                                                <?php foreach ($sections as $section) { ?>
                                                    <option value="<?php echo $section["id"] ?>" <?php if(isset($_GET["section_id"]) && $_GET["section_id"] == $section["id"]) {echo "selected";}?>><?php echo $section["name"] ?></option>
                                                <?php } ?>
                                            </select>
                                            
                                            <select class="form-select" name="passout_section_id[]" style="display: <?php if(isset($_GET["class_id"]) && ($_GET["class_id"] == 13)) {echo 'block';} else {echo 'none';}?>">
                                                <option value=""></option>
                                            </select>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
                <input type="text" class="d-none" name="class_id" value="<?php echo $_GET["class_id"] ?>" />
                <button type="submit" class="btn btn-success rounded rounded-pill mt-4"><i class="fa fa-plus"></i> Save</button>
            </div>
        </div>
        <?php echo form_close() ?> 
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
        
        $('select[name="status[]"]').change(function() {
          if ($(this).val() === 'Continue') {
                $(this).parent().parent().find('select[name="continue_class_id[]"]').show();
                $(this).parent().parent().find('select[name="continue_section_id[]"]').show();
        
                $(this).parent().parent().find('select[name="promote_class_id[]"]').hide();
                $(this).parent().parent().find('select[name="promote_section_id[]"]').hide();
            
                $(this).parent().parent().find('select[name="passout_class_id[]"]').hide();
                $(this).parent().parent().find('select[name="passout_section_id[]"]').hide();
          } else if($(this).val() === 'Promote') {
                $(this).parent().parent().find('select[name="promote_class_id[]"]').show();
                $(this).parent().parent().find('select[name="promote_section_id[]"]').show();
                
                $(this).parent().parent().find('select[name="continue_class_id[]"]').hide();
                $(this).parent().parent().find('select[name="continue_section_id[]"]').hide();
                
                $(this).parent().parent().find('select[name="passout_class_id[]"]').hide();
                $(this).parent().parent().find('select[name="passout_section_id[]"]').hide();
            }
            else {
                $(this).parent().parent().find('select[name="passout_class_id[]"]').show();
                $(this).parent().parent().find('select[name="passout_section_id[]"]').show();
                
                $(this).parent().parent().find('select[name="promote_class_id[]"]').hide();
                $(this).parent().parent().find('select[name="promote_section_id[]"]').hide();
                
                $(this).parent().parent().find('select[name="continue_class_id[]"]').hide();
                $(this).parent().parent().find('select[name="continue_section_id[]"]').hide();
                
           }
        });

        function withdraw(id) {
            
        }
        
        $(document).ready(function() {
            // When the "check_all" checkbox changes
            $("#check_all").change(function() {
                // If it's checked, set all checkboxes to checked
                if ($(this).prop("checked")) {
                    $('input:checkbox').prop('checked', true);
                } else {
                    // Otherwise, uncheck all checkboxes
                    $('input:checkbox').prop('checked', false);
                }
            });
        });
    </script>
<?php $this->load->view("inc/app_footer.php"); ?>