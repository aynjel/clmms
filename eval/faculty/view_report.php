<?php include 'db_connect.php' ?>
<?php
$query = "SELECT * from tb_data where user_id = '" . $_SESSION['login_id'] . "' order by date desc";
$result = mysqli_query($conn, $query);
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
              <!-- <th scope="col">Description</th> -->
              <th scope="col">Action Taken</th>
              <th scope="col">Done By</th>
              <th scope="col">Remarks</th>
              <th scope="col">Evaluation Status</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($row = mysqli_fetch_array($result)) : ?>
              <tr>
                <!-- <td class="text-center"><?php echo $row['id'] ?></td> -->
                <td><?php echo $row['languages'] ?></td>
                <!-- <td><?php echo $row['description'] ?></td> -->
                <td><?php echo date('M d, Y h:i A', strtotime($row['date'])) ?></td>
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
                <td class="text-center">
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
    $('.view_report_details').click(function() {
      uni_modal("Maintenance Report Details", "<?php echo $_SESSION['login_view_folder'] ?>view_report_details.php?id=" + $(this).attr('data-id'))
    })
    $('.new_evaluation').click(function() {
      uni_modal("New Evaluation", "<?= $_SESSION['login_view_folder'] ?>manage_evaluation.php", "large")
    })
    $('.new_request').click(function() {
      uni_modal("New Request for Maintenance", "<?= $_SESSION['login_view_folder'] ?>manage_report.php")
    })
    $('.manage_report').click(function() {
      uni_modal("Manage Report", "<?= $_SESSION['login_view_folder'] ?>manage_report.php?id=" + $(this).attr('data-id'))
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