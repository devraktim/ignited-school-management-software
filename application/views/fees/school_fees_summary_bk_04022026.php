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
            left: 180px; /* 50 + 150 */
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
        <h1>Monthly Fees Summary</h1>
    </div>

    <?php echo form_open(base_url("fees/school-fees/index"), array("method" => "GET")) ?> 
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
    
    
    <?php if(isset($records)) { ?>
        <div class="card card-flush h-xl-100 mb-4" id="students_card">
            <div class="card-body py-9">
        
                <?php if(count($records) > 0) { $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']; ?>
                    <div class="table-responsive">
                        <table class="table table-bordered px-2">
                          <thead>
                            <tr class="table-dark text-light">
                              <th class="sticky-header sticky-column-1" style="z-index:5!important;"></th>
                              <th class="text-nowrap sticky-header sticky-column-2" style="z-index:5!important;">Name</th>
                              <th class="text-nowrap sticky-header sticky-column-3" style="z-index:5!important;">Student No.</th>
                              <?php for ($i = 1; $i <= 12; $i++): ?>
                                <th class="text-nowrap"><?php echo $months[$i - 1]; ?></th>
                              <?php endfor; ?>
                              <th class="text-nowrap">Gross Amt</th>
                              <th class="text-nowrap">P.Y. Due</th>
                              <th class="text-nowrap">Concession Amt.</th>
                              <th class="text-nowrap">Payable</th>
                            </tr>
                          </thead>
                        
                          <tbody>
                            <?php
                              // initialize accumulators
                              $sumMonthly = array_fill(0, 12, 0.0);
                              $sumGross = 0.0;
                              $sumPrevDue = 0.0;
                              $sumConcession = 0.0;
                              $sumPayable = 0.0;
                        
                              $sl_no = 0;
                              foreach ($records as $r):
                                $sl_no++;
                                $monthly_total = 0.0;
                                $outstanding = floatval($r['outstanding_amount'] ?? 0);
                                $concession = floatval($r['total_concession_fees'] ?? 0);
                        
                                for ($i = 0; $i < 12; $i++) {
                                  $m = floatval($r['monthly_payable'][$i]['payable'] ?? 0);
                                  $monthly_total += $m;
                                  $sumMonthly[$i] += $m;
                                }
                        
                                $gross = floatval($r['total_monthly_fees'] ?? 0);
                                $net = ($outstanding + $monthly_total) - $concession;
                        
                                $sumGross += $gross;
                                $sumPrevDue += $outstanding;
                                $sumConcession += $concession;
                                $sumPayable += $net;
                            ?>
                              <tr>
                                <td class="table-warning text-dark p-2 sticky-column-1"><?php echo $sl_no; ?></td>
                                <td class="text-nowrap sticky-column-2" style="background-color:#fbffd1!important">
                                  <?php echo htmlspecialchars($r['student_name']); ?>
                                </td>
                                <td class="text-nowrap sticky-column-3" style="background-color:#fbffd1!important">
                                  <?php echo htmlspecialchars($r['student_no']); ?>
                                </td>
                                <?php for ($i = 0; $i < 12; $i++): ?>
                                  <td><?php echo number_format($r['monthly_payable'][$i]['payable'] ?? 0, 2); ?></td>
                                <?php endfor; ?>
                        
                                <td><?php echo number_format($gross, 2); ?></td>
                                <td><?php echo number_format($outstanding, 2); ?></td>
                                <td><?php echo number_format($concession, 2); ?></td>
                                <td><?php echo number_format($net, 2); ?></td>
                              </tr>
                            <?php endforeach; ?>
                          </tbody>
                        
                          <tfoot>
                            <tr class="table-dark text-light">
                              <td colspan="3" class="text-start px-2">Total Payble Amount</td>
                              <?php foreach ($sumMonthly as $m): ?>
                                <td></td>
                              <?php endforeach; ?>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td><?php echo number_format($sumPayable, 2); ?></td>
                            </tr>
                          </tfoot>
                        </table>
                    </div>
                <?php } else { ?>
                    <div class="row justify-content-center">
                        <h3 class="text-center">No Data Found</h3>
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