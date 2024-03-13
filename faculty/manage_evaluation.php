<?php
require '../db_connect.php';
if (isset($_GET['id'])) {
    $qry = $conn->query("SELECT * from tb_data where id = " . $_GET['id']);
    foreach ($qry->fetch_array() as $k => $val) {
        $$k = $val;
    }
}
?>
<form id="manage-evaluation_01">
    <p>
        <i><b>Thank You</b> for rating the Customer Satisfaction Survey. The survey should take less than 5 minutes of your time to complete. Please rate your satisfaction level with each of the following statements. Your feedback is important to us and will help us to improve our services.</i>
    </p>

    <ul style="list-style-type: none; padding: 0; display: flex; justify-content: space-between;">
        <li>1 - Very Dissatisfied</li>
        <li>2 - Dissatisfied</li>
        <li>3 - Neutral</li>
        <li>4 - Satisfied</li>
        <li>5 - Very Satisfied</li>
    </ul>

    <hr>

    <input type="hidden" name="id" value="<?= isset($id) ? $id : '' ?>">
    <div class="form-group">
        <label for="report_id">Select Report to Evaluate</label>
        <select class="form-control" name="report_id" id="report_id">
            <option selected disabled hidden>Select Report</option>
            <?php
            $qry = $conn->query("SELECT * from tb_data WHERE status = 0 AND faculty_id IS NOT NULL ORDER BY date DESC");
            while ($row = $qry->fetch_assoc()) :
            ?>
                <option value="<?= $row['id'] ?>" <?= isset($report_id) && $report_id == $row['id'] ? 'selected' : '' ?> title="<?= $row['languages'] ?> - <?= $row['description'] ?>"><?= $row['languages'] ?> - <?= $row['description'] ?></option>
            <?php endwhile; ?>
        </select>
    </div>
    <div class="form-group">
        <label for="service">How satisfied are you with the service provided?</label>
        <select class="form-control" name="service" id="service" required>
            <option value="1">1 - Very Dissatisfied</option>
            <option value="2">2 - Dissatisfied</option>
            <option value="3">3 - Neutral</option>
            <option value="4">4 - Satisfied</option>
            <option value="5">5 - Very Satisfied</option>
        </select>
    </div>
    <div class="form-group">
        <label for="response">How do you rate the response time of our technician?</label>
        <select class="form-control" name="response" id="response" required>
            <option value="1">1 - Very Dissatisfied</option>
            <option value="2">2 - Dissatisfied</option>
            <option value="3">3 - Neutral</option>
            <option value="4">4 - Satisfied</option>
            <option value="5">5 - Very Satisfied</option>
        </select>
    </div>
    <div class="form-group">
        <label for="quality">How satisfied are you with the quality of our service?</label>
        <select class="form-control" name="quality" id="quality" required>
            <option value="1">1 - Very Dissatisfied</option>
            <option value="2">2 - Dissatisfied</option>
            <option value="3">3 - Neutral</option>
            <option value="4">4 - Satisfied</option>
            <option value="5">5 - Very Satisfied</option>
        </select>
    </div>
    <div class="form-group">
        <label for="communication">How do you rate our customer communication?</label>
        <select class="form-control" name="communication" id="communication" required>
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
                <select class="form-control" name="experience" id="experience" required>
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
                <select class="form-control" name="troubleshooting" id="troubleshooting" required>
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
                <select class="form-control" name="clean_orderly" id="clean_orderly" required>
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
        <select class="form-control" name="overall" id="overall" required>
            <option value="1">1 - Very Dissatisfied</option>
            <option value="2">2 - Dissatisfied</option>
            <option value="3">3 - Neutral</option>
            <option value="4">4 - Satisfied</option>
            <option value="5">5 - Very Satisfied</option>
        </select>
    </div>
    <div class="form-group">
        <label for="core_services">What are the main strengths of our services?</label>
        <textarea class="form-control" name="core_services" id="core_services" required></textarea>
    </div>
    <div class="form-group">
        <label for="improvement">What areas would we need to improve in terms of our services?</label>
        <textarea class="form-control" name="improvement" id="improvement" required></textarea>
    </div>
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
                        alert_toast("Thank you for responding to our survey.", "success");
                        setTimeout(function() {
                            location.reload()
                        }, 1850)
                    }
                }
            })
        })
    })
</script>