<?php
//require same as include except if the code fails the page is killed
require('login-parser.php'); ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Login System</title>
</head>
<body>
  <?php
  //Lets you look at the post array (wrap in <pre> tag for better reading)
  // print_r($_POST);?>
  <h1>Log In to your account.</h1>
  <?php echo $feedback; ?>
  <form class="form-login" action="login.php" method="post">
    <label for="login-username">Username:</label>
    <input id="login-username" type="text" name="username" value="" autofocus required>
    <label for="login-password">Password:</label>
    <input id="login-password" type="password" name="password" value="" required>
    <input type="submit" name="submit" value="Log In">
    <input type="hidden" name="submitted_login" value="true">
  </form>
</body>
</html>
