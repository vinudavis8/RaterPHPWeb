<?php
include_once(dirname(__DIR__) . "/models/user.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  $email = $_POST["email"];
  $password = $_POST["pass"];
  $user = new User();
  $result = $user->login($email, $password);
  if (mysqli_num_rows($result) === 1) {
    session_start();
    $row = mysqli_fetch_assoc($result);
    $_SESSION['logged_in_user_id'] = $row['user_id'];
    $_SESSION['logged_in_user_name'] = $row['name'];
    $_SESSION['logged_in_user_type'] = $row['user_type'];

    echo $row['user_type'];
    exit();
  } else {
    echo 'failed';
    exit();
  }
} else {
}
?>

<!-- The Modal -->
<div class="modal" id="myModal">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <!-- Modal body -->
      <div class="modal-body">
        <div class="alert alert-danger" style="display:none">
          <strong>Login failed!</strong>
          <span id="message"></span>
        </div>
        <div class="alert alert-success" style="display:none">
          <strong>Login failed!</strong>
          <span id="messageSucess"></span>
        </div>
        <div class="form-floating mb-3">
          <input type="email" required class="form-control floating-input" id="email" placeholder="name@example.com">
          <label for="email">Email address</label>
          <span id="error-username" class="error-msg"></span>
        </div>
        <div class="form-floating">
          <input type="password" class="form-control floating-input" id="pass" placeholder="Password">
          <label for="pass">Password</label>
          <span id="error-password" class="error-msg"></span>
        </div>
        <input type="button" class="btn btn-success col-md-12 form-control mt-3" value="Login" onclick="checkLoginDetails()">
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-success col-md-12 form-control mt-3" data-bs-dismiss="modal">
   
  </button> -->Not a member?
        <a href="./forms/register.php" class="class=" text-center""> Signup</a>
        <!-- <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button> -->
      </div>
    </div>
  </div>
</div>
<script>
    document.onkeydown=function(evt){
        var keyCode = evt ? (evt.which ? evt.which : evt.keyCode) : event.keyCode;
        if(keyCode == 13)
        {
          checkLoginDetails();
        }
    }
</script>