<?php
$room_id = isset($_GET['room_id']) ? $_GET['room_id'] : '';
$category_name = isset($_GET['category_name']) ? $_GET['category_name'] : '';
?>

<form id="equipment_monitor_form">
  <input type="hidden" name="id" value="<?= isset($eq_id) ? $eq_id : '' ?>">
  <input type="hidden" name="room_id" value="<?php echo $room_id ?>">
  <input type="hidden" name="category_name" value="<?php echo $category_name ?>">
  <div class="form-group">
    <label for="functional" class="control-label">Functional</label>
    <input type="number" name="functional" id="functional" class="form-control form-control-sm" value="<?= isset($functional) ? $functional : '' ?>">
  </div>
  <div class="form-group">
    <label for="not_functional" class="control-label">Not-Functional</label>
    <input type="number" name="not_functional" id="not_functional" class="form-control form-control-sm" value="<?= isset($not_functional) ? $not_functional : '' ?>">
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