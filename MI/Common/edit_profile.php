<?php
session_start();
include("C:/xapp/htdocs/OEMS/includes/dbconnection.php");
include("C:/xapp/htdocs/OEMS/Privacy/decryption.php");
include("C:/xapp/htdocs/OEMS/Privacy/encryption.php");

// ✅ Session check
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

$username = $_SESSION['username'];
//$_SESSION['flash_message'] = "";
//$message = $_SESSION['flash_message'];

// --- Handle Update ---
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $newPassword = trim($_POST['password']);
    $newEmail    = trim($_POST['email']);
    $newFullname = trim($_POST['fullname']);
    $newMobile   = trim($_POST['mobile']);

    // --- Validation ---
    $errors = [];

    // Username must be exactly 9 digits (only numbers)
    if($_SESSION['role'] == 'student') {
        if (empty($username) || !preg_match('/^[0-9]{9}$/', $username)) {
            $errors[] = "⚠️ Username must be exactly 9 digits and only contain numbers.";
        }
    }

    // Password (min 6 chars)
    if (strlen($newPassword) < 6) {
        $errors[] = "⚠️ Password must be at least 6 characters.";
    }

    // Email
    if (!filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "⚠️ Invalid email format.";
    }

    // Fullname
    if (empty($newFullname) || strlen($newFullname) < 3) {
        $errors[] = "⚠️ Full name must be at least 3 characters.";
    } elseif (!preg_match("/^[A-Za-z]+(?: [A-Za-z]+)*$/", $newFullname)) {
        $errors[] = "⚠️ Full name should only contain letters and single spaces between words.";
    }

    // Mobile (10 digits)
    if (!preg_match("/^[0-9]{10}$/", $newMobile)) {
        $errors[] = "⚠️ Mobile number must be exactly 10 digits.";
    }
    $newPassword = encrypt($newPassword);
    if (empty($errors)) {
        // ✅ Update in DB using prepared statements
        // Update users (only password)
        $stmt1 = $conn->prepare("UPDATE users SET password=? WHERE username=?");
        $stmt1->bind_param("ss", $newPassword, $username);
        $stmt1->execute();

        // Update users_details
        $stmt2 = $conn->prepare("UPDATE users_details SET fullname=?, email=?, mobile_number=? WHERE username=?");
        $stmt2->bind_param("ssss", $newFullname, $newEmail, $newMobile, $username);
        $stmt2->execute();

        $stmt1->close();
        $stmt2->close();

        //$message = "<div class='alert alert-success text-center'>Profile updated successfully ✅</div>";
        //$message = "Profile updated successfully ✅";
        // ✅ Save success message in session & redirect
        $_SESSION['flash_message'] = "Profile updated successfully ✅";
        header("Location: edit_profile.php");
        exit();
    } else {
        $_SESSION['flash_message'] = "<ul>";
        foreach ($errors as $err) {
            $_SESSION['flash_message'] .= "<li>$err</li>";
        }
        $_SESSION['flash_message'] .= "</ul>";
        header("Location: edit_profile.php");
        exit();
    }
}

// --- Fetch user data again after update ---
$sql = "SELECT u.username, u.password, u.role, d.fullname, d.email, d.mobile_number 
        FROM users u 
        JOIN users_details d ON u.username = d.username 
        WHERE u.username = ?";
$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->bind_param("s", $username);  // one ? → one variable
    $stmt->execute();
    $result = $stmt->get_result();
    $userData = $result->fetch_assoc();
    $stmt->close();
} else {
    die("SQL prepare failed: " . $conn->error);
}
if (!$userData) {
    die("⚠ No user details found.");
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Profile • Online Exam System</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background: url("../../assets/images/coder9.png") no-repeat center center/cover;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      padding: 20px;
      font-family: Arial, sans-serif;
    }

    .profile-card {
      background: rgba(255, 255, 255, 0.08);
      border-radius: 20px;
      box-shadow: 0 8px 40px rgba(0, 0, 0, 0.5);
      backdrop-filter: blur(15px);
      -webkit-backdrop-filter: blur(15px);
      padding: 35px 40px;
      width: 700px;
      max-width: 95%;
      border: 1px solid rgba(255, 255, 255, 0.3);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .profile-card:hover {
      transform: scale(1.02);
      box-shadow: 0 12px 60px rgba(0, 0, 0, 0.6);
    }

    h3 {
      text-align: center;
      font-weight: bold;
      color: #fff;
      margin-bottom: 10px;
      letter-spacing: 1px;
    }

    /* Stylish Line Below Heading */
    .heading-line {
      width: 210px;
      height: 3px;
      background: linear-gradient(90deg, #4f46e5, #7c3aed, #ec4899);
      margin: 0 auto 25px auto;
      border-radius: 50px;
      box-shadow: 0 0 8px #7c3aed;
      animation: glow 1.5s infinite alternate;
    }

    @keyframes glow {
      from { box-shadow: 0 0 8px #7c3aed; }
      to { box-shadow: 0 0 18px #ec4899; }
    }

    .form-label {
      font-weight: 600;
      color: #fff;
      font-size: 15px;
      margin-bottom: 5px;
    }

    .form-control {
      border-radius: 8px;
      box-shadow: none;
      background: rgba(255, 255, 255, 0.15);
      border: 1px solid rgba(255, 255, 255, 0.3);
      color: #fff;
      height: 45px;
      font-size: 15px;
      transition: all 0.3s ease;
      padding-right: 40px;
    }

    .form-control:hover,
    .form-control:focus {
      background: rgba(255, 255, 255, 0.25);
      border-color: #4f46e5;
      box-shadow: 0 0 12px #4f46e5;
      color: #fff;
      transform: scale(1.02);
    }

    .password-container {
      position: relative;
      display: flex;
      align-items: center;
    }

    .eye-icon {
      position: absolute;
      right: 12px;
      top: 50%;
      transform: translateY(-50%);
      cursor: pointer;
      color: #fff;
      font-size: 18px;
    }

    .button-row {
    display: flex;
    justify-content: space-between; /* left & right */
    margin-top: 20px;
    }

    .button-row .btn {
    min-width: 120px; /* optional: makes buttons equal width */
    }

    /* Update Button */
    .btn-update {
      display: block;
      margin: 25px auto 0;
      background: linear-gradient(90deg, #4f46e5, #7c3aed, #ec4899);
      color: #fff;
      font-weight: bold;
      border: none;
      padding: 10px 40px;
      border-radius: 30px;
      box-shadow: 0 0 10px #7c3aed;
      font-size: 16px;
      transition: all 0.3s ease;
    }

    .btn-update:hover {
      transform: scale(1.08);
      box-shadow: 0 0 20px #ec4899;
    }
    /* Back Button */
    .back-btn {
      display: block;
      margin: 25px auto 0;
      font-weight: bold;
      padding: 10px 40px;
      border-radius: 30px;
      box-shadow: 0 0 10px #fff;
      font-size: 16px;
      transition: all 0.3s ease;
      background: rgba(255, 255, 255, 0.15);
      color: #fff;
      border: 1px solid rgba(255, 255, 255, 0.3);
      text-decoration: none;
    }

    .back-btn:hover {
      background: rgba(255, 255, 255, 0.3);
      box-shadow: 0 0 8px #fff;
    }
    .mb-custom {
      margin-bottom: 18px;
    }
    .messagebox {
      border-radius: 8px;
      background: rgba(255, 255, 255, 0.15);
      border: 1px solid rgba(255, 255, 255, 0.3);
      color: #fff;
      font-size: 15px;
      text-align: center;
      align-items: center;
    }
    .messagebox2 {
      /* border-radius: 8px;
      background: rgba(255, 255, 255, 0.15);
      border: 1px solid rgba(255, 255, 255, 0.3); */
      /* color: #fff;
      font-size: 15px;
      text-align: center;
      align-items: center; */
    }
    #passwordStrength {
      text-align: center;
      align-items: center;
      font-weight: bold;
      font-size: 14px;
      height: 20px;
    }
    .strength-weak {
      color: #dc3545;  /* red */
    }
    .strength-medium {
      color: #fd7e14; /* orange */
    }
    .strength-strong {
      color: #ffc107; /* yellow */
    }
    .strength-very-strong {
      color: #28a745; /* green */
    }
  </style>
</head>
<body>
  <div class="profile-card">
    <h3>👤 Edit Profile</h3>
    <div class="heading-line"></div>

    <form method="POST" action="edit_profile.php">
      <div class="row">
        <!-- LEFT SIDE -->
        <div class="col-md-6">
          <!-- Username -->
          <div class="mb-custom">
            <label for="username" class="form-label">Username</label>
            <input type="text" id="username" name="username" class="form-control" value="<?= htmlspecialchars($userData['username']) ?>" required readonly>
          </div>

          <!-- Password -->
          <div class="mb-custom">
            <label for="password" class="form-label">Password</label>
            <div class="password-container">
              <input type="password" id="password" name="password" class="form-control" value="<?= htmlspecialchars(decrypt($userData['password'])) ?>" required>
              <i class="bi bi-eye eye-icon" id="eyeIcon" onclick="togglePassword()"></i>
            </div>
          </div>

          <!-- Email -->
          <div class="mb-custom">
            <label for="email" class="form-label">Email</label>
            <input type="email" id="email" name="email" class="form-control" value="<?= htmlspecialchars($userData['email']) ?>" required>
          </div>
        </div>

        <!-- RIGHT SIDE -->
        <div class="col-md-6">
          <!-- Role -->
          <div class="mb-custom">
            <label for="role" class="form-label">Role</label>
            <input type="text" id="role" name="role" class="form-control" value="<?= htmlspecialchars($userData['role']) ?>" required readonly>
          </div>

          <!-- Full Name -->
          <div class="mb-custom">
            <label for="fullname" class="form-label">Full Name</label>
            <input type="text" id="fullname" name="fullname" class="form-control" value="<?= htmlspecialchars($userData['fullname']) ?>" required>
          </div>

          <!-- Mobile -->
          <div class="mb-custom">
            <label for="mobile" class="form-label">Mobile</label>
            <input type="tel" id="mobile" name="mobile" class="form-control" value="<?= htmlspecialchars($userData['mobile_number']) ?>" required>
          </div>
        </div>
      </div>

      <!-- Flash Message -->
      <?php if (isset($_SESSION['flash_message'])): ?>
        <div class="messagebox" id="messageDiv"><?php echo $_SESSION['flash_message']; ?></div>
        <?php unset($_SESSION['flash_message']); ?>
      <?php endif; ?>

      <!-- Password Strength Indicator -->
      <div class="messagebox2" id="strengthWrapper" style="display: none;">
        <div id="passwordStrength" class="mt-2"></div>
      </div>

      <div class="button-row">
        <a href="view_profile.php" class="back-btn">← View Profile</a>
        <button type="submit" class="btn-update">Update</button>
      </div>


    </form>
  </div>

  <script>
    function togglePassword() {
      const passwordInput = document.getElementById("password");
      const eyeIcon = document.getElementById("eyeIcon");
      if (passwordInput.type === "password") {
        passwordInput.type = "text";
        eyeIcon.classList.remove("bi-eye");
        eyeIcon.classList.add("bi-eye-slash");
      } else {
        passwordInput.type = "password";
        eyeIcon.classList.remove("bi-eye-slash");
        eyeIcon.classList.add("bi-eye");
      }
    }
    setTimeout(() => {
      const msg = document.getElementById("messageDiv");
      if (msg) {
        msg.style.transition = "opacity 0.5s ease";
        msg.style.opacity = "0";
        setTimeout(() => msg.remove(), 500); // remove fully after fade-out
      }
    }, 3000);

    //password strength
    const passwordInput = document.getElementById("password");
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
        strengthText = "Enter password ❌";
        strengthClass = "strength-weak";
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

    // Show strength meter when password field is active
    passwordInput.addEventListener("focus", () => {
      strengthWrapper.style.display = "block";
      checkPasswordStrength(passwordInput.value); // <-- run immediately so no blank space
    });

    passwordInput.addEventListener("blur", () => {
      strengthWrapper.style.display = "none"; // hide on blur
    });

    passwordInput.addEventListener("input", function () {
      checkPasswordStrength(this.value);
    });
  </script>
</body>
</html>