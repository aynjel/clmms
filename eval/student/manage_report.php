<?php
require '../db_connect.php';
if (isset($_GET['id'])) {
  $qry = $conn->query("SELECT * from tb_data where id = " . $_GET['id']);
  foreach ($qry->fetch_array() as $k => $val) {
    $$k = $val;
  }
}
?>
<form action="" id="manage-report">
  <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">

  <div class="row">
    <div class="col-md-12">
      <div class="form-group" hidden>
        <label for="" class="control-label">Section</label>
        <div class="form-check">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="languages[]" value="Civil and Sanitary" id="civil_and_sanitary" <?php echo isset($languages) && in_array('Civil and Sanitary', explode(',', $languages)) ? 'checked' : '' ?>>
            <label class="form-check-label" for="civil_and_sanitary">
              Civil and Sanitary
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="languages[]" value="Electrical" id="electrical" <?php echo isset($languages) && in_array('Electrical', explode(',', $languages)) ? 'checked' : '' ?>>
            <label class="form-check-label" for="electrical">
              Electrical
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="languages[]" value="Mechanical" id="mechanical" <?php echo isset($languages) && in_array('Mechanical', explode(',', $languages)) ? 'checked' : '' ?>>
            <label class="form-check-label" for="mechanical">
              Mechanical
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="languages[]" value="Electronic and Communication" id="electronic_and_communication" <?php echo isset($languages) && in_array('Electronic and Communication', explode(',', $languages)) ? 'checked' : '' ?>>
            <label class="form-check-label" for="electronic_and_communication">
              Electronic and Communication
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="languages[]" value="ICT" id="ict" <?php echo isset($languages) && in_array('ICT', explode(',', $languages)) ? 'checked' : '' ?>>
            <label class="form-check-label" for="ict">
              ICT
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="languages[]" value="Others" id="others" <?php echo isset($languages) && in_array('Others', explode(',', $languages)) ? 'checked' : '' ?>>
            <label class="form-check-label" for="others">
              Others
            </label>
          </div>
        </div>
      </div>
      <div class="form-group" hidden>
        <label for="" class="control-label">Description</label>
        <textarea name="description" id="" cols="30" rows="4" class="form-control" required><?php echo isset($description) ? $description : '' ?></textarea>
      </div>
      <div class="form-group" hidden>
        <label for="" class="control-label">Date/Time</label>
        <input type="datetime-local" class="form-control" name="date" value="<?php echo isset($date) ? date("Y-m-d\TH:i:s", strtotime($date)) : '' ?>" required>
      </div>
      <div class="form-group">
        <label for="" class="control-label">Status</label>
        <select name="status" id="" class="custom-select" required>
          <option value="1" <?php echo isset($status) && $status == 1 ? 'selected' : '' ?>>Under Process</option>
          <option value="0" <?php echo isset($status) && $status == 0 ? 'selected' : '' ?>>Accomplished</option>
        </select>
      </div>
    </div>
  </div>
</form>
<script>
  $(document).ready(function() {
    $('#manage-report').submit(function(e) {
      e.preventDefault()
      start_load()
      $.ajax({
        url: 'ajax.php?action=save_report',
        method: 'POST',
        data: new FormData($(this)[0]),
        processData: false,
        contentType: false,
        cache: false,
        success: function(resp) {
          if (resp == 1) {
            alert_toast("Data successfully saved", 'success')
            setTimeout(function() {
              location.reload()
            }, 1500)
          }
        }
      })
    })
  })
</script>