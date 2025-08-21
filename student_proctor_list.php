<?php include('db_connect.php'); ?>
<style>
input[type=checkbox] {
    transform: scale(1.3);
    padding: 10px;
    cursor: pointer;
}
</style>
<div class="container-fluid">
    <div class="col-lg-12">
        <div class="row mb-4 mt-4"></div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <b>List of Student Proctors</b>
                        <span class="float:right">
                            <a class="btn btn-primary btn-block btn-sm col-sm-2 float-right" href="javascript:void(0)" id="new_student_proctor">
                                <i class="fa fa-plus"></i> New 
                            </a>
                        </span>
                    </div>
                    <div class="card-body">
                        <table class="table table-condensed table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>ID Number</th>
                                    <th>Student Name</th>
                                    <th>Proctor Name</th>
                                    <th>Information</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $i = 1;
                                $student = $conn->query("
                                    SELECT sp.id, s.id_no, s.name AS student_name, s.email, s.contact, s.address,
                                           p.name AS proctor_name
                                    FROM student_proctor sp
                                    JOIN student s ON s.id = sp.student_id
                                    JOIN proctor p ON p.id = sp.proctor_id
                                    ORDER BY s.name ASC
                                ");
                                while($row = $student->fetch_assoc()):
                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $i++ ?></td>
                                    <td><b><?php echo $row['id_no'] ?></b></td>
                                    <td><b><?php echo ucwords($row['student_name']) ?></b></td>
                                    <td><b><?php echo ucwords($row['proctor_name']) ?></b></td>
                                    <td>
                                        <small>Email: <b><i><?php echo $row['email'] ?></i></b></small><br>
                                        <small>Contact #: <b><i><?php echo $row['contact'] ?></i></b></small><br>
                                        <small>Address: <b><i><?php echo $row['address'] ?></i></b></small>
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-outline-primary edit_student_proctor" data-id="<?php echo $row['id'] ?>">Edit</button>
                                        <button class="btn btn-sm btn-outline-danger delete_student_proctor" data-id="<?php echo $row['id'] ?>">Delete</button>
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
    $('table').DataTable();
});

$('#new_student_proctor').click(function(){
    uni_modal("New Student Proctor", "manage_student_proctor.php", "mid-large");
});

$('.edit_student_proctor').click(function(){
    uni_modal("Edit Student Proctor", "manage_student_proctor.php?id=" + $(this).attr('data-id'), "mid-large");
});

$('.delete_student_proctor').click(function(){
    _conf("Are you sure you want to delete this student proctor?", "delete_student_proctor", [$(this).attr('data-id')]);
});

function delete_student_proctor(id){
    start_load();
    $.ajax({
        url: 'ajax.php?action=delete_student_proctor',
        method: 'POST',
        data: { id: id },
        success: function(resp){
            if(resp == 1){
                alert_toast("Data successfully deleted", 'success');
                setTimeout(() => location.reload(), 1500);
            }
        }
    });
}
</script>
