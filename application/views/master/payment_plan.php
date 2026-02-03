<?php $this->load->view("inc/app_header.php"); ?>

    <div class="row mb-5">
        <div class="col-md-8">
            <h1>Payment Plan</h1>
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


    <div class="card card-flush h-xl-100 mb-4">
        <div class="card-body py-9">
            <div class="row">
                <h4 class="mb-3">Payment Collection Type</h4>
                
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="exampleRadios" id="installments_key" value="installments">
                  <label class="form-check-label" for="installments_months">Installments</label>
                </div>
                
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="exampleRadios" id="months_key" value="months">
                  <label class="form-check-label" for="months">Months</label>
                </div>
            </div>
        </div>
    </div>
                
    <div id="installments" style="display: none;">
        <div class="card card-flush h-xl-100">
            <div class="card-body py-9">
                <form action="<?php echo base_url() ?>master/payment-plan/store" method="POST">
                    <div class="row">
                        <input type="text" class="d-none" name="type" value="installments" />
                        
                        <div class="col-md-4">
                            <label for="installmentsInput" class="form-label">How many installments?</label>
                            <input type="number" class="form-control w-100" id="installmentsInput">
                        </div>
                        <div class="col-md-4">
                            <button type="button" class="btn btn-success" id="installmentsBtn" style="margin-top: 26px !important;">Get Installments</button>
                        </div>
                    </div>
                    
                    <div id="inscontainer" class="mt-4">
                        
                    </div>
                    
                    <div class="mt-3">
                        <button type="submit" class="btn btn-success mt-5" style="margin-top: 25px !important;">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div id="months" style="display: none;">
        <div class="card card-flush h-xl-100">
            <div class="card-body py-9">
                <form action="<?php echo base_url() ?>master/payment-plan/store" method="POST">
                    <div class="row">
                        <input type="text" class="d-none" name="type" value="months" />
                        
                        <div class="row">
                            <h4 class="mb-3">Payment Collection Display (in header)</h4>
                            
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="radio" name="display" value="installment">
                              <label class="form-check-label" for="installments_months">Installment</label>
                            </div>
                            
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="radio" name="display" value="month">
                              <label class="form-check-label" for="months">Month</label>
                            </div>
                        </div>

                        <div class="mt-3">
                            <button type="submit" class="btn btn-success">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add event listeners for radio buttons
            const radios = document.getElementsByName('exampleRadios');
            radios.forEach(radio => {
                radio.addEventListener('change', function() {
                    // Hide all divs
                    document.getElementById('installments').style.display = 'none';
                    document.getElementById('months').style.display = 'none';

                    // Show the selected div based on the radio button value
                    if (this.value === 'installments') {
                        document.getElementById('installments').style.display = 'block';
                    } else if (this.value === 'months') {
                        document.getElementById('months').style.display = 'block';
                    }
                });
            });
        });
    </script>
    
    <script>
        $("#installmentsBtn").click(function() {
            let number_of_installments = parseInt($("#installmentsInput").val());
            let html = "";
            
            // Initialize the previous "to date" as null
            let prevToDate = null;
    
            for (let i = 1; i <= number_of_installments; i++) {
                let installmentHtml = `
                    <tr class="installment-row" id="installment_row_${i}">
                        <td class="table-primary text-dark p-2">${i}</td>
                        <td><h5>Installment ${i}</h5></td>
                        <td>
                            <input type="date" id="installment${i}_from" class="form-control" ${i === 1 ? '' : 'disabled'}>
                        </td>
                        <td>
                            <input type="date" id="installment${i}_to" class="form-control" ${i === 1 ? '' : 'disabled'}>
                        </td>
                    </tr>`;
    
                // Add the installment HTML for this row
                html += installmentHtml;
    
                // If this is not the first installment, set the min date of "From Date" to 1 day after the previous installment's "To Date"
                if (prevToDate !== null) {
                    let nextFromDate = new Date(prevToDate);
                    nextFromDate.setDate(nextFromDate.getDate() + 1);
    
                    let nextFromDateString = nextFromDate.toISOString().split('T')[0];
                    
                    // Update the min date for the next installment's "From Date"
                    html = html.replace(`id="installment${i + 1}_from"`, `id="installment${i + 1}_from" min="${nextFromDateString}" ${i === number_of_installments - 1 ? '' : ''}`);
                    html = html.replace(`id="installment${i + 1}_to"`, `id="installment${i + 1}_to" min="${nextFromDateString}" ${i === number_of_installments - 1 ? '' : ''}`);
                }
    
                // Update prevToDate to the current date
                prevToDate = new Date(); // Initially, set the previous "to date" to today (for the first installment)
            }
    
            // Append the table rows with the installment data
            $("#inscontainer").html(`
                <table class="table table-bordered">
                    <thead>
                        <tr class="table-dark text-light">
                            <th></th>
                            <th>Installment</th>
                            <th>From Date</th>
                            <th>To Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${html}
                    </tbody>
                </table>
            `);
    
            // Enable date input for the first installment
            $("#installment1_from").prop("disabled", false);
            $("#installment1_to").prop("disabled", false);
    
            // Handle when the user fills the dates for an installment
            $("input[type=date]").on("change", function() {
                let currentInstallment = $(this).closest(".installment-row");
                
                let fromDate = currentInstallment.find("input[id*='from']").val()
                let toDate = currentInstallment.find("input[id*='to']").val()
                
                if(fromDate == "" || toDate == "") {return;}
                
                let currentFromDate = new Date(currentInstallment.find("input[id*='from']").val());
                let currentToDate = new Date(currentInstallment.find("input[id*='to']").val());
                
                console.log(currentFromDate, currentToDate)
    
                // Make sure the 'to date' is later than 'from date'
                if (currentFromDate && currentToDate && currentToDate < currentFromDate) {
                    alert("The 'To Date' should be after the 'From Date'");
                    $(this).val(""); // Clear the incorrect date
                } else {
                    // If both From Date and To Date are selected, enable the next installment's dates
                    if (currentFromDate && currentToDate) {
                        let nextInstallment = currentInstallment.next(".installment-row");
                        
                        if (nextInstallment.length) {
                            // Update the "From Date" for the next installment to be one day after the "To Date"
                            let nextFromDate = new Date(currentToDate);
                            nextFromDate.setDate(nextFromDate.getDate() + 1);
                            let nextFromDateString = nextFromDate.toISOString().split('T')[0];
    
                            // Set the min date for the next installment's "From Date"
                            nextInstallment.find("input[id*='from']").prop("min", nextFromDateString);
                            nextInstallment.find("input[id*='from']").prop("disabled", false);
                            
                            // Set the min date for the next installment's "To Date"
                            nextInstallment.find("input[id*='to']").prop("min", nextFromDateString);
                            nextInstallment.find("input[id*='to']").prop("disabled", false);
                        }
                    }
                }
            });
        });
    </script>
<?php $this->load->view("inc/app_footer.php"); ?>