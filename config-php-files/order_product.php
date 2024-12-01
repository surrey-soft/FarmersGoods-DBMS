<?php
session_start();

// Include DB connection
include '../config-php-files/db_connection.php';

// Check if the customer is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'customer') {
    die("Unauthorized access! Please log in as a customer.");
}

$customer_id = $_SESSION['user_id'];  // Get the logged-in customer's ID

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form inputs
    $product_id = isset($_POST['product_id']) ? $_POST['product_id'] : null;
    $order_date = isset($_POST['order_date']) ? $_POST['order_date'] : null;
    $order_destination = isset($_POST['order_destination']) ? $_POST['order_destination'] : null;
    $order_status = "In Process";  // Default status

    // Validate inputs
    if (!$product_id || !$order_date || !$order_destination) {
        die("All fields are required.");
    }

    // Insert into Orders table with Customer_ID
    $sql = "INSERT INTO ordertable (Customer_ID, Product_ID, Order_Date, Order_Destination, Order_Status)
            VALUES (?, ?, ?, ?, ?)";

    $stmt = $con->prepare($sql);
    $stmt->bind_param("iisss", $customer_id, $product_id, $order_date, $order_destination, $order_status);

    if ($stmt->execute()) {
        // Order placed successfully
        echo "Order successfully placed!";
        // Redirect to customer dashboard or confirmation page
        header("Location: ../user-dashboard/customer_dashboard.php?order_success=true");
        exit();
    } else {
        // Handle failure
        die("Failed to place order: " . $stmt->error);
    }
} else {
    die("Invalid request method.");
}

$con->close();  // Close the database connection
?>
