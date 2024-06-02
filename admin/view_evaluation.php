<?php
include '../db_connect.php';
if (isset($_GET['id'])) {
	$qry = $conn->query("SELECT * FROM tbl_evaluation WHERE id = {$_GET['id']}")->fetch_array();
	foreach ($qry as $k => $v) {
		$$k = $v;
	}
}
function displayText($idStatus)
{
	if ($idStatus == 1) {
		return "Very Dissatisfied";
	} elseif ($idStatus == 2) {
		return "Disatisfied";
	} elseif ($idStatus == 3) {
		return "Neutral";
	} elseif ($idStatus == 4) {
		return "Satisfied";
	} elseif ($idStatus == 5) {
		return "Very Satisfied";
	} else {
		return $idStatus;
	}
}
?>
<div class="container-fluid" id="admin/view_evaluation.php">
	<div class="row">
		<div class="col-md-12">
			<dl>
				<dt><b class="border-bottom border-primary">Evaluator</b></dt>
				<dd><?php
						$fac = $conn->query("SELECT * FROM faculty_list where id = " . $user_id)->fetch_array();
						echo ucwords($fac['firstname'] . ' ' . $fac['lastname']);
						?></dd>
			</dl>
			<dl>
				<dt><b class="border-bottom border-primary">Status</b></dt>
				<dd>
					<b>
						<?php if ($status == 1) : ?>
							<span class="badge badge-success">Accomplish</span>
						<?php else : ?>
							<span class="badge badge-warning">Under Process</span>
						<?php endif; ?>
					</b>
				</dd>
			</dl>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<dl>
				<dt><b class="border-bottom border-primary">Evaluation for</b></dt>
				<dd>
					<?php
					$fac = $conn->query("SELECT * FROM tb_data where id = " . $report_id)->fetch_array();
					echo ucwords($fac['description']) . ' - ' . rtrim($fac['languages'], ',');
					?>
				</dd>
			</dl>
		</div>
	</div>
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
	</div>
	<div class="row">
		<div class="col-md-12">
			<dl>
				<dt><b class="border-bottom border-primary">
						What are the main strengths of the our services?
					</b></dt>
				<dd><?php echo ucwords($core_services) ?></dd>
			</dl>
			<dl>
				<dt><b class="border-bottom border-primary">
						What areas should we need to improve?
					</b></dt>
				<dd><?php echo ucwords($improvement) ?></dd>
			</dl>
		</div>
	</div>
</div>
<style>
	#uni_modal .modal-footer {
		display: none
	}

	#uni_modal .modal-footer.display {
		display: flex
	}

	#post-field {
		max-height: 70vh;
		overflow: auto;
	}
</style>
<div class="modal-footer display p-0 m-0">
	<!-- Print Button -->
	<button class="btn btn-primary" onclick="PrintElem('admin/view_evaluation.php')">Print</button>
	<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
</div>