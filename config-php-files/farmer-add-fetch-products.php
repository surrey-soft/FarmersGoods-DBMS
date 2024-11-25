<?php
session_start();

// Include the database connection
include("db_connection.php");

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit();
}

// Insert the product into the database if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['product_name'], $_POST['product_type'], $_POST['product_date'])) {
    $productName = mysqli_real_escape_string($con, $_POST['product_name']);
    $productType = mysqli_real_escape_string($con, $_POST['product_type']);
    $productDate = mysqli_real_escape_string($con, $_POST['product_date']);
    $farmerId = $_SESSION['user_id']; // Get the farmer's ID from the session

    // Insert product into the database
    $sql = "INSERT INTO product (Product_Name, Product_Type, Date, Farmer_ID) 
            VALUES ('$productName', '$productType', '$productDate', '$farmerId')";

    if (mysqli_query($con, $sql)) {
        // Redirect to the dashboard with success
        header('Location: ../user-dashboard/farmer_dashboard.php?show_products=true');
        exit();
    } else {
        // If insertion fails, return an error message
        $_SESSION['error'] = 'Failed to add product. Please try again.';
        header('Location: ../user-dashboard/farmer_dashboard.php');
        exit();
    }
}

// Fetch all products for the logged-in farmer when Show Products is clicked
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['show_products'])) {
    $farmerId = $_SESSION['user_id']; // Get the logged-in farmer's ID

    // Fetch the products from the database
    $sql = "SELECT * FROM product WHERE Farmer_ID = '$farmerId'";
    $result = mysqli_query($con, $sql);

    if ($result) {
        // Check if any rows were returned
        if (mysqli_num_rows($result) > 0) {
            // Store products in session for displaying on the dashboard
            $_SESSION['products'] = mysqli_fetch_all($result, MYSQLI_ASSOC);
        } else {
            // If no products found, set a message in the session
            $_SESSION['error'] = 'No products found for this farmer.';
        }
    } else {
        $_SESSION['error'] = 'Error fetching products from the database.';
    }

    // Redirect back to the dashboard to show products
    header('Location: ../user-dashboard/farmer_dashboard.php?show_products=true');
    exit();
}
?>
