<?php $this->load->view("inc/app_header.php"); ?>

<style>
    .employee-img {
        width: 180px;
        height: 200px;
        object-fit: cover;
        object-position: center;
    }
</style>

<div class="row mb-5">
    <div class="col-md-6">
        <h1>Employee List</h1>
    </div>
    <div class="col-md-2"></div>
    <div class="col-md-4 text-center">
        <?php if ($this->session->flashdata('success')) { ?>
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                <strong><?php echo $this->session->flashdata('success'); ?></strong>
            </div>
        <?php } ?>
    </div>
</div>

<div class="row mb-5">
    <div class="col-md-12 mb-5">
        <div class="card card-flush h-xl-100">
            <div class="card-body py-9">

                <!-- ===================== TABS ===================== -->
                <ul class="nav nav-pills nav-justified mb-3" id="pills-tab" role="tablist">
                    <?php $i = 0; ?>

                    <!-- All Employees -->
                    <?php $i++; ?>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link tab-button active"
                                id="pills-tab-<?php echo $i; ?>"
                                data-bs-toggle="pill"
                                data-bs-target="#tab-<?php echo $i; ?>"
                                type="button"
                                role="tab"
                                aria-selected="true">
                            All
                        </button>
                    </li>

                    <!-- Employee Type Tabs -->
                    <?php foreach ($employee_types as $type) { $i++; ?>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link tab-button"
                                    id="pills-tab-<?php echo $i; ?>"
                                    data-bs-toggle="pill"
                                    data-bs-target="#tab-<?php echo $i; ?>"
                                    type="button"
                                    role="tab"
                                    aria-selected="false">
                                <?php echo $type['name']; ?>
                            </button>
                        </li>
                    <?php } ?>
                </ul>

                <!-- ===================== TAB CONTENT ===================== -->
                <div class="tab-content" id="pills-tabContent">

                    <?php $i = 0; ?>

                    <!-- ===================== ALL EMPLOYEES ===================== -->
                    <?php $i++; ?>
                    <div class="tab-pane fade show active" id="tab-<?php echo $i; ?>" role="tabpanel">
                        <div class="row justify-content-center">

                            <?php if (count($employees) > 0) { ?>
                                <?php foreach ($employees as $employee) { ?>
                                    <div class="col-md-3 p-md-4 p-sm-2">
                                        <a href="<?php echo base_url(); ?>personnel/employee/show/<?php echo $employee['id']; ?>">
                                            <div class="card" style="width: 80%; cursor: pointer; box-shadow: 1px 7px 11px 0px #b5b5b5;">
                                                <div class="row justify-content-center">
                                                    <?php if ($employee['image']) { ?>
                                                        <img class="card-img-top employee-img"
                                                             src="<?php echo base_url('storage/employees/') . $employee['image']; ?>"
                                                             style="opacity: <?php echo $employee['status'] == 'ACTIVE' ? '1' : '0.3'; ?>">
                                                    <?php } else { ?>
                                                        <img class="card-img-top employee-img"
                                                             src="<?php echo base_url('assets/media/avatar/') . ($employee['sex'] == 'male' ? 'male.jpg' : 'female.jpg'); ?>"
                                                             style="height: 200px; width: fit-content; opacity: <?php echo $employee['status'] == 'ACTIVE' ? '1' : '0.3'; ?>">
                                                    <?php } ?>
                                                </div>
                                                <div class="card-body" style="padding-top: 10px;">
                                                    <h4 class="card-title text-center">
                                                        <?php echo $employee['f_name'] . ' ' . $employee['m_name'] . ' ' . $employee['l_name']; ?>
                                                    </h4>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                <?php } ?>
                            <?php } else { ?>
                                <div class="col-12 text-center mt-4">
                                    <h3>No Data Found</h3>
                                </div>
                            <?php } ?>

                        </div>
                    </div>

                    <!-- ===================== EMPLOYEE TYPE TABS ===================== -->
                    <?php foreach ($employee_types as $type) { $i++; ?>
                        <div class="tab-pane fade" id="tab-<?php echo $i; ?>" role="tabpanel">
                            <div class="row justify-content-center">

                                <?php
                                $found = false;
                                foreach ($employees as $employee) {
                                    if ($employee['emp_type_id'] == $type['id']) {
                                        $found = true;
                                ?>
                                        <div class="col-md-3 p-md-4 p-sm-2">
                                            <a href="<?php echo base_url(); ?>personnel/employee/show/<?php echo $employee['id']; ?>">
                                                <div class="card" style="width: 80%; cursor: pointer; box-shadow: 1px 7px 11px 0px #b5b5b5;">
                                                    <div class="row justify-content-center">
                                                        <?php if ($employee['image']) { ?>
                                                            <img class="card-img-top employee-img"
                                                                 src="<?php echo base_url('storage/employees/') . $employee['image']; ?>"
                                                                 style="opacity: <?php echo $employee['status'] == 'ACTIVE' ? '1' : '0.3'; ?>">
                                                        <?php } else { ?>
                                                            <img class="card-img-top employee-img"
                                                                 src="<?php echo base_url('assets/media/avatar/') . ($employee['sex'] == 'male' ? 'male.jpg' : 'female.jpg'); ?>"
                                                                 style="height: 200px; width: fit-content; opacity: <?php echo $employee['status'] == 'ACTIVE' ? '1' : '0.3'; ?>">
                                                        <?php } ?>
                                                    </div>
                                                    <div class="card-body" style="padding-top: 10px;">
                                                        <h4 class="card-title text-center">
                                                            <?php echo $employee['f_name'] . ' ' . $employee['m_name'] . ' ' . $employee['l_name']; ?>
                                                        </h4>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                <?php
                                    }
                                }

                                if (!$found) {
                                ?>
                                    <div class="col-12 text-center mt-4">
                                        <h3>No Data Found</h3>
                                    </div>
                                <?php } ?>

                            </div>
                        </div>
                    <?php } ?>

                </div>
                <!-- ===================== END TAB CONTENT ===================== -->

            </div>
        </div>
    </div>
</div>

<?php $this->load->view("inc/app_footer.php"); ?>
