<?php
session_start();
include('../includes/dbconnection.php');

$message = "";
$email_message = "";

// ✅ Get username from session (set in forgot_password.php)
if (!isset($_SESSION['username'])) {
    header("Location: forgot_password.php");
    exit();
}

$username = $_SESSION['username'];

// ✅ Fetch user's email from users_details table
$sql = "SELECT email FROM users_details WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $email = $row['email'];
    $email_message = "OTP sent to your registered email address <b>$email</b>";
} else {
    $email_message = "Unable to fetch your email address. Please try again.";
}

// ✅ Show temporary message from previous step
if (isset($_SESSION['flash_message'])) {
    $message = $_SESSION['flash_message'];
    unset($_SESSION['flash_message']);
}

// ✅ Verify OTP submission
if (isset($_POST['otp'])) {
    $otp = trim($_POST['otp']);

    if ($otp == $_SESSION['otp']) {
        $_SESSION['flash_message'] = "OTP verified successfully!";
        header("Location: reset_password.php");
        exit;
    } else {
        $message = "Invalid OTP. Please try again.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verify OTP - Online Exam System</title>
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

        /* 🔹 Blue glow hover effect */
        .login-box:hover {
            transform: scale(1.03);
            box-shadow: 0 12px 40px rgba(0, 123, 255, 0.4);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        h2 {
            margin-bottom: 25px;
            font-weight: 600;
            text-align: center;
            color: #4da3ff;
        }

        .form-control {
            margin-bottom: 15px;
            background-color: rgba(0, 0, 0, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #fff;
            transition: all 0.3s ease;
        }

        .form-control::placeholder {
            color: #ffffffb3;
        }

        .form-control:focus {
            background-color: rgba(0, 0, 0, 0.8);
            color: #fff;
            border-color: #4da3ff;
            box-shadow: none;
        }

        .btn-primary {
            width: 100%;
            background-color: #007bff;
            border: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .info-message {
            background-color: rgba(0, 123, 255, 0.1);
            border-left: 3px solid #4da3ff;
            color: #b3d9ff;
            padding: 10px 15px;
            border-radius: 8px;
            font-size: 14px;
            margin-bottom: 20px;
            animation: fadeIn 0.6s ease;
        }

        .error-message, .success-message {
            text-align: center;
            font-size: 14px;
            margin-bottom: 10px;
            animation: fadeIn 0.4s ease;
        }

        .error-message { color: #ffb3b3; }
        .success-message { color: #b3ffb3; }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-5px); }
            to { opacity: 1; transform: translateY(0); }
        }

        a {
            color: #4da3ff;
            text-decoration: none;
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
        font-size: 20px;  /* Increased font size (2x) */
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        letter-spacing: 0.5px;
        z-index: 999;
        backdrop-filter: blur(6px);
        box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.3);
        }

        a:hover {
            text-decoration: underline;
        }

        label { font-weight: 600; }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>Verify OTP</h2>

        <!-- ✅ Permanent Info Message -->
        <div class="info-message">
            <?= $email_message; ?>
        </div>

        <!-- ✅ Temporary Success/Error Message -->
        <?php if($message != ""): ?>
            <div id="messageBox" class="<?php echo ($message == 'Invalid OTP. Please try again.') ? 'error-message' : 'success-message'; ?>">
                <?= htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Enter OTP</label>
                <input type="text" name="otp" class="form-control" placeholder="Enter the OTP" required>
            </div>

            <button type="submit" class="btn btn-primary">Verify OTP</button>

            <div class="text-center mt-3">
                <a href="forgot_password.php">Resend OTP</a>
            </div>
        </form>
    </div>

    <footer class="footer-credit">
    Developed with by <strong>Pankaj Yadav</strong> & <strong>Vraj Thakar</strong>
    </footer>

    <script>
        // Hide temporary messages after 3–5 seconds
        setTimeout(() => {
            const box = document.getElementById("messageBox");
            if (box) box.style.display = "none";
        }, 4000);
    </script>
</body>
</html>
