<?php include 'db_connect.php' ?>
<div class="col-lg-12">
	<div class="card card-outline card-success">
		<div class="card-header">
			<div class="card-tools">
				<a class="btn btn-block btn-sm btn-default btn-flat border-primary" href="./index.php?page=new_maintenance_staff"><i class="fa fa-plus"></i> Add New Maintenance</a>
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
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
					$class = array();
					$classes = $conn->query("SELECT id,concat(curriculum,' ',level,' - ',section) as `class` FROM class_list");
					while ($row = $classes->fetch_assoc()) {
						$class[$row['id']] = $row['class'];
					}
					$qry = $conn->query("SELECT *,concat(firstname,' ',lastname) as name FROM student_list order by concat(firstname,' ',lastname) asc");
					while ($row = $qry->fetch_assoc()) :
					?>
						<tr>
							<th class="text-center"><?php echo $i++ ?></th>
							<td><b><?php echo $row['school_id'] ?></b></td>
							<td><b><?php echo ucwords($row['name']) ?></b></td>
							<td><b><?php echo $row['email'] ?></b></td>

							<td class="text-center">
								<button type="button" class="btn btn-default btn-sm btn-flat border-info wave-effect text-info dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
									Action
								</button>
								<div class="dropdown-menu" style="">
									<a class="dropdown-item view_student" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">View</a>
									<div class="dropdown-divider"></div>
									<a class="dropdown-item" href="./index.php?page=edit_maintenance_staff&id=<?php echo $row['id'] ?>">Edit</a>
									<div class="dropdown-divider"></div>
									<a class="dropdown-item delete_student" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">Delete</a>
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
		$('.view_student').click(function() {
			uni_modal("<i class='fa fa-id-card'></i> student Details", "<?php echo $_SESSION['login_view_folder'] ?>view_student.php?id=" + $(this).attr('data-id'))
		})
		$('.delete_student').click(function() {
			_conf("Are you sure to delete this student?", "delete_student", [$(this).attr('data-id')])
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

	function delete_student($id) {
		start_load()
		$.ajax({
			url: 'ajax.php?action=delete_student',
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