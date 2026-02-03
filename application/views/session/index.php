<?php $this->load->view("inc/app_header.php"); ?>

    <div class="row mb-5 align-items-center">
        <div class="col-md-1">
          <h1>Session</h1>
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal"><i class="fa fa-plus"></i> New Session</button>
        </div>
    </div>

    <div class="card card-flush h-xl-100">
        <!--begin::Body-->
        <div class="card-body py-9">
            
            <div class="table-responsive">
                <table class="table">
                    <tr class="table-dark text-center text-light">
                        <th>From Date</th>
                        <th>End Date</th>
                        <th>Display Format</th>
                    </tr>
                    <?php foreach($academy_sessions as $session) { ?>
                        <tr class="text-center">
                            <td><?php echo $session["start"] ?></td>
                            <td><?php echo $session["end"] ?></td>
                            <td><?php echo $session["display_format"] ?></td>
                        </tr>
                    <?php } ?>
                </table>
            </div>

        </div>
    </div>


    <div class="modal fade" id="modal" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog">
            <!--begin::Modal content-->
            <form action="<?php echo base_url() ?>masters/sessions" method="POST">
                <div class="modal-content rounded">
                    <!--begin::Modal header-->
                    <div class="modal-header">
                        <h2>Add New Session</h2>
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
                            <label class="form-label">Session Display Format</label>
                            <select class="form-select" name="display_format">
                                <option value="Y">2023-2024</option>
                                <option value="y">23-24</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label">Session Start From</label>
                            <input class="form-control" type="date" name="start">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Session End At</label>
                            <input class="form-control" type="date" name="end">
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