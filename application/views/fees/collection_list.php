<?php $this->load->view("inc/app_header.php"); ?>

<div class="row mb-5">
    <div class="col-md-8">
        <h1>Collection List</h1>
    </div>
    <div class="col-md-4 text-center">
        <?php if($this->session->flashdata('success')) { ?>
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                <strong><?php echo $this->session->flashdata('success')?></strong>
            </div>
        <?php } ?>
    </div>
</div>


<div class="card card-flush h-xl-100">
    <div class="card-body py-9">
        <?php echo form_open(base_url("fees/fees-collection/index"), array("method" => "GET")) ?> 
            <div class="row">
                <!-- Class Dropdown -->
                <div class="col-md-3 mb-3">
                    <div class="form-group">
                        <label class="form-label">Select Class</label>
                        <select class="form-select" name="class_id" id="class_id">
                            <option value="">Please Select</option>
                            <?php foreach ($classes as $class) { ?>
                                <option value="<?php echo $class["id"] ?>" <?php if (isset($_GET["class_id"]) && $_GET["class_id"] == $class["id"]) { echo "selected"; } ?>>
                                    <?php echo $class["name"] ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <!-- Section Dropdown -->
                <div class="col-md-3 mb-3">
                    <div class="form-group">
                        <label class="form-label">Select Section</label>
                        <select class="form-select" id="section_id" name="section_id" <?php if (!isset($sections)) { echo "disabled"; } ?>>
                            <option value="">Please Select</option>
                            <?php foreach ($sections as $section) { ?>
                                <option value="<?php echo $section["id"] ?>"  <?php if (isset($_GET["section_id"]) && $_GET["section_id"] == $section["id"]) { echo "selected"; } ?>>
                                    <?php echo $section["name"] ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <!-- Student Type Dropdown -->
                <div class="col-md-3 mb-3">
                    <div class="form-group">
                        <label class="form-label">Select Student Type</label>
                        <select class="form-select" name="student_type_id" id="student_type_id">
                            <option value="">Please Select</option>
                            <?php foreach ($student_types as $student_type) { ?>
                                <option value="<?php echo $student_type["id"] ?>" <?php if (isset($_GET["student_type_id"]) && $_GET["student_type_id"] == $student_type["id"]) { echo "selected"; } ?>>
                                    <?php echo $student_type["name"] ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <!-- From Date -->
                <div class="col-md-3 mb-3">
                    <label class="form-label">From Date</label>
                    <input type="date" class="form-control" name="from_date" value="<?php echo isset($_GET['from_date']) ? $_GET['from_date'] : ''; ?>">
                </div>

                <!-- To Date -->
                <div class="col-md-3 mb-3">
                    <label class="form-label">To Date</label>
                    <input type="date" class="form-control" name="to_date" value="<?php echo isset($_GET['to_date']) ? $_GET['to_date'] : ''; ?>">
                </div>

                <!-- Search Button -->
                <div class="col-md-3 mb-3" style="margin-top: 25px;">
                    <button id="btn_save" class="btn btn-success">
                        <i class="fa fa-search"></i> Search
                    </button>
                </div>
            </div>
        <?php echo form_close() ?> 
    </div>
</div>

<?php if (isset($records) && !empty($records)) { ?>
    <div class="card card-flush h-xl-100">
        <div class="card-body py-9">
            <div class="table-responsive">
                <table class="table table-bordered">
                <thead>
                    <tr class="table-dark text-light">
                        <th></th>
                        <th>Student No</th>
                        <th>Name</th>
                        <th>Receipt ID</th>
                        <th>Receipt Date</th>
                        <th>Payment Method</th>
                        <th>Period</th> <!-- New Column -->
                        <th>Paid</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                
                <tbody>
                    <?php $i = 0; foreach ($records as $record) { $i++; ?>
                        <tr>
                            <td class="table-primary text-dark p-2"><?php echo $i; ?></td>
                            <td><?php echo $record['student_no']; ?></td>
                            <td><?php echo $record['student_name']; ?></td>
                            <td><?php echo $record['receipt_id']; ?></td>
                            <td><?php echo date('d-m-Y', strtotime($record['receipt_date'])); ?></td>
                            <td><?php echo ucwords(str_replace('_', ' ', $record['payment_method'])); ?></td>
                            
                            <!-- Period Column -->
                            <td>
                                <?php
                                    $months = json_decode($record['months'], true);
                                    if (!empty($months)) {
                                        $uniqueMonths = array_unique($months);
                                        $monthNames = array_map(function($m) {
                                            return date('F', mktime(0, 0, 0, $m + 1, 10));
                                        }, $uniqueMonths);
                                        echo implode(', ', $monthNames);
                                    } else {
                                        echo '-';
                                    }
                                ?>
                            </td>
            
                            <td><?php echo number_format($record['net_amount'], 2); ?></td>
                            <td>
                                <!-- Print Button -->
                                <a href="<?php echo base_url('fees/fees-collection/print?receipt_id=' . $record['receipt_id']); ?>" 
                                   class="btn btn-sm btn-edit mx-1" 
                                   title="Print" 
                                   target="_blank">
                                    <i class="fa fa-print"></i>
                                </a>
                            
                                <!-- Delete Button -->
                                <a href="<?php echo base_url('fees/fees-collection/delete?receipt_id=' . $record['receipt_id']); ?>" 
                                   class="btn btn-sm btn-edit mx-1" 
                                   title="Delete" 
                                   onclick="confirmDelete(<?php echo $record['id']; ?>)">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            </div>
        </div>
    </div>
<?php } else { ?>
    <div class="card card-flush h-xl-100">
        <div class="card-body py-9 text-center text-muted">
            <h4 class="text-center">No Data Found</h4>
        </div>
    </div>
<?php } ?>

    
<script>
    $("#class_id").change(function(event) {
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
            $("#btn_save").prop("disabled", false)

        })
    })
</script>



<?php $this->load->view("inc/app_footer.php"); ?>
