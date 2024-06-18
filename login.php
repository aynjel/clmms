<!DOCTYPE html>
<html lang="en">
<style>
  .bg-black {
    background-image: url('./assets/login-bg.png');
    background-size: cover;
    background-position: center;
  }

  .login-title {
    background: #000;
    color: #fff;
    padding: 10px;
    text-align: center;
    margin-bottom: 10px;
    box-shadow: 0 0 10px #000;
    background: rgba(0, 0, 0, 0.4);
  }
</style>
<?php
session_start();
include('./db_connect.php');
ob_start();
// if(!isset($_SESSION['system'])){

$system = $conn->query("SELECT * FROM system_settings")->fetch_array();
foreach ($system as $k => $v) {
  $_SESSION['system'][$k] = $v;
}
// }
ob_end_flush();
?>
<?php
if (isset($_SESSION['login_id']))
  header("location:index.php?page=home");

?>
<?php include 'header.php' ?>

<body class="hold-transition login-page bg-black">
  <h2 class="login-title">
    <b><?php echo $_SESSION['system']['name'] ?> </b>
  </h2>
  <div class="login-box">
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body login-card-body">
        <form action="" id="login-form">
          <div class="input-group mb-3">
            <input type="email" class="form-control" name="email" required placeholder="Email">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" name="password" required placeholder="Password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="form-group mb-3">
            <label for="">Login As</label>
            <select name="login" id="" class="custom-select custom-select-sm">
              <option value="1">Chairperson</option>
              <option value="2">Faculty In-charge</option>
              <option value="3">Maintenance Staff</option>
            </select>
          </div>
          <div class="row">
            <div class="col-8">
              <div class="icheck-primary">
                <input type="checkbox" id="remember">
                <label for="remember">
                  Remember Me
                </label>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-4">
              <button type="submit" class="btn btn-primary btn-block">Sign In</button>
            </div>
            <!-- /.col -->
            <div class="col-12">
              <a href="javascript:void(0)" id="new_account" class="text-center">
                Register as Maintenance Staff
              </a>
            </div>
          </div>
        </form>
      </div>

      <!-- /.login-card-body -->
    </div>

  </div>
  <!-- /.login-box -->
  <script>
    $(document).ready(function() {
      $('#new_account').click(function() {
        location.href = 'new_maintenance_staff.php'
      })

      $('#login-form').submit(function(e) {
        e.preventDefault()
        start_load()
        if ($(this).find('.alert-danger').length > 0)
          $(this).find('.alert-danger').remove();
        $.ajax({
          url: 'ajax.php?action=login',
          method: 'POST',
          data: $(this).serialize(),
          error: err => {
            console.log(err)
            end_load();

          },
          success: function(resp) {
            if (resp == 1) {
              location.href = 'index.php?page=home';
            } else {
              $('#login-form').prepend('<div class="alert alert-danger">Username or password is incorrect.</div>')
              end_load();
            }
          }
        })
      })
    })
  </script>
  <?php include 'footer.php' ?>

</body>

</html>