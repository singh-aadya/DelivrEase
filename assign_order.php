<?php 
require_once 'db.php';
require_once 'classes/DeliveryAssigner.php';
require_once 'classes/WorkloadManager.php';
require_once 'classes/FatigueTracker.php';

$workloadManager = new WorkloadManager($conn);
$fatigueTracker = new FatigueTracker($conn);
$deliveryAssigner = new DeliveryAssigner($conn, $workloadManager, $fatigueTracker);

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate and process order assignment
    $customerName = trim($_POST['customer_name']);
    $address = trim($_POST['address']);
    $zone = $_POST['zone'];
    $orderWeight = floatval($_POST['order_weight']);

    if (empty($customerName)) {
        $errors[] = 'Customer name is required';
    }

    if (empty($address)) {
        $errors[] = 'Delivery address is required';
    }

    if (empty($zone)) {
        $errors[] = 'Delivery zone is required';
    }

    if (empty($errors)) {
        try {
            $orderDetails = [
                'customer_name' => $customerName,
                'address' => $address,
                'zone' => $zone,
                'order_weight' => $orderWeight
            ];

            $assignedWorker = $deliveryAssigner->assignOrder($orderDetails);
            $success = 'Order assigned to ' . $assignedWorker['name'] . ' successfully!';
        } catch (Exception $e) {
            $errors[] = 'Order assignment failed: ' . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Order - Delivery System</title>
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
                        <a class="nav-link active" href="assign_order.php">Assign Order</a>
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
            <h1 class="display-4">Assign Order</h1>
            <p class="lead">Assign delivery orders to available workers</p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container">
        <div class="form-container">
            <form method="POST" action="assign_order.php" class="needs-validation" novalidate>
                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger">
                        <?php foreach ($errors as $error): ?>
                            <p><?php echo htmlspecialchars($error); ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                <?php if (!empty($success)): ?>
                    <div class="alert alert-success">
                        <?php echo htmlspecialchars($success); ?>
                    </div>
                <?php endif; ?>
                <div class="mb-3">
                    <label for="customer_name" class="form-label">Customer Name</label>
                    <label for="worker_id" class="form-label">Worker ID</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-id-badge"></i></span>
                        <input type="text" class="form-control" id="worker_id" name="worker_id" placeholder="Enter worker ID" required>
                        <div class="invalid-feedback">
                            Please enter the worker ID.
                        </div>
                    </div>
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-tasks"></i> Assign Order
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
