<?php
// === Dashboard Analytics Logic ===
include 'db_connect.php';

// 1. Total Fee Collected
$total_collected = $conn->query("SELECT IFNULL(SUM(amount), 0) as collected FROM payments")->fetch_assoc()['collected'];

// 2. Total Pending Dues
$pending_due = $conn->query("
    SELECT IFNULL(SUM(sef.total_fee - IFNULL((
        SELECT SUM(p.amount) FROM payments p WHERE p.ef_id = sef.id
    ), 0)), 0) as pending 
    FROM student_ef_list sef
")->fetch_assoc()['pending'];

// 3. Students with Dues
$students_with_dues = $conn->query("
    SELECT COUNT(*) as count FROM (
        SELECT sef.id, (sef.total_fee - IFNULL((
            SELECT SUM(p.amount) FROM payments p WHERE p.ef_id = sef.id
        ), 0)) as balance 
        FROM student_ef_list sef
    ) as sub 
    WHERE sub.balance > 0
")->fetch_assoc()['count'];

// 4. Reminders Sent (Same as students with dues)
$reminders_sent = $students_with_dues;
?>
<style>
    .small-box {
        border-radius: 0.5rem;
        padding: 1.2rem;
        color: white;
        position: relative;
        overflow: hidden;
        margin-bottom: 20px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    .bg-success { background-color:rgb(116, 220, 140); }
    .bg-danger { background-color:rgb(232, 127, 137); }
    .bg-warning { background-color:rgb(227, 201, 124); color: #000; }
    .bg-info { background-color:rgb(106, 214, 231); }
    .small-box h3 {
        font-size: 24px;
        margin: 0;
    }
    .small-box p {
        margin: 10px 0 0;
        font-size: 16px;
    }
</style>
<div class="row mt-4 mb-4"> <!-- Added mb-4 -->
    <div class="col-md-3">
        <div class="small-box bg-success text-center">
            <h3>₹<?php echo number_format($total_collected); ?></h3>
            <p>Total Fee Collected</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="small-box bg-danger text-center">
            <h3>₹<?php echo number_format($pending_due); ?></h3>
            <p>Total Pending Dues</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="small-box bg-warning text-center">
            <h3><?php echo $students_with_dues; ?></h3>
            <p>Students With Dues</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="small-box bg-info text-center">
            <h3><?php echo $reminders_sent; ?></h3>
            <p>Reminders Sent</p>
        </div>
    </div>
</div>

<!-- Chart.js -->
<!-- Chart.js -->
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="row mt-4">
    <!-- Bar Chart -->
    <div class="col-md-6">
        <div style="height: 400px;">
            <canvas id="feeChart" style="height: 100%; width: 100%;"></canvas>
        </div>
    </div>

    <!-- Pie Chart -->
    <div class="col-md-6">
        <div style="height: 400px;">
            <canvas id="feePieChart" style="height: 100%; width: 100%;"></canvas>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('feeChart').getContext('2d');
const feeChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Fee Collected', 'Pending Dues', 'Students With Dues', 'Reminders Sent'],
        datasets: [{
            label: 'Fee Stats',
            data: [
                <?php echo $total_collected; ?>,
                <?php echo $pending_due; ?>,
                <?php echo $students_with_dues; ?>,
                <?php echo $reminders_sent; ?>
            ],
            backgroundColor: [
                '#28a745',
                '#dc3545',
                '#ffc107',
                '#17a2b8'
            ],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    font: {
                        size: 10
                    }
                }
            },
            x: {
                ticks: {
                    font: {
                        size: 10
                    }
                }
            }
        }
    }
});
</script>
<script>
const pieCtx = document.getElementById('feePieChart').getContext('2d');
const feePieChart = new Chart(pieCtx, {
    type: 'pie',
    data: {
        labels: [
            'Total Fee Collected',
            'Total Pending Dues',
            'Students With Dues',
            'Reminders Sent'
        ],
        datasets: [{
            data: [
                <?php echo $total_collected; ?>,
                <?php echo $pending_due; ?>,
                <?php echo $students_with_dues; ?>,
                <?php echo $reminders_sent; ?>
            ],
            backgroundColor: [
                '#28a745', // Green
                '#dc3545', // Red
                '#ffc107', // Yellow
                '#17a2b8'  // Teal
            ]
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    font: {
                        size: 12
                    }
                }
            }
        }
    }
});
</script>

