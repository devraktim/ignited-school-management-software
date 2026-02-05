<?php $this->load->view("inc/app_header.php"); ?>

<style>
    .select2-selection--single {
        height: 43px !important;
        border: 1px solid black !important;
    }

</style>

<!-- Include Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<div class="row mb-5">
    <h1>Fees Reports</h1>
</div>

<form id="form" method="GET" action="" target="_blank">
    <div class="row mb-5">
        <div class="col-md-12">
            <div class="card card-flush h-xl-100">
                <div class="card-body py-9">
                    <h4 class="text-center text-dark bg-secondary py-3 mb-3">Report Criteria</h4>
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <tbody>
                                <!-- First Row: From Date ~ To Date and From Month ~ To Month -->
                                <tr>
                                    <td><label for="from_date" class="fw-semibold">From Date</label></td>
                                    <td>
                                        <input type="date" class="form-control" id="from_date" name="from_date" value="<?= isset($_GET['from_date']) ? $_GET['from_date'] : '' ?>">
                                    </td>
                        
                                    <td><label for="to_date" class="fw-semibold">To Date</label></td>
                                    <td>
                                        <input type="date" class="form-control" id="to_date" name="to_date" value="<?= isset($_GET['to_date']) ? $_GET['to_date'] : '' ?>">
                                    </td>
                        
                                    <td><label class="me-2">From Month</label></td>
                                    <td>
                                        <select class="form-select me-3 month-select" name="month_from" style="width:auto;">
                                            <option value="">Please Select</option>
                                            <?php foreach (range(1, 12) as $m) { ?>
                                                <option value="<?= $m ?>"><?= date("F", mktime(0, 0, 0, $m, 1)) ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                        
                                    <td><label class="me-2">To Month</label></td>
                                    <td>
                                        <select class="form-select me-3 month-select" name="month_to" style="width:auto;">
                                            <option value="">Please Select</option>
                                            <?php foreach (range(1, 12) as $m) { ?>
                                                <option value="<?= $m ?>"><?= date("F", mktime(0, 0, 0, $m, 1)) ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                </tr>
                        
                                <!-- Second Row: Class, Section, and Student Type -->
                                <tr>
                                    <td><label class="fw-semibold">Class</label></td>
                                    <td>
                                        <select class="form-select" id="class_id" name="class_id">
                                            <option value="">Please Select</option>
                                            <?php foreach ($classes as $class) { ?>
                                                <option value="<?= $class['id'] ?>" <?= isset($_GET['class_id']) && $_GET['class_id'] == $class['id'] ? 'selected' : '' ?>><?= $class['name'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                        
                                    <td><label class="fw-semibold">Section</label></td>
                                    <td>
                                        <select class="form-select" id="section_id" name="section_id">
                                            <option value="">Please Select</option>
                                            <?php foreach ($sections as $section) { ?>
                                                <option value="<?= $section['id'] ?>" <?= isset($_GET['section_id']) && $_GET['section_id'] == $section['id'] ? 'selected' : '' ?>><?= $section['name'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                        
                                    <td><label class="fw-semibold">Student Type</label></td>
                                    <td>
                                        <select class="form-select" id="student_type_id" name="student_type_id">
                                            <option value="">Please Select</option>
                                            <?php foreach ($student_types as $type) { ?>
                                                <option value="<?= $type['id'] ?>" <?= isset($_GET['student_type_id']) && $_GET['student_type_id'] == $type['id'] ? 'selected' : '' ?>><?= $type['name'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                </tr>
                        
                                <!-- Payment Modes Section -->
                                <tr>
                                    <td colspan="10">
                                        <div class="d-flex align-items-center flex-wrap">
                                            <?php 
                                                $payment_modes = [
                                                    'cash'         => 'Cash',
                                                    'credit_card'  => 'Credit Card',
                                                    'debit_card'   => 'Debit Card',
                                                    'qr_code'      => 'QR Code Scan',
                                                    'cheque'       => 'Cheque / Pay Order',
                                                    'neft'         => 'NEFT / RTGS',
                                                    'bank_deposit' => 'Bank Deposit'
                                                ];
                        
                                                foreach ($payment_modes as $key => $label) { ?>
                                                    <div class="form-check me-3">
                                                        <input class="form-check-input payment_mode" type="checkbox" name="payment_mode[]" value="<?= $key ?>">
                                                        <label class="form-check-label"><?= $label ?></label>
                                                    </div>
                                            <?php } ?>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SCHOOL FEES COLLECTION REPORTS -->
    <div class="row">
        <div class="col-md-4">
            <div class="card card-flush h-xl-100">
                <div class="card-body py-9">
                    <h4 class="text-center text-dark bg-secondary py-3 mb-3">School Fees Collection Report</h4>
                    <button type="button" class="btn btn-primary mb-3 w-100" onclick="report('fee-collection')">Fee Collection</button>
                    <button type="button" class="btn btn-primary mb-3 w-100" onclick="report('fee-head-wise-collection')">Fee Head wise Collection</button>
                    <button type="button" class="btn btn-primary mb-3 w-100" onclick="report('payment-wise-collection')">Payment wise Collection</button>
                    <button type="button" class="btn btn-primary mb-3 w-100" onclick="report('personnel-wise-collection')">Collection Personnel wise Fee Collection</button>
                </div>
            </div>
        </div>

        <!-- OTHER REPORTS -->
        <div class="col-md-4">
            <div class="card card-flush h-xl-100">
                <div class="card-body py-9">
                    <h4 class="text-center text-dark bg-secondary py-3 mb-3">Other Reports</h4>
                    <button type="button" class="btn btn-primary mb-3 w-100" onclick="report('total-concession')">
                        Total Concession</button>
                </div>
            </div>
        </div>

        <!-- PAYMENT & OUTSTANDING REPORTS -->
        <div class="col-md-4">
            <div class="card card-flush h-xl-100">
                <div class="card-body py-9">
                    <h4 class="text-center text-dark bg-secondary py-3 mb-3">Payment & Outstanding Reports</h4>
                    <button type="button" class="btn btn-primary mb-3 w-100" onclick="generateClassMonthlyCollection()">Class wise Monthly/Months Collection</button>
                    <button type="button" class="btn btn-primary mb-3 w-100" onclick="generateClassAllCollection()">Class wise All Months Collection</button>
                    <button type="button" class="btn btn-primary mb-3 w-100" onclick="generateClassOutstanding()">Class wise Outstanding</button>
                    
                    <select class="form-select" id="state_id" name="state_id">
                        <option value="">Please Select</option>
                        <?php foreach ($states as $state) { ?>
                            <option value="<?= $state['id'] ?>" <?= isset($_GET['state_id']) && $_GET['state_id'] == $state['id'] ? 'selected' : '' ?>>
                                <?= $state['name'] ?>
                            </option>
                        <?php } ?>
                    </select>
                    
                    <button type="button" class="btn btn-primary mt-3 mb-3 w-100" onclick="generateStateWiseOutstanding()">State Wise Outstanding</button>
                    
                    <button type="button" class="btn btn-primary mb-3 w-100" onclick="getConsolidedOutstanding()">Consolidated Outstanding</button>
                    
                    <select class="form-select mb-5" id="student_search" name="student_id">
                        <option value="">Type to search student...</option>
                        <?php foreach ($students as $student) { ?>
                            <option value="<?php echo $student["id"]; ?>" 
                                <?php echo ($selected_id == $student["id"]) ? 'selected' : ''; ?>>
                                <?php echo $student["student_no"] . " - " . $student["name"]; ?>
                            </option>
                        <?php } ?>
                    </select>
                    
                    <button type="button" class="btn btn-primary mb-3 w-100" onclick="generateStudentPayment()">Student's Monthly Payment</button>
                    <button type="button" class="btn btn-primary mb-3 w-100" onclick="report('previous-year-outstanding')">Previous Year Outstanding</button>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        $('#student_search').select2({
            placeholder: "Type to search student...",
            allowClear: true,
            width: '100%' // Ensures it fits parent container
        });

        // Submit form on selection
        $('#student_search').on('change', function() {
            if ($(this).val()) {
                $('#studentSearchForm').submit();
            }
        });
    });
</script>


<script>
    function getConsolidedOutstanding() {
        
        const studentTypeSelect = document.getElementById('student_type_id');
        const studentTypeValue = studentTypeSelect.value.trim();
    
        if (studentTypeValue === "") {
            alert("Please select a student type.");
            studentTypeSelect.focus();
            return false;
        }
        
        report('consolidated-outstanding')
    }
    
    function generateClassMonthlyCollection() {
        
        const classSelect = document.getElementById('class_id');
        const classValue = classSelect.value.trim();
    
        if (classValue === "") {
            alert("Please select a class.");
            classSelect.focus();
            return false;
        }
        

        const monthFrom = document.querySelector('select[name="month_from"]').value;
        const monthTo = document.querySelector('select[name="month_to"]').value;
        
        if (!monthFrom || !monthTo) {
            alert("Please select both 'From' and 'To' months.");
            return false;
        }

        // If everything is valid, proceed with the report
        report('class-wise-all-months-collection');
    }
    
    function generateClassAllCollection() {
        
        const classSelect = document.getElementById('class_id');
        const classValue = classSelect.value.trim();
    
        if (classValue === "") {
            alert("Please select a class.");
            classSelect.focus();
            return false;
        }
        

        report('class-wise-all-months-collection')
    }

    function generateStudentPayment() {
        const studentNo = document.getElementById('student_search').value.trim();
        
        if (studentNo === "") {
            alert("Please select a student.");
            return false;
        }
    
        // Call the report function with 'students-monthly-payment'
        report('students-monthly-payment');
    }

    function generateClassOutstanding() {
        const classSelect = document.getElementById('class_id');
        const classValue = classSelect.value.trim();
    
        if (classValue === "") {
            alert("Please select a Class before generating the report.");
            classSelect.focus();
            return false;
        }
    
        // If class is selected, proceed as usual
        report('class-wise-outstanding');
    }
  
    function generateStateWiseOutstanding() {
        const stateSelect = document.getElementById('state_id');
        const stateValue = stateSelect.value.trim();
    
        if (stateValue === "") {
            alert("Please select a State before generating the report.");
            stateSelect.focus();
            return false;
        }
    
        // If state is selected, proceed as usual
        report('state-wise-outstanding');
    }
</script>

<script>
    function report(name) {
        // All reports submit via GET method with full form data
        $("#form").attr("method", "GET");
        $("#form").attr("action", "<?php echo base_url('fees/reports/'); ?>" + name);
        $("#form").submit();
    }

    // Fetch section by class selection
    function fetch_section() {
        fetch("<?php echo base_url('students?class_id='); ?>" + $("#class_id").val())
            .then(response => response.json())
            .then(data => {
                $("#section_id").empty();
                $("#section_id").append(`<option value=''>Any</option>`);
                data.sections.forEach((section) => {
                    $("#section_id").append(`<option value=${section.id}>${section.name}</option>`);
                });
                $("#section_id").prop("disabled", false);
            });
    }

    $(document).ready(function () {
        $("#section_id").prop("disabled", true);
        fetch_section();
        $("#class_id").change(function () {
            fetch_section();
        });
    });
</script>

<script>
    $(document).ready(function () {
        // Enable Installment checkboxes when Installment checkbox checked
        $("#chk_installment").on("change", function () {
            $(".installment").prop("disabled", !this.checked);
        });

        // Enable Month dropdowns when Month checkbox checked
        $("#chk_month").on("change", function () {
            $(".month-select").prop("disabled", !this.checked);
        });
    });
</script>

<?php $this->load->view("inc/app_footer.php"); ?>
