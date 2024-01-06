<?php
include '../db_connect.php';
if(isset($_GET['id'])){
	$qry = $conn->query("SELECT * FROM equipment_list where id={$_GET['id']}")->fetch_array();
	foreach($qry as $k => $v){
		$$k = $v;
	}
}
?>
<div class="container-fluid">
	<form action="" id="manage-equipment">
		<input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
		<div id="msg" class="form-group"></div>
		<div class="form-group">
			<label for="quantity" class="control-label">Quantity</label>
			<input type="text" class="form-control form-control-sm" name="quantity" id="quantity" value="<?php echo isset($quantity) ? $quantity : '' ?>" required>
		</div>
		<div class="form-group">
			<label for="description" class="control-label">Description</label>
			<textarea type="text" class="form-control form-control-sm" name="description" id="description" cols="30" rows="4" class="form-control" required><?php echo isset($description) ? $description : '' ?></textarea>
		</div>
		<div class="form-group">
			<label for="manufacturer" class="control-label">Manufacturer</label>
			<input type="text" class="form-control form-control-sm" name="manufacturer" id="manufacturer" value="<?php echo isset($manufacturer) ? $manufacturer : '' ?>" required>
		</div>
        <div class="form-group">
			<label for="serial" class="control-label">Serial No:</label>
			<input type="text" class="form-control form-control-sm" name="serial" id="serial" value="<?php echo isset($serial) ? $serial : '' ?>" required>
		</div>
        <div class="form-group">
			<label for="condition" class="control-label">Condition</label>
			<input type="text" class="form-control form-control-sm" name="condition" id="condition" value="<?php echo isset($condition) ? $condition : '' ?>" required>
	</form>
</div>
<script>
	$(document).ready(function(){
		$('#manage-equipment').submit(function(e){
			e.preventDefault();
			start_load()
			$('#msg').html('')
			$.ajax({
				url:'ajax.php?action=save_equipment',
				method:'POST',
				data:$(this).serialize(),
				success:function(resp){
					if(resp == 1){
						alert_toast("Data successfully saved.","success");
						setTimeout(function(){
							location.reload()	
						},1750)
					}else if(resp == 2){
						$('#msg').html('<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Equipment quantity already exist.</div>')
						end_load()
					}
				}
			})
		})
	})

</script>