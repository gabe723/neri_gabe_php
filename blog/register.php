<?php
require('db-config.php');
include_once('functions.php');
//begin parser
if ( $_POST['did_register'] ) {
  //sanitize all user input data
  $username = clean_string( $_POST['username'] );
  $email = clean_string( $_POST['email'] );
  $password = clean_string( $_POST['password'] );
  $policy = clean_string( $_POST['policy'] );
  //validate the following*:
  $valid = 1;
  /*username wrong length*/
  if ( strlen($username) < 5 OR strlen($username) > 50 ) {
    $valid = 0;
    $errors['username'] = 'Choose a username between 5 and 50 characters long.';
  }else{
    /*username already taken*/
    $query = "SELECT username FROM users WHERE username = '$username' LIMIT 1";
    $result = $db->query($query);
    if ( $result->num_rows == 1 ) {
      $valid = 0;
      $errors['username'] = 'Sorry, that username is already in use. Choose another.';
    }
  }
  /*password wrong length*/
  if ( strlen($password) < 8 ) {
    $valid = 0;
    $errors['password'] = 'Your password needs to be at least 8 characters.';
  }
  /*email bad format*/
  if ( ! filter_var($email, FILTER_VALIDATE_EMAIL) ) {
    $valid = 0;
    $errors['email'] = 'Please provide a valid email.';
  }else{
    /*email already taken*/
    $query = "SELECT email FROM users WHERE email = '$email' LIMIT 1";
    $result = $db->query($query);
    if ( $result->num_rows == 1 ) {
      $valid = 0;
      $errors['email'] = 'That email is already registered.';
    }
  }
  /*policy box not checked*/
  if ( $policy != 1 ) {
    $valid = 0;
    $errors['policy'] = 'Please agree to our terms before signing up.';
  }
  //if valid, add the user to the users table!
  if ( $valid ) {
    //add salt to make it harder to hack passwords
    $password = sha1($password . SALT);
    $query = "INSERT INTO users ( username, password, email, is_admin, is_approved ) VALUES ( '$username', '$password', '$email', 0, 0 )";
    $result = $db->query($query);
    //if it worked, tell them to wait for confirmation, redirect to login
    if ( $db->affected_rows == 1 ) {
      $feedback = 'You are now signed up! As soon as you are approved by an admin, you can log in!';
    }else{
      //if it failed, show the user feedback
      $feedback = 'Sorry, your account was not created. Try again later.';
    }
  }//end if valid
  else{
    $feedback = 'There where errors in the form submission, please fix the highlighted areas.';
  }
}//end parser
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Sign up for an account</title>
  <link rel="stylesheet" href="admin/css/admin-style.css">
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">
</head>
<body class="login">
  <h1>Create an Account</h1>
  <?php if ( isset($feedback) ) {
    echo '<div class="feedback">';
    echo $feedback;
    //if there are errors, show them as a lists
    if ( ! empty($errors) ) {
      echo '<ul>';
      foreach ( $errors as $error ) {
        echo '<li>' . $error . '</li>';
      }
      echo '</ul>';
    }
    echo '</div>';
  } ?>
  <form class="form-account" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
    <label for="the_username">Choose a Username</label>
    <input type="text" id="the_username" name="username">
    <span class="hint">*Between 5 - 50 characters</span>
    <label for="the_email">Your Email Address</label>
    <input type="email" id="the_email" name="email">
    <label for="the_password">Choose a Password</label>
    <input type="password" id="the_password" name="password">
    <span class="hint">*At least 8 characters</span>
    <label>
      <input type="checkbox" name="policy" value="1">
      I agree to the <a href="#" target="_blank" rel="noopener">Terms of Service</a> and the <a href="#" target="_blank" rel="noopener">Privacy Policy.</a>
    </label>
    <input type="submit" value="Sign Up">
    <input type="hidden" name="did_register" value="1">
  </form>
</body>
</html>
