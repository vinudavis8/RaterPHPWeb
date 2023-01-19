<?php 
include "../layout/header.php";
include_once(dirname(__DIR__) . "/models/tradesmen.php");
include_once(dirname(__DIR__) . "/models/bookings.php"); ?>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
<script src="../scripts/rater.js" charset="utf-8"></script>
<script>
    <?php include "../scripts/trader-profile.js" ?>
</script>

<?php
$logged_in_user_id = 0;
if (isset($_SESSION['logged_in_user_id'])) {
    $logged_in_user_id = $_SESSION['logged_in_user_id'];
}
$user = new User();
$trader = new Tradesmen();
$booking = new Bookings();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {


    $booking->tradesmen_id = $_POST['tradesmen_id'];
    $booking->customer_id = $_SESSION['logged_in_user_id'];
    $booking->booking_date = $_POST['bookingDate'];
    $trader->tradesmen_id = $booking->tradesmen_id;
    $rowcount = $booking->createBooking($booking);
    $message = "";
    if ($rowcount === 1) {
        echo " <div class=\"alert alert-success\" >
               <strong>Success!</strong>
               <span>Booking Successful</span>
               </div>";
    } else
        echo " <div class=\"alert alert-success\" >
               <strong>Failed!</strong>
               <span>Booking Failed</span>
               </div>";
} else {
    if (isset($_GET['tradesmen_id'])) {
        $trader->tradesmen_id = $_GET['tradesmen_id'];
        $_SESSION['selected_tradesmen_id'] = $trader->tradesmen_id;
    } else if (isset($_SESSION['selected_tradesmen_id'])) {
        $trader->tradesmen_id = $_SESSION['selected_tradesmen_id'];
    }
}

$result = $trader->getProfileDetails($trader->tradesmen_id);
if (mysqli_num_rows($result) === 1) {

    $row = mysqli_fetch_assoc($result);
    $trader->name = $row['name'];
    $trader->phone = $row['phone'];
    $trader->email = $row['email'];
    $trader->category = $row['category_name'];
    $trader->location = $row['location_name'];
    $trader->hourly_rate = $row['hourly_rate'];
    $trader->description = $row['description'];
    $trader->skills = $row['description'];
    $trader->profile_image = $row['profile_image_path'];
    $trader->professional_certification = $row['professional_certification'];

    $listDates = $booking->getAvailableDates($trader->tradesmen_id);
    $bookedDates = array();
    while ($row = mysqli_fetch_array($listDates, MYSQLI_ASSOC)) {
        $bookedDates[] = $row["booking_date"]; 
    }
    if ($trader->profile_image == "") {
        $trader->profile_image = "../images/img_avatar.png";
    } else
        $trader->profile_image = "../images/profile/" . $trader->profile_image;
}
?>


<div class="container row mt-3  div-profile">
    <form action="trader_profile.php" method="POST" id="bookingForm">
        <?php echo "<input type=\"hidden\" value=\" $trader->tradesmen_id\" name=\"tradesmen_id\" id=\"tradesmen_id\" >" ?>
        <?php echo "<input type='hidden' value=" . $logged_in_user_id . " name='customer_id' id='customer_id' >" ?>
        <input type="hidden" name="bookingDate" id="bookingDates" value="">
        <div class='row'>
            <div class="col-md-12">
                <div class='rounded shadow-box   mr-1'>
                    <div class='row'>
                        <div class='col-md-2'>
                            <?php echo " <img class=' trader-img' src='" . $trader->profile_image . "' alt='img'> "; ?>
                        </div>
                        <div class='col-md-4'>
                            <h4> <?php echo "<span>{$trader->name}</span>"; ?></h4>
                            <div class="rate1"></div>
                            <i class="fa fa-map-marker" aria-hidden="true"> <span> <?php echo "<span>{$trader->location}" ?></span></i>
                            <h6> Hourly rate :£
                                <?php echo "<span>{$trader->hourly_rate}</span>"; ?>
                            </h6>
                            <?php echo  "<span class=\"badge rounded-pill bg-info\">" . $trader->category . "</span>"; ?>
                            <?php echo " <h5>Certifications: {$trader->professional_certification}<h5>" ?>
                            <i class="fa fa-regular fa-phone btn btn-success" aria-hidden="true"><?php echo " <span>{$trader->phone}" ?></i>
                            <i class="fa fa-envelope btn btn-success" aria-hidden="true"><?php echo " <span>{$trader->email}" ?></i>
                        </div>
                        <div class='col-md-6'>
                            <h4>Business Overview</h4>
                            <?php echo " <span>{$trader->description}</span>" ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>





        <div class='rounded col-md-12' id="select-dates">
            <div class="row">
                <div class="col-md-8">
                    <h4>Availability </h4>
                </div>
                <div class="col-md-4">
                    <button type="button" class="btn btn-outline-success mt-3 me-3">Available</button>
                    <button type="button" class="btn btn-danger disabled mt-3 me-3">Booked</button>
                    <button type="button" class="btn btn-light disabled mt-3 me-3">Not Available</button>
                </div>
            </div>
            <div class="div-available-dates">
                <?php
                for ($i = 1; $i <= 21; $i += 1) {
                    $date = new DateTime('+ ' . $i . ' day');
                    $day =  $date->format('l');
                    $dateVal = $date->format('d/m/Y');

                    if ($day == 'Saturday' || $day == 'Sunday') {
                        echo '<button type="button"  class="btn btn-light disabled mt-3 me-3"><span>' . $day . '<br/>' . $dateVal . '</span></button>';
                    } else
    if (in_array($dateVal, $bookedDates)) {
                        echo '<button type="button"  class="btn btn-danger disabled mt-3 me-3"><span>' . $day . '<br/>' . $dateVal . '</span></button>';
                    } else
                        echo '
                              <button type="button" id="' . $dateVal . '"  class="btn btn-outline-success mt-3 me-3" onclick="toggle(this)"><span>' . $day . '<br/>' . $dateVal . '</span>
                              </button>';
                }
                ?>
            </div>
            <input type="button" class="btn btn-success" onClick="submitBooking()" value="Book">
        </div>
        <div class="review-box  rounded shadow-box col-md-4" id="review-box">
            <?php include_once(dirname(__DIR__) . "/forms/rating.php"); ?>
        </div>
    </form>
</div>

<script>
    <?php include "../scripts/script.js" ?>
</script>