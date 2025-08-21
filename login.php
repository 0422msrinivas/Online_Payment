<!DOCTYPE html>
<html lang="en">
<?php 
session_start();
include('./db_connect.php');
ob_start();
$system = $conn->query("SELECT * FROM system_settings limit 1")->fetch_array();
foreach($system as $k => $v){
	$_SESSION['system'][$k] = $v;
}
ob_end_flush();
?>
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title><?php echo $_SESSION['system']['name'] ?></title>
 	
<?php include('./header.php'); ?>
<?php 
if(isset($_SESSION['login_id']))
header("location:index.php?page=home");
?>

<style>
    body {
        margin: 0;
        padding: 0;
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #1a2a6c, #b21f1f, #fdbb2d);
        background-size: 400% 400%;
        animation: gradientAnimation 15s ease infinite;
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        overflow: hidden;
    }

    @keyframes gradientAnimation {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    main#main {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        height: 100%;
    }

    .card {
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(10px);
        border-radius: 15px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.37);
        padding: 30px;
        animation: fadeIn 1.5s ease;
    }

    .card-body {
        text-align: center;
    }

    .form-control {
        margin-bottom: 20px;
        border: none;
        border-radius: 5px;
        padding: 10px;
        background: rgba(255, 255, 255, 0.7);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .form-control:focus {
        transform: scale(1.05);
        box-shadow: 0 4px 15px rgba(0, 128, 255, 0.6);
        outline: none;
    }

    .btn-primary {
        padding: 12px 20px;
        color: white;
        background: linear-gradient(90deg, #ff7e5f, #feb47b);
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .btn-primary:hover {
        transform: scale(1.1);
        box-shadow: 0 6px 15px rgba(255, 126, 95, 0.4);
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
</head>

<body>
  <main id="main">
      <div class="align-self-center w-100">

        <!-- <h4 class="text-white text-center"><b><?php echo $_SESSION['system']['name'] ?></b></h4> -->
        <h4 class="text-white text-center"><b>Admin Login</b></h4>
        <div id="login-center" class="row justify-content-center">
          <div class="card col-md-4">
            <div class="card-body">
              <form id="login-form">
                <div class="form-group">
                  <label for="username" class="control-label">Username</label>
                  <input type="text" id="username" name="username" class="form-control">
                </div>
                <div class="form-group">
                  <label for="password" class="control-label">Password</label>
                  <input type="password" id="password" name="password" class="form-control">
                </div>
                <center><button class="btn btn-primary">Login</button></center>
              </form>
            </div>
          </div>
        </div>
      </div>
  </main>

  <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>
</body>

<script>
  $('#login-form').submit(function(e){
    e.preventDefault();
    $('#login-form button').attr('disabled', true).html('Logging in...');
    if($(this).find('.alert-danger').length > 0)
      $(this).find('.alert-danger').remove();
    $.ajax({
      url: 'ajax.php?action=login',
      method: 'POST',
      data: $(this).serialize(),
      error: function(err) {
        console.log(err);
        $('#login-form button').removeAttr('disabled').html('Login');
      },
      success: function(resp) {
        if(resp == 1) {
          location.href = 'index.php?page=home';
        } else {
          $('#login-form').prepend('<div class="alert alert-danger">Username or password is incorrect.</div>');
          $('#login-form button').removeAttr('disabled').html('Login');
        }
      }
    });
  });
</script>
</html>