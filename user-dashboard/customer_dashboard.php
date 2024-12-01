<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Customer Dashboard</title>
  <link rel="stylesheet" href="../css/added-style.css">
</head>
<body>
  <!-- Navbar -->
  <div class="navbar">
    <a href="javascript:void(0);" onclick="showOrderForm()">Order Product</a>
    <a href="javascript:void(0);" onclick="signOut()">Sign Out</a>
  </div>

  <!-- Dashboard container -->
  <div class="container">
    <h2>Welcome to Your Dashboard, Customer!</h2>

    <!-- Show Products Not Ordered -->
    <div class="product-list" id="productList">
      <h3>Products Not Ordered</h3>
      <table>
        <thead>
          <tr>
            <th>Product Name</th>
            <th>Product Type</th>
            <th>Product Date</th>
            <th>Batch ID</th>
            <th>Order</th>
          </tr>
        </thead>
        <tbody>
          <?php
            include '../config-php-files/db_connection.php';

            // Fetch products not ordered by the customer
            $sql = "
                SELECT p.Product_ID, p.Product_Name, p.Product_Type, p.Date, p.BatchID 
                FROM PRODUCT p 
                LEFT JOIN ordertable o ON p.Product_ID = o.Product_ID
                WHERE o.Product_ID IS NULL AND p.BatchID IS NOT NULL";  // Fetch products without orders
            $result = $con->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['Product_Name']}</td>
                            <td>{$row['Product_Type']}</td>
                            <td>{$row['Date']}</td>
                            <td>{$row['BatchID']}</td>
                            <td><button onclick='showOrderForm({$row['Product_ID']})'>Order</button></td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No products available for ordering.</td></tr>";
            }
            $con->close();
          ?>
        </tbody>
      </table>
    </div>

    <!-- Order Form (Initially hidden) -->
    <div class="form-container" id="orderForm" style="display: none;">
      <h3>Order Product</h3>
      <form method="POST" action="../config-php-files/order_product.php">
        <input type="hidden" name="product_id" id="order_product_id" />

        <!-- Order Date -->
        <label for="order_date">Order Date</label>
        <input type="date" name="order_date" id="order_date" required />

        <!-- Destination Location -->
        <label for="order_destination">Destination Location</label>
        <input type="text" name="order_destination" id="order_destination" placeholder="Enter delivery address" required />

        <!-- Submit Button -->
        <input type="submit" value="Place Order" />
        <button type="button" onclick="cancelOrder()">Cancel</button>
      </form>
    </div>
  </div>

  <script>
    // Show Order Form when the Order button is clicked
    function showOrderForm(productId) {
      document.getElementById("orderForm").style.display = "block";  // Show the form
      document.getElementById("productList").style.display = "none";  // Hide the product list

      // Set the hidden field in the form
      document.getElementById("order_product_id").value = productId;
    }

    // Cancel order form and return to the product list
    function cancelOrder() {
      document.getElementById("orderForm").style.display = "none";  // Hide the form
      document.getElementById("productList").style.display = "block";  // Show the product list
    }

    // Sign out function
    function signOut() {
      window.location.href = "../index.php"; // Redirect to login page
    }
  </script>
</body>
</html>
