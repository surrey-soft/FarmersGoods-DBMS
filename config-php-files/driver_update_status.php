<?php
session_start();

// Ensure Driver is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'driver') {
    die("Unauthorized access! Please log in as Driver.");
}

$driver_id = $_SESSION['user_id']; // Logged-in Driver ID

// Include DB connection
include '../config-php-files/db_connection.php';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];  // Status to be updated (Delivered)

    // Validate inputs
    if (!$order_id || !$status) {
        die("All fields are required.");
    }

    // Update order status to Delivered and set Driver ID
    $update_sql = "UPDATE ordertable SET Order_Status = ?, Driver_ID = ? WHERE Order_ID = ?";
    $stmt = $con->prepare($update_sql);
    $stmt->bind_param("sii", $status, $driver_id, $order_id);

    if ($stmt->execute()) {
        echo "Order status updated to Delivered!";
        header("Location: ../user-dashboard/driver_dashboard.php?success=order_delivered");
        exit();
    } else {
        die("Failed to update order status: " . $stmt->error);
    }
}

$con->close();
?>
