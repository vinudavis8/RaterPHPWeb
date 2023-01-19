<?php
include_once(dirname(__DIR__) . '/common/helper.php');

class Bookings
{

  public $booking_id;
  public $customer_id;
  public $tradesmen_id;
  public $booking_date;
  public $status;

  function __construct() {
    $this->status = "Pending";
  }

  function getAvailableDates($tradesmen_id)
  {
    $q = "select DATE_FORMAT(booking_date,'%d/%m/%Y')booking_date from bookings where tradesmen_id=" . $tradesmen_id . " and booking_date>CURDATE();";
    $r = ExecuteQuery($q);
    return $r;
  }
 
  function getTradesmenBookingList($tradesmen_id)
  {
    $q = "select b.booking_date,u.name,b.status,b.booking_id from bookings b  join  user u on u.user_id=b.customer_id where  b.tradesmen_id=".$tradesmen_id.";";
    $r = ExecuteQuery($q);
    return $r;
  }

  
  function createBooking($booking)
  {
    $q = "INSERT INTO bookings(customer_id,tradesmen_id,booking_date,status) VALUES('" . $booking->customer_id . "','" . $booking->tradesmen_id . "', STR_TO_DATE('" . $booking->booking_date . "','%d/%m/%Y'),'".$booking->status."');";
    $r = ExecuteNonQuery($q);
    return $r;
  }
  function updateBooking($booking)
  {
    $q = "update bookings set rating=" . $booking->rating . " where booking_id=" . $booking->booking_id . ";";
    $r = ExecuteNonQuery($q);
    return $r;
  }
  function saveBookingStatus($booking_id)
  {
    $q = "update bookings set status='Completed' where booking_id=" .$booking_id . ";";
    $r = ExecuteNonQuery($q);
    return $r;
  }
  function getCompletedBookings($tradesmen_id,$customer_id)
  {
    $q = "select count(*)as count from bookings where   customer_id=".$customer_id." and tradesmen_id= ".$tradesmen_id."";
    $r = ExecuteQuery($q);
    return $r;
  }
}
