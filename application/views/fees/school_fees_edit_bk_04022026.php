<?php $this->load->view("inc/app_header.php"); ?>

    <style>
        .table-responsive {
            height: 500px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            border: 1px solid #ccc;
        }
        .sticky-header {
            position: sticky;
            top: 0;
            background-color: #f2f2f2;
            z-index: 2; /* Ensures the header stays on top */
        }
        .sticky-header {
            position: sticky;
            top: 0;
            background-color: #f2f2f2;
            z-index: 2; /* Ensures the header stays on top */
        }
        .sticky-column-1 {
            position: sticky;
            left:0;
            background-color:  white;
            z-index: 4; /* Ensures the column stays above the table cells */
            min-width: 50px; 
        }
        
        .sticky-column-2 {
            position: sticky;
            left: 50px;
            z-index: 3; /* Ensures the column stays above the table cells */
            min-width: 100px; 
        }
        
        .sticky-column-3 {
            position: sticky;
            left: 150px;
            z-index: 2; /* Ensures the column stays above the table cells */
            min-width: 100px;
            box-shadow: 10px 0 10px -5px rgba(0, 0, 0, 0.2); /* Add a right shadow */
            border-right: 1px solid black !important;
        }
    
        table .form-select {
            width: 150px !important;    
        }
    </style>

    <div class="row mb-5">
        <div class="col-md-8">
            <h1>Edit Monthly Fees</h1>
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
    
    <?php echo form_open(base_url("fees/school-fees/edit"), array("method" => "GET")) ?> 
        <div class="card card-flush h-xl-100 mb-4">
            <div class="card-body py-9">
                <div class="row">
                    <!-- Dropdowns Row -->
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Select Class</label>
                        <select class="form-select" name="class_id" id="class_id">
                            <option value="">-- Select Class --</option>
                            <?php foreach ($classes as $class) { ?>
                                <option value="<?php echo $class['id']; ?>" 
                                    <?php echo (isset($_GET['class_id']) && $_GET['class_id'] == $class['id']) ? 'selected' : ''; ?>>
                                    <?php echo $class['name']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
        
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Select Section</label>
                        <select class="form-select" name="section_id" id="section_id">
                            <option value="">-- Select Section --</option>
                            <?php foreach ($sections as $section) { ?>
                                <option value="<?php echo $section['id']; ?>" 
                                    <?php echo (isset($_GET['section_id']) && $_GET['section_id'] == $section['id']) ? 'selected' : ''; ?>>
                                    <?php echo $section['name']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
        
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Select Student Type</label>
                        <select class="form-select" name="student_type_id" id="student_type_id">
                            <option value="">-- Select Student Type --</option>
                            <?php foreach ($student_types as $student_type) { ?>
                                <option value="<?php echo $student_type['id']; ?>" 
                                    <?php echo (isset($_GET['student_type_id']) && $_GET['student_type_id'] == $student_type['id']) ? 'selected' : ''; ?>>
                                    <?php echo $student_type['name']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Select Month</label>
                        <select class="form-select" name="month_id" id="month">
                            <option value="">-- Select Month --</option>
                            <?php
                            $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                            for ($i = 0; $i < 12; $i++) { // Loop from 0 to 11, skipping 12
                            ?>
                                <option value="<?php echo $i; ?>" 
                                    <?php echo (isset($_GET['month_id']) && $_GET['month_id'] == $i) ? 'selected' : ''; ?>>
                                    <?php echo $months[$i]; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    
                    <div class="col-md-2 d-flex align-items-end mb-3">
                        <button type="submit" class="btn btn-primary w-100">Search</button>
                    </div>
                </div>
            </div>
        </div>
    <?php echo form_close() ?> 
        
    <form name="form_data" action="<?php echo base_url("fees/school-fees/update"); ?>" method="POST">
       
        <?php if(isset($records)) { ?>
            <div class="card card-flush h-xl-100 mb-4" id="students_card">
                <div class="card-body py-9">
                    
                    <?php if(count($records) > 0) { ?>
                        <div class="table-responsive">
                            <table class="table table-bordered px-2">
                                <thead>
                                    <tr class="table-dark text-light">
                                        <th class="sticky-header sticky-column-1" style="z-index: 5 !important;">#</th>
                                        <th class="text-nowrap sticky-header sticky-column-2" style="z-index: 5 !important;">Name</th>
                                        <th class="text-nowrap sticky-header sticky-column-3" style="z-index: 5 !important;">Student No.</th>
                                        <th>Month</th>
                                        <th>Due Date</th>
                                        <?php foreach ($fees_heads as $head): ?>
                                            <th><?php echo htmlspecialchars($head['name']); ?></th>
                                        <?php endforeach; ?>
                                        <th>Total</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $serial = 1; ?>
                                    <?php foreach ($records as $student): ?>
                                        <tr>
                                            <td class="table-warning text-dark p-2 sticky-column-1"><?php echo $serial++; ?></td>
                                            <td class="text-nowrap sticky-column-2" style="background-color: #fbffd1 !important;"><?php echo htmlspecialchars($student['student_name']); ?></td>
                                            <td class="text-nowrap sticky-column-3" style="background-color: #fbffd1 !important;"><?php echo htmlspecialchars($student['student_no']); ?></td>
                                            <td><?php foreach ($months as $index => $month) echo ($_GET['month_id'] == $index) ? $month : ''; ?></td>
                                            <td class="due-date-cell"></td>
                        
                                            <?php $total = 0; ?>
                                            <?php foreach ($fees_heads as $head): ?>
                                                <?php
                                                $fees_for_head = array_filter($student['fees'], function($fee) use ($head) {
                                                    return $fee['fees_head_id'] == $head['id'];
                                                });
                                                ?>
                                                <td>
                                                    <?php if (!empty($fees_for_head)): ?>
                                                        <?php foreach ($fees_for_head as $fee): ?>
                                                            <?php echo number_format($fee['amount'], 2); $total = $total + $fee['amount']; ?><br/>
                                                        <?php endforeach; ?>
                                                    <?php else: ?>
                                                        NA
                                                    <?php endif; ?>
                                                </td>
                                            <?php endforeach; ?>
                                            
                                            <td><?php echo number_format($total, 2); ?></td>
                                            <td>
                                                <button 
                                                    type="button" 
                                                    class="btn btn-primary btn-sm edit-btn" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#editModal" 
                                                    data-student_id="<?php echo $student['student_id']; ?>" 
                                                    data-id="<?php echo $student['student_no']; ?>" 
                                                    data-name="<?php echo htmlspecialchars($student['student_name']); ?>" 
                                                    data-due-date="<?php echo $fee['due_date']; ?>" 
                                                    data-fees='<?php echo json_encode($student['fees'], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT); ?>'>Edit</button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <?php } else { ?>
                        <div class="row justify-content-center">
                            <h3 class="text-center">No Data Found</h3>
                        </div>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
        
    </form>
    
    <!-- Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <form id="editStudentForm" action="<?php echo base_url("fees/school-fees/update"); ?>" method="POST">
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Monthly Fees Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="studentName" class="form-label">Student Name</label>
                        <input type="text" class="form-control" id="studentName" name="studentName" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="studentNo" class="form-label">Student No.</label>
                        <input type="text" class="form-control" id="studentNo" name="studentNo" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="dueDate" class="form-label">Due Date</label>
                        <input type="date" class="form-control" id="dueDate" name="dueDate">
                    </div>
                    
                    <input type="text" class="form-control d-none" id="student_id" name="student_id">
                    <input type="text" class="form-control d-none" name="class_id" value="<?php echo $_GET['class_id'] ?>">
                    <input type="text" class="form-control d-none" name="section_id" value="<?php echo $_GET['section_id'] ?>">
                    <input type="text" class="form-control d-none" name="student_type_id" value="<?php echo $_GET['student_type_id'] ?>">
                    <input type="text" class="form-control d-none" name="month_id" value="<?php echo $_GET['month_id'] ?>">
                   
                    <!-- Fees Head Table -->
                    <h6>Fees Heads</h6>
                    <table class="table table-bordered px-2">
                        <thead>
                            <tr class="table-dark text-light">
                                <th>#</th>
                                <th>Fee Head</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody id="feesHeadsTableBody">
                            <!-- Fee heads will be populated dynamically using JS -->
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="saveChangesBtn">Save Changes</button>
                </div>
            </div>
        </div>
        </form>
    </div>
    
    <script>
        $(document).ready(function() {
            // Iterate over all buttons with class 'edit-btn'
            $('.edit-btn').each(function() {
                // Get the due date from the button's 'data-due-date' attribute
                var dueDate = $(this).data('due-date');
                
                // Find the corresponding row and update the 'due-date-cell' column
                var row = $(this).closest('tr'); // Get the closest row
                var dueDateCell = row.find('.due-date-cell'); // Find the cell for due date
                
                // Set the text content of the due date cell, formatting if necessary
                if (dueDate) {
                    // Optionally format the date here (e.g., 'YYYY-MM-DD')
                    dueDateCell.text(new Date(dueDate).toLocaleDateString());
                } else {
                    dueDateCell.text('NA'); // If no due date is found, show 'NA'
                }
            });
        });
    </script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const editButtons = document.querySelectorAll('.edit-btn');
        
            editButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    const studentId = this.getAttribute('data-id');
                    const studentName = this.getAttribute('data-name');
                    const dueDate = this.getAttribute('data-due-date');
                    
                    // Populate the modal fields
                    document.getElementById('student_id').value = this.getAttribute('data-student_id');
                    document.getElementById('studentName').value = studentName;
                    document.getElementById('studentNo').value = studentId;
                    document.getElementById('dueDate').value = dueDate;
        
                    // Clear previous fee head table rows
                    const feesHeadsTableBody = document.getElementById('feesHeadsTableBody');
                    feesHeadsTableBody.innerHTML = '';
        
                    // Declare variables outside the loop
                    let feeHeadRow, checkboxCell, feeHeadCheckbox, feeHeadNameCell, amountCell, feeAmountInput;
        
                    // Loop through each fee head and create rows in the table
                    <?php foreach ($fees_heads as $head): ?>
                        feeHeadRow = document.createElement('tr');
        
                        // Create checkbox column
                        checkboxCell = document.createElement('td');
                        checkboxCell.className = 'table-primary text-center';
                        feeHeadCheckbox = document.createElement('input');
                        feeHeadCheckbox.type = 'checkbox';
                        feeHeadCheckbox.id = 'feesHead_<?php echo $head['id']; ?>';
                        feeHeadCheckbox.value = '<?php echo $head['id']; ?>';
                        feeHeadCheckbox.name="feesHead_<?php echo $head['id']; ?>"
                        checkboxCell.appendChild(feeHeadCheckbox);
        
                        // Create fee head name column
                        feeHeadNameCell = document.createElement('td');
                        feeHeadNameCell.textContent = '<?php echo htmlspecialchars($head['name']); ?>';
        
                        // Create amount column with input field
                        amountCell = document.createElement('td');
                        feeAmountInput = document.createElement('input');
                        feeAmountInput.type = 'number';
                        feeAmountInput.className = 'form-control';
                        // feeAmountInput.readOnly = true; // Initially readonly
                        feeAmountInput.disabled = true; // Initially disabled
                        feeAmountInput.id = 'amount_<?php echo $head['id']; ?>';
                        feeAmountInput.name = 'amount_<?php echo $head['id']; ?>';
                        amountCell.appendChild(feeAmountInput);
        
                        // Append all cells to the row
                        feeHeadRow.appendChild(checkboxCell);
                        feeHeadRow.appendChild(feeHeadNameCell);
                        feeHeadRow.appendChild(amountCell);
        
                        // Append the row to the table body
                        feesHeadsTableBody.appendChild(feeHeadRow);
        
                        // Loop through student's fees to preselect checkboxes and fill amounts
                        var student_fees = JSON.parse(this.getAttribute('data-fees'));
                        console.log(student_fees)
                        
                        student_fees.forEach(function(fee) {
                            
                                const checkbox = document.getElementById(`feesHead_${Number(fee.fees_head_id)}`);
                                const amountField = document.getElementById(`amount_${Number(fee.fees_head_id)}`);
                              
                                if (checkbox && amountField) {
                                    checkbox.checked = true;
                                    amountField.value = fee.amount;
                                    amountField.disabled = false;
                                }
                         
                        });
                        
                        // Add event listener to toggle input field on checkbox change
                        feeHeadCheckbox.addEventListener('change', function() {
                            const amountField = document.getElementById('amount_<?php echo $head['id']; ?>');
                            if (this.checked) {
                                amountField.disabled = false;
                            } else {
                                amountField.disabled = true;
                                amountField.value = "";  
                            }
                        });
                    <?php endforeach; ?>
                });
            });
        });
    </script>
        
    <script>
        function showCards() {
            const ids = ['students_card', 'month_card', 'fees_head_card'];
            ids.forEach(id => {
                const el = document.getElementById(id);
                if (el) {
                    el.style.display = 'block';
                    el.classList.remove('d-none'); // If Bootstrap's d-none class is also hiding it
                }
            });
        }
    </script>
    
    <script>
        function toggleAll(source) {
            const checkboxes = document.querySelectorAll('.student_checkbox');
            checkboxes.forEach(cb => cb.checked = source.checked);
        }
    </script>
    
    <script>
        $(document).ready(function () {
            const feeHeads = <?php echo json_encode($fees_heads); ?>;
        
            function populateSecondCard() {
                const selected = $(".fee-head-checkbox:checked");
                const container = $("#fee_amounts_container");
                container.html("");
        
                selected.each(function () {
                    const id = $(this).val();
                    const name = $(this).data("name");
                    container.append(`
                        <div class="col-md-4 mb-3">
                            <label>${name}</label>
                            <input type="number" class="form-control fee-amount" name="fee_amounts_${id}" data-id="${id}" required>
                        </div>
                    `);
                });
            }
        
            $("#btn_process").on("click", function () {
                populateSecondCard();
                $("#fees_head_amount_card").slideDown();
            });

        });
        
        $("#class_id").change(function(event) {
            $("#class_id").val()

            fetch("<?php echo base_url('students?class_id=') ?>" + $("#class_id").val())
            .then(response => response.json())
            .then(data => {
                $("#section_id").empty()

                $("#section_id").append(`
                    <option value=''>-- Select Section --</option>
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