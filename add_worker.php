<?php 
require_once 'db.php';
require_once 'classes/WorkloadManager.php';

$workloadManager = new WorkloadManager($conn);
$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate input
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $zone = $_POST['zone'];

    if (empty($name)) {
        $errors[] = 'Name is required';
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Valid email is required';
    }

    if (empty($phone) || !preg_match('/^\d{10}$/', $phone)) {
        $errors[] = 'Valid 10-digit phone number is required';
    }

    if (empty($errors)) {
        try {
            $stmt = $conn->prepare('INSERT INTO workers (name, email, phone, zone) VALUES (?, ?, ?, ?)');
            $stmt->bind_param('ssss', $name, $email, $phone, $zone);
            
            if ($stmt->execute()) {
                $success = 'Worker added successfully!';
            } else {
                $errors[] = 'Failed to add worker: ' . $stmt->error;
            }
        } catch (Exception $e) {
            $errors[] = 'Database error: ' . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Worker - Delivery System</title>
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
                        <a class="nav-link active" href="add_worker.php">Add Worker</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="assign_order.php">Assign Order</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="leave_request.php">Leave Request</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="hero-section">
        <div class="container text-center">
            <h1 class="display-4">Add New Worker</h1>
            <p class="lead">Register a new delivery worker to the system</p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container">
        <div class="form-container">
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $zone = $_POST['zone'];
    $sql = "INSERT INTO workers (name, zone) VALUES ('$name', '$zone')";
    if ($conn->query($sql) === TRUE) {
                    echo '<div class="alert alert-success" role="alert">
                            <i class="fas fa-check-circle"></i> Worker added successfully!
                          </div>';
    } else {
                <div class="mb-3">
                    <label for="name" class="form-label">Worker Name</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter worker's name" value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>" required>
                        <div class="invalid-feedback">
                            Please enter the worker's name.
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter worker's email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
                        <div class="invalid-feedback">
                            Please enter the worker's email.
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Phone Number</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                        <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter worker's phone number" value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>" required>
                        <div class="invalid-feedback">
                            Please enter the worker's phone number.
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="zone" class="form-label">Zone</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                        <select class="form-select" id="zone" name="zone" required>
                            <option value="urban" <?php echo (isset($_POST['zone']) && $_POST['zone'] == 'urban') ? 'selected' : ''; ?>>Urban</option>
                            <option value="suburban" <?php echo (isset($_POST['zone']) && $_POST['zone'] == 'suburban') ? 'selected' : ''; ?>>Suburban</option>
                            <option value="rural" <?php echo (isset($_POST['zone']) && $_POST['zone'] == 'rural') ? 'selected' : ''; ?>>Rural</option>
                        </select>
                        <div class="invalid-feedback">
                            Please select the delivery zone.
                        </div>
                    </div>
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-plus-circle"></i> Add Worker
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
