<?php
include "../layout/header_register.php";
include_once(dirname(__DIR__) . "/models/tradesmen.php");
include_once(dirname(__DIR__) . "/models/user.php");
include_once(dirname(__DIR__) . "/models/category.php");
include_once(dirname(__DIR__) . "/models/location.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $user = new User();
  $user->name = $_POST["name"];
  $user->phone = $_POST["phone"];
  $user->email = $_POST["email"];
  $user->user_type = $_POST["userType"];
  $user->location = $_POST["location"];
  $user->category = $_POST["category"];
  $user->password = $_POST["password"];

  $result = $user->register( $user);
 
  echo "<div class='alert alert-success text-center'> <strong><span>" . $result . "</span></strong></div>";
}
?>
<div class="container  mt-3">
  <div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-6">
      <div class='rounded shadow-box'>
        <h2 class="text-center">Register</h2>
        <form action="register.php" method="POST">
          <a href="../index.php">Back to Login</a>
          <div class="mb-3 mt-3">
            <label for="email">Name *</label>
            <input type="name" class="form-control" id="name" placeholder="Enter name" name="name" required>
          </div>
          <div class="mb-3 mt-3">
            <label for="email">Phone *</label>
            <input type="phone" class="form-control" id="phone" placeholder="Enter phone" name="phone" required>
          </div>
          <div class="mb-3 mt-3">
            <label for="email">Email *</label>
            <input type="email" class="form-control" id="email" placeholder="Enter email" name="email" required>
          </div>
          <div class="mb-3 mt-3">
            <label for="email">User Type</label>
            <select class="form-select" name="userType" id="userType" onchange="userTypeChange()">
              <option value="customer">Customer</option>
              <option value="tradesmen">Tradesmen</option>
            </select>
          </div>
          <div class="mb-3 mt-3">
            <label for="email">Location</label>
            <select class="form-select" id="location" name="location">
              <?php
              $location = new Location();
              $result = $location->getLocationList();
              while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                echo "   <option value='" . $row["location_id"] . "'>" . $row["location_name"] . "</option>";
              }
              ?>
            </select>
          </div>
          <div class="mb-3 select-tradesmen" style="display: none;">
            <label for="pwd">Category</label>
            <select class="form-select" id="category" name="category">
              <?php
              $category = new Category();
              $result = $category->getCategoryList();
              while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                echo "   <option value='" . $row["category_id"] . "'>" . $row["category_name"] . "</option>";
              }
              ?>
            </select>
          </div>
          <div class="mb-3 mt-3  mb-3">
            <label for="password">Password *</label>
            <input type="password" class="form-control" id="password" placeholder="Enter password" name="password" required>
          </div>
          <div class="row  justify-content-center mb-3">
            <button type="submit"  class="btn btn-success col-md-3">Register</button>
          </div>
        </form>
      </div>
    </div>
    <div class="col-md-3"></div>
  </div>
</div>
<?php include "../layout/footer.php" ?>
<script>
  <?php include "../scripts/script.js" ?>
</script>