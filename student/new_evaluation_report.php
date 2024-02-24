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
<div class="col-lg-12">
	<div class="card">
		<div class="card-body">
			<form class="container" action="" method="post" autocomplete="off">
				<div class="form-group">
					<label for="section">Section</label>
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="languages[]" value="Civil and Sanitary" id="civil_and_sanitary">
						<label class="form-check-label" for="civil_and_sanitary">
							Civil and Sanitary
						</label>
					</div>
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="languages[]" value="Electrical" id="electrical">
						<label class="form-check-label" for="electrical">
							Electrical
						</label>
					</div>
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="languages[]" value="Mechanical" id="mechanical">
						<label class="form-check-label" for="mechanical">
							Mechanical
						</label>
					</div>
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="languages[]" value="Electronic and Communication" id="electronic_and_communication">
						<label class="form-check-label" for="electronic_and_communication">
							Electronic and Communication
						</label>
					</div>
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="languages[]" value="ICT" id="ict">
						<label class="form-check-label" for="ict">
							ICT
						</label>
					</div>
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="languages[]" value="Others" id="others" checked>
						<label class="form-check-label" for="others">
							Others
						</label>
					</div>
				</div>
				<div class="form-group">
					<label for="description">Description</label>
					<input class="form-control" id="description" name="description" required placeholder="Description" type="text" value="">
				</div>
				
				<div class="form-group">
					<button class="btn btn-primary" type="submit" name="submit">Submit</button>
				</div>
			</form>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		
	})
	
</script>