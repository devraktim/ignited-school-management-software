<?php $this->load->view("inc/app_header.php"); ?>

<div class="row mb-5">
    <h1>Academic Settings</h1>
</div>

<form action="<?php echo base_url()?>academics/setting" method="POST">
    <div class="row">
        <div class="col-md-8">
            <div class="card card-flush h-xl-100">
                <!--begin::Body-->
                <div class="card-body py-9">
                    <!-- Allow Negative Marks -->
                    <div class="row g-3 mb-3 align-items-center">
                        <div class="col-md-4">
                            <label class="col-form-label">Allow Negative Marks</label>
                        </div>
                        <div class="col-md-8">
                            <select class="form-select" name="allow_negative_marks" id="cmbAllowNeg">
                                <option value="" <?php echo empty($settings['allow_negative_marks']) ? 'selected' : ''; ?>>Select</option>
                                <option value="1" <?php echo $settings['allow_negative_marks'] == '1' ? 'selected' : ''; ?>>Yes</option>
                                <option value="2" <?php echo $settings['allow_negative_marks'] == '2' ? 'selected' : ''; ?>>No</option>
                            </select>
                        </div>
                    </div>

                    <!-- Highlight Failed Subjects -->
                    <div class="row g-3 mb-3 align-items-center">
                        <div class="col-md-4">
                            <label class="col-form-label">Highlight Failed Subjects</label>
                        </div>
                        <div class="col-md-8">
                            <select class="form-select" name="highlight_failed_subjects" id="cmbHighlight">
                                <option value="" <?php echo empty($settings['highlight_failed_subjects']) ? 'selected' : ''; ?>>Select</option>
                                <option value="do_not_highlight" <?php echo $settings['highlight_failed_subjects'] == 'do_not_highlight' ? 'selected' : ''; ?>>Do Not Highlight</option>
                                <option value="with_asterix" <?php echo $settings['highlight_failed_subjects'] == 'with_asterix' ? 'selected' : ''; ?>>With Asterix</option>
                                <option value="with_parenthesis" <?php echo $settings['highlight_failed_subjects'] == 'with_parenthesis' ? 'selected' : ''; ?>>With Parenthesis</option>
                                <option value="in_red_color" <?php echo $settings['highlight_failed_subjects'] == 'in_red_color' ? 'selected' : ''; ?>>In Red Color</option>
                            </select>
                        </div>
                    </div>

                    <!-- Teachers will be assigned for Marks Entry -->
                    <div class="row g-3 mb-3 align-items-center">
                        <div class="col-md-4">
                            <label class="col-form-label">Teachers will be assigned for Marks Entry</label>
                        </div>
                        <div class="col-md-8">
                            <select class="form-select" name="assign_teacher_for_marks_entry" id="cmbAssignTeacher">
                                <option value="" <?php echo empty($settings['assign_teacher_for_marks_entry']) ? 'selected' : ''; ?>>Select</option>
                                <option value="1" <?php echo $settings['assign_teacher_for_marks_entry'] == '1' ? 'selected' : ''; ?>>Yes</option>
                                <option value="2" <?php echo $settings['assign_teacher_for_marks_entry'] == '2' ? 'selected' : ''; ?>>No</option>
                            </select>
                        </div>
                    </div>

                    <!-- Teachers will be assigned for Grade Entry -->
                    <div class="row g-3 mb-3 align-items-center">
                        <div class="col-md-4">
                            <label class="col-form-label">Teachers will be assigned for Grade Entry</label>
                        </div>
                        <div class="col-md-8">
                            <select class="form-select" name="assign_teacher_for_grade_entry" id="cmbGAssignTeacher">
                                <option value="" <?php echo empty($settings['assign_teacher_for_grade_entry']) ? 'selected' : ''; ?>>Select</option>
                                <option value="1" <?php echo $settings['assign_teacher_for_grade_entry'] == '1' ? 'selected' : ''; ?>>Yes</option>
                                <option value="2" <?php echo $settings['assign_teacher_for_grade_entry'] == '2' ? 'selected' : ''; ?>>No</option>
                            </select>
                        </div>
                    </div>

                    <!-- Class Teachers will be assigned to Classes -->
                    <div class="row g-3 mb-3 align-items-center">
                        <div class="col-md-4">
                            <label class="col-form-label">Class Teachers will be assigned to Classes</label>
                        </div>
                        <div class="col-md-8">
                            <select class="form-select" name="assign_class_teacher_to_classes" id="cmbAssignCTeacher">
                                <option value="" <?php echo empty($settings['assign_class_teacher_to_classes']) ? 'selected' : ''; ?>>Select</option>
                                <option value="1" <?php echo $settings['assign_class_teacher_to_classes'] == '1' ? 'selected' : ''; ?>>Yes</option>
                                <option value="2" <?php echo $settings['assign_class_teacher_to_classes'] == '2' ? 'selected' : ''; ?>>No</option>
                            </select>
                        </div>
                    </div>

                    <!-- Only Class Teachers can enter Report Card Remarks -->
                    <div class="row g-3 mb-3 align-items-center">
                        <div class="col-md-4">
                            <label class="col-form-label">Only Class Teachers can enter Report Card Remarks</label>
                        </div>
                        <div class="col-md-8">
                            <select class="form-select" name="class_teacher_can_enter_remarks" id="cmbCTRemarks">
                                <option value="" <?php echo empty($settings['class_teacher_can_enter_remarks']) ? 'selected' : ''; ?>>Select</option>
                                <option value="1" <?php echo $settings['class_teacher_can_enter_remarks'] == '1' ? 'selected' : ''; ?>>Yes</option>
                                <option value="2" <?php echo $settings['class_teacher_can_enter_remarks'] == '2' ? 'selected' : ''; ?>>No</option>
                            </select>
                        </div>
                    </div>

                    <!-- Only Class Teachers can enter Personal Evaluation -->
                    <div class="row g-3 mb-3 align-items-center">
                        <div class="col-md-4">
                            <label class="col-form-label">Only Class Teachers can enter Personal Evaluation</label>
                        </div>
                        <div class="col-md-8">
                            <select class="form-select" name="class_teacher_can_enter_personal_evaluation" id="cmbCTPerEval">
                                <option value="" <?php echo empty($settings['class_teacher_can_enter_personal_evaluation']) ? 'selected' : ''; ?>>Select</option>
                                <option value="1" <?php echo $settings['class_teacher_can_enter_personal_evaluation'] == '1' ? 'selected' : ''; ?>>Yes</option>
                                <option value="2" <?php echo $settings['class_teacher_can_enter_personal_evaluation'] == '2' ? 'selected' : ''; ?>>No</option>
                            </select>
                        </div>
                    </div>

                    <!-- Only Class Teachers can enter Student Attendance -->
                    <div class="row g-3 mb-3 align-items-center">
                        <div class="col-md-4">
                            <label class="col-form-label">Only Class Teachers can enter Student Attendance</label>
                        </div>
                        <div class="col-md-8">
                            <select class="form-select" name="class_teacher_can_enter_attendance" id="cmbCTAttendance">
                                <option value="" <?php echo empty($settings['class_teacher_can_enter_attendance']) ? 'selected' : ''; ?>>Select</option>
                                <option value="1" <?php echo $settings['class_teacher_can_enter_attendance'] == '1' ? 'selected' : ''; ?>>Yes</option>
                                <option value="2" <?php echo $settings['class_teacher_can_enter_attendance'] == '2' ? 'selected' : ''; ?>>No</option>
                            </select>
                        </div>
                    </div>

                    <!-- Only Principal can enter Principal's Remarks -->
                    <div class="row g-3 mb-3 align-items-center">
                        <div class="col-md-4">
                            <label class="col-form-label">Only Principal can enter Principal's Remarks</label>
                        </div>
                        <div class="col-md-8">
                            <select class="form-select" name="principal_can_enter_remarks" id="cmbPRRemarks">
                                <option value="" <?php echo empty($settings['principal_can_enter_remarks']) ? 'selected' : ''; ?>>Select</option>
                                <option value="1" <?php echo $settings['principal_can_enter_remarks'] == '1' ? 'selected' : ''; ?>>Yes</option>
                                <option value="2" <?php echo $settings['principal_can_enter_remarks'] == '2' ? 'selected' : ''; ?>>No</option>
                            </select>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card card-flush h-xl-100">
                <!--begin::Body-->
                <div class="card-body py-9">
                    <!-- Show buttons only if "Yes" is selected for assigning class teacher -->
                    <?php if($settings['assign_class_teacher_to_classes'] == '1') { ?>
                    <a href="<?php echo base_url()?>academics/setting/assign-teacher-class" class="btn btn-primary mb-3 w-100">Assign Class Teacher</a>
                    <?php } ?>

                    <a href="<?php echo base_url()?>academics/setting/show-class-teacher" class="btn btn-primary mb-3 w-100">Show Class Teacher</a>
                    
                    <?php if ($settings['assign_teacher_for_marks_entry'] != "2" || $settings['assign_teacher_for_grade_entry'] != "2") { ?>
                        <a href="<?php echo base_url()?>academics/exam-control-privileges" class="btn btn-primary mb-3 w-100">
                            Marks/ Grade Entry Permissions
                        </a>
                    <?php } ?>
                </div>
            </div>
        </div>

    </div>

    <?php if($this->session->user['permissions'][0]['academics_module'] != "VIEWER") { ?>
    <button type="submit" class="btn btn-success rounded rounded-pill mt-5"><i class="fa fa-plus"></i> Save</button>
    <?php } ?>
</form>

<?php $this->load->view("inc/app_footer.php"); ?>
