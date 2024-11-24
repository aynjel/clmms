<?php include 'db_connect.php' ?>

<div class="row">
	<div class="col-lg-12">
		<?php
		$query = "SELECT * from tb_report order by date desc";
		$result = mysqli_query($conn, $query);
		?>
		<div class="card card-outline card-primary">
			<div class="card-header">
				<h3 class="card-title text-capitalize font-weight-bold">
					<i class="fa fa-list"></i> Report's (<?= mysqli_num_rows($result) ?>)
				</h3>
				<div class="card-tools">
					<ul class="pagination pagination-sm m-0 float-right">
						<li class="page-item">
							<a class="btn btn-block btn-sm btn-default btn-flat border-primary new_report" href="javascript:void(0)"><i class="fa fa-plus"></i> New Report</a>
						</li>
					</ul>
				</div>
			</div>
			<div class="card-body">
				<table class="table tabe-hover table-bordered report_list">
					<thead>
						<tr>
							<th scope="col">Office/Area</th>
							<th scope="col">Machine/Equipment/Facility</th>
							<th scope="col">Date of Inspection</th>
							<th scope="col">Status, Condition, Problem</th>
							<th scope="col">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php while ($row = mysqli_fetch_array($result)) : ?>
							<tr>
								<td><?php echo $row['area'] ?></td>
								<td><?php echo $row['equipment'] ?></td>
								<td>
									<?php echo date('m/d/Y', strtotime($row['date'])) ?>
								</td>
								<td><?php echo $row['status'] ?></td>
								<td class="text-center">
									<div class="btn-group">
										<a href="javascript:void(0)" data-id="<?= $row['id'] ?>" class="btn btn-primary btn-flat manage_report">
											<i class="fas fa-edit"></i>
										</a>
										<button type="button" class="btn btn-danger btn-flat delete_report" data-id="<?= $row['id'] ?>">
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
</div>

<script>
	$(document).ready(function() {
		const table = $('.report_list').DataTable({
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
	});

	$('.view_report_details').click(function() {
		uni_modal("Maintenance Report Details", "<?php echo $_SESSION['login_view_folder'] ?>view_report_details.php?id=" + $(this).attr('data-id'))
	})
	$('.new_report').click(function() {
		uni_modal("New Report", "<?= $_SESSION['login_view_folder'] ?>manage_report_1.php", "large")
	})
	$('.manage_report').click(function() {
		uni_modal("Manage Report", "<?= $_SESSION['login_view_folder'] ?>manage_report_1.php?id=" + $(this).attr('data-id'))
	})
	$('.delete_report').click(function() {
		_conf("Are you sure to delete this report?", "delete_report", [$(this).attr('data-id')])
	})

	function delete_report($id) {
		start_load()
		$.ajax({
			url: 'ajax.php?action=delete_report_fa1',
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