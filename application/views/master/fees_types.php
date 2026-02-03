<?php $this->load->view("inc/app_header.php"); ?>

    <div class="row mb-5">
        <!-- Column for the header, aligned to the left -->
        <div class="col-md-6 d-flex align-items-center">
            <h1 class="mb-0">School/ Boarding Fees Head</h1>
        </div>
    
        <!-- Column for the button, aligned to the right -->
        <div class="col-md-6 text-end">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal">
                <i class="fa fa-plus"></i> Add Fees Head
            </button>
        </div>
    </div>
    
    <!-- Alert positioned at the top-right corner using fixed positioning -->
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 1050;">
        <?php if ($this->session->flashdata('success')) { ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                <strong><?php echo $this->session->flashdata('success') ?></strong>
            </div>
        <?php } ?>
    </div>


    <div class="row">
        <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="card card-flush h-xl-100">
                    <!--begin::Body-->
                    <div class="card-body py-9">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr class="table-dark text-center">
                                        <th>
                                            <h4 class="text-light">Fees Head</h4>
                                        </th>
                                       
                                        <th>
                                            <h4 class="text-light">Action</h4>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($records as $record) { ?>
                                        <tr>
                                            <td style="font-size: large;"><?php echo $record["name"]; ?></td>
                                            
                                          
                                            
                                            <td class="text-end">
                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-sm btn-edit mx-1" data-bs-toggle="modal" data-bs-target="#modal_<?php echo $record["id"] ?>"><i class="fa fa-edit"></i></button>
                                                    <a class="btn btn-sm btn-delete mx-1" href="<?php echo base_url() ?>masters/fees-types/delete/<?php echo $record["id"] ?>" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash"></i></a>
                                                </div>
                                            </td>
                                            
                                            <div class="modal fade" id="modal_<?php echo $record["id"] ?>" tabindex="-1" aria-hidden="true">
                                                <!--begin::Modal dialog-->
                                                <div class="modal-dialog">
                                                    <!--begin::Modal content-->
                                                    <form action="<?php echo base_url() ?>masters/fees-types/update/<?php echo $record["id"] ?>" method="POST">
                                                        <div class="modal-content rounded">
                                                            <!--begin::Modal header-->
                                                            <div class="modal-header">
                                                                <h2>Edit Fees Head</h2>
                                                                <!--begin::Close-->
                                                                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                                                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                                                                    <span class="svg-icon svg-icon-1">
                                                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                                                                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
                                                                        </svg>
                                                                    </span>
                                                                    <!--end::Svg Icon-->
                                                                </div>
                                                                <!--end::Close-->
                                                            </div>
                                                            <!--end::Modal header-->
                                                            
                                                            <!--begin::Modal body-->
                                                            <div class="modal-body">
                                                                <div class="form-group mb-3">
                                                                    <label class="form-label">Fees Head Name</label>
                                                                    <input class="form-control" name="fees_type" value="<?php echo $record["name"] ?>">
                                                                </div>
                                                                
                                                                <div class="form-group mb-3">
                                                                    <label class="form-label">Fees Head Status</label>
                                                                </div>
                                                            </div>
                                                            <!--end::Modal body-->
                                                            
                                                            <!--end::Modal Footer-->
                                                            <div class="modal-footer">
                                                                <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
                                                                <input type="reset" class="btn btn-warning" value="Reset">
                                                            </div>
                                                            <!--end::Modal Footer-->
                                                        </div>
                                                    <!--end::Modal content-->
                                                    </form>
                                                </div>
                                                <!--end::Modal dialog-->
                                            </div>
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
    
    <div class="modal fade" id="modal" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog">
            <!--begin::Modal content-->
            <form action="<?php echo base_url() ?>masters/fees-types" method="POST">
                <div class="modal-content rounded">
                    <!--begin::Modal header-->
                    <div class="modal-header">
                        <h2>Add New Fees Head</h2>
                        <!--begin::Close-->
                        <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                            <span class="svg-icon svg-icon-1">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                                    <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                        </div>
                        <!--end::Close-->
                    </div>
                    <!--end::Modal header-->
                    
                    <!--begin::Modal body-->
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="form-label">Fees Head Name</label>
                            <input class="form-control" name="fees_type">
                        </div>
                    </div>
                    <!--end::Modal body-->
                    
                    <!--end::Modal Footer-->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success"><i class="fa fa-plus"></i> Save</button>
                        <input type="reset" class="btn btn-warning" value="Reset">
                    </div>
                    <!--end::Modal Footer-->
                </div>
            <!--end::Modal content-->
            </form>
        </div>
        <!--end::Modal dialog-->
    </div>

    <?php $this->load->view("inc/app_footer.php"); ?>