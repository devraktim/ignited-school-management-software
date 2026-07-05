<?php $this->load->view("inc/app_header.php"); ?>

    <div class="row mb-5">
        <div class="col-md-6">
            <h1>Marks Entry</h1>
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

    <div class="card card-flush h-xl-100 mb-5">
        <div class="card-body py-9">
            <form action="<?php echo base_url() ?>academics/marks-entry-filter" method="POST">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <div class="form-group">
                            <label class="form-label">Class</label>
                            <select class="form-select" name="class_id" id="class_id" required>
                                <option value="">Please Select</option>
                                <?php foreach ($classes as $class) { ?>
                                    <option value="<?php echo $class["id"] ?>" <?php if(isset($class_id) && $class_id == $class["id"]) {echo "selected";}?>><?php echo $class["name"]  ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="form-group">
                            <label class="form-label">Section</label>
                            <select class="form-select" id="section_id" name="section_id" required <?php if(!isset($sections)) { echo "disabled"; }?>>
                                <?php foreach ($sections as $section) { ?>
                                    <option value="<?php echo $section["id"] ?>" <?php if(isset($section_id) && $section_id == $section["id"]) {echo "selected";}?>><?php echo $section["name"] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label">Exams</label>
                            <select class="form-select" id="exam_id" name="exam_id" required <?php if(!isset($exam_id)) { echo "disabled"; }?>>
                                <?php foreach ($exams as $exam) { ?>
                                    <option value="<?php echo $exam["id"] ?>" <?php if(isset($exam_id) && $exam_id == $exam["id"]) {echo "selected";}?>> <?php echo $exam['name'] ?> (<?php echo $exam['short_name'] ?>) </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label">Component</label>
                            <select class="form-select" id="component_id" name="component_id" required <?php if(!isset($component_id)) { echo "disabled"; }?>>
                                <?php foreach ($components as $component) { ?>
                                    <option value="<?php echo $component["id"] ?>" <?php if(isset($component_id) && $component_id == $component["id"]) {echo "selected";}?>> <?php echo $component['name'] ?> </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <!--<div class="col-md-3">-->
                    <!--    <div class="form-group">-->
                    <!--        <label class="form-label">Subject Type</label>-->
                    <!--        <select class="form-select" id="subject_type_id" name="subject_type_id" required <?php if(!isset($subject_type_id)) { echo "disabled"; }?>>-->
                    <!--        </select>-->
                    <!--    </div>-->
                    <!--</div>-->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label">Subject</label>
                            <select class="form-select" id="subject_id" name="subject_id" required <?php if(!isset($subject_id)) { echo "disabled"; }?>>
                                <?php foreach ($subjects as $subject) { ?>
                                    <option value="<?php echo $subject["id"] ?>" <?php if(isset($subject_id) && $subject_id == $subject["id"]) {echo "selected";}?>> <?php echo $subject['name'] ?> </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3" style="margin-top: 25px;">
                        <button id="btn_save" class="btn btn-success" disabled>
                            <i class="fa fa-search"></i> Search
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <?php if(isset($students)) { ?>
        <?php if(count($students) > 0) { ?>
            <form action="<?php echo base_url()?>academics/marks-store-filter/" method="POST">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card card-flush h-xl-100">
                            <div class="card-body py-9">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr class="table-dark text-light">
                                                <th></th>
                                                <th>Student No</th>
                                                <th>Roll No</th>
                                                <th>Name</th>
                                                <th>Marks</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 0;foreach($students as $student) { $i++; ?>
                                                <tr>
                                                    <td class="table-primary text-dark p-2"><?php echo $i; ?></td>
                                                    <td><?php echo $student["student_no"]?> </td>
                                                    <td><?php echo $student["roll_no"]?> </td>
                                                    <td><?php echo $student["f_name"] . " " . $student["m_name"] . " " . $student["l_name"] ?></td>
                                                    <td>
                                                        <input type="text" class="form-control d-none" name="ids[]" value="<?php echo $student["id"] ?>" />    
                                                        <input 
                                                            type="text" 
                                                            class="form-control" 
                                                            name="marks[]" 
                                                            min="0" 
                                                            max="<?php echo $full_marks; ?>" 
                                                            value="<?php echo $student['marks']; ?>" 
                                                            onchange="marks_input(this)" 
                                                        />  
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table> 
                                </div>
                            </div>
                        </div>
                </div>
                    
                    <div class="col-md-4">
                        <div class="card card-flush h-xl-100">
                            <div class="card-body py-9">
                                <div class="table-responsive">
                                    <table class="table">
                                        <tbody>
                                            <tr class="table-dark">
                                                <td colspan="2">
                                                    <h3 class="text-white ps-3 mb-0">Examination Paper Details</h3>
                                                </td>
                                            </tr> 
                                            <tr>
                                                <td><h4>Subject</h4></td>
                                                <td><?php echo $subject_name ?></td>
                                            </tr> 
                                            <tr>
                                                <td><h4>Component</h4></td>
                                                <td><?php echo $component_name ?></td>
                                            </tr>
                                            <tr>
                                                <td><h4>Full Marks</h4></td>
                                                <td><?php echo $full_marks ?></td>
                                            </tr>
                                            <tr>
                                                <td><h4>Pass Marks</h4></td>
                                                <td><?php echo $pass_marks ?></td>
                                            </tr>
                                            <tr class="table-dark">
                                                <td colspan="2">
                                                    <h3 class="text-white ps-3 mb-0">Permissible Values</h3>
                                                </td>
                                            </tr> 
                                            <tr>
                                                <td><h4>Blank</h4></td>
                                                <td>If Marks is not available</td>
                                            </tr> 
                                            <tr>
                                                <td><h4>Marks</h4></td>
                                                <td>If Marks available</td>
                                            </tr>
                                            <tr>
                                                <td><h4>AB</h4></td>
                                                <td>If student is absent</td>
                                            </tr>
                                            <tr>
                                                <td><h4>R</h4></td>
                                                <td>If student has been reported against</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <input type="text" class="form-control d-none" name="class_id"     value="<?php echo $class_id ?>">
                <input type="text" class="form-control d-none" name="section_id"   value="<?php echo $section_id ?>">
                <input type="text" class="form-control d-none" name="exam_id"      value="<?php echo $exam_id ?>">
                <input type="text" class="form-control d-none" name="subject_id"   value="<?php echo $subject_id ?>">

                <?php if($this->session->user['permissions'][0]['academics_module'] != "VIEWER") { ?>
                    <?php if($assign_teacher_for_marks_entry == "1") { ?>   
                        <?php if($entry_status) { ?>
                            <button
                                type="submit"
                                class="btn btn-success rounded rounded-pill mt-4"
                            >
                                <i class="fa fa-plus"></i>
                                Save
                            </button>
                        <?php } else { ?>

                            <div class="alert alert-danger mt-4 mb-0">
                                <i class="fa fa-lock me-2"></i>

                                <strong>Marks Entry Not Available</strong>

                                <?php if(!empty($entry_message)){ ?>
                                    - <?php echo $entry_message; ?>
                                <?php } ?>

                            </div>

                        <?php } ?>

                    <?php } else { ?>
                        <button
                            type="submit"
                            class="btn btn-success rounded rounded-pill mt-4"
                        >
                            <i class="fa fa-plus"></i>
                            Save
                        </button>
                    <?php } ?>
                <?php } ?>
            </form>
        <?php } else { ?>
            <div class="card card-flush h-xl-100">
                <div class="card-body py-9">
                    <h1 class="text-center text-muted">Students Not Found</h1>
                </div>
            </div>
        <?php } ?>
    <?php } ?>

<script>
/**
 * =========================================================
 * ENABLE SEARCH BUTTON WHEN ALL FILTERS ARE SELECTED
 * =========================================================
 */
function toggleSearchButton() {

    const classId = $("#class_id").val();
    const sectionId = $("#section_id").val();
    const examId = $("#exam_id").val();
    const componentId = $("#component_id").val();
    const subjectId = $("#subject_id").val();

    if (classId && sectionId && examId && componentId && subjectId) {
        $("#btn_save").prop("disabled", false);
    } else {
        $("#btn_save").prop("disabled", true);
    }
}

/**
 * =========================================================
 * 1. CLASS CHANGE → LOAD SECTIONS
 * =========================================================
 */
$("#class_id").change(function () {

    const classId = $("#class_id").val();

    $("#btn_save").prop("disabled", true);

    $("#section_id").html(`<option value="">Please Select</option>`);
    $("#exam_id").html(`<option value="">Please Select</option>`);
    $("#component_id").html(`<option value="">Please Select</option>`);
    $("#subject_id").html(`<option value="">Please Select</option>`);

    $("#section_id").prop("disabled", true);
    $("#exam_id").prop("disabled", true);
    $("#component_id").prop("disabled", true);
    $("#subject_id").prop("disabled", true);

    if (!classId) {
        toggleSearchButton();
        return;
    }

    fetch("<?php echo base_url('academics/marks-entry-filter?class_id=') ?>" + classId)
        .then(res => res.json())
        .then(data => {

            data.sections.forEach(section => {
                $("#section_id").append(`
                    <option value="${section.id}">${section.name}</option>
                `);
            });

            $("#section_id").prop("disabled", false);
            toggleSearchButton();
        });
});


/**
 * =========================================================
 * 2. SECTION CHANGE → LOAD EXAMS
 * =========================================================
 */
$("#section_id").change(function () {

    const classId = $("#class_id").val();
    const sectionId = $("#section_id").val();

    $("#btn_save").prop("disabled", true);

    $("#exam_id").html(`<option value="">Please Select</option>`);
    $("#component_id").html(`<option value="">Please Select</option>`);
    $("#subject_id").html(`<option value="">Please Select</option>`);

    $("#exam_id").prop("disabled", true);
    $("#component_id").prop("disabled", true);
    $("#subject_id").prop("disabled", true);

    if (!classId || !sectionId) {
        toggleSearchButton();
        return;
    }

    fetch("<?php echo base_url('academics/marks-entry-filter') ?>" +
        `?class_id=${classId}&section_id=${sectionId}`)
        .then(res => res.json())
        .then(data => {

            data.exams.forEach(exam => {
                $("#exam_id").append(`
                    <option value="${exam.id}">${exam.name}</option>
                `);
            });

            $("#exam_id").prop("disabled", false);
            toggleSearchButton();
        });
});


/**
 * =========================================================
 * 3. EXAM CHANGE → LOAD COMPONENTS + SUBJECTS
 * =========================================================
 */
$("#exam_id").change(function () {

    const classId = $("#class_id").val();
    const sectionId = $("#section_id").val();
    const examId = $("#exam_id").val();

    $("#btn_save").prop("disabled", true);

    $("#component_id").html(`<option value="">Please Select</option>`);
    $("#subject_id").html(`<option value="">Please Select</option>`);

    $("#component_id").prop("disabled", true);
    $("#subject_id").prop("disabled", true);

    if (!classId || !sectionId || !examId) {
        toggleSearchButton();
        return;
    }

    fetch("<?php echo base_url('academics/marks-entry-filter') ?>" +
        `?class_id=${classId}&section_id=${sectionId}&exam_id=${examId}`)
        .then(res => res.json())
        .then(data => {

            data.components.forEach(component => {
                $("#component_id").append(`
                    <option value="${component.id}">${component.name}</option>
                `);
            });

            data.subjects.forEach(subject => {
                $("#subject_id").append(`
                    <option value="${subject.id}">${subject.name}</option>
                `);
            });

            $("#component_id").prop("disabled", false);
            $("#subject_id").prop("disabled", false);

            toggleSearchButton();
        });
});


/**
 * =========================================================
 * 4. COMPONENT & SUBJECT CHANGE
 * =========================================================
 */
$("#component_id").change(function () {
    toggleSearchButton();
});

$("#subject_id").change(function () {
    toggleSearchButton();
});


/**
 * =========================================================
 * MARKS VALIDATION
 * =========================================================
 */
function marks_input(input) {

    const maxMarks = Number(input.max);
    const value = input.value.trim();

    if (value === '' || isNaN(value)) return;

    const numValue = Number(value);

    if (numValue > maxMarks) {
        alert(`Marks cannot exceed ${maxMarks}`);
        input.value = '';
    }
}


/**
 * =========================================================
 * INITIAL STATE
 * =========================================================
 */
$(document).ready(function () {
    $("#btn_save").prop("disabled", true);
    toggleSearchButton();
});
</script>
<?php $this->load->view("inc/app_footer.php"); ?>