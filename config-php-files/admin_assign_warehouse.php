<?php
session_start();

// Ensure Admin is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
    die("Unauthorized access! Please log in as Admin.");
}

// Include DB connection
include '../config-php-files/db_connection.php';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = $_POST['order_id'] ?? null;
    $warehouse_id = $_POST['warehouse_id'] ?? null;
    $pickup_location = $_POST['pickup_location'] ?? null;

    if (!$order_id || !$warehouse_id || !$pickup_location) {
        die("All fields are required.");
    }

    // Update the order with the assigned Warehouse_ID and Order_Pickup
    $sql = "UPDATE ordertable SET Warehouse_ID = ?, Order_Pickup = ? WHERE Order_ID = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("isi", $warehouse_id, $pickup_location, $order_id);

    if ($stmt->execute()) {
        echo "Warehouse assigned successfully!";
        // Redirect back to the admin dashboard with success message
        header("Location: ../user-dashboard/admin_dashboard.php?success=warehouse_assigned");
        exit();
    } else {
        die("Failed to assign warehouse: " . $stmt->error);
    }
} else {
    die("Invalid request method.");
}

$con->close();
?>
