<?php
require '../db_connect.php';
if (isset($_GET['id'])) {
    $qry = $conn->query("SELECT * from tbl_evaluation where id = " . $_GET['id']);
    foreach ($qry->fetch_array() as $k => $val) {
        $$k = $val;
    }
}
?>
<form id="manage-evaluation_01">
    <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
    <div class="form-group">
        <label for="status">Status</label>
        <select class="form-control" name="status" id="status">
            <option selected hidden disabled>Choose</option>
            <option value="0">Pending</option>
            <option value="1">Approve</option>
            <option value="2">Reject</option>
        </select>
    </div>
    <!-- <div class="form-group">
        <label for="service">How satisfied are you with the service provided?</label>
        <select class="form-control" name="service" id="service">
            <option value="1">1 - Very Dissatisfied</option>
            <option value="2">2 - Dissatisfied</option>
            <option value="3">3 - Neutral</option>
            <option value="4">4 - Satisfied</option>
            <option value="5">5 - Very Satisfied</option>
        </select>
    </div>
    <div class="form-group">
        <label for="response">How do you rate the response time of our technician?</label>
        <select class="form-control" name="response" id="response">
            <option value="1">1 - Very Dissatisfied</option>
            <option value="2">2 - Dissatisfied</option>
            <option value="3">3 - Neutral</option>
            <option value="4">4 - Satisfied</option>
            <option value="5">5 - Very Satisfied</option>
        </select>
    </div>
    <div class="form-group">
        <label for="quality">How satisfied are you with the quality of our service?</label>
        <select class="form-control" name="quality" id="quality">
            <option value="1">1 - Very Dissatisfied</option>
            <option value="2">2 - Dissatisfied</option>
            <option value="3">3 - Neutral</option>
            <option value="4">4 - Satisfied</option>
            <option value="5">5 - Very Satisfied</option>
        </select>
    </div>
    <div class="form-group">
        <label for="communication">How do you rate our customer communication?</label>
        <select class="form-control" name="communication" id="communication">
            <option value="1">1 - Very Dissatisfied</option>
            <option value="2">2 - Dissatisfied</option>
            <option value="3">3 - Neutral</option>
            <option value="4">4 - Satisfied</option>
            <option value="5">5 - Very Satisfied</option>
        </select>
    </div>
    <div class="form-group">
        <label for="knowledge">How do you rate the knowledge of our technician in terms of:</label>
        <div class="row">
            <div class="col-md-4">
                <label for="experience">
                    Experience
                </label>
                <select class="form-control" name="experience" id="experience">
                    <option value="1">1 - Very Dissatisfied</option>
                    <option value="2">2 - Dissatisfied</option>
                    <option value="3">3 - Neutral</option>
                    <option value="4">4 - Satisfied</option>
                    <option value="5">5 - Very Satisfied</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="troubleshooting">
                    Troobleshooting
                </label>
                <select class="form-control" name="troubleshooting" id="troubleshooting">
                    <option value="1">1 - Very Dissatisfied</option>
                    <option value="2">2 - Dissatisfied</option>
                    <option value="3">3 - Neutral</option>
                    <option value="4">4 - Satisfied</option>
                    <option value="5">5 - Very Satisfied</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="clean_orderly">
                    Clean & Orderly
                </label>
                <select class="form-control" name="clean_orderly" id="clean_orderly">
                    <option value="1">1 - Very Dissatisfied</option>
                    <option value="2">2 - Dissatisfied</option>
                    <option value="3">3 - Neutral</option>
                    <option value="4">4 - Satisfied</option>
                    <option value="5">5 - Very Satisfied</option>
                </select>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label for="overall">Rate your overall satisfaction with the service.</label>
        <select class="form-control" name="overall" id="overall">
            <option value="1">1 - Very Dissatisfied</option>
            <option value="2">2 - Dissatisfied</option>
            <option value="3">3 - Neutral</option>
            <option value="4">4 - Satisfied</option>
            <option value="5">5 - Very Satisfied</option>
        </select>
    </div>
    <div class="form-group">
        <label for="core_services">What are the main strengths of our services?</label>
        <textarea class="form-control" name="core_services" id="core_services"></textarea>
    </div>
    <div class="form-group">
        <label for="improvement">What areas would we need to improve in terms of our services?</label>
        <textarea class="form-control" name="improvement" id="improvement"></textarea>
    </div> -->
</form>
<script>
    $(document).ready(function() {
        $('#manage-evaluation_01').submit(function(e) {
            e.preventDefault();
            start_load()
            $.ajax({
                url: 'ajax.php?action=save_evaluation_01',
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