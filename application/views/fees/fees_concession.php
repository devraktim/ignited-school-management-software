<?php $this->load->view("inc/app_header.php"); ?>

    <div class="row mb-5">
        <div class="col-md-8">
            <h1>Concession Fees Entry</h1>
        </div>
        <div class="col-md-4 text-center">
            <?php if($this->session->flashdata('success'))  {?>
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    <strong><?php echo $this->session->flashdata('success')?></strong>
                </div>
            <?php } ?>
        </div>
    </div>

    <div class="card card-flush h-xl-100">
        <div class="card-body py-9">
            <?php echo form_open(base_url("fees/fees-concession/create"), array("method" => "GET")) ?> 
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
       
                <div class="row">
                    <div class="col-md-6">
                        <div class="card card-flush h-xl-100 mt-5">
                            <div class="card-body py-9">
                                <?php if(count($students) > 0) { ?>
                                    <div class="table-responsive">
                                        <table class="table table-bordered px-2">
                                            <thead>
                                                <tr class="table-dark text-light">
                                                    <th></th>
                                                    <th>Name</th>
                                                    <th>Student ID</th>
                                                    <th>Concession</th>
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
                                                            <select class="form-select concession-select" data-student-id="<?php echo $student['id']; ?>" data-student-name="<?php echo $student['f_name'] . " " . $student['m_name'] . " " . $student['l_name']; ?>" data-student-no="<?php echo $student['student_no']; ?>" name="concession[]">
                                                                <option value="0" selected="">No</option>
                                                                <option value="1">Yes</option>
                                                            </select>
                                                            <input type="hidden" name="student_id" value="<?php echo $student['id'] ?>" />
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                            </div>
                                <?php } else { ?>
                                    <div class="row justify-content-center">
                                        <h3 class="text-center">No Student Found</h3>
                                    </div>
                                <?php } ?>  
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6" id="data-table" style="display: none;">
                        <div class="card card-flush h-xl-100 mt-5">
                            <div class="card-body py-9">
                                <div class="table-responsive">
                                    <table class="table" id="selected-students-table">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Student Number</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Dynamically populated -->
                                        </tbody>
                                    </table>
                                </div>
                                
                                <?php echo form_open(base_url("fees/fees-concession/store"), array("method" => "POST")) ?> 
                                    <h4>Concession Entry</h4>
                                    <div class="table-responsive">
                                        <table class="table" id="selected-students-table">
                                            <tbody>
                                                <tr>
                                                    <th><?php echo $payment_plan_type_display == "month" ? "Month" : "Installment No."; ?></th>
                                                    <th>Amount</th>
                                                </tr>
                                            
                                                <?php
                                                // List of months
                                                $months = [
                                                    "January", "February", "March", "April", "May", "June",
                                                    "July", "August", "September", "October", "November", "December"
                                                ];
                                            
                                                // Loop through the months or installments
                                                for ($i = 0; $i < 12; $i++) {
                                                    $isMonth = $payment_plan_type_display == "month";
                                                    $label = $isMonth ? $months[$i] : "Installment " . ($i + 1);
                                                    $inputName = $isMonth ? "ins_" . ($i + 1) : "ins_" . ($i + 1);
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $label; ?></td>
                                                        <td>
                                                            <input type="text" class="form-control" name="<?php echo $inputName; ?>">
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    
                                    <input type="text" class="d-none" name="student_id" id="student_id" />
                                    <button type="submit" class="btn btn-success">Save</button>
                                <?php echo form_close() ?> 
                            </div>
                        </div>
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
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectElements = document.querySelectorAll('.concession-select');
            const selectedTableBody = document.querySelector('#selected-students-table tbody');
        
            // Event listener for the "concession" select dropdown
            selectElements.forEach(function(selectElement) {
                selectElement.addEventListener('change', function() {
                    const studentId = this.getAttribute('data-student-id');
                    const studentName = this.getAttribute('data-student-name');
                    const studentNo = this.getAttribute('data-student-no');
        
                    document.getElementById('student_id').value = studentId
                    selectedTableBody.innerHTML = '';
                    
                    if (this.value === '1') { // If "Yes" is selected
                        // Create a new row for the selected student
                        const newRow = document.createElement('tr');
                        newRow.innerHTML = `
                            <td>${studentName}</td>
                            <td>${studentNo}</td>
                        `;
                        selectedTableBody.appendChild(newRow);
                        
                        document.getElementById('data-table').style.display = 'block'
                    } else {
                        // Remove the row if "No" is selected
                        const rows = selectedTableBody.querySelectorAll('tr');
                        rows.forEach(function(row) {
                            const idCell = row.querySelector('td:first-child');
                            if (idCell && idCell.textContent === studentId) {
                                row.remove();
                            }
                        });
                        
                        document.getElementById('data-table').style.display = 'none'
                    }
                });
            });
        });
    </script>

<?php $this->load->view("inc/app_footer.php"); ?>