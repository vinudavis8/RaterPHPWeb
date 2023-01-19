<?php
session_start();
unset($_SESSION["logged_in_user_id"]);
unset($_SESSION["logged_in_user_name"]); 
unset($_SESSION["logged_in_user_type"]); 
header("Location:../index.php");
?>