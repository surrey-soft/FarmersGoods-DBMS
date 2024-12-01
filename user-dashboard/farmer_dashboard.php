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
    <!-- Include necessary styles -->
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="../css/added-style.css">
  <title>Farmer Dashboard</title>
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
        <button type="button" onclick="cancelAddProduct()">Cancel</button> <!-- Cancel Button -->
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
                <td><?php echo !empty($product['BatchID']) ? htmlspecialchars($product['BatchID']) : 'Pending'; ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php endif; ?>
    </div>

  </div>
  <?php include '../footer.php' ?>

  <script>
    // Show and hide form sections
    function showAddProductForm() {
      document.getElementById("addProductForm").style.display = "block";  // Show Add Product form
      document.getElementById("productList").style.display = "none";  // Hide Product List
    }

    // Function to cancel adding a product and hide the form
    function cancelAddProduct() {
      document.getElementById("addProductForm").style.display = "none";  // Hide Add Product form
      document.getElementById("productList").style.display = "block";  // Show Product List
    }

    function signOut() {
      window.location.href = "../index.php"; // Redirect to login page
    }
  </script>

</body>
</html>
