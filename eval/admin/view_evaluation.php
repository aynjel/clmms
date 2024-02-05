<?php 
include '../db_connect.php';
if(isset($_GET['id'])){
	$qry = $conn->query("SELECT * FROM tbl_evaluation WHERE id = {$_GET['id']}")->fetch_array();
	foreach($qry as $k => $v){
		$$k = $v;
	}
}
function displayText($idStatus){
	if($idStatus == 1){
		return "Very Dissatisfied";
	}elseif($idStatus == 2){
		return "Disatisfied";
	}elseif($idStatus == 3){
		return "Neutral";
	}elseif($idStatus == 4){
		return "Satisfied";
	}elseif($idStatus == 5){
		return "Very Satisfied";
	}else{
		return $idStatus;
	}
}
?>
<div class="container-fluid">
	<div class="col-lg-12">
		<div class="row">
			<div class="col-md-6">
				<dl>
					<dt><b class="border-bottom border-primary">Service</b></dt>
					<dd>
						<?= displayText($service); ?>
					</dd>
				</dl>
				<dl>
					<dt><b class="border-bottom border-primary">Response</b></dt>
					<dd>
						<?= displayText($response); ?>
					</dd>
				</dl>
				<dl>
					<dt><b class="border-bottom border-primary">Quality</b></dt>
					<dd>
						<?= displayText($quality); ?>
					</dd>
				</dl>
				<dl>
					<dt><b class="border-bottom border-primary">Communication</b></dt>
					<dd>
						<?= displayText($communication); ?>
					</dd>
				</dl>
			</div>
			<div class="col-md-6">
				<dl>
					<dt><b class="border-bottom border-primary">Troubleshooting</b></dt>
					<dd>
						<?= displayText($troubleshooting); ?>
					</dd>
				</dl>
				<dl>
					<dt><b class="border-bottom border-primary">Clean Orderly</b></dt>
					<dd>
						<?= displayText($clean_orderly); ?>
					</dd>
				</dl>
				<dl>
					<dt><b class="border-bottom border-primary">Overall</b></dt>
					<dd>
						<?= displayText($overall); ?>
					</dd>
				</dl>
				<dl>
					<dt><b class="border-bottom border-primary">Experience</b></dt>
					<dd>
						<?= displayText($experience); ?>
					</dd>
				</dl>
			</div>
			<hr>
			<div class="col-md-12">
				<dl>
					<dt><b class="border-bottom border-primary">Core Services</b></dt>
					<dd><?php echo ucwords($core_services) ?></dd>
				</dl>
				<dl>
					<dt><b class="border-bottom border-primary">Improvement</b></dt>
					<dd><?php echo ucwords($improvement) ?></dd>
				</dl>
			</div>
		</div>
	</div>
</div>
<style>
	#uni_modal .modal-footer{
		display: none
	}
	#uni_modal .modal-footer.display{
		display: flex
	}
	#post-field{
		max-height: 70vh;
		overflow: auto;
	}
</style>
<div class="modal-footer display p-0 m-0">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
</div>