<?php include 'db_connect.php' ?>
<?php
$query = "SELECT * from tb_data ORDER BY id DESC";
$result = mysqli_query($conn,$query);
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
              <!-- <th scope="col">Action</th> -->
						</tr>
					</thead>
					<tbody>
						<?php while($row = mysqli_fetch_array($result)): ?>
							<tr>
                <td class="text-center"><?php echo $row['id'] ?></td>
                <td class="text-center"><?php echo $row['languages'] ?></td>
                <td class="text-center"><?php echo $row['description'] ?></td>
                <td class="text-center"><?php echo date('F j, Y, g:i a',strtotime($row['date'])); ?></td>
                <!-- <td class="text-center">
                  <button class="btn btn-sm btn-primary edit_equipment" type="button" data-id="<?php echo $row['id'] ?>" data-room_id="<?php echo $row['room_id'] ?>" data-section="<?php echo $row['section'] ?>" data-description="<?php echo $row['description'] ?>" data-date_time="<?php echo $row['date_time'] ?>">Edit</button>
                  <button class="btn btn-sm btn-danger delete_equipment" type="button" data-id="<?php echo $row['id'] ?>">Delete</button>
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
  $(document).ready(function(){
    $('.report_list').dataTable()
  })
</script>