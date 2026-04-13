<?php
session_start();
if (!isset($_SESSION['role'])) {
    header("Location: index.php");
    exit();
}

$role = $_SESSION['role'];

if ($role == 'admin') {
    header("Location: admin/dashboard.php");
} elseif ($role == 'teacher') {
    header("Location: teacher/dashboard.php");
} elseif ($role == 'student') {
    header("Location: student/dashboard.php");
} else {
    echo "Unknown role.";
}
?>
