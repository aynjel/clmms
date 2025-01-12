<?php include 'db_connect.php' ?>
<div class="col-lg-12">
	<div class="card card-outline card-primary">
		<div class="card-header">
			<div class="card-tools">
				<a class="btn btn-block btn-sm btn-default btn-flat border-primary new_room" href="index.php?page=new_room"><i class="fa fa-plus"></i> Add New</a>
			</div>
		</div>
		<div class="card-body">
			<table class="table tabe-hover table-bordered" id="room-list">
				<thead>
					<tr>
						<th>Room</th>
						<th>Capacity</th>
						<th>Assigned Faculty 1</th>
						<th>Assigned Faculty 2</th>
						<th>Status</th>
						<th style="text-align: center;">Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
					$qry = $conn->query("SELECT * FROM `room_list` order by id asc");
					while ($row = $qry->fetch_assoc()) :

					?>
						<tr>
							<td><b><?= $row['room'] ?></b></td>
							<td><b><?= $row['capacity'] ?></b></td>
							<td>
								<?php if ($row['faculty_id_1'] == null) : ?>
									No faculty assigned
								<?php else : ?>
									<?php
									$fac = $conn->query("SELECT * FROM faculty_list where id = " . $row['faculty_id_1'])->fetch_array();
									?>
									<b><?= ucwords($fac['firstname'] . ' ' . $fac['lastname']) ?></b>
								<?php endif; ?>
							</td>
							<td>
								<?php if ($row['faculty_id_2'] == null) : ?>
									No faculty assigned
								<?php else : ?>
									<?php
									$fac = $conn->query("SELECT * FROM faculty_list where id = " . $row['faculty_id_2'])->fetch_array();
									?>
									<b><?= ucwords($fac['firstname'] . ' ' . $fac['lastname']) ?></b>
								<?php endif; ?>
							</td>
							<td>
								<b>
									<?php if ($row['status'] == 1) : ?>
										<span class="badge badge-success">Active</span>
									<?php else : ?>
										<span class="badge badge-danger">Inactive</span>
									<?php endif; ?>
								</b>
							</td>
							<td class="text-center">
								<div class="btn-group">
									<a href="javascript:void(0)" data-id="<?= $row['id'] ?>" class="btn btn-sm btn-primary btn-flat manage_room">
										<i class="fas fa-edit"></i>
									</a>
									<button type="button" class="btn btn-sm btn-danger btn-flat delete_room" data-id="<?= $row['id'] ?>">
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
<script>
	$(document).ready(function() {
		$('#room-list').dataTable({
			dom: 'Bfrtip',
			buttons: [
				'excel', {
					extend: 'print',
					text: 'Print',
					autoPrint: true,
					title: '',
					// Add header logo 
					messageTop: '<header style="display: flex; justify-content: space-between; align-items: center;"><img src="https://raw.githubusercontent.com/aynjel/clmms/main/assets/print-logo-1.png" alt="CTU Logo" style="" /><p style="text-align: center;font-size: 20px;"> Republic of the Philippines <br> <b> CEBU TECHNOLOGICAL UNIVERSITY <br> TUBURAN CAMPUS </b> <br> <small> Poblacion 8, Tuburan, Cebu, Philippines <br> Website: http://www.ctu.edu.ph E-mail: tuburan.campus@ctu.edu.ph <br> Tel. No. (032) 463-9350 </small> </p><img src="https://raw.githubusercontent.com/aynjel/clmms/main/assets/print-logo-2.png" alt="ASEAN Logo" style="" /></header>',
					// Add footer logo fixed in the bottom center
					messageBottom: '<footer style="text-align: center; position: fixed; bottom: 0; width: 100%;"><img src="https://raw.githubusercontent.com/aynjel/clmms/main/assets/print-logo-3.png" alt="Footer Logo" /></footer>'
				}
			]
		})
		$('.manage_room').click(function() {
			uni_modal("Manage room", "<?= $_SESSION['login_view_folder'] ?>manage_room.php?id=" + $(this).attr('data-id'))
		})
		$('.delete_room').click(function() {
			_conf("Are you sure to delete this room?", "delete_room", [$(this).attr('data-id')])
		})
		$('#list').dataTable({
			dom: 'Bfrtip',
			buttons: [
				'excel', 'pdf', 'print'
			],
		})
	})

	function delete_room($id) {
		start_load()
		$.ajax({
			url: 'ajax.php?action=delete_room',
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