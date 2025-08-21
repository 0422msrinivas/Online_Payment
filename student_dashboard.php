<?php
session_start();
include("connection.php");

// Check if session and query parameter are set
if (!isset($_SESSION['student_id']) || !isset($_GET['id_no'])) {
    header("Location: login.php");
    exit;
}

// Get id_no from query parameter
$id_no = $_GET['id_no'];

// Fetch student data from the database using id_no
$query = "SELECT * FROM student WHERE id_no = '$id_no' LIMIT 1";
$result = mysqli_query($con, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $student_data = mysqli_fetch_assoc($result);
} else {
    echo "Student data not found!";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Dashboard</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #74ebd5, #ACB6E5);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            background: #007bff;
            color: white;
            border-top-left-radius: 20px;
            border-top-right-radius: 20px;
            text-align: center;
            font-size: 1.5rem;
            font-weight: 600;
        }
        .btn-custom {
            background-color: #007bff;
            color: white;
            border-radius: 10px;
        }
        .btn-custom:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Welcome, <?php echo htmlspecialchars($student_data['name']); ?>!
                </div>
                <div class="card-body">
                    <p><strong>ID:</strong> <?php echo htmlspecialchars($student_data['id_no']); ?></p>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($student_data['email']); ?></p>
                    <p><strong>Contact:</strong> <?php echo htmlspecialchars($student_data['contact']); ?></p>
                    <div class="text-center">
                        <a href="logout.php" class="btn btn-custom mt-3">Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
