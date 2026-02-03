<?php $this->load->view("inc/app_header.php"); ?>

<style>
    /* Increase height of Select2 input */
    .select2-container .select2-selection--single {
        height: 45px !important;
        padding: 6px 12px;
        font-size: 16px;
        line-height: 30px;
    }
    
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 30px;
    }
    
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 45px;
    }
    
    /*#modalTableBody tr:nth-last-child(-n+4) {*/
    /*  background-color: #e7f1ff;*/
    /*  font-weight: 600;*/
    /*  border-top: 2px solid #0056b3;*/
    /*  box-shadow: inset 0 2px 5px rgba(0,0,0,0.1);*/
    /*}*/
    
    /*#modalTableBody tr td {*/
    /*    padding-left: 5px;*/
    /*    padding-right: 5px;*/
    /*}*/
    
    #fees-table td:nth-child(2) textarea,
    #fees-table td:nth-child(2) input[type=text],
    #fees-table td:nth-child(2) input[type=email],
    #fees-table td:nth-child(2) input[type=number],
    #fees-table td:nth-child(2) input[type=date],
    #fees-table td:nth-child(2) select {
        background-color: #ffffd9 !important;
    }
</style>

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
        z-index: 2; /* Ensures the header stays on top */
    }
 
    .sticky-column-1 {
        position: sticky;
        left: 0;
        z-index: 4;
        min-width: 200px; 
    }
    
    .sticky-column-2 {
        position: sticky;
        left: 200px;
        z-index: 3;
        min-width: 400px; 
        box-shadow: 1px 0 0 0 black, 10px 0 10px -5px rgba(0, 0, 0, 0.2);
    }
</style>


<!-- Include Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<div class="row mb-5">
    <div class="col-md-8">
        <h1>Fee Collection</h1>
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

<!-- Search Student-->
<?php
$selected_id = isset($_GET['student_id']) ? $_GET['student_id'] : '';
?>
<div class="card card-flush h-xl-100">
    <div class="card-body py-9">
        <?php echo form_open(base_url("fees/fees-collection/create"), array("method" => "GET", "target" => "_blank", "id" => "studentSearchForm")) ?> 
            <?php if(count($students) > 0) { ?>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label class="form-label">Search Student</label>
                        <select class="form-select" id="student_search" name="student_id" required>
                            <option value="">Type to search student...</option>
                            <?php foreach ($students as $student) { ?>
                                <option value="<?php echo $student["id"]; ?>" 
                                    <?php echo ($selected_id == $student["id"]) ? 'selected' : ''; ?>>
                                    <?php echo $student["student_no"] . " - " . $student["name"]; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
            <?php } else { ?>
                <div class="row">
                    <h4 class="text-center">No Data Found</h4>
                </div>
            <?php } ?>
        <?php echo form_close(); ?>
    </div>
</div>


<!-- Student Details-->
<?php if(isset($st)) {  ?>
    <div class="card card-flush h-xl-100 mt-5">
    <div class="card-body py-9">
       <div class="table-responsive" style="height: 100% !important;">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td class="text-center table-danger" style="color: black; font-weight: bold;" colspan=6>Student Details</td>
                    </tr>
                    <tr>
                        <td class="text-center table-warning" style="color: black; font-weight: bold;">Student No</td>
                        <td class="text-center table-primary" style="color: black;">
                            <?php echo $st['student_no']; ?>
                        </td>
                        <td class="text-center table-warning" style="color: black; font-weight: bold;">Name</td>
                        <td class="text-center table-primary" style="color: black;">
                            <?php echo $st['f_name'] . ' ' . $st['m_name'] . ' ' . $st['l_name']; ?>
                        </td>
                        <td class="text-center table-warning" style="color: black; font-weight: bold;">Roll No</td>
                        <td class="text-center table-primary" style="color: black;">
                            <?php echo $st['roll_no']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center table-warning" style="color: black; font-weight: bold;">Class</td>
                        <td class="text-center table-primary" style="color: black;">
                            <?php 
                                foreach ($classes as $c) {
                                    if($c['id'] == $st['student_session_class_id']) {
                                        echo $c['name'];
                                        break;
                                    }
                                }
                            ?>
                        </td>
                        <td class="text-center table-warning" style="color: black; font-weight: bold;">Section</td>
                        <td class="text-center table-primary" style="color: black;">
                            <?php echo 'A'; ?>
                        </td>
                        
                        <td class="text-center table-warning" style="color: black; font-weight: bold;">Student Type</td>
                        <td class="text-center table-primary" style="color: black;">
                            <?php echo $st['student_type_name']; ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php } ?>


<!-- Collection-->
<?php if(isset($student_fees_heads) && isset($installments)) { ?>
    
    <?php
    // Initialize fee head totals array
    $fee_head_totals = [];
    
    // Group installments by fee head
    foreach ($installments as $installment) {
        $fee_head_id = $installment['fees_head_id'];
        $amount = $installment['amount'];
        $paid = $installment['paid'];
        $due = $installment['due'];
        $month = $installment['month'];
    
        // Initialize structure for this fee head if not already set
        if (!isset($fee_head_totals[$fee_head_id])) {
            $fee_head_totals[$fee_head_id] = [
                'name' => '',
                'total_amount' => 0,
                'total_paid' => 0,
                'total_due' => 0,
                'installments' => []  // This will hold data per month
            ];
        }
    
        // Set fee head name
        if ($fee_head_totals[$fee_head_id]['name'] === '') {
            foreach ($student_fees_heads as $head_group) {
                if ($head_group['class'] == $installment['class_id']) {
                    foreach ($head_group['student_types'] as $student_type) {
                        if ($student_type['type'] == $installment['student_type_id']) {
                            foreach ($student_type['fees_heads'] as $fee_head) {
                                if ($fee_head['fees_type_id'] == $fee_head_id) {
                                    $fee_head_totals[$fee_head_id]['name'] = $fee_head['name'];
                                }
                            }
                        }
                    }
                }
            }
        }
    
        // Accumulate totals
        $fee_head_totals[$fee_head_id]['total_amount'] += $amount;
        $fee_head_totals[$fee_head_id]['total_paid'] += $paid;
        $fee_head_totals[$fee_head_id]['total_due'] += $due;
    
        // Store installment details per month
        $fee_head_totals[$fee_head_id]['installments'][$month] = [
            'amount' => $amount,
            'paid' => $paid,
            'due' => $due
        ];
    }
    
    // --- Concession + Previous Year Due data ---
    $total_concession = 0;
    $concession_map = [];
    if (!empty($concession)) {
        foreach ($concession as $c) {
            $installment_no = (int) str_replace('ins_', '', $c['installment_id']);
            $concession_map[$installment_no - 1] = $c['amount'];
            $total_concession += $c['amount'];
        }
    }

    $previous_due = $outstanding_fees['amount'] ?? 0;
    
    $fees_gross_totals = 0;
    $fees_gross_paid = 0;
    $fees_gross_due = 0;
    ?>
    
    <?php echo form_open(base_url("fees/fees-collection/store"), array("method" => "POST", "id" => "collectionform")) ?> 
        <!-- Payment Collection-->
        <div class="card card-flush h-xl-100 mt-5">
            <div class="card-body py-9">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-6">
                                <?php $receipt_no = substr(time(), -6); $today = date('Y-m-d'); ?>
                                <div>
                                    <label for="receipt_no" class="form-label">Receipt No.</label>
                                    <input type="text" id="receipt_no" name="receipt_no" class="form-control" value="<?= $receipt_no ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div>
                                    <label for="receipt_date" class="form-label">Receipt Date</label>
                                    <input type="date" id="receipt_date" name="receipt_date" class="form-control" value="<?= $today ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6 d-flex justify-content-end align-items-center">
                        <h2>Amount Payble: <span class="display_amount_payble">00.00</span> INR</h2>
                    </div>
                </div>
                <div style="overflow-x:auto; max-height:600px;">
                    <div class="table-responsive">
                        <table class="table table-bordered" style="min-width: 1000px;" id="fees-table">
                            <thead class="bg-light sticky-top" style="position: sticky; top: 0; z-index: 10 !important; border-bottom: 2px solid black;">
                                <tr>
                                    <th 
                                        class="sticky-header sticky-column-1 px-3" 
                                        style="z-index: 5 !important; background-color: #f1f1f1 !important;">Fee Head Name</th>
                                    
                                    <th 
                                        class="sticky-header sticky-column-2" 
                                        style="z-index: 5 !important; background-color: #f1f1f1 !important;">Total Payable Summery</th>
                                        
                                    <?php
                                    $months = [];
                                    $due_dates = [];
                                    foreach ($installments as $installment) {
                                        $months[] = $installment['month'];
                                        $due_dates[] = $installment['due_date'];
                                    }
                                    $months = array_unique($months);
                                    sort($months);
                                    foreach ($months as $month) {
                                        $monthName = date('F', mktime(0, 0, 0, $month + 1, 10)); ?>
                                        <th class="sticky-header" style="min-width:250px;">
                                            <div class="d-flex flex-column">
                                                <!-- Top text -->
                                                <div class="mb-2 text-center">
                                                    <span><?= $monthName ?></span>
                                                </div>
                                        
                                                <!-- Bottom row with two checkboxes -->
                                                <div class="d-flex justify-content-between align-items-center px-1">
                                                    <!-- New checkbox (Collection) -->
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input collect-check" id="collect_<?= $month ?>" data-month="<?= $month ?>">
                                                        <label class="form-check-label" for="collect_<?= $month ?>">Collect</label>
                                                    </div>
                                        
                                                    <!-- Existing checkbox (Part Payment) -->
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input toggle-check" id="check_<?= $month ?>" data-month="<?= $month ?>">
                                                        <label class="form-check-label" for="check_<?= $month ?>">Part Payment</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </th>
                                    <?php } ?>
                                    <th style="width:50px;"></th>
                                </tr>
                            </thead>
                            
                            <tbody>
                                <?php foreach ($fee_head_totals as $fee_head_id => $fee_data): ?>
                                    <tr class="main-fee-row">
                                        <!-- Fee Head Name -->
                                        <td class="text-nowrap sticky-column-1 px-3" style="background-color: #f1f1f1 !important;"><?= $fee_data['name'] ?></td>
                            
                                        <!-- Total Info -->
                                        <td class="text-nowrap sticky-column-2" style="background-color: #f1f1f1 !important;">
                                            <div class="d-flex justify-content-between px-1">
                                                <small class="text-dark" style="font-weight: bold;">
                                                    Tot.P: <?= number_format($fee_data['total_amount'], 2) ?> INR
                                                </small>
                                                <small class="text-success" style="font-weight: bold;">
                                                    Paid: <?= number_format($fee_data['total_paid'], 2) ?> INR
                                                </small>
                                                <small class="text-danger" style="font-weight: bold;">
                                                    Due: <?= number_format($fee_data['total_due'], 2) ?> INR
                                                </small>
                                            </div>
                                            
                                            <?php 
                                                $fees_gross_totals = $fees_gross_totals + $fee_data['total_amount'];
                                                $fees_gross_paid = $fees_gross_paid + $fee_data['total_paid'];
                                                $fees_gross_due = $fees_gross_due + $fee_data['total_due'];
                                            ?>
                                            <input 
                                                type="number" 
                                                class="form-control form-control-sm total-amount" 
                                                value="<?= $fee_data['total_amount'] ?>" 
                                                readonly>
                                        </td>
                            
                                        <!-- Monthly Installments -->
                                        <?php foreach ($months as $month): 
                                            $monthData = $fee_data['installments'][$month] ?? ['amount' => 0, 'paid' => 0, 'due' => 0];
                                            $amount = $monthData['amount'];
                                            $paid = $monthData['paid'];
                                            $due = $monthData['due'];
                                        ?>
                                            <td>
                                                <div class="d-flex justify-content-between px-1">
                                                    <small class="text-dark" style="font-weight: bold;">
                                                        P.A: <?= number_format($amount, 2) ?> INR
                                                    </small>
                                                    <small class="<?= $paid > 0 ? 'text-success' : 'text-danger' ?>" style="font-weight: bold;">
                                                        Paid: <?= number_format($paid, 2) ?> INR
                                                    </small>
                                                </div>
                                                <?php 
                                                    $due = $fee_data['installments'][$month]['due'] ?? 0;
                                                    $style = $due == 0 ? 'background-color: #28a745 !important; color: #f1f1f1 !important;' : '';
                                                ?>
                                                <input 
                                                    type="number" 
                                                    step="0.01"
                                                    class="form-control form-control-sm month_<?= $month ?> fee-input" 
                                                    name="<?= $fee_head_id ?>_<?= $month ?>" 
                                                    value="<?= $due ?>" 
                                                    data-amount="<?= $due ?>" 
                                                    readonly 
                                                    disabled
                                                    style="<?= $style ?>">

                                            </td>
                                        <?php endforeach; ?>
                            
                                        <!-- Empty Column (Optional Actions, e.g. Edit/Pay) -->
                                        <td></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>

    
                            <tbody id="other-fees-body"></tbody>
                    
                            <tfoot>
                                <!-- Add Other Fee Row -->
                                <tr>
                                    <td colspan="<?= 2 + count($months) ?>" class="px-3">
                                        <button type="button" id="add-other-fee" class="btn btn-sm btn-primary">+ Add Other Fee</button>
                                    </td>
                                </tr>
                                
                                
                                <?php if ($fine_counting != 'na') {
                                    $today = new DateTime();
                                    $late_fine_total = 0;
                                    $total_paid_fine = 0;
                                    $total_actual_fine = 0;
                                
                                    $month_fines = [];
                                    $paid_fines = [];
                                    $actual_fines = [];
                                
                                    // Step 1: Calculate paid fine per month
                                    foreach ($other_payments as $payment) {
                                        if ($payment['name'] === 'Late Fine') {
                                            $monthIndex = (int)$payment['month'];
                                            if (!isset($paid_fines[$monthIndex])) {
                                                $paid_fines[$monthIndex] = 0;
                                            }
                                            $paid_fines[$monthIndex] += floatval($payment['amount']);
                                        }
                                    }
                                
                                    // Step 2: Loop through each month and calculate fines
                                    foreach ($months as $i => $month) {
                                        $fine = 0;
                                        $due_date_str = $due_dates[$i] ?? null;
                                
                                        if (!empty($due_date_str)) {
                                            $due_date = new DateTime($due_date_str);
                                
                                            if ($today > $due_date) {
                                                if ($fine_counting == 'day') {
                                                    $interval = $due_date->diff($today);
                                                    $delay_days = $interval->days;
                                                    $fine = $delay_days * $fine_amount;
                                                } elseif ($fine_counting == 'month') {
                                                    $delay_months = (($today->format('Y') - $due_date->format('Y')) * 12)
                                                                    + ($today->format('m') - $due_date->format('m'));
                                                    if ($today->format('d') < $due_date->format('d')) {
                                                        $delay_months--;
                                                    }
                                                    $delay_months = max(0, $delay_months);
                                                    $fine = $delay_months * $fine_amount;
                                                }
                                            }
                                        }
                                
                                        $paid = $paid_fines[$i] ?? 0;
                                        $outstanding_fine = max(0, $fine - $paid);
                                
                                        // Track values
                                        $month_fines[$month] = $outstanding_fine;
                                        $late_fine_total += $outstanding_fine;
                                        $total_actual_fine += $fine;
                                        $total_paid_fine += $paid;
                                        $actual_fines[$i] = $fine;
                                    }
                                ?>
                                
                                <!-- Late Fine Row -->
                                <tr id="fine-row">
                                    <td class="text-nowrap sticky-column-1 px-3" style="background-color: #f1f1f1 !important;">Late Fine</td>
                                
                                    <!-- Tot.P / Paid / Due Summary -->
                                    <td class="text-nowrap sticky-column-2" style="background-color: #f1f1f1 !important;">
                                        <div class="d-flex justify-content-between px-1">
                                            <small class="text-dark" style="font-weight: bold;">
                                                Tot.P: <span id="fine-total-actual"><?= number_format($total_actual_fine, 2) ?></span> INR
                                            </small>
                                            <small class="text-success" style="font-weight: bold;">
                                                Paid: <span id="fine-total-paid"><?= number_format($total_paid_fine, 2) ?></span> INR
                                            </small>
                                            <small class="text-danger" style="font-weight: bold;">
                                                Due: <span id="fine-total-due"><?= number_format($late_fine_total, 2) ?></span> INR
                                            </small>
                                        </div>
                                        <input type="number" name="fine_amount_total" id="fine-total"
                                               class="form-control form-control-sm total-amount" 
                                               value="<?= $late_fine_total ?>" 
                                               readonly>
                                    </td>
                                
                                    <!-- Monthly Fine Inputs -->
                                    <?php foreach ($months as $i => $month): ?>
                                        <td>
                                            <div class="d-flex justify-content-between px-1">
                                                <small class="text-dark" style="font-weight: bold;">
                                                    P.A: <?= number_format($amount, 2) ?> INR
                                                </small>
                                                <small class="<?= $paid > 0 ? 'text-success' : 'text-danger' ?>" style="font-weight: bold;">
                                                    Paid: <?= number_format($paid, 2) ?> INR
                                                </small>
                                            </div>
                                            
                                            <input 
                                                type="number" 
                                                name="fine_amount_<?= $month ?>"
                                                class="form-control form-control-sm fine-month month_<?= $month ?> fee-input"
                                                value="<?= $month_fines[$month] ?? 0 ?>" 
                                                data-month="<?= $month ?>" 
                                                data-amount="<?= $month_fines[$month] ?? 0 ?>" 
                                                data-due-date="<?= $due_dates[$i] ?>"
                                                data-paid-fine="<?= $paid_fines[$i] ?? 0 ?>"
                                                data-actual-fine="<?= $actual_fines[$i] ?? 0 ?>"
                                                readonly 
                                                disabled>
                                        </td>
                                    <?php endforeach; ?>
                                    <td></td>
                                </tr>
                                <?php } ?>

                                
                                <?php
                                // Totals for Previous Year Due
                                $total_previous_due = $previous_due;
                                $previous_toal_paid = 0;
                                
                                // Step 1: Aggregate payments made
                                foreach ($other_payments as $op) {
                                    if ($op['name'] === 'Previous Year Due') {
                                        $previous_toal_paid = $previous_toal_paid + floatval($op['amount']);
                                    }
                                }

                                ?>
                                
                                <!-- Previous Year Due -->
                                <tr id="previous-due-row">
                                    <td class="text-nowrap sticky-column-1 px-3" style="background-color: #f1f1f1 !important;">Previous Year Due</td>
                                
                                    <!-- Total Summary -->
                                    <td class="text-nowrap sticky-column-2" style="background-color: #f1f1f1 !important;">
                                        <div class="d-flex justify-content-between px-1">
                                            <small class="text-dark" style="font-weight: bold;">
                                                Tot.P: <span id="previous-due-total-actual"><?= number_format($total_previous_due, 2) ?></span> INR
                                            </small>
                                            <small class="text-success" style="font-weight: bold;">
                                                Paid: <span id="previous-due-total-paid"><?= number_format($previous_toal_paid, 2) ?></span> INR
                                            </small>
                                            <small class="text-danger" style="font-weight: bold;">
                                                Due: <span id="previous-due-total-due"><?= number_format($total_previous_due - $previous_toal_paid, 2) ?></span> INR
                                            </small>
                                        </div>
                                        <input type="number" name="previous_year_due_total" id="previous-due-total" class="form-control total-amount form-control-sm" value="0" readonly>
                                    </td>
                                
                                    <!-- Monthly Inputs -->
                                    <?php foreach ($months as $month): ?>
                                        <td class="text-center">
                                            <input type="number"
                                                   step="0.01"
                                                   name="previous_year_due_<?= $month ?>"
                                                   class="form-control form-control-sm previous-due-month fee-input month_<?= $month ?>"
                                                   data-month="<?= $month ?>"
                                                   data-paid="0"
                                                   value="0"
                                                   disabled>
                                        </td>
                                    <?php endforeach; ?>
                                    <td></td>
                                </tr>
                                
                                <!-- Gross Amount Row -->
                                <tr id="gross-row">
                                    <td class="text-nowrap sticky-column-1 px-3" style="background-color: #f1f1f1 !important;">Gross Amount</td>
                                    <td class="text-nowrap sticky-column-2" style="background-color: #f1f1f1 !important;">
                                        <div class="d-flex justify-content-between px-1">
                                            <small class="text-dark" style="font-weight: bold;">
                                                Tot.P: <?php echo number_format($fees_gross_totals, 2); ?> INR
                                            </small>
                                            <small class="text-success" style="font-weight: bold;">
                                                Paid: <?php echo number_format($fees_gross_paid, 2); ?> INR
                                            </small>
                                            <small class="text-danger" style="font-weight: bold;">
                                                Due: <?php echo number_format($fees_gross_due, 2); ?> INR
                                            </small>
                                        </div>
                                        
                                        <input type="number" name="gross_amount_total" id="gross-total" class="form-control form-control-sm" readonly>
                                    </td>
                                    <?php foreach ($months as $month): ?>
                                        <td>
                                            <input type="number" name="gross_amount_<?php echo $month; ?>" class="form-control form-control-sm gross-month month_<?php echo $month; ?>" data-month="<?= $month ?>" readonly disabled="">
                                        </td>
                                    <?php endforeach; ?>
                                    <td></td>
                                </tr>
                                
                                <?php
                                // Step 1: Calculate concession paid per month
                                $concession_paid_map = [];
                                $total_concession_paid = 0;
                                
                                foreach ($other_payments as $payment) {
                                    if ($payment['name'] === 'Concession') {
                                        $month = (int)$payment['month'];
                                        $paid_amount = (float)$payment['amount'];
                                        
                                        if (!isset($concession_paid_map[$month])) {
                                            $concession_paid_map[$month] = 0;
                                        }
                                        $concession_paid_map[$month] += $paid_amount;
                                        $total_concession_paid = $total_concession_paid + $paid_amount;
                                    }
                                }
                                
                                
                                
                                // Step 2: Calculate totals and prepare concession map for display
                                // foreach ($months as $month) {
                                //     $pa = $amount; // Planned amount for the month
                                //     $paid = $concession_paid_map[$month] ?? 0;
                                
                                //     $total_concession_planned += $pa;
                                //     $total_concession_paid += $paid;
                                
                                //     $concession_map[$month] = $paid;
                                // }
                                
                                // $total_concession_due = $total_concession - $total_concession_paid;
                                ?>
                                
                                <!-- Concession Row -->
                                <tr id="concession-row">
                                    <td class="text-nowrap sticky-column-1 px-3" style="background-color: #f1f1f1 !important;">Concession</td>
                                    
                                    <!-- Totals Column -->
                                    <td class="text-nowrap sticky-column-2" style="background-color: #f1f1f1 !important;">
                                        <input type="number" name="concession_amount_total" id="concession-total" class="form-control form-control-sm" value="" readonly>
                                    </td>
                                
                                    <!-- Monthly columns -->
                                    <?php foreach ($months as $month): 
                                        $c_amount = $concession_map[$month] ?? 0;
                                        $c_paid = $concession_paid_map[$month] ?? 0;
                                    ?>
                                        <td>
                                            <input 
                                                type="number" 
                                                name="concession_amount_<?= $month; ?>" 
                                                class="form-control form-control-sm concession-month month_<?= $month; ?>" 
                                                value="<?= $c_amount - $c_paid ?>" 
                                                data-month="<?= $month ?>" 
                                                readonly 
                                                disabled>
                                        </td>
                                    <?php endforeach; ?>
                                
                                    <td></td> <!-- Optional empty column -->
                                </tr>

                                <!-- Net Payable -->
                                <tr id="net-row">
                                    <td class="text-nowrap sticky-column-1 px-3" style="background-color: #f1f1f1 !important;">Net Payable Amount</td>
                                    <td class="text-nowrap sticky-column-2" style="background-color: #f1f1f1 !important;">
                                        <?php
                                            $net_payable_total = $fees_gross_totals - $total_concession;
                                            $net_payable_paid = $fees_gross_paid - $total_concession_paid;
                                            $net_payable_due = $net_payable_total - $net_payable_paid;
                                        ?>
                                        
                                        <div class="d-flex justify-content-between px-1">
                                            <small class="text-dark" style="font-weight: bold;">
                                                Tot.P: <?= number_format($net_payable_total, 2) ?> INR
                                            </small>
                                            <small class="text-success" style="font-weight: bold;">
                                                Paid: <?= number_format($net_payable_paid, 2) ?> INR
                                            </small>
                                            <small class="text-danger" style="font-weight: bold;">
                                                Due: <?= number_format($net_payable_due, 2) ?> INR
                                            </small>
                                        </div>
                                        
                                        <input type="number" name="net_amount_total" id="net-total" class="form-control form-control-sm" readonly></td>
                                    <?php foreach ($months as $month): ?>
                                        <td>
                                            <div class="d-flex justify-content-between px-1">
                                                <small class="text-dark" style="font-weight: bold;">.</small>
                                                <small class="text-danger" style="font-weight: bold;">.</small>
                                            </div>
                                            <input type="number" name="net_amount_<?php echo $month; ?>" class="form-control form-control-sm net-month month_<?php echo $month; ?>" data-month="<?= $month ?>" readonly disabled="">
                                        </td>
                                    <?php endforeach; ?>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    
        
        <input type="text" class="d-none" name="student_id" value="<?php echo $selected_id; ?>" />
        <input type="text" class="d-none" name="summary" value="" />
    
            
        <!-- Payment Method Entry-->
        <div class="card card-flush h-xl-100 mt-5">
            <div class="card-body py-9">
                <div class="row">
                        <div class="col-md-6">
                            <!-- Mode of Payment -->
                            <div class="mb-3">
                                <label for="payment_mode" class="form-label">Mode of Payment</label>
                                <select id="payment_mode" name="payment_mode" class="form-select">
                                    <option value="cash">Cash</option>
                                    <option value="credit_card">Credit Card</option>
                                    <option value="debit_card">Debit Card</option>
                                    <option value="qr_code">QR Code Scan</option>
                                    <option value="cheque">Cheque / Pay Order</option>
                                    <option value="neft">NEFT / RTGS</option>
                                    <option value="bank_deposit">Bank Deposit</option>
                                </select>
                            </div>
                
                            <!-- Remarks -->
                            <div class="mb-3">
                                <label for="remarks" class="form-label">Remarks</label>
                                <textarea id="remarks" name="remarks" class="form-control" rows="2"></textarea>
                            </div>
                            
                            <div class="mb-3">
                                <h2>Amount Payble: <span class="display_amount_payble">00.00</span> INR</h2>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div id="extra-fields"></div>
                        </div>
                    </div>
        
                <input type="text" class="d-none" name="print" value="no" />
                <button type="button" id="previewSubmit" class="btn btn-primary">Confirm</button>
            </div>
        </div>
    <?php echo form_close(); ?>
<?php } ?>


<!-- Confirmation Modal -->
<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="confirmModalLabel">Confirm Payment Details</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
      
        <div class="modal-body">
            <table class="table table-bordered">
              <thead>
                  <tr class="table-dark text-light">
                    <th class="px-2">Fee Head</th>
                    <th>Collecting Amount</th>
                  </tr>
                </thead>
                <tbody id="modalTableBody">
                    <!-- Dynamic content will be inserted here -->
                </tbody>
            </table>
        </div>
        
        <div class="modal-footer d-flex justify-content-between">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <div>
            <button type="button" id="finalSubmitBtn1" class="btn btn-primary">Save</button>
            <button type="button" id="finalSubmitBtn2" class="btn btn-success">Save & Print</button>
          </div>
        </div>
    </div>
  </div>
</div>


<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


<!--Recalculate Totals (Second Columns)-->
<script>
    let otherFeeCounter = 0;
    const months = <?= json_encode(array_values($months)) ?>;

    function recalculateTotals() {
        let grossTotal = 0;
        let monthTotals = {};
    
        // Initialize monthly totals
        months.forEach(month => { monthTotals[month] = 0; });
    
        // Loop through each row in the table
        $('#fees-table tr').each(function () {
            let rowTotal = 0;
    
            $(this).find('.fee-input').each(function () {
                // Skip if input is disabled
                if ($(this).is(':disabled')) {
                    return;
                }
    
                const value = parseFloat($(this).val()) || 0;
    
                // Determine the month
                const month = $(this).data('month') || this.className.match(/month_(\w+)/)[1];
    
                // Add to totals
                monthTotals[month] += value;
                rowTotal += value;
            });
    
            // Set row total (clamped to 0 if negative)
            $(this).find('.total-amount').val(Math.max(rowTotal, 0));
    
            // Add to gross total
            // grossTotal += rowTotal;
        });
    
        // Set gross total (clamped)
        $('#gross-total').val(Math.max(grossTotal, 0));
    
        // Set each month's total in footer (clamped)
        $('.gross-month').each(function () {
            const month = $(this).data('month');
            $(this).val(Math.max(monthTotals[month], 0));
        });
    
        recalcAll();
    }
</script>

<!--Calculate for Gross and Net Payble-->
<script>
    function recalcAll() {
        let grossTotal = 0,
            concessionTotal = 0,
            previousDueTotal = parseFloat($("#previous-due-total").val()) || 0;
    
        // Initialize monthly trackers
        let grossMonth = {}, concessionMonth = {}, fineMonth = {}, prevMonth = {}, netMonth = {};
    
        // Setup per-month values
        months.forEach(m => {
            grossMonth[m] = 0;
            concessionMonth[m] = parseFloat($(".concession-month[data-month='" + m + "']").val()) || 0;
            prevMonth[m] = parseFloat($(".previous-due-month[data-month='" + m + "']").val()) || 0;
            fineMonth[m] = parseFloat($(".fine-month[data-month='" + m + "']").val()) || 0;
        });
    
        // Loop through fee inputs
        $("#fees-table tbody tr").each(function () {
            $(this).find('.fee-input').each(function () {
                if ($(this).is(':disabled')) return;
    
                const val = parseFloat($(this).val()) || 0;
                
                // Get the month from data attribute or fallback to class
                let month = $(this).data('month');
                if (!month) {
                    const match = this.className.match(/month_(\d+)/);
                    if (match) {
                        month = match[1];
                    } else {
                        console.warn("Month not found for input", this);
                        return;
                    }
                }
    
                // Add only the fee input to total — prev and fine handled separately
                grossMonth[month] = (grossMonth[month] || 0) + val;
                // grossTotal += val;
            });
        });
    
        // Add fine and previous due to grossMonth values
        months.forEach(m => {
            grossMonth[m] += (prevMonth[m] || 0) + (fineMonth[m] || 0);
            // grossTotal += (fineMonth[m] || 0); // don't add prevMonth again here
        });
        
        $('input.gross-month').each(function () {
            if (!$(this).is(':disabled')) {
                const month = $(this).data('month');
                grossTotal += grossMonth[month] || 0;
            }
        });
        
        // Update Gross row
        $("#gross-total").val(Math.max(grossTotal, 0));
        $(".gross-month").each(function () {
            let m = $(this).data("month");
            $(this).val(Math.max(grossMonth[m] || 0, 0));
        });
    
        // Calculate Concession Total
        concessionTotal = 0;
        $(".concession-month").each(function () {
            if ($(this).is(':disabled')) return;
            concessionTotal += parseFloat($(this).val()) || 0;
        });
        $("#concession-total").val(Math.max(concessionTotal, 0));
    
        // Net = Gross - Concession + Previous Due (overall)
        let netTotal = grossTotal - concessionTotal;
        netTotal = Math.max(netTotal, 0); // Clamp to 0
    
        // Calculate Net per month
        months.forEach(m => {
            let net = grossMonth[m] - concessionMonth[m];
            netMonth[m] = Math.max(net, 0); // Clamp negative to 0
        });
    
        // Update totals in DOM
        $("#net-total").val(netTotal);
        $(".display_amount_payble").text(netTotal);
    
        $(".net-month").each(function () {
            let m = $(this).data("month");
            $(this).val(Math.max(netMonth[m] || 0, 0));
        });
    }
    
    // Trigger recalculation on relevant inputs
    $(document).on("input", ".fee-input, .concession-month, .previous-due-month, .fine-month", recalcAll);
    
    // Run once at page load
    $(document).ready(function () {
        recalcAll(); 
                
        let previous_year_total_payble = parseFloat($('#previous-due-total-actual').val())
        let previous_year_total_paid = 0
        let previous_year_total_due = 0

        let gross_total_payble = 0
        let gross_total_paid = 0
        let gross_year_total_due = 0

    });
</script>

<!--Check Installment Status-->
<script>
    // Function to check installment status and disable checkbox if all inputs are zero
    function checkInstallmentStatus() {
        // Loop through each 'Collect' checkbox
        $('.collect-check').each(function () {
            var month = $(this).data('month');  // Get the month associated with the checkbox

            // Find all input fields for that month with class 'month_[month]'
            var targetInputs = $('input.month_' + month);

            var allZero = true;  // Flag to check if all values are zero
 
            // Check if all input fields have a value of 0
            targetInputs.each(function () {
                if (parseFloat($(this).val()) !== 0) {
                    allZero = false;  // If any field isn't zero, set flag to false
                    return false;  // Exit the loop early if one value isn't zero
                }
            });

            // Disable the checkbox if all inputs are zero
            var installmentCheckbox = $('#collect_' + month);
            if (allZero) {
                console.log("Disableing: " + month)
                installmentCheckbox.prop('disabled', true);
                installmentCheckbox.prop('checked', false);
            } else {
                installmentCheckbox.prop('disabled', false);
            }
        });
    }
</script>

<script>
    $(document).ready(function () {
        // When any 'Collect' checkbox is toggled
        $('.collect-check').on('change', function () {
            var month = $(this).data('month');
            var partPaymentCheckbox = $('#check_' + month);

            if ($(this).is(':checked')) {
                partPaymentCheckbox.prop('disabled', false);
            } else {
                partPaymentCheckbox.prop('checked', false).prop('disabled', true);
            }
        });

        // Initially disable part payment checkboxes if collect is not checked
        $('.collect-check').each(function () {
            var month = $(this).data('month');
            var partPaymentCheckbox = $('#check_' + month);

            if (!$(this).is(':checked')) {
                partPaymentCheckbox.prop('disabled', true);
            }
        });
        
        // Event listener for checkbox clicks
        $('.collect-check').on('change', function() {
            // Get the data-month value from the clicked checkbox
            var month = $(this).data('month');
    
            // Find all input fields with the corresponding month_[data-month] class
            var targetInputs = $('input.month_' + month);
    
            // Toggle the disabled attribute on those inputs
            targetInputs.each(function() {
                if ($(this).prop('disabled')) {
                    // If already disabled, remove the disabled attribute
                    $(this).prop('disabled', false);
                } else {
                    // If not disabled, add the disabled attribute
                    $(this).prop('disabled', true);
                }
            });
            
            recalculateTotals()
        });
        
        checkInstallmentStatus();
    });
</script>

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
    $(document).ready(function () {
        // Toggle read-only fields for a given installment column
        $('.toggle-check').on('change', function () {
            const month = $(this).data('month');
            const isChecked = $(this).is(':checked');
            $(`.month_${month}`).prop('readonly', !isChecked);
        });
    
        // Watch all fee inputs for changes to recalculate totals
        $(document).on('input', '.fee-input', function () {
            recalculateTotals();
        });
    

        $('#add-other-fee').click(function () {
            otherFeeCounter++;
            let row = `<tr class="other-fee-row" data-row="${otherFeeCounter}">`;
        
            row += `<td class="text-nowrap sticky-column-1 px-3" style="background-color: #f1f1f1 !important;"><input type="number" name="other[${otherFeeCounter}][name]" class="form-control form-control-sm" placeholder="Other Fee Name" required></td>`;
            row += `<td class="text-nowrap sticky-column-2" style="background-color: #f1f1f1 !important;"><input type="number" name="other[${otherFeeCounter}][total]" class="form-control form-control-sm total-amount" readonly></td>`;
        
            months.forEach(function (month) {
                // Check if the checkbox for the current month is checked
                var isChecked = $('#collect_' + month).prop('checked');
                
                // Add the row's input element
                row += `<td>
                            <input type="number" step="0.01" min="0" value="0"
                                name="other[${otherFeeCounter}][month_${month}]"
                                class="form-control form-control-sm other-month fee-input month_${month}"
                                data-month="${month}" 
                                ${isChecked ? '' : 'disabled'}
                                readonly>
                        </td>`;
            });
        
            row += `<td><button type="button" class="btn btn-sm btn-danger remove-row">&minus;</button></td>`;
            row += `</tr>`;
            
            $('#other-fees-body').append(row);
        });

    
        // Remove Other Fee row
        $(document).on('click', '.remove-row', function () {
            $(this).closest('tr').remove();
            recalculateTotals();
        });
    
        // Watch other-month inputs for changes to recalc total
        $(document).on('input', '.other-month', function () {
            const row = $(this).closest('tr');
            let total = 0;
            row.find('.other-month').each(function () {
                total += parseFloat($(this).val()) || 0;
            });
            row.find('.total-amount').val(total);
            recalculateTotals();
        });
    
        // Initial gross total
        recalculateTotals();
    });
</script>

<script>
    $(document).ready(function() {
        $("#payment_mode").on("change", function() {
            let mode = $(this).val();
            let extra = "";
    
            if(mode === "credit_card" || mode === "debit_card") {
                extra = `
                    <div class="mb-3">
                        <label for="bank_name" class="form-label">Bank Name *</label>
                        <input type="text" id="bank_name" name="bank_name" class="form-control" required>
                    </div>`;
            }
    
            if(mode === "cheque") {
                extra = `
                    <div class="mb-3">
                        <label for="cheque_no" class="form-label">Cheque / Pay Order No. *</label>
                        <input type="text" id="cheque_no" name="cheque_no" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="cheque_date" class="form-label">Cheque / Pay Order Date *</label>
                        <input type="date" id="cheque_date" name="cheque_date" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="bank_name" class="form-label">Bank Name *</label>
                        <input type="text" id="bank_name" name="bank_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="branch_name" class="form-label">Branch Name *</label>
                        <input type="text" id="branch_name" name="branch_name" class="form-control" required>
                    </div>`;
            }
    
            if(mode === "neft") {
                extra = `
                    <div class="mb-3">
                        <label for="bank_name" class="form-label">Bank Name *</label>
                        <input type="text" id="bank_name" name="bank_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="branch_name" class="form-label">Branch Name *</label>
                        <input type="text" id="branch_name" name="branch_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="transfer_date" class="form-label">Transaction Date *</label>
                        <input type="date" id="transfer_date" name="transfer_date" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="reference_no" class="form-label">Transaction Reference No. *</label>
                        <input type="text" id="reference_no" name="reference_no" class="form-control" required>
                    </div>`;
            }
    
            if(mode === "bank_deposit") {
                extra = `
                    <div class="mb-3">
                        <label for="bank_name" class="form-label">Bank Name *</label>
                        <input type="text" id="bank_name" name="bank_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="deposit_date" class="form-label">Deposit Date *</label>
                        <input type="date" id="deposit_date" name="deposit_date" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="deposit_slip_no" class="form-label">Deposit Slip No. *</label>
                        <input type="text" id="deposit_slip_no" name="deposit_slip_no" class="form-control" required>
                    </div>`;
            }
    
            $("#extra-fields").html(extra);
        });
    });
</script>

<script>
    $(document).ready(function () {
        $('#previewSubmit').on('click', function () {
            const modalBody = $('#modalTableBody');
            modalBody.empty();

            const summaryData = {}; // For storing feeLabel: inputVal pairs

            // Collect rows from tbody and tfoot
            $('#fees-table').find('tbody tr, tfoot tr').each(function () {
                const $row = $(this);
                const $cells = $row.find('td');

                if ($cells.length < 2) return;

                // Fee Head Name — either text or input value
                let feeLabel = $cells.eq(0).text().trim();
                if (!feeLabel) {
                    const input = $cells.eq(0).find('input');
                    if (input.length) {
                        feeLabel = input.val()?.trim() || 'Unnamed Fee';
                    }
                }

                // Second cell — collect values
                const $secondCell = $cells.eq(1);
                const inputVal = $secondCell.find('input').val()?.trim() || '-';

                const paText = $secondCell.find('small.text-dark').text()?.replace('P.A:', '').trim() || '-';
                const paidText = $secondCell.find('small.text-danger').text()?.replace('Paid:', '').trim() || '-';

                if (feeLabel || inputVal) {
                    if (feeLabel || inputVal) {
                        if (feeLabel != "Gross Amount" && feeLabel != "Net Payable Amount") {
                            $('#modalTableBody').append(`
                                <tr>
                                    <td>${feeLabel}</td>
                                    <td>${inputVal} INR</td>
                                </tr>
                            `);
                            // Store in summary JSON if inputVal is meaningful (not just "-")
                            if (inputVal !== '-') {
                                summaryData[feeLabel] = inputVal;
                            }
                        }
                    }
                }
            });

            // Store JSON string in the input with name="summary"
            $('input[name="summary"]').val(JSON.stringify(summaryData));

            // Show the modal
            const modal = new bootstrap.Modal(document.getElementById('confirmModal'));
            modal.show();
        });

        // Final submit
        $('#finalSubmitBtn1, #finalSubmitBtn2').on('click', function () {
            
            // Check if the clicked button is the one with ID #finalSubmitBtn2
            if ($(this).attr('id') === 'finalSubmitBtn2') {
                // If it is, find the hidden input with the name "print" and change its value to "yes"
                $('input[name="print"]').val('yes');
            } else {
                // If any other button (like #finalSubmitBtn1) is clicked, set the value to "no"
                $('input[name="print"]').val('no');
            }
            
            $('#fees-table thead .collect-check').each(function () {
                var isChecked = $(this).is(':checked');

                // Get the index of the <th> this checkbox is in
                var th = $(this).closest('th');
                var colIndex = th.index();

                if (!isChecked) {
                    // Go through each row in the table body and tfoot
                    $('#fees-table tbody tr, #fees-table tfoot tr').each(function () {
                        var td = $(this).find('td').eq(colIndex);
                        td.find('input').removeAttr('name');
                    });
                }
            });
            
            $('#collectionform').submit();
        });
    });

    $(document).ready(function () {
        $('.fee-input').on('input', function () {
            const maxAmount = parseFloat($(this).data('amount'));
            const currentValue = parseFloat($(this).val());
    
            if (!isNaN(maxAmount) && currentValue > maxAmount) {
                $(this).val(maxAmount);
            }
        });
    });
</script>

<!--Recalculate Fine Amount-->
<script>
    $(document).ready(function () {
        var fineCounting = '<?= $fine_counting ?>'; // 'day' or 'month'
        var fineAmount = <?= json_encode($fine_amount) ?>;
    
        $('#receipt_date').on('change', function () {
            var receiptDateVal = $(this).val();
            if (!receiptDateVal) return;
    
            var receiptDate = new Date(receiptDateVal);
            var totalFine = 0;
            var totalActualFine = 0;
            var totalPaidFine = 0;
    
            $('.fine-month').each(function () {
                var $input = $(this);
                var dueDateStr = $input.data('due-date');
                var paidFine = parseFloat($input.data('paid-fine')) || 0;
                var fine = 0;
    
                if (dueDateStr) {
                    var dueDate = new Date(dueDateStr);
    
                    if (receiptDate > dueDate) {
                        if (fineCounting === 'day') {
                            var diffTime = receiptDate - dueDate;
                            var delayDays = Math.floor(diffTime / (1000 * 60 * 60 * 24));
                            fine = delayDays * fineAmount;
                        } else if (fineCounting === 'month') {
                            var yearDiff = receiptDate.getFullYear() - dueDate.getFullYear();
                            var monthDiff = receiptDate.getMonth() - dueDate.getMonth();
                            var delayMonths = (yearDiff * 12) + monthDiff;
    
                            if (receiptDate.getDate() < dueDate.getDate()) {
                                delayMonths--;
                            }
    
                            delayMonths = Math.max(0, delayMonths);
                            fine = delayMonths * fineAmount;
                        }
                    }
                }
    
                var outstandingFine = Math.max(0, fine - paidFine);
    
                // Update input field
                $input.val(outstandingFine);
                $input.attr('data-amount', outstandingFine);
                $input.attr('data-actual-fine', fine);
    
                // Totals
                totalFine += outstandingFine;
                totalActualFine += fine;
                totalPaidFine += paidFine;
            });
    
            // Update summary values
            $('#fine-total').val(totalFine);
            $('#fine-total-actual').text(totalActualFine);
            $('#fine-total-paid').text(totalPaidFine);
            $('#fine-total-due').text(totalFine);
        });
    });
</script>

<!--Recalculate Previous Year Due-->
<script>
    $(document).ready(function () {
        let totalPreviousDue = parseFloat($('#previous-due-total-due').text().replace(/,/g, '')) || 0;

        $('.previous-due-month').on('input', function () {
            let totalInputted = 0;
    
            // Calculate sum of user inputs
            $('.previous-due-month').each(function () {
                let val = parseFloat($(this).val()) || 0;
                totalInputted += val;
            });
    
            // If user over-inputs, revert the current change
            if (totalInputted > totalPreviousDue) {
                let exceededBy = totalInputted - totalPreviousDue;
                let currentVal = parseFloat($(this).val()) || 0;
                let newVal = (currentVal - exceededBy).toFixed(2);
                $(this).val(newVal > 0 ? newVal : 0);
                totalInputted -= exceededBy;
            }

        });
    
        // Optional: trigger once on page load
        $('.previous-due-month').trigger('input');
    });
</script>

<?php
$session = $this->session->academy_session['current_session'] ?? null;
?>

<?php
    $session = $this->session->academy_session['current_session'] ?? [];
?>

<script>
    window.academySession = {
        start: "<?= $session['start'] ?? '' ?>",
        end: "<?= $session['end'] ?? '' ?>"
    };
</script>

<script>
$(document).ready(function () {

    if (!academySession.start || !academySession.end) {
        console.error('Session data missing');
        return;
    }

    const table = $('#fees-table');

    // -------- Build session month list --------
    let startDate = new Date(academySession.start);
    let endDate   = new Date(academySession.end);

    let sessionMonths = [];
    let cursor = new Date(startDate);
    cursor.setDate(1);

    while (cursor <= endDate) {
        sessionMonths.push(cursor.getMonth());
        cursor.setMonth(cursor.getMonth() + 1);
    }

    // -------- Detect month column indexes --------
    let headerRow = table.find('thead tr');
    let headerCells = headerRow.children('th');

    let monthColIndexMap = {};

    headerCells.each(function (index) {
        let monthText = $(this).find('span').first().text().trim();
        if (monthText) {
            let monthIndex = new Date(monthText + ' 1, 2000').getMonth();
            monthColIndexMap[monthIndex] = index;
        }
    });

    // Fixed columns
    const fixedStartCols = [0, 1];                    // Fee Head + Summary
    const fixedEndCols   = [headerCells.length - 1];  // Action column

    // -------- Final column order --------
    let finalOrder = [...fixedStartCols];

    sessionMonths.forEach(m => {
        if (monthColIndexMap[m] !== undefined) {
            finalOrder.push(monthColIndexMap[m]);
        }
    });

    finalOrder.push(...fixedEndCols);

    // -------- Clone entire columns --------
    let clonedColumns = {};

    finalOrder.forEach(colIndex => {
        clonedColumns[colIndex] = [];
        table.find('tr').each(function () {
            let cell = $(this).children('th,td').eq(colIndex);
            clonedColumns[colIndex].push(cell.clone(true, true));
        });
    });

    // -------- Remove original columns --------
    table.find('tr').each(function () {
        let cells = $(this).children('th,td');
        cells.remove();
    });

    // -------- Rebuild table with cloned columns --------
    table.find('tr').each(function (rowIndex) {
        let row = $(this);
        finalOrder.forEach(colIndex => {
            row.append(clonedColumns[colIndex][rowIndex]);
        });
    });

    console.log('Columns cloned & reordered:', finalOrder);
});
</script>




<?php $this->load->view("inc/app_footer.php"); ?>
