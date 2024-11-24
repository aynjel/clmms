<?php include 'db_connect.php' ?>

<div class="row">
	<div class="col-lg-12">
		<?php
		$query = "SELECT * from tb_data order by date desc";
		$result = mysqli_query($conn, $query);
		?>
		<div class="card card-outline card-primary">
			<div class="card-header">
				<h3 class="card-title text-capitalize font-weight-bold">
					<i class="fa fa-list"></i> Request List (<?= mysqli_num_rows($result) ?>)
				</h3>
				<div class="card-tools">
					<ul class="pagination pagination-sm m-0 float-right">
						<li class="page-item">
							<a class="btn btn-block btn-sm btn-default btn-flat border-primary new_evaluation" href="javascript:void(0)"><i class="fa fa-plus"></i> New Evaluation</a>
						</li>
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
							<th scope="col">Done By</th>
							<th scope="col">Remarks</th>
							<th scope="col">Evaluation Status</th>
							<!-- <th scope="col">Action</th> -->
						</tr>
					</thead>
					<tbody>
						<?php while ($row = mysqli_fetch_array($result)) : ?>
							<tr>
								<!-- <td class="text-center"><?php echo $row['id'] ?></td> -->
								<td><?php echo substr($row['languages'], 0, -1) ?></td>
								<!-- <td><?php echo $row['description'] ?></td> -->
								<td>
									<?php echo date('m/d/Y', strtotime($row['date'])) ?>
								</td>
								<td>
									<?php
									$maintenanceQuery = $conn->query("SELECT * from student_list where id = " . $row['user_id']);
									$maintenance = $maintenanceQuery->fetch_assoc();
									echo $maintenance['firstname'] . ' ' . $maintenance['lastname'];
									?>
								</td>
								<td>
									<?php
									if ($row['status'] == 1) {
										echo "<span class='badge badge-success'>Accomplished</span>";
									} else {
										echo "<span class='badge badge-info'>Under Process</span>";
									}
									?>
								</td>
								<td>
									<?php
									if ($row['f_status'] == 1) {
										echo "<span class='badge badge-success'>Approved</span>";
									} else {
										echo "<span class='badge badge-warning'>Pending</span>";
									}
									?>
								</td>
								<!-- <td class="text-center">
									<div class="btn-group">
										<button class="btn btn-sm btn-info view_report_details" type="button" data-id="<?php echo $row['id'] ?>">
											<i class="fa fa-eye"></i>
										</button>
										<a href="javascript:void(0)" data-id="<?= $row['id'] ?>" class="btn btn-primary btn-flat manage_report">
											<i class="fas fa-edit"></i>
										</a>
										<button type="button" class="btn btn-danger btn-flat delete_report" data-id="<?= $row['id'] ?>">
											<i class="fas fa-trash"></i>
										</button>
									</div>
								</td> -->
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
	});
	// $(document).ready(function() {
	// 	const table = $('.report_list').DataTable({
	// 		pageLength: 5,
	// 		dom: 'Bfrtip',
	// 		buttons: [
	// 			'excel', 'pdf', {
	// 				extend: 'print',
	// 				text: 'Print',
	// 				autoPrint: true,
	// 				title: '',
	// 				messageTop: '<header style="display: flex; justify-content: space-between; align-items: center;"><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/9a/CTU_new_logo.png/1200px-CTU_new_logo.png" alt="CTU Logo" style="width: 100px; height: 100px;" /><p style="text-align: center;"> Republic of the Philippines <br> CEBU TECHNOLOGICAL UNIVERSITY <br> TUBURAN CAMPUS <br> Brgy. 8 Poblacion, Tuburan, Cebu <br> Tel. No. (032) 463-9350 </p><img src="https://upload.wikimedia.org/wikipedia/en/thumb/4/49/Seal_of_ASEAN.svg/1200px-Seal_of_ASEAN.svg.png" alt="ASEAN Logo" style="width: 100px; height: 100px;" />',
	// 				messageBottom: 'This document is generated by the system and does not require signature.',
	// 				customize: function(win) {
	// 					$(win.document.body)
	// 						.css('font-size', '10pt')
	// 						.prepend(
	// 							'<img src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/9a/CTU_new_logo.png/1200px-CTU_new_logo.png" style="position:absolute; top:0; left:0; opacity:0.1;" />'
	// 						);

	// 					$(win.document.body).find('table')
	// 						.addClass('compact')
	// 						.css('font-size', 'inherit');
	// 				}
	// 			}
	// 		]
	// 	})
	// });

	$('.view_report_details').click(function() {
		uni_modal("Maintenance Report Details", "<?php echo $_SESSION['login_view_folder'] ?>view_report_details.php?id=" + $(this).attr('data-id'))
	})
	$('.new_evaluation').click(function() {
		uni_modal("New Evaluation", "<?= $_SESSION['login_view_folder'] ?>manage_evaluation.php", "large")
	})
	$('.new_request').click(function() {
		uni_modal("New Request for Maintenance", "<?= $_SESSION['login_view_folder'] ?>manage_request.php")
	})
	$('.manage_report').click(function() {
		uni_modal("Manage Report", "<?= $_SESSION['login_view_folder'] ?>manage_request.php?id=" + $(this).attr('data-id'))
	})
	$('.delete_report').click(function() {
		_conf("Are you sure to delete this report?", "delete_report", [$(this).attr('data-id')])
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