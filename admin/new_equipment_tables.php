<?php
$room_id = isset($_GET['room_id']) ? $_GET['room_id'] : '';
$category_name = isset($_GET['category_name']) ? $_GET['category_name'] : '';
?>

<form id="equipment_monitor_form">
  <input type="hidden" name="id" value="<?= isset($eq_id) ? $eq_id : '' ?>">
  <input type="hidden" name="room_id" value="<?php echo $room_id ?>">
  <input type="hidden" name="category_name" value="<?php echo $category_name ?>">
  <div class="form-group">
    <label for="long" class="control-label">Long</label>
    <input type="number" name="long" id="long" class="form-control form-control-sm" value="<?= isset($long) ? $long : '' ?>">
  </div>
  <div class="form-group">
    <label for="square" class="control-label">Square</label>
    <input type="number" name="square" id="square" class="form-control form-control-sm" value="<?= isset($square) ? $square : '' ?>">
  </div>
  <div class="form-group">
    <label for="circle" class="control-label">Circle</label>
    <input type="number" name="circle" id="circle" class="form-control form-control-sm" value="<?= isset($circle) ? $circle : '' ?>">
  </div>
  <div class="form-group">
    <label for="mini" class="control-label">Mini</label>
    <input type="number" name="mini" id="mini" class="form-control form-control-sm" value="<?= isset($mini) ? $mini : '' ?>">
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