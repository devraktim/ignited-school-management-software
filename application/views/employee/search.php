<?php $this->load->view("inc/app_header.php"); ?>

    <div class="row mb-5">
        <div class="col-md-6">
            <h1>Search Employee</h1>
        </div>
    </div>

    <div class="row mb-5">
        <div class="col-md-12 mb-5">
            <div class="card card-flush h-xl-100">
                <div class="card-body py-9">
                    <div class="row">
                        <h4 class="mb-3">Search Parameters</h4>
                    </div>
                    <form action="<?php echo base_url() ?>personnel/employee/search" method="GET">
                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td>Employee Code</td>
                                        <td>
                                            <input class="form-control" type="text" name="emp_code" value="<?php if(isset($_GET['emp_code'])) echo $_GET['emp_code']; ?>">
                                        </td>
                                        <td>First Name</td>
                                        <td>
                                            <input class="form-control" type="text" name="f_name" value="<?php if(isset($_GET['f_name'])) echo $_GET['f_name']; ?>">
                                        </td>
                                        <td>Middle Name</td>
                                        <td>
                                            <input class="form-control" type="text" name="m_name" value="<?php if(isset($_GET['m_name'])) echo $_GET['m_name']; ?>">
                                        </td>
                                        <td>Last Name</td>
                                        <td>
                                            <input class="form-control" type="text" name="l_name" value="<?php if(isset($_GET['l_name'])) echo $_GET['l_name']; ?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Sex</td>
                                        <td>
                                            <select class="form-select" name="sex" value="<?php if(isset($_GET['sex'])) echo $_GET['sex']; ?>">
                                                <option value="">Any</option>
                                                <option value="male"    <?php if(isset($_GET['sex']) && $_GET['sex'] == "male") echo "selected"; ?>>Male</option>
                                                <option value="female"  <?php if(isset($_GET['sex']) && $_GET['sex'] == "female") echo "selected"; ?>>Female</option>
                                                <option value="other"   <?php if(isset($_GET['sex']) && $_GET['sex'] == "other") echo "selected"; ?>>Other</option>
                                            </select>
                                        </td>
                                        <td>Category</td>
                                        <td>
                                            <select class="form-select" name="category_id">
                                                <option value="">Any</option>
                                                <?php foreach ($categories as $category) { ?>
                                                    <option value="<?php echo $category["id"] ?>" <?php if(isset($_GET['category_id']) && $_GET['category_id'] == $category["id"]) echo "selected"; ?>><?php echo $category["name"] ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        <td>Department</td>
                                        <td>
                                            <select class="form-select" name="department_id">
                                                <option value="">Any</option>
                                                <?php foreach ($departments as $department) { ?>
                                                    <option value="<?php echo $department["id"] ?>"  <?php if(isset($_GET['department_id']) && $_GET['department_id'] == $department["id"]) echo "selected"; ?>><?php echo $department["name"] ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        <td>Designation</td>
                                        <td>
                                            <select class="form-select" name="designation_id">
                                                <option value="">Any</option>
                                                <?php foreach ($designations as $designation) { ?>
                                                    <option value="<?php echo $designation["id"] ?>"  <?php if(isset($_GET['designation_id']) && $_GET['designation_id'] == $designation["id"]) echo "selected"; ?>><?php echo $designation["name"] ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                
                                    </tr>
                                    <tr>
                                        <td>Religion</td>
                                        <td>
                                            <select class="form-select" name="religion_id">
                                                <option value="">Any</option>
                                                <?php foreach ($religions as $religion) { ?>
                                                    <option value="<?php echo $religion["id"] ?>"  <?php if(isset($_GET['religion_id']) && $_GET['religion_id'] == $religion["id"]) echo "selected"; ?>><?php echo $religion["name"] ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        <td>Nationality</td>
                                        <td>
                                            <select class="form-select" name="nationality_id">
                                                <option value="">Any</option>
                                                <?php foreach ($nationalities as $nationality) { ?>
                                                    <option value="<?php echo $nationality["id"] ?>" <?php if(isset($_GET['nationality_id']) && $_GET['nationality_id'] == $nationality["id"]) echo "selected"; ?>><?php echo $nationality["name"] ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        <td>Employee Type</td>
                                        <td>
                                            <select class="form-select" name="emp_type_id">
                                                <option value="">Any</option>
                                                <?php foreach ($employee_types as $type) { ?>
                                                    <option value="<?php echo $type["id"] ?>" <?php if(isset($_GET['emp_type_id']) && $_GET['emp_type_id'] == $type["id"]) echo "selected"; ?>><?php echo $type["name"] ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        <td>Job Status</td>
                                        <td>
                                            <select class="form-select" name="job_status_id">
                                                <option value="">Any</option>
                                                <?php foreach ($job_status as $status) { ?>
                                                    <option value="<?php echo $status["id"] ?>" <?php if(isset($_GET['job_status_id']) && $_GET['job_status_id'] == $status["id"]) echo "selected"; ?>><?php echo $status["name"] ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="8" class="text-center">
                                            <button type="submit" class="btn btn-success"><i class="fa fa-search"></i> Search</button> 
                                            <input type="reset" class="btn btn-warning" value="Reset">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php if(isset($employees)) { ?>
        <div class="row mb-5">
            <div class="col-md-12 mb-5">
                <div class="card card-flush h-xl-100">
                    <div class="card-body py-9">
                        <div class="row">
                            <h4 class="mb-3">Employees</h4>
                        </div>
                        <div class="row">
                            <?php if(count($employees) == 0) { ?>
                                <h4 class="text-center">No Employees Found</h4>    
                            <?php } else { ?>
                                <div class="table-responsive table-bordered table-striped table-hover">
                                    <table class="table">
                                        <thead>
                                            <tr class="text-center table-dark text-light">
                                                <th></th>
                                                <th>Employee Code</th>
                                                <th>Name</th>
                                                <th>Department</th>
                                                <th>Designation</th>
                                                <th>Sex</th>
                                                <th>Category</th>
                                                <th>Employee Type</th>
                                                <th>Job Status</th>
                                                <th>Religion</th>
                                                <th>Nationality</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $sl_no = 0; foreach($employees as $employee) {  $sl_no++; ?>
                                                <tr class="text-center">
                                                    <td class="table-dark text-light text-end"><?php echo $sl_no ?></td>
                                                    <td><?php echo $employee["emp_code"] ?></td>
                                                    <td><?php echo $employee["f_name"] . " " . $employee["m_name"] . " " . $employee["l_name"]?></td>
                                                    <td><?php echo $departments[$employee["department_id"] - 1]['name'] ?></td>
                                                    <td><?php echo $designations[$employee["designation_id"] - 1]['name'] ?></td>
                                                    <td><?php echo $employee["sex"] ?></td>
                                                    <td><?php echo $categories[$employee["category_id"] - 1]['name'] ?></td>
                                                    <td><?php echo $employee_types[$employee["emp_type_id"] - 1]['name'] ?></td>
                                                    <td><?php echo $job_status[$employee["job_status_id"] - 1]['name'] ?></td>
                                                    <td><?php echo $religions[$employee["religion_id"] - 1]['name'] ?></td>
                                                    <td><?php echo $nationalities[$employee["nationality_id"] - 1]['name'] ?></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>

<?php $this->load->view("inc/app_footer.php"); ?>