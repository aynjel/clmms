<?php
$room_id = isset($_GET['room_id']) ? $_GET['room_id'] : $data->room_id;
$category_id = isset($_GET['category_id']) ? $_GET['category_id'] : $data->category_id;;
?>

<form id="equipment_monitor_form">
  <input type="hidden" name="equipment_id" value="<?= isset($id) ? $id : '' ?>">
  <input type="hidden" name="room_id" value="<?= $room_id; ?>">
  <input type="hidden" name="category_id" value="<?= $category_id; ?>">
  <div class="form-group">
    <label for="green" class="control-label">Green</label>
    <input type="number" name="green" id="green" class="form-control form-control-sm" value="<?= isset($data->green) ? $data->green : '' ?>">
  </div>
  <div class="form-group">
    <label for="white" class="control-label">White</label>
    <input type="number" name="white" id="white" class="form-control form-control-sm" value="<?= isset($data->white) ? $data->white : '' ?>">
  </div>
  <div class="form-group">
    <label for="yellow" class="control-label">Yellow</label>
    <input type="number" name="yellow" id="yellow" class="form-control form-control-sm" value="<?= isset($data->yellow) ? $data->yellow : '' ?>">
  </div>
  <div class="form-group">
    <label for="arm_chair" class="control-label">Arm Chair</label>
    <input type="number" name="arm_chair" id="arm_chair" class="form-control form-control-sm" value="<?= isset($data->arm_chair) ? $data->arm_chair : '' ?>">
  </div>
  <div class="form-group">
    <label for="status" class="control-label">Status</label>
    <select name="status" id="status" class="form-control form-control-sm" required>
      <option value="New" <?php echo isset($data->status) && $data->status == 'New' ? 'selected' : '' ?>>New</option>
      <option value="Damaged" <?php echo isset($data->status) && $data->status == 'Damaged' ? 'selected' : '' ?>>Damaged</option>
    </select>
  </div>
  <hr>
  <?php if (!isset($id)) : ?>
    <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i> Save</button>
  <?php endif; ?>
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