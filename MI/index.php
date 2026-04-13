<?php
session_start();
require_once "C:/xapp/htdocs/OEMS/includes/dbconnection.php";
require_once "C:/xapp/htdocs/OEMS/Privacy/encryption.php";

$error = "false"; // Variable to store login error
// ✅ Get error from session if redirected after failed login
if (isset($_SESSION['login_error'])) {
    $error = $_SESSION['login_error'];
    unset($_SESSION['login_error']); // clear after showing once
}

if(isset($_SESSION['flash_message'])) {
    $error = $_SESSION['flash_message'];
    unset($_SESSION['flash_message']);
}

// Get signup status
$result = $conn->query("SELECT signup_active FROM system_settings WHERE id = 1");
$row = $result->fetch_assoc();
$signup_active = $row['signup_active'];

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['username']) && !empty($_POST['f_password'])) {
    $username = mysqli_real_escape_string($conn, trim($_POST['username']));
    $plainpassword = trim($_POST['f_password']);
    $encryptedPassword = encrypt($plainpassword);  

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $encryptedPassword);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        // Redirect based on role
        if ($user['role'] === 'admin') {
            header("Location: Admin/admin_dash.php");
        } 
        elseif ($user['role'] === 'teacher') {
            header("Location: Teacher/teacher_dash.php");
        } 
        elseif ($user['role'] === 'student') {
            header("Location: Student/student_dash.php");
        } 
        else {
            
            $_SESSION['login_error'] = "Unknown role!";
            header("Location: index.php");
        }
        exit();
    } 
    else {
    // ❌ Store error in session and redirect (PRG pattern)
    $_SESSION['login_error'] = "Invalid username or password";
    header("Location: index.php");
    exit();
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Online Exam System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            background: url('../assets/images/Coder.png') no-repeat center center fixed;
            background-size: cover;
            height: 100vh;
            font-family: Arial, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-box {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 40px;
            width: 400px;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
            color: #fff; 
            transition: all 0.3s ease-in-out;
        }
        /* --- Hover animation --- */
        .login-box:hover {
            transform: scale(1.03);
            box-shadow: 0 12px 40px rgba(0, 123, 255, 0.4);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .login-container h2 {
            margin-bottom: 25px;
            font-weight: 600;
            white-space: nowrap;
        }
        .form-control {
            margin-bottom: 15px;
            background-color: rgba(0, 0, 0, 0.6);
            border: none;
            color: #fff;
        }
        .form-control::placeholder {
            color: #ffffffb3;
        }
        .btn-primary {
            width: 100%;
        }
        .password-wrapper {
            position: relative;
        }
        .toggle-password {
            position: absolute;
            top: 50%;
            right: 12px;
            transform: translateY(-50%);
            cursor: pointer;
            font-size: 18px;
            color: #ccc;
        }
        .form-control:focus {
            background-color: rgba(0, 0, 0, 0.7);
            color: #fff;
        }
        .error-message {
            color: #ffb3b3;
            font-size: 14px;
            text-align: center;
            margin-bottom: 10px;
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
    <div class="login-box">
        <h2 class="mb-4">Online Exam System</h2>
        <form method="POST" action="index.php">
            <input type="text" name="username" class="form-control mb-3" placeholder="Username" required autofocus />

            <!-- password -->
            <div class="password-wrapper mb-2">
                <input type="password" name="f_password" id="password" class="form-control" placeholder="Password" required />
                <span class="toggle-password" onclick="togglePassword(this)">👁️</span>
            </div>

            <!-- Error message here -->
            <?php if ($error!="false"): ?>
                <div class="error-message" id="errorBox"><?php echo $error; ?></div>
            <?php endif; ?>

            <!-- Login button -->
            <button type="submit" class="btn btn-primary">Login</button>

            <!-- Forget password link -->
            <div class="text-center mt-3">
                <a href="forgot_password.php" class="text-decoration-none">Forgot Password?</a>
            </div>

            <?php if ($signup_active == 1): ?>
            <div class="mt-3 text-center">
                <a href="sign_up.php" class="btn btn-outline-success w-100">New User? Register Here</a>
            </div>
            <?php endif; ?>
        </form>
    </div>
    <footer class="footer-credit">
    Developed with by <strong>Pankaj Yadav</strong> & <strong>Vraj Thakar</strong>
    </footer>
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

        // Hide error message after 3 seconds
        setTimeout(() => {
            const errorBox = document.getElementById("errorBox");
            if (errorBox) {
                errorBox.style.display = "none";
            }
        }, 2000);
        /*if (window.performance && performance.navigation.type === 2) {
            location.reload(true);
        }*/
    </script>
</body>
</html>
