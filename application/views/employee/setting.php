<?php $this->load->view("inc/app_header.php"); ?>

    <div class="row mb-5 align-items-center">
        <div class="col-md-6">
            <h1 class="mb-0">Personnel Settings</h1>
        </div>

        <div class="col-md-6 text-end">
            <?php if ($this->session->flashdata('success')) { ?>
                <div class="alert alert-success alert-dismissible d-inline-block mb-0">
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    <strong><?php echo $this->session->flashdata('success') ?></strong>
                </div>
            <?php } ?>
        </div>
    </div>

    <form action="<?php echo base_url()?>personnel/settings/store" method="POST">
        <div class="row">
            <div class="col-md-8">
                <div class="card card-flush h-xl-100">
                    <!--begin::Body-->
                    <div class="card-body py-9">
                        <h2 class="mb-3">Setting</h2>
                        <div class="row g-3 mb-3 align-items-center">
                            <div class="col-md-4">
                                <label class="col-form-label">Sort Employees By</label>
                            </div>
                            <div class="col-md-8">
                                <select class="form-select" name="employee_sort_by">
                                    <option value="employee_code" <?php if($settings['employee_sort_by'] == "employee_code") {echo "selected";}?>>Employee Code</option>
                                    <option value="first_name" <?php if($settings['employee_sort_by'] == "first_name") {echo "selected";}?>>First Name</option>
                                    <option value="last_name" <?php if($settings['employee_sort_by'] == "last_name") {echo "selected";}?>>Last Name</option>
                                </select>
                            </div>
                        </div>

                        <div class="row g-3 mb-3 align-items-center">
                            <div class="col-md-4">
                                <label class="col-form-label">Display Employee Name As</label>
                            </div>
                            <div class="col-md-8">
                                <select class="form-select" name="employee_name_display_format">
                                    <option value="f_m_s" <?php if($settings['employee_name_display_format'] == "f_m_s") {echo "selected";}?>>First_Name Middle_Name Last_Name</option>
                                    <option value="l_f_m" <?php if($settings['employee_name_display_format'] == "l_f_m") {echo "selected";}?>>Last_Name, First_Name Middle_Name</option>
                                    <option value="l_f_m" <?php if($settings['employee_name_display_format'] == "l_f_m") {echo "selected";}?>>Last_Name First_Name Middle_Name</option>
                                    <option value="l_m_f" <?php if($settings['employee_name_display_format'] == "l_m_f") {echo "selected";}?>>Last_Name Middle_Name First_Name</option>
                                </select>
                            </div>
                        </div>

                        <div class="row g-3 mb-3 align-items-center">
                            <div class="col-md-4">
                                <label class="col-form-label">Auto Generate Employee Code</label>
                            </div>
                            <div class="col-md-8">
                                <select class="form-select" name="employee_auto_generate_no">
                                    <option value="1" <?php if($settings['employee_auto_generate_no'] == "1") {echo "selected";}?>>Yes</option>
                                    <option value="0" <?php if($settings['employee_auto_generate_no'] == "0") {echo "selected";}?>>No</option>
                                </select>
                            </div>
                        </div>

                        <div class="row g-3 mb-3 align-items-center">
                            <div class="col-md-4">
                                <label class="col-form-label">Display Inactive Employees</label>
                            </div>
                            <div class="col-md-8">
                                <select class="form-select" name="employee_display_inactive">
                                    <option value="1" <?php if($settings['employee_display_inactive'] == "1") {echo "selected";}?>>Yes</option>
                                    <option value="0" <?php if($settings['employee_display_inactive'] == "0") {echo "selected";}?>>No</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="row g-3 mb-3 align-items-center">
                            <div class="col-md-4">
                                <label class="col-form-label">Display Retired Employees</label>
                            </div>
                            <div class="col-md-8">
                                <select class="form-select" name="employee_display_retired">
                                    <option value="1" <?php if($settings['employee_display_retired'] == "1") {echo "selected";}?>>Yes</option>
                                    <option value="0" <?php if($settings['employee_display_retired'] == "0") {echo "selected";}?>>No</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="row g-3 mb-3 align-items-center">
                            <div class="col-md-4">
                                <label class="col-form-label">Display Resigned Employees</label>
                            </div>
                            <div class="col-md-8">
                                <select class="form-select" name="employee_display_resigned">
                                    <option value="1" <?php if($settings['employee_display_resigned'] == "1") {echo "selected";}?>>Yes</option>
                                    <option value="0" <?php if($settings['employee_display_resigned'] == "0") {echo "selected";}?>>No</option>
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