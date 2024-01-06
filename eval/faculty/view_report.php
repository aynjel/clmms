<?php

require_once('db_connect.php');
$query = "select * from tb_data ";
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
      <th scope="col">Time/Date</th>
      <th scope="col">Action</th>
    </tr>
    <tr>
    <?php
    
      while($row = mysqli_fetch_assoc($result))
      {
    ?>
     <td><?php echo $row['id']; ?></td>
     <td><?php echo $row['languages']; ?></td>
     <td><?php echo $row['description']; ?></td>
     <td><?php echo $row['date']; ?></td>
    </tr>
    <?php
      }



    ?>
  </thead>
  
</table>
</body>
</html>