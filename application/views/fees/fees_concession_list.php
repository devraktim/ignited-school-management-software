<?php $this->load->view("inc/app_header.php"); ?>

<style>
    .table-responsive { height: 500px; }
    table { width: 100%; border-collapse: collapse; }
    th, td { padding: 8px; border: 1px solid #ccc; }
    .sticky-header { position: sticky; top: 0; background: #f2f2f2; z-index: 2; }
    .sticky-column-1 { position: sticky; left:0; background:white; z-index:4; min-width:50px; }
    .sticky-column-2 { position: sticky; left:50px; z-index:3; min-width:100px; }
    .sticky-column-3 {
        position: sticky;
        left:265px;
        z-index:2;
        min-width:100px;
        box-shadow: 10px 0 10px -5px rgba(0,0,0,.2);
        border-right: 1px solid black !important;
    }
    table .form-select { width: 150px !important; }
</style>

<?php
/* =========================
   SESSION-BASED MONTH ORDER
   ========================= */
$session = $this->session->academy_session['current_session'];

$startMonth = (int) date('n', strtotime($session['start']));
$endMonth   = (int) date('n', strtotime($session['end']));

$allMonths = [
    1=>'Jan',2=>'Feb',3=>'Mar',4=>'Apr',
    5=>'May',6=>'Jun',7=>'Jul',8=>'Aug',
    9=>'Sep',10=>'Oct',11=>'Nov',12=>'Dec'
];

$orderedMonths = [];
// Start month → Dec
for($m=$startMonth;$m<=12;$m++){ $orderedMonths[]=$allMonths[$m]; }
// Jan → End month
for($m=1;$m<=$endMonth;$m++){ $orderedMonths[]=$allMonths[$m]; }
?>

<div class="row mb-5">
    <div class="col-md-8">
        <h1>Concession</h1>
    </div>
    <div class="col-md-4 text-center">
        <?php if($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                <strong><?php echo $this->session->flashdata('success')?></strong>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="card card-flush h-xl-100">
    <div class="card-body py-9">
        <?php echo form_open(base_url("fees/fees-concession/index"), ["method"=>"GET"]) ?> 
        <div class="row">
            <!-- CLASS -->
            <div class="col-md-3 mb-3">
                <div class="form-group">
                    <label class="form-label">Select Class</label>
                    <select class="form-select" name="class_id" id="class_id" required>
                        <option value="">Please Select</option>
                        <?php foreach ($classes as $class): ?>
                            <option value="<?php echo $class["id"] ?>" <?php echo (isset($_GET["class_id"]) && $_GET["class_id"] == $class["id"]) ? "selected":""; ?>><?php echo $class["name"] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <!-- SECTION -->
            <div class="col-md-3 mb-3">
                <div class="form-group">
                    <label class="form-label">Select Section</label>
                    <select class="form-select" id="section_id" name="section_id" <?php echo (!isset($sections)) ? "disabled":"" ?> required>
                        <option value=''>Please Select</option>
                        <?php foreach ($sections as $section): ?>
                            <option value="<?php echo $section["id"] ?>" <?php echo (isset($_GET["section_id"]) && $_GET["section_id"] == $section["id"]) ? "selected":""; ?>><?php echo $section["name"] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <!-- STUDENT TYPE -->
            <div class="col-md-3 mb-3">
                <div class="form-group">
                    <label class="form-label">Select Student Type</label>
                    <select class="form-select" name="student_type_id" id="student_type_id" required>
                        <option value="">Please Select</option>
                        <?php foreach ($student_types as $student_type): ?>
                            <option value="<?php echo $student_type["id"] ?>" <?php echo (isset($_GET["student_type_id"]) && $_GET["student_type_id"] == $student_type["id"]) ? "selected":""; ?>><?php echo $student_type["name"] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <!-- SEARCH BUTTON -->
            <div class="col-md-3 mb-3" style="margin-top: 25px;">
                <button id="btn_save" class="btn btn-success" <?php echo (!isset($sections)) ? "disabled":"" ?>>
                    <i class="fa fa-search"></i> Search
                </button>
            </div>
        </div>
        <?php echo form_close() ?>
    </div>
</div>

<?php if(isset($students)): ?>
<div class="card card-flush h-xl-100 mt-5">
    <div class="card-body py-9">
        <div class="row">
            <div class="col-md-12">
                <?php if(count($students) > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr class="table-dark text-light">
                                    <th class="sticky-header sticky-column-1" style="z-index:5 !important;"></th>
                                    <th class="text-nowrap sticky-header sticky-column-2" style="z-index:5 !important;">Name</th>
                                    <th class="text-nowrap sticky-header sticky-column-3" style="z-index:5 !important;">Student ID</th>

                                    <?php if ($payment_plan_type_display == "month"): ?>
                                        <?php foreach($orderedMonths as $month): ?>
                                            <th class="text-nowrap sticky-header"><?php echo $month; ?> 25</th>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <?php for($i=1;$i<=12;$i++): ?>
                                            <th class="text-nowrap sticky-header">Installment <?php echo $i; ?></th>
                                        <?php endfor; ?>
                                    <?php endif; ?>

                                    <th class="text-nowrap sticky-header">Total</th>
                                    <th class="sticky-header">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $sl=0; foreach($students as $student): $sl++; ?>
                                <tr>
                                    <td class="table-warning text-dark p-2 sticky-column-1"><?php echo $sl; ?></td>
                                    <td class="text-nowrap sticky-column-2" style="background-color:#fbffd1 !important;">
                                        <?php echo $student['f_name'].' '.$student['m_name'].' '.$student['l_name']; ?>
                                    </td>
                                    <td class="text-nowrap sticky-column-3" style="background-color:#fbffd1 !important;">
                                        <?php echo $student['student_no']; ?>
                                    </td>

                                    <?php
                                    $concessions = $student['concession'];
                                    $totalAmount = 0;
                                    for($i=0;$i<12;$i++):
                                        if(isset($concessions[$i])):
                                            $amount = floatval($concessions[$i]['amount']);
                                            $totalAmount += $amount;
                                    ?>
                                        <td data-name="<?php echo $concessions[$i]['installment_id']; ?>"
                                            data-amount="<?php echo $amount; ?>"
                                            data-student-id="<?php echo $student['id']; ?>">
                                            <?php echo number_format($amount,2); ?>
                                        </td>
                                    <?php else: ?>
                                        <td class="text-muted">NA</td>
                                    <?php endif; endfor; ?>

                                    <td><strong><?php echo number_format($totalAmount,2); ?></strong></td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-primary edit-installment"
                                                data-student-id="<?php echo $student['id']; ?>"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editInstallmentModal">
                                            <?php echo (count($concessions) > 0) ? 'Edit':'Create'; ?>
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="row justify-content-center">
                        <h3 class="text-center">No Student Found</h3>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- MODAL -->
<div class="modal fade" id="editInstallmentModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            <label>Total Concession</label>
            <input type="number" id="total-concession-fees" class="form-control mb-3" />

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr><th>Month</th><th>Amount</th></tr>
                    </thead>
                    <tbody id="installment-details-body"></tbody>
                </table>
            </div>

            <input type="hidden" id="modal_student_id" />
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="close-btn">Close</button>
            <button type="button" class="btn btn-success" id="save-installment-btn">Save</button>
        </div>
    </div>
  </div>
</div>

<script>
const orderedMonths = <?php echo json_encode($orderedMonths); ?>;

document.querySelectorAll('.edit-installment').forEach(btn=>{
    btn.addEventListener('click',function(){
        const row = this.closest('tr');
        const cells = row.querySelectorAll('td[data-amount]');
        const body = document.getElementById('installment-details-body');
        body.innerHTML = '';

        let total = 0;
        orderedMonths.forEach((month,index)=>{
            let amount = cells[index] ? cells[index].dataset.amount : 0;
            total += parseFloat(amount||0);
            body.innerHTML += `
                <tr>
                    <td>${month}</td>
                    <td><input type="text" class="form-control concession-fee" name="ins_${index+1}" value="${amount}"></td>
                </tr>
            `;
        });

        document.getElementById('total-concession-fees').value = total;
        document.getElementById('modal_student_id').value = this.dataset.studentId;
        document.querySelector('#editInstallmentModal .modal-title').textContent = (total>0?'Edit':'Create')+' Concession';
    });
});

document.getElementById('save-installment-btn').addEventListener('click',()=>{
    const formData = new FormData();
    formData.append('student_id',document.getElementById('modal_student_id').value);
    document.querySelectorAll('.concession-fee').forEach(i=>formData.append(i.name,i.value));

    fetch("<?php echo base_url('fees/fees-concession/update');?>",{
        method:'POST',body:formData
    }).then(r=>r.json()).then(d=>{
        alert(d.message);
        location.reload();
    });
});

// Update sections on class change
$("#class_id").change(function(){
    fetch("<?php echo base_url('students?class_id=') ?>"+$(this).val())
    .then(r=>r.json())
    .then(data=>{
        $("#section_id").empty().append(`<option value=''>Please Select</option>`);
        data.sections.forEach(s=>$("#section_id").append(`<option value=${s.id}>${s.name}</option>`));
        $("#section_id,#btn_save").prop("disabled",false);
    });
});
</script>

<?php $this->load->view("inc/app_footer.php"); ?>
