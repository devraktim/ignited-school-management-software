<?php $this->load->view("inc/app_header.php"); ?>

    <div class="row mb-5">
        <div class="col-md-6">
            <h1>Examination Paper</h1>
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
        <ul class="nav nav-pills nav-justified mb-3" id="pills-tab" role="tablist">
            <?php $i = 0; foreach($classes as $class) { $i++ ?>
                <li class="nav-item" role="presentation">
                    <button class="nav-link tab-button" id="pills-tab-<?php echo $i;?>" data-bs-toggle="pill" data-bs-target="#tab-<?php echo $i;?>" type="button" role="tab" aria-controls="pills-<?php echo $class['name'] ?>" aria-selected="false"><?php echo $class['name'] ?></button>
                </li>
            <?php } ?>
        </ul>
        <div class="tab-content" id="pills-tabContent">
            <?php $i = 0; foreach($classes as $class) { $i++ ?>
                <div class="tab-pane fade" id="tab-<?php echo $i;?>" role="tabpanel">
                    <div class="row">
                        <?php $flag = false; foreach($papers as $paper_key => $paper) { if($paper["class_name"] == $class["name"]) { $flag = true; ?>
                            <?php foreach($paper["exams"] as $exam_key => $exam) { ?>
                                <div class="col-md-12 mt-3 mb-3">
                                <div class="card card-flush h-xl-100">
                                    <div class="card-body py-9">
                                        <div class="row mb-3">
                                            <div class="col-md-12 text-center">
                                                <h4 class="text-dark d-block">
                                                    <?php echo $exam["exam_name"] ?>
                                                </h4>

                                                <?php if($this->session->user['permissions'][0]['academics_module'] != "VIEWER" && 
                                                          $this->session->user['permissions'][0]['academics_module'] != "OPERATOR" ) { ?>
                                                <a href="<?php echo base_url() ?>academics/examination-paper/delete/<?php echo $exam["exam_id"] ?>" class="btn btn-sm btn-delete text-dark"><i class="fa fa-trash"></i></a>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-sm table-bordered mt-3">
                                                <thead>
                                                    <tr class="text-center">
                                                        <th><h4 class="text-center">Sl No.</h4></th>
                                                        <th><h4 class="text-center">Subject</h4></th>
                                                        <th><h4 class="text-center">Component</h4></th>
                                                        <th><h4 class="text-center">Full Marks</h4></th>
                                                        <th><h4 class="text-center">Pass Marks</h4></th>
            
                                                        <?php if($this->session->user['permissions'][0]['academics_module'] != "VIEWER" && 
                                                                  $this->session->user['permissions'][0]['academics_module'] != "OPERATOR" ) { ?>
                                                        <th><h4 class="text-center">Action</h4></th>
                                                        <?php } ?>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $k = 0; foreach($exam["subjects"] as $subject_key => $subject) { $k++ ?>
                                                        <tr>
                                                            <td class="text-dark text-center" style="padding-left: 5px;"><?php echo $k; ?></td>
                                                            <td class="text-center"><?php echo $subject['subject_name'] ?></td>
                                                            <td class="text-center"><?php echo $subject['component_name'] ?></td>
                                                            <td class="text-center"><?php echo $subject['full_marks'] ?></td>
                                                            <td class="text-center"><?php echo $subject['pass_marks'] ?></td>
            
                                                            <?php if($this->session->user['permissions'][0]['academics_module'] != "VIEWER" && 
                                                                      $this->session->user['permissions'][0]['academics_module'] != "OPERATOR" ) { ?>
                                                            <td class="text-center">
                                                                <a href="<?php echo base_url() ?>academics/examination-paper/remove-subject?id=<?php echo $exam["exam_id"] ?>&subject_id=<?php echo $subject_key ?>" class="btn btn-sm btn-delete mx-1">
                                                                    <i class="fa fa-trash"></i>
                                                                </a>
                                                            </td>
                                                            <?php } ?>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                        <?php }} if($flag == false) { ?>
                            <h3 class="text-center mt-4">No Examination Paper Available</h3>    
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

   
<?php $this->load->view("inc/app_footer.php"); ?>