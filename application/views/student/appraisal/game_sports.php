<?php $this->load->view("inc/app_header.php"); ?>
<?php 
    $class_map = [
        1 => "UKG", 2 => "I", 3 => "II", 4 => "III", 5 => "IV", 
        6 => "V", 7 => "VI", 8 => "VII", 9 => "VIII", 10 => "IX", 
        11 => "X", 12 => "XI", 13 => "XII"
    ];
    
    $section_map = [
        1 => "A", 2 => "B", 3 => "SC", 4 => "AR"
    ];

?>

    <div class="row mb-5">
        <h1>Appraisal Game & Sports</h1>
    </div>

    <div class="card card-flush h-xl-100">
        <div class="card-body py-9">
            <form action="<?php echo base_url() ?>students/reports/generate-appraisal-game-and-sports" method="GET">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <div class="form-group">
                            <label class="form-label">Select Class</label>
                            <select class="form-select" name="ss.class_id" id="class_id" required>
                                <option value="">Please Select</option>
                                <?php foreach ($classes as $class) { ?>
                                    <option value="<?php echo $class["id"] ?>" <?php if(isset($_GET["ss_class_id"]) && $_GET["ss_class_id"] == $class["id"]) {echo "selected";}?>><?php echo $class["name"] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="form-group">
                            <label class="form-label">Select Section</label>
                            <select class="form-select" name="ss.section_id" id="section_id" required <?php if(!isset($sections)) { echo "disabled"; }?>>
                                <?php foreach ($sections as $section) { ?>
                                    <option value="<?php echo $section["id"] ?>" <?php if(isset($_GET["ss_section_id"]) && $_GET["ss_section_id"] == $section["id"]) {echo "selected";}?>><?php echo $section["name"] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-3 mb-3">
                        <div class="form-group">
                            <label class="form-label">Select Game</label>
                            <select class="form-select" name="participated_in">
                                <option value="">Select</option>
                                
                                <?php foreach($games as $extra_curricular) { ?>
                                    <option value="<?php echo $extra_curricular['id'] ?>" <?php if(isset($_GET['participated_in']) && $extra_curricular['id'] == $_GET['participated_in']) {echo "selected";}  ?>><?php echo $extra_curricular['name'] ?></option>
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
    
    <?php if(count($records) > 0) { ?>
    <div class="card card-flush h-xl-100">
        <div class="card-body py-9">
            <div class="row">
                <form id="form" method="POST" action="<?php echo base_url() ?>students/reports/appraisal-game-and-sports">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr class="text-center table-dark text-light">
                                    <th>S.NO</th>
                                    <th>Session</th>
                                    <th>Student No</th>
                                    <th>Name</th>
                                    <!--<th>Class</th>-->
                                    <!--<th>Section</th>-->
                                    <th>Participated In</th>
                                    <th>Result</th>
                                    <th>Remarks</th>
                                </tr>
                            </thead>
                            
                            <tbody>
                                <?php $i = 0; foreach($records as $record) { $i++; ?>
                                    <tr>
                                        <td class="table-primary text-dark p-2"><?php echo $i; ?></td>
                                        <td>
                                            <?php 
                                                $id = $this->session->academy_session['current_session']['id'];
            
                                                switch ($id) {
                                                    case 1:
                                                        echo "23-24";
                                                        break;
                                                    case 2:
                                                        echo "24-25";
                                                        break;
                                                    default:
                                                        echo "Unknown session ID";
                                                        break;
                                                }
                                            ?>
                                        </td>
                                        <td><?php echo $record['student_no'] ?></td>
                                        <td><?php echo $record['f_name'] . ' ' . $record['m_name'] . ' ' . $record['l_name']; ?></td>
                                        <!--<td>-->
                                        <!--    <?php echo $class_map[$record['student_session_class_id']] ?>-->
                                        <!--</td>-->
                                        <!--<td>-->
                                        <!--    <?php echo $section_map[$record['student_session_section_id']] ?>-->
                                        <!--</td>-->
                                        <td class="d-none">
                                            <select class="form-select" name="participated_in[]">
                                                <option value="">Select</option>
                                                
                                                <?php foreach($games as $extra_curricular) { ?>
                                                    <option value="<?php echo $extra_curricular['id'] ?>" <?php if(isset($_GET['participated_in']) && $extra_curricular['id'] == $_GET['participated_in']) {echo "selected";}  ?>><?php echo $extra_curricular['name'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" name="result[]" value="<?php echo $record['result'] ?>" />
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" name="remarks[]" value="<?php echo $record['remarks'] ?>"  />
                                            <input type="text" class="d-none" name="student_id[]" value="<?php echo $record['id'] ?>" />
                                            <input type="text" class="d-none" name="class_id[]" value="<?php if(isset($_GET["ss_class_id"])) { echo $_GET["ss_class_id"]; } ?>" />
                                            <input type="text" class="d-none" name="section_id[]" value="<?php if(isset($_GET["ss_section_id"])) { echo $_GET["ss_section_id"]; } ?>" />
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <button class="btn btn-success">Save</button>
                </form>
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
    </script>

<?php $this->load->view("inc/app_footer.php"); ?>