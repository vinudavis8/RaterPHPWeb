<?php
include_once(dirname(__DIR__) . '/common/helper.php');
include_once('user.php');

class Customer extends User
{


    function getBookingList($customer_id)
    {
      $q = "select b.booking_date,u.name,ifnull(b.status,'Pending')as status from bookings b  join  user u on u.user_id=b.tradesmen_id where  b.customer_id=".$customer_id.";";
      $r = ExecuteQuery($q);
      return $r;
    }
    function getCustomerRatingsCount($tradesmen_id,$customer_id)
    {
  
      $q = "select count(*) as count from ratings where customer_id=" . $customer_id . " and tradesmen_id=" . $tradesmen_id . " ;";
      $r = ExecuteQuery($q);
      return $r;
    }
}