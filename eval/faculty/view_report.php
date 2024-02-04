<?php include 'db_connect.php' ?>
<?php
$query = "SELECT * from tb_data where user_id = '".$_SESSION['login_id']."' order by date desc";
$result = mysqli_query($conn,$query);
?>
<div class="row">
  <div class="col-lg-12">
		<div class="card card-outline card-primary">
			<div class="card-header">
				<h3 class="card-title text-capitalize font-weight-bold">
          Reports (<?= mysqli_num_rows($result) ?>)
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
				<table class="table tabe-hover table-bordered report_list">
					<thead>
						<tr>
              <!-- <th scope="col">#</th> -->
              <th scope="col">Section</th>
              <th scope="col">Description</th>
              <th scope="col">Date/Time</th>
              <th scope="col">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php while($row = mysqli_fetch_array($result)): ?>
							<tr>
                <!-- <td class="text-center"><?php echo $row['id'] ?></td> -->
                <td><?php echo $row['languages'] ?></td>
                <td><?php echo $row['description'] ?></td>
                <td><?php echo date('F j, Y, g:i a',strtotime($row['date'])); ?></td>
                <td class="text-center">
                  <div class="btn-group" >
                    <a href="javascript:void(0)" data-id="<?= $row['id'] ?>" class="btn btn-primary btn-flat manage_report">
                      <i class="fas fa-edit"></i>
                    </a>
                    <button type="button"  class="btn btn-danger btn-flat delete_report" data-id="<?= $row['id'] ?>">
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
</div>

<script>
  $(document).ready(function(){
    $('.report_list').dataTable()
    $('.new_evaluation').click(function(){
      uni_modal("New Evaluation","<?= $_SESSION['login_view_folder'] ?>manage_evaluation.php")
    })
    $('.new_request').click(function(){
      uni_modal("New Request","<?= $_SESSION['login_view_folder'] ?>manage_report.php")
    })
    $('.manage_report').click(function(){
      uni_modal("Manage Report","<?= $_SESSION['login_view_folder'] ?>manage_report.php?id="+$(this).attr('data-id'))
    })
    $('.delete_report').click(function(){
      _conf("Are you sure to delete this report?","delete_report",[$(this).attr('data-id')])
    })
  })
  function delete_report($id){
    start_load()
    $.ajax({
      url:'ajax.php?action=delete_report',
      method:'POST',
      data:{id:$id},
      success:function(resp){
        if(resp == 1){
          alert_toast("Data successfully deleted",'success')
          setTimeout(function(){
            location.reload()
          },1500)
        }
      }
    })
  }
</script>