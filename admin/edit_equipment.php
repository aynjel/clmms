<?php
include '../db_connect.php';
$qry = $conn->query("SELECT * FROM equipment_list where id = " . $_GET['id'])->fetch_array();
foreach ($qry as $k => $v) {
	$$k = $v;
}
$data = json_decode($data);
?>
<form action="" id="manage_equipment">
	<input type="text" name="id" value="<?php echo isset($id) ? $id : '' ?>">
	<input type="text" name="id" value="<?php echo isset($room_id) ? $room_id : '' ?>">
	<input type="text" name="id" value="<?php echo isset($category_id) ? $category_id : '' ?>">
	<?php
	switch ($category_id) {
		case '1':
			include 'new_equipment_system_unit.php';
			break;
		case '2':
			include 'new_equipment_monitor.php';
			break;
		case '3':
			include 'new_equipment_avr_monitor_keyboard.php';
			break;
		case '4':
			include 'new_equipment_avr_monitor_keyboard.php';
			break;
		case '5':
			include 'new_equipment_tables.php';
			break;
		case '6':
			include 'new_equipment_avr_monitor_keyboard.php';
			break;
		case '7':
			include 'new_equipment_other_equipment.php';
			break;
		case '8':
			include 'new_equipment_monoblock_chairs.php';
			break;
	} ?>
	<!-- <div class="row">
		<div class="col-md-4">
			<div class="form-group">
				<label for="" class="control-label">Name</label>
				<input type="text" class="form-control form-control-sm" name="name" value="<?php echo isset($name) ? $name : '' ?>" required>
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				<label for="" class="control-label">Serial No.</label>
				<input type="text" class="form-control form-control-sm" name="serial_no" value="<?php echo isset($serial_no) ? $serial_no : '' ?>" required>
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				<label for="" class="control-label">Quantity</label>
				<input type="number" class="form-control form-control-sm" name="quantity" value="<?php echo isset($quantity) ? $quantity : '' ?>" required>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label for="" class="control-label">Manufacturer</label>
				<input type="text" class="form-control form-control-sm" name="manufacturer" value="<?php echo isset($manufacturer) ? $manufacturer : '' ?>" required>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label for="" class="control-label">Condition</label>
				<select name="condition" id="" class="custom-select custom-select-sm">
					<option value="Good" <?php echo isset($condition) && $condition == 'Good' ? 'selected' : '' ?>>Good</option>
					<option value="Bad" <?php echo isset($condition) && $condition == 'Bad' ? 'selected' : '' ?>>Bad</option>
					<option value="Refurbished" <?php echo isset($condition) && $condition == 'Refurbished' ? 'selected' : '' ?>>Refurbished</option>
					<option value="Damaged" <?php echo isset($condition) && $condition == 'Damaged' ? 'selected' : '' ?>>Damaged</option>
				</select>
			</div>
		</div>

		<div class="col-md-12">
			<div class="form-group">
				<label for="" class="control-label">Description</label>
				<textarea name="description" id="" cols="30" rows="4" class="form-control"><?php echo isset($description) ? $description : '' ?></textarea>
			</div>
		</div>
	</div> -->
</form>

<script>
	$('#manage_equipment').submit(function(e) {
		e.preventDefault()
		$('input').removeClass("border-danger")
		start_load()
		$('#msg').html('')

		$.ajax({
			url: 'ajax.php?action=save_equipment',
			data: new FormData($(this)[0]),
			cache: false,
			contentType: false,
			processData: false,
			method: 'POST',
			type: 'POST',
			success: function(resp) {
				if (resp == 1) {
					alert_toast('Data successfully saved.', "success");
					setTimeout(function() {
						location.replace('index.php?page=equipment_list')
					}, 750)
				} else if (resp == 2) {
					$('#msg').html("<div class='alert alert-danger'>Equipment already exist.</div>");
					$('[name="name"]').addClass("border-danger")
					end_load()
				}
			}
		})
	})
</script>