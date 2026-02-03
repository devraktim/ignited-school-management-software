<?php $this->load->view("inc/app_header.php"); ?>

    <div class="row mb-5">
        <div class="col-md-6">
            <h1>Security Reports</h1>
        </div>
    </div>

    <div class="row mb-5">
        <div class="col-md-6 mb-5">
            <div class="card card-flush h-xl-100">
                <div class="card-body py-9">
                    <div class="buttons">
                        <button class="btn btn-primary" id="active_user_list">Active User List</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-5">
            <div class="card card-flush h-xl-100">
                <div class="card-body py-9">
                    <div class="buttons">
                        <button class="btn btn-info" id="inactive_user_list">Inactive User List</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $("#active_user_list").click(function(){
            window.open('<?php echo base_url() ?>security/users/generate-report?status=ACTIVE','name','width=600,height=400')
        })

        $("#inactive_user_list").click(function(){
            window.open('<?php echo base_url() ?>security/users/generate-report?status=IN ACTIVE','name','width=600,height=400')
        })
    </script>

<?php $this->load->view("inc/app_footer.php"); ?>