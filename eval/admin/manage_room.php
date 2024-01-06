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
			<input type="text" class="form-control form-control-sm" name="room" id="room" value="<?php echo isset($room) ? $room : '' ?>" required>
		</div>
		<div class="form-group">
			<label for="assign" class="control-label">Assign Faculty in Charge</label>
			<input type="text" class="form-control form-control-sm" name="assign" id="assign" value="<?php echo isset($assign) ? $assign : '' ?>" required>
		</div>
		
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