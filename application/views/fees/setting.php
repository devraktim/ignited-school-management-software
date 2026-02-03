<?php $this->load->view("inc/app_header.php"); ?>

    <div class="row mb-5">
        <div class="col-md-3">
            <h1>Fees Settings</h1>
        </div>
        <div class="col-md-5"></div>
        <div class="col-md-4 text-center">
            <?php if($this->session->flashdata('success'))  {?>
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    <strong><?php echo $this->session->flashdata('success')?></strong>
                </div>
            <?php } ?>
        </div>
    </div>
 

    <form action="<?php echo base_url()?>fees/setting/store" method="POST">
        <div class="row">
            <div class="col-md-8">
                <div class="card card-flush h-xl-100">
                    <!--begin::Body-->
                    <div class="card-body py-9">
                        <h2 class="mb-3">Late Fine Fees</h2>
                        
                        <div class="row g-3 mb-3 align-items-center">
                            <div class="col-md-4">
                                <label class="col-form-label">Late time for school fees</label>
                            </div>
                            <div class="col-md-4">
                                <select class="form-select" name="school_late_fine_fees" id="schoolLateFineSelect">
                                    <option value="na" <?php echo isset($settings['school_late_fine_fees']) && $settings['school_late_fine_fees'] == 'na' ? 'selected' : ''; ?>>Not Applicable</option>
                                    <option value="day" <?php echo isset($settings['school_late_fine_fees']) && $settings['school_late_fine_fees'] == 'day' ? 'selected' : ''; ?>>Per Day</option>
                                    <option value="month_installment" <?php echo isset($settings['school_late_fine_fees']) && $settings['school_late_fine_fees'] == 'month_installment' ? 'selected' : ''; ?>>Per Month/ Installment</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <input class="form-control" name="school_late_fine_amount" id="schoolLateFineAmount" 
                                    value="<?php echo isset($settings['school_late_fine_amount']) ? $settings['school_late_fine_amount'] : ''; ?>" 
                                    style="<?php echo isset($settings['school_late_fine_fees']) && $settings['school_late_fine_fees'] !== 'na' ? 'display: block;' : 'display: none;'; ?>" placeholder="Amount" />
                            </div>
                        </div>
                        
                        <div class="row g-3 mb-3 align-items-center">
                            <div class="col-md-4">
                                <label class="col-form-label">Late time for hostel fees</label>
                            </div>
                            <div class="col-md-4">
                                <select class="form-select" name="hostel_late_fine_fees" id="hostelLateFineSelect">
                                    <option value="na" <?php echo isset($settings['hostel_late_fine_fees']) && $settings['hostel_late_fine_fees'] == 'na' ? 'selected' : ''; ?>>Not Applicable</option>
                                    <option value="day" <?php echo isset($settings['hostel_late_fine_fees']) && $settings['hostel_late_fine_fees'] == 'day' ? 'selected' : ''; ?>>Per Day</option>
                                    <option value="month_installment" <?php echo isset($settings['hostel_late_fine_fees']) && $settings['hostel_late_fine_fees'] == 'month_installment' ? 'selected' : ''; ?>>Per Month/ Installment</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <input class="form-control" name="hostel_late_fine_amount" id="hostelLateFineAmount" 
                                    value="<?php echo isset($settings['hostel_late_fine_amount']) ? $settings['hostel_late_fine_amount'] : ''; ?>" 
                                    style="<?php echo isset($settings['hostel_late_fine_fees']) && $settings['hostel_late_fine_fees'] !== 'na' ? 'display: block;' : 'display: none;'; ?>" placeholder="Amount" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-success rounded rounded-pill mt-5"><i class="fa fa-plus"></i> Save</button>
    </form>
    
    <script>
        // Function to handle the visibility of the input fields based on the dropdown selection
        function toggleLateFineAmount(selectElement, inputElement) {
            if (selectElement.value !== 'na') {
                inputElement.style.display = 'block'; // Show the input field
            } else {
                inputElement.style.display = 'none'; // Hide the input field
            }
        }

        // Get the select elements and input fields
        const schoolLateFineSelect = document.getElementById('schoolLateFineSelect');
        const schoolLateFineAmount = document.getElementById('schoolLateFineAmount');
        
        const hostelLateFineSelect = document.getElementById('hostelLateFineSelect');
        const hostelLateFineAmount = document.getElementById('hostelLateFineAmount');

        // Add event listeners to the select elements to trigger the function
        schoolLateFineSelect.addEventListener('change', function() {
            toggleLateFineAmount(schoolLateFineSelect, schoolLateFineAmount);
        });

        hostelLateFineSelect.addEventListener('change', function() {
            toggleLateFineAmount(hostelLateFineSelect, hostelLateFineAmount);
        });

        // Initially check the selection when the page loads
        toggleLateFineAmount(schoolLateFineSelect, schoolLateFineAmount);
        toggleLateFineAmount(hostelLateFineSelect, hostelLateFineAmount);
    </script>

<?php $this->load->view("inc/app_footer.php"); ?>