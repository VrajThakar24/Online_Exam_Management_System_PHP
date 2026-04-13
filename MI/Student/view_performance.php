<?php
include "../../includes/dbconnection.php"; 
session_start();

// ✅ Check if student is logged in
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'student') {
    header("Location: ../index.php");
    exit();
}

$username = $_SESSION['username'];

// ✅ Fetch all exam results of logged-in student
$sql = "SELECT exam_name, exam_datetime, obtained_marks 
        FROM available_results 
        WHERE username = ? 
        ORDER BY exam_datetime ASC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

$examNames = [];
$marks = [];

while ($row = $result->fetch_assoc()) {
    $examNames[] = $row['exam_name'];
    $marks[] = $row['obtained_marks'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Performance Graph</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="bg-light">

<?php include("../Common/navbar.php"); ?>

<div class="container mt-4">
  <a href="available_results.php" class="btn btn-dark mb-3">&larr; Back to Results</a>
  <h3 class="text-center mb-4">📊 Your Performance Graph</h3>

  <canvas id="performanceChart" height="120"></canvas>
</div>

<script>
  const ctx = document.getElementById('performanceChart').getContext('2d');
  const chart = new Chart(ctx, {
      data: {
          labels: <?php echo json_encode($examNames); ?>,
          datasets: [
              {
                  type: 'bar',
                  label: 'Marks Obtained',
                  data: <?php echo json_encode($marks); ?>,
                  backgroundColor: 'rgba(0, 123, 255, 0.7)', // Blue bars
                  borderColor: 'rgba(0, 123, 255, 1)',
                  borderWidth: 1,
                  barPercentage: 0.4,
                  categoryPercentage: 0.6
              },
              {
                  type: 'line',
                  label: 'Performance Trend',
                  data: <?php echo json_encode($marks); ?>,
                  borderColor: 'orange',
                  backgroundColor: 'rgba(255,165,0,0.2)',
                  fill: false,
                  tension: 0.3,
                  pointBackgroundColor: 'orange',
                  pointRadius: 5
              }
          ]
      },
      options: {
          responsive: true,
          plugins: {
              title: {
                  display: true,
                  text: 'Exam Performance (Bar + Line Graph)'
              }
          },
          scales: {
              y: {
                  beginAtZero: true,
                  min: 0,
                  max: 20,  // 👉 Fix Y-axis scale 0–20
                  ticks: { stepSize: 1 }
              }
          }
      }
  });
</script>

</body>
</html>
