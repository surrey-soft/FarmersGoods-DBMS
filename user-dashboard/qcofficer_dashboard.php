<?php
session_start();

// Ensure QC Officer is logged in
if (!isset($_SESSION['user_id'])) {
    die("Unauthorized access! Please log in as QC Officer.");
}

$qco_id = $_SESSION['user_id']; // Logged-in QC Officer ID

// Include DB connection
include '../config-php-files/db_connection.php';

// Fetch products without Batch ID
$sql_unassigned = "SELECT Product_ID, Product_Name, Product_Type, Date FROM PRODUCT WHERE BatchID IS NULL";
$result_unassigned = $con->query($sql_unassigned);
$products_unassigned = [];
if ($result_unassigned && $result_unassigned->num_rows > 0) {
    while ($row = $result_unassigned->fetch_assoc()) {
        $products_unassigned[] = $row;
    }
}

// Fetch products with Batch ID
$sql_assigned = "
    SELECT p.Product_ID, p.Product_Name, p.Product_Type, p.Date, p.BatchID 
    FROM PRODUCT p 
    WHERE p.BatchID IS NOT NULL 
      AND p.BatchID NOT IN (SELECT BatchID FROM grade)";

$result_assigned = $con->query($sql_assigned);
$products_assigned = [];
if ($result_assigned && $result_assigned->num_rows > 0) {
    while ($row = $result_assigned->fetch_assoc()) {
        $products_assigned[] = $row;
    }
}

$con->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>QC Dashboard</title>
  <!-- Include necessary styles -->
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="../css/added-style.css">
</head>
<body>
  <!-- Navbar -->
  <div class="navbar">
    <a href="javascript:void(0);" onclick="showAssignBatchForm()">Assign Batch</a>
    <a href="../index.php">Sign Out</a>
  </div>

  <!-- Dashboard container -->
  <div class="container">
    <h2>Welcome to Your Dashboard, QC Officer!</h2>

    <!-- Products Needing Batch ID Assignment -->
    <div class="product-list" id="productList">
      <h3>Products Needing Batch ID Assignment</h3>
      <table>
        <thead>
          <tr>
            <th>Product ID</th>
            <th>Product Name</th>
            <th>Product Type</th>
            <th>Product Date</th>
            <th>Batch ID (Status)</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($products_unassigned)): ?>
            <?php foreach ($products_unassigned as $product): ?>
              <tr>
                <td><?php echo $product['Product_ID']; ?></td>
                <td><?php echo $product['Product_Name']; ?></td>
                <td><?php echo $product['Product_Type']; ?></td>
                <td><?php echo $product['Date']; ?></td>
                <td>Pending</td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="5">No products available without a Batch ID.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <!-- Assigned Products Table -->
    <div class="product-list" id="assignedProducts">
      <h3>Batch ID Assigned Products</h3>
      <table>
        <thead>
          <tr>
            <th>Product ID</th>
            <th>Product Name</th>
            <th>Product Type</th>
            <th>Product Date</th>
            <th>Batch ID</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($products_assigned)): ?>
            <?php foreach ($products_assigned as $product): ?>
              <tr>
                <td><?php echo $product['Product_ID']; ?></td>
                <td><?php echo $product['Product_Name']; ?></td>
                <td><?php echo $product['Product_Type']; ?></td>
                <td><?php echo $product['Date']; ?></td>
                <td><?php echo $product['BatchID']; ?></td>
                <td>
                  <button onclick="showGradingForm('<?php echo $product['BatchID']; ?>')">Grade</button>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="6">No products available for grading.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <!-- Assign Batch ID Form -->
    <div class="form-container" id="assignBatchForm" style="display: none;">
      <h3>Assign Batch ID</h3>
      <form method="POST" action="../config-php-files/qc_assign_batch_id.php">
        <label for="batch_id">Batch ID</label>
        <input type="text" name="batch_id" id="batch_id" placeholder="Format: productName-date-month-year" required />

        <label for="product_id">Product ID</label>
        <input type="text" name="product_id" id="product_id" required />

        <label for="batch_name">Batch Name</label>
        <input type="text" name="batch_name" id="batch_name" required />

        <label for="batch_type">Batch Type</label>
        <select name="batch_type" id="batch_type" required>
          <option value="Fruit">Fruit</option>
          <option value="Vegetable">Vegetable</option>
          <option value="Grain">Grain</option>
          <option value="Dairy">Dairy</option>
        </select>

        <label for="batch_date">Batch Date</label>
        <input type="date" name="batch_date" id="batch_date" required />

        <input type="submit" value="Assign Batch" />
        <button type="button" onclick="cancelForm()">Cancel</button>
      </form>
    </div>

    <!-- Grading Form -->
    <div class="form-container" id="gradingForm" style="display: none;">
      <h3>Grade Product</h3>
      <form method="POST" action="../config-php-files/qc_grade_product.php">
        <input type="hidden" name="qco_id" value="<?php echo $qco_id; ?>" />
        <input type="hidden" name="batch_id" id="grading_batch_id" />

        <label for="protein_content">Protein Content</label>
        <input type="number" step="0.01" name="protein_content" id="protein_content" required />

        <label for="nutrition_level">Nutrition Level</label>
        <input type="number" step="0.01" name="nutrition_level" id="nutrition_level" required />

        <label for="size">Size</label>
        <input type="text" name="size" id="size" required />

        <label for="shape">Shape</label>
        <input type="text" name="shape" id="shape" required />

        <label for="color">Color</label>
        <input type="text" name="color" id="color" required />

        <label for="moisture_content">Moisture Content</label>
        <input type="number" step="0.01" name="moisture_content" id="moisture_content" required />

        <label for="ripeness_level">Ripeness Level</label>
        <input type="number" step="0.01" name="ripeness_level" id="ripeness_level" required />

        <label for="physical_defects">Physical Defects</label>
        <input type="text" name="physical_defects" id="physical_defects" required />

        <input type="submit" value="Submit Grade" />
        <button type="button" onclick="cancelForm()">Cancel</button>
      </form>
    </div>
  </div>
  <?php include '../footer.php' ?>
  <script>
    function showForm(showId) {
      document.getElementById("productList").style.display = "none";
      document.getElementById("assignedProducts").style.display = "none";
      document.getElementById(showId).style.display = "block";
    }

    function cancelForm() {
      document.getElementById("productList").style.display = "block";
      document.getElementById("assignedProducts").style.display = "block";
      document.getElementById("assignBatchForm").style.display = "none";
      document.getElementById("gradingForm").style.display = "none";
    }

    function showAssignBatchForm() {
      showForm("assignBatchForm");
    }

    function showGradingForm(batchId) {
      showForm("gradingForm");
      document.getElementById("grading_batch_id").value = batchId;
    }
  </script>
</body>
</html>
