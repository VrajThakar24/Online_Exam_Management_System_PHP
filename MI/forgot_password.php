<?php
session_start();
include('../includes/dbconnection.php');
require '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$message = "";
$success = false;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username'])) {
    $username = trim($_POST['username']);

    $sql = "SELECT email FROM users_details WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $email = $row['email'];
        $otp = rand(100000, 999999);

        $_SESSION['otp'] = $otp;
        $_SESSION['username'] = $username;

        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'oems.ytsoftwaresolutions@gmail.com';
            $mail->Password = 'fjya ueme kupi daow'; // app password
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('oems.ytsoftwaresolutions@gmail.com', 'OEMS Support');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'OEMS Password Reset OTP';
            $mail->Body = "
                <p>Dear <b>$username</b>,</p>
                <p>Your OTP for password reset is:</p>
                <h3>$otp</h3>
                <p>This OTP is valid for 10 minutes.</p>
                <p>Regards,<br><b>OEMS Support Team</b></p>
            ";

            if ($mail->send()) {
                $_SESSION['flash_message'] = "OTP sent successfully!";
                $success = true;
            } else {
                $message = "Something went wrong. Email not sent.";
            }
        } catch (Exception $e) {
            $message = "Something went wrong. Email not sent.";
        }
    } else {
        $message = "Invalid username!";
    }

    if ($success) {
        echo "<script>
            setTimeout(() => { window.location.href = 'verify_otp.php'; }, 1000);
        </script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password - Online Exam System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: url('../assets/images/Coder.png') no-repeat center center fixed;
            background-size: cover;
            height: 100vh;
        }
        .glass-box {
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
        .glass-box:hover {
            transform: scale(1.03);
            box-shadow: 0 12px 40px rgba(0, 123, 255, 0.4);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .form-control {
            background-color: rgba(0, 0, 0, 0.6);
            border: none;
            color: #fff;
        }
        .form-control:focus {
            background-color: rgba(0, 0, 0, 0.7);
            color: #fff;
            border-color: #4da3ff;
            box-shadow: none;
        }
        .form-control::placeholder { color: #ffffffb3; }
        a { color: #4da3ff; text-decoration: none; }
        a:hover { text-decoration: underline; }

        /* Smooth fade animation */
        .fade-element {
            opacity: 0;
            transition: opacity 0.4s ease;
        }
        .fade-element.show {
            opacity: 1;
        }

        /* Spinner area animation */
        #loading-spinner {
            display: none;
            opacity: 0;
            transition: opacity 0.4s ease;
        }
        #loading-spinner.show {
            display: block;
            opacity: 1;
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
<body class="d-flex justify-content-center align-items-center">

    <div class="glass-box rounded-4 shadow-lg p-4 position-relative">
        <h2 class="text-center mb-4 fw-semibold">Forgot Password</h2>

        <?php if($message): ?>
            <div class="alert alert-danger text-center py-2 fade-element show" id="errorBox"><?= $message ?></div>
        <?php endif; ?>

        <?php if($success): ?>
            <div class="alert alert-success text-center py-2 fade-element show" id="successBox">OTP sent successfully! Redirecting...</div>
        <?php endif; ?>

        <form method="POST" onsubmit="showSpinner()">
            <div class="mb-3">
                <label class="form-label fw-semibold">Username</label>
                <input type="text" name="username" class="form-control" placeholder="Enter your username" required>
            </div>

            <div class="text-center mb-3" id="loading-spinner">
                <div class="spinner-border text-light" role="status"></div>
                <p class="mt-2 mb-0 small">Sending OTP...</p>
            </div>

            <button type="submit" id="submit-btn" class="btn btn-primary w-100 mb-3">Send OTP</button>
            <div class="text-center">
                <a href="index.php">Back to Login</a>
            </div>
        </form>
    </div>

    <footer class="footer-credit">
    Developed with by <strong>Pankaj Yadav</strong> & <strong>Vraj Thakar</strong>
    </footer>

    <script>
        function showSpinner() {
            const spinner = document.getElementById("loading-spinner");
            const button = document.getElementById("submit-btn");
            spinner.classList.add("show");
            button.disabled = true;
        }

        // Smooth fade-out of alerts
        window.addEventListener("load", () => {
            const msg = document.getElementById("errorBox") || document.getElementById("successBox");
            if (msg) {
                setTimeout(() => {
                    msg.classList.remove("show");
                    setTimeout(() => { msg.style.display = "none"; }, 400);
                }, 3000);
            }
        });
    </script>
</body>
</html>
