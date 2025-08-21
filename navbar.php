<style>
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }

  body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    font-size: 15px;
  }

  nav#sidebar {
    width: 230px;
    background: linear-gradient(to bottom, #0096c7, #023e8a);
    color: white;
    min-height: 100vh;
    box-shadow: 2px 0 12px rgba(0, 0, 0, 0.2);
    position: fixed;
  }

  .sidebar-list {
    padding: 1.5rem 1rem;
  }

  .sidebar-list a {
    display: flex;
    align-items: center;
    text-decoration: none;
    padding: 12px 20px;
    margin-bottom: 8px;
    border-radius: 8px;
    color: #ffffff;
    font-weight: 500;
    background-color: rgba(255, 255, 255, 0.05);
    transition: background-color 0.4s ease, color 0.4s ease, transform 0.4s ease;
    will-change: background-color, color, transform;
  }

  .sidebar-list a:hover,
  .sidebar-list a.active {
    background-color: #48cae4;
    color: #001f3f;
    transform: translateX(4px);
    font-weight: 600;
  }

  .icon-field {
    margin-right: 12px;
    font-size: 18px;
    width: 25px;
    text-align: center;
    transition: color 0.4s ease;
  }

  .mx-2.text-white {
    margin: 20px 10px 10px;
    font-size: 14px;
    color: #caf0f8;
    border-bottom: 1px solid rgba(255, 255, 255, 0.2);
    padding-bottom: 4px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }

  nav#sidebar::-webkit-scrollbar {
    width: 6px;
  }

  nav#sidebar::-webkit-scrollbar-thumb {
    background-color: #90e0ef;
    border-radius: 10px;
  }

  .collapse a {
    text-indent: 10px;
  }
</style>

<nav id="sidebar" class='mx-lt-5 bg-dark'>
	<div class="sidebar-list">
		<a href="index.php?page=home" class="nav-item nav-home"><span class='icon-field'><i class="fa fa-tachometer-alt"></i></span> Dashboard</a>
		<a href="index.php?page=fees" class="nav-item nav-fees"><span class='icon-field'><i class="fa fa-money-check"></i></span> Student Fees</a>
		<a href="index.php?page=payments" class="nav-item nav-payments"><span class='icon-field'><i class="fa fa-receipt"></i></span> Payments</a>
		
		<div class="mx-2 text-white">Master List</div>
		<a href="index.php?page=courses" class="nav-item nav-courses"><span class='icon-field'><i class="fa fa-scroll"></i></span> Courses & Fees</a>
		<a href="index.php?page=students" class="nav-item nav-students"><span class='icon-field'><i class="fa fa-users"></i></span> Students</a>
		
		<div class="mx-2 text-white">Report</div>
		<a href="index.php?page=payments_report" class="nav-item nav-payments_report"><span class='icon-field'><i class="fa fa-th-list"></i></span> Payments Report</a>
		
		<!-- Updated Send Reminders Link -->
       <a href="index.php?page=admin_dues_list" class="nav-item nav-admin_dues_list"><span class='icon-field'><i class="fa fa-bell"></i></span> Send Reminders
</a>
<a href="index.php?page=student_proctor_list" class="nav-item nav-student_proctor_list">
    <span class='icon-field'><i class="fa fa-user-check"></i></span> Student Proctor Assignment
</a>

<a href="index.php?page=proctor" class="nav-item nav-proctor">
    <span class='icon-field'><i class="fa fa-user-tie"></i></span> Manage Proctors
</a>

		<div class="mx-2 text-white">Systems</div>
		<?php if($_SESSION['login_type'] == 1): ?>
			<a href="index.php?page=users" class="nav-item nav-users"><span class='icon-field'><i class="fa fa-users"></i></span> Users</a>
			<!-- <a href="index.php?page=site_settings" class="nav-item nav-site_settings"><span class='icon-field'><i class="fa fa-cogs"></i></span> System Settings</a> -->
		<?php endif; ?>
	</div>
</nav>

<script>
	$('.nav_collapse').click(function(){
		console.log($(this).attr('href'))
		$($(this).attr('href')).collapse()
	})
	$('.nav-<?php echo isset($_GET['page']) ? $_GET['page'] : '' ?>').addClass('active')
</script>
