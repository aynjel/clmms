<?php
$room_sql = $conn->query("SELECT * FROM room_list where id = ".$_GET['room_id'])->fetch_array();
foreach($room_sql as $k => $v){
	$$k = $v;
}
?>
<form action="" id="manage_faculty_room">
	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<label for="room" class="control-label">Room</label>
				<input type="text" class="form-control form-control-sm" value="<?= isset($room) ? $room : '' ?>" readonly>
				<input type="text" class="form-control form-control-sm" name="room" id="room" value="<?= isset($id) ? $id : '' ?>" hidden>
			</div>
		</div>
		<div class="col-md-12">
			<div class="form-group">
				<label for="faculty" class="control-label">Faculty</label>
				<select name="faculty" id="faculty" class="custom-select custom-select-sm">
					<option selected disabled value="" hidden>Select Faculty</option>
					<?php 
					$chk = $conn->query("SELECT * FROM faculty_room_list where room_id = {$id} ");
					if($chk->num_rows > 0){
						$fac = $chk->fetch_array();
						$fac = $conn->query("SELECT * FROM faculty_list where id = {$fac['faculty_id']} ")->fetch_array();
						echo '<option value="'.$fac['id'].'" selected>'.ucwords($fac['firstname'].' '.$fac['lastname']).'</option>';
					}
					$qry = $conn->query("SELECT * FROM faculty_list order by lastname asc");
					while($row= $qry->fetch_assoc()):
					?>
					<option value="<?= $row['id'] ?>" <?= isset($fac['id']) && $fac['id'] == $row['id'] ? 'selected' : '' ?>><?= ucwords($row['firstname'].' '.$row['lastname']) ?></option>
				<?php endwhile; ?>
				</select>
			</div>
		</div>
	</div>

	<div class="col-lg-12 text-right justify-content-center d-flex">
		<button class="btn btn-primary mr-2">Save</button>
		<button class="btn btn-secondary" type="button" onclick="location.href = 'index.php?page=room_list'">Cancel</button>
	</div>
</form>

<script>
	$('#manage_faculty_room').submit(function(e) {
		e.preventDefault()
		$('input').removeClass("border-danger")
		start_load()
		$('#msg').html('')

		$.ajax({
			url: 'ajax.php?action=save_faculty_room',
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