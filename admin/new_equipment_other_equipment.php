<?php
$room_id = isset($_GET['room_id']) ? $_GET['room_id'] : '';
$category_id = isset($_GET['category_id']) ? $_GET['category_id'] : '';
?>

<form id="equipment_monitor_form">
  <input type="hidden" name="id" value="<?= isset($eq_id) ? $eq_id : '' ?>">
  <input type="hidden" name="room_id" value="<?php echo $room_id ?>">
  <input type="hidden" name="category_id" value="<?php echo $category_id ?>">
  <div class="form-group">
    <label for="smart_tv" class="control-label">Smart TV</label>
    <input type="number" name="smart_tv" id="smart_tv" class="form-control form-control-sm" value="<?= isset($smart_tv) ? $smart_tv : '' ?>">
  </div>
  <div class="form-group">
    <label for="switch" class="control-label">Switch</label>
    <input type="number" id="switch" class="form-control form-control-sm" name="switch" value="<?= isset($switch) ? $switch : '' ?>">
  </div>
  <div class="form-group">
    <label for="air_condition_unit" class="control-label">Air Condition Unit</label>
    <input type="number" id="air_condition_unit" class="form-control form-control-sm" name="air_condition_unit" value="<?= isset($air_condition_unit) ? $air_condition_unit : '' ?>">
  </div>
  <div class="form-group">
    <label for="printer" class="control-label">Printer</label>
    <input type="number" id="printer" class="form-control form-control-sm" name="printer" value="<?= isset($printer) ? $printer : '' ?>">
  </div>
  <div class="form-group">
    <label for="status" class="control-label">Status</label>
    <select name="status" id="status" class="form-control form-control-sm" required>
      <option value="Functional" <?php echo isset($status) && $status == 'Functional' ? 'selected' : '' ?>>Functional</option>
      <option value="Not Functional" <?php echo isset($status) && $status == 'Not Functional' ? 'selected' : '' ?>>Not Functional</option>
    </select>
  </div>
  <hr>
  <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i> Save</button>
</form>

<script>
  $('#equipment_monitor_form').submit(function(e) {
    e.preventDefault();

    $.ajax({
      url: 'ajax.php?action=save_equipment',
      method: 'POST',
      data: $(this).serialize(),
      success: function(resp) {
        if (resp == 1) {
          alert_toast("Data successfully saved", 'success')
          setTimeout(function() {
            window.location.href = 'index.php?page=equipment_list&room_id=<?= $room_id ?>'
          }, 1500)
        }
      }
    })
  })
</script>