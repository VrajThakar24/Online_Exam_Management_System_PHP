<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'student') {
    header("Location: ../index.php");
    exit();
}

require __DIR__ . '/../../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//use TCPDF;

// ✅ Exam Data from Session
$questions = $_SESSION['questions'];
$answers   = $_SESSION['answers'];

$total = count($questions);
$correct = 0;
$attempted = 0;
$wrong = 0;

foreach ($questions as $i => $q) {
    if ($answers[$i] !== null) {
        $attempted++;
        if ($answers[$i] === $q['Correct_Ans']) $correct++;
        else $wrong++;
    }
}

// ✅ Fetch User details
include "../../includes/dbconnection.php";
$username = $_SESSION['username'];
$res = $conn->query("SELECT fullname,email FROM users_details WHERE username='$username'");
$user = $res->fetch_assoc();
$userName = $user['fullname'];
$userEmail = $user['email'];

// Exam Meta
$examDate = date("Y-m-d | h:i A");
$examId   = rand(30,99);
$subject  = "Windows App Development Using CSharp";

// ✅ Create PDF
$pdf = new TCPDF();
$pdf->AddPage();
$pdf->SetFont('helvetica','B',16);
$pdf->Cell(0,10,"Examination Result",0,1,'C');
$pdf->Ln(5);

$pdf->SetFont('helvetica','',11);
$pdf->Write(0,"Exam Date: $examDate\n");
$pdf->Write(0,"Exam ID: $examId\n");
$pdf->Write(0,"Subject: $subject\n");
$pdf->Write(0,"Student Name: $userName\n");
$pdf->Write(0,"Attempted: $attempted\n");
$pdf->Write(0,"Correct: $correct\n");
$pdf->Write(0,"Wrong: $wrong\n");
$pdf->Ln(10);

$html = '<table border="1" cellpadding="4">
<tr><th>No</th><th>Question</th><th>Attempted Answer</th><th>Correct Answer</th></tr>';
foreach ($questions as $i => $q) {
    $userAns = $answers[$i] ?? "Not Attempted";
    $correctAns = $q['Correct_Ans'];
    $html .= "<tr>
                <td>".($i+1)."</td>
                <td>".$q['Question']."</td>
                <td>$userAns</td>
                <td>$correctAns</td>
             </tr>";
}
$html .= "</table>";
$pdf->writeHTML($html,true,false,true,false,'');

$pdfPath = __DIR__ . "/../../results/result_$username.pdf";
$pdf->Output($pdfPath,'F');

// ✅ Email PDF
$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = "oems.ytsoftwaresolutions@gmail.com"; 
    $mail->Password = "fjya ueme kupi daow";
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;
    $mail->SMTPDebug  = 0;

    $mail->setFrom("oems.ytsoftwaresolutions@gmail.com","OEMS Exam System");
    $mail->addAddress($userEmail,$userName);

    $mail->isHTML(true);
    $mail->Subject = "Your Detailed Exam Result";
    $mail->Body = "Hello $userName,<br><br>Your exam result is attached in PDF format.<br><br>
    <b>Total Questions:</b> $total<br>
    <b>Attempted:</b> $attempted<br>
    <b>Correct:</b> $correct<br>
    <b>Wrong:</b> $wrong<br><br>
    Regards,<br>OEMS Team";

    $mail->addAttachment($pdfPath);
    $mail->send();
    $mailMsg = "✅ Detailed Result PDF sent successfully to $userEmail";
} catch (Exception $e) {
    $mailMsg = "❌ Email Error: {$mail->ErrorInfo}";
}

// Clear session
//session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam Result</title>
    <style>
        /* 👇 तुम्हारा HTML template का CSS */
        body { margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f5f7fa; }
        .result-container { max-width: 750px; background-color: #fff; margin: 30px auto; padding: 25px 30px; border-radius: 12px; border: 3px solid #1e3a8a; box-shadow: 0px 6px 25px rgba(0, 0, 0, 0.25); }
        .result-container h2 { text-align: center; font-size: 30px; color: #1e3a8a; font-weight: bold; margin-bottom: 5px; text-transform: uppercase; }
        .result-container p { text-align: center; color: #555; font-size: 14px; margin-bottom: 20px; font-style: italic; }
        .divider { height: 3px; background: linear-gradient(90deg, #1e3a8a, #3b82f6); margin-bottom: 20px; border-radius: 5px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table th, table td { padding: 14px; text-align: center; border: 1px solid #bbb; font-size: 16px; }
        table th { background-color: #1e3a8a; color: #fff; font-weight: bold; letter-spacing: 0.5px; }
        table tr:nth-child(even) { background-color: #f9fafb; }
        .score-box { text-align: center; padding: 18px; margin-top: 15px; background: linear-gradient(135deg, #dcfce7, #bbf7d0); color: #15803d; font-size: 20px; font-weight: bold; border: 2px solid #16a34a; border-radius: 10px; }
        .buttons { display: flex; justify-content: center; gap: 20px; margin-top: 25px; }
        .btn { padding: 12px 30px; font-size: 16px; border-radius: 8px; text-decoration: none; cursor: pointer; transition: all 0.3s ease; border: none; font-weight: bold; }
        .btn-back { background-color: #1e3a8a; color: #fff; }
        .btn-print { background-color: #16a34a; color: #fff; }
        .btn-back:hover { background-color: #3b82f6; }
        .btn-print:hover { background-color: #22c55e; }
        @media print { body { background-color: white; } .buttons { display: none; } .result-container { box-shadow: none; border: 2px solid #000; } }
    </style>
</head>
<body>
    <div class="result-container">
        <h2>Exam Result</h2>
        <p>Official Performance Report</p>
        <div class="divider"></div>
        <table>
            <tr><th>Exam Name</th><td><?= $subject ?></td></tr>
            <tr><th>Date & Time</th><td><?= $examDate ?></td></tr>
            <tr><th>Total Questions</th><td><?= $total ?></td></tr>
            <tr><th>Right Attempts</th><td><?= $correct ?></td></tr>
            <tr><th>Wrong Attempts</th><td><?= $wrong ?></td></tr>
        </table>
        <div class="score-box">
            🎯 Your Score: <b><?= $correct ?> / <?= $total ?></b>
        </div>
        <div class="buttons">
            <a href="student_dash.php" class="btn btn-back">⬅ Back to Dashboard</a>
            <button class="btn btn-print" onclick="window.print()">🖨 Print Result</button>
        </div>
        <p style="text-align:center; margin-top:15px; font-weight:bold;"><?= $mailMsg ?></p>
    </div>
</body>
</html>
