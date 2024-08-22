<?php include 'db_connect.php' ?>
<div class="row">
	<div class="col-md-4">
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
	<div class="col-md-4">
		<div class="form-group">
			<label for="" class="control-label">Filter by Room Status</label>
			<select name="status" id="status" class="custom-select custom-select-sm" onchange="location.href = 'index.php?page=equipment_list&status=' + this.value">
				<option selected disabled hidden>Select Status</option>
				<option value="1" <?php echo isset($_GET['status']) && $_GET['status'] == 1 ? 'selected' : '' ?>>Active</option>
				<option value="0" <?php echo isset($_GET['status']) && $_GET['status'] == 0 ? 'selected' : '' ?>>Inactive</option>
			</select>
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<label for="" class="control-label">Filter by Condition</label>
			<select name="condition" id="condition" class="custom-select custom-select-sm" onchange="location.href = 'index.php?page=equipment_list&condition=' + this.value">
				<option selected disabled hidden>Select Condition</option>
				<?php
				$conditions = ['Good', 'Bad', 'Refurbished', 'Damaged'];
				?>
				<?php foreach ($conditions as $key => $value) : ?>
					<option value="<?php echo $value ?>" <?php echo isset($_GET['condition']) && $_GET['condition'] == $value ? 'selected' : '' ?>><?php echo $value ?></option>
				<?php endforeach; ?>
			</select>
		</div>
	</div>
</div>
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
				<table class="table table-hover table-bordered equipment_list">
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
						<table class="table table-hover table-bordered equipment_list">
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
							<table class="table table-hover table-bordered equipment_list">
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
<?php } elseif (isset($_GET['condition']) && $_GET['condition'] != '') {
	// get room where equipment condition is equal to $_GET['condition']
	$roomQuery = $conn->query("SELECT * FROM room_list where id in (SELECT room_id FROM equipment_list where `condition` = '{$_GET['condition']}' group by room_id) order by id desc"); ?>
	<?php if ($roomQuery->num_rows <= 0) : ?>
		<div class="col-lg-12">
			<div class="card card-outline card-danger">
				<div class="card-body">
					<center><b>No Data to display</b></center>
				</div>
			</div>
		</div>
	<?php else : ?>
		<?php while ($row = $roomQuery->fetch_assoc()) : ?>
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
						<table class="table table-hover table-bordered equipment_list">
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
								$qry = $conn->query("SELECT * FROM equipment_list where room_id = " . $row['id'] . " and `condition` = '{$_GET['condition']}' order by id asc");
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
<?php } else {
	$eqList = $conn->query("SELECT * FROM room_list order by id desc");
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
						<table class="table table-hover table-bordered equipment_list">
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
			buttons: [{
				extend: 'excel',
				text: 'Excel',
				title: 'Inventory Report Details',
			}, {
				extend: 'print',
				text: 'Print',
				autoPrint: true,
				title: '',
				// Add header logo 
				messageTop: '<header style="display: flex; justify-content: space-between; align-items: center;"><img src="https://raw.githubusercontent.com/aynjel/clmms/main/assets/print-logo-1.png" alt="CTU Logo" style="" /><p style="text-align: center;font-size: 20px;"> Republic of the Philippines <br> <b> CEBU TECHNOLOGICAL UNIVERSITY <br> TUBURAN CAMPUS </b> <br> <small> Poblacion 8, Tuburan, Cebu, Philippines <br> Website: http://www.ctu.edu.ph E-mail: tuburan.campus@ctu.edu.ph <br> Tel. No. (032) 463-9350 </small> </p><img src="https://raw.githubusercontent.com/aynjel/clmms/main/assets/print-logo-2.png" alt="ASEAN Logo" style="" /></header>',
				// Add footer logo fixed in the bottom center
				messageBottom: '<footer style="text-align: center; position: fixed; bottom: 0; width: 100%;"><img src="https://raw.githubusercontent.com/aynjel/clmms/main/assets/print-logo-3.png" alt="Footer Logo" /></footer>'
			}]
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