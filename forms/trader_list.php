<?php
include_once(dirname(__DIR__) . "/models/tradesmen.php");
if (!session_id()) session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $category = $_POST["category"];
  $location = $_POST["location"];
  $from_date = $_POST["fromDate"];
  $to_date = $_POST["toDate"];

  echo '<div class="trader-list col-md-12">';
  $trader = new Tradesmen();
  $result = $trader->getTraderList($category, $location, $from_date, $to_date);

  while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    $img_path = $row["profile_image_path"];
    if ($img_path == "") {
      $img_path = "images/img_avatar.png";
    } else
      $img_path = "images/profile/" . $img_path;
    
    echo "<div class='trader-card  col-md-3 mr-1'>
          <div class='row'>
          <div class='col-md-7'>
          <h5>" . $row["name"] . "</h4>
          <h6>"  . $row["location_name"] . "</h6>
          <p class=\"badge rounded-pill bg-info\">" . $row["category_name"] . "</p><br/>";
    if ($row["rating"] == "")
      $rating = 0;
    else
      $rating = $row["rating"];
    for ($i = $rating; $i > 0; $i--) {
      echo "<span class='fa fa-star checked'></span>";
    }
    for ($i = 5 - $rating; $i > 0; $i--) {
      echo "<span class='fa fa-star '></span>";
    }

    echo "<span class='h4'>  "   . $rating . "</span>
          <h6> Hourly rate :£ " . $row["hourly_rate"] . "</h6>
         </div>

        <div class='col-md-5'>
          <img  class='trader-img' src='" . $img_path . "' alt='img'>
        </div>
     </div>
     </br>
   <div class='col-md-12'> 
   " . substr($row["description"], 0, 150) . "...View more
   </div>";
    if (isset($_SESSION['logged_in_user_id'])) {
      echo "<a href='forms/trader_profile.php?tradesmen_id= " . $row["user_id"] . "' class='btn btn-success col-md-12'>View </a>";
    } else {
      echo "<button class='btn btn-success col-md-12' onclick='viewTradesmen(" . $row["user_id"] . ")'>View </button>";
    }
    echo " </div>";
  }
  echo '</div>';
}
