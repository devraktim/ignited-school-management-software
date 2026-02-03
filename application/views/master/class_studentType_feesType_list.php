<?php $this->load->view("inc/app_header.php"); ?>
    <div class="row mb-5">
        <div class="col-md-6">
            <h1>Fees Head Summary</h1>
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
        <!-- Classes Tab -->
        <ul class="nav nav-pills nav-justified mb-3" id="pills-tab" role="tablist">
            <?php $i = 0; foreach($classes as $class) { $i++ ?>
                <li class="nav-item" role="presentation">
                    <button class="nav-link tab-button" id="pills-tab-<?php echo $i;?>" data-bs-toggle="pill" data-bs-target="#tab-<?php echo $i;?>" type="button" role="tab" aria-controls="pills-<?php echo $class['name'] ?>" aria-selected="false"><?php echo $class['name'] ?></button>
                </li>
            <?php } ?>
        </ul>
    
        <!-- Tab Content for Classes -->
        <div class="tab-content" id="pills-tabContent">
            <?php foreach($records as $record) { ?>
            <div class="tab-pane fade" id="tab-<?php echo $record['class']['id'];?>" role="tabpanel">
                <div class="row">
                    <div class="col-md-6">
                        <?php foreach($record['student_types'] as $student_type) { ?>
                            <div class="card card-flush h-xl-100">
                                <div class="card-body py-9">
                                    <?php if(count($student_type['fees_heads']) > 0) { ?>
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr class="table-dark text-light">
                                                        <th></th>
                                                        <th>Fees Head</th>
                                                        <th>Current Status</th>
                                                        <th>Change Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $k = 0; foreach($student_type['fees_heads'] as $head) { $k++; ?>
                                                        <tr>
                                                            <td class="table-primary text-dark p-2"><?php echo $k; ?></td>
                                                            
                                                            <td><?php echo $head['name']; ?></td>
                                                            
                                                            <?php if($head['status'] == 1) { ?>
                                                                <td>
                                                                    <span class="badge bg-success">Active</span>
                                                                </td>
                                                            <?php } ?>
                                                                                    
                                                            <?php if($head['status'] == 0) { ?>
                                                                <td>
                                                                    <span class="badge bg-danger">Inactive</span>
                                                                </td>
                                                            <?php } ?>
                                                
                                                            <!-- If delete_permission is 0 (meaning it's assigned), hide the action buttons -->
                                                            <?php if ($head['delete_permission'] == 0) { ?>
                                                                <td colspan="3">
                                                                    <span class="text-muted">
                                                                        <i class="fa fa-lock"></i> Locked - Already assigned to student
                                                                    </span>
                                                                </td>
                                                            <?php } else { ?>
                                                                <!-- If delete_permission is not 0, show the action buttons -->
                                                
                                                                <?php if($head['status'] == 1) { ?>
                                                                <td>
                                                                    <a href="<?php echo base_url() ?>masters/assign-fees-types/change-status/<?php echo $record['class']['id'] . '_' . $student_type['type']['id'] . '_' . $head['fees_type_id']?>" 
                                                                        class="btn btn-sm btn-danger" 
                                                                        onclick="return confirm('Are you sure to inactive this fees head?');">
                                                                        Inactive
                                                                    </a>
                                                                </td>
                                                                <?php } ?>
                                                
                                                                <?php if($head['status'] == 0) { ?>
                                                                <td>
                                                                    <a href="<?php echo base_url() ?>masters/assign-fees-types/change-status/<?php echo $record['class']['id'] . '_' . $student_type['type']['id'] . '_' . $head['fees_type_id']?>" 
                                                                        class="btn btn-sm btn-success" 
                                                                        onclick="return confirm('Are you sure to active this fees head?');">
                                                                        Active
                                                                    </a>
                                                                </td>
                                                                <?php } ?>
                                                
                                                                <td>
                                                                    <a href="<?php echo base_url() ?>masters/assign-fees-types/delete/<?php echo $record['class']['id'] . '_' . $student_type['type']['id'] . '_' . $head['fees_type_id']?>" 
                                                                        class="btn btn-sm btn-delete mx-1" 
                                                                        onclick="return confirm('Are you sure to delete this fees head?');">
                                                                        <i class="fa fa-trash"></i>
                                                                    </a>
                                                                </td>
                                                            <?php } ?>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    <?php } else { ?>
                                        <h4 class="text-center">No Data Found</h4>
                                    <?php } ?>
                                </div>
                            </div>
                        <?php } ?>  
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
<?php $this->load->view("inc/app_footer.php"); ?>