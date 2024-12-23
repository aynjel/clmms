<?php
$room_id = isset($_GET['room_id']) ? $_GET['room_id'] : '';
$category_name = isset($_GET['category_name']) ? $_GET['category_name'] : '';
?>

<form id="equipment_monitor_form">
  <input type="hidden" name="id" value="<?= isset($eq_id) ? $eq_id : '' ?>">
  <input type="hidden" name="room_id" value="<?php echo $room_id ?>">
  <input type="hidden" name="category_name" value="<?php echo $category_name ?>">
  <div class="form-group">
    <label for="monitor_number" class="control-label">Monitor Number</label>
    <input type="number" name="monitor_number" id="monitor_number" class="form-control form-control-sm" value="<?= isset($monitor_number) ? $monitor_number : '' ?>">
  </div>
  <div class="form-group">
    <label for="manufacturer" class="control-label">Manufacturer</label>
    <input type="text" id="manufacturer" class="form-control form-control-sm" name="manufacturer" value="<?= isset($manufacturer) ? $manufacturer : '' ?>">
  </div>
  <div class="form-group">
    <label for="serial_no" class="control-label">Serial No.</label>
    <input type="text" id="serial_no" class="form-control form-control-sm" name="serial_no" value="<?= isset($serial_no) ? $serial_no : '' ?>">
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