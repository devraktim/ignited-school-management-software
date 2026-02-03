<?php $this->load->view("inc/app_header.php"); ?>

    <div class="row mb-5">
        <div class="col-md-3">
            <h1>Withdrawn Reasons</h1>
        </div>
        <div class="col-md-3">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal"><i class="fa fa-plus"></i> Add Withdrawn Reason</button>
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


    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <div class="card card-flush h-xl-100">
                <div class="card-body py-9">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr class="table-dark text-center">
                                    <th>
                                        <h4 class="text-light">Withdrawal Reason</h4>
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
                                                <a class="btn btn-sm btn-delete mx-1" href="<?php echo base_url() ?>masters/withdrawal-reason/delete/<?php echo $record["id"] ?>" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash"></i></a>
                                            </div>
                                        </td>
                                        
                                        <div class="modal fade" id="modal_<?php echo $record["id"] ?>" tabindex="-1" aria-hidden="true">
                                            <!--begin::Modal dialog-->
                                            <div class="modal-dialog">
                                                <!--begin::Modal content-->
                                                <form action="<?php echo base_url() ?>masters/withdrawal-reason/update/<?php echo $record["id"] ?>" method="POST">
                                                    <div class="modal-content rounded">
                                                        <!--begin::Modal header-->
                                                        <div class="modal-header">
                                                            <h2>Edit Withdrawal Reason</h2>
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
                                                                <label class="form-label">Withdrawal-reason</label>
                                                                <input class="form-control" name="withdrawal_reason" value="<?php echo $record["name"] ?>">
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


    <div class="modal fade" id="modal" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog">
            <!--begin::Modal content-->
            <form action="<?php echo base_url() ?>masters/withdrawal-reason" method="POST">
                <div class="modal-content rounded">
                    <!--begin::Modal header-->
                    <div class="modal-header">
                        <h2>Add New Withdrawal Reason</h2>
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
                            <label class="form-label">Withdrawal Reason</label>
                            <input class="form-control" name="withdrawal_reason">
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