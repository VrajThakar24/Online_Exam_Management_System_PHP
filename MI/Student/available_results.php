<?php
include "../../includes/dbconnection.php"; // DB connection
session_start();
// ✅ Session check
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'student') {
    header("Location: ../index.php");
    exit();
}

$username = $_SESSION['username'];
$sql = "SELECT exam_name, exam_datetime, total_marks, obtained_marks 
        FROM available_results 
        WHERE username = '$username'";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Available Exam Results</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
        background-color: #f8f9fa;
    }
    .card-title {
        font-size: 1.25rem;
    }
  </style>
</head>
<body class="bg-light">
  <!-- Navbar -->
  <?php include("../Common/navbar.php"); ?>
  
  <div class="container mt-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
      <a href="student_dash.php" class="btn btn-dark">&larr; Back to Dashboard</a>
      <h4 class="m-0">Available Exam Results</h4>
  </div>
  </div>
  <div class="container my-5">
    <!-- <h2 class="text-center mb-4">Available Exam Results</h2> -->

    <div class="table-responsive">
      <table class="table table-bordered table-striped shadow">
        <thead class="table-dark text-center">
          <tr>
            <th>Exam Name</th>
            <th>Date</th>
            <th>Time</th>
            <th>Marks</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody class="text-center">
          <?php
          if (mysqli_num_rows($result) > 0) {
              while ($row = mysqli_fetch_assoc($result)) {
                  $exam_date = date("Y-m-d", strtotime($row['exam_datetime']));
                  $exam_time = date("h:i A", strtotime($row['exam_datetime']));
                  ?>
                  <tr>
                    <td><?php echo htmlspecialchars($row['exam_name']); ?></td>
                    <td><?php echo $exam_date; ?></td>
                    <td><?php echo $exam_time; ?></td>
                    <td><?php echo $row['obtained_marks'] . " / " . $row['total_marks']; ?></td>
                    <td>
                      <a class="btn btn-success btn-sm" 
                         href="view-result.php?subject=<?php echo urlencode($row['exam_name']); ?>&marks=<?php echo $row['obtained_marks']; ?>&total=<?php echo $row['total_marks']; ?>&date=<?php echo $exam_date; ?>&time=<?php echo $exam_time; ?>">
                         View Result
                      </a>
                    </td>
                  </tr>
                  <?php
              }
          } else {
              echo "<tr><td colspan='5'>No results available.</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>

  <div class="text-center mt-4">
    <a href="view_performance.php" class="btn btn-info">📊 View Performance Graph</a>
  </div>e 
  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
