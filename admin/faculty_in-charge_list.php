<?php include 'db_connect.php' ?>
<div class="col-lg-12">
	<div class="card card-outline card-success">
		<div class="card-header">
			<div class="card-tools">
				<a class="btn btn-block btn-sm btn-default btn-flat border-primary" href="./index.php?page=new_faculty_in-charge"><i class="fa fa-plus"></i> Add New Faculty</a>
			</div>
		</div>
		<div class="card-body">
			<table class="table tabe-hover table-bordered" id="list">
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th>Employee ID</th>
						<th>Name</th>
						<th>Email</th>
						<th colspan="2">Room/s Assigned</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
					$qry = $conn->query("SELECT *,concat(firstname,' ',lastname) as name FROM faculty_list order by concat(firstname,' ',lastname) asc");
					while ($row = $qry->fetch_assoc()) :
					?>
						<tr>
							<th class="text-center"><?php echo $i++ ?></th>
							<td><b><?php echo $row['school_id'] ?></b></td>
							<td><b><?php echo ucwords($row['name']) ?></b></td>
							<td><b><?php echo $row['email'] ?></b></td>
							<td><b><?php
											$room = $conn->query("SELECT * FROM room_list where faculty_id_1 = " . $row['id']);
											echo ucwords($room->num_rows > 0 ? $room->fetch_array()['room'] : 'N/A');
											?></b></td>
							<td><b><?php
											$room = $conn->query("SELECT * FROM room_list where faculty_id_2 = " . $row['id']);
											echo ucwords($room->num_rows > 0 ? $room->fetch_array()['room'] : 'N/A');
											?></b></td>
							<td class="text-center">
								<button type="button" class="btn btn-default btn-sm btn-flat border-info wave-effect text-info dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
									Action
								</button>
								<div class="dropdown-menu" style="">
									<a class="dropdown-item view_faculty" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">View</a>
									<div class="dropdown-divider"></div>
									<a class="dropdown-item" href="./index.php?page=edit_faculty&id=<?php echo $row['id'] ?>">Edit</a>
									<div class="dropdown-divider"></div>
									<a class="dropdown-item delete_faculty" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">Delete</a>
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
		$('.view_faculty').click(function() {
			uni_modal("<i class='fa fa-id-card'></i> Faculty Details", "<?php echo $_SESSION['login_view_folder'] ?>view_faculty.php?id=" + $(this).attr('data-id'))
		})
		$('.delete_faculty').click(function() {
			_conf("Are you sure to delete this faculty?", "delete_faculty", [$(this).attr('data-id')])
		})
		$('#list').dataTable({
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
	})

	function delete_faculty($id) {
		start_load()
		$.ajax({
			url: 'ajax.php?action=delete_faculty',
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