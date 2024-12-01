<?php
session_start();

// Ensure Driver is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'driver') {
    die("Unauthorized access! Please log in as Driver.");
}

$driver_id = $_SESSION['user_id']; // Logged-in Driver ID

// Include DB connection
include '../config-php-files/db_connection.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = $_POST['order_id'] ?? null;

    if (!$order_id) {
        die("Order ID is required.");
    }

    // Get Customer_ID for the order
    $get_customer_query = "SELECT Customer_ID FROM ordertable WHERE Order_ID = ?";
    $stmt = $con->prepare($get_customer_query);
    $stmt->bind_param("i", $order_id);  // Bind the order_id as integer
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        die("Invalid Order ID.");
    }

    $row = $result->fetch_assoc();
    $customer_id = $row['Customer_ID'];

    // Update the order status and assign the driver
    $update_order_sql = "UPDATE ordertable SET Order_Status = 'In Transit', Driver_ID = ? WHERE Order_ID = ?";
    $stmt = $con->prepare($update_order_sql);
    $stmt->bind_param("ii", $driver_id, $order_id);  // Bind driver_id and order_id
    if ($stmt->execute()) {
        // Redirect back to the dashboard with a success message
        header("Location: ../user-dashboard/driver_dashboard.php?success=1");
        exit();
    } else {
        die("Failed to accept order: " . $stmt->error);
    }
} else {
    die("Invalid request method.");
}

$con->close(); // Close the DB connection
?>
