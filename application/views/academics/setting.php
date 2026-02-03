<?php $this->load->view("inc/app_header.php"); ?>

    <div class="row mb-5">
        <div class="col-md-6">
            <h1>Academics Setting</h1>
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
        <div class="col-md-6">
            <a href="<?php echo base_url()?>academics/setting/assign-teacher-class" class="btn btn-primary">Assign Class Teacher</a>
        </div>
        <div class="col-md-6">
            <a href="<?php echo base_url()?>academics/setting/show-class-teacher" class="btn btn-primary">Show Class Teacher</a>
        </div>

    </div>

   
<?php $this->load->view("inc/app_footer.php"); ?>