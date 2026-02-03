<?php $this->load->view("inc/app_header.php"); ?>

<div class="row align-items-center mb-4">

    <!-- Page Title -->
    <div class="col-md-8">
        <h1 class="mb-0">Leave Applications</h1>
    </div>

    <!-- New Leave Button -->
    <div class="col-md-4 text-end">
        <a href="<?php echo base_url('personnel/leave'); ?>" class="btn btn-primary">
            <i class="fa fa-plus"></i> New Leave
        </a>
    </div>

</div>

<!-- Success Message -->
<?php if ($this->session->flashdata('success')) { ?>
    <div class="row mb-4">
        <div class="col-md-6 mx-auto">
            <div class="alert alert-success alert-dismissible text-center">
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                <strong><?php echo $this->session->flashdata('success'); ?></strong>
            </div>
        </div>
    </div>
<?php } ?>


<div class="row">
    <div class="col-md-12">
        <div class="card card-flush h-xl-100">
            <div class="card-body py-9">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr class="text-center table-dark text-light">
                                <th>SL</th>
                                <th>Emp Code</th>
                                <th>Emp Name</th>
                                <th>Department</th>
                                <th>Designation</th>
                                <th>Application Date</th>
                                <th>Leave</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 0; foreach($leaves as $leave) { 
                                $i++;
                                $app = json_decode($leave['application'], true); // Decode JSON

                                $application_date = isset($app['application_date']) ? $app['application_date'] : '';
                                $from_date = isset($app['from_date']) ? $app['from_date'] : '';
                                $to_date = isset($app['to_date']) ? $app['to_date'] : '';
                                
                                // Format dates to dd-mm-YYYY
                                $application_date = !empty($application_date) ? date('d-m-Y', strtotime($application_date)) : '';
                                $from_date = !empty($from_date) ? date('d-m-Y', strtotime($from_date)) : '';
                                $to_date = !empty($to_date) ? date('d-m-Y', strtotime($to_date)) : '';
                                
                                // Prepare leave period
                                $leave_period = $from_date;
                                if(!empty($from_date) && !empty($to_date)) {
                                    $leave_period = $from_date . ' to ' . $to_date;
                                }
                            ?>
                            <tr class="text-center">
                                <td><?php echo $i; ?></td>
                                <td><?php echo $leave['employee']['emp_code']; ?></td>
                                <td><?php echo $leave['employee']['f_name'] . ' ' . $leave['employee']['m_name'] . ' ' . $leave['employee']['l_name']; ?></td>
                                <td><?php echo $leave['employee']['department']; ?></td>
                                <td><?php echo $leave['employee']['designation']; ?></td>
                                <td><?php echo $application_date; ?></td>
                                <td><?php echo $leave_period; ?></td>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-primary view-btn btn-sm mx-2" 
        data-application='<?php echo htmlspecialchars($leave['application']); ?>' 
        data-emp='<?php echo htmlspecialchars(json_encode($leave['employee'])); ?>'>View</button>
                            
                                        <a href="<?php echo base_url('personnel/leave/delete/'.$leave['id']); ?>" 
                                           class="btn btn-danger btn-sm" 
                                           onclick="return confirm('Are you sure to delete this leave?')">Delete</a>
                                    </div>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for View Leave Application -->
<div class="modal fade" id="leaveModal" tabindex="-1" aria-labelledby="leaveModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="leaveModalLabel">Leave Application</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <div id="modalLeaveContent" style="font-size:16px;line-height:1.6;"></div>
      </div>
      <div class="modal-footer">
        <button id="printLeaveBtn" class="btn btn-success">Print</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
$(document).ready(function() {
    $('.view-btn').click(function() {
        var app = $(this).data('application'); // Already JS object
        var employee = $(this).data('emp');    // Already JS object

        // Parse dates
        var fromDate = app.from_date ? moment(app.from_date).format('DD-MM-YYYY') : '';
        var toDate = app.to_date ? moment(app.to_date).format('DD-MM-YYYY') : '';
        var applicationDate = app.application_date ? moment(app.application_date).format('DD-MM-YYYY') : '';

        // Leave period display
        var leavePeriod = fromDate;
        if(fromDate && toDate) leavePeriod = (fromDate === toDate) ? fromDate : fromDate + ' to ' + toDate;

        // Construct HTML for modal
        var html = `
            <div style="max-width:800px;margin:0 auto;padding:20px;font-size:16px;line-height:1.6;">
                <div style="text-align:right;margin-bottom:20px;"><strong>Date:</strong> ${applicationDate}</div>
                <div style="text-align:center;font-size:20px;font-weight:bold;margin-bottom:20px;">Leave Application</div>
                
                <p class='mb-0'>To,</p>
                <p class='mb-0'><strong>The Principal</strong></p>
                <p class='mb-0'><strong>St. Francis School, Jorethang</strong></p>
                <p class='mb-0'><strong>Sikkim</strong></p>

                <div style="margin:20px 0;">
                    <p>Subject: Application for leave ${leavePeriod}</p>
                    <p>Dear Sir,</p>
                    <p>
                    I hereby like to inform you that due to <strong>${app.leave_reason || ''}</strong>, 
                    I shall be unable to attend school ${leavePeriod === fromDate ? 'on ' + fromDate : 'from ' + fromDate + ' to ' + toDate}.
                    </p>
                    <p>Hence I request your benevolence to grant me the leave ${leavePeriod === fromDate ? 'on ' + fromDate : 'from ' + fromDate + ' to ' + toDate} and oblige.</p>
                </div>

                <p class='mb-0'>Thanking You</p>
                <p class='mb-0'>Yours Faithfully</p>
                <br>
                <p class='mb-0'><strong>${employee.f_name} ${employee.m_name} ${employee.l_name}</strong></p>
                <p class='mb-0'><strong>${employee.designation}</strong></p>
            </div>
        `;

        $('#modalLeaveContent').html(html);
        $('#leaveModal').modal('show');

        // Attach print function
        $('#printLeaveBtn').off('click').on('click', function() {
            var printWindow = window.open('', '_blank');
            printWindow.document.write(`
                <html>
                <head>
                    <title>Leave Application</title>
                    <style>
                        body { font-family: Arial, sans-serif; margin: 40px; }
                        @page { size: A4; margin: 40px; }
                        .letter { max-width: 800px; margin: 0 auto; line-height: 1.6; font-size: 16px; }
                        .text-right { text-align: right; }
                        .text-center { text-align: center; font-weight: bold; font-size: 20px; margin-bottom: 20px; }
                    </style>
                </head>
                <body>
                    <div class="letter">
                        ${html}
                    </div>
                </body>
                </html>
            `);
            printWindow.document.close();
        });
    });
});

</script>

<?php $this->load->view("inc/app_footer.php"); ?>
