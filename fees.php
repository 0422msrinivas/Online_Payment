<?php include('db_connect.php'); ?>
<style>
	input[type=checkbox] {
		-ms-transform: scale(1.3);
		-moz-transform: scale(1.3);
		-webkit-transform: scale(1.3);
		-o-transform: scale(1.3);
		transform: scale(1.3);
		padding: 10px;
		cursor: pointer;
	}

thead {
	background:  #007bff;
	color: #fff;
}

.card-header {
	background: linear-gradient(to right, #4facfe, #00f2fe);
	color: #fff;
	font-weight: bold;
	font-size: 1.2rem;
	box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
	border: none;
	border-radius: 1rem 1rem 0 0;
}

.card {
	background: rgba(255, 255, 255, 0.15);
	backdrop-filter: blur(10px);
	-webkit-backdrop-filter: blur(10px);
	border-radius: 2xl;
	box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
	border: 1px solid rgba(255, 255, 255, 0.2);
	transition: transform 0.3s ease;
}

.card:hover {
	transform: translateY(-4px);
}

.btn-outline-primary {
	border-color: #764ba2;
	color: #764ba2;
	transition: 0.3s ease-in-out;
}

.btn-outline-primary:hover {
	background: #764ba2;
	color: white;
}
</style>
<div class="container-fluid">
	<div class="col-lg-12">
		<div class="row mb-4 mt-4">
			<div class="col-md-12"></div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<b>List of Student Fees</b>
						<span class="float:right"><a class="btn btn-primary btn-block btn-sm col-sm-2 float-right" href="javascript:void(0)" id="new_fees">
							<i class="fa fa-plus"></i> New 
						</a></span>
					</div>
					<div class="card-body">
						<table class="table table-condensed table-bordered table-hover">
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th>ID No.</th>
									<th>EF No.</th>
									<th>Name</th>
									<th>Payable Fee</th>
									<th>Paid</th>
									<th>Balance</th>
									<th class="text-center">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$i = 1;
								$fees = $conn->query("SELECT ef.*,s.name as sname,s.id_no FROM student_ef_list ef inner join student s on s.id = ef.student_id order by s.name asc ");
								while($row=$fees->fetch_assoc()):
									$paid = $conn->query("SELECT sum(amount) as paid FROM payments where ef_id=".$row['id']);
									$paid = $paid->num_rows > 0 ? $paid->fetch_array()['paid']:0;
									$balance = $row['total_fee'] - $paid;
								?>
								<tr>
									<td class="text-center"><?php echo $i++ ?></td>
									<td><p><b><?php echo $row['id_no'] ?></b></p></td>
									<td><p><b><?php echo $row['ef_no'] ?></b></p></td>
									<td><p><b><?php echo ucwords($row['sname']) ?></b></p></td>
									<td class="text-right"><p><b><?php echo number_format($row['total_fee'],2) ?></b></p></td>
									<td class="text-right"><p><b><?php echo number_format($paid,2) ?></b></p></td>
									<td class="text-right"><p><b><?php echo number_format($balance,2) ?></b></p></td>
									<td class="text-center">
										<button class="btn btn-sm btn-outline-primary view_payment" type="button" data-id="<?php echo $row['id'] ?>">View</button>
										<button class="btn btn-sm btn-outline-primary edit_fees" type="button" data-id="<?php echo $row['id'] ?>">Edit</button>
										<button class="btn btn-sm btn-outline-danger delete_fees" type="button" data-id="<?php echo $row['id'] ?>">Delete</button>
									</td>
								</tr>
								<?php endwhile; ?>
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
		margin: unset;
	}
	img {
		max-width: 100px;
		max-height: 150px;
	}
</style>
<script>
	$(document).ready(function(){
		$('table').dataTable()
	})

	$('.view_payment').click(function(){
		uni_modal("Payment Details","view_payment.php?ef_id="+$(this).attr('data-id')+"&pid=0","mid-large")
	})

	$('#new_fees').click(function(){
		uni_modal("Enroll Student ","manage_fee.php","mid-large")
	})

	$('.edit_fees').click(function(){
		uni_modal("Manage Student's Enrollment Details","manage_fee.php?id="+$(this).attr('data-id'),"mid-large")
	})

	$('.delete_fees').click(function(){
		_conf("Are you sure to delete this fees ?","delete_fees",[$(this).attr('data-id')])
	})

	function delete_fees($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_fees',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully deleted",'success')
					setTimeout(function(){
						location.reload()
					},1500)
				}
			}
		})
	}
</script>
