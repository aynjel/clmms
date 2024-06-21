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
    <b>
      Register New Maintenance Staff
    </b>
  </h2>
  <div class="login-box">
    <div class="card">
      <div class="card-body login-card-body">
        <form action="" id="register-form">
          <div class="row">
            <div class="col-md-6 border-right">
              <div class="form-group">
                <label for="" class="control-label">Employee ID</label>
                <input type="number" name="school_id" class="form-control form-control-sm" required value="<?php echo isset($school_id) ? $school_id : '' ?>">
              </div>
              <div class="form-group">
                <label for="" class="control-label">First Name</label>
                <input type="text" name="firstname" class="form-control form-control-sm" required value="<?php echo isset($firstname) ? $firstname : '' ?>">
              </div>
              <div class="form-group">
                <label for="" class="control-label">Last Name</label>
                <input type="text" name="lastname" class="form-control form-control-sm" required value="<?php echo isset($lastname) ? $lastname : '' ?>">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">Email</label>
                <input type="email" class="form-control form-control-sm" name="email" required value="<?php echo isset($email) ? $email : '' ?>">
                <small id="#msg"></small>
              </div>
              <div class="form-group">
                <label class="control-label">Password</label>
                <input type="password" class="form-control form-control-sm" name="password" <?php echo !isset($id) ? "required" : '' ?>>
                <small><i><?php echo isset($id) ? "Leave this blank if you dont want to change you password" : '' ?></i></small>
              </div>
              <div class="form-group">
                <label class="label control-label">Confirm Password</label>
                <input type="password" class="form-control form-control-sm" name="cpass" <?php echo !isset($id) ? 'required' : '' ?>>
                <small id="pass_match" data-status=''></small>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label class="label control-label">Section</label>
                <!-- Electrician, Plumber, Carpenter, Mason, Painter, Welder, Mechanic, Gardener, Driver, Security Guard -->
                <select name="section" id="" class="custom-select custom-select-sm">
                  <option value="" <?php echo !isset($section) ? 'selected' : '' ?>>Select Section</option>
                  <option value="Civil and Sanitary" <?php echo isset($section) && $section == 'Civil and Sanitary' ? 'selected' : '' ?>>Civil and Sanitary</option>
                  <option value="Electrical" <?php echo isset($section) && $section == 'Electrical' ? 'selected' : '' ?>>Electrical</option>
                  <option value="Mechanical" <?php echo isset($section) && $section == 'Mechanical' ? 'selected' : '' ?>>Mechanical</option>
                  <option value="Electronic and Communication" <?php echo isset($section) && $section == 'Electronic and Communication' ? 'selected' : '' ?>>Electronic and Communication</option>
                  <option value="ICT" <?php echo isset($section) && $section == 'ICT' ? 'selected' : '' ?>>ICT</option>
                  <option value="Others" <?php echo isset($section) && $section == 'Others' ? 'selected' : '' ?>>Others</option>
                </select>
              </div>
            </div>
          </div>
          <div class="col-lg-12 text-right justify-content-center d-flex">
            <button class="btn btn-primary mr-2" type="submit">
              Sign Up
            </button>
            <button class="btn" type="button" onclick="location.href = 'index.php'">
              Sign In
            </button>
          </div>
        </form>
      </div>

      <!-- /.login-card-body -->
    </div>

  </div>
  <!-- /.login-box -->
  <script>
    $(document).ready(function() {
      $('[name="password"],[name="cpass"]').keyup(function() {
        var pass = $('[name="password"]').val()
        var cpass = $('[name="cpass"]').val()
        if (cpass == '' || pass == '') {
          $('#pass_match').attr('data-status', '')
        } else {
          if (cpass == pass) {
            $('#pass_match').attr('data-status', '1').html('<i class="text-success">Password Matched.</i>')
          } else {
            $('#pass_match').attr('data-status', '2').html('<i class="text-danger">Password does not match.</i>')
          }
        }
      })

      $('#register-form').submit(function(e) {
        e.preventDefault()
        start_load()
        $('#msg').html('')
        if ($('[name="password"]').val() != '' && $('[name="cpass"]').val() != '') {
          if ($('#pass_match').attr('data-status') != 1) {
            if ($("[name='password']").val() != '') {
              $('[name="password"],[name="cpass"]').addClass("border-danger")
              end_load()
              return false;
            }
          }
        }
        $.ajax({
          url: 'ajax.php?action=save_student',
          data: new FormData($(this)[0]),
          cache: false,
          contentType: false,
          processData: false,
          method: 'POST',
          type: 'POST',
          success: function(resp) {
            if (resp == 1) {
              alert_toast('Registration successfully.', 'success')
              setTimeout(function() {
                location.replace('index.php')
              }, 750)
            } else if (resp == 2) {
              $('#msg').html("<div class='alert alert-danger'>Email already exist.</div>");
              $('[name="email"]').addClass("border-danger")
              end_load()
            }
          }
        })
      })
    })
  </script>
  <?php include 'footer.php' ?>

</body>

</html>