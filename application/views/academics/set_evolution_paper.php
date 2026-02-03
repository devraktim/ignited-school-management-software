<?php $this->load->view("inc/app_header.php"); ?>
<link href="https://unpkg.com/bootstrap-table@1.22.0/dist/extensions/reorder-rows/bootstrap-table-reorder-rows.css" rel="stylesheet">

    <div class="row mb-5">
        <div class="col-md-6">
            <h1>Set Evaluation Paper</h1>
        </div>
        <div class="col-md-2"></div>
        <div class="col-md-4 text-center">
            <?php if($this->session->flashdata('success'))  {?>
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    <strong><?php echo $this->session->flashdata('success')?></strong>
                </div>
            <?php } ?>
        </div>
    </div>

    <?php echo form_open(base_url("academics/set-evolution-paper/"), array("method" => "POST")) ?> 
        <div class="card card-flush h-xl-100">
            <div class="card-body py-9">
                <div class="row mb-5 align-items-center">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label">Class</label>
                            <select class="form-select" name="class_id">
                                <option value="">Please Select</option>
                                <?php foreach($classes as $class) { ?>
                                    <option value="<?php echo $class["id"]?>"><?php echo $class["name"]?></option>    
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label">Exam</label>
                            <select class="form-select" name="exam_id">
                                <option value="">Please Select</option>
                                <?php foreach($exams as $exam) { ?>
                                    <option value="<?php echo $exam["id"]?>"><?php echo $exam["name"]?> (<?php echo $exam["short_name"]?>)</option>    
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row mb-5 align-items-cenger">
                    <h4 class="mb-4">Subject</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="table-responsive">
                            <table id="table" class="table table-bordered border border-1 border-dark table-sm">
                            <tbody>
                                <?php foreach($evolution_subjects as $subject) { ?>
                                    <tr class="border border-1 border-dark">
                                        <td style="width: 50px;">
                                            <div class="form-check ms-3">
                                              <input class="form-check-input" type="checkbox" id="check1" name="subjects[]" value="<?php echo $subject['id'] ?>">
                                            </div>
                                        </td>
                                        <td>
                                            <?php echo $subject['name'] ?>
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
        </div>
        
        <?php if($this->session->user['permissions'][0]['academics_module'] != "VIEWER") { ?>
        <button type="submit" class="btn btn-success rounded rounded-pill mt-4"><i class="fa fa-plus"></i>Save</button>
        <?php } ?>
    <?php echo form_close() ?> 


<?php $this->load->view("inc/app_footer.php"); ?>

<script type="text/javascript">
$(document).ready(function() {
    // Initialise the table
    $("#table").tableDnD();
});
</script>