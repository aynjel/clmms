<?php
require '../db_connect.php';
if (isset($_GET['id'])) {
    $qry = $conn->query("SELECT * from tb_report where id = " . $_GET['id']);
    foreach ($qry->fetch_array() as $k => $val) {
        $$k = $val;
    }
}
?>
<form id="manage-report">
    <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
    <div class="row">
        <div class="form-group col-md-6">
            <label for="area">Office / Area</label>
            <input type="text" name="area" id="area" class="form-control" value="<?php echo isset($area) ? $area : '' ?>">
        </div>
        <div class="form-group col-md-6">
            <label for="date">Date of Inspection</label>
            <input type="date" name="date" id="date" class="form-control" value="<?php echo isset($date) ? $date : '' ?>">
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-6">
            <label for="area">Machine / Equipment / Facility</label>
            <input type="text" name="equipment" id="machine" class="form-control" value="<?php echo isset($equipment) ? $equipment : '' ?>">
        </div>
        <div class="form-group col-md-6">
            <label for="date">Status, Condition, Problem</label>
            <input type="text" name="status" id="status" class="form-control" value="<?php echo isset($status) ? $status : '' ?>">
        </div>
    </div>
</form>
<script>
    $(document).ready(function() {
        $('#manage-report').submit(function(e) {
            e.preventDefault();
            start_load()
            $.ajax({
                url: 'ajax.php?action=save_report_fa1',
                method: 'POST',
                data: $(this).serialize(),
                success: function(resp) {
                    if (resp == 1) {
                        alert_toast("Data successfully saved.", "success");
                        setTimeout(function() {
                            location.reload()
                        }, 1750)
                    }
                }
            })
        })
    })
</script>