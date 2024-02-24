<?php
require '../db_connect.php';
if (isset($_GET['id'])) {
  $qry = $conn->query("SELECT * from tb_data where id = " . $_GET['id']);
  foreach ($qry->fetch_array() as $k => $val) {
    $$k = $val;
  }
}
?>
<div class="row">
  <div class="col-md-12">
    <p><b>Section:</b> <span class="text-muted"><?php echo $languages ?></span></p>
    <p><b>Description:</b> <span class="text-muted"><?php echo $description ?></span></p>
    <p><b>Action Taken:</b> <span class="text-muted"><?php echo date('F j, Y, g:i a', strtotime($date)) ?></span></p>
    <p><b>Done By:</b> <span class="text-muted">
        <?php
        $maintenanceQuery = $conn->query("SELECT * from student_list where id = " . $user_id);
        $maintenance = $maintenanceQuery->fetch_assoc();
        echo $maintenance['firstname'] . ' ' . $maintenance['lastname'];
        ?>
      </span></p>
    <p><b>Remarks:</b> <span class="text-muted">
        <?php
        if ($status == 1) {
          echo "<span class='badge badge-success'>Accomplished</span>";
        } else {
          echo "<span class='badge badge-info'>Under Process</span>";
        }
        ?>
      </span></p>
    <p><b>Status:</b> <span class="text-muted">
        <?php
        if ($f_status == 1) {
          echo "<span class='badge badge-success'>Approved</span>";
        } else {
          echo "<span class='badge badge-warning'>Pending</span>";
        }
        ?>
      </span></p>
  </div>
</div>