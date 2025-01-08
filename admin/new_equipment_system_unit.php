<?php
$room_id = isset($_GET['room_id']) ? $_GET['room_id'] : '';
$category_id = isset($_GET['category_id']) ? $_GET['category_id'] : '';
?>

<form id="equipment_system_unit_form">
  <input type="hidden" name="id" value="<?= isset($eq_id) ? $eq_id : '' ?>">
  <input type="hidden" name="room_id" value="<?php echo $room_id ?>">
  <input type="hidden" name="category_id" value="<?php echo $category_id ?>">
  <div class="form-group">
    <label for="pc_number" class="control-label">PC Number</label>
    <input type="number" name="pc_number" id="pc_number" class="form-control form-control-sm" value="<?= isset($data->pc_number) ? $data->pc_number : '' ?>">
  </div>
  <div class="form-group">
    <label for="manufacturer" class="control-label">Manufacturer</label>
    <input type="text" id="manufacturer" class="form-control form-control-sm" name="manufacturer" value="<?= isset($data->manufacturer) ? $data->manufacturer : '' ?>">
  </div>
  <div class="form-group">
    <label for="serial_no" class="control-label">Serial No.</label>
    <input type="text" id="serial_no" class="form-control form-control-sm" name="serial_no" value="<?= isset($data->serial_no) ? $data->serial_no : '' ?>">
  </div>
  <div class="form-group">
    <label for="os_version" class="control-label">OS Version</label>
    <input type="text" id="os_version" class="form-control form-control-sm" name="os_version" value="<?= isset($data->os_version) ? $data->os_version : '' ?>">
  </div>
  <div class="form-group">
    <label for="ram" class="control-label">RAM</label>
    <input type="text" id="ram" class="form-control form-control-sm" name="ram" value="<?= isset($data->ram) ? $data->ram : '' ?>">
  </div>
  <div class="form-group">
    <label for="processor" class="control-label">Processor</label>
    <input type="text" id="processor" class="form-control form-control-sm" name="processor" value="<?= isset($data->processor) ? $data->processor : '' ?>">
  </div>
  <div class="form-group">
    <label for="status" class="control-label">Status</label>
    <select name="status" id="status" class="form-control form-control-sm" required>
      <option value="Functional" <?php echo isset($data->status) && $data->status == 'Functional' ? 'selected' : '' ?>>Functional</option>
      <option value="Not Functional" <?php echo isset($data->status) && $data->status == 'Not Functional' ? 'selected' : '' ?>>Not Functional</option>
    </select>
  </div>
  <hr>
  <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i> Save</button>
</form>

<script>
  $('#equipment_system_unit_form').submit(function(e) {
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