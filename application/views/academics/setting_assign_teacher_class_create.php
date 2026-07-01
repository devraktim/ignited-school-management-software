<?php $this->load->view("inc/app_header.php"); ?>

    <div class="row mb-5">
        <div class="col-md-6">
            <h1>Assign Teacher to The Classes</h1>
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

    <form action="<?php echo base_url(); ?>academics/setting/assign-teacher-class" method="POST">
        <div class="row mb-5">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="card card-flush h-xl-100 mt-5">
                    <div class="card-body py-9">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr class="text-center table-dark">
                                        <th><h4 class="text-light">Class</h4></th>
                                        <th><h4 class="text-light">Section</h4></th>
                                        <th><h4 class="text-light">Teacher</h4></th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php foreach ($classes as $class) { ?>

                                        <?php if (empty($class["sections"])) { ?>

                                            <tr class="text-center">

                                                <td style="vertical-align:middle;">
                                                    <h4>
                                                        <?php echo $class["name"]; ?>
                                                    </h4>
                                                </td>

                                                <td colspan="2">
                                                    <span class="text-muted">
                                                        No Sections Assigned
                                                    </span>
                                                </td>

                                            </tr>

                                        <?php continue;} ?>

                                        <?php foreach ($class["sections"] as $section) { ?>

                                            <tr class="text-center">

                                                <td style="vertical-align:middle;">

                                                    <h4>
                                                        <?php echo $class["name"]; ?>
                                                    </h4>

                                                </td>

                                                <td style="vertical-align:middle;">

                                                    <h4>
                                                        <?php echo $section["name"]; ?>
                                                    </h4>

                                                </td>

                                                <td>

                                                    <input
                                                        type="hidden"
                                                        name="class_id[]"
                                                        value="<?php echo $class["id"]; ?>"
                                                    >

                                                    <input
                                                        type="hidden"
                                                        name="section_id[]"
                                                        value="<?php echo $section["id"]; ?>"
                                                    >

                                                    <select
                                                        class="form-select"
                                                        name="employee_id[]"
                                                    >

                                                        <option value="">
                                                            Please Select
                                                        </option>

                                                        <?php $selectedKey =
                                                            $class["id"] . "_" . $section["id"]; ?>

                                                        <?php foreach ($employees as $employee) { ?>

                                                            <option
                                                                value="<?php echo $employee["id"]; ?>"

                                                                <?php if (
                                                                    isset($selected[$selectedKey]) &&
                                                                    $selected[$selectedKey] == $employee["id"]
                                                                ) {
                                                                    echo "selected";
                                                                } ?>
                                                            >

                                                                <?php echo trim(
                                                                    $employee["f_name"] .
                                                                        " " .
                                                                        $employee["m_name"] .
                                                                        " " .
                                                                        $employee["l_name"]
                                                                ); ?>

                                                                
                                                                <?php echo $employee["designation"]; ?>

                                                            </option>

                                                        <?php } ?>

                                                    </select>

                                                </td>

                                            </tr>

                                        <?php } ?>

                                    <?php } ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>   
            <div class="col-md-3"></div>                                         
        </div>
        <button type="submit" class="btn btn-success rounded rounded-pill mt-4"><i class="fa fa-plus"></i> Save</button>
    </form>
   
<?php $this->load->view("inc/app_footer.php"); ?>
