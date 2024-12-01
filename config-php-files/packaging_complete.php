<?php
session_start();

// Ensure Packaging Staff is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'packagingStaff') {
    die("Unauthorized access! Please log in as Packaging Staff.");
}

// Include DB connection
include '../config-php-files/db_connection.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = $_POST['order_id'] ?? null;
    $package_type = $_POST['package_type'] ?? null;
    $description = $_POST['description'] ?? null;
    $packaging_date = $_POST['packaging_date'] ?? null;

    if (!$order_id || !$package_type || !$description || !$packaging_date) {
        die("All fields are required.");
    }

    // Insert into the package table
    $sql = "INSERT INTO package (PackageType, Description, Packaging_Date, Order_ID) VALUES (?, ?, ?, ?)";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("sssi", $package_type, $description, $packaging_date, $order_id);

    if ($stmt->execute()) {
        echo "Packaging completed successfully!";
        // Update the order status to 'Completed'
        $update_sql = "UPDATE ordertable SET Order_Status = 'Packaging Completed' WHERE Order_ID = ?";
        $update_stmt = $con->prepare($update_sql);
        $update_stmt->bind_param("i", $order_id);
        $update_stmt->execute();

        // Redirect back to the dashboard
        header("Location: ../user-dashboard/packagingstaff_dashboard.php?success=packaging_completed");
        exit();
    } else {
        die("Failed to complete packaging: " . $stmt->error);
    }
} else {
    die("Invalid request method.");
}

$con->close(); // Close the DB connection
?>
