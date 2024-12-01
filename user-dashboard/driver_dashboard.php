<?php
session_start();

// Ensure Driver is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'driver') {
    die("Unauthorized access! Please log in as Driver.");
}

$driver_id = $_SESSION['user_id']; // Logged-in Driver ID

// Include DB connection
include '../config-php-files/db_connection.php';

// Fetch unprocessed orders (Packaging Completed)
$sql_unprocessed = "SELECT o.Order_ID, o.Product_ID, o.Order_Destination, o.Order_Date, c.Customer_ID, 
                    c.FirstName as Customer_FirstName, c.LastName as Customer_LastName, 
                    c.MobileNo as Customer_Contact, o.Order_Pickup 
                    FROM ordertable o
                    JOIN customer c ON o.Customer_ID = c.Customer_ID
                    WHERE o.Order_Status = 'Packaging Completed'";

$stmt_unprocessed = $con->prepare($sql_unprocessed);
$stmt_unprocessed->execute();
$result_unprocessed = $stmt_unprocessed->get_result();

$unprocessed_orders = [];
if ($result_unprocessed && $result_unprocessed->num_rows > 0) {
    while ($row = $result_unprocessed->fetch_assoc()) {
        $unprocessed_orders[] = $row;
    }
}

// Fetch accepted orders (In Transit)
$sql_in_transit = "SELECT o.Order_ID, o.Product_ID, o.Order_Destination, o.Order_Date, c.Customer_ID, 
                   c.FirstName as Customer_FirstName, c.LastName as Customer_LastName, 
                   c.MobileNo as Customer_Contact, o.Order_Pickup 
                   FROM ordertable o
                   JOIN customer c ON o.Customer_ID = c.Customer_ID
                   WHERE o.Order_Status = 'In Transit' AND o.Driver_ID = ?";

$stmt_in_transit = $con->prepare($sql_in_transit);
$stmt_in_transit->bind_param("i", $driver_id);
$stmt_in_transit->execute();
$result_in_transit = $stmt_in_transit->get_result();

$in_transit_orders = [];
if ($result_in_transit && $result_in_transit->num_rows > 0) {
    while ($row = $result_in_transit->fetch_assoc()) {
        $in_transit_orders[] = $row;
    }
}

$con->close(); // Close the DB connection
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Driver Dashboard</title>
    <!-- Include necessary styles -->
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="../css/added-style.css">
  <script>
    // Function to toggle between unprocessed and accepted orders
    function toggleOrderDetails(button) {
      var orderDetails = document.getElementById("acceptedOrders");
      var productList = document.getElementById("productList");

      // Toggle visibility of the tables
      if (orderDetails.style.display === "none") {
        orderDetails.style.display = "block";  // Show accepted orders
        productList.style.display = "none";    // Hide the unprocessed orders
        button.innerHTML = "View Unaccepted Orders"; // Change button text
      } else {
        orderDetails.style.display = "none";   // Hide accepted orders
        productList.style.display = "block";   // Show unprocessed orders
        button.innerHTML = "View Orders";      // Change button text back
      }
    }
  </script>
</head>
<body>
  <!-- Navbar -->
  <div class="navbar">
    <a href="javascript:void(0);" onclick="toggleOrderDetails(this)">View Orders</a> <!-- Trigger for View Orders -->
    <a href="javascript:void(0);" onclick="showAddVehicleForm()">Add Vehicle Info</a>
    <a href="../index.php">Sign Out</a>
  </div>

  <!-- Dashboard container -->
  <div class="container">
    <h2>Welcome to Your Dashboard, Driver!</h2>

    <!-- Unprocessed Orders (Packaging Completed) -->
    <div class="product-list" id="productList">
      <h3>Orders Ready for Transport</h3>
      <table>
        <thead>
          <tr>
            <th>Order ID</th>
            <th>Product ID</th>
            <th>Order Destination</th>
            <th>Order Date</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($unprocessed_orders)): ?>
            <?php foreach ($unprocessed_orders as $order): ?>
              <tr>
                <td><?php echo $order['Order_ID']; ?></td>
                <td><?php echo $order['Product_ID']; ?></td>
                <td><?php echo $order['Order_Destination']; ?></td>
                <td><?php echo $order['Order_Date']; ?></td>
                <td>
                  <!-- Form to accept order -->
                  <form action="../config-php-files/driver_accept_order.php" method="POST">
                    <input type="hidden" name="order_id" value="<?php echo $order['Order_ID']; ?>" />
                    <input type="submit" value="Accept Order" />
                  </form>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="5">No orders available for transport.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <!-- Accepted Orders (In Transit) (Initially hidden) -->
    <div class="accepted-orders" id="acceptedOrders" style="display:none;">
      <h3>Driver Accepted Orders</h3>
      <table>
        <thead>
          <tr>
            <th>Order ID</th>
            <th>Pickup Location</th>
            <th>Order Destination</th>
            <th>Customer Name</th>
            <th>Customer Contact</th>
            <th>Packaging Date</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($in_transit_orders as $order): ?>
            <tr>
              <td><?php echo $order['Order_ID']; ?></td>
              <td><?php echo $order['Order_Pickup']; ?></td>
              <td><?php echo $order['Order_Destination']; ?></td>
              <td><?php echo $order['Customer_FirstName'] . " " . $order['Customer_LastName']; ?></td>
              <td><?php echo $order['Customer_Contact']; ?></td>
              <td><?php echo $order['Order_Date']; ?></td>
              <td>
                <!-- Form to mark order as delivered -->
                <form action="../config-php-files/driver_update_status.php" method="POST">
                  <input type="hidden" name="order_id" value="<?php echo $order['Order_ID']; ?>" />
                  <input type="hidden" name="status" value="Delivered" />
                  <input type="submit" value="Mark as Delivered" />
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <!-- Add Vehicle Info Form (Initially hidden) -->
    <div class="form-container" id="addVehicleForm" style="display:none;">
      <h3>Add Your Vehicle Information</h3>
      <form method="POST" action="../config-php-files/add_vehicle_info.php">
        <label for="vehicle_regno">Vehicle Registration Number</label>
        <input type="text" name="vehicle_regno" id="vehicle_regno" required />

        <label for="v_name">Vehicle Name</label>
        <input type="text" name="v_name" id="v_name" required />

        <label for="v_capacity">Vehicle Capacity</label>
        <input type="number" name="v_capacity" id="v_capacity" required />

        <label for="vehicle_type">Vehicle Type</label>
        <input type="text" name="vehicle_type" id="vehicle_type" required />

        <input type="submit" value="Add Vehicle" />
      </form>
      <button type="button" onclick="cancelAddVehicle()">Cancel</button> <!-- Cancel Button -->
    </div>
  </div>
  <?php include '../footer.php' ?>
  <script>
    // Show Add Vehicle Form
    function showAddVehicleForm() {
      document.getElementById("addVehicleForm").style.display = "block";  // Show the form
      document.getElementById("productList").style.display = "none";      // Hide the table
      document.getElementById("acceptedOrders").style.display = "none";   // Hide the accepted orders
    }

    // Cancel the form and show the table again
    function cancelAddVehicle() {
      document.getElementById("addVehicleForm").style.display = "none";  // Hide the form
      document.getElementById("productList").style.display = "block";    // Show the table
      document.getElementById("acceptedOrders").style.display = "none";  // Hide the accepted orders
    }
  </script>
</body>
</html>
