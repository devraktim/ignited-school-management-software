<?php $this->load->view("inc/app_header.php"); ?>

    <div class="row mb-5">
        <div class="col-md-8">
            <h1>Set Monthly Fees/ Student Installment Entry</h1>
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
    
    <?php echo form_open(base_url("fees/school-fees/create"), array("method" => "GET")) ?> 
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
        
                    <div class="col-md-3 d-flex align-items-end mb-3">
                        <button type="submit" class="btn btn-primary w-100">Search</button>
                    </div>
                </div>
            </div>
        </div>
    <?php echo form_close() ?> 
        
    <form name="form_data" id="form_data" action="<?php echo base_url("fees/school-fees/store"); ?>" method="POST">
        
        <input type="text" class="d-none" name="class_id" value="<?php echo $_GET['class_id']; ?>" />
        <input type="text" class="d-none" name="section_id" value="<?php echo $_GET['section_id']; ?>" />
        <input type="text" class="d-none" name="student_type_id" value="<?php echo $_GET['student_type_id']; ?>" />
        
        <?php if(isset($outstanding_fees)) { ?>
            <div class="card card-flush h-xl-100 mb-4 step-form-1" id="students_card">
                <div class="card-body py-9">
                    <h2 class="d-block">Student (Class/ Section)</h2>
                    <hr />
                    
                    <?php if(count($outstanding_fees) > 0) { ?>
                        <div class="table-responsive">
                        <?php echo form_open(base_url("fees/fees-due/store"), array("method" => "POST")) ?> 
                        <table class="table table-bordered px-2">
                            <thead>
                                <tr class="table-dark text-light">
                                    <th class="text-center">
                                        <input type="checkbox" id="select_all" onclick="toggleAll(this)">
                                    </th>
                                    <!--<th>#</th>-->
                                    <th>Name</th>
                                    <th>Student ID</th>
                                    <th>Class</th>
                                    <th>Section</th>
                                    <th>Student Type</th>
                                    <th>Fees Outstanding (Prev Yr. Due)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $sl_no = 0; foreach($outstanding_fees as $outstanding_fee) { $sl_no++; ?>
                                    <tr>
                                        <td class="table-primary text-center">
                                            <input type="checkbox" class="student_checkbox" name="selected_students[]" value="<?php echo $outstanding_fee['student_id']; ?>">
                                        </td>
                                        <!--<td class="table-primary text-dark"><?php echo $sl_no ?></td>-->
                                        <td>
                                            <?php echo $outstanding_fee['student_name']; ?>
                                        </td>
                                        <td>
                                            <?php echo $outstanding_fee['student_no']; ?>
                                        </td>
                                        
                                        <td>
                                            <?php echo $selected_class['name']; ?>
                                        </td>
                                        <td>
                                            <?php echo $selected_section['name']; ?>
                                        </td>
                                        <td>
                                            <?php echo $selected_student_type['name']; ?>
                                        </td>
                                        
                                        <td>
                                            <?php 
                                                $amount = ($outstanding_fee['amount'] === "" ? 0 : $outstanding_fee['amount']);
                                                echo number_format($amount, 2);
                                            ?>
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
                    
                    <div class="col-md-3 mb-3" style="margin-top: 25px;">
                        <button type="button" id="step-button-1" class="btn btn-primary">Proceed Now</button>
                    </div>
                </div>
            </div>
        <?php } ?>

        <?php if(isset($outstanding_fees)) { ?>
        <div class="card card-flush h-xl-100 mb-4 step-form-2" id="month_card" style="display: none;">
            <div class="card-body py-9">
                <div class="row">
                    <div class="col-12 mb-3">
                        <h2 class="d-block">Select Month/ Months and Set The Due Date</h2>
                        <hr />
                        <div class="row">
                            <?php
                            $months = [
                                "Jan", "Feb", "Mar", "Apr",
                                "May", "Jun", "Jul", "Aug",
                                "Sep", "Oct", "Nov", "Dec"
                            ];

                            // get start & end month index (0–11)
                            $startMonth = (int) date('n', strtotime($this->session->academy_session['current_session']['start'])) - 1;
                            $endMonth   = (int) date('n', strtotime($this->session->academy_session['current_session']['end'])) - 1;

                            // build display order
                            $orderedIndexes = [];

                            if ($startMonth <= $endMonth) {
                                // e.g. Mar → Aug
                                $orderedIndexes = range($startMonth, $endMonth);
                            } else {
                                // e.g. Feb → Jan (wrap around year)
                                $orderedIndexes = array_merge(
                                    range($startMonth, 11),
                                    range(0, $endMonth)
                                );
                            }

                            // render months in new order (IDs & names unchanged)
                            foreach ($orderedIndexes as $index) {
                            ?>
                                <div class="col-md-3 mb-3">
                                    <div class="form-check">
                                        <input 
                                            class="form-check-input" 
                                            type="checkbox" 
                                            id="month_<?php echo $index; ?>"
                                            name="months[]" 
                                            value="<?php echo $index; ?>" 
                                        />
                                        
                                        <label class="form-check-label" for="month_<?php echo $index; ?>">
                                            <?php echo $months[$index]; ?>
                                        </label>
                                    </div>
                                    
                                    <input 
                                        type="date" 
                                        class="form-control mt-2" 
                                        name="month_dates_<?php echo $index; ?>" 
                                    />
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3 mb-3" style="margin-top: 25px;">
                    <button type="button" id="step-button-2" class="btn btn-primary">Proceed Now</button>
                </div>
            </div>
        </div>
        <?php } ?>

        <?php if(isset($outstanding_fees)) { ?>
        <div class="card card-flush h-xl-100 mb-4 step-form-3" id="fees_head_card" style="display: none;">
            <div class="card-body py-9">
                <div class="row">
                    <div class="col-12 mb-3">
                        <h2 class="d-block">Select Fee Heads <span class="text-danger">*</span></h2>
                        <hr />
                        <div class="row">
                            <?php foreach ($assign_fees_heads as $index => $fees_head) { ?>
                                <div class="col-md-3 mb-2">
                                    <div class="form-check">
                                        <input 
                                            class="form-check-input fee-head-checkbox" 
                                            type="checkbox" 
                                            name="fees_head_id[]" 
                                            value="<?php echo $fees_head['id']; ?>"
                                            id="fees_head_<?php echo $index; ?>"
                                            data-name="<?php echo $fees_head['name']; ?>"
                                            <?php if (isset($_GET['fees_head_id']) && in_array($fees_head['id'], (array)$_GET['fees_head_id'])) echo 'checked'; ?>
                                        >
                                        <label class="form-check-label" for="fees_head_<?php echo $index; ?>">
                                            <?php echo $fees_head['name']; ?>
                                        </label>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
            
                    <div class="col-md-3 mb-3" style="margin-top: 25px;">
                        <button type="button" id="btn_process" class="btn btn-primary">Proceed Now</button>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
        
        <div class="card card-flush h-xl-100 mt-5 mb-4 step-form-4" id="fees_head_amount_card" style="display: none;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <!-- Left Side -->
                    <h2 class="mb-0">Enter Fee Amounts</h2>
            
                    <!-- Right Side -->
                    <h4 class="mb-0">Total Amount: <span id="total_amount_display">00.00 INR</span></h4>
                </div>
                
                <hr />
            
                <div class="row" id="fee_amounts_container">
                    <!-- Dynamically added fee head amount fields -->
                </div>
            
                <button type="submit" id="submit_btn" class="btn btn-success">Save</button>
            </div>
        </div>
    
    </form>
    
    <!--Step Validation-->
    <script>
        $(document).ready(function() {
            $("#step-button-1").click(function() {
                if ($('.student_checkbox:checked').length === 0) {
                    alert("Please select at least one student to proceed further.");
                    
                    $('.step-form-2').css('display', 'none');
                } else {
                   $('.step-form-2').css('display', 'block');
                }
            })
            
            $("#step-button-2").on("click", function() {
                var isValid = true;
                
                // Check if at least one month is selected
                var selectedMonths = $("input[name='months[]']:checked");
                if (selectedMonths.length === 0) {
                    alert("Please select at least one month.");
                    isValid = false;
                } else {
                    // Check if each selected month has a due date
                    selectedMonths.each(function() {
                        var monthIndex = $(this).val();
                        var dueDateField = $("input[name='month_dates_" + monthIndex + "']");
                        if (!dueDateField.val()) {
                            alert("Please set the due date for " + $(this).next('label').text().trim() + " month.");
                            isValid = false;
                            return false; // Stop the loop on the first error
                        }
                    });
                }
        
                if (isValid) {
                    $('.step-form-3').css('display', 'block');
                }
                else {
                    $('.step-form-3').css('display', 'none');
                }
            });
            
        })
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
                
                if(selected.length === 0) {
                    alert("Please select at least one fees head to proceed further.")
                    
                    return;
                }
        
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
                
                $("#fees_head_amount_card").slideDown();
            }
            
            // Function to calculate and update total amount
            function updateTotalAmount() {
                let total = 0;
        
                $(".fee-amount").each(function () {
                    const val = parseFloat($(this).val());
                    if (!isNaN(val)) {
                        total += val;
                    }
                });
        
                // Update the header total amount
                $("#total_amount_display").text(total.toFixed(2) + " INR");
            }
        
            $("#btn_process").on("click", function () {
                populateSecondCard();
            });
            
            // Bind the event listener
            $(document).on("input", ".fee-amount", function () {
                updateTotalAmount();
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