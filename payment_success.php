<?php
session_start();

// Include Razorpay SDK and PHPMailer
require 'vendor/autoload.php';
use Razorpay\Api\Api;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require_once('vendor/tecnickcom/tcpdf/tcpdf.php');

// Razorpay API Keys
$api_key = 'rzp_live_wDefGMCh4teI5E'; // Replace with your Razorpay API Key
$api_secret = 'gIdUfJIECMbwr1TYHdhgFbzo'; // Replace with your Razorpay API Secret

$api = new Api($api_key, $api_secret);

// Directory to save receipts
$receipts_dir = __DIR__ . '/receipts/';
if (!is_dir($receipts_dir)) {
    mkdir($receipts_dir, 0777, true);
}

// Database connection
$conn = new mysqli("localhost", "root", "", "sfps_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get student ID from session
$student_id_no = $_SESSION['id_no'];

// Query to get student and fee info
$verify_query = "SELECT 
                    sef.id AS sef_id, 
                    sef.total_fee, 
                    sef.course_id,
                    s.id AS student_id, 
                    s.name, 
                    s.email, 
                    s.contact,
                    c.COURSE AS course_name,
                    c.level AS course_level
                 FROM student_ef_list sef
                 JOIN student s ON sef.student_id = s.id
                 JOIN courses c ON sef.course_id = c.id
                 WHERE s.id_no = '$student_id_no'";
$verify_result = $conn->query($verify_query);

if ($verify_result && $verify_result->num_rows > 0) {
    $student_data = $verify_result->fetch_assoc();
    $sef_id = $student_data['sef_id'];
    $total_fee = $student_data['total_fee'];
    $student_name = $student_data['name'];
    $student_email = $student_data['email'];
    $student_contact = $student_data['contact'];
    $course_name = $student_data['course_name'];
    $course_level = $student_data['course_level'];
    $student_db_id = $student_data['student_id'];

    // ✅ Get Proctor Email
    $proctor_email = null;
    $proctor_query = "SELECT p.email AS proctor_email
                      FROM student_proctor sp
                      JOIN proctor p ON sp.proctor_id = p.id
                      WHERE sp.student_id = $student_db_id";
    $proctor_result = $conn->query($proctor_query);
    if ($proctor_result && $proctor_result->num_rows > 0) {
        $proctor_email = $proctor_result->fetch_assoc()['proctor_email'];
    }

    // Calculate balance fee
    $paid_query = "SELECT SUM(amount) AS total_paid FROM payments WHERE ef_id = $sef_id";
    $paid_result = $conn->query($paid_query);
    $total_paid = $paid_result->fetch_assoc()['total_paid'] ?? 0;
    $balance_fee = $total_fee - $total_paid;

    // Get payment amount
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['amount'])) {
        $amount_paid = (float)$_POST['amount'];
    } elseif (isset($_GET['amount'])) {
        $amount_paid = (float)$_GET['amount'];
    } else {
        echo "Payment amount not specified.";
        exit;
    }

    // Validate amount
    if ($amount_paid <= 0 || $amount_paid > $balance_fee) {
        echo "Invalid payment amount.";
        exit;
    }

    // Create Razorpay Order
    $orderData = [
        'receipt' => 'rcptid_' . uniqid(),
        'amount' => $amount_paid * 100,
        'currency' => 'INR',
        'payment_capture' => 1
    ];
    $order = $api->order->create($orderData);

    // Insert payment record
    $remarks = "Installment Payment";
    $stmt_insert = $conn->prepare("INSERT INTO payments (ef_id, amount, remarks, date_created) VALUES (?, ?, ?, NOW())");
    $stmt_insert->bind_param("ids", $sef_id, $amount_paid, $remarks);
    $stmt_insert->execute();

    if ($stmt_insert->affected_rows > 0) {
        echo "Payment recorded successfully.";

        echo "<script>
            setTimeout(function() {
                window.location.href = 'student_page.php';
            }, 5000);
        </script>";

        // Create receipt HTML
        $receipt_html = '
        <html><head><style>
        body { font-family: Arial, sans-serif; }
        h2 { text-align: center; font-weight: bold; }
        .info-table, .summary-table {
            width: 100%; border-collapse: collapse; margin-top: 20px;
        }
        .info-table td { padding: 5px 10px; vertical-align: top; }
        .summary-table th, .summary-table td {
            border: 1px solid #000; padding: 8px; text-align: left;
        }
        .summary-table th { background-color: #f2f2f2; }
        .bold { font-weight: bold; }
        </style></head><body>
        <h2>Payment Receipt</h2>
        <table class="info-table">
            <tr><td><strong>EF. No:</strong> ' . $sef_id . '</td>
                <td><strong>Payment Date:</strong> ' . date('F d, Y') . '</td></tr>
            <tr><td><strong>Student:</strong> ' . htmlspecialchars($student_name) . '</td>
                <td><strong>Paid Amount:</strong> ' . number_format($amount_paid, 2) . '</td></tr>
            <tr><td><strong>Course/Level:</strong> <span class="bold">' . htmlspecialchars($course_name . ' - ' . $course_level) . '</span></td>
                <td><strong>Remarks:</strong> ' . htmlspecialchars($remarks) . '</td></tr>
        </table><br><br>
        <strong>Payment Summary</strong>
        <table class="summary-table">
            <tr><th colspan="2">Fee Details</th><th colspan="2">Payment Details</th></tr>
            <tr><td><strong>Fee Type</strong></td><td><strong>Amount</strong></td><td><strong>Date</strong></td><td><strong>Amount</strong></td></tr>
            <tr><td>cet</td><td>' . number_format($total_fee, 2) . '</td><td>' . date('Y-m-d') . '</td><td>' . number_format($amount_paid, 2) . '</td></tr>
            <tr><td><strong>Total</strong></td><td><strong>' . number_format($total_fee, 2) . '</strong></td>
                <td><strong>Total</strong></td><td><strong>' . number_format($amount_paid, 2) . '</strong></td></tr>
            <tr><td colspan="2"><strong>Total Payable Fee</strong></td><td colspan="2">' . number_format($total_fee, 2) . '</td></tr>
            <tr><td colspan="2"><strong>Total Paid</strong></td><td colspan="2">' . number_format($total_paid + $amount_paid, 2) . '</td></tr>
            <tr><td colspan="2"><strong>Balance</strong></td><td colspan="2">' . number_format($balance_fee - $amount_paid, 2) . '</td></tr>
        </table></body></html>';

        // Generate PDF
        // Generate password-protected PDF
$password = strtolower(substr($student_name, 0, 4)) . substr($student_id_no, -4);
$pdf = new TCPDF();
$pdf->SetProtection(['print'], $password, null, 0, null);  // Add password protection
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 12);
$pdf->writeHTML($receipt_html);
$pdf_file = $receipts_dir . 'pay_' . $order['id'] . '_receipt.pdf';
$pdf->Output($pdf_file, 'F');

        // Send Email to Student and Proctor
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = '0422msrinivasa@gmail.com';
            $mail->Password = 'bell ptxc uebm qgdx'; // Use App Password if 2FA is enabled
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('0422msrinivasa@gmail.com', 'Student Fee Payment');
            $mail->addAddress($student_email, $student_name);
            if ($proctor_email) {
                $mail->addAddress($proctor_email, 'Proctor');
            }
            $mail->addAttachment($pdf_file);
            $mail->isHTML(true);
            $mail->Subject = 'Payment Receipt';
            $mail->Body = $receipt_html;
            $mail->send();
            echo 'Receipt sent to student and proctor email.';
        } catch (Exception $e) {
            echo "Email sending failed: {$mail->ErrorInfo}";
        }
    } else {
        echo "Error recording payment.";
    }
} else {
    echo "Student verification failed.";
}
?>
