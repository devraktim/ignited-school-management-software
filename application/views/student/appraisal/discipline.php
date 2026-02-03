<?php $this->load->view("inc/app_header.php"); ?>
    <style>
        .table-responsive {
            height: 500px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            border: 1px solid #ccc;
        }
        .sticky-header {
            position: sticky;
            top: 0;
            background-color: #f2f2f2;
            z-index: 2; /* Ensures the header stays on top */
        }
        .sticky-header {
            position: sticky;
            top: 0;
            background-color: #f2f2f2;
            z-index: 2; /* Ensures the header stays on top */
        }
        .sticky-column-1 {
            position: sticky;
            left:0;
            background-color:  white;
            z-index: 4; /* Ensures the column stays above the table cells */
            min-width: 50px; 
        }
        
        .sticky-column-2 {
            position: sticky;
            left: 50px;
            z-index: 3; /* Ensures the column stays above the table cells */
            min-width: 100px; 
        }
        
        .sticky-column-3 {
            position: sticky;
            left: 150px;
            z-index: 2; /* Ensures the column stays above the table cells */
            min-width: 100px; 
        }
        
        .sticky-column-4 {
            position: sticky;
            left: 250px;
            z-index: 1; /* Ensures the column stays above the table cells */
            min-width: 200px; 
        }
        
        .sticky-column-5 {
            position: sticky;
            left: 450px;
            z-index: 1; /* Ensures the column stays above the table cells */
            min-width: 50px; 
        }
        
        .sticky-column-6 {
            position: sticky;
            left: 500px;
            z-index: 1; /* Ensures the column stays above the table cells */
            min-width: 50px; 
            box-shadow: 10px 0 10px -5px rgba(0, 0, 0, 0.2); /* Add a right shadow */
            border-right: 1px solid black !important;
        }
        
        select {
            width: 200px !important;
        }
    </style>
    
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
        <h1>Appraisal Discipline</h1>
    </div>

    <div class="card card-flush h-xl-100">
        <div class="card-body py-9">
            <form action="<?php echo base_url() ?>students/reports/generate-appraisal-discipline" method="GET">
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
                <form id="form" method="POST" action="<?php echo base_url() ?>students/reports/appraisal-discipline">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr class="text-center table-dark text-light">
                                    <th class="text-nowrap sticky-header sticky-column-1" style="z-index: 5 !important;">S.NO</th>
                                    <th class="text-nowrap sticky-header sticky-column-2" style="z-index: 5 !important;">Session</th>
                                    <th class="text-nowrap sticky-header sticky-column-3" style="z-index: 5 !important;">Student No</th>
                                    <th class="text-nowrap sticky-header sticky-column-4" style="z-index: 5 !important;">Name</th>
                                    <th class="text-nowrap sticky-header sticky-column-5" style="z-index: 5 !important;">Class</th>
                                    <th class="text-nowrap sticky-header sticky-column-6" style="z-index: 5 !important;">Section</th>
                                    
                                    <th class="text-nowrap sticky-header">Conduct</th>
                                    <th class="text-nowrap sticky-header">Behaviour</th>
                                    <th class="text-nowrap sticky-header">Punctuality</th>
                                    <th class="text-nowrap sticky-header">Attendence</th>
                                    <th class="text-nowrap sticky-header">Leadership</th>
                                    <th class="text-nowrap sticky-header">Interaction</th>
                                    <th class="text-nowrap sticky-header">Expressiveness</th>
                                    <th class="text-nowrap sticky-header">Participation</th>
                                </tr>
                            </thead>
                            
                            <tbody>
                                <?php $i = 0; foreach($records as $record) { $i++; ?>
                                    <tr>
                                        <td class="text-center text-nowrap sticky-column-1" style="background-color: #fbffd1 !important;"><?php echo $i; ?></td>
                        
                                        <td class="text-center text-nowrap sticky-column-2" style="background-color: #fbffd1 !important;">
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
                        
                                        <td class="text-center text-nowrap sticky-column-3" style="background-color: #fbffd1 !important;"><?php echo $record['student_no'] ?></td>
                        
                                        <td class="text-center text-nowrap sticky-column-4" style="background-color: #fbffd1 !important;"><?php echo $record['f_name'] . ' ' . $record['m_name'] . ' ' . $record['l_name']; ?></td>
                        
                                        <td class="text-center text-nowrap sticky-column-5" style="background-color: #fbffd1 !important;">
                                            <?php echo $class_map[$record['student_session_class_id']] ?>
                                        </td>
                        
                                        <td class="text-center text-nowrap sticky-column-6" style="background-color: #fbffd1 !important;">
                                            <?php echo $section_map[$record['student_session_section_id']] ?>
                                        </td>
                        
                                        <td>
                                            <select class="form-select" name="conduct_id[]">
                                                <option value="">Select</option>
                                                
                                                <?php foreach($conducts as $conduct) { ?>
                                                    <option value="<?php echo $conduct['id'] ?>" <?php if(isset($record['conduct_id']) && $conduct['id'] == $record['conduct_id']) {echo "selected";}  ?>><?php echo $conduct['name'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        
                                        <td>
                                            <!-- Behaviours Dropdown -->
                                            <select class="form-select" name="behaviour_id[]">
                                                <option value="">Select</option>
                                                <?php foreach($behaviours as $behaviour) { ?>
                                                    <option value="<?php echo $behaviour['id'] ?>" <?php if(isset($record['behaviour_id']) && $behaviour['id'] == $record['behaviour_id']) {echo "selected";}  ?>><?php echo $behaviour['name'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        
                                        <td>
                                            <select class="form-select" name="punctuality_id[]">
                                                <option value="">Select</option>
                                                <?php foreach($punctualities as $punctuality) { ?>
                                                    <option value="<?php echo $punctuality['id'] ?>" <?php if(isset($record['punctuality_id']) && $punctuality['id'] == $record['punctuality_id']) {echo "selected";}  ?>><?php echo $punctuality['name'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        
                                        <td>
                                            <select class="form-select" name="attendance_id[]">
                                                <option value="">Select</option>
                                                <?php foreach($attendancees as $attendance) { ?>
                                                    <option value="<?php echo $attendance['id'] ?>" <?php if(isset($record['attendance_id']) && $attendance['id'] == $record['attendance_id']) {echo "selected";}  ?>><?php echo $attendance['name'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        
                                        <td>
                                            <select class="form-select" name="leadership_id[]">
                                                <option value="">Select</option>
                                                <?php foreach($leaderships as $leadership) { ?>
                                                    <option value="<?php echo $leadership['id'] ?>" <?php if(isset($record['leadership_id']) && $leadership['id'] == $record['leadership_id']) {echo "selected";}  ?>><?php echo $leadership['name'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        
                                        <td>
                                           <select class="form-select" name="interaction_id[]">
                                                <option value="">Select</option>
                                                <?php foreach($interactions as $interaction) { ?>
                                                    <option value="<?php echo $interaction['id'] ?>" <?php if(isset($record['interaction_id']) && $interaction['id'] == $record['interaction_id']) {echo "selected";}  ?>><?php echo $interaction['name'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        
                                        <td>
                                            <select class="form-select" name="expressiveness_id[]">
                                                <option value="">Select</option>
                                                <?php foreach($expressiveness as $exp) { ?>
                                                    <option value="<?php echo $exp['id'] ?>" <?php if(isset($record['expressiveness_id']) && $exp['id'] == $record['expressiveness_id']) {echo "selected";}  ?>><?php echo $exp['name'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        
                                        <td>
                                            <select class="form-select" name="participation_id[]">
                                                <option value="">Select</option>
                                                <?php foreach($participations as $participation) { ?>
                                                    <option value="<?php echo $participation['id'] ?>" <?php if(isset($record['participation_id']) && $participation['id'] == $record['participation_id']) {echo "selected";}  ?>><?php echo $participation['name'] ?></option>
                                                <?php } ?>
                                            </select>
                                            
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