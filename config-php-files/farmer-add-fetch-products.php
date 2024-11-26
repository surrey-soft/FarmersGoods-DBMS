<?php
session_start();

// Include the database connection
include("db_connection.php");

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit();
}

// Function to add the product to the database
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['product_name'], $_POST['product_type'], $_POST['product_date'])) {
    // Sanitize input
    $productName = mysqli_real_escape_string($con, $_POST['product_name']);
    $productType = mysqli_real_escape_string($con, $_POST['product_type']);
    $productDate = mysqli_real_escape_string($con, $_POST['product_date']);
    $farmerId = $_SESSION['user_id']; // Get logged-in farmer's ID

    // Insert into product table
    $sql = "INSERT INTO product (Product_Name, Product_Type, Date, Farmer_ID) 
            VALUES ('$productName', '$productType', '$productDate', '$farmerId')";
    
    if (mysqli_query($con, $sql)) {
        $_SESSION['success'] = 'Product added successfully!';
    } else {
        $_SESSION['error'] = 'Error adding product.';
    }

    // Redirect back to the dashboard
    header('Location:../user-dashboard/farmer_dashboard.php');
    exit();
}
?>
