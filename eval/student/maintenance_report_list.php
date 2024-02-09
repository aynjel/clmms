<?php include 'db_connect.php' ?>
<?php
$query = "SELECT * from tb_data ORDER BY id DESC";
$result = mysqli_query($conn, $query);
?>
<div class="row">
	<div class="col-lg-12">
		<div class="card card-outline card-primary">
			<div class="card-header">
				<h3 class="card-title text-capitalize font-weight-bold">
					Maintenance Report List (<?= mysqli_num_rows($result) ?>)
				</h3>
			</div>
			<div class="card-body">
				<table class="table tabe-hover table-bordered report_list">
					<thead>
						<tr>
							<th scope="col">#</th>
							<th scope="col">Section</th>
							<th scope="col">Description</th>
							<th scope="col">Date/Time</th>
							<th scope="col">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php while ($row = mysqli_fetch_array($result)) : ?>
							<tr>
								<td class="text-center"><?php echo $row['id'] ?></td>
								<td class="text-center"><?php echo $row['languages'] ?></td>
								<td class="text-center"><?php echo $row['description'] ?></td>
								<td class="text-center"><?php echo date('F j, Y, g:i a', strtotime($row['date'])); ?></td>
								<td class="text-center">
									<button class="btn btn-sm btn-primary view_report" type="button" data-id="<?php echo $row['id'] ?>">View</button>
									<button class="btn btn-sm btn-danger delete_report" type="button" data-id="<?php echo $row['id'] ?>">Delete</button>
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
		$('.report_list').dataTable()
		$('.view_report').click(function() {
			uni_modal("Maintenance Report Details", "<?php echo $_SESSION['login_view_folder'] ?>view_report.php?id=" + $(this).attr('data-id'))
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