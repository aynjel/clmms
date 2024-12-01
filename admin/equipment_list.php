<?php
include 'db_connect.php';

$room_status = isset($_GET['room_status']) ? $_GET['room_status'] : '';
$room_id = isset($_GET['room_id']) ? $_GET['room_id'] : '';
$equipment_status = isset($_GET['equipment_status']) ? $_GET['equipment_status'] : '';
$rooms = $conn->query("SELECT * FROM room_list order by id asc");
$category_list = array(
	1 => 'System Unit',
	2 => 'Monitor',
	3 => 'Avr',
	4 => 'Keyboard',
	5 => 'Mouse',
	6 => 'Monoblock Chairs',
	7 => 'Tables',
	8 => 'Other Equipment'
);

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

	<?php while ($room_row = $rooms->fetch_assoc()) { ?>
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
				$room_equipment = $conn->query("SELECT * FROM equipment_list where room_id = '{$room_row['id']}'");

				if ($room_equipment->num_rows <= 0) :
				?>
					<div class="text-center">
						No Equipment Found
					</div>
				<?php
				endif;
				while ($room_eq_row = $room_equipment->fetch_assoc()) {
				?>
					<div class="card card-outline card-secondary">
						<div class="card-header">
							<div class="card-title">
								<h3 class="card-title">
									<span class="badge badge-secondary">Category</span>
									<span class="text-uppercase font-weight-bold"><?= $room_eq_row['category_name'] ?></span>
								</h3>
							</div>
							<div class="card-tools">
								<div class="btn-group dropleft float-right">
									<a class="btn btn-sm btn-default delete_equipment" href="javascript:void(0)" data-id="<?= $room_eq_row['id'] ?>"><i class="fa fa-trash text-danger"></i> Delete</a>
									<a
										class="btn btn-sm btn-default"
										href="./index.php?page=new_equipment&room_id=<?= $room_eq_row['room_id'] ?>&category_name=<?= $room_eq_row['category_name'] ?>&eq_id=<?= $room_eq_row['id'] ?>">
										<i class="fa fa-edit text-info"></i> Edit
									</a>
								</div>
							</div>
						</div>
						<?php
						$decoded_data = json_decode($room_eq_row['data'], true);
						switch ($room_eq_row['category_name']) {
							case $category_list[1]:
						?>
								<table class="table table-bordered">
									<thead>
										<tr>
											<th>PC Number</th>
											<th>Manufacturer</th>
											<th>Serial Number</th>
											<th>OS Version</th>
											<th>RAM</th>
											<th>Processor</th>
											<th>Status</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td><?= $decoded_data['pc_number'] ?></td>
											<td><?= $decoded_data['manufacturer'] ?></td>
											<td><?= $decoded_data['serial_no'] ?></td>
											<td><?= $decoded_data['os_version'] ?></td>
											<td><?= $decoded_data['ram'] ?></td>
											<td><?= $decoded_data['processor'] ?></td>
											<td><?= $decoded_data['status'] ?></td>
										</tr>
									</tbody>
								</table>
							<?php
								break;
							case $category_list[2]:
							?>
								<table class="table table-bordered">
									<thead>
										<tr>
											<th>Monitor Number</th>
											<th>Manufacturer</th>
											<th>Serial Number</th>
											<th>Status</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td><?= $decoded_data['monitor_number'] ?></td>
											<td><?= $decoded_data['manufacturer'] ?></td>
											<td><?= $decoded_data['serial_no'] ?></td>
											<td><?= $decoded_data['status'] ?></td>
										</tr>
									</tbody>
								</table>
							<?php
								break;
							case $category_list[3]:
							?>
								<table class="table table-bordered">
									<thead>
										<tr>
											<th>AVR</th>
											<th>Quantity</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>Functional</td>
											<td><?= $decoded_data['functional'] ?></td>
										</tr>
										<tr>
											<td>Not-Functional</td>
											<td><?= $decoded_data['not_functional'] ?></td>
										</tr>
									</tbody>
								</table>
							<?php
								break;
							case $category_list[4]:
							?>
								<table class="table table-bordered">
									<thead>
										<tr>
											<th>Keyboard</th>
											<th>Quantity</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>Functional</td>
											<td><?= $decoded_data['functional'] ?></td>
										</tr>
										<tr>
											<td>Not-Functional</td>
											<td><?= $decoded_data['not_functional'] ?></td>
										</tr>
									</tbody>
								</table>
							<?php
								break;
							case $category_list[5]:
							?>
								<table class="table table-bordered">
									<thead>
										<tr>
											<th>Mouse</th>
											<th>Quantity</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>Functional</td>
											<td><?= $decoded_data['functional'] ?></td>
										</tr>
										<tr>
											<td>Not-Functional</td>
											<td><?= $decoded_data['not_functional'] ?></td>
										</tr>
									</tbody>
								</table>
							<?php
								break;
							case $category_list[6]:
							?>
								<table class="table table-bordered">
									<thead>
										<tr>
											<th>Monoblock Chairs</th>
											<th>Quantity</th>
											<th>Status</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>Green</td>
											<td><?= $decoded_data['green'] ?></td>
											<td rowspan="4" style="vertical-align: middle;"><?= $decoded_data['status'] ?></td>
										</tr>
										<tr>
											<td>White</td>
											<td><?= $decoded_data['white'] ?></td>
										</tr>
										<tr>
											<td>Yellow</td>
											<td><?= $decoded_data['yellow'] ?></td>
										</tr>
										<tr>
											<td>Arm Chair</td>
											<td><?= $decoded_data['arm_chair'] ?></td>
										</tr>
									</tbody>
								</table>
							<?php
								break;
							case $category_list[7]:
							?>
								<table class="table table-bordered">
									<thead>
										<tr>
											<th>Table</th>
											<th>Quantity</th>
											<th>Status</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>Long</td>
											<td><?= $decoded_data['long'] ?></td>
											<td rowspan="4" style="vertical-align: middle;"><?= $decoded_data['status'] ?></td>
										</tr>
										<tr>
											<td>Square</td>
											<td><?= $decoded_data['square'] ?></td>
										</tr>
										<tr>
											<td>Mini</td>
											<td><?= $decoded_data['mini'] ?></td>
										</tr>
										<tr>
											<td>Circle</td>
											<td><?= $decoded_data['circle'] ?></td>
										</tr>
									</tbody>
								</table>
							<?php
								break;
							case $category_list[8]:
							?>
								<table class="table table-bordered">
									<thead>
										<tr>
											<th>Other Equipment</th>
											<th>Quantity</th>
											<th>Status</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>Smart TV</td>
											<td><?= $decoded_data['smart_tv'] ?></td>
											<td rowspan="4" style="vertical-align: middle;"><?= $decoded_data['status'] ?></td>
										</tr>
										<tr>
											<td>Switch</td>
											<td><?= $decoded_data['switch'] ?></td>
										</tr>
										<tr>
											<td>Air Condition Unit</td>
											<td><?= $decoded_data['air_condition_unit'] ?></td>
										</tr>
										<tr>
											<td>Printer</td>
											<td><?= $decoded_data['printer'] ?></td>
										</tr>
									</tbody>
								</table>
						<?php
								break;
							default:
								# code...
								break;
						}
						?>
					</div>
				<?php
				}

				?>
			</div>
		</div>
	<?php } ?>
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