<?php
require 'vendor/autoload.php';
// session_start();

// DB Connection
$conn = new mysqli("localhost", "root", "", "sfps_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Sorting logic
$sort_by = $_GET['sort'] ?? 'name_asc';
$order_clause = "s.name ASC";
if ($sort_by === 'name_desc') $order_clause = "s.name DESC";
elseif ($sort_by === 'level_asc') $order_clause = "c.level ASC";
elseif ($sort_by === 'level_desc') $order_clause = "c.level DESC";

// Query to get students with dues
$students_query = "
SELECT s.id, s.name, s.email, s.id_no,
       sef.total_fee, COALESCE(SUM(p.amount), 0) AS total_paid,
       c.level
FROM student s
LEFT JOIN student_ef_list sef ON sef.student_id = s.id
LEFT JOIN payments p ON p.ef_id = sef.id
LEFT JOIN courses c ON sef.course_id = c.id
GROUP BY sef.id
HAVING (sef.total_fee - COALESCE(SUM(p.amount), 0)) > 0
ORDER BY $order_clause
";

$students_result = $conn->query($students_query);
if (!$students_result) {
    die("Error fetching students: " . $conn->error);
}

$reminders_sent = $_SESSION['reminders_sent'] ?? [];
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Student Fee Dues</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            border: none;
        }
        .card-header {
            font-size: 20px;
            font-weight: bold;
            background-color: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
        }
        .table th, .table td {
            vertical-align: middle !important;
            text-align: center;
        }
        .btn-sm {
            padding: 4px 10px;
            font-size: 13px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
<?php include 'topbar.php'; ?>
<?php include 'navbar.php'; ?>

<div class="container-fluid mt-4">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">Student Fee Dues</div>
            <div class="card-body">
                <table class="table table-bordered table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>ID No</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>
                                Level
                                <?php
                                    $next_sort = ($sort_by === 'level_asc') ? 'level_desc' : 'level_asc';
                                    $icon = ($sort_by === 'level_asc') ? '▲' : (($sort_by === 'level_desc') ? '▼' : '');
                                ?>
                                <a href="?sort=<?= $next_sort ?>" style="text-decoration: none; margin-left: 5px;">
                                    <?= $icon ?>
                                </a>
                            </th>
                            <th>Total Fee</th>
                            <th>Total Paid</th>
                            <th>Due Amount</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $i = 1;
                        while ($row = $students_result->fetch_assoc()):
                            $due = $row['total_fee'] - $row['total_paid'];
                            $student_id = $row['id'];
                            $reminder_sent = in_array($student_id, $reminders_sent);
                        ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td><strong><?= htmlspecialchars($row['id_no']) ?></strong></td>
                            <td><?= htmlspecialchars($row['name']) ?></td>
                            <td><?= htmlspecialchars($row['email'] ?? 'N/A') ?></td>
                            <td><?= htmlspecialchars($row['level'] ?? 'N/A') ?></td>
                            <td>₹<?= number_format($row['total_fee'], 2) ?></td>
                            <td>₹<?= number_format($row['total_paid'], 2) ?></td>
                            <td><strong>₹<?= number_format($due, 2) ?></strong></td>
                            <td>
                                <?php if ($reminder_sent): ?>
                                    <button class="btn btn-success btn-sm" disabled>
                                        <i class="fas fa-check-circle"></i> Reminder Sent
                                    </button>
                                <?php else: ?>
                                    <form action="send_reminder.php" method="post">
                                        <input type="hidden" name="student_id" value="<?= $student_id ?>">
                                        <button type="submit" class="btn btn-outline-danger btn-sm">
                                            <i class="fas fa-bell"></i> Send Reminder
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
                <?php if ($i === 1): ?>
                    <p class="text-center text-muted">No students with dues.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

</body>
</html>
