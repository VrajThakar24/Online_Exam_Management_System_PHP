<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Create Exam</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-body">
                <h3 class="card-title text-center mb-4">Create New Exam</h3>

                <?php

                require $_SERVER['DOCUMENT_ROOT'] . '/OEMS/vendor/autoload.php';

                use PhpOffice\PhpSpreadsheet\IOFactory;

                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $exam_name = $_POST['exam_name'];
                    $exam_date = $_POST['exam_date'];
                    $marks = (int)$_POST['marks'];
                    $exam_duration = sprintf('00:%02d:00', (int)$_POST['exam_duration']);
                    $subject_id = $_POST['subject_id'];

                    $targetFile = "uploads/" . basename($_FILES['excel_file']['name']);

                    if (move_uploaded_file($_FILES['excel_file']['tmp_name'], $targetFile)) {
                        try {
                            $spreadsheet = IOFactory::load($targetFile);
                            $sheet = $spreadsheet->getActiveSheet();
                            $rows = $sheet->toArray();

                            $conn = new mysqli("localhost", "root", "", "online_exam_db");
                            if ($conn->connect_error) {
                                die('<div class="alert alert-danger">DB Connection failed: ' . $conn->connect_error . '</div>');
                            }

                            // Insert exam metadata into available_exams table
                            $stmt = $conn->prepare("INSERT INTO available_exams (exam_name, exam_date, marks, exam_duration, subject_id) VALUES (?, ?, ?, ?, ?)");
                            $stmt->bind_param('ssiss', $exam_name, $exam_date, $marks, $exam_duration, $subject_id);
                            $stmt->execute();
                            $stmt->close();

                            // Create exam questions table and insert data
                            $sqlFile = "newexam.sql";
                            $fp = fopen($sqlFile, "w");

                            $createTable = "DROP TABLE IF EXISTS `$exam_name`;\n";
                            $createTable .= "CREATE TABLE `$exam_name` (
                                id INT AUTO_INCREMENT PRIMARY KEY,
                                question TEXT NOT NULL,
                                option_a VARCHAR(255) NOT NULL,
                                option_b VARCHAR(255) NOT NULL,
                                option_c VARCHAR(255) NOT NULL,
                                option_d VARCHAR(255) NOT NULL,
                                correct CHAR(1) NOT NULL
                            );\n\n";

                            fwrite($fp, $createTable);
                            $conn->multi_query($createTable);
                            while ($conn->more_results() && $conn->next_result()) {;}

                            $isHeader = true;
                            foreach ($rows as $row) {
                                if ($isHeader) {
                                    $isHeader = false;
                                    continue;
                                }

                                list($question, $a, $b, $c, $d, $correct) = $row;

                                if (trim($question) == "") continue;

                                $insert = sprintf(
                                    "INSERT INTO `%s` (question, option_a, option_b, option_c, option_d, correct) 
                                     VALUES ('%s','%s','%s','%s','%s','%s');\n",
                                    $exam_name,
                                    $conn->real_escape_string($question),
                                    $conn->real_escape_string($a),
                                    $conn->real_escape_string($b),
                                    $conn->real_escape_string($c),
                                    $conn->real_escape_string($d),
                                    $conn->real_escape_string($correct)
                                );

                                fwrite($fp, $insert);
                                $conn->query($insert);
                            }

                            fclose($fp);

                            echo '<div class="alert alert-success text-center">✅ Exam <strong>' . htmlspecialchars($exam_name) . '</strong> created successfully and saved in available_exams table.</div>';

                        } catch (Exception $e) {
                            echo '<div class="alert alert-danger text-center">Error reading file: ' . $e->getMessage() . '</div>';
                        }
                    } else {
                        echo '<div class="alert alert-danger text-center">❌ File upload failed.</div>';
                    }
                }
                ?>

                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="exam_name" class="form-label">Exam Table Name</label>
                        <input type="text" class="form-control" id="exam_name" name="exam_name" placeholder="e.g., csharp_unit2" required>
                    </div>

                    <div class="mb-3">
                        <label for="exam_date" class="form-label">Exam Date & Time</label>
                        <input type="datetime-local" class="form-control" id="exam_date" name="exam_date" required>
                    </div>

                    <div class="mb-3">
                        <label for="marks" class="form-label">Marks (e.g., 20)</label>
                        <input type="number" class="form-control" id="marks" name="marks" placeholder="e.g., 20" required>
                    </div>

                    <div class="mb-3">
                        <label for="exam_duration" class="form-label">Exam Duration (Minutes)</label>
                        <input type="number" class="form-control" id="exam_duration" name="exam_duration" placeholder="e.g., 15 for 15 minutes" min="1" required>
                    </div>


                    <div class="mb-3">
                        <label for="subject_id" class="form-label">Subject ID</label>
                        <input type="text" class="form-control" id="subject_id" name="subject_id" placeholder="e.g., java" required>
                    </div>

                    <div class="mb-3">
                        <label for="excel_file" class="form-label">Upload Excel File (.xlsx/.xls)</label>
                        <input type="file" class="form-control" id="excel_file" name="excel_file" accept=".xlsx,.xls" required>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="teacher_dash.php" class="btn btn-secondary">Back to Dashboard</a>
                        <button type="submit" class="btn btn-primary">Create Exam</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
