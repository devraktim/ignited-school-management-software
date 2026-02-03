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
                        <?php $flag = false; foreach($papers as $paper) { if($paper["class"]["id"] == $class["id"]) { $flag = true;?>
                            <div class="col-md-8 mt-3 mb-3">
                                <div class="card card-flush h-xl-100">
                                    <div class="card-body py-9">
                                        <div class="row mb-3">
                                            <div class="col-md-12 text-center">
                                                <h4 class="text-dark d-block"><?php echo $paper["exam"]["name"] ?> (<?php echo $paper["exam"]["short_name"] ?>)</h4>
                                                
                                                <?php if($paper["paper_type"] == "component") { ?>
                                                    <h1 class="d-inline"><span class="badge rounded-pill bg-primary p-3">Component</span></h1>
                                                <?php } elseif ($paper["paper_type"] == "mark_grade") { ?>
                                                    <h4 class="d-inline"><span class="badge rounded-pill bg-primary p-3">Marks To Grade</span></h4>
                                                <?php } else { ?>
                                                    <h4 class="d-inline"><span class="badge rounded-pill bg-primary p-3">Grade</span></h4>
                                                <?php } ?>
                                                
                                                <a href="<?php echo base_url() ?>academics/examination-paper/edit/<?php echo $paper['id'] ?>" class="btn btn-sm btn-edit text-dark"><i class="fa fa-pencil"></i></a>
                                                
                                                <?php if($this->session->user['permissions'][0]['academics_module'] != "VIEWER" && 
                                                          $this->session->user['permissions'][0]['academics_module'] != "OPERATOR" ) { ?>
                                                <a href="<?php echo base_url() ?>academics/examination-paper/delete/<?php echo $paper['id'] ?>" class="btn btn-sm btn-delete text-dark"><i class="fa fa-trash"></i></a>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-sm table-bordered mt-3">
                                                <thead>
                                                    <tr class="text-center">
                                                        <th><h4 class="text-center">Sl No.</h4></th>
                                                        <th><h4 class="text-center">Subject</h4></th>
                                                        
                                                        <?php if($this->session->user['permissions'][0]['academics_module'] != "VIEWER" && 
                                                                  $this->session->user['permissions'][0]['academics_module'] != "OPERATOR" ) { ?>
                                                        <th><h4 class="text-center">Action</h4></th>
                                                        <?php } ?>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $k = 0; foreach($paper["subjects"] as $subject) { $k++ ?>
                                                        <tr>
                                                            <td class="text-dark text-center" style="padding-left: 5px;"><?php echo $k; ?></td>
                                                            <td class="text-center"><?php echo $subject['name'] ?></td>
                                                            
                                                            <?php if($this->session->user['permissions'][0]['academics_module'] != "VIEWER" && 
                                                                      $this->session->user['permissions'][0]['academics_module'] != "OPERATOR" ) { ?>
                                                            <td class="text-center">
                                                                <a href="<?php echo base_url() ?>academics/examination-paper/remove-subject?id=<?php echo $paper["id"]?>&subject_id=<?php echo $subject['id']?>" class="btn btn-sm btn-delete mx-1">
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
                            <div class="col-md-4 mt-3 mb-3">
                                <div class="card card-flush h-xl-100">
                                    <div class="card-body py-9">
                                        <?php if($paper["paper_type"] == "component") { ?>
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th colspan="2">
                                                            <h4 class="text-center">Component - <?php echo $paper["component"]["name"] ?></h4>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <h5 class="text-center">Full Marks - <?php echo $paper["full_marks"] ?></h5>
                                                        </td>
                                                        <td>
                                                            <h5 class="text-center">Pass Marks - <?php echo $paper["pass_marks"] ?></h5>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        <?php } elseif ($paper["paper_type"] == "mark_grade") { ?>
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th colspan="3">
                                                            <h4 class="text-center">Marks To Grade</h4>
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th>
                                                            <h4 class="text-center">Min</h4>
                                                        </th>
                                                        <th>
                                                            <h4 class="text-center">Max</h4>
                                                        </th>
                                                        <th>
                                                            <h4 class="text-center">Grade</h4>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach($paper["marks"]->marks as $marks) { ?>
                                                        <tr>
                                                            <td>
                                                                <h4 class="text-center"><?php echo $marks->min ?></h4>
                                                            </td>
                                                            <td>
                                                                <h4 class="text-center"><?php echo $marks->max ?></h4>
                                                            </td>
                                                            <td>
                                                                <h4 class="text-center"><?php echo $marks->grade ?></h4>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        <?php } else { ?>
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th colspan="3">
                                                            <h4 class="text-center">Grade</h4>
                                                        </th>
                                                        <tr>
                                                            <td>
                                                                <h4 class="text-center">Name</h4>
                                                            </td>
                                                            <td>
                                                                <h4 class="text-center">Short Name</h4>
                                                            </td>
                                                        </tr>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach($grades as $grade) { ?>
                                                        <tr>
                                                            <td class="text-center">
                                                                <h4><?php echo $grade["name"] ?></h4>
                                                            </td>
                                                            <td class="text-center">
                                                                <h4><?php echo $grade["short_name"] ?></h4>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        <?php }} if($flag == false) { ?>
                            <h3 class="text-center mt-4">No Examination Paper Available</h3>    
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

   
<?php $this->load->view("inc/app_footer.php"); ?>