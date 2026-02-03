<?php $this->load->view("inc/app_header.php"); ?>


    <div class="row mb-5">
        <div class="col-md-3">
            <h1>Class - Sections</h1>
        </div>
        <div class="col-md-2"></div>
        <div class="col-md-3"></div>
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
        <div class="col-md-4"></div>
        <div class="col-md-4 mb-5">
            <div class="card card-flush h-xl-100">
                <div class="card-body py-9">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr class="table-dark text-center">
                                    <th><h4 class="text-light">Class</h4></th>
                                    <th><h4 class="text-light">Section</h4></th>
                                    <th><h4 class="text-light">Action</h4></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($records as $record) { ?>
                                    <?php foreach($record['sections'] as $section) {?>
                                        <tr class="text-center">
                                            <td><h5><?php echo $record['class'] ?></h5></td>
                                            <td><h5><?php echo $section['name'] ?></h5></td>
                                            <td>
                                                <a class="btn btn-sm  btn-delete mx-1" href="<?php echo base_url() ?>masters/class-section/delete/<?php echo $section["class_section_id"] ?>"  onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash"></i></a>
                                            </td>
                                        </tr>    
                                    <?php }?>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php echo form_open(base_url('masters/class-section'), array("method" => "POST")) ?>
        <div class="card card-flush h-xl-100">
            <!--begin::Body-->
            <div class="card-body py-9">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label">Select Class</label>
                            <select class="form-select" name="class_id" required>
                                <option value="">Please Select</option>
                                <?php foreach ($classes as $class) { ?>
                                    <option value="<?php echo $class["id"] ?>"><?php echo $class["name"] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-flush h-xl-100 mt-5">
            <div class="card-body py-9">
                <div class="row">
                    <label class="form-label">Select Sections</label>
                    <div class="col-md-3" id="section_container">
                        <div class="row mb-3 justify-content-between align-items-center">
                            <div class="col-11">
                                <select class="form-select" name="sections[]" required>
                                    <option value="">Please Select</option>
                                    <?php foreach ($sections as $section) { ?>
                                        <option value="<?php echo $section["id"] ?>"><?php echo $section["name"] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-1">
                                <button type="button" class="btn btn-sm btn-danger remove"><i class="fa fa-trash"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-5">
                    <div class="col-md-3 text-center">
                        <button type="button" class="btn btn-sm btn-primary w-75 add"><i class="fa fa-plus"></i></div>
                    </div>
                </div>
                <button type="submit" class="btn btn-success rounded rounded-pill mt-5"><i class="fa fa-plus"></i> Save</button>
            </div>
        </div>
    <?php echo form_close() ?>

    <script>
        $(document).on("click", ".add", function(event) {
            $("#section_container").append(`
                <div class="row mb-3 justify-content-between align-items-center">
                    <div class="col-11">
                        <select class="form-select" name="sections[]" required>
                            <option value="">Please Select</option>
                            <?php foreach ($sections as $section) { ?>
                                <option value="<?php echo $section["id"] ?>"><?php echo $section["name"] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-1">
                        <button class="btn btn-sm btn-danger remove"><i class="fa fa-trash"></i></div>
                    </div>
                </div>
            `)
        })

        $(document).on("click", ".remove", function(event) {
            console.log(event)
            $(this).parent().parent().remove()
        })
    </script>

    <?php $this->load->view("inc/app_footer.php"); ?>