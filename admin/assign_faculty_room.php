<?php
include '../db_connect.php';
if(isset($_GET['room_id'])){
	$qry = $conn->query("SELECT * FROM room_list where id={$_GET['room_id']}")->fetch_array();
	foreach($qry as $k => $v){
		$$k = $v;
	}
}
?>
<form action="" id="manage_faculty_room">
	<input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
	<input type="hidden" name="description" value="<?php echo isset($description) ? $description : '' ?>">
	<input type="hidden" name="capacity" value="<?php echo isset($capacity) ? $capacity : '' ?>">
	<input type="hidden" name="status" value="<?php echo isset($status) ? $status : 1 ?>">
	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<label for="room" class="control-label">Room</label>
				<input type="text" class="form-control form-control-sm" name="room" value="<?php echo isset($room) ? $room : '' ?>" readonly>
			</div>
		</div>
		<div class="col-md-12">
			<div class="form-group">
				<label for="faculty" class="control-label">Faculty</label>
				<select name="faculty_id" id="faculty" class="form-control form-control-sm select2">
					<option selected disabled hidden>Select Faculty</option>
					<?php
					$qry = $conn->query("SELECT * FROM faculty_list order by lastname asc");
					while($row= $qry->fetch_assoc()):
					?>
					<option value="<?= $row['id'] ?>" <?= isset($fac['id']) && $fac['id'] == $row['id'] ? 'selected' : '' ?>><?= ucwords($row['firstname'].' '.$row['lastname']) ?></option>
				<?php endwhile; ?>
				</select>
			</div>
		</div>
	</div>
</form>

<script>
	$('#manage_faculty_room').submit(function(e) {
		e.preventDefault()
		$('input').removeClass("border-danger")
		start_load()
		$('#msg').html('')

		$.ajax({
			url: 'ajax.php?action=save_room',
			data: new FormData($(this)[0]),
			cache: false,
			contentType: false,
			processData: false,
			method: 'POST',
			type: 'POST',
			success: function(resp) {
				console.log(resp)
				if (resp == 1) {
					alert_toast('Data successfully saved.', "success");
					setTimeout(function() {
						location.replace('index.php?page=room_list')
					}, 750)
				} else if (resp == 2) {
					$('#msg').html("<div class='alert alert-danger'>Faculty is already assigned to a room.</div>")
					$('[name="name"]').addClass("border-danger")
					end_load()
				}
			}
		})
	})
</script>