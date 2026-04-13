<?php
session_start();

// Prevent browser caching
header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Session check
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

// Get full name
$fullname = isset($_SESSION['fullname']) ? $_SESSION['fullname'] : 'Student';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <style>
        body {
            background-color: #f8f9fa;
        }

        /* Navbar layout */
        .navbar-custom {
            background-color: #212529;
            color: #fff;
        }

        .navbar-custom .navbar-brand,
        .navbar-custom .nav-link,
        .navbar-custom .fullname,
        .navbar-custom .dashboard-title {
            color: #fff;
        }

        .dashboard-title {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            font-weight: 600;
        }

        .fullname {
            font-weight: 500;
        }

        .fade-in {
            opacity: 0;
            transform: translateY(20px);
            transition: all 1s ease-in-out;
        }

        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .card-body {
            min-height: 170px;
        }
    </style>
</head>
<body>


<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <!-- Left: Welcome message -->
        <span class="navbar-brand">
            Welcome, <?php echo isset($_SESSION['fullname']) ? $_SESSION['fullname'] : 'Student'; ?>
        </span>

        <!-- Center: Student Dashboard (Perfectly Centered) -->
        <div class="position-absolute start-50 translate-middle-x">
            <a class="navbar-brand" href="#">Admin Dashboard</a>
        </div>


        <!-- Right: Logout Button -->
        <div class="d-flex">
            <a class="btn btn-outline-light" href="logout.php">Logout</a>
        </div>
    </div>
</nav>


<!-- Header with fade effect -->
<header class="bg-light text-center py-5 fade-in" id="welcomeSection">
    <div class="container">
        <h2>Welcome to Admin Dashboard</h2>
        <p class="lead">Manage Users and Exams from the panel below.</p>
    </div>
</header>

<!-- Main content with cards -->
<div class="container mt-4 fade-in" id="cardsSection">
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card border-primary">
                <div class="card-body">
                    <h5 class="card-title">Alter User</h5>
                    <p class="card-text">Add, edit, or remove user accounts.</p>
                    <a href="alter_user.php" class="btn btn-success">Go to alter user</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-success">
                <div class="card-body">
                    <h5 class="card-title">Alter Exam</h5>
                    <p class="card-text">Manage exams and questions.</p>
                    <a href="alter_exam.php" class="btn btn-success">Go to alter exam</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Fade-in effect on page load
    window.addEventListener("DOMContentLoaded", () => {
        const welcome = document.getElementById("welcomeSection");
        const cards = document.getElementById("cardsSection");

        setTimeout(() => {
            welcome.classList.add("visible");
        }, 100); // Welcome section fade-in

        setTimeout(() => {
            cards.classList.add("visible");
        }, 400); // Cards fade-in after welcome
    });
</script>

</body>
</html>
