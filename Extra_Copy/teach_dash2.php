<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'teacher') {
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
    <title>Student Dashboard</title>
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

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark position-relative">
    <div class="container-fluid">

        <!-- Left: Welcome -->
        <span class="navbar-brand">
            Welcome, <?php echo $_SESSION['fullname'] ?? 'Teacher'; ?>
        </span>

        <!-- Center: Title -->
        <div class="position-absolute start-50 translate-middle-x">
            <a class="navbar-brand" href="#">Teacher Dashboard</a>
        </div>

        <!-- Right: Logout -->
        <div class="d-flex ms-auto">
            <a class="btn btn-outline-light" href="logout.php">Logout</a>
        </div>

        </div>
    </nav>


    <header class="bg-light text-center py-5 fade-in" id="welcomeSection">
    <div class="container">
        <h2>Welcome to Teacher Dashboard</h2>
        <p class="lead">Manage exams, view student performance, and update your profile.</p>
    </div>
    </header>


    <div class="container mt-4 fade-in" id="cardsSection"">
        <div class="row g-4">
        <div class="col-md-4">
            <div class="card border-primary">
            <div class="card-body">
                <h5 class="card-title">Create Exam</h5>
                <p class="card-text">Prepare and assign new exams to students.</p>
                <a href="#" class="btn btn-primary">Create</a>
            </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-success">
            <div class="card-body">
                <h5 class="card-title">View Student Exams</h5>
                <p class="card-text">Review students's past performance and answers.</p>
                <a href="#" class="btn btn-success">View Exams</a>
            </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-info">
            <div class="card-body">
                <h5 class="card-title">Profile</h5>
                <p class="card-text">Update your teacher profile information.</p>
                <a href="#" class="btn btn-info">Edit Profile</a>
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
        }, 150); // Welcome section fade-in

        setTimeout(() => {
            cards.classList.add("visible");
        }, 400); // Cards fade-in after welcome
    });
    </script>

    </body>
    </html>