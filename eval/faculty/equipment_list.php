<?php include'db_connect.php' ?>
<div class="col-lg-12">
	<div class="card card-outline card-success">
		<div class="card-header">
			<div class="card-tools">
				<a class="btn btn-block btn-sm btn-default btn-flat border-primary" href="./index.php?page=new_equipment"><i class="fa fa-plus"></i> Add New Equipment</a>
			</div>
		</div>
		<div class="card-body">
			<table class="table tabe-hover table-bordered" id="list">
				<thead>
					<tr>
						<th class="text-center">Name</th>
						<th>Quantity</th>
						<th>Description</th>
						<th>Manufacturer</th>
						<th>Serial No.</th>
						<th>Condition</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$qry = $conn->query("SELECT * FROM equipment_list order by id asc");
					while($row= $qry->fetch_assoc()):
					?>
					<tr>
						<td class="text-center">
							<?php echo $row['name'] ?>
						</td>
						<td class="">
							<?php echo $row['quantity'] ?>
						</td>
						<td class="">
							<?php echo $row['description'] ?>
						</td>
						<td class="">
							<?php echo $row['manufacturer'] ?>
						</td>
						<td class="">
							<?php echo $row['serial_no'] ?>
						</td>
						<td class="">
							<?php echo $row['condition'] ?>
						</td>
						<td class="text-center">
		                    <div class="btn-group">
		                        <a href="./index.php?page=edit_equipment&id=<?php echo $row['id'] ?>" class="btn btn-primary btn-flat">
		                          <i class="fas fa-edit"></i>
		                        </a>
		                        <button type="button" class="btn btn-danger btn-flat delete_equipment" data-id="<?php echo $row['id'] ?>">
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
	$('.view_equipment').click(function(){
		uni_modal("<i class='fa fa-id-card'></i> equipment Details","<?php echo $_SESSION['login_view_folder'] ?>view_equipment.php?id="+$(this).attr('data-id'))
	})
	$('.delete_equipment').click(function(){
	_conf("Are you sure to delete this equipment?","delete_equipment",[$(this).attr('data-id')])
	})
		$('#list').dataTable()
	})
	function delete_equipment($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_equipment',
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