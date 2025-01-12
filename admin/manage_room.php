<?php
include '../db_connect.php';
if (isset($_GET['id'])) {
	$qry = $conn->query("SELECT * FROM room_list where id={$_GET['id']}")->fetch_array();
	foreach ($qry as $k => $v) {
		$$k = $v;
	}
}
?>
<form action="" id="manage-room">
	<input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
	<div id="msg" class="form-group"></div>
	<div class="form-group">
		<label for="room" class="control-label">Room</label>
		<input type="number" class="form-control form-control-sm" name="room" id="room" value="<?php echo isset($room) ? $room : '' ?>" required autofocus>
	</div>
	<div class="form-group">
		<label for="capacity" class="control-label">Capacity</label>
		<input type="number" class="form-control form-control-sm" name="capacity" id="capacity" value="<?php echo isset($capacity) ? $capacity : '' ?>" required>
	</div>
	<div class="form-group">
		<label for="status" class="control-label">Status</label>
		<select name="status" id="status" class="custom-select custom-select-sm">
			<option value="1" <?php echo isset($status) && $status == 1 ? 'selected' : '' ?>>Active</option>
			<option value="0" <?php echo isset($status) && $status == 0 ? 'selected' : '' ?>>Inactive</option>
		</select>
	</div>
	<div class="form-group">
		<label for="description" class="control-label">Description <i>(optional)</i></label>
		<textarea name="description" id="description" cols="30" rows="2" class="form-control"><?php echo isset($description) ? $description : '' ?></textarea>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<label for="room" class="control-label">Room</label>
				<input type="text" class="form-control form-control-sm" name="room" value="<?php echo isset($room) ? $room : '' ?>" readonly>
			</div>
		</div>
		<div class="col-md-12">
			<div class="form-group">
				<label for="faculty" class="control-label">Faculty 1</label>
				<select name="faculty_id_1" id="faculty" class="form-control form-control-sm select2">
					<option selected disabled hidden>Select Faculty</option>
					<?php
					$qry1 = $conn->query("SELECT * FROM faculty_list order by lastname asc");
					while ($row = $qry1->fetch_assoc()):
					?>
						<option value="<?= $row['id'] ?>" <?= isset($faculty_id_1) && $faculty_id_1 == $row['id'] ? 'selected' : '' ?>><?= ucwords($row['firstname'] . ' ' . $row['lastname']) ?></option>
					<?php endwhile; ?>
				</select>
			</div>
		</div>
		<div class="col-md-12">
			<div class="form-group">
				<label for="faculty" class="control-label">Faculty 2</label>
				<select name="faculty_id_2" id="faculty" class="form-control form-control-sm select2">
					<option selected disabled hidden>Select Faculty</option>
					<?php
					$qry2 = $conn->query("SELECT * FROM faculty_list order by lastname asc");
					while ($row = $qry2->fetch_assoc()):
					?>
						<option value="<?= $row['id'] ?>" <?= isset($faculty_id_2) && $faculty_id_2 == $row['id'] ? 'selected' : '' ?>><?= ucwords($row['firstname'] . ' ' . $row['lastname']) ?></option>
					<?php endwhile; ?>
				</select>
			</div>
		</div>
	</div>
</form>
<script>
	$(document).ready(function() {
		$('#manage-room').submit(function(e) {
			e.preventDefault();
			start_load()
			$('#msg').html('')
			$.ajax({
				url: 'ajax.php?action=save_room',
				method: 'POST',
				data: $(this).serialize(),
				success: function(resp) {
					if (resp == 1) {
						alert_toast("Data successfully saved.", "success");
						setTimeout(function() {
							location.reload()
						}, 1750)
					} else if (resp == 2) {
						$('#msg').html('<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Room already exist.</div>')
						end_load()
					}
				}
			})
		})
	})
</script>