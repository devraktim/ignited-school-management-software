<?php $this->load->view("inc/app_header.php"); ?>

    <div class="row mb-5">
        <div class="col-md-6">
            <h1>Assigned Teacher to The Classes</h1>
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

    <div class="row mb-5">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <div class="card card-flush h-xl-100 mt-5">
                <div class="card-body py-9">
                    <div class="table-responsive">
                        <table class="table table-sm school-table">
                            <thead>
                                <tr class="text-center table-dark">
                                    <th><h4 class="text-light">Class</h4></th>
                                    <th><h4 class="text-light">Section</h4></th>
                                    <th><h4 class="text-light">Teacher</h4></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($records as $record) { ?>
                                    <tr class="text-center">
                                        <td><h5><?php echo $record['class'] ?></h5></td>
                                        <td><h5><?php echo $record['section'] ?></h5></td>
                                        <td><h5><?php echo $record['employee_name'] ?></h5></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>            
        <div class="col-md-3"></div>                                
    </div>
   
<?php $this->load->view("inc/app_footer.php"); ?>