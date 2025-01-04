<?php
include 'db_connect.php';

$room_status = isset($_GET['room_status']) ? $_GET['room_status'] : '';
$room_id = isset($_GET['room_id']) ? $_GET['room_id'] : '';
$equipment_status = isset($_GET['equipment_status']) ? $_GET['equipment_status'] : '';
$rooms = $conn->query("SELECT * FROM room_list order by id asc");

if (isset($_GET['room_id'])) {
	$rooms = $conn->query("SELECT * FROM room_list where id = " . $_GET['room_id'] . " order by id asc");
}
?>

<div class="col-lg-12">

	<!--Start-->
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label for="" class="control-label">
					Filter by Room
					<!-- Clear Filter -->
					<?php if (isset($_GET['room_id'])) : ?>
						<span class="float-right"><a href="index.php?page=equipment_list" class="ml-2">Clear Filter</a></span>
					<?php endif; ?>
				</label>
				<select name="room_id" id="room_id" class="custom-select custom-select-sm" onchange="location.href = 'index.php?page=equipment_list&room_id=' + this.value">
					<option selected disabled hidden>Select Room</option>
					<?php
					$room = $conn->query("SELECT * FROM room_list order by id asc");
					if ($room->num_rows <= 0) :
					?>
						<option disabled>No Room Found</option>
					<?php
					else :
					?>
						<option value="0" <?php echo isset($_GET['room_id']) && $_GET['room_id'] == 0 ? 'selected' : '' ?> hidden>All</option>
					<?php endif; ?>
					<?php
					while ($row = $room->fetch_assoc()) :
					?>
						<option value="<?php echo $row['id'] ?>" <?php echo isset($_GET['room_id']) && $_GET['room_id'] == $row['id'] ? 'selected' : '' ?>>Room: <?php echo $row['room'] ?></option>
					<?php endwhile; ?>
				</select>
			</div>
			<!-- Clear Filter -->
		</div>
	</div>

	<!--End-->

	<?php while ($room_row = $rooms->fetch_assoc()) {
	?>
		<div class="card card-outline card-primary">
			<div class="card-header">
				<div class="card-title">
					<h3 class="card-title">Room Number: <?= $room_row['room'] ?></h3>
					<p class="card-text">Description: <?= $room_row['description'] ?></p>
				</div>

				<div class="card-tools float-right">
					<a class="btn btn-block btn-sm btn-default" href="./index.php?page=new_equipment&room_id=<?= $room_row['id'] ?>"><i class="fa fa-plus"></i> Add New Equipment</a>
				</div>
			</div>
			<div class="card-body">
				<?php
				$equipment_category_array = array();

				$equipment_sql = $conn->query("SELECT id, room_id, category_id, data FROM equipment_list where room_id = " . $room_row['id'] . " order by id asc");

				while ($equipment = $equipment_sql->fetch_assoc()) {
					$category_sql = $conn->query("SELECT * FROM tbl_categories where id = " . $equipment['category_id']);

					$equipment['category'] = $category_sql->num_rows > 0 ? $category_sql->fetch_array()['name'] : 'N/A';
					$equipment_category_array[$equipment['category_id']][] = $equipment;
				} ?>

				<?php foreach ($equipment_category_array as $equipment) { ?>
					<pre>
						<?= json_encode($equipment, JSON_PRETTY_PRINT) ?>
					</pre>
				<?php } ?>
			</div>
		</div>
	<?php }
	$conn->close()
	?>
</div>

<script>
	$(document).ready(function() {
		$('.delete_equipment').click(function() {
			_conf("Are you sure to delete this equipment?", "delete_equipment", [$(this).attr('data-id')])
		})
	})

	function delete_equipment($eq_id) {
		start_load()
		$.ajax({
			url: 'ajax.php?action=delete_equipment',
			method: 'POST',
			data: {
				id: $eq_id
			},
			success: function(resp) {
				if (resp == 1) {
					alert_toast("Data successfully deleted", 'success')
					setTimeout(function() {
						location.reload()
					}, 1500)

				}
			}
		})
	}
</script>