<?php include "../layout/header.php";
include_once "../models/customer.php";
if (!session_id()) session_start();
?>

<div class="container  mt-3 grid-div">
  <table class="table">
    <thead class="table-success">
      <tr>
        <th>Tradesmen</th>
        <th>Booking Date</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $customer = new Customer();
      $user_id = $_SESSION['logged_in_user_id'];
      $result = $customer->getBookingList($user_id);   //get list of bookings of customers
      while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        echo 
          "<tr>
          <td>" . $row["name"] . "</td>
          <td>" . $row["booking_date"] . "</td>
          <td>" . $row["status"] . "</td>
          </tr>";
      }
      ?>
    </tbody>
  </table>
</div>

<?php include "../layout/footer.php" ?>
<script>
  <?php include "../scripts/script.js" ?>
</script>