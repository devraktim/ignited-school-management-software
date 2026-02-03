<?php $this->load->view("inc/app_header.php"); ?>

<style>
    .row-updated {
        background-color: #cfe2ff !important; /* Bootstrap primary light */
        transition: background-color 0.8s ease-in-out;
    }
    
    .row-blink {
        animation: blinkBg 0.6s ease-in-out 2;
    }
    
    @keyframes blinkBg {
        0%   { background-color: #ffffff; }
        50%  { background-color: #9ec5fe; } /* Bootstrap primary soft */
        100% { background-color: #ffffff; }
    }
    
    #holidayTable td {
        padding: 10px 12px; /* little padding */
        vertical-align: middle;
    }

    #holidayTable input.form-control-sm {
        padding: 6px 10px; /* input inner padding */
    }
</style>

<div class="container mt-4">
    <h2>Personnel Holidays</h2>
    
    <div class="card card-flush h-xl-100">
        <div class="card-body py-9">
            <div id="alert-box"></div>
            
            <table class="table table-bordered" id="holidayTable">
                <thead class="table-dark">
                    <tr>
                        <th class="px-2">Holiday Name</th>
                        <th class="px-2">Holiday Date</th>
                        <th width="120">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($holidays as $h) { ?>
                        <tr data-id="<?= $h['id'] ?>">
                            <td>
                                <input type="text" class="form-control form-control-sm name"
                                       value="<?= $h['name'] ?>">
                            </td>
                            <td>
                                <input type="date" class="form-control form-control-sm date"
                                       value="<?= $h['holiday_date'] ?>">
                            </td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-success mx-2 save"><i class="fa fa-save"></i></button>
                                    <button class="btn btn-danger delete"><i class="fa fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        
            <button class="btn btn-primary" id="addRow">
                <i class="fa fa-plus"></i> Add Holiday
            </button>
        </div>
    </div>
</div>

<script>
$(document).ready(function () {

    function showAlert(msg, type="success") {
        $("#alert-box").html(
            `<div class="alert alert-${type} alert-dismissible fade show">
                ${msg}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>`
        );
    }

    // Add new row
    $("#addRow").click(function () {
        $("#holidayTable tbody").append(`
            <tr class="new px-3">
                <td>
                    <input 
                        type="text" 
                        class="form-control form-control-sm name" 
                        placeholder="Holiday Name">
                </td>
                <td>
                    <input 
                        type="date" 
                        class="form-control form-control-sm date">
                </td>
                <td class="text-center">
                    <div class="btn-group btn-group-sm" role="group">
                        <button type="button" class="btn btn-success mx-2 save">
                            <i class="fa fa-save"></i>
                        </button>
                        <button type="button" class="btn btn-danger delete">
                            <i class="fa fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
        `);
    });


    // Save (Insert / Update)
    $(document).on("click", ".save", function () {
        let row = $(this).closest("tr");
        let id = row.data("id");
    
        let name = row.find(".name").val();
        let date = row.find(".date").val();
    
        if (!name || !date) {
            showAlert("Please fill all fields", "warning");
            return;
        }
    
        let url = id
            ? "<?= base_url('masters/holidays/update/') ?>" + id
            : "<?= base_url('masters/holidays') ?>";
    
        $.post(url, { name, holiday_date: date }, function (res) {
            let r = JSON.parse(res);
            showAlert(r.message);
    
            // NEW UX EFFECT 👇
            row.removeClass("row-updated row-blink");
            void row[0].offsetWidth; // reset animation
    
            row.addClass("row-blink");
    
            setTimeout(function () {
                row.addClass("row-updated");
            }, 600);
    
            if (!id && r.id) {
                row.attr("data-id", r.id);
                row.removeClass("new");
            }
        });
    });
    
    // Delete
    $(document).on("click", ".delete", function () {
        let row = $(this).closest("tr");
        let id = row.data("id");

        if (!id) {
            row.remove();
            return;
        }

        if (!confirm("Delete this holiday?")) return;

        $.post("<?= base_url('masters/holidays/delete/') ?>" + id, function (res) {
            let r = JSON.parse(res);
            showAlert(r.message, "danger");
            row.remove();
        });
    });

});
</script>

<?php $this->load->view("inc/app_footer.php"); ?>
