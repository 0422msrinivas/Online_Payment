<?php 
include 'db_connect.php';
if(isset($_GET['id'])){
    $qry = $conn->query("SELECT * FROM proctor WHERE id = ".$_GET['id']);
    foreach($qry->fetch_array() as $k => $val){
        $$k = $val;
    }
}
?>

<div class="container-fluid">
    <form action="" id="manage-proctor">
        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
        
        <div class="form-group">
            <label>Proctor ID</label>
            <input type="text" name="id_no" class="form-control" required value="<?php echo isset($id_no) ? $id_no : '' ?>">
        </div>
        <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" class="form-control" required value="<?php echo isset($name) ? $name : '' ?>">
        </div>
        <div class="form-group">
            <label>Contact</label>
            <input type="text" name="contact" class="form-control" maxlength="10" pattern="\d{10}" required value="<?php echo isset($contact) ? $contact : '' ?>">
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required value="<?php echo isset($email) ? $email : '' ?>">
        </div>
        <div class="form-group">
            <label>Department</label>
            <input type="text" name="department" class="form-control" required value="<?php echo isset($department) ? $department : '' ?>">
        </div>
        <div class="form-group">
            <label>Address</label>
            <textarea name="address" class="form-control" rows="3" required><?php echo isset($address) ? $address : '' ?></textarea>
        </div>
    </form>
</div>

<script>
$('#manage-proctor').submit(function(e){
    e.preventDefault();
    start_load();
    $.ajax({
        url: 'ajax.php?action=save_proctor',
        data: new FormData($(this)[0]),
        cache: false,
        contentType: false,
        processData: false,
        method: 'POST',
        success: function(resp){
            if(resp == 1){
                alert_toast("Proctor saved successfully.", 'success');
                setTimeout(() => location.reload(), 1000);
            } else if (resp == 2){
                $('#msg').html('<div class="alert alert-danger">ID already exists.</div>');
                end_load();
            }
        }
    });
});
</script>