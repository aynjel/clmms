<?php include 'db_connect.php' ?>
<?php
$eqList = $conn->query("SELECT * FROM room_list WHERE faculty_id = {$_SESSION['login_id']} order by id desc");
?>
<!-- <div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<label for="" class="control-label">Filter by Room</label>
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
					<option value="0" <?php echo isset($_GET['room_id']) && $_GET['room_id'] == 0 ? 'selected' : '' ?>>All</option>
				<?php endif; ?>
				<?php
				while ($row = $room->fetch_assoc()) :
				?>
					<option value="<?php echo $row['id'] ?>" <?php echo isset($_GET['room_id']) && $_GET['room_id'] == $row['id'] ? 'selected' : '' ?>>Room: <?php echo $row['room'] ?></option>
				<?php endwhile; ?>
			</select>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label for="" class="control-label">Filter by Status</label>
			<select name="status" id="status" class="custom-select custom-select-sm" onchange="location.href = 'index.php?page=equipment_list&status=' + this.value">
				<option selected disabled hidden>Select Status</option>
				<option value="1" <?php echo isset($_GET['status']) && $_GET['status'] == 1 ? 'selected' : '' ?>>Active</option>
				<option value="0" <?php echo isset($_GET['status']) && $_GET['status'] == 0 ? 'selected' : '' ?>>Inactive</option>
			</select>
		</div>
	</div> -->
<!-- <div class="col-md-4">
		<div class="form-group">
			<label for="" class="control-label">Filter by Faculty</label>
			<select name="faculty_id" id="faculty_id" class="custom-select custom-select-sm" onchange="location.href = 'index.php?page=equipment_list&faculty_id=' + this.value">
				<option selected disabled hidden>Select Faculty</option>
				<?php
				$faculty = $conn->query("SELECT * FROM faculty_list order by id asc");
				if ($faculty->num_rows <= 0) : ?>
					<option disabled>No Faculty Found</option>
				<?php endif; ?>
				<?php while ($row = $faculty->fetch_assoc()) : ?>
					<option value="<?php echo $row['id'] ?>" <?php echo isset($_GET['faculty_id']) && $_GET['faculty_id'] == $row['id'] ? 'selected' : '' ?>><?php echo $row['firstname'] . ' ' . $row['lastname'] ?></option>
				<?php endwhile; ?>
			</select>
		</div>
	</div> -->
<!-- </div> -->
<?php
if (isset($_GET['room_id']) && $_GET['room_id'] > 0) {
	$eqList = $conn->query("SELECT * FROM room_list where id = " . $_GET['room_id']);
	$row = $eqList->fetch_assoc();
?>
	<div class="col-lg-12">
		<div class="card card-outline <?php echo $row['status'] == 1 ? "card-success" : "card-danger" ?>">
			<div class="card-header">
				<h3 class="card-title text-capitalize font-weight-bold">
					<?php if ($row['status'] == 1) : ?>
						<span class="badge badge-success">Active</span>
					<?php else : ?>
						<span class="badge badge-danger">Inactive</span>
					<?php endif; ?>
					<br>
					Assign: Room <?php echo $row['room'] ?>
				</h3>
				<?php if ($row['status'] == 1) : ?>
					<div class="card-tools">
						<a class="btn btn-block btn-sm btn-default btn-flat border-primary" href="./index.php?page=new_equipment&room_id=<?php echo $row['id'] ?>"><i class="fa fa-plus"></i> Add New Equipment</a>
					</div>
				<?php endif; ?>
			</div>
			<div class="card-body">
				<table class="table tabe-hover table-bordered equipment_list">
					<thead>
						<tr>
							<th class="text-center">Name</th>
							<th>Quantity</th>
							<th>Description</th>
							<th>Manufacturer</th>
							<th>Serial No.</th>
							<th>Condition</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$qry = $conn->query("SELECT * FROM equipment_list where room_id = " . $row['id'] . " order by id asc");
						while ($row = $qry->fetch_assoc()) :
						?>
							<tr>
								<td class="text-center">
									<?php echo $row['name'] ?>
								</td>
								<td class="">
									<?php echo $row['quantity'] ?>
								</td>
								<td class="">
									<?php echo $row['description'] ?>
								</td>
								<td class="">
									<?php echo $row['manufacturer'] ?>
								</td>
								<td class="">
									<?php echo $row['serial_no'] ?>
								</td>
								<td class="">
									<?php echo $row['condition'] ?>
								</td>
								<td class="text-center">
									<div class="btn-group">
										<a href="./index.php?page=edit_equipment&id=<?php echo $row['id'] ?>" class="btn btn-primary btn-flat">
											<i class="fas fa-edit"></i>
										</a>
										<button type="button" class="btn btn-danger btn-flat delete_equipment" data-id="<?php echo $row['id'] ?>">
											<i class="fas fa-trash"></i>
										</button>
									</div>
								</td>
							</tr>
						<?php endwhile; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
<?php } elseif (isset($_GET['status']) && $_GET['status'] > -1) {
	$eqList = $conn->query("SELECT * FROM room_list where status = " . $_GET['status'] . " order by id desc");
?>
	<?php if ($eqList->num_rows <= 0) : ?>
		<div class="col-lg-12">
			<div class="card card-outline card-danger">
				<div class="card-body">
					<center><b>No Data to display</b></center>
				</div>
			</div>
		</div>
	<?php else : ?>
		<?php while ($row = $eqList->fetch_assoc()) : ?>
			<div class="col-lg-12">
				<div class="card card-outline <?php echo $row['status'] == 1 ? "card-success" : "card-danger" ?>">
					<div class="card-header">
						<h3 class="card-title text-capitalize font-weight-bold">
							<?php if ($row['status'] == 1) : ?>
								<span class="badge badge-success">Active</span>
							<?php else : ?>
								<span class="badge badge-danger">Inactive</span>
							<?php endif; ?>
							<br>
							Assign: Room <?php echo $row['room'] ?>
						</h3>
						<?php if ($row['status'] == 1) : ?>
							<div class="card-tools">
								<a class="btn btn-block btn-sm btn-default btn-flat border-primary" href="./index.php?page=new_equipment&room_id=<?php echo $row['id'] ?>"><i class="fa fa-plus"></i> Add New Equipment</a>
							</div>
						<?php endif; ?>
					</div>
					<div class="card-body">
						<table class="table tabe-hover table-bordered equipment_list">
							<thead>
								<tr>
									<th class="text-center">Name</th>
									<th>Quantity</th>
									<th>Description</th>
									<th>Manufacturer</th>
									<th>Serial No.</th>
									<th>Condition</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$qry = $conn->query("SELECT * FROM equipment_list where room_id = " . $row['id'] . " order by id asc");
								while ($row = $qry->fetch_assoc()) :
								?>
									<tr>
										<td class="text-center">
											<?php echo $row['name'] ?>
										</td>
										<td class="">
											<?php echo $row['quantity'] ?>
										</td>
										<td class="">
											<?php echo $row['description'] ?>
										</td>
										<td class="">
											<?php echo $row['manufacturer'] ?>
										</td>
										<td class="">
											<?php echo $row['serial_no'] ?>
										</td>
										<td class="">
											<?php echo $row['condition'] ?>
										</td>
										<td class="text-center">
											<div class="btn-group">
												<a href="./index.php?page=edit_equipment&id=<?php echo $row['id'] ?>" class="btn btn-primary btn-flat">
													<i class="fas fa-edit"></i>
												</a>
												<button type="button" class="btn btn-danger btn-flat delete_equipment" data-id="<?php echo $row['id'] ?>">
													<i class="fas fa-trash"></i>
												</button>
											</div>
										</td>
									</tr>
								<?php endwhile; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		<?php endwhile; ?>
	<?php endif; ?>
	<?php } elseif (isset($_GET['faculty_id']) && $_GET['faculty_id'] > 0) {
	$faList = $conn->query("SELECT * FROM faculty_list where id = " . $_GET['faculty_id']);
	$row = $faList->fetch_assoc();
	if ($faList->num_rows <= 0) :
		$eqList = $conn->query("SELECT * FROM room_list where id = " . $row['room_id']);
		$row = $eqList->fetch_assoc();
	?>
		<?php if ($eqList->num_rows <= 0) : ?>
			<div class="col-lg-12">
				<div class="card card-outline card-danger">
					<div class="card-body">
						<center><b>No Data to display</b></center>
					</div>
				</div>
			</div>
		<?php else : ?>
			<?php while ($row = $eqList->fetch_assoc()) : ?>
				<div class="col-lg-12">
					<div class="card card-outline <?php echo $row['status'] == 1 ? "card-success" : "card-danger" ?>">
						<div class="card-header">
							<h3 class="card-title text-capitalize font-weight-bold">
								<?php if ($row['status'] == 1) : ?>
									<span class="badge badge-success">Active</span>
								<?php else : ?>
									<span class="badge badge-danger">Inactive</span>
								<?php endif; ?>
								<br>
								Assign: Room <?php echo $row['room'] ?>
							</h3>
							<?php if ($row['status'] == 1) : ?>
								<div class="card-tools">
									<a class="btn btn-block btn-sm btn-default btn-flat border-primary" href="./index.php?page=new_equipment&room_id=<?php echo $row['id'] ?>"><i class="fa fa-plus"></i> Add New Equipment</a>
								</div>
							<?php endif; ?>
						</div>
						<div class="card-body">
							<table class="table tabe-hover table-bordered equipment_list">
								<thead>
									<tr>
										<th class="text-center">Name</th>
										<th>Quantity</th>
										<th>Description</th>
										<th>Manufacturer</th>
										<th>Serial No.</th>
										<th>Condition</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$qry = $conn->query("SELECT * FROM equipment_list where room_id = " . $row['id'] . " order by id asc");
									while ($row = $qry->fetch_assoc()) :
									?>
										<tr>
											<td class="text-center">
												<?php echo $row['name'] ?>
											</td>
											<td class="">
												<?php echo $row['quantity'] ?>
											</td>
											<td class="">
												<?php echo $row['description'] ?>
											</td>
											<td class="">
												<?php echo $row['manufacturer'] ?>
											</td>
											<td class="">
												<?php echo $row['serial_no'] ?>
											</td>
											<td class="">
												<?php echo $row['condition'] ?>
											</td>
											<td class="text-center">
												<div class="btn-group">
													<a href="./index.php?page=edit_equipment&id=<?php echo $row['id'] ?>" class="btn btn-primary btn-flat">
														<i class="fas fa-edit"></i>
													</a>
													<button type="button" class="btn btn-danger btn-flat delete_equipment" data-id="<?php echo $row['id'] ?>">
														<i class="fas fa-trash"></i>
													</button>
												</div>
											</td>
										</tr>
									<?php endwhile; ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			<?php endwhile; ?>
		<?php endif; ?>
	<?php endif; ?>
<?php } else { ?>
	<?php if ($eqList->num_rows <= 0) : ?>
		<div class="col-lg-12">
			<div class="card card-outline card-danger">
				<div class="card-body">
					<center><b>No Data to display</b></center>
				</div>
			</div>
		</div>
	<?php else : ?>
		<?php while ($row = $eqList->fetch_assoc()) : ?>
			<div class="col-lg-12">
				<div class="card card-outline <?php echo $row['status'] == 1 ? "card-success" : "card-danger" ?>">
					<div class="card-header">
						<h3 class="card-title text-capitalize font-weight-bold">
							<?php if ($row['status'] == 1) : ?>
								<span class="badge badge-success">Active</span>
							<?php else : ?>
								<span class="badge badge-danger">Inactive</span>
							<?php endif; ?>
							<br>
							Assign: Room <?php echo $row['room'] ?>
						</h3>
						<?php if ($row['status'] == 1) : ?>
							<div class="card-tools">
								<a class="btn btn-block btn-sm btn-default btn-flat border-primary" href="./index.php?page=new_equipment&room_id=<?php echo $row['id'] ?>"><i class="fa fa-plus"></i> Add New Equipment</a>
							</div>
						<?php endif; ?>
					</div>
					<div class="card-body">
						<table class="table tabe-hover table-bordered equipment_list">
							<thead>
								<tr>
									<th class="text-center">Name</th>
									<th>Quantity</th>
									<th>Description</th>
									<th>Manufacturer</th>
									<th>Serial No.</th>
									<th>Condition</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$qry = $conn->query("SELECT * FROM equipment_list where room_id = " . $row['id'] . " order by id asc");
								while ($row = $qry->fetch_assoc()) :
								?>
									<tr>
										<td class="text-center">
											<?php echo $row['name'] ?>
										</td>
										<td class="">
											<?php echo $row['quantity'] ?>
										</td>
										<td class="">
											<?php echo $row['description'] ?>
										</td>
										<td class="">
											<?php echo $row['manufacturer'] ?>
										</td>
										<td class="">
											<?php echo $row['serial_no'] ?>
										</td>
										<td class="">
											<?php echo $row['condition'] ?>
										</td>
										<td class="text-center">
											<div class="btn-group">
												<a href="./index.php?page=edit_equipment&id=<?php echo $row['id'] ?>" class="btn btn-primary btn-flat">
													<i class="fas fa-edit"></i>
												</a>
												<button type="button" class="btn btn-danger btn-flat delete_equipment" data-id="<?php echo $row['id'] ?>">
													<i class="fas fa-trash"></i>
												</button>
											</div>
										</td>
									</tr>
								<?php endwhile; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		<?php endwhile; ?>
	<?php endif; ?>
<?php } ?>

<script>
	$(document).ready(function() {
		$('.view_equipment').click(function() {
			uni_modal("<i class='fa fa-id-card'></i> equipment Details", "<?php echo $_SESSION['login_view_folder'] ?>view_equipment.php?id=" + $(this).attr('data-id'))
		})
		$('.delete_equipment').click(function() {
			_conf("Are you sure to delete this equipment?", "delete_equipment", [$(this).attr('data-id')])
		})
		$('.equipment_list').dataTable({
			dom: 'Bfrtip',
			buttons: [
				'excel', 'pdf', 'print'
			],
		})
	})

	function delete_equipment($id) {
		start_load()
		$.ajax({
			url: 'ajax.php?action=delete_equipment',
			method: 'POST',
			data: {
				id: $id
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