<?php 
require_once 'db.php';
require_once 'classes/LeaveManager.php';

$leaveManager = new LeaveManager($conn);
$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate leave request input
    $workerId = intval($_POST['worker_id']);
    $startDate = $_POST['start_date'];
    $endDate = $_POST['end_date'];
    $reason = trim($_POST['reason']);

    if (empty($workerId)) {
        $errors[] = 'Worker ID is required';
    }

    if (empty($startDate) || empty($endDate)) {
        $errors[] = 'Start and end dates are required';
    } elseif (strtotime($startDate) > strtotime($endDate)) {
        $errors[] = 'Start date must be before end date';
    }

    if (empty($reason)) {
        $errors[] = 'Leave reason is required';
    }

    if (empty($errors)) {
        try {
            $leaveRequest = [
                'worker_id' => $workerId,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'reason' => $reason
            ];

            $result = $leaveManager->submitLeaveRequest($leaveRequest);
            $success = 'Leave request submitted successfully!';
        } catch (Exception $e) {
            $errors[] = 'Leave request failed: ' . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Request - Delivery System</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .hero-section {
            background: linear-gradient(135deg, #6B73FF 0%, #000DFF 100%);
            color: white;
            padding: 2rem 0;
            margin-bottom: 2rem;
        }
        .form-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 2rem;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="fas fa-truck"></i> Delivery System
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="add_worker.php">Add Worker</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="assign_order.php">Assign Order</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="leave_request.php">Leave Request</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="hero-section">
        <div class="container text-center">
            <h1 class="display-4">Submit Leave Request</h1>
            <p class="lead">Request time off for delivery workers</p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container">
        <div class="form-container">
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $worker = $_POST['worker_id'];
    $date = $_POST['leave_date'];
    $reason = $_POST['reason'];
    $sql = "INSERT INTO leaves (worker_id, leave_date, reason) VALUES ('$worker', '$date', '$reason')";
    if ($conn->query($sql) === TRUE) {
                    echo '<div class="alert alert-success" role="alert">
                            <i class="fas fa-check-circle"></i> Leave request submitted successfully!
                          </div>';
    } else {
                <div class="mb-3">
                    <label for="worker_id" class="form-label">Worker ID</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-id-badge"></i></span>
                        <input type="number" class="form-control" id="worker_id" name="worker_id" placeholder="Enter worker ID" value="<?php echo isset($_POST['worker_id']) ? htmlspecialchars($_POST['worker_id']) : ''; ?>" required>
                        <div class="invalid-feedback">
                            Please enter the worker ID.
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="start_date" class="form-label">Start Date</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                        <input type="date" class="form-control" id="start_date" name="start_date" value="<?php echo isset($_POST['start_date']) ? htmlspecialchars($_POST['start_date']) : ''; ?>" required>
                        <div class="invalid-feedback">
                            Please select a start date.
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="end_date" class="form-label">End Date</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                        <input type="date" class="form-control" id="end_date" name="end_date" value="<?php echo isset($_POST['end_date']) ? htmlspecialchars($_POST['end_date']) : ''; ?>" required>
                        <div class="invalid-feedback">
                            Please select an end date.
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="reason" class="form-label">Reason for Leave</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-comment"></i></span>
                        <textarea class="form-control" id="reason" name="reason" rows="3" placeholder="Enter reason for leave" required><?php echo isset($_POST['reason']) ? htmlspecialchars($_POST['reason']) : ''; ?></textarea>
                    </div>
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane"></i> Submit Leave Request
                    </button>
                    <a href="index.php" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Home
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3 mt-5">
        <div class="container">
            <p class="mb-0">&copy; 2024 Delivery Worker Management System. All rights reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Form validation script
        (function () {
            'use strict'
            var forms = document.querySelectorAll('.needs-validation')
            Array.prototype.slice.call(forms)
                .forEach(function (form) {
                    form.addEventListener('submit', function (event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }
                        form.classList.add('was-validated')
                    }, false)
                })
        })()
    </script>
</body>
</html>
