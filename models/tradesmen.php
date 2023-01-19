<?php
include_once(dirname(__DIR__) . '/common/helper.php');
include_once('user.php');

class Tradesmen extends User
{
  public $tradesmen_id;
  public $hourly_rate;
  public $rating;
  public $review;
  public $category;
  public $professional_certification;
  public $skills;
  public $description;
  public $profile_image;
  public $recent_works_images;

  function __construct() {
    $this->hourly_rate = 0;
  }
 
  function getProfileDetails($user_id)
  {
    $q = "select * from view_tradesmen where user_id='" . $user_id . "'";
    $r = ExecuteQuery($q);
    return $r;
  }
  function getTraderList($category_id, $location_id)
  {

    $q = "select * from view_tradesmen t left join  view_ratings  r on  t.user_id=r.tradesmen_id where  1=1 ";
    if ($category_id != 0) {
      $q .= " and t.category_id=" . $category_id . "";
    };
    if ($location_id != 0) {
      $q .= " and t.location_id=" . $location_id . "";
    };
    $r = ExecuteQuery($q);
    $rowcount = $r->num_rows;
    return $r;
  }
 
  function getRatings($tradesmen_id)
  {

    $q = "select * from temprating left join  (select rating,count(rating)as count from ratings where tradesmen_id=" . $tradesmen_id . " group by rating) as b on b.rating=temprating.ind order by ind desc;";
    $r = ExecuteQuery($q);
    return $r;
  }
 
  function getRatingSummary($tradesmen_id)
  {

    $q = "select count(rating) as count , floor(avg(rating)) as rating  from ratings where tradesmen_id=" . $tradesmen_id . "";
    $r = ExecuteQuery($q);
    return $r;
  }
  function getRatingsList($tradesmen_id)
  {

    $q = "select u.name,r.rating,r.review  from user u join  ratings r on r.customer_id=u.user_id where  tradesmen_id=" . $tradesmen_id . " ;";
    $r = ExecuteQuery($q);
    return $r;
  }
  function updateTradesmen($tradesmen)
  {

    $q = "UPDATE tradesmen SET category_id =" . $tradesmen->category . " ,hourly_rate =" . $tradesmen->hourly_rate . ", description ='" . $tradesmen->description . "' , professional_certification ='" . $tradesmen->professional_certification . "', skills ='" . $tradesmen->skills . "', profile_image_path='".$tradesmen->profile_image."' WHERE user_id =" . $tradesmen->user_id . "  ";
    $r1 = ExecuteNonQuery($q);
    $q = "UPDATE user SET name ='" . $tradesmen->name . "',phone ='" . $tradesmen->phone . "' ,email ='" . $tradesmen->email . "' ,password ='" . $tradesmen->password . "', location_id =" . $tradesmen->location . "  WHERE user_id =" . $tradesmen->user_id . "; ";
    $r2 = ExecuteNonQuery($q);
    if ($r1 == 1 || $r2 == 1)
      return 1;
    else return 0;
  }
  function saveRating($tradesmen, $customer_id)
  {

    $q = "INSERT INTO ratings(tradesmen_id,customer_id,rating,review)VALUES(" . $tradesmen->tradesmen_id . " ," . $customer_id . " ," . $tradesmen->rating . " ,'" . $tradesmen->review . "');";
    $r = ExecuteNonQuery($q);
    return $r;
  }
}
