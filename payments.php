<?php include 'db_connect.php'; ?>
<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: #f0f2f5;
    }

    .card {
        border: none;
        border-radius: 16px;
        background: rgba(255, 255, 255, 0.85);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        backdrop-filter: blur(6px);
    }

    .card-header {
        background: linear-gradient(to right, #4facfe, #00f2fe);
        color: white;
        border-radius: 16px 16px 0 0;
        padding: 20px 25px;
        font-size: 22px;
        font-weight: 600;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .btn {
        border-radius: 30px;
        font-size: 13px;
        padding: 6px 15px;
        transition: all 0.3s ease-in-out;
    }

    .btn-sm {
        margin: 2px;
    }

    .btn-outline-primary:hover {
        background: #007bff;
        color: white;
    }

    .btn-outline-danger:hover {
        background: #dc3545;
        color: white;
    }

    .btn-primary {
        background: linear-gradient(to right, #667eea, #764ba2);
        color: white;
        border-radius: 30px;
        padding: 10px 20px;
        font-weight: 600;
        border: none;
    }

    .btn-primary:hover {
        background: linear-gradient(to right, #764ba2, #667eea);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    }

    table {
        border-radius: 10px;
        overflow: hidden;
    }

    thead {
        background-color: #007bff;
        color: #fff;
    }

    table tbody tr {
        animation: rowFadeIn 0.4s ease-in-out;
    }

    table tbody tr:hover {
        background-color: #ecfdf5;
        transform: scale(1.01);
        box-shadow: 0 2px 8px rgba(32, 201, 151, 0.1);
        transition: all 0.3s ease-in-out;
    }

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

    @keyframes rowFadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    #new_payment {
        float: right;
        transition: 0.2s ease-in-out;
    }

    #new_payment:hover {
        transform: scale(1.05);
    }
</style>

<div class="container-fluid mt-4">
    <div class="col-lg-12">
        <div class="row mb-4">
            <div class="col-md-12 text-right">
                <a class="btn btn-primary btn-sm" href="javascript:void(0)" id="new_payment">
                    <i class="fa fa-plus-circle"></i> New
                </a>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                💰 List of Payments
            </div>
            <div class="card-body p-4">
                <table class="table table-bordered table-hover table-striped">
                    <thead class="text-center">
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>ID No.</th>
                            <th>EF No.</th>
                            <th>Name</th>
                            <th>Paid Amount</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $i = 1;
                        $payments = $conn->query("SELECT p.*,s.name as sname, ef.ef_no,s.id_no FROM payments p inner join student_ef_list ef on ef.id = p.ef_id inner join student s on s.id = ef.student_id order by unix_timestamp(p.date_created) desc ");
                        if($payments->num_rows > 0):
                            while($row=$payments->fetch_assoc()):
                                $paid = $conn->query("SELECT sum(amount) as paid FROM payments where ef_id=".$row['id']);
                                $paid = $paid->num_rows > 0 ? $paid->fetch_array()['paid']:'';
                        ?>
                        <tr>
                            <td class="text-center"><?php echo $i++ ?></td>
                            <td><b><?php echo date("M d,Y H:i A",strtotime($row['date_created'])) ?></b></td>
                            <td><b><?php echo $row['id_no'] ?></b></td>
                            <td><b><?php echo $row['ef_no'] ?></b></td>
                            <td><b><?php echo ucwords($row['sname']) ?></b></td>
                            <td class="text-right"><b><?php echo number_format($row['amount'],2) ?></b></td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-outline-primary view_payment" data-id="<?php echo $row['id'] ?>" data-ef_id="<?php echo $row['ef_id'] ?>">View</button>
                                <button class="btn btn-sm btn-outline-primary edit_payment" data-id="<?php echo $row['id'] ?>">Edit</button>
                                <button class="btn btn-sm btn-outline-danger delete_payment" data-id="<?php echo $row['id'] ?>">Delete</button>
                            </td>
                        </tr>
                        <?php endwhile; else: ?>
                        <tr>
                            <th class="text-center" colspan="7">No data.</th>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('table').dataTable();
    });

    $('#new_payment').click(function(){
        uni_modal("New Payment", "manage_payment.php", "mid-large");
    });

    $('.view_payment').click(function(){
        uni_modal("Payment Details", "view_payment.php?ef_id=" + $(this).attr('data-ef_id') + "&pid=" + $(this).attr('data-id'), "mid-large");
    });

    $('.edit_payment').click(function(){
        uni_modal("Manage Payment", "manage_payment.php?id=" + $(this).attr('data-id'), "mid-large");
    });

    $('.delete_payment').click(function(){
        _conf("Are you sure to delete this payment?", "delete_payment", [$(this).attr('data-id')]);
    });

    function delete_payment($id){
        start_load();
        $.ajax({
            url: 'ajax.php?action=delete_payment',
            method: 'POST',
            data: { id: $id },
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
