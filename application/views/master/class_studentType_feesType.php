<?php $this->load->view("inc/app_header.php"); ?>
    <div class="row mb-5">
        <div class="col-md-3">
            <h1>Assign Fees Head</h1>
        </div>
        <div class="col-md-2">
           
        </div>
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


    <?php echo form_open(base_url("masters/assign-fees-types"), array("method" => "POST", "id" => "form")) ?> 
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card card-flush h-xl-100 mt-5">
                    <table class="table table-bordered">
                        <thead>
                            <tr class="table-dark text-light">
                                <th>
                                    <input type="checkbox" id="check-all-class" class="form-check-input ms-2" />
                                </th>
                                <th>Class</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($classes as $class) { ?>
                                <tr>
                                    <td class="table-primary text-dark p-2">
                                        <input 
                                            type="checkbox" 
                                            name="class_ids[]" 
                                            value="<?php echo $class['id'] ?>" 
                                            class="form-check-input"
                                        />
                                    </td>
                                    <td><?php echo $class['name'] ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card card-flush h-xl-100 mt-5">
                    <table class="table table-bordered">
                        <thead>
                            <tr class="table-dark text-light">
                                <th>
                                    <input type="checkbox" id="check-all-stydent-type" class="form-check-input ms-2" />
                                </th>
                                <th>Student Type</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($student_types as $student_type) { ?>
                                <tr>
                                    <td class="table-primary text-dark p-2">
                                        <input 
                                            type="checkbox" 
                                            name="student_type_ids[]" 
                                            value="<?php echo $student_type['id'] ?>" 
                                            class="form-check-input" />
                                    </td>
                                    <td><?php echo $student_type['name'] ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-flush h-xl-100 mt-5">
                    <table class="table table-bordered">
                        <thead>
                            <tr class="table-dark text-light">
                                <th>
                                    <input type="checkbox" id="check-all-fees" class="form-check-input ms-2" />
                                </th>
                                <th>Fees Type</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($fees_types as $fees_type) { ?>
                                <tr>
                                    <td class="table-primary text-dark p-2">
                                        <input type="checkbox" name="fees_ids[]" value="<?php echo $fees_type['id'] ?>" class="form-check-input" <?php if(in_array($fees_type['id'], $records)) { echo "checked"; };  ?>/>
                                    </td>
                                    <td><?php echo $fees_type['name'] ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="text-end mt-5">
            <button type="button" id="submit-btn" class="btn btn-success">Save</button>
        </div>
    <?php echo form_close() ?> 

    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const submitBtn = document.getElementById("submit-btn");
            const myform = document.getElementById("form");
            
            const classCheckboxes = document.querySelectorAll('input[name="class_ids[]"]');
            const studentTypeCheckboxes = document.querySelectorAll('input[name="student_type_ids[]"]');
            const feeTypeCheckboxes = document.querySelectorAll('input[name="fees_ids[]"]');
        
            function validateForm() {
                let isValid = true;
        
                const classSelected = Array.from(classCheckboxes).some(cb => cb.checked);
                const studentSelected = Array.from(studentTypeCheckboxes).some(cb => cb.checked);
                const feeSelected = Array.from(feeTypeCheckboxes).some(cb => cb.checked);
                
                console.log(studentSelected)
        
                if (!classSelected) {
                    alert("Please select a class to save the record.");
                    isValid = false;
                    return;
                }
        
                if (!studentSelected) {
                    alert("Please select a student type to save the record.");
                    isValid = false;
                    return;
                }
        
                if (!feeSelected) {
                    alert("Please select a fees type to save the record.");
                    isValid = false;
                    return;
                }
        
                myform.submit()
            }
            
            submitBtn.addEventListener("click", function () {
                validateForm();
            });

        });
    </script>


    <script>
        $(document).ready(function() {
            $('#check-all-class').on('change', function() {
                var isChecked = $(this).is(':checked');
                $('input[name="class_ids[]"]').each(function() {
                    $(this).prop('checked', isChecked);
                });
            });
            
            $('#check-all-stydent-type').on('change', function() {
                var isChecked = $(this).is(':checked');
                $('input[name="student_type_ids[]"]').each(function() {
                    $(this).prop('checked', isChecked);
                });
            });
            
            $('#check-all-fees').on('change', function() {
                var isChecked = $(this).is(':checked');
                $('input[name="fees_ids[]"]').each(function() {
                    $(this).prop('checked', isChecked);
                });
            });
        });
    </script>
    
<?php $this->load->view("inc/app_footer.php"); ?>