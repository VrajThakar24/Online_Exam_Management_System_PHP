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
?>

<!DOCTYPE html>
<html>
<head>
    <title>Start Exam</title>
    <style>
        body {
            margin: 0;
            font-family: Arial;
            background-color: #f3f4f6;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .container {
            width: 60%;
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 0 20px #bbb;
            position: relative;
        }
        .timer-box {
            position: absolute;
            top: 15px;
            right: 20px;
            font-weight: bold;
            color: #e63946;
        }
        .status-bar {
            margin-bottom: 20px;
            font-weight: bold;
            display: flex;
            justify-content: space-between;
            color: #333;
        }
        .option {
            margin: 10px 0;
        }
        .buttons {
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
        }
        .buttons input {
            padding: 10px 25px;
            font-size: 16px;
        }
    </style>
    <script>
        let totalSeconds = <?= $time_left ?>;
        function startTimer() {
            const timerElem = document.getElementById('timer');
            const countdown = setInterval(() => {
                let min = Math.floor(totalSeconds / 60);
                let sec = totalSeconds % 60;
                timerElem.innerText = `Time Left: ${min}m ${sec}s`;

                totalSeconds--;
                if (totalSeconds < 0) {
                    clearInterval(countdown);
                    alert("Time's up! Submitting your test.");
                    window.location.href = 'result2.php';
                }
            }, 1000);
        }
        window.onload = startTimer;
    </script>
</head>
<body>
<div class="container">
    <div class="timer-box" id="timer">Loading...</div>

    <form method="post">
        <div class="status-bar">
            <div>Question <?= $index + 1 ?> of <?= $total_questions ?></div>
            <div>Remaining: <?= $remaining_questions ?></div>
        </div>

        <h3>Q<?= $index + 1 ?>. <?= $question['Question'] ?></h3>

        <?php
        $options = ['A', 'B', 'C', 'D'];
        foreach ($options as $opt) {
            $value = $question[$opt];
            $checked = ($_SESSION['answers'][$index] == $value) ? "checked" : "";
            echo "<div class='option'>
                    <label><input type='radio' name='option' value='$value' $checked> $value</label>
                  </div>";
        }
        ?>

        <div class="buttons">
            <?php if ($index > 0): ?>
                <input type="submit" name="prev" value="Previous">
            <?php else: ?>
                <span></span>
            <?php endif; ?>

            <?php if ($index < $total_questions - 1): ?>
                <input type="submit" name="next" value="Next">
            <?php else: ?>
                <input type="submit" name="submit" value="Submit">
            <?php endif; ?>
        </div>
    </form>
</div>
</body>
</html>
