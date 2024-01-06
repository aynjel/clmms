<?php include'db_connect.php' ?>
<div class="col-lg-12">
	<div class="card card-outline card-primary">
		<div class="card-header">
			<div class="card-tools">
				<a class="btn btn-block btn-sm btn-default btn-flat border-primary new_room" href="javascript:void(0)"><i class="fa fa-plus"></i> Add New</a>
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
						<th class="text-center">#</th>
						<th>Room</th>
						<th>Assign Faculty in Charge</th>
                        <th>Action</th>
						
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
					$qry = $conn->query("SELECT `id`, `room`, `assign` FROM `room_list` WHERE id");
					while($row= $qry->fetch_assoc()):
                        
					?>
					<tr>
						<th class="text-center"><?php echo $i++ ?></th>
						<td><b><?php echo $row['room'] ?></b></td>
						<td><b><?php echo $row['assign'] ?></b></td>
						<td class="text-center">
		                    <div class="btn-group" >
								
		                        <a href="javascript:void(0)" data-id="<?php echo $row['id'] ?>" class="btn btn-primary btn-flat manage_room">
		                          <i class="fas fa-edit"></i>
		                        </a>
		                        <button type="button"  class="btn btn-danger btn-flat delete_room" data-id="<?php echo $row['id'] ?>">
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
		$('.new_room').click(function(){
			uni_modal("New room","<?php echo $_SESSION['login_view_folder'] ?>manage_room.php")
		})
		$('.manage_room').click(function(){
			uni_modal("Manage room","<?php echo $_SESSION['login_view_folder'] ?>manage_room.php?id="+$(this).attr('data-id'))
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