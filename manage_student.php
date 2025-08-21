<?php 
include 'db_connect.php'; 
if(isset($_GET['id'])){
    $qry = $conn->query("SELECT * FROM student WHERE id = ".$_GET['id']);
    foreach($qry->fetch_array() as $k => $val){
        $$k = $val;
    }
}
?>
<div class="container-fluid">
    <form action="" id="manage-student">
        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
        <div id="msg" class="form-group"></div>

        <div class="form-group">
            <label for="" class="control-label">Admission Number</label>
            <input type="text" class="form-control" name="id_no" value="<?php echo isset($id_no) ? $id_no : '' ?>" required>
        </div>

        <div class="form-group">
            <label for="" class="control-label">Name</label>
            <input type="text" class="form-control" name="name" value="<?php echo isset($name) ? $name : '' ?>" required>
        </div>

        <div class="form-group">
            <label for="" class="control-label">Contact</label>
            <input type="text" class="form-control" name="contact" maxlength="10" pattern="\d{10}" title="Please enter a valid 10-digit mobile number." value="<?php echo isset($contact) ? $contact : '' ?>" required>
        </div>

        <div class="form-group">
            <label for="" class="control-label">Email</label>
            <input type="email" class="form-control" name="email" id="email" value="<?php echo isset($email) ? $email : '' ?>" required>
            <span id="email-error" class="text-danger" style="display:none;">Please enter a valid email address.</span>
        </div>

        <div class="form-group">
            <label for="" class="control-label">Address</label>
            <textarea name="address" id="" cols="30" rows="3" class="form-control" required><?php echo isset($address) ? $address : '' ?></textarea>
        </div>

        <!-- Admission Type Dropdown -->
        <div class="form-group">
            <label for="" class="control-label">Admission Type</label>
            <select name="admission_type" class="form-control" required>
                <option value="CET" <?php echo isset($admission_type) && $admission_type == 'CET' ? 'selected' : ''; ?>>CET</option>
                <option value="Management" <?php echo isset($admission_type) && $admission_type == 'Management' ? 'selected' : ''; ?>>Management</option>
                <!-- Add other admission types here if needed -->
            </select>
        </div>
    </form>
</div>

<script>
    $(document).ready(function() {
        // Email validation
        $('#email').on('input', function() {
            const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            const email = $(this).val();
            if (emailPattern.test(email)) {
                $('#email-error').hide();
                $('#submit-btn').prop('disabled', false); // Enable submit button if valid
            } else {
                $('#email-error').show();
                $('#submit-btn').prop('disabled', true); // Disable submit button if invalid
            }
        });

        // Form reset
        $('#manage-student').on('reset', function() {
            $('#msg').html('');
            $('input:hidden').val('');
        });

        // Form submit
        $('#manage-student').submit(function(e) {
            e.preventDefault();

            // Check if email is valid before submitting
            const email = $('#email').val();
            const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            if (!emailPattern.test(email)) {
                $('#email-error').show(); // Show error if email is invalid
                return; // Prevent form submission if email is invalid
            }

            start_load();
            $('#msg').html('');
            $.ajax({
                url: 'ajax.php?action=save_student',
                data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                success: function(resp) {
                    if (resp == 1) {
                        alert_toast("Data successfully saved.", 'success');
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    } else if (resp == 2) {
                        $('#msg').html('<div class="alert alert-danger mx-2">ID # already exists.</div>');
                        end_load();
                    }
                }
            });
        });
    });
</script>
