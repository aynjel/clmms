<?php include'db_connect.php' ?>
<div class="col-lg-12">
	<div class="card card-outline card-primary">
		<!-- <div class="card-header">
			<div class="card-tools">
				<a class="btn btn-block btn-sm btn-default btn-flat border-primary new_room" href="index.php?page=new_room"><i class="fa fa-plus"></i> Add New</a>
			</div>
		</div> -->
		<div class="card-body">
			<table class="table tabe-hover table-bordered" id="evaluation_list">
				<colgroup>
					<col width="5%">
					<col width="20%">
					<col width="30%">
					<col width="10%">
				</colgroup>
				<thead>
					<tr>
						<th>ID</th>
						<th>Faculty</th>
                        <th>Status</th>
                        <th style="text-align: center;">Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
					$qry = $conn->query("SELECT * FROM `tbl_evaluation` order by id asc");
					while($row= $qry->fetch_assoc()):
                        
					?>
					<tr>
						<td><b><?= $row['id'] ?></b></td>
						<td><b><?php
						$fac = $conn->query("SELECT * FROM faculty_list where id = ".$row['user_id'])->fetch_array();
						echo ucwords($fac['firstname'].' '.$fac['lastname']);
						?></b></td>
						<td>
							<b>
								<?php if($row['status'] == 1): ?>
									<span class="badge badge-success">ACCEPTED</span>
								<?php elseif($row['status'] == 2): ?>
									<span class="badge badge-danger">REJECTED</span>
								<?php else: ?>
									<span class="badge badge-warning">PENDING</span>
								<?php endif; ?>
							</b>
						</td>
						<td class="text-center">
		                    <div class="btn-group">
								<a href="javascript:void(0)" data-id="<?= $row['id'] ?>" class="btn btn-info btn-flat view_evaluation">
		                          <i class="fas fa-eye"></i>
								</a>
		                        <a href="javascript:void(0)" data-id="<?= $row['id'] ?>" class="btn btn-primary btn-flat manage_evaluation">
		                          <i class="fas fa-edit"></i>
		                        </a>
		                        <button type="button"  class="btn btn-danger btn-flat delete_evaluation" data-id="<?= $row['id'] ?>">
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
		$('#evaluation_list').dataTable()
		$('.view_evaluation').click(function(){
			uni_modal("Evaluation Details","<?= $_SESSION['login_view_folder'] ?>view_evaluation.php?id="+$(this).attr('data-id'))
		})
		$('.manage_evaluation').click(function(){
			uni_modal("Manage Evaluation","<?= $_SESSION['login_view_folder'] ?>manage_evaluation.php?id="+$(this).attr('data-id'))
		})
		$('.delete_evaluation').click(function(){
			_conf("Are you sure to delete this Evaluation?","delete_evaluation",[$(this).attr('data-id')])
		})
	})
	function delete_evaluation($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_evaluation_01',
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