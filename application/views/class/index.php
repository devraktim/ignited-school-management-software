<?php $this->load->view("inc/app_header.php"); ?>

    <div class="row mb-5">
        <div class="col-md-1">
            <h1>Classes</h1>
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal"><i class="fa fa-plus"></i> Add Class</button>
        </div>
        <div class="col-md-5"></div>
        <div class="col-md-4 text-center">
            <?php if($this->session->flashdata('success'))  {?>
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    <strong><?php echo $this->session->flashdata('success')?></strong>
                </div>
            <?php } ?>
        </div>
    </div>

    <div class="card card-flush h-xl-100">
        <!--begin::Body-->
        <div class="card-body py-9">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Class</th>
                            <th>Action</th>

                            <th>Class</th>
                            <th>Action</th>

                            <th>Class</th>
                            <th>Action</th>

                            <th>Class</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $size = count($records);
                            $i = 0;

                            while($i<$size) { 
                        ?>
                            <tr>
                                <?php if($i<$size) { ?>
                                    <td style="font-size: large;"><?php echo $records[$i]["name"]; ?></td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                            <button type="button" class="btn btn-sm  btn-edit mx-1" data-bs-toggle="modal" data-bs-target="#modal_<?php echo $records[$i]["id"] ?>"><i class="fa fa-edit"></i></button>
                                            <a class="btn btn-sm  btn-delete mx-1" href="<?php echo base_url() ?>masters/classes/delete/<?php echo $records[$i]["id"] ?>"  onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash"></i></a>
                                        </div>
                                    </td>
                                    
                                    <div class="modal fade" id="modal_<?php echo $records[$i]["id"] ?>" tabindex="-1" aria-hidden="true">
                                        <!--begin::Modal dialog-->
                                        <div class="modal-dialog">
                                            <!--begin::Modal content-->
                                            <form action="<?php echo base_url() ?>masters/classes/update/<?php echo $records[$i]["id"] ?>" method="POST">
                                                <div class="modal-content rounded">
                                                    <!--begin::Modal header-->
                                                    <div class="modal-header">
                                                        <h2>Edit Class</h2>
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
                                                            <label class="form-label">Class Name</label>
                                                            <input class="form-control" name="class" value="<?php echo $records[$i]["name"] ?>">
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
                                <?php $i++; } ?>

                                <?php if($i<$size) { ?>
                                    <td style="font-size: large;"><?php echo $records[$i]["name"]; ?></td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                        <button type="button" class="btn btn-sm  btn-edit mx-1" data-bs-toggle="modal" data-bs-target="#modal_<?php echo $records[$i]["id"] ?>"><i class="fa fa-edit"></i></button>
                                            <a class="btn btn-sm  btn-delete mx-1" href="<?php echo base_url() ?>masters/classes/delete/<?php echo $records[$i]["id"] ?>"  onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash"></i></a>
                                        </div>
                                    </td>
                                    <div class="modal fade" id="modal_<?php echo $records[$i]["id"] ?>" tabindex="-1" aria-hidden="true">
                                        <!--begin::Modal dialog-->
                                        <div class="modal-dialog">
                                            <!--begin::Modal content-->
                                            <form action="<?php echo base_url() ?>masters/classes/update/<?php echo $records[$i]["id"] ?>" method="POST">
                                                <div class="modal-content rounded">
                                                    <!--begin::Modal header-->
                                                    <div class="modal-header">
                                                        <h2>Edit Class</h2>
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
                                                            <label class="form-label">Class Name</label>
                                                            <input class="form-control" name="class" value="<?php echo $records[$i]["name"] ?>">
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
                                <?php $i++; } ?>

                                <?php if($i<$size) { ?>
                                    <td style="font-size: large;"><?php echo $records[$i]["name"]; ?></td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                            <button type="button" class="btn btn-sm  btn-edit mx-1" data-bs-toggle="modal" data-bs-target="#modal_<?php echo $records[$i]["id"] ?>"><i class="fa fa-edit"></i></button>
                                            <a class="btn btn-sm  btn-delete mx-1" href="<?php echo base_url() ?>masters/classes/delete/<?php echo $records[$i]["id"] ?>"  onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash"></i></a>
                                        </div>
                
                                    </td>
                                    <div class="modal fade" id="modal_<?php echo $records[$i]["id"] ?>" tabindex="-1" aria-hidden="true">
                                        <!--begin::Modal dialog-->
                                        <div class="modal-dialog">
                                            <!--begin::Modal content-->
                                            <form action="<?php echo base_url() ?>masters/classes/update/<?php echo $records[$i]["id"] ?>" method="POST">
                                                <div class="modal-content rounded">
                                                    <!--begin::Modal header-->
                                                    <div class="modal-header">
                                                        <h2>Edit Class</h2>
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
                                                            <label class="form-label">Class Name</label>
                                                            <input class="form-control" name="class" value="<?php echo $records[$i]["name"] ?>">
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
                                <?php $i++; } ?>

                                <?php if($i<$size) { ?>
                                    <td style="font-size: large;"><?php echo $records[$i]["name"]; ?></td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                        <button type="button" class="btn btn-sm  btn-edit mx-1" data-bs-toggle="modal" data-bs-target="#modal_<?php echo $records[$i]["id"] ?>"><i class="fa fa-edit"></i></button>
                                            <a class="btn btn-sm  btn-delete mx-1" href="<?php echo base_url() ?>masters/classes/delete/<?php echo $records[$i]["id"] ?>"  onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash"></i></a>
                                        </div>
                                    </td>
                                    <div class="modal fade" id="modal_<?php echo $records[$i]["id"] ?>" tabindex="-1" aria-hidden="true">
                                        <!--begin::Modal dialog-->
                                        <div class="modal-dialog">
                                            <!--begin::Modal content-->
                                            <form action="<?php echo base_url() ?>masters/classes/update/<?php echo $records[$i]["id"] ?>" method="POST">
                                                <div class="modal-content rounded">
                                                    <!--begin::Modal header-->
                                                    <div class="modal-header">
                                                        <h2>Edit Class</h2>
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
                                                            <label class="form-label">Class Name</label>
                                                            <input class="form-control" name="class" value="<?php echo $records[$i]["name"] ?>">
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
                                <?php $i++; } ?>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!--end::Body-->
    </div>

    <div class="modal fade" id="modal" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog">
            <!--begin::Modal content-->
            <form action="<?php echo base_url() ?>masters/classes" method="POST">
                <div class="modal-content rounded">
                    <!--begin::Modal header-->
                    <div class="modal-header">
                        <h2>Add New Class</h2>
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
                            <label class="form-label">Class Name</label>
                            <input class="form-control" name="class">
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