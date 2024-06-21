<?php include 'db_connect.php' ?>
<?php
$query = "SELECT * from tb_data WHERE user_id = {$_SESSION['login_id']} ORDER BY id DESC";
$result = mysqli_query($conn, $query);
?>
<div class="row">
	<div class="col-lg-12">
		<div class="card card-outline card-primary">
			<div class="card-header">
				<h3 class="card-title text-capitalize font-weight-bold">
					Maintenance Report List (<?= mysqli_num_rows($result) ?>)
				</h3>
				<div class="card-tools">
					<ul class="pagination pagination-sm m-0 float-right">
						<li class="page-item">
							<a class="btn btn-block btn-sm btn-default btn-flat border-primary new_request" href="javascript:void(0)"><i class="fa fa-plus"></i> New Request</a>
						</li>
					</ul>
				</div>
			</div>
			<div class="card-body">
				<table border="0" cellspacing="5" cellpadding="5">
					<tbody>
						<tr>
							<td>Minimum date:</td>
							<td><input type="date" id="min"></td>
						</tr>
						<tr>
							<td>Maximum date:</td>
							<td><input type="date" id="max"></td>
						</tr>
					</tbody>
				</table>
				<table class="table tabe-hover table-bordered report_list">
					<thead>
						<tr>
							<!-- <th scope="col">#</th> -->
							<th scope="col">Section</th>
							<!-- <th scope="col">Description</th> -->
							<th scope="col">Action Taken</th>
							<th scope="col">Remarks</th>
							<th scope="col">Evaluation Status</th>
							<!-- <th scope="col">Date Created</th> -->
							<th scope="col">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php while ($row = mysqli_fetch_array($result)) : ?>
							<tr>
								<!-- <td class="text-center"><?php echo $row['id'] ?></td> -->
								<td><?php echo substr($row['languages'], 0, -1) ?></td>
								<!-- <td class="text-center"><?php echo $row['description'] ?></td> -->
								<td class="text-center">
									<?php echo date('m/d/Y', strtotime($row['date'])) ?>
								</td>
								<td class="text-center">
									<?php if ($row['status'] == 1) : ?>
										<span class="badge badge-success">Accomplished</span>
									<?php else : ?>
										<span class="badge badge-warning">Under Process</span>
									<?php endif; ?>
								</td>
								<td class="text-center">
									<?php if ($row['f_status'] == 1) : ?>
										<span class="badge badge-success">Approved</span>
									<?php else : ?>
										<span class="badge badge-warning">Pending</span>
									<?php endif; ?>
								</td>
								<!-- <td class="text-center"><?php echo $row['date'] ?></td> -->
								<td class="text-center">
									<div class="btn-group">
										<button class="btn btn-sm btn-info view_report" type="button" data-id="<?php echo $row['id'] ?>">
											<i class="fa fa-eye"></i>
										</button>
										<button class="btn btn-sm btn-primary edit_report" type="button" data-id="<?php echo $row['id'] ?>">
											<i class="fa fa-edit"></i>
										</button>
										<button class="btn btn-sm btn-danger delete_report" type="button" data-id="<?php echo $row['id'] ?>">
											<i class="fa fa-trash"></i>
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

		let minDate, maxDate;

		// Create date inputs
		minDate = new DateTime('#min', {
			format: 'MMMM Do YYYY'
		});
		maxDate = new DateTime('#max', {
			format: 'MMMM Do YYYY'
		});

		// Filter by date
		$('#min, #max').on('change', function() {
			minDate = $('#min').val();
			maxDate = $('#max').val();

			table.draw();

			console.log(minDate, maxDate);
		});

		$.fn.dataTable.ext.search.push(
			function(settings, data, dataIndex) {
				// format and trim the date values from data[1]

				const min = moment(minDate, 'YYYY-MM-DD');
				const max = moment(maxDate, 'YYYY-MM-DD');
				const date = moment(data[1], 'MM/DD/YYYY');

				// If the date is between the min and max
				if ((min == '' && max == '') || (min == '' && date <= max) || (min <= date && '' == max) || (min <= date && date <= max)) {
					return true;
				}

				return false;
			}
		);

		$('.new_request').click(function() {
			uni_modal("New Request for Maintenance", "<?= $_SESSION['login_view_folder'] ?>manage_report.php")
		})
		$('.view_report').click(function() {
			uni_modal("Maintenance Report Details", "<?php echo $_SESSION['login_view_folder'] ?>view_report.php?id=" + $(this).attr('data-id'))
		})
		$('.edit_report').click(function() {
			uni_modal("Edit Maintenance Report", "<?php echo $_SESSION['login_view_folder'] ?>manage_report.php?id=" + $(this).attr('data-id'))
		})
		$('.delete_report').click(function() {
			_conf("Are you sure to delete this report?", "delete_report", [$(this).attr('data-id')])
		})
	})

	function delete_report($id) {
		start_load()
		$.ajax({
			url: 'ajax.php?action=delete_report',
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