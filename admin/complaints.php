<?php
include 'db_connect.php';
?>
<div class="container-fluid">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<b>List of Reports of Complaints</b>
			</div>
			<div class="card-body">
				<table class="table table-bordered table-hover" id="complaint-tbl">
					<thead>
						<tr>
							<th width="10%">Date</th>
							<th width="20%">Information</th>
							<th width="10%">Report</th>
							<th width="20%">Incident Address</th>
							<th width="10%">Status</th>
							<th width="10%">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$status = array("", "Pending", "Received", "Action Made");
						$qry = $conn->query("SELECT c.*, cm.name, cm.contact, cm.address as user_address FROM complaints c LEFT JOIN complainants cm ON c.complainant_id = cm.id ORDER BY unix_timestamp(c.date_created) DESC");

						while ($row = $qry->fetch_array()):
							?>
							<tr class="<?php echo $row['status'] == 1 ? 'border-alert' : '' ?>">
								<td>
									<?php echo date('M d, Y h:i A', strtotime($row['date_created'])) ?>
								</td>
								<td>
									<p>Name:
										<small><i><b>
													<?php echo $row['name'] ?>
												</b></i></small>
									</p>
									<p>Contact #: <b>
											<?php echo $row['contact'] ?>
										</b></p>
									<p>User Address:<small><i><b>
													<?php echo $row['user_address'] ?>
												</b></i></small> </p>

								</td>
								<td>
									<?php echo $row['message'] ?>
								</td>
								<td>
									<?php echo $row['incident_address'] ?>
								</td>
								<td>
									<?php echo $status[$row['status']] ?>
								</td>
								<td class="text-center">
									<button class="btn btn-primary btn-sm m-0 view_btn" type="button"
										data-id="<?php echo $row['id'] ?>">View</button>
								</td>
							</tr>
						<?php endwhile; ?>


					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<style>
	.border-gradien-alert {
		border-image: linear-gradient(to right, red, yellow) !important;
	}

	.border-alert th,
	.border-alert td {
		animation: blink 200ms infinite alternate;
	}

	@keyframes blink {
		from {
			border-color: white;
		}

		to {
			border-color: red;
			background: #ff00002b;
		}
	}
</style>
<script>
	$('#complaint-tbl').dataTable();
	$('.view_btn').click(function () {
		uni_modal("View Details", "manage_complaint.php?id=" + $(this).attr('data-id'), "mid-large")
	})
</script>