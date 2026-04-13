<?php
include("C:/xapp/htdocs/OEMS/includes/dbconnection.php");
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: C:/xapp/htdocs/OEMS/MI/index.php");
    exit();
}

// Toggle signup status
if (isset($_POST['toggle_signup'])) {
    $status = $_POST['toggle_signup']; // 1 or 0
    $sql = "UPDATE system_settings SET signup_active = ? WHERE id = 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $status);
    $stmt->execute();
}

// Fetch current status
$result = $conn->query("SELECT signup_active FROM system_settings WHERE id = 1");
$row = $result->fetch_assoc();
$current_status = $row['signup_active'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Admin Dashboard - Online Exam</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <style>
    body {
      background-color: #f8f9fa;
    }
    .card-title {
      font-size: 1.25rem;
    }
    .card:hover {
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        transform: translateY(-5px);
        transition: 0.3s;
    }
  </style>
</head>
<body>

  <!-- Navbar -->
  <?php include("../Common/navbar.php"); ?>

  <!-- Header -->
  <header class="bg-light text-center py-5">
    <div class="container">
      <h2>Welcome to Admin Dashboard</h2>
      <p class="lead">Manage Users, Exams and signup settings.</p>
    </div>
  </header>

  <!-- Main Cards -->
  <div class="container mt-4">
    <div class="row g-4 justify-content-center">
      <!-- Alter User -->
      <div class="col-md-4">
        <div class="card border-primary">
          <div class="card-body text-center">
            <h5 class="card-title">Alter User</h5>
            <p class="card-text">Add, edit, or remove user accounts.</p>
            <a href="alter_user.php" class="btn btn-primary">Go to Alter User</a>
          </div>
        </div>
      </div>

      <!-- Alter Exam -->
      <div class="col-md-4">
        <div class="card border-success">
          <div class="card-body text-center">
            <h5 class="card-title">Alter Exam</h5>
            <p class="card-text">Manage exams and questions.</p>
            <a href="alter_exam.php" class="btn btn-success">Go to Alter Exam</a>
          </div>
        </div>
      </div>

      <!-- Signup Status -->
      <div class="col-md-4">
        <div class="card <?php echo ($current_status == 1) ? 'border-success' : 'border-danger'; ?>">
          <div class="card-body text-center">
            <h5 class="card-title">Signup Status</h5>
            <p class="card-text">
              Signup Link is currently: 
              <strong class="<?php echo ($current_status == 1) ? 'text-success' : 'text-danger'; ?>">
                <?php echo ($current_status == 1) ? 'Active' : 'Inactive'; ?>
              </strong>
            </p>
            <form method="post" class="d-flex gap-2 justify-content-center">
              <button type="submit" name="toggle_signup" value="1" class="btn btn-success">Activate</button>
              <button type="submit" name="toggle_signup" value="0" class="btn btn-danger">Deactivate</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>


</body>
</html>
