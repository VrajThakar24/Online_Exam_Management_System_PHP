<?php
include "../../includes/dbconnection.php"; // DB connection
session_start();
// ✅ Session check
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'student') {
    header("Location: ../index.php");
    exit();
}
$username = $_SESSION['username'];
$sql = "SELECT * FROM available_exams";
$result = mysqli_query($conn, $sql);       
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Available Exams</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    body {
        background-color: #f8f9fa;
    }
    .card-title {
        font-size: 1.25rem;
    }
    .clock-container {
      text-align: center;
      padding: 20px 0 10px;
      font-size: 1.5rem;
      font-weight: bold;
    }
    .exam-container {
      background: white;
      padding: 30px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      width: 90%;
      margin: auto;
    }
  </style>
</head>
<body>

  <!-- Navbar -->
  <?php include("../Common/navbar.php"); ?>

  <div class="container mt-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
      <a href="student_dash.php" class="btn btn-dark">&larr; Back to Dashboard</a>
      <h4 class="m-0">Available Exam</h4>
  </div>
  </div>
  <!-- Live Clock -->
  <div class="clock-container">
    System Time: <span id="systemClock"></span>
  </div>

  <!-- Exam Table -->
  <div class="exam-container">
    <h4 class="text-center mb-4">Available Exams</h4>
    <table class="table table-bordered text-center">
      <thead class="thead-dark">
        <tr>
          <th>Exam Name</th>
          <th>Date</th>
          <th>Time</th>
          <th>Duration</th>
          <th>Marks</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($result->num_rows > 0): ?>
          <?php while($row = $result->fetch_assoc()): ?>
            <?php
                $examName = htmlspecialchars($row['exam_name']);
                $datetime = new DateTime($row['exam_date']);
                $date = $datetime->format('Y-m-d');
                $time = $datetime->format('h:i A'); // ✅ 12-hour format with AM/PM
                $duration = $row['exam_duration'];
                $marks = $row['marks'];
            ?>
            <tr>
              <td><?= $examName ?></td>
              <td><?= $date ?></td>
              <td><?= $time ?></td>
              <td><?= $duration ?></td>
              <td><?= $marks ?></td>
              <td>
                <button class="btn btn-success btn-sm"
                        onclick="attemptExam('<?= addslashes($examName) ?>', '<?= $row['exam_date'] ?>')">
                  Attempt
                </button>
              </td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr><td colspan="6">No exams available</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  


  <script>
  // Live Clock
  function updateClock() {
    const now = new Date();
    document.getElementById("systemClock").textContent = now.toLocaleString();
  }

  setInterval(updateClock, 1000);
  updateClock();

  // Attempt Exam
  function attemptExam(name, examDatetimeStr) {

    const examTime = new Date(examDatetimeStr.replace(" ", "T")); 
    const now = new Date();

    if (now >= examTime) {
      window.location.href = `start_exam.php?exam_name=${encodeURIComponent(name)}`;
    } else {
      const readableDate = examTime.toLocaleDateString();
      const readableTime = examTime.toLocaleTimeString();

      alert(`Still the exam has not started. It will start on ${readableDate} at ${readableTime}.`);
    }
  }
</script>


</body>
</html>
<?php $conn->close(); ?>