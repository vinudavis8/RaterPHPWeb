<?php
include_once(dirname(__DIR__) . "/models/tradesmen.php");
include_once(dirname(__DIR__) . "/models/bookings.php");
include_once(dirname(__DIR__) . "/models/customer.php");

if (!session_id()) session_start();
$user = new User();
$tradesmen = new Tradesmen();
$booking = new Bookings();
$customer = new Customer();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $rating = $_POST['user_rating'];
    if ($rating > 0) {
        $tradesmen->tradesmen_id = $_POST['tradesmen_id'];
        $customer_id = $_POST['customer_id'];
        $tradesmen->rating = $_POST['user_rating'];
        $tradesmen->review = $_POST['review'];
        $rowcount = $tradesmen->saveRating($tradesmen, $customer_id);
        $message = "";
        if ($rowcount === 1) {
            $message = "success";
        } else
            $message = "failed";
    }
}
$tradesmen_id = $_SESSION['selected_tradesmen_id'];
$ratings_list = $tradesmen->getRatings($tradesmen_id);
$rating_summary = $tradesmen->getRatingSummary($tradesmen_id);
$result = $customer->getCustomerRatingsCount($tradesmen_id, $_SESSION['logged_in_user_id']);
$row1 = mysqli_fetch_assoc($result);
$customer_ratings_count = $row1['count'];

$row1 = mysqli_fetch_assoc($rating_summary);
$total_ratings = $row1['count'];
$average_ratings = $row1['rating'];

$result = $booking->getCompletedBookings($tradesmen_id, $_SESSION['logged_in_user_id']);
$row1 = mysqli_fetch_assoc($result);
$bookings_completed = $row1['count'];

?>
<input type="hidden" name="user_rating" id="user_rating" value="">
<input type="hidden" name="user_rating" id="rating" value="">
<h2 class="">Review summary</h2>
<div class="row">
    <div class="col-md-4">
        <div class="" style="display: flex;">
            <div class="rate1"></div>
            <span id="avg-rating" class="h1 ms-3">
                <?php echo $average_ratings ?>
            </span>
        </div>
        <?php echo $total_ratings ?> reviews
        <br />
        <br />
        <?php

        while ($row = mysqli_fetch_array($ratings_list, MYSQLI_ASSOC)) {
            $percentage = 0;
            if ($row["count"] > 0) {
                $percentage = ($row["count"] / $total_ratings) * 100;
            }
            echo " <div class=\"col-sm-24\">
                     <div class=\"histogram--row\">
                         <span>" . $row["ind"] . " </span>★</span>
                         <div class=\"histogram--bar\" style=\"width: " . $percentage . "%;\"></div>
                         <span>" . $row["count"] . " </span>
                     </div> </div>";
        }

        ?>
        <div class="col-sm-24">
            <div class="row">
                <div class=" col-md-12">
                    <br />
                    <span id="rating_message"></span>
                    <span>Rate Tradesmen</span>
                    <div class="rate2"></div>
                    <a class="btn btn-big btn-fullWidth btn-yellow " href="">Write a review</a>
                    <textarea id="review" name="review" rows="4" cols="40"> </textarea>
                    <span id="rating-message"></span>
                    <?php
                    if ($bookings_completed == 0) {
                        echo "<p class='text-danger'>Rating option unavailable, you must do a booking to rate this tradesmen<p>";
                        echo "<button type=\"button\" class=\"btn btn-success  \" disabled >Save Rating</button>";
                    } else
                    if ($customer_ratings_count > 0) {
                        echo "<p class='text-success'>You have already rated this  tradesmen<p>";
                        echo "<button type=\"button\" class=\"btn btn-success  \" disabled >Save Rating</button>";
                    } else
                    echo
                    "<button type=\"button\" class=\"btn btn-success  \" onclick=\"saveRating()\">Save Rating</button>";
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8 div-review">
        <?php 
        $result = $tradesmen->getRatingsList($tradesmen_id, $_SESSION['logged_in_user_id']);
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $rat = $row['rating'];
            echo "<div > 
    <img src=\"../images/img_avatar.png\" alt=\"Logo\" style=\"width:40px;\" class=\"rounded-pill\">
    <span>" . $row['name'] . "</span> 
    <p>";
            for ($i = 0; $i < $rat; $i++) {
                echo " <i class=\"fa fa-star checked\" aria-hidden=\"true\"></i>";
            }
            echo  "</p> 
    <p>" . $row['review'] . "</p> 
    </div><hr>";
        }
        ?>
    </div>
</div>