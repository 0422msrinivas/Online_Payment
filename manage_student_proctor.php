<?php include 'db_connect.php' ?>
<?php
if (isset($_GET['id'])) {
    $qry = $conn->query("SELECT * FROM student_proctor WHERE id = {$_GET['id']} ");
    foreach ($qry->fetch_array() as $k => $v) {
        $$k = $v;
    }
}
?>
<div class="container-fluid">
    <form id="manage-student-proctor">
        <div id="msg"></div>
        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
        
        <div class="form-group">
            <label for="" class="control-label">Student</label>
            <select name="student_id" id="student_id" class="custom-select input-sm select2">
                <option value=""></option>
                <?php
                    $student = $conn->query("SELECT * FROM student ORDER BY name ASC");
                    while ($row = $student->fetch_assoc()):
                ?>
                <option value="<?php echo $row['id'] ?>" <?php echo isset($student_id) && $student_id == $row['id'] ? 'selected' : '' ?>>
                    <?php echo ucwords($row['name']) . ' | ' . $row['id_no'] ?>
                </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="" class="control-label">Proctor</label>
            <select name="proctor_id" id="proctor_id" class="custom-select input-sm select2">
                <option value=""></option>
                <?php
                    $proctors = $conn->query("SELECT * FROM proctor ORDER BY name ASC");
                    while ($row = $proctors->fetch_assoc()):
                ?>
                <option value="<?php echo $row['id'] ?>" <?php echo isset($proctor_id) && $proctor_id == $row['id'] ? 'selected' : '' ?>>
                    <?php echo ucwords($row['name']) ?>
                </option>
                <?php endwhile; ?>
            </select>
        </div>

    </form>
</div>

<script>
$('.select2').select2({
    placeholder: 'Please select here',
    width: '100%'
});

$('#manage-student-proctor').submit(function(e) {
    e.preventDefault();
    start_load();
    $.ajax({
        url: 'ajax.php?action=save_student_proctor',
        method: 'POST',
        data: $(this).serialize(),
        error: err => {
            console.log(err);
            end_load();
        },
        success: function(resp) {
            if (resp == 1) {
                alert_toast("Student Proctor mapping saved successfully.", 'success');
                setTimeout(() => location.reload(), 1000);
            } else if (resp == 2) {
                $('#msg').html('<div class="alert alert-danger">This student already has a proctor assigned.</div>');
                end_load();
            }
        }
    });
});
</script>
