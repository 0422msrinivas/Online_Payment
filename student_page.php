<?php
session_start();

// Check if the student_id is set in the session
if (isset($_SESSION['id_no'])) {
    $student_id = $_SESSION['id_no'];  // Get the student_id from session
} else {
    echo "User not logged in.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Fee Details</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;
    }

    body {
        background: linear-gradient(135deg, #89f7fe, #66a6ff);
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        animation: gradientBG 8s ease infinite alternate;
    }

    @keyframes gradientBG {
        0% { background-position: 0% 50%; }
        100% { background-position: 100% 50%; }
    }

    .container {
        max-width: 1000px;
        width: 95%;
        background: #ffffff;
        padding: 40px;
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        animation: fadeIn 1s ease-in-out;
    }

    .header {
        text-align: center;
        margin-bottom: 30px;
    }

    .header h2 {
        font-size: 2.5rem;
        color: #2c3e50;
        background: linear-gradient(to right, #6a11cb 0%, #2575fc 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        animation: slideDown 0.8s ease-out;
    }

    .header p {
        font-size: 1.1rem;
        color: #555;
        margin-top: 10px;
    }

    p {
        background: #f1f9ff;
        padding: 15px 20px;
        border-left: 5px solid #4facfe;
        border-radius: 10px;
        margin: 10px 0;
        font-size: 1rem;
        color: #2c3e50;
        animation: fadeSlide 0.6s ease-in-out;
    }

    h3 {
        margin-top: 30px;
        color: #333;
        text-align: center;
        font-size: 1.6rem;
        animation: slideUp 0.8s ease-in-out;
    }

    table {
        width: 100%;
        margin-top: 20px;
        border-collapse: collapse;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        animation: zoomIn 0.8s ease-in-out;
    }

    table th, table td {
        padding: 14px;
        text-align: center;
        font-size: 0.95rem;
    }

    table th {
        background-color: #2575fc;
        color: white;
        text-transform: uppercase;
        font-weight: 600;
    }

    table tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .actions {
        text-align: center;
        margin-top: 40px;
    }

    button {
        background: linear-gradient(to right, #43e97b 0%, #38f9d7 100%);
        padding: 14px 30px;
        font-size: 1rem;
        border: none;
        border-radius: 30px;
        cursor: pointer;
        color: white;
        font-weight: bold;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        transition: all 0.4s ease;
        animation: pulse 2s infinite;
    }

    button:hover {
        transform: scale(1.05);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.25);
    }

    /* Animations */
    @keyframes fadeIn {
        from {opacity: 0; transform: translateY(20px);}
        to {opacity: 1; transform: translateY(0);}
    }

    @keyframes fadeSlide {
        from {opacity: 0; transform: translateX(-20px);}
        to {opacity: 1; transform: translateX(0);}
    }

    @keyframes slideUp {
        from {opacity: 0; transform: translateY(30px);}
        to {opacity: 1; transform: translateY(0);}
    }

    @keyframes slideDown {
        from {opacity: 0; transform: translateY(-30px);}
        to {opacity: 1; transform: translateY(0);}
    }

    @keyframes zoomIn {
        from {opacity: 0; transform: scale(0.9);}
        to {opacity: 1; transform: scale(1);}
    }

    @keyframes pulse {
        0% { box-shadow: 0 0 0 0 rgba(58, 183, 149, 0.4); }
        70% { box-shadow: 0 0 0 10px rgba(58, 183, 149, 0); }
        100% { box-shadow: 0 0 0 0 rgba(58, 183, 149, 0); }
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .container {
            padding: 25px;
        }

        .header h2 {
            font-size: 2rem;
        }

        table th, table td {
            font-size: 0.85rem;
        }

        button {
            width: 100%;
            font-size: 0.95rem;
        }
    }
</style>
<body style="background-color:rgb(62, 80, 81);">
    <div class="container mt-5">
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white text-center">
                <h3 class="mb-0">Student Fee Details</h3>
            </div>
            <div class="card-body">
                <h5 class="text-muted">User ID: <span class="badge bg-secondary"><?php echo $student_id; ?></span></h5>
                <hr>

                <?php
                $conn = new mysqli("localhost", "root", "", "sfps_db");
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Fetch student info
                $student_query = "SELECT * FROM student WHERE id_no = '$student_id'";
                $student_result = $conn->query($student_query);

                if ($student_result && $student_result->num_rows > 0) {
                    $student = $student_result->fetch_assoc();
                    echo "<p><strong>Name:</strong> {$student['name']}</p>";
                    echo "<p><strong>Contact:</strong> {$student['contact']}</p>";
                    echo "<p><strong>Email:</strong> {$student['email']}</p>";
                    echo "<p><strong>Address:</strong> {$student['address']}</p>";
                    echo "<p><strong>Admission Type:</strong> {$student['admission_type']}</p>";
                } else {
                    echo "<div class='alert alert-warning'>Student not found.</div>";
                }

                // Fee details
                $fee_query = "SELECT sef.total_fee, c.course 
                              FROM student_ef_list sef
                              JOIN student s ON sef.student_id = s.id
                              JOIN courses c ON sef.course_id = c.id
                              WHERE s.id = (SELECT id FROM student WHERE id_no = '$student_id')";
                $fee_result = $conn->query($fee_query);
                $total_fee = 0;

                if ($fee_result && $fee_result->num_rows > 0) {
                    while ($fee = $fee_result->fetch_assoc()) {
                        echo "<p><strong>Course:</strong> {$fee['course']}</p>";
                        $total_fee = $fee['total_fee'];
                        echo "<p><strong>Total Fee:</strong> ₹{$fee['total_fee']}</p>";
                    }
                } else {
                    echo "<div class='alert alert-warning'>Fee details not found.</div>";
                }

                // Paid amount
                $payment_query = "SELECT SUM(p.amount) AS total_paid 
                                  FROM payments p
                                  JOIN student_ef_list sef ON sef.id = p.ef_id
                                  JOIN student s ON s.id = sef.student_id
                                  WHERE s.id_no = '$student_id'";
                $payment_result = $conn->query($payment_query);
                $total_paid = 0;

                if ($payment_result && $payment_result->num_rows > 0) {
                    $payment = $payment_result->fetch_assoc();
                    $total_paid = $payment['total_paid'];
                }

                $balance_fee = $total_fee - $total_paid;

                echo "<p><strong>Total Paid:</strong> ₹{$total_paid}</p>";
                echo "<p><strong>Balance Fee:</strong> ₹{$balance_fee}</p>";

                // Payment history
                $payment_history_query = "SELECT p.date_created, p.amount, p.remarks  
                                          FROM student s 
                                          JOIN student_ef_list sef ON s.id = sef.student_id 
                                          JOIN payments p ON sef.id = p.ef_id 
                                          WHERE s.id_no = '$student_id'";

                $payment_history_result = $conn->query($payment_history_query);

                if ($payment_history_result && $payment_history_result->num_rows > 0) {
                    echo "<h5 class='mt-4'>Payment History</h5>";
                    echo "<div class='table-responsive'>";
                    echo "<table class='table table-striped table-bordered'>";
                    echo "<thead class='table-dark'><tr><th>Date</th><th>Amount (₹)</th><th>Remarks</th></tr></thead><tbody>";
                    while ($payment = $payment_history_result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>{$payment['date_created']}</td>";
                        echo "<td>{$payment['amount']}</td>";
                        echo "<td>{$payment['remarks']}</td>";
                        echo "</tr>";
                    }
                    echo "</tbody></table></div>";
                } else {
                    echo "<div class='alert alert-info'>No payment history found.</div>";
                }

                $conn->close();
                ?>

                <div class="text-center mt-4">
                    <a href="razorpay_payment.php?id_no=<?php echo $student_id; ?>" class="btn btn-success btn-lg">Pay Now</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>