<?php
session_start();
include('../includes/dbconnection.php');
include("C:/xapp/htdocs/OEMS/Privacy/encryption.php");

$message = "";

if (isset($_POST['password'])) {
    $username = $_SESSION['username'];
    $newpass = trim($_POST['password']);
    $confpass = trim($_POST['confirm_password']);

    // ✅ Server-side password validation
    $uppercase = preg_match('@[A-Z]@', $newpass);
    $lowercase = preg_match('@[a-z]@', $newpass);
    $number    = preg_match('@[0-9]@', $newpass);
    $specialChars = preg_match('@[^\w]@', $newpass);

    if ($newpass !== $confpass) {
        $message = "Passwords do not match!";
    } elseif (strlen($newpass) < 8 || !$uppercase || !$lowercase || !$number || !$specialChars) {
        $message = "Password must be at least 8 characters long and include uppercase, lowercase, number, and special character.";
    } else {
        $enc_pass = encrypt($newpass);
        $sql = "UPDATE users SET password='$enc_pass' WHERE username='$username'";
        if (mysqli_query($conn, $sql)) {
            unset($_SESSION['otp']);
            echo "<script>alert('Password updated successfully. Please login.'); window.location='index.php';</script>";
            exit;
        } else {
            $message = "Something went wrong. Try again.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password - Online Exam System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
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

        .reset-box {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 40px;
            width: 400px;
            box-shadow: 0 8px 32px rgba(31, 38, 135, 0.37);
            color: #fff;
            transition: all 0.3s ease-in-out;
        }

        .reset-box:hover {
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
            padding-right: 40px;
        }

        .form-control::placeholder {
            color: #ffffffb3;
        }

        .form-control:focus {
            background-color: rgba(0, 0, 0, 0.8);
            border-color: #4da3ff;
            box-shadow: none;
            color: #fff;
        }

        .btn-primary {
            width: 100%;
            background-color: #007bff;
            border: none;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }

        .error-message {
            text-align: center;
            color: #ffb3b3;
            margin-bottom: 10px;
        }

        .password-container {
            position: relative;
        }

        .eye-icon {
            position: absolute;
            top: 60%;
            right: 12px;
            /* transform: translateY(-50%); */
            cursor: pointer;
            display: flex;
            align-items: center;
            color: #ccc;
            padding-right: 4px;
            transition: color 0.2s ease;
        }

        .eye-icon:hover {
            color: #4da3ff;
        }


        a {
            color: #4da3ff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        /* Password strength styles */
        .strength-wrapper {
            text-align: center;
            margin-top: 5px;
            font-weight: bold;
            font-size: 14px;
            height: 20px;
            display: none;
            opacity: 0;
            transition: opacity 0.4s ease;
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

        .strength-weak { color: #dc3545; }
        .strength-medium { color: #fd7e14; }
        .strength-strong { color: #ffc107; }
        .strength-very-strong { color: #28a745; }
    </style>
</head>
<body>
    <div class="reset-box">
        <h2>Reset Password</h2>

        <?php if ($message != ""): ?>
            <div class="error-message" id="messageBox"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>

        <form method="POST" id="resetForm">
            <!-- New Password -->
            <div class="mb-3 password-container">
                <label class="form-label">New Password</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Enter new password" required>
                <span class="bi bi-eye eye-icon" id="togglePassword"></span>
            </div>

            <!-- Confirm Password -->
            <div class="mb-3 password-container">
                <label class="form-label">Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" class="form-control" placeholder="Re-enter password" required>
                <span class="bi bi-eye eye-icon" id="toggleConfirm"></span>
            </div>

            <!-- Password Strength Meter -->
            <div class="strength-wrapper" id="strengthWrapper">
                <div id="passwordStrength"></div>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Reset Password</button>

            <div class="text-center mt-3">
                <a href="index.php">Back to Login</a>
            </div>
        </form>
    </div>

    <footer class="footer-credit">
    Developed with by <strong>Pankaj Yadav</strong> & <strong>Vraj Thakar</strong>
    </footer>

    <script>
        // Eye toggle for both password fields
        const togglePassword = document.getElementById("togglePassword");
        const passwordInput = document.getElementById("password");
        const toggleConfirm = document.getElementById("toggleConfirm");
        const confirmInput = document.getElementById("confirm_password");

        togglePassword.addEventListener("click", () => {
            const type = passwordInput.type === "password" ? "text" : "password";
            passwordInput.type = type;
            togglePassword.classList.toggle("bi-eye-slash");
        });

        toggleConfirm.addEventListener("click", () => {
            const type = confirmInput.type === "password" ? "text" : "password";
            confirmInput.type = type;
            toggleConfirm.classList.toggle("bi-eye-slash");
        });

        // Password strength logic
        const strengthWrapper = document.getElementById("strengthWrapper");
        const strengthDiv = document.getElementById("passwordStrength");

        function checkPasswordStrength(password) {
            let strengthText = "";
            let strengthClass = "";

            let conditions = 0;
            if (password.length >= 8) conditions++;
            if (/[A-Z]/.test(password)) conditions++;
            if (/[a-z]/.test(password)) conditions++;
            if (/[0-9]/.test(password)) conditions++;
            if (/[\W_]/.test(password)) conditions++;

            if (password.length === 0) {
                strengthText = "";
                strengthClass = "";
            } else if (conditions <= 2) {
                strengthText = "Weak password ❌";
                strengthClass = "strength-weak";
            } else if (conditions === 3) {
                strengthText = "Medium password ⚠️";
                strengthClass = "strength-medium";
            } else if (conditions === 4) {
                strengthText = "Strong password ✅";
                strengthClass = "strength-strong";
            } else if (conditions === 5) {
                strengthText = "Very Strong password 🔥";
                strengthClass = "strength-very-strong";
            }

            strengthDiv.textContent = strengthText;
            strengthDiv.className = strengthClass;
        }

        passwordInput.addEventListener("focus", () => {
            strengthWrapper.style.display = "block";
            setTimeout(() => strengthWrapper.style.opacity = "1", 50);
        });

        passwordInput.addEventListener("blur", () => {
            strengthWrapper.style.opacity = "0";
            setTimeout(() => strengthWrapper.style.display = "none", 400);
        });

        passwordInput.addEventListener("input", function() {
            checkPasswordStrength(this.value);
        });

        // Client-side validation
        document.getElementById("resetForm").addEventListener("submit", function(e) {
            const pass = passwordInput.value;
            const confirm = confirmInput.value;

            const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;

            if (!regex.test(pass)) {
                e.preventDefault();
                alert("Password must be at least 8 characters long and include uppercase, lowercase, number, and special character.");
                return;
            }
            if (pass !== confirm) {
                e.preventDefault();
                alert("Passwords do not match!");
                return;
            }
        });

        // Hide messages after a few seconds
        setTimeout(() => {
            const box = document.getElementById("messageBox");
            if (box) {
                box.style.transition = "opacity 0.5s ease";
                box.style.opacity = "0";
                setTimeout(() => box.remove(), 500);
            }
        }, 4000);
    </script>
</body>
</html>
