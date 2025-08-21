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
        background: linear-gradient(to right, #6a11cb, #2575fc);
        color: white;
        border-radius: 30px;
        padding: 10px 20px;
        font-weight: 600;
        border: none;
    }

    .btn-primary:hover {
        background: linear-gradient(to right, #2575fc, #6a11cb);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(106, 17, 203, 0.3);
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
        background-color: #f1f7ff;
        transform: scale(1.01);
        box-shadow: 0 2px 8px rgba(0, 123, 255, 0.1);
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

    #new_course {
        float: right;
        transition: 0.2s ease-in-out;
    }

    #new_course:hover {
        transform: scale(1.05);
    }

    input[type=checkbox] {
        transform: scale(1.3);
        padding: 10px;
        cursor: pointer;
    }
</style>

<div class="container-fluid mt-4">
    <div class="col-lg-12">
        <div class="row mb-4">
            <div class="col-md-12 text-right">
                <a class="btn btn-primary btn-sm" href="javascript:void(0)" id="new_course">
                    <i class="fa fa-plus-circle"></i> New Entry
                </a>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                📘 List of Courses and Fees
            </div>
            <div class="card-body p-4">
                <table class="table table-bordered table-hover table-striped">
                    <thead class="text-center">
                        <tr>
                            <th>#</th>
                            <th>Course/Semester</th>
                            <th>Description</th>
                            <th>Total Fee</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $i = 1;
                        $course = $conn->query("SELECT * FROM courses ORDER BY course ASC");
                        while($row = $course->fetch_assoc()):
                        ?>
                        <tr>
                            <td class="text-center"><?php echo $i++ ?></td>
                            <td><b><?php echo $row['course'] . " - " . $row['level'] ?></b></td>
                            <td><small><i><b><?php echo $row['description'] ?></b></i></small></td>
                            <td class="text-right"><b><?php echo number_format($row['total_amount'], 2) ?></b></td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-outline-primary edit_course" data-id="<?php echo $row['id'] ?>">Edit</button>
                                <button class="btn btn-sm btn-outline-danger delete_course" data-id="<?php echo $row['id'] ?>">Delete</button>
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

    $('#new_course').click(function(){
        uni_modal("New Course and Fees Entry", "manage_course.php", "large");
    });

    $('.edit_course').click(function(){
        uni_modal("Manage Course and Fees Entry", "manage_course.php?id=" + $(this).attr('data-id'), "large");
    });

    $('.delete_course').click(function(){
        _conf("Are you sure to delete this course?", "delete_course", [$(this).attr('data-id')]);
    });

    function delete_course($id){
        start_load();
        $.ajax({
            url: 'ajax.php?action=delete_course',
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
