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
$astat = array("Not Yet Started", "On-going", "Closed");
?>

<div class="col-12">
  <div class="card">
    <div class="card-body">
      Welcome <?php echo $_SESSION['login_name'] ?>!
      <br>
      <div class="row">
        <div class="col-md-4">
          <div class="small-box bg-light shadow-sm border">
            <div class="inner">
              <h3><?php echo $conn->query("SELECT * FROM tb_data WHERE faculty_id = $_SESSION[login_id]")->num_rows; ?></h3>

              <p>Total Report</p>
            </div>
            <div class="icon">
              <i class="fa ion-ios-people-outline"></i>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="small-box bg-light shadow-sm border">
            <div class="inner">
              <h3><?php echo $conn->query("SELECT * FROM equipment_list")->num_rows; ?></h3>

              <p>Total Equipment</p>
            </div>
            <div class="icon">
              <i class="fa fa-laptop"></i>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="small-box bg-light shadow-sm border">
            <div class="inner">
              <h3><?php echo $conn->query("SELECT * FROM tbl_evaluation WHERE faculty_id = $_SESSION[login_id]")->num_rows; ?></h3>

              <p>Total Evaluate</p>
            </div>
            <div class="icon">
              <i class="fa fa-poll"></i>
            </div>
          </div>
        </div>
      </div>


    </div>

  </div>