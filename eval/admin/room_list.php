<?php include'db_connect.php' ?>
<div class="col-lg-12">
	<div class="card card-outline card-primary">
		<div class="card-header">
			<div class="card-tools">
				<a class="btn btn-block btn-sm btn-default btn-flat border-primary new_room" href="index.php?page=new_room"><i class="fa fa-plus"></i> Add New</a>
			</div>
		</div>
		<div class="card-body">
			<table class="table tabe-hover table-bordered" id="list">
				<colgroup>
					<col width="5%">
					<col width="20%">
					<col width="30%">
					<col width="10%">
				</colgroup>
				<thead>
					<tr>
						<th>Room</th>
						<th>Capacity</th>
                        <th style="text-align: center;">Assigned Faculty</th>
                        <th>Status</th>
                        <th style="text-align: center;">Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
					$qry = $conn->query("SELECT * FROM `room_list` order by id asc");
					while($row= $qry->fetch_assoc()):
                        
					?>
					<tr>
						<td><b><?= $row['room'] ?></b></td>
						<td><b><?= $row['capacity'] ?></b></td>
						<td style="text-align: center;">
							<b>
								<?php 
								$chk = $conn->query("SELECT * FROM faculty_room_list where room_id = {$row['id']} ");
								if($chk->num_rows > 0){
									$fac = $chk->fetch_array();
									$fac = $conn->query("SELECT * FROM faculty_list where id = {$fac['faculty_id']} ")->fetch_array();
									echo ucwords($fac['firstname'].' '.$fac['lastname']);?>
										<div class="d-flex justify-content-center">
											<button class="btn btn-sm btn-flat btn-link assign_faculty" type="button" data-id="<?= $row['id'] ?>">Re-assign</button>
										</div>
									<?php
								}else{
									if ($row['status'] == 1) { ?>
										<div class="d-flex justify-content-center">
											<button class="btn btn-sm btn-flat btn-primary assign_faculty" type="button" data-id="<?= $row['id'] ?>">Assign</button>
										</div>
									<?php } else { ?>
										<div class="d-flex justify-content-center">
											<button class="btn btn-sm btn-flat btn-secondary" type="button" data-id="<?= $row['id'] ?>" disabled>Assign</button>
										</div>
									<?php }
								} ?>
							</b>
						</td>
						<td>
							<b>
								<?php if($row['status'] == 1): ?>
									<span class="badge badge-success">Active</span>
								<?php else: ?>
									<span class="badge badge-danger">Inactive</span>
								<?php endif; ?>
							</b>
						</td>
						<td class="text-center">
		                    <div class="btn-group" >
								
		                        <a href="javascript:void(0)" data-id="<?= $row['id'] ?>" class="btn btn-primary btn-flat manage_room">
		                          <i class="fas fa-edit"></i>
		                        </a>
		                        <button type="button"  class="btn btn-danger btn-flat delete_room" data-id="<?= $row['id'] ?>">
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
	$(document).ready(function(){
		$('#list').dataTable()
		// $('.new_room').click(function(){
		// 	uni_modal("New room","<?= $_SESSION['login_view_folder'] ?>manage_room.php")
		// })
		$('.assign_faculty').click(function(){
			window.location.href = "index.php?page=assign_faculty_room&room_id="+$(this).attr('data-id')
		})
		$('.manage_room').click(function(){
			uni_modal("Manage room","<?= $_SESSION['login_view_folder'] ?>manage_room.php?id="+$(this).attr('data-id'))
		})
		$('.delete_room').click(function(){
			_conf("Are you sure to delete this room?","delete_room",[$(this).attr('data-id')])
		})
	    $('#list').dataTable()
	})

	function delete_room($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_room',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully deleted",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	}
</script>