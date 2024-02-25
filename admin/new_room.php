<?php
?>
<div class="col-lg-12">
	<div class="card">
		<div class="card-body">
			<form action="" id="manage_room">
				<input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label for="room" class="control-label">Room</label>
							<input type="text" class="form-control form-control-sm" name="room" id="room" min="1" value="<?php echo isset($room) ? $room : '' ?>" required autofocus>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="capacity" class="control-label">Capacity</label>
							<input type="number" class="form-control form-control-sm" name="capacity" id="capacity" min="1" value="<?php echo isset($capacity) ? $capacity : '' ?>" required>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="status" class="control-label">Status</label>
							<select name="status" id="status" class="custom-select custom-select-sm">
								<option value="1" <?php echo isset($status) && $status == 1 ? 'selected' : '' ?>>Active</option>
								<option value="0" <?php echo isset($status) && $status == 0 ? 'selected' : '' ?>>Inactive</option>
							</select>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label for="description" class="control-label">Description <i>(optional)</i></label>
							<textarea name="description" id="description" cols="30" rows="4" class="form-control"><?php echo isset($description) ? $description : '' ?></textarea>
						</div>
					</div>
				</div>
				<div class="col-lg-12 text-right justify-content-center d-flex">
					<button class="btn btn-primary mr-2">Save</button>
					<button class="btn btn-secondary" type="button" onclick="location.href = 'index.php?page=room_list'">Cancel</button>
				</div>
			</form>
		</div>
	</div>
</div>

<script>
	$('#manage_room').submit(function(e) {
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
					$('#msg').html("<div class='alert alert-danger'>Room already exist.</div>");
					$('[name="name"]').addClass("border-danger")
					end_load()
				}
			}
		})
	})
</script>