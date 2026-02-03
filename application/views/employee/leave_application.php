<?php $this->load->view("inc/app_header.php"); ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<style>
    body { background: #fff !important; }
    .leave-container { max-width: 800px !important; margin: 40px auto !important; padding: 30px 40px !important; border: 1px solid #ddd !important; font-size: 18px !important; }
    .title { font-size: 26px !important; font-weight: 600 !important; text-align: center !important; margin-bottom: 30px !important; }
    .form-inline-input { display: inline-block !important; width: auto !important; min-width: 160px !important; border: none !important; border-bottom: 1px solid #000 !important; border-radius: 0 !important; padding: 0 5px !important; }
    .form-inline-input:focus { box-shadow: none !important; border-bottom: 2px solid #000 !important; }
    .section-gap { margin-top: 25px !important; }
    .signature { margin-top: 60px !important; }
</style>

<div class="row mb-5">
    <h1>Leave Application</h1>
</div>

<form id="form" method="POST" action="<?php echo base_url() ?>personnel/leave">
    <div class="row mb-5">
        <div class="col-md-12">
            <div class="card card-flush h-xl-100">
                <div class="card-body py-9">
                    <div class="container leave-container">

                        <!-- Date -->
                        <div class="text-end mb-4">
                            <strong>Date :</strong>
                            <input type="date" name="application_date" class="form-inline-input"
                                   value="<?= date('Y-m-d') ?>" style="background-color:white!important;">
                        </div>

                        <!-- Address -->
                        <div class="mb-4">
                            <p class="mb-1">To</p>
                            <p class="mb-1"><strong>The Principal</strong></p>
                            <p class="mb-1"><strong>St. Francis School, Jorethang</strong></p>
                            <p class="mb-1"><strong>Sikkim</strong></p>
                        </div>

                        <!-- SUBJECT -->
                        <div class="text-center mb-4" id="subjectTextContainer"></div>

                        <!-- BODY -->
                        <div class="section-gap" id="bodyContainer"></div>

                        <!-- Closing -->
                        <div class="section-gap">
                            <p class="mb-0">Thanking You</p>
                            <p class="mb-0">Yours Faithfully</p>
                            <br>
                            <p class="mb-0"><strong><?php echo $employee['f_name'] . ' ' . $employee['m_name'] . ' ' . $employee['l_name']  ?></strong></p>
                            <p class="mb-0"><strong><?php echo $employee['designation']  ?></strong></p>
                        </div>

                        <!-- Hidden HTML for submission -->
                        <textarea name="application_html" id="application_html" style="display:none;"></textarea>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>

<script>
$(function () {

    const today = moment();
    const tomorrow = moment().add(1, 'days');

    // Function to update subject and body
    function updateText(from, to) {
        const sameDay = from.isSame(to, 'day');
        let subjectHtml, bodyHtml;

        if (sameDay) {
            subjectHtml = `
                Application for leave on
                <input type="text" id="leaveRange" name="leaveRange" class="form-inline-input"
                       style="background-color:white!important;width:220px;"
                       value="${from.format('DD-MM-YYYY')}">
            `;

            bodyHtml = `
                <p>Dear Sir,</p>
                <p>
                I hereby like to inform you that due to
                <input type="text" name="leave_reason" class="form-inline-input"
                       placeholder="reason" style="width:420px;background:white!important;">
                I shall be unable to attend school on <strong>${from.format('DD-MM-YYYY')}</strong>.
                </p>
                <p>Hence I request your benevolence to grant me the leave on <strong>${from.format('DD-MM-YYYY')}</strong> and oblige.</p>
            `;
        } else {
            subjectHtml = `
                Application for leave from
                <input type="text" id="leaveRange" name="leaveRange" class="form-inline-input"
                       style="background-color:white!important;width:260px;"
                       value="${from.format('DD-MM-YYYY')} to ${to.format('DD-MM-YYYY')}">
            `;

            bodyHtml = `
                <p>Dear Sir,</p>
                <p>
                I hereby like to inform you that due to
                <input type="text" name="leave_reason" class="form-inline-input"
                       placeholder="reason" style="width:420px;background:white!important;">
                I shall be unable to attend school from <strong>${from.format('DD-MM-YYYY')}</strong>
                to <strong>${to.format('DD-MM-YYYY')}</strong>.
                </p>
                <p>Hence I request your benevolence to grant me the leave from <strong>${from.format('DD-MM-YYYY')}</strong> to <strong>${to.format('DD-MM-YYYY')}</strong> and oblige.</p>
            `;
        }

        $('#subjectTextContainer').html(subjectHtml);
        $('#bodyContainer').html(bodyHtml);

        attachPicker(from, to);      // Reattach picker for updates
        updateHiddenHTML();           // Update hidden textarea for submission
    }

    // Function to attach Date Range Picker
    function attachPicker(start, end) {
        $('#leaveRange').daterangepicker({
            startDate: start,
            endDate: end,
            autoApply: true,
            locale: { format: 'DD-MM-YYYY' },
            opens: 'center'
        }, function(start, end, label) {
            const display = start.isSame(end, 'day') 
                ? start.format('DD-MM-YYYY') 
                : `${start.format('DD-MM-YYYY')} to ${end.format('DD-MM-YYYY')}`;
            $('#leaveRange').val(display);
            updateText(start, end);
        });

        // Set initial display
        const initialDisplay = start.isSame(end, 'day') 
            ? start.format('DD-MM-YYYY') 
            : `${start.format('DD-MM-YYYY')} to ${end.format('DD-MM-YYYY')}`;
        $('#leaveRange').val(initialDisplay);
    }

    // Function to update hidden HTML for submission
    function updateHiddenHTML() {
        const htmlContent = $('.leave-container').html();
        $('#application_html').val(htmlContent);
    }

    // Update hidden HTML on any input change
    $(document).on('input', '.form-inline-input', updateHiddenHTML);

    // ✅ Initial load
    updateText(today, tomorrow);

});
</script>


<?php $this->load->view("inc/app_footer.php"); ?>
