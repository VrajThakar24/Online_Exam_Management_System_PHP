<?php
include "../../includes/dbconnection.php";
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'student') {
    header("Location: ../index.php");
    exit();
}

// Start Exam - load only once
if (!isset($_SESSION['questions'])) {
    $result = $conn->query("SELECT * FROM csharp_test1 ORDER BY RAND() LIMIT 20");
    $questions = [];
    while ($row = $result->fetch_assoc()) {
        $questions[] = $row;
    }
    $_SESSION['questions'] = $questions;
    $_SESSION['index'] = 0;
    $_SESSION['answers'] = array_fill(0, 20, null);
    $_SESSION['start_time'] = time();
}

$index = $_SESSION['index'];
$questions = $_SESSION['questions'];
$total_questions = count($questions);
$remaining_questions = $total_questions - $index;

// Timer check (15 mins = 900 sec)
if (time() - $_SESSION['start_time'] > 900) {
    header("Location: result2.php");
    exit();
}

// Save answer
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['option'])) {
        $_SESSION['answers'][$index] = $_POST['option'];
    }

    if (isset($_POST['next']) && $index < $total_questions - 1) $_SESSION['index']++;
    if (isset($_POST['prev']) && $index > 0) $_SESSION['index']--;
    if (isset($_POST['submit'])) {
        header("Location: result2.php");
        exit();
    }

    header("Location: start_exam.php");
    exit();
}

$question = $questions[$index];
$time_left = 900 - (time() - $_SESSION['start_time']); // seconds
$minutes = floor($time_left / 60);
$seconds = $time_left % 60;
?>


<!DOCTYPE html>
<html>
<head>
    <title>Start Exam</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f3f4f6;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .container {
            width: 70%;
            background: white;
            border-radius: 12px;
            padding: 40px;
            box-shadow: 0 0 25px rgba(0,0,0,0.1);
            position: relative;
        }
        .timer-box {
            position: absolute;
            top: 15px;
            right: 20px;
            font-weight: bold;
            font-size: 18px;
            margin-bottom: 15px;
        }
        .timer-box .badge {
            padding: 10px 15px;
            font-size: 16px;
            border-radius: 8px;
        }
        .status-bar {
            margin-top: 40px;
            margin-bottom: 25px;
            font-weight: bold;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: #333;
            font-size: 16px;
            padding: 12px 10px;
            border-bottom: 1px solid #e5e5e5;
        }
        .option {
            margin: 10px 0;
            font-size: 16px;
        }
        .buttons {
            margin-top: 25px;
            display: flex;
            justify-content: center;
            gap: 20px;
        }
        #loadingSpinner {
            display: none;
            margin-top: 30px;
            text-align: center;
        }
        #loadingSpinner p {
            margin-top: 15px;
            font-size: 17px;
            color: #0d6efd;
        }
    </style>


    <script>
        let totalSeconds = <?= $time_left ?>;
        function startTimer() {
            const timerElem = document.getElementById('timer');
            const countdown = setInterval(() => {
                let min = Math.floor(totalSeconds / 60);
                let sec = totalSeconds % 60;
                timerElem.innerHTML = `<span>Time Left: ${min}m ${sec}s</span>`;
                totalSeconds--;
                if (totalSeconds < 0) {
                    clearInterval(countdown);
                    alert("Time's up! Submitting your test.");
                    window.location.href = 'result2.php';
                }
            }, 1000);
        }

        function showLoading(buttonName) {
            if (buttonName === "submit") {
                document.getElementById("loadingSpinner").style.display = "block";
            }
        }

        window.onload = startTimer;
    </script>
</head>
<body>
<div class="container">
    <!-- ✅ Timer now starts with PHP rendered time -->
    <div class="timer-box" id="timer">
        <span>Time Left: <?= $minutes ?>m <?= $seconds ?>s</span>
    </div>

    <form method="post">
        <div class="status-bar">
            <div>Question <?= $index + 1 ?> of <?= $total_questions ?></div>
            <div>Remaining: <?= $remaining_questions ?></div>
        </div>

        <h4 class="mb-3">Q<?= $index + 1 ?>. <?= $question['Question'] ?></h4>

        <?php
        $options = ['A', 'B', 'C', 'D'];
        foreach ($options as $opt) {
            $value = $question[$opt];
            $checked = ($_SESSION['answers'][$index] == $value) ? "checked" : "";
            echo "<div class='option form-check'>
                    <input class='form-check-input' type='radio' name='option' value='$value' $checked id='$opt'>
                    <label class='form-check-label' for='$opt'>$value</label>
                  </div>";
        }
        ?>

        <div class="buttons">
            <?php if ($index > 0): ?>
                <button type="submit" name="prev" class="btn btn-primary">Previous</button>
            <?php endif; ?>

            <?php if ($index < $total_questions - 1): ?>
                <button type="submit" name="next" class="btn btn-primary">Next</button>
            <?php else: ?>
                <button type="submit" name="submit" class="btn btn-success" onclick="showLoading('submit')">Submit</button>
            <?php endif; ?>
        </div>

        <!-- Loading Spinner -->
        <div id="loadingSpinner">
            <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
                <span class="visually-hidden">Processing...</span>
            </div>
            <p class="fw-bold">Submitting your answers & sending email... Please wait</p>
        </div>
    </form>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
  