<?php
include_once(dirname(__DIR__) . '/common/helper.php');
class User
{
  public  $user_id;
  public  $name;
  public  $user_type;
  public  $location;
  public  $phone;
  public  $email;
  public  $password;
  public $category;

  function login($email, $password)
  {
    $q = "SELECT * FROM user where email='" . $email . "' and password='" . $password . "'";
    $r = ExecuteQuery($q);
    $rowcount = $r->num_rows;
    return $r;
  }
  function checkUsernameAvailable($email)
  {
    $q = "SELECT count(*) as count FROM user where email='" . $email . "'";
    $result = ExecuteQuery($q);
    $row = mysqli_fetch_assoc($result);
    return  $row['count'];
  }

  function register( $user)
  {
    $response = "";
    $email_count = $this->checkUsernameAvailable( $user->email);
    if ($email_count > 0) {
      $response = "Registration failed..!Another user already exist with this email";
      return $response;
    }
    $q = "INSERT INTO user (name,phone,user_type,location_id,email,password) VALUES('" .  $user->name . "','" .  $user->phone . "','" .  $user->user_type . "'," .  $user->location . ",'" .  $user->email . "','" .  $user->password . "');";
    $user_id = ExecuteScalar($q);
    if ( $user->user_type == "tradesmen") {
      $q = "INSERT INTO tradesmen (user_id,category_id) VALUES('" . $user_id . "','" .  $user->category . "');";
      $r = ExecuteNonQuery($q);
      $response = "Registration Successfull...!";
      return $response;
    } else {
      if ($user_id > 0) {
        $response = "Registration Successfull";
        return $response;
      }
    }
  }
}
