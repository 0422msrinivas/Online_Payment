<?php
require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$conn = new mysqli("localhost", "root", "", "sfps_db");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

// Get all students with dues
$query = "
SELECT s.name, s.email, COALESCE(sef.total_fee, 0) AS total_fee,
       COALESCE(SUM(p.amount), 0) AS total_paid
FROM student s
LEFT JOIN student_ef_list sef ON sef.student_id = s.id
LEFT JOIN payments p ON p.ef_id = sef.id
GROUP BY s.id
";

$result = $conn->query($query);
$sent = 0;

while ($row = $result->fetch_assoc()) {
    $due = $row['total_fee'] - $row['total_paid'];
    if ($due <= 0) continue;

    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = '0422msrinivasa@gmail.com';
        $mail->Password = 'bell ptxc uebm qgdx';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;

        $mail->setFrom('0422msrinivasa@gmail.com', 'Fees Admin');
        $mail->addAddress($row['email'], $row['name']);
        $mail->isHTML(true);
        $mail->Subject = 'Fee Payment Reminder';
        $mail->Body = "
            <h3>Dear {$row['name']},</h3>
            <p>This is a reminder that you have an outstanding fee of <strong>₹" . number_format($due, 2) . "</strong>.</p>
            <p>Please complete your payment at the earliest convenience.</p>
            <p>Regards,<br>College Admin</p>
        ";
        $mail->send();
        $sent++;
    } catch (Exception $e) {
        echo "Failed to send to {$row['email']}: {$mail->ErrorInfo}<br>";
    }
}

echo "<h3>$sent reminder(s) sent successfully.</h3>";
echo '<a href="admin_dues_list.php">← Back to Dues List</a>';
?>
