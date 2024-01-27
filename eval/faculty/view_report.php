<?php

require_once('db_connect.php');
$query = "SELECT * from tb_data ORDER BY id DESC";
$result = mysqli_query($conn,$query);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    
</head>
<body>
    <h1 align="center" style="color:red;">Report List</h1>
    <br>
    <div class="card-body">
        <div class="table-responsive">
        <table class="table table-bordered">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Section</th>
      <th scope="col">Description</th>
      <th scope="col">Date/Time</th>
      <!-- <th scope="col">Action</th> -->
    </tr>
    <tr>
    <?php
    
      while($row = mysqli_fetch_assoc($result))
      {
    ?>
     <td><?= $row['id']; ?></td>
     <td><?= $row['languages']; ?></td>
     <td><?= $row['description']; ?></td>
     <td><?= date('F j, Y, g:i a',strtotime($row['date'])); ?></td>
    </tr>
    <?php
      }



    ?>
  </thead>
  
</table>
</body>
</html>