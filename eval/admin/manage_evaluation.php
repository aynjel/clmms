<?php
include '../db_connect.php';
if(isset($_GET['id'])){
	$qry = $conn->query("SELECT * FROM room_list where id={$_GET['id']}")->fetch_array();
	foreach($qry as $k => $v){
		$$k = $v;
	}
}
?>
<div class="container-fluid">
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
		<!-- <div class="form-group">
			<label for="faculty" class="control-label">Faculty</label>
			<select name="faculty_id" id="faculty" class="custom-select custom-select-sm" required>
				<option selected disabled hidden>Select Faculty</option>
				<?php 
				$qry = $conn->query("SELECT * FROM faculty_list order by id asc");
				while($row= $qry->fetch_assoc()): ?>
				<option value="<?= $row['id'] ?>" <?= isset($fac['id']) && $fac['id'] == $row['id'] ? 'selected' : '' ?>><?= ucwords($row['firstname'].' '.$row['lastname']) ?></option>
			<?php endwhile; ?>
			</select>
		</div> -->
	</form>
</div>
<script>
	$(document).ready(function(){
		$('#manage-room').submit(function(e){
			e.preventDefault();
			start_load()
			$('#msg').html('')
			$.ajax({
				url:'ajax.php?action=save_room',
				method:'POST',
				data:$(this).serialize(),
				success:function(resp){
					if(resp == 1){
						alert_toast("Data successfully saved.","success");
						setTimeout(function(){
							location.reload()	
						},1750)
					}else if(resp == 2){
						$('#msg').html('<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Room already exist.</div>')
						end_load()
					}
				}
			})
		})
	})

</script>