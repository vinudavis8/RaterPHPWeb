<?php 
include "../layout/header.php";
include_once "../models/bookings.php";
if (!session_id()) session_start();
$bookings = new Bookings();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $booking_id = $_POST["booking_id"];
    $result = $bookings->saveBookingStatus($booking_id);
}
?>

<div class="container  mt-3 grid-div">
    <table class="table">
        <thead class="table-success">
            <tr>
                <th>Customer</th>
                <th>Booking Date</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $user_id = $_SESSION['logged_in_user_id'];
            $result = $bookings->getTradesmenBookingList($user_id);
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                echo "<tr>
                      <td>" . $row["name"] . "</td>
                      <td>" . $row["booking_date"] . "</td>
                      <td>" . $row["status"] . "</td>
                      <td> ";

                if ($row["status"] == "Pending") {
                    echo "  <button   class='btn btn-success' onclick='saveBookingStatus(" . $row["booking_id"] . ")' >Completed</button>   ";
                }
                echo "  </td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php include "../layout/footer.php" ?>
<script>
    <?php include "../scripts/script.js" ?>
</script>