<!-- index page of the Online Exam Management System -->

<!-- php code -->
<?php
session_start();
require_once "includes/dbconnection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get inputs safely
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $sql = "select* from users where username = '$username' &&
    password= '$password' ";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];  // Store role in session

        // Redirect based on role
        if ($user['role'] === 'admin') {
            header("Location: admin_dash.php");
        }
        elseif ($user['role'] === 'teacher') {
            header("Location: teacher_dash.php");
        } 
        elseif ($user['role'] === 'student') {
            header("Location: student_dash.php");
        } 
        else{
            echo "Unknown role!";
        }
        exit();
    }
    else {
        echo "<script>alert('Invalid username or password');</script>";
    }
}
    // if (mysqli_affected_rows($conn)> 0) {
    //     $_SESSION['username'] = $username;
    //     header("Location:student_dash.php");
    //     exit();
        
    //     //echo("Redirecting to dashboard...");
    //     //$_SESSION['username'] = $username;

    //     // Store session info if needed
        
    //     //$_SESSION['role'] = $username['role'];

    //     // Redirect based on role
    //     /*if ($username['role'] == 'teacher') {
    //         header("Location: teacher_dash.php");
    //         exit();
    //     } elseif ($username['role'] == 'student') {
    //         header("Location: student_dash.php");
    //         exit();
    //     } elseif ($username['role'] == 'admin') {
    //         header("Location: admin_dash.php"); // optional if you have admin dashboard
    //         exit();
    //     } else {
    //         echo "Unknown role!";
    //     }*/
    // } 

else{
    echo '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Login - Online Exam System</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            body {
                background: linear-gradient(to right, #6a11cb, #2575fc);
                height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                font-family: sans-serif;
            }
            .login-box {
                background-color: white;
                padding: 40px 30px;
                border-radius: 12px;
                box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
                width: 100%;
                max-width: 400px;
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
                color: #555;
            }
        </style>
    </head>
    <body>
        <div class="login-box">
            <h2 class="mb-4">Online Exam System</h2>

            

            <form method="POST" action="">
                <input type="text" name="username" class="form-control mb-3" placeholder="Username" required />

                <div class="password-wrapper mb-3">
                    <input type="password" name="password" id="password" class="form-control" placeholder="Password" required />
                    <span class="toggle-password" onclick="togglePassword(this)">
                        👁️
                    </span>
                </div>

                <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>
        </div>

        <script>
            function togglePassword(el) {
                const input = document.getElementById("password");
                if (input.type === "password") {
                    input.type = "text";
                    el.textContent = "👁️‍🗨️"; // hide icon
                } else {
                    input.type = "password";
                    el.textContent = "👁️"; // show icon
                }
            }
        </script>
    </body>
    </html>';
}
?>