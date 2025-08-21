<?php include 'db_connect.php'; ?>
<div class="container-fluid">
	<div class="col-lg-12">
		<div class="row mb-4 mt-4">
			<div class="col-md-12">
				<h4><b>Student-Proctor Connection</b></h4>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<b>List of Connections</b>
						<span class="float:right">
							<a class="btn btn-primary btn-block btn-sm col-sm-2 float-right" href="javascript:void(0)" id="new_connection">
								<i class="fa fa-plus"></i> New 
							</a>
						</span>
					</div>
					<div class="card-body">
						<table class="table table-condensed table-bordered table-hover">
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th>Student ID</th>
									<th>Student Name</th>
									<th>Proctor Name</th>
									<th class="text-center">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$i = 1;
								$query = $conn->query("SELECT sp.*, s.id_no, s.name as sname, p.name as pname 
									FROM student_proctor sp 
									INNER JOIN student s ON sp.student_id = s.id 
									INNER JOIN proctor p ON sp.proctor_id = p.id 
									ORDER BY sp.id ASC");
								if($query->num_rows > 0):
									while($row = $query->fetch_assoc()):
								?>
								<tr>
									<td class="text-center"><?php echo $i++ ?></td>
									<td><?php echo $row['id_no'] ?></td>
									<td><?php echo ucwords($row['sname']) ?></td>
									<td><?php echo ucwords($row['pname']) ?></td>
									<td class="text-center">
										<button class="btn btn-sm btn-outline-primary edit_connection" type="button" data-id="<?php echo $row['id'] ?>">Edit</button>
										<button class="btn btn-sm btn-outline-danger delete_connection" type="button" data-id="<?php echo $row['id'] ?>">Delete</button>
									</td>
								</tr>
								<?php endwhile; else: ?>
								<tr>
									<th class="text-center" colspan="5">No data found.</th>
								</tr>
								<?php endif; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<style>
	td {
		vertical-align: middle !important;
	}
	td p {
		margin: unset
	}
	img {
		max-width: 100px;
		max-height: 150px;
	}
</style>

<script>
	$(document).ready(function(){
		$('table').dataTable();
	});

	$('#new_connection').click(function(){
		uni_modal("New Student-Proctor Connection", "manage_connection.php", "mid-large");
	});

	$('.edit_connection').click(function(){
		uni_modal("Edit Student-Proctor Connection", "manage_connection.php?id=" + $(this).attr('data-id'), "mid-large");
	});

	$('.delete_connection').click(function(){
		_conf("Are you sure to delete this connection?", "delete_connection", [$(this).attr('data-id')]);
	});

	function delete_connection($id){
		start_load();
		$.ajax({
			url: 'ajax.php?action=delete_connection',
			method: 'POST',
			data: {id: $id},
			success: function(resp){
				if(resp == 1){
					alert_toast("Connection deleted successfully", 'success');
					setTimeout(function(){
						location.reload();
					}, 1500);
				}
			}
		});
	}
</script>
