<?php
include("C:/xapp/htdocs/OEMS/includes/dbconnection.php");
session_start();

// ✅ Prevent browser from caching
header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// ✅ Session check
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'student') {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Dashboard - Online Exam</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="css/style.css">
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
        .footer-credit {
        position: fixed;
        bottom: 0;
        width: 100%;
        background: rgba(0, 0, 0, 0.6);
        color: #ffffffcc;
        text-align: center;
        border-radius: 10px 10px 0 0;
        padding: 20px 0; /* Increased height (2x) */
        font-size: 18px;  /* Increased font size (2x) */
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        letter-spacing: 0.5px;
        z-index: 999;
        backdrop-filter: blur(6px);
        box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.3);
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <?php include("../Common/navbar.php"); ?>

    <header class="bg-light text-center py-5">
        <div class="container">
            <h2>Welcome to Student Dashboard</h2>
            <p class="lead">Access exams, view results, and manage your profile.</p>
        </div>
    </header>

    <div class="container mt-4">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card border-primary">
                    <div class="card-body d-flex flex-column align-items-center">
                        <h5 class="card-title">Start Exam</h5>
                        <p class="card-text">Begin your assigned exams now.</p>
                        <form action="available_exam.php" method="post">
                            <input type="submit" name="available_exam" value="Take Exam" class="btn btn-primary">
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-success">
                    <div class="card-body d-flex flex-column align-items-center">
                        <h5 class="card-title">Results</h5>
                        <p class="card-text">View past results and performance.</p>
                        <a href="available_results.php" class="btn btn-success">View Results</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-info">
                    <div class="card-body d-flex flex-column align-items-center">
                        <h5 class="card-title">Profile</h5>
                        <p class="card-text">Update your information.</p>
                        <a href="../Common/view_profile.php" class="btn btn-info">Edit Profile</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include("../Common/footer.php"); ?>
</body>
</html>
