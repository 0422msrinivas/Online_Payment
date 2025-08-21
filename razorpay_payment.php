<?php
session_start();

// Include Razorpay SDK
require 'vendor/autoload.php';
use Razorpay\Api\Api;

// Razorpay API Keys
$api_key = 'rzp_live_wDefGMCh4teI5E'; // Replace with your Razorpay API Key
$api_secret = 'gIdUfJIECMbwr1TYHdhgFbzo'; // Replace with your Razorpay API Secret

$api = new Api($api_key, $api_secret);

// Check if student_id is set in session
if (isset($_SESSION['id_no'])) {
    $student_id = $_SESSION['id_no'];

    // Database connection
    $conn = new mysqli("localhost", "root", "", "sfps_db");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch student details (name, email, contact)
    $student_details_query = "SELECT s.name, s.email, s.contact 
                              FROM student s 
                              WHERE s.id_no = '$student_id'";

    $student_details_result = $conn->query($student_details_query);
    $student_name = '';
    $student_email = '';
    $student_contact = '';

    if ($student_details_result && $student_details_result->num_rows > 0) {
        $student_details = $student_details_result->fetch_assoc();
        $student_name = $student_details['name'];
        $student_email = $student_details['email'];
        $student_contact = $student_details['contact'];
    }

    // Fetch total fee from the database
    $fee_query = "SELECT sef.total_fee
                  FROM student_ef_list sef
                  JOIN student s ON s.id = sef.student_id
                  WHERE s.id_no = '$student_id'";

    $fee_result = $conn->query($fee_query);
    $total_fee = 0;  // Default value

    if ($fee_result && $fee_result->num_rows > 0) {
        $fee = $fee_result->fetch_assoc();
        $total_fee = $fee['total_fee'];
    }

    // Fetch total paid amount from the payments table
    $payment_query = "SELECT SUM(p.amount) AS total_paid
                      FROM payments p
                      JOIN student_ef_list sef ON sef.id = p.ef_id
                      JOIN student s ON s.id = sef.student_id
                      WHERE s.id_no = '$student_id'";

    $payment_result = $conn->query($payment_query);
    $paid_amount = 0;  // Default value

    if ($payment_result && $payment_result->num_rows > 0) {
        $payment = $payment_result->fetch_assoc();
        $paid_amount = $payment['total_paid'];
    }

    // Calculate balance fee
    $balance_fee = $total_fee - $paid_amount;

    // Fetch admission type
    $admission_query = "SELECT s.admission_type
                        FROM student s
                        WHERE s.id_no = '$student_id'";

    $admission_result = $conn->query($admission_query);
    $admission_type = '';  // Default value

    if ($admission_result && $admission_result->num_rows > 0) {
        $admission = $admission_result->fetch_assoc();
        $admission_type = $admission['admission_type'];
    }
// Calculate installments for management students
$amount_to_pay = $balance_fee; // Default for non-management students
if ($admission_type === 'Management') {
    $first_installment = ceil($total_fee * 0.6);
    $second_installment = ceil($total_fee * 0.4);

    // Debug: Check values of installments and balance_fee
    error_log("First Installment: ₹$first_installment, Second Installment: ₹$second_installment, Balance Fee: ₹$balance_fee");

    // Check if the balance fee matches first installment or second installment
    if ($balance_fee == $total_fee) {
        $amount_to_pay = $first_installment; // Pay first installment
    } elseif ($balance_fee == $second_installment) {
        $amount_to_pay = $second_installment; // Pay second installment
    }
    }
} else {
    echo "Student ID is not set in session.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pay with Razorpay</title>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

    body {
        font-family: 'Poppins', sans-serif;
        margin: 0;
        padding: 0;
        background: linear-gradient(135deg, #e3f2fd, #bbdefb);
        animation: gradientShift 10s infinite alternate;
    }

    @keyframes gradientShift {
        0% {
            background: linear-gradient(135deg, #e3f2fd, #bbdefb);
        }
        100% {
            background: linear-gradient(135deg, #bbdefb, #e3f2fd);
        }
    }

    .container {
        max-width: 800px;
        margin: 60px auto;
        padding: 30px;
        background: rgba(255, 255, 255, 0.95);
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease-in-out;
    }

    .container:hover {
        transform: scale(1.01);
    }

    h1 {
        text-align: center;
        color: #1a237e;
        margin-bottom: 30px;
        font-size: 2rem;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th, td {
        padding: 14px 20px;
        border: none;
        text-align: left;
        font-size: 1rem;
    }

    th {
        background-color: #e8eaf6;
        color: #1a237e;
        border-radius: 8px 8px 0 0;
    }

    td {
        background-color: #f5f5f5;
        color: #424242;
        border-radius: 0 0 8px 8px;
    }

    button {
        width: 100%;
        padding: 14px;
        margin-top: 30px;
        font-size: 1.1rem;
        background: linear-gradient(135deg, #2196f3, #21cbf3);
        color: #fff;
        border: none;
        border-radius: 12px;
        cursor: pointer;
        box-shadow: 0 10px 20px rgba(33, 203, 243, 0.3);
        transition: all 0.3s ease;
    }

    button:hover {
        background: linear-gradient(135deg, #21cbf3, #2196f3);
        box-shadow: 0 12px 24px rgba(33, 203, 243, 0.5);
        transform: translateY(-2px);
    }
</style>
</head>
<body>

<div class="container">
    <h1>Fee Payment</h1>

    <table>
        <tr>
            <th>Student Name</th>
            <td><?php echo $student_name; ?></td>
        </tr>
        <tr>
            <th>Email</th>
            <td><?php echo $student_email; ?></td>
        </tr>
        <tr>
            <th>Contact</th>
            <td><?php echo $student_contact; ?></td>
        </tr>
        <tr>
            <th>Admission Type</th>
            <td><?php echo $admission_type; ?></td>
        </tr>
        <tr>
            <th>Total Fee</th>
            <td>₹<?php echo number_format($total_fee, 2); ?></td>
        </tr>
        <tr>
            <th>Paid Amount</th>
            <td>₹<?php echo number_format($paid_amount, 2); ?></td>
        </tr>
        <tr>
            <th>Balance Fee</th>
            <td>₹<?php echo number_format($balance_fee, 2); ?></td>
        </tr>
        <tr>
            <th>Amount to Pay</th>
            <td>₹<?php echo number_format($amount_to_pay, 2); ?></td>
        </tr>
    </table>

    <button type="button" id="rzp-button">Pay Now</button>
</div>

<script>
    document.getElementById('rzp-button').onclick = function (e) {
        e.preventDefault();

        const amountInPaise = <?php echo $amount_to_pay; ?> * 100;

        const options = {
            key: "<?php echo $api_key; ?>",
            amount: amountInPaise,
            name: "Student Fee Payment",
            description: "Pay balance fee",
            handler: function (response) {
                const paymentId = response.razorpay_payment_id;
                const url = `payment_success.php?payment_id=${paymentId}&amount=<?php echo $amount_to_pay; ?>`;
                window.location.href = url;
            },
            prefill: {
                name: "<?php echo $student_name; ?>",
                email: "<?php echo $student_email; ?>",
                contact: "<?php echo $student_contact; ?>"
            },
            theme: {
                color: "#F37254"
            }
        };

        const rzp1 = new Razorpay(options);
        rzp1.open();
    };
</script>

</body>
</html>
