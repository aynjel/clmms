<?php
?>
<div class="col-lg-12">
	<div class="card">
		<div class="card-body">
			<form action="" id="manage_evaluation">
				<input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label for="equipment" class="control-label">Equipment</label>
							<select name="equipment" id="equipment" class="form-control form-control-sm select2">
								<option value=""></option>
								<?php 
								$eq = $conn->query("SELECT * FROM equipment_list order by name asc");
								while($row=$eq->fetch_assoc()):
								?>
								<option value="<?php echo $row['id'] ?>" <?php echo isset($equipment) && $equipment == $row['id'] ? 'selected' : '' ?>><?php echo $row['name'] ?></option>
								<?php endwhile; ?>
							</select>
						</div>
					</div>
				</div>
				<div class="col-lg-12 text-right justify-content-center d-flex">
					<button class="btn btn-primary mr-2">Save</button>
					<button class="btn btn-secondary" type="button" onclick="location.href = 'index.php?page=evaluation_report_list'">Cancel</button>
				</div>
			</form>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		
	})
	
</script>