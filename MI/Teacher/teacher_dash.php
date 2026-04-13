<?php
include("C:/xapp/htdocs/OEMS/includes/dbconnection.php");
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'teacher') {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Teacher Dashboard - Online Exam</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            background-color: #f8f9fa;
            /* background-image: url('../../assets/images/coder9.png'); */
            background-size: cover;
            background-position: center;
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

    <header class="bg-light text-center py-5">
        <div class="container">
        <h2>Welcome to Teacher Dashboard</h2>
        <p class="lead">Create or view exams, view student performance, and update your profile.</p>
        </div>
    </header>

    <div class="container mt-4">
        <div class="row g-4">
        <div class="col-md-4">
            <div class="card border-primary">
            <div class="card-body d-flex flex-column align-items-center">
                <h5 class="card-title">Exam</h5>
                <p class="card-text">Prepare or view exams.</p>
                <form method="post" class="d-flex gap-2 justify-content-center">
                    <a href="create_exam.php" class="btn btn-primary">Create Exam</a>
                    <a href="available_exam.php" class="btn btn-primary">View Exams</a>
                </form>
            </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-success">
            <div class="card-body d-flex flex-column align-items-center">
                <h5 class="card-title">Result</h5>
                <p class="card-text">Review students's past performance.</p>
                <a href="#" class="btn btn-success">View Results</a>
            </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-info">
            <div class="card-body d-flex flex-column align-items-center">
                <h5 class="card-title">Profile</h5>
                <p class="card-text">Update your teacher profile information.</p>
                <a href="../Common/view_profile.php" class="btn btn-info">Edit Profile</a>
            </div>
            </div>
        </div>
        </div>
    </div>
</body>
</html>