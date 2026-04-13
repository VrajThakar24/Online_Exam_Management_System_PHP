<?php
include("../../includes/dbconnection.php");
include("functions.php");

$username = $_SESSION['username'] ?? '';
$role = $_SESSION['role'] ?? 'student';

if (!isset($_SESSION['fullname'])) {
    $_SESSION['fullname'] = getUserFullname($conn, $username);
}

$dashboardTitle = match ($role) {
    'admin' => 'Admin Dashboard',
    'teacher' => 'Teacher Dashboard',
    default => 'Student Dashboard',
};
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid d-grid" style="grid-template-columns: 1fr auto 1fr; align-items: center; width: 100%;">
        <div>
            <span class="navbar-brand">
                Welcome, <?= htmlspecialchars($_SESSION['fullname'] ?: 'User'); ?>
            </span>
        </div>

        <div class="text-center w-100">
            <span class="navbar-text fw-bold d-block text-center">
                <?= $dashboardTitle; ?>
            </span>
        </div>

        <div class="text-end">
            <a class="btn btn-outline-light" href="../logout.php" aria-label="Logout from system">Logout</a>
        </div>
    </div>
</nav>