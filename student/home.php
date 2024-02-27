<?php include('db_connect.php');
function ordinal_suffix1($num)
{
  $num = $num % 100; // protect against large numbers
  if ($num < 11 || $num > 13) {
    switch ($num % 10) {
      case 1:
        return $num . 'st';
      case 2:
        return $num . 'nd';
      case 3:
        return $num . 'rd';
    }
  }
  return $num . 'th';
}
$astat = array("Not Yet Started", "Started", "Closed");
?>

<div class="col-12">
  <div class="card">
    <div class="card-body">
      Welcome <?php echo $_SESSION['login_name'] ?>!
      <br>
      <div class="row">
        <div class="col-md-3 col-lg-4">
          <div class="small-box bg-light shadow-sm border">
            <div class="inner">
              <h3><?php echo $conn->query("SELECT * FROM tb_data WHERE user_id = $_SESSION[login_id]")->num_rows; ?></h3>

              <p>Total Report</p>
            </div>
            <div class="icon">
              <i class="fas fa-list"></i>
            </div>
          </div>
        </div>

        <div class="col-md-3 col-lg-4">
          <div class="small-box bg-light shadow-sm border">
            <div class="inner">
              <h3><?php echo $conn->query("SELECT * FROM tb_data where user_id = $_SESSION[login_id] AND status = 0")->num_rows; ?></h3>

              <p>Pending Evaluation</p>
            </div>
            <div class="icon">
              <i class="fas fa-clock"></i>
            </div>
          </div>
        </div>

        <div class="col-md-3 col-lg-4">
          <div class="small-box bg-light shadow-sm border">
            <div class="inner">
              <h3><?php echo $conn->query("SELECT * FROM tb_data where user_id = $_SESSION[login_id] AND status = 1")->num_rows; ?></h3>

              <p>Accomplished</p>
            </div>
            <div class="icon">
              <i class="fas fa-check"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>