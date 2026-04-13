<?php
session_start();
include("C:/xapp/htdocs/OEMS/includes/dbconnection.php");
include("C:/xapp/htdocs/OEMS/Privacy/decryption.php");

// ✅ Session check (only allow logged in student)
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'student') {
    header("Location: index.php");
    exit();
}

$username = $_SESSION['username'];

// --- Simple SQL query ---
$sql = "SELECT u.username, u.password, u.role, d.fullname, d.email, d.mobile_number 
        FROM users u, users_details d 
        WHERE u.username = d.username AND u.username = '$username'";

$result = mysqli_query($conn, $sql);
$userData = mysqli_fetch_assoc($result);
if (!$userData) {
    die("⚠ No user details found.");
}
$userData['password'] = decrypt($userData['password']);
echo($userData['password']);

mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>User Profile</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      background: url("https://picsum.photos/1600/900?blur=3") no-repeat center center fixed;
      background-size: cover;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .profile-card {
      background: rgba(255, 255, 255, 0.8);
      padding: 30px;
      border-radius: 20px;
      width: 600px;
      text-align: center;
      box-shadow: 0px 8px 20px rgba(0,0,0,0.2);
      backdrop-filter: blur(6px);
      animation: fadeIn 1s ease-in-out;
    }
    h2 {
      font-size: 24px;
      color: #222;
      border-bottom: 2px solid #2575fc;
      display: inline-block;
      padding-bottom: 5px;
      margin-bottom: 20px;
    }
    .profile-item strong {
      color: #2575fc;
    }
    .profile-item {
      background: rgba(255,255,255,0.6);
      border-radius: 10px;
      padding: 10px;
      transition: 0.3s;
    }
    .profile-item:hover {
      background: rgba(255,255,255,0.9);
      transform: scale(1.02);
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
    .input-group-text {
      cursor: pointer;
    }
  </style>
</head>
<body>
  <div class="profile-card">
    <h2>👤 User Profile</h2>
    <div class="row g-3 text-start">
      <div class="col-md-6 profile-item"><strong>Username:</strong> <?= $userData['username'] ?></div>
      <div class="col-md-6 profile-item"><strong>Full Name:</strong> <?= $userData['fullname'] ?></div>
      
      <!-- Password field with toggle -->
      <div class="col-md-6 profile-item">
        <strong>Password:</strong>
        <div class="input-group mt-2">
          <input type="password" id="password" class="form-control form-control-sm" 
                 value="<?= htmlspecialchars($userData['password']) ?>" readonly>
          <span class="input-group-text" onclick="togglePassword(this)" id="toggleBtn">👁️</span>
        </div>
      </div>

      <div class="col-md-6 profile-item"><strong>Email:</strong> <?= $userData['email'] ?></div>
      <div class="col-md-6 profile-item"><strong>Role:</strong> <?= $userData['role'] ?></div>
      <div class="col-md-6 profile-item"><strong>Mobile:</strong> <?= $userData['mobile_number'] ?></div>
    </div>
  </div>

  <script>
    function togglePassword(el) {
        const input = document.getElementById("password");
        if (input.type === "password") {
            input.type = "text";
            el.textContent = "👁️‍🗨️";
        } else {
            input.type = "password";
            el.textContent = "👁️";
        }
    }
  </script>
</body>
</html>
