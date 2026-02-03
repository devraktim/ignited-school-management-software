<?php $this->load->view("inc/app_header.php"); ?>

<div class="row mb-5">
    <div class="col-md-6">
        <h1><?php echo isset($exam_paper) ? 'Edit' : 'Set'; ?> Examination Paper</h1>
    </div>
    <div class="col-md-2"></div>
    <div class="col-md-4 text-center">
        <?php if($this->session->flashdata('success'))  { ?>
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                <strong><?php echo $this->session->flashdata('success')?></strong>
            </div>
        <?php } ?>
        <?php if($this->session->flashdata('error'))  { ?>
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                <strong><?php echo $this->session->flashdata('error')?></strong>
            </div>
        <?php } ?>
    </div>
</div>

<?php echo form_open(base_url("academics/set-examination-paper/"), array("method" => "POST")) ?> 

<div class="card card-flush h-xl-100">
    <div class="card-body py-9">
        <div class="row mb-5 align-items-center">
            <div class="col-md-3">
                <div class="form-group">
                    <label class="form-label">Class</label>
                    <select class="form-select" name="class_id">
                        <option value="">Please Select</option>
                        <?php foreach($classes as $class) { ?>
                            <option value="<?php echo $class["id"]?>" <?php echo (isset($exam_paper) && $exam_paper["class_id"] == $class["id"]) ? 'selected' : ''; ?>><?php echo $class["name"]?></option>    
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label class="form-label">Exam</label>
                    <select class="form-select" name="exam_id" <?php echo (isset($exam_paper)) ? '' : 'disabled'; ?>>
                        <option value="">Please Select</option>
                        <?php foreach($exams as $exam) { ?>
                            <option value="<?php echo $exam["id"]?>" <?php echo (isset($exam_paper) && $exam_paper["exam_id"] == $exam["id"]) ? 'selected' : ''; ?>><?php echo $exam["name"]?> (<?php echo $exam["short_name"]?>)</option>    
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">Paper Type</label>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="paper_type" value="component" <?php echo (isset($exam_paper) && $exam_paper["paper_type"] == 'component') ? 'checked' : ''; ?>>
                                <label class="form-check-label">Component</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="paper_type" value="grade" <?php echo (isset($exam_paper) && $exam_paper["paper_type"] == 'grade') ? 'checked' : ''; ?>>
                                <label class="form-check-label">Grade</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="paper_type" value="mark_grade" <?php echo (isset($exam_paper) && $exam_paper["paper_type"] == 'mark_grade') ? 'checked' : ''; ?>>
                                <label class="form-check-label">Marks-Grade</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="form-group">
                    <h4 class="mb-3" id="subject_title" style="display:none;">Subject</h4>
                    <div id="subjects">
                        <?php foreach ($subjects as $subject) { ?>
                            <div class="form-check mb-4">
                                <input class="form-check-input" type="checkbox" name="subject[]" value="<?php echo $subject['id']; ?>" 
                                    <?php echo (isset($exam_paper) && in_array($subject['id'], explode(",", $exam_paper["subjects"]))) ? 'checked' : ''; ?>>
                                <label class="form-check-label"><?php echo $subject["name"]; ?></label>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <!-- Component Section -->
                <div id="component" style="display: <?php echo (isset($exam_paper) && $exam_paper["paper_type"] == 'component') ? 'block' : 'none'; ?>;">
                    <div class="form-group">
                        <label class="form-label">Select Component</label>
                        <select class="form-select" name="component_id">
                            <option value="">Please Select</option>
                            <?php foreach ($components as $component) { ?>
                                <option value="<?php echo $component["id"] ?>" <?php echo (isset($exam_paper) && isset($exam_paper["marks"]["component_id"]) && $exam_paper["marks"]["component_id"] == $component["id"]) ? 'selected' : ''; ?>><?php echo $component["name"] ?></option>
                            <?php } ?>
                        </select>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <label class="form-label">Full Marks</label>
                                <input type="text" class="form-control" name="full_marks" value="<?php echo (isset($exam_paper) && isset($exam_paper["marks"]["marks"]["full_marks"])) ? $exam_paper["marks"]["marks"]["full_marks"] : ''; ?>" />
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Pass Marks</label>
                                <input type="text" class="form-control" name="pass_marks" value="<?php echo (isset($exam_paper) && isset($exam_paper["marks"]["marks"]["pass_marks"])) ? $exam_paper["marks"]["marks"]["pass_marks"] : ''; ?>" />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Mark Grade Section -->
                <div id="mark_grade" style="display: <?php echo (isset($exam_paper) && $exam_paper["paper_type"] == 'mark_grade') ? 'block' : 'none'; ?>;">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Min</th>
                                <th>Max</th>
                                <th>Grade</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($exam_paper) && isset($exam_paper["marks"]['marks'])): ?>
                                <?php foreach ($exam_paper["marks"]['marks'] as $mark): ?>
                                    <tr>
                                        <td><input type="text" class="form-control" name="min[]" value="<?php echo $mark['min']; ?>" /></td>
                                        <td><input type="text" class="form-control" name="max[]" value="<?php echo $mark['max']; ?>" /></td>
                                        <td><input type="text" class="form-control" name="grade[]" value="<?php echo $mark['grade']; ?>" /></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card-footer d-flex justify-content-between">
    <button class="btn btn-primary" type="submit">Save</button>
    <a href="<?php echo base_url('academics/set-examination-paper/create'); ?>" class="btn btn-light">Cancel</a>
</div>

<?php echo form_close(); ?>

    <script>
        $("input[name='paper_type']").change(function () {
            const paper_type = $("input[name='paper_type']:checked").val()

            if(paper_type == "component") {
                $("#component").show()
                $("#mark_grade").hide()
            }

            if(paper_type == "mark_grade") {
                $("#component").hide()
                $("#mark_grade").show()
            }

            if(paper_type == "grade") {
                $("#component").hide()
                $("#mark_grade").hide()
            }
        })

        $(".add").click(function(event) {
            $("#mark_grade table tbody").append(`
                <tr>
                    <td>
                        <input type="text" class="form-control" name="min[]" />
                    </td>
                    <td>
                        <input type="text" class="form-control" name="max[]" />
                    </td>
                    <td>
                        <input type="text" class="form-control" name="grade[]" />
                    </td>
                    <td style="vertical-align: middle;">
                        <button type="button" class="btn btn-sm btn-delete remove"><i class="fa fa-trash"></i></div>
                    </td>
                </tr>
            `)
        })

        $(document).on("click", ".remove", function(event) {
            $(this).parent().parent().remove()
        })

        $("select[name='class_id']").change(function() {
            const class_id = $("select[name='class_id']").val()

            if(class_id != "") {
                $("select[name='exam_id']").removeAttr("disabled")
            }
        })

        $("select[name='exam_id']").change(function() {
            const class_id = $("select[name='class_id']").val()
            const exam_id = $("select[name='exam_id']").val()

            if(exam_id != "") {
                $("input[name='paper_type']").removeAttr("disabled")
            }

            $("#subjects").empty();
            $("#subject_title").hide();

            fetch(`<?php echo base_url()?>academics/set-examination-paper/search?class_id=${class_id}&exam_id=${exam_id}`)
            .then(response => response.json())
            .then(data => {
                $("#subject_title").show();   
                data.forEach(data => {
                    $("#subjects").append(`
                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" name="subject[]" value="${data.id}">
                            <label class="form-check-label">${data.name}</label>
                        </div>
                    `)
                })
                
            })
            .catch(console.log)
        })
    </script>
<?php $this->load->view("inc/app_footer.php"); ?>