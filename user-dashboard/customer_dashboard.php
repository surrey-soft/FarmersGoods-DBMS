<?php
session_start();

// Ensure Customer is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'customer') {
    die("Unauthorized access! Please log in as Customer.");
}

$customer_id = $_SESSION['user_id']; // Logged-in Customer ID

// Include DB connection
include '../config-php-files/db_connection.php';

// Fetch products not ordered by the customer
$sql = "
    SELECT p.Product_ID, p.Product_Name, p.Product_Type, p.Date, p.BatchID 
    FROM PRODUCT p 
    LEFT JOIN ordertable o ON p.Product_ID = o.Product_ID
    WHERE o.Product_ID IS NULL AND p.BatchID IS NOT NULL";  // Fetch products without orders
$result = $con->query($sql);

$products = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}

// Fetch customer orders (including those without a driver)
$sql_orders = "
    SELECT o.Order_ID, o.Order_Status, o.Order_Date, o.Order_Pickup, o.Order_Destination, 
           d.D_FirstName, d.D_LastName, d.Contact_Info AS Driver_Contact
    FROM ordertable o
    LEFT JOIN driver d ON o.Driver_ID = d.Driver_ID
    WHERE o.Customer_ID = ?";
$stmt = $con->prepare($sql_orders);
$stmt->bind_param("i", $customer_id);
$stmt->execute();
$result_orders = $stmt->get_result();

$orders = [];
if ($result_orders && $result_orders->num_rows > 0) {
    while ($row = $result_orders->fetch_assoc()) {
        $orders[] = $row;
    }
}

$con->close(); // Close the DB connection
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Customer Dashboard</title>
    <!-- Include necessary styles -->
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="../css/added-style.css">
  <script>
    // Function to toggle between showing orders and products
    function toggleOrderDetails(button) {
      var orderDetails = document.getElementById("orderDetails");
      var productList = document.getElementById("productList");

      // Toggle visibility of the tables
      if (orderDetails.style.display === "none") {
        orderDetails.style.display = "block";  // Show the order details
        productList.style.display = "none";    // Hide the products
        button.innerHTML = "View Available Products"; // Change button text
      } else {
        orderDetails.style.display = "none";   // Hide the order details
        productList.style.display = "block";   // Show the products
        button.innerHTML = "View Your Orders"; // Change button text back
      }
    }
  </script>
</head>
<body>
  <!-- Navbar -->
  <div class="navbar">
    <a href="javascript:void(0);" onclick="toggleOrderDetails(this)">View Your Orders</a> <!-- Trigger for View Orders -->
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
            if (!empty($products)) {
              foreach ($products as $product) {
                echo "<tr>
                        <td>{$product['Product_Name']}</td>
                        <td>{$product['Product_Type']}</td>
                        <td>{$product['Date']}</td>
                        <td>{$product['BatchID']}</td>
                        <td><button onclick='showOrderForm({$product['Product_ID']})'>Order</button></td>
                      </tr>";
              }
            } else {
                echo "<tr><td colspan='5'>No products available for ordering.</td></tr>";
            }
          ?>
        </tbody>
      </table>
    </div>

    <!-- Show Customer Orders (Initially hidden) -->
    <div class="order-details" id="orderDetails" style="display:none;">
        <h3>Your Orders</h3>
        <table>
            <thead>
            <tr>
                <th>Order ID</th>
                <th>Status</th>
                <th>Order Date</th>
                <th>Pickup Location</th>
                <th>Destination</th>
                <th>Driver Name</th>
                <th>Driver Contact</th>
            </tr>
            </thead>
            <tbody>
            <?php
                if (!empty($orders)) {
                foreach ($orders as $order) {
                    // Conditional values for fields that might be NULL
                    $pickup_location = $order['Order_Pickup'] ? $order['Order_Pickup'] : "Pending";
                    $driver_name = $order['D_FirstName'] && $order['D_LastName'] 
                                ? $order['D_FirstName'] . " " . $order['D_LastName'] 
                                : "Pending";
                    $driver_contact = $order['Driver_Contact'] ? $order['Driver_Contact'] : "Pending";

                    echo "<tr>
                            <td>{$order['Order_ID']}</td>
                            <td>{$order['Order_Status']}</td>
                            <td>{$order['Order_Date']}</td>
                            <td>{$pickup_location}</td>
                            <td>{$order['Order_Destination']}</td>
                            <td>{$driver_name}</td>
                            <td>{$driver_contact}</td>
                        </tr>";
                }
                } else {
                    echo "<tr><td colspan='7'>No orders placed yet.</td></tr>";
                }
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
  <?php include '../footer.php' ?>

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
