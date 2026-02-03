<?php $this->load->view("inc/app_header.php"); ?>

    <div class="row mb-5">
        <h1>Outstanding Fees Entry</h1>
    </div>

    <div class="card card-flush h-xl-100">
        <div class="card-body py-9">
            <?php echo form_open(base_url("fees/fees-due/create"), array("method" => "GET")) ?> 
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <div class="form-group">
                            <label class="form-label">Select Class</label>
                            <select class="form-select" name="class_id" id="class_id" required>
                                <option value="">Please Select</option>
                                <?php foreach ($classes as $class) { ?>
                                    <option value="<?php echo $class["id"] ?>" <?php if(isset($_GET["class_id"]) && $_GET["class_id"] == $class["id"]) {echo "selected";}?>><?php echo $class["name"] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-3 mb-3">
                        <div class="form-group">
                            <label class="form-label">Select Section</label>
                            <select class="form-select" id="section_id" name="section_id" <?php if(!isset($sections)) { echo "disabled"; }?> required>
                                <?php foreach ($sections as $section) { ?>
                                    <option value="<?php echo $section["id"] ?>" <?php if(isset($_GET["section_id"]) && $_GET["section_id"] == $section["id"]) {echo "selected";}?>><?php echo $section["name"] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-3 mb-3">
                        <div class="form-group">
                            <label class="form-label">Select Student Type</label>
                            <select class="form-select" name="student_type_id" id="student_type_id" required>
                                <option value="">Please Select</option>
                                <?php foreach ($student_types as $student_type) { ?>
                                    <option value="<?php echo $student_type["id"] ?>" <?php if(isset($_GET["student_type_id"]) && $_GET["student_type_id"] == $student_type["id"]) {echo "selected";}?>><?php echo $student_type["name"] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-3 mb-3" style="margin-top: 25px;">
                        <button id="btn_save" class="btn btn-success" <?php if(!isset($sections)) { echo "disabled"; }?>><i class="fa fa-search"></i> Search</button>
                    </div>
                </div>
            <?php echo form_close() ?> 
        </div>
    </div>
    
    
    <?php if(isset($students)) { ?>
        <div class="card card-flush h-xl-100 mt-5">
            <div class="card-body py-9">
                <?php if(count($students) > 0) { ?>
                    <div class="table-responsive">
                        <?php echo form_open(base_url("fees/fees-due/store"), array("method" => "POST")) ?> 
                        <table class="table table-bordered px-2">
                            <thead>
                                <tr class="table-dark text-light">
                                    <th></th>
                                    <th>Name</th>
                                    <th>Student ID</th>
                                    <th>Fees Outstanding (Prev Yr. Due)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $sl_no = 0; foreach($students as $student) { $sl_no++; ?>
                                    <tr>
                                        <td class="table-primary text-dark p-2"><?php echo $sl_no ?></td>
                                        <td>
                                            <?php echo $student['f_name'] . " " . $student['m_name'] . " " . $student['l_name']; ?>
                                        </td>
                                        <td>
                                            <?php echo $student['student_no']; ?>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control d-none" name="student_id[]" value="<?php echo $student['id'] ?>" />
                                            <input type="number" class="form-control amount" name="amount[]" value="<?php if($student['amount'] == "" ) { echo 0; } else { echo $student['amount']; } ?>" />
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                            <tfoot>
                                <tr class="table-dark text-light">
                                    <th colspan="3" class="text-start"><h5 class="text-light">Total Fees Outstanding</h5></th>
                                    <th><h5 id="totalAmount" class="m-0 text-start text-light">0.00</h5></th>
                                </tr>
                            </tfoot>
                        </table>
                        
                        <button type="submit" class="btn btn-success rounded rounded-pill"><i class="fa fa-plus"></i> Save</button>
                        <?php echo form_close() ?> 
                    </div>
                <?php } else { ?>
                    <div class="row justify-content-center">
                        <h3 class="text-center">No Student Found</h3>
                    </div>
                <?php } ?>
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
        
        $(document).ready(function() {
            // Function to update the total whenever an amount is changed
            function updateTotal() {
                let total = 0;
                
                // Loop through all the amount input fields and sum the values
                $('.amount').each(function() {
                    let amount = parseFloat($(this).val()) || 0;  // Use 0 if the value is not a valid number
                    total += amount;
                });
                
                // Update the total amount text
                $('#totalAmount').text(total.toFixed(2));  // Format to 2 decimal places
            }
        
            // Trigger the update when the user changes the amount input
            $('.amount').on('input', function() {
                updateTotal();
            });
        
            // Initial calculation of total on page load in case of pre-filled amounts
            updateTotal();
        });
    </script>

<?php $this->load->view("inc/app_footer.php"); ?>