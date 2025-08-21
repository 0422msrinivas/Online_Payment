<?php include('db_connect.php'); ?>
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
        backdrop-filter: blur(4px);
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

    .table {
        border-radius: 10px;
        overflow: hidden;
    }

    thead {
        background-color: #007bff;
        color: #fff;
    }

    table th, table td {
        vertical-align: middle !important;
    }

    table tbody tr:hover {
        background-color: #f1f7ff;
        transition: background-color 0.3s ease;
    }

    .btn {
        border-radius: 30px;
        font-size: 13px;
        padding: 6px 15px;
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

    .table-info-text small {
        display: block;
        line-height: 1.4;
        margin-top: 2px;
    }

    #new_student {
        float: right;
        transition: 0.2s ease-in-out;
    }

    #new_student:hover {
        transform: scale(1.05);
    }

    @media (max-width: 768px) {
        .card-header {
            font-size: 18px;
        }
        table {
            font-size: 13px;
        }
    }
	/* WOW-style Modal Design */
.modal-content {
    border-radius: 20px;
    background: #f9f9fb;
    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.2);
    padding: 25px;
    animation: modalFadeIn 0.35s ease-in-out;
    border: none;
    backdrop-filter: blur(8px);
}

@keyframes modalFadeIn {
    0% {
        opacity: 0;
        transform: translateY(-20px) scale(0.95);
    }
    100% {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

.modal-header {
    background: linear-gradient(to right, #6a11cb, #2575fc);
    color: white;
    border-top-left-radius: 20px;
    border-top-right-radius: 20px;
    padding: 18px 24px;
    border-bottom: none;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.modal-title {
    font-size: 22px;
    font-weight: 600;
    letter-spacing: 1px;
}

.modal-body {
    padding: 25px;
    background-color: #fff;
    border-radius: 0 0 20px 20px;
}

.modal-footer {
    background-color: #f1f3f6;
    border-radius: 0 0 20px 20px;
    padding: 15px 20px;
    border-top: 1px solid #dee2e6;
}

input.form-control, select.form-control, textarea.form-control {
    border-radius: 12px;
    padding: 10px 16px;
    border: 1px solid #ccc;
    font-size: 14px;
    margin-bottom: 15px;
    transition: all 0.3s ease;
    background-color: #fdfdfd;
}

input.form-control:focus, textarea.form-control:focus, select.form-control:focus {
    border-color: #6a11cb;
    box-shadow: 0 0 0 4px rgba(106, 17, 203, 0.1);
    background-color: #fff;
    outline: none;
}

.btn-primary {
    background: linear-gradient(to right, #6a11cb, #2575fc);
    color: white;
    border-radius: 30px;
    padding: 10px 25px;
    font-weight: 600;
    border: none;
    transition: 0.3s ease-in-out;
}

.btn-primary:hover {
    background: linear-gradient(to right, #2575fc, #6a11cb);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(106, 17, 203, 0.3);
}

.btn-secondary {
    border-radius: 30px;
    padding: 10px 25px;
    font-weight: 600;
    color: #333;
    background-color: #e0e0e0;
    border: none;
    transition: 0.3s ease-in-out;
}

.btn-secondary:hover {
    background-color: #d5d5d5;
    transform: scale(1.02);
}
select.form-control {
    min-height: 45px;
    font-size: 15px;
    padding: 10px 14px;
    border-radius: 12px;
    background-color: #fdfdfd;
}
/* Table Row Fade-in Animation */
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

table tbody tr {
    animation: rowFadeIn 0.4s ease-in-out;
}

/* Optional: Smooth scale effect on hover */
table tbody tr:hover {
    background-color: #f1f7ff;
    transform: scale(1.01);
    box-shadow: 0 2px 8px rgba(0, 123, 255, 0.1);
    transition: all 0.3s ease-in-out;
}

</style>

<div class="container-fluid mt-4">
    <div class="col-lg-12">
        <div class="row mb-4">
            <div class="col-md-12 text-right">
                <a class="btn btn-primary btn-sm" href="javascript:void(0)" id="new_student">
                    <i class="fa fa-plus-circle"></i> Add Student
                </a>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                🎓 List of Students
            </div>
            <div class="card-body p-4">
                <table class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr class="text-center">
                            <th>#</th>
                            <th>Admission No.</th>
                            <th>Name</th>
                            <th>Details</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $i = 1;
                        $student = $conn->query("SELECT * FROM student ORDER BY name ASC");
                        while($row = $student->fetch_assoc()):
                        ?>
                        <tr>
                            <td class="text-center"><?php echo $i++ ?></td>
                            <td><b><?php echo $row['id_no'] ?></b></td>
                            <td><b><?php echo ucwords($row['name']) ?></b></td>
                            <td class="table-info-text">
                                <small><strong>Email:</strong> <?php echo $row['email'] ?></small>
                                <small><strong>Contact:</strong> <?php echo $row['contact'] ?></small>
                                <small><strong>Address:</strong> <?php echo $row['address'] ?></small>
                            </td>
                            <td class="text-center">
                                <button class="btn btn-outline-primary btn-sm edit_student" data-id="<?php echo $row['id'] ?>">
                                    <i class="fa fa-edit"></i> Edit
                                </button>
                                <button class="btn btn-outline-danger btn-sm delete_student" data-id="<?php echo $row['id'] ?>">
                                    <i class="fa fa-trash"></i> Delete
                                </button>
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
    $(document).ready(function(){
        $('table').dataTable();
    });

    $('#new_student').click(function(){
        uni_modal("New Student", "manage_student.php", "mid-large");
    });

    $('.edit_student').click(function(){
        uni_modal("Manage Student Details", "manage_student.php?id=" + $(this).attr('data-id'), "mid-large");
    });

    $('.delete_student').click(function(){
        _conf("Are you sure to delete this Student?", "delete_student", [$(this).attr('data-id')]);
    });

    function delete_student($id){
        start_load();
        $.ajax({
            url: 'ajax.php?action=delete_student',
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
