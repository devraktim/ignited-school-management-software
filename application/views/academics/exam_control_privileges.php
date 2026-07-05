<?php $this->load->view("inc/app_header.php"); ?>
<style>
.custom-tabs{
    border-bottom:none;
    gap:12px;
}

.custom-tabs .nav-link{
    border:none;
    border-radius:12px;
    padding:12px 25px;
    font-weight:600;
    color:#495057;
    background:#f1f5f9;
    transition:all .3s ease;
}

.custom-tabs .nav-link:hover{
    background:#e2e8f0;
}

.custom-tabs .nav-link.active{
    background:linear-gradient(135deg,#0d6efd,#4f8cff);
    color:#fff;
    box-shadow:0 5px 15px rgba(13,110,253,.25);
}

.tab-content{
    margin-top:20px;
}
</style>

    <style>
    .exam-table{
        min-width:1200px;
        table-layout:fixed;
    }

    .exam-table th,
    .exam-table td{
        vertical-align:middle;
    }

    .exam-table thead th{
        background:#0d6efd !important;
        color:#fff !important;
        font-weight:600;
        white-space:nowrap;
    }

    /* ===== Column Widths ===== */

    .col-sl{
        width:5%;
    }

    .col-subject{
        width:25%;
    }

    .col-component{
        width:10%;
    }

    .col-teachers{
        width:50%;
    }

    .col-action{
        width:10%;
    }

    /* ===== Sticky Columns ===== */

    .sticky-col-1{
        position:sticky;
        left:0;
        background:#fff;
        z-index:20;
    }

    .sticky-col-2{
        position:sticky;
        left:5%;
        background:#fff;
        z-index:20;
    }

    .sticky-col-3{
        position:sticky;
        left:30%;
        background:#fff;
        z-index:20;
    }

    .sticky-action{
        position:sticky;
        right:0;
        background:#fff;
        z-index:20;
    }

    /* ===== Teacher Section ===== */

    .teacher-container{
        display:flex;
        flex-wrap:nowrap;
        gap:8px;
        overflow-x:auto;
        padding-bottom:4px;
    }

    .teacher-container::-webkit-scrollbar{
        height:6px;
    }

    .teacher-badge{
        display:inline-flex;
        align-items:center;
        gap:10px;
        padding:8px 12px;
        border-radius:50px;
        border:1px solid #dee2e6;
        background:#f8f9fa;
        white-space:nowrap;
        box-shadow:0 1px 3px rgba(0,0,0,.08);
    }

    .teacher-badge:hover{
        background:#eef5ff;
    }

    /* ===== Action Buttons ===== */

    .action-buttons{
        display:flex;
        justify-content:center;
        gap:5px;
    }
    </style>

    <div class="row mb-5">
        <div class="col-md-6">
            <h1>Exam Control Paper Privileges</h1>
        </div>
        <div class="col-md-2"></div>
        <div class="col-md-4 text-center">
            <?php if ($this->session->flashdata("success")) { ?>
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    <strong><?php echo $this->session->flashdata(
                        "success"
                    ); ?></strong>
                </div>
            <?php } ?>
        </div>
    </div>


<div class="card card-flush h-xl-100 mb-5">
    <div class="card-body py-9">

        <ul class="nav custom-tabs" role="tablist">

            <?php if ($assign_teacher_for_marks_entry == "1") { ?>
                <li class="nav-item">
                    <button
                        class="nav-link active"
                        data-bs-toggle="tab"
                        data-bs-target="#marksPrivilegeTab"
                        type="button">
                        <i class="fa fa-edit me-2"></i>
                        Marks Entry Privileges
                    </button>
                </li>
            <?php } ?>

            <?php if ($assign_teacher_for_grade_entry == "1") { ?>
                <li class="nav-item">
                    <button
                        class="nav-link <?php echo ($assign_teacher_for_marks_entry != "1") ? 'active' : ''; ?>"
                        data-bs-toggle="tab"
                        data-bs-target="#gradePrivilegeTab"
                        type="button">
                        <i class="fa fa-graduation-cap me-2"></i>
                        Grade Entry Privileges
                    </button>
                </li>
            <?php } ?>

        </ul>
        
        <?php $isFirstPane = true; ?>

        <div class="tab-content">
            
            <?php if ($assign_teacher_for_marks_entry == "1") { ?>
            <div class="tab-pane fade show active" id="marksPrivilegeTab">

                <form action="<?php echo base_url(); ?>academics/exam-marks-control-privileges" method="POST">
                    <div class="row">

                        <div class="col-md-3 mb-3">
                            <label class="form-label">Class <span class="text-danger">*</span></label>
                            <select class="form-select marks-class" name="class_id" required>
                                <option value="">Please Select</option>
                                <?php foreach ($classes as $class) { ?>
                                    <option value="<?php echo $class[
                                        "id"
                                    ]; ?>" <?php if (
                                        isset($class_id) &&
                                        $class_id == $class["id"]
                                    ) {
                                        echo "selected";
                                    } ?>><?php echo $class["name"]; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">Section</label>
                            <select class="form-select marks-section" name="section_id">
                                <option value="">ALL</option>
                                <?php foreach ($sections as $section) { ?>
                                    <option value="<?php echo $section[
                                        "id"
                                    ]; ?>" <?php if (
                                        isset($section_id) &&
                                        $section_id == $section["id"]
                                    ) {
                                        echo "selected";
                                    } ?>><?php echo $section["name"]; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">Exams</label>
                            <select class="form-select marks-exam" name="exam_id">
                                <option value="">ALL</option>
                                <?php foreach ($exams as $exam) { ?>
                                    <option value="<?php echo $exam[
                                        "id"
                                    ]; ?>" <?php if (
                                        isset($exam_id) &&
                                        $exam_id == $exam["id"]
                                    ) {
                                        echo "selected";
                                    } ?>> <?php echo $exam["name"]; ?> (<?php echo $exam[
                                        "short_name"
                                    ]; ?>) 
                                    </option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="col-md-3 mb-3 d-none">
                            <label class="form-label">Component</label>
                            <select class="form-select marks-component" name="component_id">
                                <option value="">ALL</option>
                                <?php foreach ($components as $component) { ?>
                                    <option value="<?php echo $component[
                                        "id"
                                    ]; ?>" <?php if (
                                        isset($component_id) &&
                                        $component_id == $component["id"]
                                    ) {
                                        echo "selected";
                                    } ?>> <?php echo $component["name"]; ?> 
                                    </option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">Subject</label>
                            <select class="form-select marks-subject" name="subject_id">
                                <option value="">ALL</option>
                                <?php foreach ($subjects as $subject) { ?>
                                    <option value="<?php echo $subject[
                                        "id"
                                    ]; ?>" <?php if (
                                        isset($subject_id) &&
                                        $subject_id == $subject["id"]
                                    ) {
                                        echo "selected";
                                    } ?>> <?php echo $subject["name"]; ?> 
                                    </option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="col-md-3 mb-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-success">
                                <i class="fa fa-search"></i> Search
                            </button>
                        </div>

                    </div>
                </form>

            </div>
            <?php } ?>
            
            <?php if ($assign_teacher_for_grade_entry == "1") { ?>
            <div class="tab-pane fade <?php echo ($assign_teacher_for_marks_entry != "1") ? 'show active' : ''; ?>" id="gradePrivilegeTab">

                <form action="<?php echo base_url(); ?>academics/exam-grade-control-privileges" method="POST">
                    <div class="row">

                        <div class="col-md-3 mb-3">
                            <label class="form-label">Class <span class="text-danger">*</span></label>
                            <select class="form-select grade-class" name="class_id" required>
                                <option value="">Please Select</option>
                                <?php foreach ($classes as $class) { ?>
                                    <option value="<?php echo $class[
                                        "id"
                                    ]; ?>"><?php echo $class[
                                        "name"
                                    ]; ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">Section</label>
                            <select class="form-select grade-section" name="section_id" disabled>
                                <option value="">ALL</option>
                            </select>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">Exams</label>
                            <select class="form-select grade-exam" name="exam_id" disabled>
                                <option value="">ALL</option>
                            </select>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">Component</label>
                            <select class="form-select grade-component" name="component_id" disabled>
                                <option value="">ALL</option>
                            </select>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">Subject</label>
                            <select class="form-select grade-subject" name="subject_id" disabled>
                                <option value="">ALL</option>
                            </select>
                        </div>

                        <div class="col-md-3 mb-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-search"></i> Search
                            </button>
                        </div>

                    </div>
                </form>

            </div>
             <?php } ?>

        </div>

    </div>
</div>
 
<div class="row">
    <?php if (!empty($papers)) { ?>

    <div class="col-md-12 mt-3 mb-3">
        <div class="card card-flush h-xl-100">
            <div class="card-body py-9">

<div class="d-flex justify-content-between align-items-center mb-3">

    <div>
        <h5 class="mb-0">

            <?php if (!empty($exam_id)) {
                $exam = $this->Exam->get($exam_id);

                echo $exam["name"];
            } else {
                echo "All Exams";
            } ?>

        </h5>
    </div>

    <div>

        <?php if ($is_exam_locked) { ?>
            <button
                type="button"
                class="btn btn-danger btn-sm btn-toggle-exam-lock"

                data-paper-ids="<?php echo implode(",", $all_paper_ids); ?>"
                data-class-id="<?php echo $class_id; ?>"
                data-section-id="<?php echo $section_id; ?>"
                data-exam-id="<?php echo $exam_id; ?>"
                data-status="0"
            >
                <i class="fa fa-lock"></i>
               
                Open Exam
            </button>
            
        <?php } else { ?>

            <button
                type="button"
                class="btn btn-success btn-sm btn-toggle-exam-lock"

                data-paper-ids="<?php echo implode(",", $all_paper_ids); ?>"
                data-class-id="<?php echo $class_id; ?>"
                data-section-id="<?php echo $section_id; ?>"
                data-exam-id="<?php echo $exam_id; ?>"
                data-status="1"
            >
                <i class="fa fa-unlock"></i>
                Lock Exam
            </button>


        <?php } ?>

    </div>

</div>

<div class="table-responsive">

<table
    class="table table-hover table-bordered align-middle exam-table mt-3"
>

    <thead>

        <tr>

            <th class="col-sl sticky-col-1 text-center">
                Sl No
            </th>

            <th class="col-subject sticky-col-2 text-center">
                Subject
            </th>

            <!-- <th class="col-component sticky-col-3 text-center">
                Component
            </th> -->

            <th class="col-teachers text-center">
                Assigned Teachers
            </th>

            <th class="col-action sticky-action text-center">
                Action
            </th>

        </tr>

    </thead>

    <tbody>

        <?php
        $sl = 0;

        foreach ($papers as $subject) {

            $sl++;

            $isLocked = isset($subject["subject_locked"])
                ? $subject["subject_locked"]
                : 0;

            if($subject["subject_name"] == "") {
                continue;
            }
            ?>

        <tr>

            <td class="sticky-col-1 text-center">
                <?php echo $sl; ?>
            </td>

            <td class="sticky-col-2 text-center">
                <?php echo $subject["subject_name"]; ?>
            </td>

            <!-- <td class="sticky-col-3 text-center">

                <span class="badge bg-primary">
                    Written
                </span>

            </td> -->

            <td>

                <div class="teacher-container">

                    <?php if (!empty($subject["assigned_teachers"])) { ?>

                        <?php foreach (
                            $subject["assigned_teachers"]
                            as $teacher
                        ) { ?>

                            <div class="teacher-badge">

                                <span>
                                    <?php echo $teacher["teacher_name"]; ?>
                                </span>

                                <div class="form-check form-switch">

                                    <input
                                        type="checkbox"
                                        class="form-check-input teacher-status-toggle"

                                        <?php echo $teacher["status"] == 1
                                            ? "checked"
                                            : ""; ?>

                                        data-paper-ids="<?php echo implode(
                                            ",",
                                            $subject["paper_ids"]
                                        ); ?>"
                                        data-subject-id="<?php echo $subject[
                                            "subject_id"
                                        ]; ?>"
                                        data-teacher-id="<?php echo $teacher[
                                            "teacher_id"
                                        ]; ?>"
                                        data-class-id="<?php echo $class_id; ?>"
                                        data-section-id="<?php echo $section_id; ?>"
                                    >

                                </div>

                                <i
                                    class="fa fa-trash text-danger teacher-delete"
                                    role="button"

                                    data-paper-ids="<?php echo implode(
                                        ",",
                                        $subject["paper_ids"]
                                    ); ?>"
                                    data-subject-id="<?php echo $subject[
                                        "subject_id"
                                    ]; ?>"
                                    data-teacher-id="<?php echo $teacher[
                                        "teacher_id"
                                    ]; ?>"
                                    data-class-id="<?php echo $class_id; ?>"
                                    data-section-id="<?php echo $section_id; ?>"
                                ></i>

                            </div>

                        <?php } ?>

                    <?php } else { ?>

                        <span class="text-muted">
                            No Teacher Assigned
                        </span>

                    <?php } ?>

                </div>

            </td>

            <td class="sticky-action">

                <div
                    class="d-flex justify-content-center align-items-center gap-1"
                >

                    <button
                        class="btn btn-primary btn-sm btn-add-teacher"

                        data-paper-ids="<?php echo implode(
                            ",",
                            $subject["paper_ids"]
                        ); ?>"

                        data-subject-id="<?php echo $subject["subject_id"]; ?>"

                        data-class-id="<?php echo $class_id; ?>"

                        data-section-id="<?php echo $section_id; ?>"
                    >
                        <i class="fa fa-plus"></i>
                    </button>

                    <?php if ($isLocked) { ?>

                        <button
                            class="btn btn-danger btn-sm subject-lock-toggle btn-toggle-subject-lock"

                            data-paper-ids="<?php echo implode(
                                ",",
                                $subject["paper_ids"]
                            ); ?>"

                            data-subject-id="<?php echo $subject[
                                "subject_id"
                            ]; ?>"

                            data-class-id="<?php echo $class_id; ?>"

                            data-section-id="<?php echo $section_id; ?>"

                            data-status="0"
                        >
                            <i class="fa fa-lock"></i>
    
                        </button>

                    <?php } else { ?>

                        <button
                            class="btn btn-success btn-sm subject-lock-toggle btn-toggle-subject-lock"

                            data-paper-ids="<?php echo implode(
                                ",",
                                $subject["paper_ids"]
                            ); ?>"

                            data-subject-id="<?php echo $subject[
                                "subject_id"
                            ]; ?>"

                            data-class-id="<?php echo $class_id; ?>"

                            data-section-id="<?php echo $section_id; ?>"

                            data-status="1"
                        >
                           
                            <i class="fa fa-unlock"></i>
                        </button>

                    <?php } ?>

                </div>

            </td>

        </tr>

        <?php
        }
        ?>

    </tbody>

</table>

</div>


            </div>
        </div>
    </div>

    <?php } ?>    
</div>

<div class="modal fade" id="teacherModal" tabindex="-1">
    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">
                    Assign Teachers For Marks Entry
                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>
            </div>

            <div class="modal-body">

                <div id="teacher-list-container"></div>

            </div>

            <div class="modal-footer">

                <button
                    type="button"
                    class="btn btn-light"
                    data-bs-dismiss="modal">
                    Cancel
                </button>

                <button
                    type="button"
                    class="btn btn-success d-none"
                    id="saveTeacherPermissions">
                    <i class="fa fa-save"></i>
                    Save
                </button>

            </div>

        </div>

    </div>
</div>

<script>

function initializePrivilegeTab(
    classSelector,
    sectionSelector,
    examSelector,
    componentSelector,
    subjectSelector
){

    $(document).on(
        'change',
        classSelector,
        function(){

            let classId = $(this).val();

            if(classId == ''){
                $(sectionSelector).prop('disabled', true);
                $(examSelector).prop('disabled', true);
                $(componentSelector).prop('disabled', true);
                $(subjectSelector).prop('disabled', true);
                return;
            }

            fetch(
                "<?php echo base_url("academics/marks-entry?class_id="); ?>" +
                classId
            )
            .then(response => response.json())
            .then(data => {

                /* SECTION */

                $(sectionSelector).empty();

                $(sectionSelector).append(`
                    <option value="">ALL</option>
                `);

                data.sections.forEach(section => {

                    $(sectionSelector).append(`
                        <option value="${section.id}">
                            ${section.name}
                        </option>
                    `);

                });

                /* EXAMS */

                $(examSelector).empty();

                $(examSelector).append(`
                    <option value="">ALL</option>
                `);

                const addedExamIds = new Set();

                data.exams.forEach(exam => {

                    if(!addedExamIds.has(exam.id)){

                        $(examSelector).append(`
                            <option value="${exam.id}">
                                ${exam.name}
                            </option>
                        `);

                        addedExamIds.add(exam.id);
                    }

                });

                $(sectionSelector).prop('disabled', false);
                $(examSelector).prop('disabled', false);

            });

        }
    );


    $(document).on(
        'change',
        examSelector,
        function(){

            let classId = $(classSelector).val();
            let examId = $(this).val();

            $(componentSelector).empty();
            $(subjectSelector).empty();

            $(componentSelector).append(`
                <option value="">ALL</option>
            `);

            $(subjectSelector).append(`
                <option value="">ALL</option>
            `);

            if(examId == ''){

                $(componentSelector).prop('disabled', true);
                $(subjectSelector).prop('disabled', true);

                return;
            }

            fetch(
                "<?php echo base_url("academics/marks-entry?class_id="); ?>" +
                classId +
                "&exam_id=" + examId +
                "&paper_type=component"
            )
            .then(response => response.json())
            .then(data => {

                data.components.forEach(component => {

                    $(componentSelector).append(`
                        <option value="${component.id}">
                            ${component.name}
                        </option>
                    `);

                });

                data.subjects.forEach(subject => {

                    $(subjectSelector).append(`
                        <option value="${subject.id}">
                            ${subject.name}
                        </option>
                    `);

                });

                $(componentSelector).prop('disabled', false);
                $(subjectSelector).prop('disabled', false);

            });

        }
    );

    $(document).on(
        'click',
        '.btn-toggle-subject-lock',
        function(){

            const btn = $(this);

            fetch(
                getPrivilegeUrl(
                    'toggle-subject-lock'
                ),
                {
                    method:'POST',

                    headers:{
                        'Content-Type':
                        'application/x-www-form-urlencoded'
                    },

                    body:new URLSearchParams({

                        paper_ids:
                            btn.data('paper-ids'),

                        subject_id:
                            btn.data('subject-id'),

                        class_id:
                            btn.data('class-id'),

                        section_id:
                            btn.data('section-id'),

                        status:
                            btn.data('status')
                    })
                }
            )
            .then(r=>r.json())
            .then(data=>{

                alert(
                    data.message
                );

                location.reload();

            });

        }
    );

    $(document).on(
        'click',
        '.btn-toggle-exam-lock',
        function(){

            const btn = $(this);

            fetch(
                getPrivilegeUrl(
                    'toggle-exam-lock'
                ),
                {
                    method:'POST',

                    headers:{
                        'Content-Type':
                        'application/x-www-form-urlencoded'
                    },

                    body:new URLSearchParams({

                        paper_ids:
                            btn.data('paper-ids'),

                        class_id:
                            btn.data('class-id'),

                        section_id:
                            btn.data('section-id'),

                        status:
                            btn.data('status')
                    })
                }
            )
            .then(r=>r.json())
            .then(data=>{

                alert(
                    data.message
                );

                location.reload();

            });

        }
    );

}


/* ==========================
   MARKS ENTRY TAB
========================== */

initializePrivilegeTab(
    '.marks-class',
    '.marks-section',
    '.marks-exam',
    '.marks-component',
    '.marks-subject'
);


/* ==========================
   GRADE ENTRY TAB
========================== */

initializePrivilegeTab(
    '.grade-class',
    '.grade-section',
    '.grade-exam',
    '.grade-component',
    '.grade-subject'
);

</script>

<script>

let selectedPaperIds = '';
let selectedSubjectId = '';
let classId = '';
let sectionId = '';
let teacherModal = null;

let BASE_URL = 'https://ignitedsoft.in/stfrancis/';
let privilegeType = 'marks';


/* ==========================================
   TAB DETECTION
========================================== */

$('button[data-bs-toggle="tab"]').on(
    'shown.bs.tab',
    function () {

        privilegeType = $(this).data('type');

        if(
            privilegeType !== 'marks' &&
            privilegeType !== 'grades'
        ){
            privilegeType = 'marks';
        }

    }
);


/* ==========================================
   URL BUILDER
========================================== */

function getPrivilegeUrl(action = ''){

    return (
        BASE_URL +
        'academics/exam-' +
        privilegeType +
        '-control-privileges/' +
        action
    );

}


/* ==========================================
   ADD TEACHER
========================================== */

$(document).on(
    'click',
    '.btn-add-teacher',
    function(){

        selectedPaperIds =
            $(this).data('paper-ids');

        selectedSubjectId =
            $(this).data('subject-id');

        classId =
            $(this).data('class-id');

        sectionId =
            $(this).data('section-id');

        teacherModal =
            new bootstrap.Modal(
                document.getElementById(
                    'teacherModal'
                )
            );

        teacherModal.show();

        fetch(
            getPrivilegeUrl('get-teachers'),
            {
                method:'POST',
                headers:{
                    'Content-Type':
                    'application/x-www-form-urlencoded'
                },
                body:new URLSearchParams({
                    paper_ids:selectedPaperIds,
                    subject_id:selectedSubjectId,
                    class_id:classId,
                    section_id:sectionId,
                    // teacher_ids:teacherIds
                })
            }
        )
        .then(response => response.json())
        .then(data => {

            let html = '';

            data.forEach(function(row){

                html += `
                    <div class="form-check mb-2">

                        <input
                            class="form-check-input teacher-checkbox"
                            type="checkbox"
                            value="${row.teacher_id}"
                            ${
                                row.hasPermission == 1
                                ? 'checked'
                                : ''
                            }
                        >

                        <label class="form-check-label">
                            ${row.teacher_name}
                        </label>

                    </div>
                `;

            });

            $('#teacher-list-container')
                .html(html);

        });

    }
);


/* ==========================================
   SAVE TEACHERS
========================================== */

$(document).on(
    'change',
    '.teacher-checkbox',
    function(){

        let teacherIds = [];

        $('.teacher-checkbox:checked').each(function(){

            teacherIds.push(
                $(this).val()
            );

        });

        fetch(
            getPrivilegeUrl('save-teachers'),
            {
                method:'POST',
                headers:{
                    'Content-Type':
                    'application/x-www-form-urlencoded'
                },
                body:new URLSearchParams({
                    paper_ids:selectedPaperIds,
                    subject_id:selectedSubjectId,
                    class_id:classId,
                    section_id:sectionId,
                    teacher_ids:teacherIds
                })
            }
        )
        .then(response => response.json())
        .then(data => {

            if(!data.status){

                alert(
                    data.message ||
                    'Failed to update permission.'
                );

            }

        })
        .catch(function(){

            alert(
                'Something went wrong.'
            );

        });

    }
);

document.addEventListener(
    'hidden.bs.modal',
    function (e) {

        if (e.target.id === 'teacherModal') {
            location.reload();
        }

    }
);

/* ==========================================
   TOGGLE STATUS
========================================== */

document.addEventListener(
    'change',
    async function(e){

        const toggle =
            e.target.closest(
                '.teacher-status-toggle'
            );

        if(!toggle){
            return;
        }

        const status =
            toggle.checked ? 1 : 0;

        try{

            const response =
                await fetch(
                    getPrivilegeUrl(
                        'toggle-teacher'
                    ),
                    {
                        method:'POST',
                        headers:{
                            'Content-Type':
                            'application/x-www-form-urlencoded'
                        },
                        body:new URLSearchParams({

                            paper_ids:
                                toggle.dataset.paperIds,

                            subject_id:
                                toggle.dataset.subjectId,

                            teacher_id:
                                toggle.dataset.teacherId,

                            class_id:
                                toggle.dataset.classId,

                            section_id:
                                toggle.dataset.sectionId,

                            status:status
                        })
                    }
                );

            const result =
                await response.json();

            if(result.status){

                alert(
                    result.message
                );

            }else{

                alert(
                    result.message
                );

                toggle.checked =
                    !toggle.checked;

            }

        }catch(error){

            alert(
                'Failed to update teacher status'
            );

            toggle.checked =
                !toggle.checked;

        }

    }
);


/* ==========================================
   REMOVE TEACHER
========================================== */

document.addEventListener(
    'click',
    async function(e){

        const button =
            e.target.closest(
                '.teacher-delete'
            );

        if(!button){
            return;
        }

        const confirmDelete =
            confirm(
                'Are you sure you want to remove this teacher?'
            );

        if(!confirmDelete){
            return;
        }

        try{

            const response =
                await fetch(
                    getPrivilegeUrl(
                        'remove-teacher'
                    ),
                    {
                        method:'POST',
                        headers:{
                            'Content-Type':
                            'application/x-www-form-urlencoded'
                        },
                        body:new URLSearchParams({

                            paper_ids:
                                button.dataset.paperIds,

                            subject_id:
                                button.dataset.subjectId,

                            teacher_id:
                                button.dataset.teacherId,

                            class_id:
                                button.dataset.classId,

                            section_id:
                                button.dataset.sectionId

                        })
                    }
                );

            const result =
                await response.json();

            if(result.status){

                alert(
                    result.message
                );

                button
                    .closest(
                        '.teacher-badge'
                    )
                    .remove();

            }else{

                alert(
                    result.message
                );

            }

        }catch(error){

            alert(
                'Failed to remove teacher'
            );

        }

    }
);

</script>
   
<?php $this->load->view("inc/app_footer.php"); ?>
