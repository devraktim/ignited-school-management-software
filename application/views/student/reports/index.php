<?php $this->load->view("inc/app_header.php"); ?>

    <div class="row mb-5">
        <h1>Student Report</h1>
    </div>

    <form id="form" method="POST" action="" target="_blank">
        <div class="row mb-5">
            <div class="col-md-12">
                <div class="card card-flush h-xl-100">
                    <div class="card-body py-9">
                        <h4 class="text-center text-dark bg-secondary py-3 mb-3">Report Criteria</h4>
                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td style="vertical-align: middle;">Class</td>
                                        <td>
                                            <select class="form-select" id="class_id" name="ss.class_id"  value="<?php echo set_value('class_id'); ?>">
                                                <option value="">Any</option>
                                                <?php foreach ($classes as $class) { ?>
                                                    <option value="<?php echo $class["id"] ?>" <?php if(isset($_GET['class_id']) && ($_GET['class_id'] == $class['id'])) {echo "selected";} ?>><?php echo $class["name"] ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        <td style="vertical-align: middle;">Section</td>
                                        <td>
                                            <select class="form-select" id="section_id" name="ss.section_id"  value="<?php echo set_value('section_id'); ?>">
                                                <option value="">Any</option>
                                                <?php foreach ($sections as $section) { ?>
                                                    <option value="<?php echo $section["id"] ?>" <?php if(isset($_GET['section_id']) && ($_GET['section_id'] == $section['id'])) {echo "selected";} ?>><?php echo $section["name"] ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        <td style="vertical-align: middle;">Student Type</td>
                                        <td>
                                            <select class="form-select" name="s.student_type_id"  value="<?php echo set_value('student_type_id'); ?>">
                                                <option value="">Any</option>
                                                <?php foreach ($student_types as $type) { ?>
                                                    <option value="<?php echo $type["id"] ?>" <?php if(isset($_GET['student_type_id']) && ($_GET['student_type_id'] == $type['id'])) {echo "selected";} ?>><?php echo $type["name"] ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        <td style="vertical-align: middle;">House</td>
                                        <td>
                                            <select class="form-select"  name="s.house_id" value="<?php echo set_value('house_id'); ?>">
                                                <option value="">Any</option>
                                                <?php foreach ($houses as $house) { ?>
                                                    <option value="<?php echo $house["id"] ?>" <?php if(isset($_GET['house_id']) && ($_GET['house_id'] == $house['id'])) {echo "selected";} ?>><?php echo $house["name"] ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="vertical-align: middle;">Sex</td>
                                        <td>
                                            <select class="form-select" name="s.sex"  value="<?php echo set_value('sex'); ?>">
                                                <option value="">Any</option>
                                                <option value="male" <?php if(isset($_GET['sex']) && ($_GET['sex'] == 'male')) {echo "selected";} ?>>Male</option>
                                                <option value="female" <?php if(isset($_GET['sex']) && ($_GET['sex'] == 'female')) {echo "selected";} ?>>Female</option>
                                                <option value="other" <?php if(isset($_GET['sex']) && ($_GET['sex'] == 'other')) {echo "selected";} ?>>Other</option>
                                            </select>
                                        </td>
                                        <td style="vertical-align: middle;">Medical Status</td>
                                        <td>
                                            <select class="form-select" name="s.medical_status" value="<?php echo set_value('medical_status'); ?>">
                                                <option value="">Any</option>
                                                <option value="fit" <?php if(isset($_GET['medical_status']) && ($_GET['medical_status'] == 'fit')) {echo "selected";} ?>>Fit</option>
                                                <option value="differently_abled" <?php if(isset($_GET['medical_status']) && ($_GET['medical_status'] == 'differently_abled')) {echo "selected";} ?>>Differently Abled</option>
                                            </select>
                                        </td>
                                        <td style="vertical-align: middle;">Category</td>
                                        <td>
                                            <select class="form-select" name="s.category_id" value="<?php echo set_value('category_id'); ?>">
                                                <option value="">Any</option>
                                                <?php foreach ($categories as $category) { ?>
                                                    <option value="<?php echo $category["id"] ?>" <?php if(isset($_GET['category_id']) && ($_GET['category_id'] == $category['id'])) {echo "selected";} ?>><?php echo $category["name"] ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        <td style="vertical-align: middle;">Religion</td>
                                        <td>
                                            <select class="form-select" name="s.religion_id" value="<?php echo set_value('religion_id'); ?>">
                                                <option value="">Any</option>
                                                <?php foreach ($religions as $religion) { ?>
                                                    <option value="<?php echo $religion["id"] ?>" <?php if(isset($_GET['religion_id']) && ($_GET['religion_id'] == $religion['id'])) {echo "selected";} ?>><?php echo $religion["name"] ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="vertical-align: middle;">Nationality</td>
                                        <td>
                                            <select class="form-select" name="s.nationality_id" value="<?php echo set_value('nationality_id'); ?>">
                                                <option value="">Any</option>
                                                <?php foreach ($nationalities as $nationality) { ?>
                                                    <option value="<?php echo $nationality["id"] ?>" <?php if(isset($_GET['nationality_id']) && ($_GET['nationality_id'] == $nationality['id'])) {echo "selected";} ?>><?php echo $nationality["name"] ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        <td style="vertical-align: middle;">State</td>
                                        <td>
                                            <select class="form-select" name="s.state_id" value="<?php echo set_value('state_id'); ?>">
                                                <option value="">Any</option>
                                                <?php foreach ($states as $state) { ?>
                                                    <option value="<?php echo $state["id"] ?>" <?php if(isset($_GET['state_id']) && ($_GET['state_id'] == $state['id'])) {echo "selected";} ?>><?php echo $state["name"] ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-md-4">
                <div class="card card-flush h-xl-100">
                    <div class="card-body py-9">
                        <h4 class="text-center text-dark bg-secondary py-3 mb-3">Break up Reports</h4>
                        <button type="button" target="_blank" href="" class="btn btn-primary mb-3 w-100" onclick="report('breakup-class')">Class wise Breakup</button>
                        <button type="button" target="_blank" href="" class="btn btn-primary mb-3 w-100" onclick="report('breakup-student-type')">Student Type wise Break up</button>
                        <button type="button" target="_blank" href="" class="btn btn-primary mb-3 w-100" onclick="report('breakup-house')">House wise Break up</button>
                        <button type="button" target="_blank" href="" class="btn btn-primary mb-3 w-100" onclick="report('breakup-sex')">Sex wise Break up</button>
                        <button type="button" target="_blank" href="" class="btn btn-primary mb-3 w-100" onclick="report('breakup-category')">Category wise Break up</button>
                        <button type="button" target="_blank" href="" class="btn btn-primary mb-3 w-100" onclick="report('breakup-religion')">Religion wise Break up</button>
                        <button type="button" target="_blank" href="" class="btn btn-primary mb-3 w-100" onclick="report('breakup-state')">State wise Break up</button>
                        <button type="button" target="_blank" href="" class="btn btn-primary mb-3 w-100" onclick="report('breakup-nationality')">Nationality wise Break up</button>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-flush h-xl-100">
                    <div class="card-body py-9">
                        <h4 class="text-center text-dark bg-secondary py-3 mb-3">List Reports</h4>
                        <button type="button" target="_blank" href="<?php echo base_url() ?>students/reports/student-list" class="btn btn-primary mb-3 w-100" onclick="report('student-list')">Student List Report</button>
                        <button type="button" target="_blank" href="<?php echo base_url() ?>students/reports/new-admissions" class="btn btn-primary mb-3 w-100" onclick="report('new-admission')">New Admissions</button>
                        <button type="button" target="_blank" href="<?php echo base_url() ?>students/reports/inactive-students" class="btn btn-primary mb-3 w-100" onclick="report('inactive-student')">Inactive Students</button>
                        <button type="button" target="_blank" href="<?php echo base_url() ?>students/reports/student-password" class="btn btn-primary mb-3 w-100" onclick="report('student-password')">Student Website Password</button>
                        <button type="button" target="_blank" href="<?php echo base_url() ?>students/reports/report-promotion" class="btn btn-primary mb-3 w-100" onclick="report('report-promotion')">Promotion Report</button>
                        <button type="button" target="_blank" href="<?php echo base_url() ?>students/reports/report-passout" class="btn btn-primary mb-3 w-100" onclick="report('report-passout')">Passout Report</button>
                        <button type="button" target="_blank" href="<?php echo base_url() ?>students/reports/report-withdraw" class="btn btn-primary mb-3 w-100" onclick="report('report-withdraw')">Withdraw Report</button>
                        <button type="button" target="_blank" href="<?php echo base_url() ?>students/reports/subject-list" class="btn btn-primary mb-3 w-100" onclick="report('subject-list')">Student Subject List</button>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-flush h-xl-100">
                    <div class="card-body py-9">
                        <h4 class="text-center text-dark bg-secondary py-3 mb-3">Other Reports</h4>
                        
                        <?php if($this->session->user['permissions'][0]['student_module'] != "VIEWER") { ?>
                        <h6 class="text-center text-muted">Horizental ID Card</h6>
                        <div class="d-flex">
                            <button type="button" target="_blank" href="<?php echo base_url() ?>students/reports/generate-horizental-id-cards" class="btn btn-primary mb-3 w-100" onclick="report('generate-horizental-id-cards')">Generate All ID Cards</button>
                        </div>
                        
                        <div class="d-flex">
                            <input type="text" class="form-control form-sm me-2" placeholder="Student No" name="student_no" style="height: 45px !important;" />
                            <button type="button" target="_blank" href="<?php echo base_url() ?>generate-individual-horizental-id-card" class="btn btn-primary mb-3 w-100" onclick="report('generate-individual-horizental-id-card')">Generate ID Card</button>
                        </div>
                        <?php } ?>
                        
                        <?php if($this->session->user['permissions'][0]['student_module'] != "VIEWER") { ?>
                        <h6 class="text-center text-muted">Vertical ID Card</h6>
                        <div class="d-flex">
                            <button type="button" target="_blank" href="<?php echo base_url() ?>students/reports/generate-vertical-id-cards" class="btn btn-primary mb-3 w-100" onclick="report('generate-vertical-id-cards')">Generate All ID Cards</button>
                        </div>
                        
                        <div class="d-flex">
                            <input type="text" class="form-control form-sm me-2" placeholder="Student No" name="student_no" style="height: 45px !important;" />
                            <button type="button" target="_blank" href="<?php echo base_url() ?>students/reports/generate-individual-vertical-id-card" class="btn btn-primary mb-3 w-100" onclick="report('generate-individual-vertical-id-card')">Generate ID Card</button>
                        </div>
                        <?php } ?>
                        
                        <!--<div class="d-flex">-->
                        <!--    <input type="text" class="form-control form-sm me-2" placeholder="Student No" name="student_no" style="height: 45px !important;" />-->
                        <!--    <button type="button" target="_blank" href="<?php echo base_url() ?>students/reports/generate-individual-biodata" class="btn btn-primary mb-3 w-100" onclick="report('generate-individual-biodata')">Generate Biodata</button>-->
                        <!--</div>-->
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-flush h-xl-100">
                    <div class="card-body py-9">
                        <h4 class="text-center text-dark bg-secondary py-3 mb-3">Appraisal Report</h4>
                        <button type="button" target="_blank" class="btn btn-primary mb-3 w-100" onclick="report('download-appraisal-academic')">Academic</button>
                        
                        <button type="button" target="_blank" class="btn btn-primary mb-3 w-100" onclick="report('download-appraisal-extra-curricular')">Extra Curricular</button>
                        
                        <button type="button" target="_blank" class="btn btn-primary mb-3 w-100" onclick="report('download-appraisal-game-and-sports')">Game & Sports</button>
                        
                        <button type="button" target="_blank" class="btn btn-primary mb-3 w-100" onclick="report('download-appraisal-discipline')">Discipline</button>
                        
                        <button type="button" target="_blank" class="btn btn-primary mb-3 w-100" onclick="report('download-appraisal-others')">Others</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <script>
        function report(name) {
            if(name == "student-list") {
                $("input[name='student_no']").val('')
                $("#form").attr("method", "POST");
                $("#form").attr("action", `<?php echo base_url() ?>students/reports/${name}`);
            }
            else if(name == "new-admission") {
                $("input[name='student_no']").val('')
                $("#form").attr("method", "POST");
                $("#form").attr("action", `<?php echo base_url() ?>students/reports/${name}`);
            }
            else if(name == "inactive-student") {
                $("input[name='student_no']").val('')
                $("#form").attr("method", "POST");
                $("#form").attr("action", `<?php echo base_url() ?>students/reports/${name}`);
            }
            else if(name == "student-password") {
                $("input[name='student_no']").val('')
                $("#form").attr("method", "POST");
                $("#form").attr("action", `<?php echo base_url() ?>students/reports/${name}`);
            }
            else if(name == "breakup-class") {
                $("input[name='student_no']").val('')
                $("#form").attr("method", "GET");
                $("#form").attr("action", `<?php echo base_url() ?>students/reports/${name}`);
            }
            else if(name == "breakup-student-type") {
                $("input[name='student_no']").val('')
                $("#form").attr("method", "GET");
                $("#form").attr("action", `<?php echo base_url() ?>students/reports/${name}`);
            }
            else if(name == "breakup-house") {
                $("input[name='student_no']").val('')
                $("#form").attr("method", "GET");
                $("#form").attr("action", `<?php echo base_url() ?>students/reports/${name}`);
            }
            else if(name == "breakup-sex") {
                $("input[name='student_no']").val('')
                $("#form").attr("method", "GET");
                $("#form").attr("action", `<?php echo base_url() ?>students/reports/${name}`);
            }
            else if(name == "breakup-category") {
                $("input[name='student_no']").val('')
                $("#form").attr("method", "GET");
                $("#form").attr("action", `<?php echo base_url() ?>students/reports/${name}`);
            }
            else if(name == "breakup-religion") {
                $("input[name='student_no']").val('')
                $("#form").attr("method", "GET");
                $("#form").attr("action", `<?php echo base_url() ?>students/reports/${name}`);
            }
            else if(name == "breakup-state") {
                $("input[name='student_no']").val('')
                $("#form").attr("method", "GET");
                $("#form").attr("action", `<?php echo base_url() ?>students/reports/${name}`);
            }
            else if(name == "breakup-nationality") {
                $("input[name='student_no']").val('')
                $("#form").attr("method", "GET");
                $("#form").attr("action", `<?php echo base_url() ?>students/reports/${name}`);
            }
            else if(name == "report-promotion") {
                $("input[name='student_no']").val('')
                $("#form").attr("method", "POST");
                $("#form").attr("action", `<?php echo base_url() ?>students/reports/${name}`);
            }
            else if(name == "report-passout") {
                $("input[name='student_no']").val('')
                $("#form").attr("method", "POST");
                $("#form").attr("action", `<?php echo base_url() ?>students/reports/${name}`);
            }
            else if(name == "report-withdraw") {
                $("input[name='student_no']").val('')
                $("#form").attr("method", "POST");
                $("#form").attr("action", `<?php echo base_url() ?>students/reports/${name}`);
            }
            else if(name == "generate-horizental-id-cards") {
                $("input[name='student_no']").val('')
                $("#form").attr("method", "POST");
                $("#form").attr("action", `<?php echo base_url() ?>students/reports/${name}`);
            }
            else if(name == "generate-individual-horizental-id-card") {
                $("#form").attr("method", "POST");
                $("#form").attr("action", `<?php echo base_url() ?>students/reports/${name}`);
            }
            else if(name == "generate-vertical-id-cards") {
                $("input[name='student_no']").val('')
                $("#form").attr("method", "POST");
                $("#form").attr("action", `<?php echo base_url() ?>students/reports/${name}`);
            }
            else if(name == "generate-individual-vertical-id-card") {
                $("#form").attr("method", "POST");
                $("#form").attr("action", `<?php echo base_url() ?>students/reports/${name}`);
            }
            else if(name == "generate-all-biodata") {
                $("#form").attr("method", "POST");
                $("#form").attr("action", `<?php echo base_url() ?>students/reports/${name}`);
            }
            else if(name == "generate-individual-biodata") {
                $("#form").attr("method", "POST");
                $("#form").attr("action", `<?php echo base_url() ?>students/reports/${name}`);
            }
            else if(name == "download-appraisal-extra-curricular") {
                $("input[name='student_no']").val('')
                $("#form").attr("method", "POST");
                $("#form").attr("action", `<?php echo base_url() ?>students/reports/${name}`);
            }
            else if(name == "download-appraisal-game-and-sports") {
                $("input[name='student_no']").val('')
                $("#form").attr("method", "POST");
                $("#form").attr("action", `<?php echo base_url() ?>students/reports/${name}`);
            }
            else if(name == "download-appraisal-others") {
                $("input[name='student_no']").val('')
                $("#form").attr("method", "POST");
                $("#form").attr("action", `<?php echo base_url() ?>students/reports/${name}`);
            }
            else if(name == "download-appraisal-discipline") {
                $("input[name='student_no']").val('')
                $("#form").attr("method", "POST");
                $("#form").attr("action", `<?php echo base_url() ?>students/reports/${name}`);
            }
            else if(name == "appraisal-others") {
                $("input[name='student_no']").val('')
                $("#form").attr("method", "POST");
                $("#form").attr("action", `<?php echo base_url() ?>students/reports/${name}`);
            }
            else if(name == "subject-list") {
                $("input[name='student_no']").val('')
                $("#form").attr("method", "POST");
                $("#form").attr("action", `<?php echo base_url() ?>students/reports/${name}`);
            }
            else if(name == "download-appraisal-academic") {
                $("input[name='student_no']").val('')
                $("#form").attr("method", "POST");
                $("#form").attr("action", `<?php echo base_url() ?>students/reports/${name}`);
            }
            else {
                
            }
            
            $("#form").submit()
        }

        function fetch_section() {
            $("#class_id").val()
            fetch("<?php echo base_url('students?class_id=') ?>" + $("#class_id").val())
            .then(response => response.json())
            .then(data => {
                $("#section_id").empty()

                $("#section_id").append(`
                    <option value=''>Any</option>
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
            $("#section_id").prop("disabled", true)

            fetch_section()
            
            $("#class_id").change(function(event) {
                fetch_section()
            })
        })
    </script>


<?php $this->load->view("inc/app_footer.php"); ?>