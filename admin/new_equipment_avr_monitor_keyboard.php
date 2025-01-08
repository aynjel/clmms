<?php
$room_id = isset($_GET['room_id']) ? $_GET['room_id'] : '';
$category_id = isset($_GET['category_id']) ? $_GET['category_id'] : '';
?>
<form id="equipment_monitor_form">
  <input type="hidden" name="id" value="<?= isset($eq_id) ? $eq_id : '' ?>">
  <input type="hidden" name="room_id" value="<?php echo $room_id ?>">
  <input type="hidden" name="category_id" value="<?php echo $category_id ?>">
  <div class="form-group">
    <label for="functional" class="control-label">Functional</label>
    <input type="number" name="functional" id="functional" class="form-control form-control-sm" value="<?= isset($data->functional) ? $data->functional : '' ?>">
  </div>
  <div class="form-group">
    <label for="not_functional" class="control-label">Not-Functional</label>
    <input type="number" name="not_functional" id="not_functional" class="form-control form-control-sm" value="<?= isset($data->not_functional) ? $data->not_functional : '' ?>">
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