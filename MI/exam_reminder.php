<?php
// Include database connection
include('../includes/dbconnection.php');  // Change path if needed

// Load PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';  // PHPMailer autoload

// Fixed College Address (Single Location)
$college_location = "https://maps.app.goo.gl/hQPaBNQm1zgP4F62A";

// Fetch upcoming exams within next 30 minutes
$query = "SELECT * FROM available_exams 
          WHERE exam_date BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 30 MINUTE)";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query Failed: " . mysqli_error($conn));
}

if (mysqli_num_rows($result) > 0) {

    // ✅ Fetch students email & name using JOIN on users + users_details
    $userQuery = "
        SELECT u.username, d.fullname, d.email
        FROM users u
        INNER JOIN users_details d ON u.username = d.username
        WHERE u.role = 'student'
    ";
    $userResult = mysqli_query($conn, $userQuery);

    if (!$userResult) {
        die("User Query Failed: " . mysqli_error($conn));
    }

    // Loop through all upcoming exams
    while ($exam = mysqli_fetch_assoc($result)) {
        $exam_name = $exam['exam_name'];
        $exam_date = date("d M Y h:i A", strtotime($exam['exam_date']));
        $exam_duration = $exam['exam_duration'];
        $exam_marks = $exam['marks'];

        // Send emails to all students
        mysqli_data_seek($userResult, 0); // Reset pointer before looping users

        while ($user = mysqli_fetch_assoc($userResult)) {
            $to = $user['email'];
            $name = $user['fullname'];

            // Send Email using PHPMailer
            $mail = new PHPMailer(true);
            try {
                // SMTP Settings
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'oems.ytsoftwaresolutions@gmail.com';  // Replace with your Gmail
                $mail->Password = 'fjya ueme kupi daow';        // Use App Password if 2FA enabled
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                // Sender & recipient
                $mail->setFrom('oems.ytsoftwaresolutions@gmail.com', 'Online Exam Portal');
                $mail->addAddress($to);

                // Email format
                $mail->isHTML(true);
                $mail->Subject = "Exam Reminder: $exam_name";

                $mail->Body = "
                    <div style='font-family: Arial, sans-serif; padding: 15px; border: 1px solid #ddd; border-radius: 8px; background-color: #f8f9fa;'>
                        <h2 style='color:#2c3e50;'>Hello $name,</h2>
                        <p style='font-size:16px;'>
                            This is a reminder that your <b>$exam_name</b> exam is scheduled on:
                        </p>
                        <p style='font-size:18px; color:#27ae60;'><b>Date & Time:</b> $exam_date</p>
                        <p style='font-size:16px;'><b>Duration:</b> $exam_duration hours</p>
                        <p style='font-size:16px;'><b>Total Marks:</b> $exam_marks</p>
                        <p style='font-size:16px;'><b>Location:</b> $college_location</p>
                        <br>
                        <p style='font-size:14px; color:#555;'>Please be ready on time and make sure to reach the exam center before the start time.</p>
                        <hr>
                        <p style='font-size:12px; color:#888;'>This is an automated message from the Online Exam Portal.</p>
                    </div>
                ";

                $mail->send();
                echo "Reminder sent to: $to <br>";

            } catch (Exception $e) {
                echo "Failed to send email to $to. Error: {$mail->ErrorInfo}<br>";
            }
        }
    }
} else {
    echo "No upcoming exams within the next 30 minutes.";
}

mysqli_close($conn);
?>
