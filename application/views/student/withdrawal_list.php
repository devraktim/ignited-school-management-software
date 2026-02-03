<?php $this->load->view("inc/app_header.php"); ?>

    <div class="row mb-5">
        <h1>Student Settings</h1>
    </div>

    <form action="<?php echo base_url()?>students/settings/store" method="POST">
        <div class="row">
            <div class="col-md-6">
                <div class="card card-flush h-xl-100">
                    <!--begin::Body-->
                    <div class="card-body py-9">
                        <h2 class="mb-3">Setting</h2>
                        <div class="row g-3 mb-3 align-items-center">
                            <div class="col-md-4">
                                <label class="col-form-label">Sort Student By</label>
                            </div>
                            <div class="col-md-8">
                                <select class="form-select" name="student_sort_by">
                                    <option value="student_no" <?php if($settings['student_sort_by'] == "student_no") {echo "selected";}?>>Student No</option>
                                    <option value="first_name" <?php if($settings['student_sort_by'] == "first_name") {echo "selected";}?>>First Name</option>
                                    <option value="last_name" <?php if($settings['student_sort_by'] == "last_name") {echo "selected";}?>>Last Name</option>
                                    <option value="roll_no" <?php if($settings['student_sort_by'] == "roll_no") {echo "selected";}?>>Roll No</option>
                                    <option value="day_scholar" <?php if($settings['student_sort_by'] == "day_scholar") {echo "selected";}?>>Student Type, Day Scholars First</option>
                                    <option value="boarders" <?php if($settings['student_sort_by'] == "boarders") {echo "selected";}?>>Student Type, Boarders First</option>
                                </select>
                            </div>
                        </div>

                        <div class="row g-3 mb-3 align-items-center">
                            <div class="col-md-4">
                                <label class="col-form-label">Display Student's Name As</label>
                            </div>
                            <div class="col-md-8">
                                <select class="form-select" name="student_name_display_format">
                                    <option value="f_m_s" <?php if($settings['student_name_display_format'] == "f_m_s") {echo "selected";}?>>First_Name Middle_Name Last_Name</option>
                                    <option value="l_f_m" <?php if($settings['student_name_display_format'] == "l_f_m") {echo "selected";}?>>Last_Name, First_Name Middle_Name</option>
                                    <option value="l_f_m" <?php if($settings['student_name_display_format'] == "l_f_m") {echo "selected";}?>>Last_Name First_Name Middle_Name</option>
                                    <option value="l_m_f" <?php if($settings['student_name_display_format'] == "l_m_f") {echo "selected";}?>>Last_Name Middle_Name First_Name</option>
                                </select>
                            </div>
                        </div>

                        <div class="row g-3 mb-3 align-items-center">
                            <div class="col-md-4">
                                <label class="col-form-label">Auto Generate Student No</label>
                            </div>
                            <div class="col-md-8">
                                <select class="form-select" name="student_auto_generate_no">
                                    <option value="1" <?php if($settings['student_auto_generate_no'] == "1") {echo "selected";}?>>Yes</option>
                                    <option value="0" <?php if($settings['student_auto_generate_no'] == "0") {echo "selected";}?>>No</option>
                                </select>
                            </div>
                        </div>

                        <div class="row g-3 mb-3 align-items-center">
                            <div class="col-md-4">
                                <label class="col-form-label">Display Withdrawn Students</label>
                            </div>
                            <div class="col-md-8">
                                <select class="form-select" name="student_display_withdrawn_student">
                                    <option value="1" <?php if($settings['student_display_withdrawn_student'] == "1") {echo "selected";}?>>Yes</option>
                                    <option value="0" <?php if($settings['student_display_withdrawn_student'] == "0") {echo "selected";}?>>No</option>
                                </select>
                            </div>
                        </div>

                        <div class="row g-3 mb-3 align-items-center">
                            <div class="col-md-4">
                                <label class="col-form-label">Display Inactive Students</label>
                            </div>
                            <div class="col-md-8">
                                <select class="form-select" name="student_display_inactive_student">
                                    <option value="1" <?php if($settings['student_display_inactive_student'] == "1") {echo "selected";}?>>Yes</option>
                                    <option value="0" <?php if($settings['student_display_inactive_student'] == "0") {echo "selected";}?>>No</option>
                                </select>
                            </div>
                        </div>

                        <div class="row g-3 mb-3 align-items-center">
                            <div class="col-md-4">
                                <label class="col-form-label">Auto Generate TC No</label>
                            </div>
                            <div class="col-md-8">
                                <select class="form-select" name="student_auto_generate_tc_no">
                                    <option value="1" <?php if($settings['student_auto_generate_tc_no'] == "1") {echo "selected";}?>>Yes</option>
                                    <option value="0" <?php if($settings['student_auto_generate_tc_no'] == "0") {echo "selected";}?>>No</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card card-flush h-xl-100">
                    <!--begin::Body-->
                    <div class="card-body py-9">
                        <h2 class="mb-3">Default Value for New Records</h2>
                        <div class="row g-3 align-items-center">
                            <div class="col-md-4">
                                <label class="col-form-label">Sex</label>
                            </div>
                            <div class="col-md-8">
                                <select class="form-select" name="student_default_sex">
                                    <option value="">Not Specified</option>
                                    <option value="male" <?php if($settings['student_default_sex'] == "male") {echo "selected";}?>>Male</option>
                                    <option value="female" <?php if($settings['student_default_sex'] == "female") {echo "selected";}?>>Female</option>
                                </select>
                            </div>
                        </div>

                        <div class="row g-3 align-items-center">
                            <div class="col-md-4">
                                <label class="col-form-label">Class of Admission</label>
                            </div>
                            <div class="col-md-8">
                                <select class="form-select" name="student_default_class">
                                    <option value="">Not Specified</option>
                                    <?php foreach ($classes as $class) { ?>
                                        <option value="<?php echo $class["id"] ?>" <?php if($settings['student_default_class'] == $class["id"]) {echo "selected";}?>><?php echo $class["name"] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="row g-3 align-items-center">
                            <div class="col-md-4">
                                <label class="col-form-label">Student Type</label>
                            </div>
                            <div class="col-md-8">
                                <select class="form-select" name="student_default_type">
                                    <option value="">Not Specified</option>
                                    <?php foreach ($student_types as $type) { ?>
                                        <option value="<?php echo $type["id"] ?>" <?php if($settings['student_default_type'] == $type["id"]) {echo "selected";}?>><?php echo $type["name"] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="row g-3 align-items-center">
                            <div class="col-md-4">
                                <label class="col-form-label">House</label>
                            </div>
                            <div class="col-md-8">
                                <select class="form-select" name="student_default_house">
                                    <option value="">Not Specified</option>
                                    <?php foreach ($houses as $house) { ?>
                                        <option value="<?php echo $house["id"] ?>" <?php if($settings['student_default_house'] == $house["id"]) {echo "selected";}?>><?php echo $house["name"] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="row g-3 align-items-center">
                            <div class="col-md-4">
                                <label class="col-form-label">Category</label>
                            </div>
                            <div class="col-md-8">
                                <select class="form-select" name="student_default_category">
                                    <option value="">Not Specified</option>
                                    <?php foreach ($categories as $category) { ?>
                                        <option value="<?php echo $category["id"] ?>" <?php if($settings['student_default_category'] == $category["id"]) {echo "selected";}?>><?php echo $category["name"] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="row g-3 align-items-center">
                            <div class="col-md-4">
                                <label class="col-form-label">Religion</label>
                            </div>
                            <div class="col-md-8">
                                <select class="form-select" name="student_default_religion">
                                    <option value="">Not Specified</option>
                                    <?php foreach ($religions as $religion) { ?>
                                        <option value="<?php echo $religion["id"] ?>" <?php if($settings['student_default_religion'] == $religion["id"]) {echo "selected";}?>><?php echo $religion["name"] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="row g-3 align-items-center">
                            <div class="col-md-4">
                                <label class="col-form-label">Nationality</label>
                            </div>
                            <div class="col-md-8">
                                <select class="form-select" name="student_default_nationality">
                                    <option value="">Not Specified</option>
                                    <?php foreach ($nationalities as $nationality) { ?>
                                        <option value="<?php echo $nationality["id"] ?>" <?php if($settings['student_default_nationality'] == $nationality["id"]) {echo "selected";}?>><?php echo $nationality["name"] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="row g-3 align-items-center">
                            <div class="col-md-4">
                                <label class="col-form-label">State</label>
                            </div>
                            <div class="col-md-8">
                                <select class="form-select" name="student_default_state">
                                    <option value="">Not Specified</option>
                                    <?php foreach ($states as $state) { ?>
                                        <option value="<?php echo $state["id"] ?>" <?php if($settings['student_default_state'] == $state["id"]) {echo "selected";}?>><?php echo $state["name"] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="row g-3 align-items-center">
                            <div class="col-md-4">
                                <label class="col-form-label">Medical Status</label>
                            </div>
                            <div class="col-md-8">
                                <select class="form-select" name="student_default_mesical_status">
                                    <option value="">Not Specified</option>
                                    <option value="fit" <?php if($settings['student_default_mesical_status'] == "fit") {echo "selected";}?>>Fit</option>
                                    <option value="differently_abled" <?php if($settings['student_default_mesical_status'] == "differently_abled") {echo "selected";}?>>Differently Abled</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <button type="submit" class="btn btn-success rounded rounded-pill mt-5"><i class="fa fa-plus"></i> Save</button>
    </form>

<?php $this->load->view("inc/app_footer.php"); ?>