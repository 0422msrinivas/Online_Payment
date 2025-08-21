<?php include 'db_connect.php'; ?>
<style>
.card {
	background: rgba(255, 255, 255, 0.15);
	backdrop-filter: blur(10px);
	-webkit-backdrop-filter: blur(10px);
	border-radius: 1rem;
	box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
	border: 1px solid rgba(255, 255, 255, 0.2);
	transition: transform 0.3s ease;
}

.card:hover {
	transform: translateY(-4px);
}

.card-header {
	background: linear-gradient(to right, #4facfe, #00f2fe);
	color: white;
	font-weight: bold;
	font-size: 1.2rem;
	border-radius: 1rem 1rem 0 0;
	box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
}

thead {
	background: #007bff;
	color: #fff;
}

.btn-primary {
	background: #764ba2;
	border-color: #764ba2;
	transition: 0.3s ease-in-out;
}

.btn-primary:hover {
	background: #667eea;
	border-color: #667eea;
}

.table td, .table th {
	vertical-align: middle !important;
}

.table td p {
	margin: unset;
}
</style>

<div class="container-fluid">
	<div class="row mb-3">
		<div class="col-lg-12">
			<button class="btn btn-primary float-right btn-sm" id="new_user">
				<i class="fa fa-plus"></i> New user
			</button>
		</div>
	</div>
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header"><b>User List</b></div>
			<div class="card-body">
				<table class="table table-striped table-bordered" id="user-table">
					<thead>
						<tr>
							<th class="text-center">#</th>
							<th class="text-center">Name</th>
							<th class="text-center">Username</th>
							<th class="text-center">Type</th>
							<th class="text-center">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$type = array("", "Admin", "Staff", "Alumnus/Alumna");
						$users = $conn->query("SELECT * FROM users ORDER BY name ASC");
						$i = 1;
						while ($row = $users->fetch_assoc()):
						?>
						<tr>
							<td class="text-center"><?php echo $i++ ?></td>
							<td><?php echo ucwords($row['name']) ?></td>
							<td><?php echo $row['username'] ?></td>
							<td><?php echo $type[$row['type']] ?></td>
							<td class="text-center">
								<div class="btn-group">
									<button type="button" class="btn btn-primary btn-sm">Action</button>
									<button type="button" class="btn btn-primary btn-sm dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										<span class="sr-only">Toggle Dropdown</span>
									</button>
									<div class="dropdown-menu">
										<a class="dropdown-item edit_user" href="javascript:void(0)" data-id='<?php echo $row['id'] ?>'>Edit</a>
										<div class="dropdown-divider"></div>
										<a class="dropdown-item delete_user" href="javascript:void(0)" data-id='<?php echo $row['id'] ?>'>Delete</a>
									</div>
								</div>
							</td>
						</tr>
						<?php endwhile; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<script>
	$('#user-table').dataTable();

	$('#new_user').click(function(){
		uni_modal('New User','manage_user.php');
	});

	$('.edit_user').click(function(){
		uni_modal('Edit User','manage_user.php?id=' + $(this).attr('data-id'));
	});

	$('.delete_user').click(function(){
		_conf("Are you sure to delete this user?", "delete_user", [$(this).attr('data-id')]);
	});

	function delete_user(id){
		start_load();
		$.ajax({
			url: 'ajax.php?action=delete_user',
			method: 'POST',
			data: {id: id},
			success: function(resp){
				if(resp == 1){
					alert_toast("Data successfully deleted", 'success');
					setTimeout(function(){
						location.reload();
					}, 1500);
				}
			}
		});
	}
</script>
