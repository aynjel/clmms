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

				$equipment_sql = $conn->query("SELECT * FROM equipment_list WHERE room_id = " . $room_row['id'] . " ORDER by id asc");

				if ($equipment_sql->num_rows <= 0) {
					echo '<p class="text-center">No Equipment Found</p>';
				} else {
					while ($equipment = $equipment_sql->fetch_assoc()) {
						$category_sql = $conn->query("SELECT * FROM tbl_categories WHERE id = " . $equipment['category_id'] . " ORDER by id asc");

						$equipment['category'] = $category_sql->num_rows > 0 ? $category_sql->fetch_array()['name'] : 'N/A';
						$equipment_category_array[$equipment['category']][] = $equipment;
					}

					foreach ($equipment_category_array as $equipment_category) { ?>
						<div class="card">
							<div class="card-header">
								<div class="card-title">
									<h3><?= $equipment_category[0]['category']; ?></h3>
								</div>
							</div>
							<div class="card-body p-0">
								<table class="table table-hover">
									<thead>
										<tr>
											<?php
											switch ($equipment_category[0]['category_id']) {
												case 1:
													echo '<th class="text-center">PC Number</th>';
													echo '<th class="text-center">Manufacturer</th>';
													echo '<th class="text-center">Serial Number</th>';
													echo '<th class="text-center">OS Version</th>';
													echo '<th class="text-center">RAM</th>';
													echo '<th class="text-center">Processor</th>';
													echo '<th class="text-center">Status</th>';
													echo '<th class="text-center">Action</th>';
													break;
												case 2:
													echo '<th class="text-center">Monitor Number</th>';
													echo '<th class="text-center">Manufacturer</th>';
													echo '<th class="text-center">Serial Number</th>';
													echo '<th class="text-center">Status</th>';
													echo '<th class="text-center">Action</th>';
													break;
												case 3:
												case 4:
												case 5:
													echo '<th class="text-center">Functional</th>';
													echo '<th class="text-center">Not-Functional</th>';
													echo '<th class="text-center">Action</th>';
													break;
												case 6:
													echo '<th class="text-center">Green</th>';
													echo '<th class="text-center">White</th>';
													echo '<th class="text-center">Yellow</th>';
													echo '<th class="text-center">Arm Chair</th>';
													echo '<th class="text-center">Status</th>';
													echo '<th class="text-center">Action</th>';
													break;
												case 7:
													echo '<th class="text-center">Long</th>';
													echo '<th class="text-center">Square</th>';
													echo '<th class="text-center">Circle</th>';
													echo '<th class="text-center">Mini</th>';
													echo '<th class="text-center">Status</th>';
													echo '<th class="text-center">Action</th>';
													break;
												case 8:
													echo '<th class="text-center">Smart TV</th>';
													echo '<th class="text-center">Switch</th>';
													echo '<th class="text-center">Air Condition Unit</th>';
													echo '<th class="text-center">Printer</th>';
													echo '<th class="text-center">Status</th>';
													echo '<th class="text-center">Action</th>';
													break;
											}
											?>
										</tr>
									</thead>
									<tbody>
										<?php
										foreach ($equipment_category as $category) {
											$data = json_decode($category['data']);
											switch ($category['category_id']) {
												case 1:
													echo '<tr>';
													echo '<td class="text-center">' . $data->pc_number . '</td>';
													echo '<td class="text-center">' . $data->manufacturer . '</td>';
													echo '<td class="text-center">' . $data->serial_no . '</td>';
													echo '<td class="text-center">' . $data->os_version . '</td>';
													echo '<td class="text-center">' . $data->ram . '</td>';
													echo '<td class="text-center">' . $data->processor . '</td>';
													echo '<td class="text-center">' . $data->status . '</td>';
													echo '<td class="text-center">';
													echo '<button type="button" class="btn btn-default btn-sm btn-flat border-info wave-effect text-info dropdown-toggle" data-toggle="dropdown" aria-expanded="true">';
													echo '<span class="sr-only">Toggle Dropdown</span>';
													echo '</button>';
													echo '<div class="dropdown-menu" role="menu">';
													echo '<a class="dropdown-item edit_equipment" href="javascript:void(0)" data-id="' . $category['id'] . '" data-category_id="' . $category['category_id'] . '">Edit</a>';
													echo '<div class="dropdown-divider"></div>';
													echo '<a class="dropdown-item delete_equipment" href="javascript:void(0)" data-id="' . $category['id'] . '">Delete</a>';
													echo '</div>';
													echo '</td>';
													echo '</tr>';
													break;
												case 2:
													echo '<tr>';
													echo '<td class="text-center">' . $data->monitor_number . '</td>';
													echo '<td class="text-center">' . $data->manufacturer . '</td>';
													echo '<td class="text-center">' . $data->serial_no . '</td>';
													echo '<td class="text-center">' . $data->status . '</td>';
													echo '<td class="text-center">';
													echo '<button type="button" class="btn btn-default btn-sm btn-flat border-info wave-effect text-info dropdown-toggle" data-toggle="dropdown" aria-expanded="true">';
													echo '<span class="sr-only">Toggle Dropdown</span>';
													echo '</button>';
													echo '<div class="dropdown-menu" role="menu">';
													echo '<a class="dropdown-item edit_equipment" href="javascript:void(0)" data-id="' . $category['id'] . '" data-category_id="' . $category['category_id'] . '">Edit</a>';
													echo '<div class="dropdown-divider"></div>';
													echo '<a class="dropdown-item delete_equipment" href="javascript:void(0)" data-id="' . $category['id'] . '">Delete</a>';
													echo '</div>';
													echo '</td>';
													echo '</tr>';
													break;
												case 3:
												case 4:
												case 6:
													echo '<tr>';
													echo '<td class="text-center">' . $data->functional . '</td>';
													echo '<td class="text-center">' . $data->not_functional . '</td>';
													echo '<td class="text-center">';
													echo '<button type="button" class="btn btn-default btn-sm btn-flat border-info wave-effect text-info dropdown-toggle" data-toggle="dropdown" aria-expanded="true">';
													echo '<span class="sr-only">Toggle Dropdown</span>';
													echo '</button>';
													echo '<div class="dropdown-menu" role="menu">';
													echo '<a class="dropdown-item edit_equipment" href="javascript:void(0)" data-id="' . $category['id'] . '" data-category_id="' . $category['category_id'] . '">Edit</a>';
													echo '<div class="dropdown-divider"></div>';
													echo '<a class="dropdown-item delete_equipment" href="javascript:void(0)" data-id="' . $category['id'] . '">Delete</a>';
													echo '</div>';
													echo '</td>';
													echo '</tr>';
													break;
												case 8:
													echo '<tr>';
													echo '<td class="text-center">' . $data->green . '</td>';
													echo '<td class="text-center">' . $data->white . '</td>';
													echo '<td class="text-center">' . $data->yellow . '</td>';
													echo '<td class="text-center">' . $data->arm_chair . '</td>';
													echo '<td class="text-center">' . $data->status . '</td>';
													echo '<td class="text-center">';
													echo '<button type="button" class="btn btn-default btn-sm btn-flat border-info wave-effect text-info dropdown-toggle" data-toggle="dropdown" aria-expanded="true">';
													echo '<span class="sr-only">Toggle Dropdown</span>';
													echo '</button>';
													echo '<div class="dropdown-menu" role="menu">';
													echo '<a class="dropdown-item edit_equipment" href="javascript:void(0)" data-id="' . $category['id'] . '" data-category_id="' . $category['category_id'] . '">Edit</a>';
													echo '<div class="dropdown-divider"></div>';
													echo '<a class="dropdown-item delete_equipment" href="javascript:void(0)" data-id="' . $category['id'] . '">Delete</a>';
													echo '</div>';
													echo '</td>';
													echo '</tr>';
													break;
												case 5:
													echo '<tr>';
													echo '<td class="text-center">' . $data->long . '</td>';
													echo '<td class="text-center">' . $data->square . '</td>';
													echo '<td class="text-center">' . $data->circle . '</td>';
													echo '<td class="text-center">' . $data->mini . '</td>';
													echo '<td class="text-center">' . $data->status . '</td>';
													echo '<td class="text-center">';
													echo '<button type="button" class="btn btn-default btn-sm btn-flat border-info wave-effect text-info dropdown-toggle" data-toggle="dropdown" aria-expanded="true">';
													echo '<span class="sr-only">Toggle Dropdown</span>';
													echo '</button>';
													echo '<div class="dropdown-menu" role="menu">';
													echo '<a class="dropdown-item edit_equipment" href="javascript:void(0)" data-id="' . $category['id'] . '" data-category_id="' . $category['category_id'] . '">Edit</a>';
													echo '<div class="dropdown-divider"></div>';
													echo '<a class="dropdown-item delete_equipment" href="javascript:void(0)" data-id="' . $category['id'] . '">Delete</a>';
													echo '</div>';
													echo '</td>';
													echo '</tr>';
													break;
												case 7:
													echo '<tr>';
													echo '<td class="text-center">' . $data->smart_tv . '</td>';
													echo '<td class="text-center">' . $data->switch . '</td>';
													echo '<td class="text-center">' . $data->air_condition_unit . '</td>';
													echo '<td class="text-center">' . $data->printer . '</td>';
													echo '<td class="text-center">' . $data->status . '</td>';
													echo '<td class="text-center">';
													echo '<button type="button" class="btn btn-default btn-sm btn-flat border-info wave-effect text-info dropdown-toggle" data-toggle="dropdown" aria-expanded="true">';
													echo '<span class="sr-only">Toggle Dropdown</span>';
													echo '</button>';
													echo '<div class="dropdown-menu" role="menu">';
													echo '<a class="dropdown-item edit_equipment" href="javascript:void(0)" data-id="' . $category['id'] . '" data-category_id="' . $category['category_id'] . '">Edit</a>';
													echo '<div class="dropdown-divider"></div>';
													echo '<a class="dropdown-item delete_equipment" href="javascript:void(0)" data-id="' . $category['id'] . '">Delete</a>';
													echo '</div>';
													echo '</td>';
													echo '</tr>';
													break;
											}
										}	?>
									</tbody>
								</table>
							</div>
						</div>
				<?php }
				} ?>
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

		$('.edit_equipment').click(function() {
			uni_modal("Edit Equipment", "<?= $_SESSION['login_view_folder'] ?>edit_equipment.php?id=" + $(this).attr('data-id'))
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