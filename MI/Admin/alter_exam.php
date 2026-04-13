<?php


?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Alter Exam - Admin Panel</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <a class="navbar-brand" href="admin_dash.php">← Back to Dashboard</a>
      <span class="navbar-text text-white">Alter Exam</span>
    </div>
  </nav>

  <!-- Header -->
  <header class="bg-light text-center py-4">
    <div class="container">
      <h2>Exam Management</h2>
      <p class="lead">Add, edit, or remove exams below.</p>
    </div>
  </header>

  <!-- Main Content -->
  <div class="container mt-4">
    <div class="row g-4 justify-content-center">
      <div class="col-md-8">
        <div class="card border-primary">
          <div class="card-body">
            <h5 class="card-title mb-3">Create New Exam</h5>
            <form>
              <div class="mb-3">
                <label class="form-label">Exam Title</label>
                <input type="text" class="form-control" placeholder="Enter exam title" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Subject</label>
                <input type="text" class="form-control" placeholder="Enter subject" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Exam Date</label>
                <input type="date" class="form-control" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Duration (in minutes)</label>
                <input type="number" class="form-control" placeholder="e.g. 60" required>
              </div>
              <button type="submit" class="btn btn-success">Create Exam</button>
            </form>
          </div>
        </div>
      </div>

      <!-- Existing Exam Table -->
      <div class="col-md-10">
        <div class="card border-secondary mt-4">
          <div class="card-body">
            <h5 class="card-title mb-3">Existing Exams</h5>
            <table class="table table-bordered table-striped">
              <thead class="table-dark">
                <tr>
                  <th>ID</th>
                  <th>Title</th>
                  <th>Subject</th>
                  <th>Date</th>
                  <th>Duration</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>101</td>
                  <td>Mid Term</td>
                  <td>Mathematics</td>
                  <td>2025-08-10</td>
                  <td>60</td>
                  <td>
                    <button class="btn btn-warning btn-sm">Edit</button>
                    <button class="btn btn-danger btn-sm">Delete</button>
                  </td>
                </tr>
                <!-- Add more rows as needed -->
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
