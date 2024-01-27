<?php
require 'db_connect.php';

if(isset($_POST["submit"])){
  $description = $_POST["description"];

  $languages = $_POST["languages"];
  $language = "";
  foreach($languages as $row){
    $language .= $row . ",";
  }

  $query = "INSERT INTO tb_data VALUES('id', '$description', '$language', NOW())";
  mysqli_query($conn,$query);
  echo
  "
  <script> alert('Data Inserted Successfully'); </script>
  ";
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
  <style>

.container {
    max-width: 800px;
    margin: 50px auto;
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}
h2{
    text-align: center;
}

form {
  text-align: center;
    flex-direction: column;
}

label {
  font-size: xx-large;
  font-style: verdana;
  color: green;
    margin-bottom: 8px;
}
textarea,
input {
    margin-bottom: 16px;
    padding: 8px;
    margin: 15px;
}

button {
    background-color: #4caf50;
    color: #fff;
    padding: 10px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

button:hover {
    background-color: #45a049;
}
    </style>
    <meta charset="utf-8">
    <title>Insert Data</title>
  </head>
  <style media="screen">
    label{
      display: block;
    }
  </style>
  <body>
    <form class="container" action="" method="post" autocomplete="off">
    
      <label for="languages">Languages</label>
      <input type="checkbox" name="languages[]" value="Civil and Sanitary">Civil and Sanitary
      <input type="checkbox" name="languages[]" value="Electrical">Electrical
      <input type="checkbox" name="languages[]" value="Mechanical">Mechanical
      <input type="checkbox" name="languages[]" value="Electronic and Communication">Electronic and Communication
      <input type="checkbox" name="languages[]" value="ICT">ICT
      <input type="checkbox" name="languages[]" value="Others" checked>Others
      <label for="description">Description</label>
      <input style="width: 95%;" id="description" name="description" required placeholder="Description" type="text" value="">
      
      <button type="submit" name="submit">Send</button>
    </form>
  </body>
</html>
