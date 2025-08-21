<?php
include 'db_connect.php';

$student_id = isset($_GET['id']) ? $_GET['id'] : '';
$student = null;
$existing_connection = null;

$students = $conn->query("SELECT * FROM student");
$proctors = $conn->query("SELECT * FROM proctor");

if (!empty($student_id)) {
    $student_result = $conn->query("SELECT * FROM student WHERE id = '$student_id'");
    if ($student_result && $student_result->num_rows > 0) {
        $student = $student_result->fetch_assoc();
    }

    $connection_result = $conn->query("SELECT * FROM student_proctor WHERE student_id = '$student_id'");
    if ($connection_result && $connection_result->num_rows > 0) {
        $existing_connection = $connection_result->fetch_assoc();
    }
}
?>

<div class="container-fluid">
    <form action="" id="manage-connection">
        <input type="hidden" name="id" value="<?php echo isset($existing_connection['id']) ? $existing_connection['id'] : '' ?>">

        <div class="form-group">
            <label for="">Select Student</label>
            <select name="student_id" class="form-control" required>
                <option value="">Select Student</option>
                <?php while($row = $students->fetch_assoc()): ?>
                    <option value="<?php echo $row['id'] ?>"
                        <?php
                            if ((isset($student_id) && $student_id == $row['id']) || 
                                (isset($existing_connection['student_id']) && $existing_connection['student_id'] == $row['id'])) 
                                echo 'selected';
                        ?>>
                        <?php echo htmlspecialchars($row['name']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="">Assign Proctor</label>
            <select name="proctor_id" class="form-control" required>
                <option value="">Select Proctor</option>
                <?php while($row = $proctors->fetch_assoc()): ?>
                    <option value="<?php echo $row['id'] ?>"
                        <?php echo (isset($existing_connection['proctor_id']) && $existing_connection['proctor_id'] == $row['id']) ? 'selected' : '' ?>>
                        <?php echo htmlspecialchars($row['name']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <button class="btn btn-primary btn-sm mt-2">Save</button>
    </form>
</div>

<script>
$('#manage-connection').submit(function(e){
    e.preventDefault();
    start_load();
    $.ajax({
        url: 'ajax.php?action=save_connection',
        method: 'POST',
        data: $(this).serialize(),
        success: function(resp){
            if(resp == 1){
                alert_toast("Connection saved successfully.", 'success');
                setTimeout(function(){
                    location.reload();
                }, 1000);
            } else {
                alert_toast("Error saving connection.", 'danger');
                end_load();
            }
        }
    });
});
</script>
