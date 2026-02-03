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
            left: 265px; /* 50 + 150 */
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
            <h1>Concession</h1>
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
            <?php echo form_open(base_url("fees/fees-concession/index"), array("method" => "GET")) ?> 
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
                <div class="row">
                    <div class="col-md-12">
                        <?php if(count($students) > 0) { ?>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr class="table-dark text-light">
                                            <th class="sticky-header sticky-column-1" style="z-index: 5 !important;"></th>
                                            <th class="text-nowrap sticky-header sticky-column-2" style="z-index: 5 !important;">Name</th>
                                            <th class="text-nowrap sticky-header sticky-column-3" style="z-index: 5 !important;">Student ID</th>
                                    
                                            <?php
                                            if ($payment_plan_type_display == "month") {
                                                foreach (["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"] as $month) {
                                                    echo "<th class='text-nowrap sticky-header'>$month</th>";
                                                }
                                            } else {
                                                for ($i = 1; $i <= 12; $i++) {
                                                    echo "<th class='text-nowrap sticky-header'>Installment $i</th>";
                                                }
                                            }
                                            ?>
                                    
                                            <th class="text-nowrap sticky-header">Total</th>
                                            <th class="sticky-header">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $sl_no = 0; foreach($students as $student) { $sl_no++; ?>
                                            <tr>
                                                <td class="table-warning text-dark p-2 sticky-column-1"><?php echo $sl_no ?></td>
                                                <td class="text-nowrap sticky-column-2" style="background-color: #fbffd1 !important;">
                                                    <?php echo $student['f_name'] . " " . $student['m_name'] . " " . $student['l_name']; ?>
                                                </td>
                                                <td class="text-nowrap sticky-column-3" style="background-color: #fbffd1 !important;">
                                                    <?php echo $student['student_no']; ?>
                                                </td>
                                    
                                                <?php
                                                $concessions = $student['concession'];
                                                $totalAmount = 0;
                                    
                                                for ($i = 0; $i < 12; $i++) {
                                                    if (isset($concessions[$i])) {
                                                        $amount = floatval($concessions[$i]['amount']);
                                                        $totalAmount += $amount;
                                                        ?>
                                                        <td data-name="<?php echo $concessions[$i]['installment_id'] ?>" 
                                                            data-amount="<?php echo $amount ?>" 
                                                            data-student-id="<?php echo $student['id'] ?>">
                                                            <?php echo number_format($amount, 2); ?>
                                                        </td>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <td class="text-muted">NA</td>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                    
                                                <td><strong><?php echo number_format($totalAmount, 2); ?></strong></td> 
                                    
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-primary edit-installment" 
                                                            data-student-id="<?php echo $student['id'] ?>" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#editInstallmentModal">
                                                        <?php echo (count($concessions) > 0) ? 'Edit' : 'Create'; ?>
                                                    </button>
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
        </div>
    <?php } ?>

    <!-- Modal for Editing Installment -->
    <div class="modal fade" id="editInstallmentModal" tabindex="-1" aria-labelledby="editInstallmentModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="editInstallmentModalLabel"></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="form-group mb-3">
              <label for="total-concession-fees">Total Concession</label>
              <input type="number" class="form-control" id="total-concession-fees" placeholder="Enter total concession fees" />
            </div>
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th>Month</th>
                    <th>Amount</th>
                  </tr>
                </thead>
                <tbody id="installment-details-body">
                  <!-- Dynamic content will be added here -->
                </tbody>
              </table>
            </div>
            <input type="text" class="d-none" name="student_id" id="modal_student_id" />
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="close-btn">Close</button>
            <button type="button" class="btn btn-success" id="save-installment-btn" disabled>Save</button>
          </div>
        </div>
      </div>
    </div>
    
    <script>
        document.addEventListener("DOMContentLoaded", function () {
          const modal = document.getElementById("editInstallmentModal");
          const modalTitle = document.getElementById("editInstallmentModalLabel");
          const totalLabel = document.querySelector('label[for="total-concession-fees"]');
          const installmentHeader = document.querySelector('#installment-details-body').closest('table').querySelector('thead tr th:first-child');
        
          // Attach click event to all action buttons
          document.querySelectorAll(".edit-installment").forEach(function (button) {
            button.addEventListener("click", function () {
              const isCreate = this.textContent.trim().toLowerCase() === "create";
        
              // Set modal title
              modalTitle.textContent = isCreate ? "Create Concession" : "Edit Concession";

            });
          });
        });
        </script>

    <script>
        const totalConcessionFeesInput = $('#total-concession-fees');
        const saveButton = $('#save-installment-btn');
        
        $(document).on('change', '.concession-fee', function() {
            let totalConcession = parseFloat(totalConcessionFeesInput.val()) || 0;
            let totalConcessionFeesInputValue = 0;
            
            $('.concession-fee').each(function() {
                let val = parseFloat($(this).val()) || 0;
                totalConcessionFeesInputValue += val;
            });
        
            if (totalConcessionFeesInputValue > totalConcession) {
                console.log({totalConcessionFeesInputValue, totalConcession})
                
                saveButton.prop('disabled', true);
                alert("Total concession fees exceed the allowed amount!");
            } else {
                console.log({totalConcessionFeesInputValue, totalConcession})
                
                saveButton.prop('disabled', false);
                totalConcession = 0
                totalConcessionFeesInputValue = 0
            }
        })
    </script>
    
    <script>
        $("#class_id").change(function(event) {
            $("#class_id").val()
    
            fetch("<?php echo base_url('students?class_id=') ?>" + $("#class_id").val())
            .then(response => response.json())
            .then(data => {
                $("#section_id").empty()
    
                $("#section_id").append(`<option value=''>Please Select</option>`)
    
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
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.edit-installment').forEach(function(button) {
                button.addEventListener('click', function() {
                    var studentId = this.getAttribute('data-student-id');
                    var row = this.closest('tr'); 
                    var cells = row.querySelectorAll('td');
                    
                    var installmentDetails = row.querySelectorAll('td[data-name]');
                    var installmentBody = document.getElementById('installment-details-body');
                    var modalStudentId = document.getElementById('modal_student_id');
                    modalStudentId.value = studentId;
    
                    installmentBody.innerHTML = '';
    
                    var found = false;
                    var months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
                    var paymentPlanTypeDisplay = "<?php echo $payment_plan_type_display; ?>"; 
    
                    if (paymentPlanTypeDisplay == "month") {
                        let total = 0
                        months.forEach(function(month, index) {
                            var installmentAmount = installmentDetails[index] ? installmentDetails[index].getAttribute('data-amount') : '0';
                            total+=parseFloat(installmentAmount)
                            var installmentName = `ins_${index + 1}`;
        
                            if (installmentAmount !== 'NA') {
                                found = true;
                            }
    
                            var row = document.createElement('tr');
                            row.innerHTML = `
                                <td>${month} 25</td>
                                <td>
                                    <input type="text" class="form-control concession-fee" name="${installmentName}" value="${installmentAmount}" />
                                </td>
                            `;
                            installmentBody.appendChild(row);
                        });
                        
                        console.log(total)
                        totalConcessionFeesInput.val(total)
                    } else {
                        let total = 0
                        for (var i = 1; i <= 12; i++) {
                            var installmentAmount = installmentDetails[i - 1] ? installmentDetails[i - 1].getAttribute('data-amount') : 'NA';
                            total+=parseFloat(installmentAmount)
                            var installmentName = `ins_${i}`;
        
                            if (installmentAmount !== 'NA') {
                                found = true;
                            }
        
                            var row = document.createElement('tr');
                            row.innerHTML = `
                                <td>Installment ${i}</td>
                                <td>
                                    <input type="text" class="form-control concession-fee" name="${installmentName}" value="${installmentAmount}" />
                                </td>
                            `;
                            installmentBody.appendChild(row);
                        }
                        
                        console.log(total)
                        totalConcessionFeesInput.val(total)
                    }
    
                    
                    
                    var modalHeader = document.getElementById('modal-header');
                    var saveButton = document.getElementById('save-installment-btn');
    
                    if (found) {
                        modalHeader.innerText = "Edit Installments"; 
                        saveButton.innerText = "Save Changes";
                    } else {
                        modalHeader.innerText = "Create Installments"; 
                        saveButton.innerText = "Create Installments";
                    }
                });
            });
    
            document.getElementById('save-installment-btn').addEventListener('click', function() {
                var formData = new FormData();
                var studentId = document.getElementById('modal_student_id').value;
    
                formData.append('student_id', studentId);
    
                var installmentInputs = document.querySelectorAll('#installment-details-body input');
                installmentInputs.forEach(function(input) {
                    formData.append(input.name, input.value);
                });
    
                fetch("<?php echo base_url('fees/fees-concession/update'); ?>", {
                    method: 'POST',
                    body: formData
                }).then(response => response.json())
                  .then(data => {
                    if (data.success) {
                        $('#close-btn').click();
                        alert(data.message);
                        window.location.reload();
                    } else {
                        alert('Failed to update installments.');
                    }
                });
            });
        });
    </script>

<?php $this->load->view("inc/app_footer.php"); ?>
