<?php
require '../db_connect.php';
if (isset($_GET['id'])) {
  foreach ($conn->query("SELECT * from tb_report where id = " . $_GET['id'])->fetch_array() as $k => $val) {
    $$k = $val;
  }

  $person_details = $conn->query("SELECT * from faculty_list where id = " . $user_id)->fetch_array();
}

?>
<div id="data-print">
  <header style="display: flex; justify-content: space-between; align-items: center;"><img src="https://raw.githubusercontent.com/aynjel/clmms/main/assets/print-logo-1.png" alt="CTU Logo" style="" />
    <p style="text-align: center;font-size: 20px;"> Republic of the Philippines <br> <b> CEBU TECHNOLOGICAL UNIVERSITY <br> TUBURAN CAMPUS </b> <br> <small> Poblacion 8, Tuburan, Cebu, Philippines <br> Website: http://www.ctu.edu.ph E-mail: tuburan.campus@ctu.edu.ph <br> Tel. No. (032) 463-9350 </small> </p><img src="https://raw.githubusercontent.com/aynjel/clmms/main/assets/print-logo-2.png" alt="ASEAN Logo" style="" />
  </header>

  <hr>

  <h3 style="text-align: center; font-size: 20px;">
    <b>PRE-INSPECTION REPORT FOR MECHANICAL</b>
  </h3>

  <div style="margin-top: 10px;">
    <b>Office / Area:</b> <?php echo $area ?>
    <br>
    <b>Machine / Equipment / Facility:</b> <?php echo $equipment ?>
    <br>
    <b>Status / Condition / Problem:</b> <?php echo $status ?>
    <br>
    <b>Date of Inspection:</b> <?php echo date('F d, Y', strtotime($date)) ?>
    <!-- <br> -->
    <!-- <b>Person Responsible:</b> <?php echo $person_details['firstname'] . ' ' . $person_details['lastname'] ?> -->
  </div>

  <footer style="text-align: center; position: fixed; bottom: 0; width: 100%;"><img src="https://raw.githubusercontent.com/aynjel/clmms/main/assets/print-logo-3.png" alt="Footer Logo" /></footer>
</div>

<script>
  window.onload = function() {
    window.print();
  }
</script>