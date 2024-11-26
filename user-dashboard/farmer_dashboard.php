<?php
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit();
}

// Include database connection
include("../config-php-files/db_connection.php");

// Fetch products for the logged-in farmer
$products = [];
if (isset($_SESSION['user_id'])) {
    $farmerId = $_SESSION['user_id']; // Get logged-in farmer's ID

    // Fetch products from the database
    $sql = "SELECT * FROM product WHERE Farmer_ID = $farmerId";
    $result = mysqli_query($con, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        // Store the products in the session for later use
        $products = mysqli_fetch_all($result, MYSQLI_ASSOC);
        $_SESSION['products'] = $products;  // Store in session to use in frontend
    } else {
        $_SESSION['products'] = [];  // No products found
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Farmer Dashboard</title>
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: #f1f1f1;
      margin: 0;
      padding: 0;
    }

    .navbar {
      background-color: #4070f4;
      padding: 15px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .navbar a {
      color: white;
      font-size: 18px;
      text-decoration: none;
      margin: 0 15px;
      cursor: pointer;
    }

    .navbar a:hover {
      text-decoration: underline;
    }

    .container {
      width: 80%;
      margin: 20px auto;
      padding: 30px;
      background: #fff;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    h2 {
      text-align: center;
      font-size: 24px;
      font-weight: 600;
      color: #333;
    }

    .form-container {
      margin-top: 20px;
      display: none;
    }

    .form-container form {
      display: flex;
      flex-direction: column;
    }

    label {
      font-size: 16px;
      font-weight: 600;
      color: #333;
    }

    input,
    select {
      padding: 12px;
      font-size: 14px;
      border: 1.5px solid #c7bebe;
      border-radius: 6px;
      transition: all 0.3s ease;
      width: 100%;
      margin-bottom: 10px;
    }

    input[type="text"]:focus,
    select:focus {
      border-color: #4070f4;
    }

    input[type="submit"] {
      background-color: #4070f4;
      color: white;
      cursor: pointer;
      border: none;
      padding: 14px;
      font-size: 16px;
      font-weight: 600;
      transition: all 0.3s ease;
    }

    input[type="submit"]:hover {
      background-color: #0e4bf1;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    table, th, td {
      border: 1px solid #ddd;
    }

    th, td {
      padding: 12px;
      text-align: left;
    }

    .no-products {
      text-align: center;
      color: #555;
    }

    .back-btn {
      text-align: center;
      margin-top: 20px;
    }

    .back-btn a {
      text-decoration: none;
      color: #4070f4;
      font-size: 16px;
    }

    /* Initially hide Add Product Form */
    #addProductForm {
      display: none;
    }
  </style>
</head>
<body>

  <!-- Navbar -->
  <div class="navbar">
    <a href="javascript:void(0);" onclick="showAddProductForm()">Add Product</a>
    <a href="javascript:void(0);" onclick="signOut()">Sign Out</a>
  </div>

  <!-- Dashboard container -->
  <div class="container">
    <h2>Welcome to Your Dashboard, Farmer!</h2>

    <!-- Add Product Form -->
    <div class="form-container" id="addProductForm">
      <h3>Add New Product</h3>
      <form method="POST" action="../config-php-files/farmer-add-fetch-products.php">
        <label for="product_name">Product Name</label>
        <input type="text" name="product_name" id="product_name" placeholder="Enter product name" required />
        <label for="product_type">Product Type</label>
        <select name="product_type" id="product_type" required>
          <option value="Fruit">Fruit</option>
          <option value="Vegetable">Vegetable</option>
          <option value="Grain">Grain</option>
          <option value="Dairy">Dairy</option>
        </select>
        <label for="product_date">Product Date</label>
        <input type="date" name="product_date" id="product_date" required />
        <input type="submit" value="Add Product" />
      </form>
    </div>

    <!-- Display Products -->
    <div id="productList">
      <?php if (empty($products)): ?>
        <div class="no-products">
          <p>No products available. Please add a product.</p>
        </div>
      <?php else: ?>
        <table>
          <thead>
            <tr>
              <th>Product ID</th>
              <th>Product Name</th>
              <th>Product Type</th>
              <th>Product Date</th>
              <th>Batch ID</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($products as $product): ?>
              <tr>
                <td><?php echo htmlspecialchars($product['Product_ID']); ?></td>
                <td><?php echo htmlspecialchars($product['Product_Name']); ?></td>
                <td><?php echo htmlspecialchars($product['Product_Type']); ?></td>
                <td><?php echo htmlspecialchars($product['Date']); ?></td>
                <td><?php echo !empty($product['Batch_ID']) ? htmlspecialchars($product['Batch_ID']) : 'Pending'; ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php endif; ?>
    </div>

  </div>

  <script>
    // Show and hide form sections
    function showAddProductForm() {
      document.getElementById("addProductForm").style.display = "block";  // Show Add Product form
      document.getElementById("productList").style.display = "none";  // Hide Product List
    }

    function signOut() {
      window.location.href = "../index.php"; // Redirect to login page
    }
  </script>

</body>
</html>
