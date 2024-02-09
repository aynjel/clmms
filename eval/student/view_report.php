<?php
require '../db_connect.php';
if (isset($_GET['id'])) {
  $qry = $conn->query("SELECT * from tb_data where id = " . $_GET['id']);
  foreach ($qry->fetch_array() as $k => $val) {
    $$k = $val;
  }
}
?>
<div class="container-fluid">
  <div class="row">
    <div class="col-lg-12">
      <div class="card card-outline card-primary">
        <div class="card-header">
          <h3 class="card-title text-capitalize font-weight-bold">
            Maintenance Report Details
          </h3>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              <p><b>Section:</b> <span class="text-muted"><?php echo $languages ?></span></p>
              <p><b>Description:</b> <span class="text-muted"><?php echo $description ?></span></p>
              <p><b>Date/Time:</b> <span class="text-muted"><?php echo date('F j, Y, g:i a', strtotime($date)) ?></span></p>
              <p><b>Status:</b> <span class="text-muted">
                  <?php
                  if ($status == 1) {
                    echo "<span class='badge badge-success'>Done Evaluate</span>";
                  } else {
                    echo "<span class='badge badge-warning'>Pending</span>";
                  }
                  ?>
                </span></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>