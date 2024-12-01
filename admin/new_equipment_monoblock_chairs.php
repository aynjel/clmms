<?php
$room_id = isset($_GET['room_id']) ? $_GET['room_id'] : '';
$category_name = isset($_GET['category_name']) ? $_GET['category_name'] : '';
?>

<form id="equipment_monitor_form">
  <input type="hidden" name="id" value="<?= isset($eq_id) ? $eq_id : '' ?>">
  <input type="hidden" name="room_id" value="<?php echo $room_id ?>">
  <input type="hidden" name="category_name" value="<?php echo $category_name ?>">
  <div class="form-group">
    <label for="green" class="control-label">Green</label>
    <input type="number" name="green" id="green" class="form-control form-control-sm" value="<?= isset($green) ? $green : '' ?>">
  </div>
  <div class="form-group">
    <label for="white" class="control-label">White</label>
    <input type="number" name="white" id="white" class="form-control form-control-sm" value="<?= isset($white) ? $white : '' ?>">
  </div>
  <div class="form-group">
    <label for="yellow" class="control-label">Yellow</label>
    <input type="number" name="yellow" id="yellow" class="form-control form-control-sm" value="<?= isset($yellow) ? $yellow : '' ?>">
  </div>
  <div class="form-group">
    <label for="arm_chair" class="control-label">Arm Chair</label>
    <input type="number" name="arm_chair" id="arm_chair" class="form-control form-control-sm" value="<?= isset($arm_chair) ? $arm_chair : '' ?>">
  </div>
  <div class="form-group">
    <label for="status" class="control-label">Status</label>
    <select name="status" id="status" class="form-control form-control-sm" required>
      <option value="New" <?php echo isset($status) && $status == 'New' ? 'selected' : '' ?>>New</option>
      <option value="Damaged" <?php echo isset($status) && $status == 'Damaged' ? 'selected' : '' ?>>Damaged</option>
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