<?php
include '../db_connect.php';
$room_qry = $conn->query("SELECT * FROM room_list where id={$_GET['room_id']}");
?>

<table class="table table-hover">
	<thead>
		<tr>
			<td>Faculty 1</td>
			<td>Faculty 2</td>
		</tr>
	</thead>
	<tbody>
		<?php while ($row = $room_qry->fetch_assoc()): ?>
			<tr>
				<td>
					<?php
					if (isset($row['faculty_id_1'])) {
						$qry1 = $conn->query("SELECT * FROM faculty_list WHERE id = {$row['faculty_id_1']};")->fetch_assoc();
						echo ucwords($qry1['firstname'] . ' ' . $qry1['lastname']);
					} else {
						echo "No faculty assigned";
					}
					?>
				</td>
				<td>
					<?php
					if (isset($row['faculty_id_2'])) {
						$qry2 = $conn->query("SELECT * FROM faculty_list WHERE id = {$row['faculty_id_2']};")->fetch_assoc();
						echo ucwords($qry2['firstname'] . ' ' . $qry2['lastname']);
					} else {
						echo "No faculty assigned";
					}
					?>
				</td>
			</tr>
		<?php endwhile; ?>
	</tbody>
</table>

<div class="modal-footer display p-0 m-0">
	<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
</div>
<style>
	#uni_modal .modal-footer {
		display: none
	}

	#uni_modal .modal-footer.display {
		display: flex
	}
</style>