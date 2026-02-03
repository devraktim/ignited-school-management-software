<?php $this->load->view("inc/app_header.php"); ?>

    <div class="row mb-5">
        <div class="col-md-8">
            <h1>Payment Plan View</h1>
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
                <div class="col-md-6">
                    <h4 class="mb-3">Payment Collection Type - <?php if($data['type'] == "installments") { echo "Installment & Months"; } else { echo "Months"; } ?></h4>
                    
                    <h4 class="mb-3">Payment Collection Display as - <?php if($data['display'] == "installment") { echo "Installment"; } else { echo "Month"; } ?></h4>
                    
                    <?php 
                        // Get start and end dates from session
                        $start_date = $this->session->academy_session['current_session']['start'];
                        $end_date = $this->session->academy_session['current_session']['end'];
                    
                        // Convert the start and end dates to DateTime objects
                        $start = new DateTime($start_date);
                        $end = new DateTime($end_date);
                    
                        // Loop through all months between start and end dates for month type
                        $months = [];
                        while ($start <= $end) {
                            $months[] = $start->format('F Y');  // Format to "Month Year"
                            $start->modify('first day of next month');  // Move to next month
                        }
                    ?>
                    
                    <?php if($data['type'] == "months") { ?>
                        <?php if ($data['display'] == "month") { ?>
                            <!-- Display Month Names -->
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="table-dark text-light">
                                        <th></th> <!-- Blank Header -->
                                        <th>Month</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($months as $index => $month) { ?>
                                        <tr>
                                            <td class="table-primary text-dark p-2"><?php echo $index + 1; ?></td> <!-- Loop iteration number -->
                                            <td><?php echo $month; ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        <?php } else { ?>
                            <!-- Display Installment Names -->
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="table-dark text-light">
                                        <th></th> <!-- Blank Header -->
                                        <th>Installment</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($months as $index => $month) { ?>
                                        <tr>
                                            <td class="table-primary text-dark p-2"><?php echo $index + 1; ?></td> <!-- Loop iteration number -->
                                            <td>Installment <?php echo $index + 1; ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        <?php } ?>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
<?php $this->load->view("inc/app_footer.php"); ?>