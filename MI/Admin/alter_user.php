<?php
require_once "../../includes/dbconnection.php";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"]; // already encrypted
    $role = $_POST["role"];

    $sql = "INSERT INTO users (username,password, role) VALUES ('$username', '$password', '$role')";
    mysqli_query($conn, $sql);
    header("Location: alter_user.php");
    exit();
}

// Fetch existing users
$users = mysqli_query($conn, "SELECT * FROM users ORDER BY role");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Alter User - Admin Panel</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            padding: 20px;
            margin-bottom: 20px;
        }
        table {
            background-color: white;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="admin_dash.php" class="btn btn-dark">&larr; Back to Dashboard</a>
            <h4 class="m-0">Alter User</h4>
        </div>

        <h3>User Management</h3>
        <div class="card shadow-sm">
            <form method="POST">
                <div class="row mb-3">
                    <div class="col">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control" placeholder="Enter username" required>
                    </div>
                    <div class="col">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" placeholder="Enter email" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <label>Password</label>
                        <input type="text" name="password" class="form-control" placeholder="Enter password (already encrypted)" required>
                    </div>
                    <div class="col">
                        <label>Role</label>
                        <select name="role" class="form-control">
                            <option value="Student">Student</option>
                            <option value="Teacher">Teacher</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-success">Add User</button>
            </form>
        </div>

        <h4>Existing Users</h4>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Username</th>
                <th>Password</th>
                <th>Role</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($users)) { ?>
            <tr>
                <td><?= $row['username'] ?></td>
                <td><?php echo $row['password']; ?></td>
                <td><?= $row['role'] ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

    </div>
</body>
</html>
