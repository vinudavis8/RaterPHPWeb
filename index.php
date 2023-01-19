<?php
include_once "layout/header.php";
include_once "models/tradesmen.php";
include_once "models/category.php";
include_once "models/location.php";
?>
<div class="col-md-12 div-box">
  <input type="hidden" id="redirect_URL">
  <div class="div-search rounded">
    <h4 class="head-search mt-3"> Find local traders near you</h4>
    <div class="row mt-3">
      <div class="form-floating col-md-6 mt-1">
        <select class="form-select" id="category" name="category">
          <option value='0'>All</option>;
          <?php
          $category = new Category();
          $result = $category->getCategoryList();
          while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            echo "<option value='" . $row["category_id"] . "'>" . $row["category_name"] . "</option>";
          }
          ?>
        </select>
        <label for="category" class="form-label">Category</label>
      </div>
      <div class="form-floating col-md-6  mt-1">
        <select class="form-select" id="location" name="location">
          <option value='0'>All</option>;
          <?php
          $location = new Location();
          $result = $location->getLocationList();
          while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            echo "<option value='" . $row["location_id"] . "'>" . $row["location_name"] . "</option>";
          }
          ?>
        </select>
        <label for="location" class="form-label">Location</label>
      </div>
      <div class="col-md-6 mt-3">
        <input type="button" class="btn btn-success col-md-12" onclick="searchTraders()" value="Search">
      </div>
    </div>
  </div>
  <div class="col-md-12">
    <img class="banner" src="images/tradesmen-back1.png" alt="back">
  </div>
</div>
<div class="container">
  <div id="tradersList">
    <div class="row mt-3 ">
      <h4 class="text-center mb-3">How It works</h4>
      <div class="col-md-1"> </div>
      <div class="col-md-3 me-3 div-how"> 
      <img src="images/1.png">  
      <h5 class="text-center mt-3 ">search for local tradesmen near you</h5> </div>
      <div class="col-md-3 me-3 div-how">
      <img src="images/2.png">  
      <h5 class="text-center me-3 mt-3">create booking </h5></div>
      <div class="col-md-3 me-3 div-how"> 
      <img src="images/3.png">  
      <h5 class="text-center mt-3"> Add review and rating</h5> </div>
      <div class="col-md-2"> </div>
    </div>
  </div>
</div>
<?php include_once('forms/login.php'); ?>
<?php include "layout/footer.php" ?>
<script>
  <?php include "scripts/script.js" ?>
</script>