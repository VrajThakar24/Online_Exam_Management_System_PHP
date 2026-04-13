<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'student') {
    header("Location: index.php");
    exit();
}

require __DIR__ . '/../../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
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

// Exam Meta (example, tum apna DB ya session se la sakte ho)
$examDate = date("m/d/Y h:i:s A");
$examId   = rand(30,99); // tumhare table ka exam id use karna
$subject  = "Windows App Development Using CSharp";

// ✅ Create PDF
$pdf = new TCPDF();
$pdf->AddPage();
$pdf->SetFont('helvetica','',11);

// Title
$pdf->SetFont('helvetica','B',16);
$pdf->Cell(0,10,"Examination Result",0,1,'C');
$pdf->Ln(5);

$pdf->SetFont('helvetica','',11);
$pdf->Write(0,"Exam Date: $examDate\n");
$pdf->Write(0,"Exam ID: $examId\n");
$pdf->Write(0,"Subject: $subject\n");
$pdf->Write(0,"Student Name: $userName\n");
$pdf->Write(0,"Attempted Right: $correct\n");
$pdf->Write(0,"Attempted Wrong: $wrong\n");
$pdf->Ln(10);

// ✅ Create Table
$html = '<style>
table { border-collapse: collapse; width: 100%; font-size:11px; }
th, td { border:1px solid #333; padding:6px; }
th { background-color:#2575fc; color:white; }
tr:nth-child(even) { background:#f2f2f2; }
</style>';

$html .= '<table>
<tr>
    <th>No</th>
    <th>Question</th>
    <th>Attempted Answer</th>
    <th>Correct Answer</th>
</tr>';

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

// Clear exam session
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Exam Result - Online Exam System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background:#f3f4f6; font-family:Segoe UI, sans-serif; }
        .result-box { margin:80px auto; max-width:600px; background:white; padding:40px; border-radius:12px; box-shadow:0 0 20px #bbb; }
        .result-box h2 { color:#2575fc; font-weight:700; }
    </style>
</head>
<body>
<div class="result-box text-center">
    <h2>Exam Summary</h2>
    <p><b>Total MCQs:</b> <?= $total ?></p>
    <p><b>Attempted:</b> <?= $attempted ?></p>
    <p><b>Correct:</b> <?= $correct ?></p>
    <p><b>Wrong:</b> <?= $wrong ?></p>
    <p style="color:green; font-weight:bold;"><?= $mailMsg ?></p>
    <a href="student_dash.php" class="btn btn-primary">Go to Dashboard</a>
</div>
</body>
</html>
3