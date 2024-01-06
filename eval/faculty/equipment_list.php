<?php include'db_connect.php' ?>
<div class="col-lg-12">
	<div class="card card-outline card-primary">
		<div class="card-header">
			<div class="card-tools">
				<a class="btn btn-block btn-sm btn-default btn-flat border-primary new_equipment" href="javascript:void(0)"><i class="fa fa-plus"></i> Add New</a>
			</div>
		</div>
		<div class="card-body">
			<table class="table tabe-hover table-bordered" id="list">
				<colgroup>
					<col width="5%">
					<col width="15%">
					<col width="30%">
					<col width="40%">
					<col width="15%">
				</colgroup>
				<thead>
					<tr>
						<th class="text-center">#</th>
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
					$i = 1;
					$qry = $conn->query("SELECT `id`, `quantity`, `description`, `manufacturer`, `serial`, `condition` FROM `equipment_list` WHERE id");
					while($row= $qry->fetch_assoc()):
					?>
					<tr>
						<th class="text-center"><?php echo $i++ ?></th>
						<td><b><?php echo $row['quantity'] ?></b></td>
						<td><b><?php echo $row['description'] ?></b></td>
						<td><b><?php echo $row['manufacturer'] ?></b></td>
                        <td><b><?php echo $row['serial'] ?></b></td>
                        <td><b><?php echo $row['condition'] ?></b></td>
						<td class="text-center">
		                    <div class="btn-group">
		                        <a href="javascript:void(0)" data-id='<?php echo $row['id'] ?>' class="btn btn-primary btn-flat manage_equipment">
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
		$('#list').dataTable()
		$('.new_equipment').click(function(){
			uni_modal("New equipment","<?php echo $_SESSION['login_view_folder'] ?>manage_equipment.php")
		})
		$('.manage_equipment').click(function(){
			uni_modal("Manage equipment","<?php echo $_SESSION['login_view_folder'] ?>manage_equipment.php?id="+$(this).attr('data-id'))
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