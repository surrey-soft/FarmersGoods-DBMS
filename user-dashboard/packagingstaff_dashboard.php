<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Oc Dashboard</title>
  <style>
    /* Styling for the page */
    @import url('https://fonts.googleapis.com/css?family=Poppins:400,500,600,700&display=swap');
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

    .form-container,
    .product-list {
      margin-top: 20px;
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

    .product-list table {
      width: 100%;
      border-collapse: collapse;
    }

    .product-list table, .product-list th, .product-list td {
      border: 1px solid #ddd;
    }

    .product-list th, .product-list td {
      padding: 12px;
      text-align: left;
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

    /* Initially hide both Add Product Form and Product List */
    #addProductForm,
    #productList {
      display: none; /* Hide both initially */
    }
  </style>
</head>
<body>
  <!-- Navbar -->
  <div class="navbar">
    <!-- <a href="javascript:void(0);" onclick="showAddProductForm()">Add Product</a> -->
    <a href="javascript:void(0);" onclick="showPackegingProducts()">Show Packaging Products</a>
    <a href="javascript:void(0);" onclick="signOut()">Sign Out</a>
  </div>

  <!-- Dashboard container -->
  <div class="container">
    <h2>Packeging Staff Dashboard!</h2>

    <!-- Error Messages -->
    <?php if (isset($_SESSION['error'])): ?>
      <div style="color: red; text-align: center;">
        <?php echo $_SESSION['error']; ?>
      </div>
      <?php unset($_SESSION['error']); // Clear the error message after displaying ?>
    <?php endif; ?>

    <!-- Add Product Form -->
    <!-- <div class="form-container" id="addProductForm">
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
    </div> -->

    <!-- Show Products -->
    <div class="product-list" id="productList">
      <h3>This products waiting for packeging</h3>
      <table>
        <thead>
          <tr>
            <th>Package ID</th>
            <th>Package Type</th>
            <th>Package Description</th>
            <th>Package Date</th>
            <th>ORder ID</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($products)): ?>
            <?php foreach ($products as $product): ?>
              <tr>
                <td><?php echo $product['Product_Name']; ?></td>
                <td><?php echo $product['Product_Type']; ?></td>
                <td><?php echo $product['Product_Date']; ?></td>
                <td><?php echo $product['Batch_ID'] ? $product['Batch_ID'] : 'Pending'; ?></td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="4">No products available.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  <script>
    // Show and hide form sections
    function showAddProductForm() {
      document.getElementById("addProductForm").style.display = "block";  // Show Add Product form
      document.getElementById("productList").style.display = "none";  // Hide Product List
    }

    function showProducts() {
      document.getElementById("productList").style.display = "block";  // Show Products table
      document.getElementById("addProductForm").style.display = "none";  // Hide Add Product form
    }

    function signOut() {
      window.location.href = "../index.php"; // Redirect to login page
    }
  </script>
</body>
</html>
