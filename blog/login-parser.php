<?php
//begin or resume the session
session_start();
//hide notices because they are ugly
error_reporting( E_ALL & ~ E_NOTICE );
//connect to DB
require('db-config.php');
include_once('functions.php');
//begin parsing the form if the user submitted it
if( $_POST['submitted_login']){
  //sanitize the values the user typed in:
  $username = clean_string( $_POST['username'] );
  $password = clean_string( $_POST['password'] );
  if ( strlen($username) >= 5 AND strlen($username) <= 50 AND strlen($password) >= 8 ) {
    //check DB for this user
    $password = sha1( $password . SALT );
    $query = "SELECT user_id, is_admin FROM users WHERE username = '$username' AND password = '$password' AND is_approved = 1 LIMIT 1";
    $result = $db->query($query);
    if ( $result->num_rows == 1 ) {
      //remember the user for one week
      setcookie('logged_in_cookie', true, time() + 60 * 60 * 24 * 7 );
      $_SESSION['logged_in_session'] = true;
      //send to secret page
      header('location:admin');
    }else{
      //show error message
      $feedback = 'The information that was entered is incorrect. Please try again.';
    }
  }else{
    //show correct message
    $feedback = 'Username or password is not the correct length.';
  } //end of validation
} //end of form parser
//is the user trying to log out?
if ( $_GET['action'] == 'logout' ) {
  // Unset all of the session variables.
  $_SESSION = array();
  // If it's desired to kill the session, also delete the session cookie.
  // Note: This will destroy the session, and not just the session data!
  if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
    $params["path"], $params["domain"],
    $params["secure"], $params["httponly"]
  );
}
//destroy the session
session_destroy();
//force cookies to expire
setcookie('logged_in_cookie', '', time() - 9999999);
} //end of logout logic
//do not close php when the document only contains php
