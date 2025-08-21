<?php
require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Connect to DB
$conn = new mysqli("localhost", "root", "", "sfps_db");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$student_id = $_POST['student_id'] ?? '';
if (!$student_id) die("Student ID missing.");

// Fetch student info
$query = "
SELECT s.id, s.name, s.email, COALESCE(sef.total_fee,0) AS total_fee,
       COALESCE(SUM(p.amount),0) AS total_paid,
       sef.id AS ef_id, sef.reminder_sent
FROM student s
LEFT JOIN student_ef_list sef ON sef.student_id = s.id
LEFT JOIN payments p ON p.ef_id = sef.id
WHERE s.id = '$student_id'
GROUP BY s.id
";

$result = $conn->query($query);
if ($result->num_rows === 0) die("Student not found.");
$row = $result->fetch_assoc();

$name = $row['name'];
$email = $row['email'];
$due = $row['total_fee'] - $row['total_paid'];
$ef_id = $row['ef_id'];

if ($due <= 0) {
    echo "<script>alert('No dues for $name.'); window.history.back();</script>";
    exit;
}

if ($row['reminder_sent']) {
    echo "<script>alert('Reminder already sent to $name.'); window.history.back();</script>";
    exit;
}

// Send Email
$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = '0422msrinivasa@gmail.com'; // Your Gmail
    $mail->Password = 'bell ptxc uebm qgdx';      // App Password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port = 465;

    $mail->setFrom('0422msrinivasa@gmail.com', 'Fees Admin');
    $mail->addAddress($email, $name);

    $mail->isHTML(true);
    $mail->Subject = 'Fee Payment Reminder';
    $mail->Body = "
        <h3>Dear $name,</h3>
        <p>This is a reminder that you have an outstanding fee amount of <strong>₹" . number_format($due, 2) . "</strong>.</p>
        <p>Please log in to the portal and make your payment at the earliest.</p>
        <p>Thank you,<br>College Administration</p>
    ";

    $mail->send();

    // Update reminder status
    $conn->query("UPDATE student_ef_list SET reminder_sent = 1 WHERE id = '$ef_id'");
    echo "<script>alert('Reminder sent to $name.'); window.history.back();</script>";
} catch (Exception $e) {
    echo "Mailer Error: {$mail->ErrorInfo}";
}
