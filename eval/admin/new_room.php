<?php
?>
<div class="col-lg-12">
	<div class="card">
		<div class="card-body">
			<form action="" id="manage_student">
				<input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
				<div class="row">
					<div class="col-md-6 border-right">
						<div class="form-group">
							<label for="" class="control-label">Room</label>
							<input type="text" name="room" class="form-control form-control-sm" required value="<?php echo isset($room) ? $room : '' ?>">
						</div>
						<div class="form-group">
							<label for="" class="control-label">Assign</label>
							<input type="text" name="assign" class="form-control form-control-sm" required value="<?php echo isset($assign) ? $assign : '' ?>">
						</div>
						
								<?php 
								$classes = $conn->query("SELECT id,concat(room, assign) as room FROM room_list");
								while($row=$classes->fetch_assoc()):
								?>
								<option value="<?php echo $row['id'] ?>" <?php echo isset($room) && $room == $row['id'] ? "selected" : "" ?>><?php echo $row['#'] ?></option>
								<?php endwhile; ?>
							</select>
						</div>
						
					
					</div>
				</div>
				<hr>
				<div class="col-lg-12 text-right justify-content-center d-flex">
					<button class="btn btn-primary mr-2" type="button" onclick="location.href = 'index.php?page=edit_room'">Save</button>
					<button class="btn btn-secondary" type="button" onclick="location.href = 'index.php?page=room_list'">Cancel</button>
				</div>
			</form>
		</div>
	</div>
</div>
<style>
	img#cimg{
		height: 15vh;
		width: 15vh;
		object-fit: cover;
		border-radius: 100% 100%;
	}
</style>
<script>
	
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
</script>