<?php $this->load->view("inc/app_header.php"); ?>

    <div class="row mb-5">
        <div class="col-md-6">
            <h1>Passport</h1>
        </div>
    </div>

    <div class="row mb-5">
        <div class="col-md-12 mb-5">
            <div class="card card-flush h-xl-100">
                <div class="card-body py-9">
                    <form action="<?php echo base_url() ?>students/passport" method="GET">
                        <div class="row align-items-end">
                            <div class="col-md-3">
                                <label class="form-label">Class</label>
                                <select class="form-select" id="class_id" name="class_id">
                                    <option value="">Any</option>
                                    <?php foreach($classes as $class) { ?>
                                        <option value="<?php echo $class['id'] ?>" <?php if(isset($_GET['class_id']) && ($_GET['class_id'] == $class['id'])) {echo "selected" ;} ?>><?php echo $class['name'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Section</label>
                                <select class="form-select" id="section_id" name="section_id">
                                    <option value="">Any</option>
                                    <?php foreach($sections as $section) { ?>
                                        <option value="<?php echo $section['id'] ?>" <?php if(isset($_GET['section_id']) && $_GET['section_id'] == $section['id']) {echo "selected" ;} ?>><?php echo $section['name'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Nationality</label>
                                <select class="form-select" name="nationality_id">
                                    <option value="">Any</option>
                                    <?php foreach($nationalities as $nationality) { ?>
                                        <option value="<?php echo $nationality['id'] ?>" <?php if(isset($_GET['nationality_id']) && $_GET['nationality_id'] == $nationality['id']) {echo "selected" ;} ?>><?php echo $nationality['name'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-success"><i class="fa fa-search"></i> Search</button> 
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-5">
        <div class="col-md-12 mb-5">
            <div class="card card-flush h-xl-100">
                <div class="card-body py-9">
                    <?php if(count($students) > 0) { ?>
                        <div class="table-responsive table-bordered table-striped table-hover">
                            <table class="table">
                                <thead>
                                    <tr class="text-center table-dark text-light">
                                        <th></th>
                                        <th colspan="4">Basic Details</th>
                                        <th colspan="5">Passport Details</th>
                                        <th></th>
                                    </tr>
                                    <tr class="text-center table-dark text-light">
                                        <th></th>
                                        <th>Student No</th>
                                        <th>Name</th>
                                        <th>Class</th>
                                        <th>Section</th>
                                        <th>Nationality</th>
                                        <th>Number</th>
                                        <th>Date of Issue</th>
                                        <th>Valid From</th>
                                        <th>Valid To</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $sl_no = 0; foreach($students as $student) {  $sl_no++; ?>
                                        <tr class="text-center">
                                            <td><?php echo $sl_no ?></td>
                                            <td><?php echo $student["student_no"] ?></td>
                                            <td><?php echo $student["f_name"] . " " . $student["m_name"] . " " . $student["l_name"]?></td>
                                            <td><?php echo $student["class"] ?></td>
                                            <td><?php echo $student["section"] ?></td>
                                            <td><?php echo $student["nationality"] ?></td>
                                            <td><?php echo $student["passport_no"] ?></td>
                                            <td><?php echo $student["passport_date_of_issue"] ?></td>
                                            <td><?php echo $student["passport_valid_from"] ?></td>
                                            <td><?php echo $student["passport_valid_to"] ?></td>
                                            <td>
                                                <a href="<?php echo base_url() ?>students/passport/show/<?php echo $student['id'] ?>" class="btn btn-sm btn-light">
                                                    <i class="fa fa-eye text-dark"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    <?php } else { ?>
                        <h2 class="text-center">No Student Fount</h2>
                    <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function fetch_section() {
        
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
            })
        }


        $(document).ready(function () {
            $("#section_id").prop("disabled", true)

            // fetch_section()
            
            $("#class_id").change(function(event) {
                fetch_section()
            })
        })
    </script>
<?php $this->load->view("inc/app_footer.php"); ?>