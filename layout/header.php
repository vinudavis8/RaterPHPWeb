<?php session_start();
//$base_url = 'http://localhost:4433/Rater';
$base_url='https://homepages.shu.ac.uk/~c1056386/Rater/'

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Rater</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <style>
    <?php
    include_once(dirname(__DIR__) . '/css/style.css'); ?>
  </style>
  <style>
  </style>
</head>

<body>
  <nav class="navbar navbar-expand-sm bg-dark navbar-dark ">
    <div class=" nav-div ">
      <a class="" href="<?php echo $base_url . '/index.php' ?>">
        <img src="<?php echo $base_url . '/images/logoRater.jpg' ?>" alt="Logo"  class="logo-rater">
      </a>
    </div>
    <div class="col-md-10">
      <?php
      if (isset($_SESSION['logged_in_user_id'])) {
        $user_type =  $_SESSION['logged_in_user_type'];
        $logged_in_user_name = $_SESSION['logged_in_user_name'];
        echo '<span class="nav-items login-user">Welcome ' . $logged_in_user_name . '
        <a class="btn btn-danger nav-items " href="' . $base_url . '/forms/logout.php">Logout</a>
        </span>
        <a class="navbar-brand nav-items" href="#">
        <img src="' . $base_url . '/images/img_avatar.png" alt="Logo" style="width:40px;" class="rounded-pill">
        </a>';

        if ($user_type == 'customer') {
          echo " <a class=\"navbar-brand nav-items\" href=\"$base_url/forms/user_bookings.php\"> View Bookings</a>";
        } else
        if ($user_type == 'tradesmen') {
          echo " <a class=\"navbar-brand nav-items\" href=\"$base_url/forms/tradesmen_bookings.php\">View Bookings</a>";
        }
        if ($user_type == 'admin') {
          echo " <a class=\"navbar-brand nav-items\" href=\"$base_url/forms/create_category.php\">Create Category</a>";
        }
      } else {
        echo ' 
        <button type="button" class="btn btn-success nav-items" data-bs-toggle="modal" data-bs-target="#myModal">
        Login/Register
        </button>';
      }
      ?>
    </div>
  </nav>