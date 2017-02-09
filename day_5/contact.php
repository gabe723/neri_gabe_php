<?php
error_reporting( E_ALL & ~ E_NOTICE );

//useful function for highlighting fields with errors
//$field is a tring that should match the name of the field input
//$array is an array of error messages
function error_highlight( $field, $array ){
  if ( isset($array) ) {
    if ( array_key_exists( $field, $array ) ) {
      echo 'class="error"';
    }
  }
}
//parse the form if the user submitted it
if ( $_POST['did_send']) {
  //extract a;; the data that was inputed by user
  //sanatize all data
  $name       = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
  $email      = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
  $phone      = filter_var($_POST['phone'], FILTER_SANITIZE_NUMBER_INT);
  $reason     = filter_var($_POST['reason'], FILTER_SANITIZE_STRING);
  $message    = filter_var($_POST['message'], FILTER_SANITIZE_STRING);
  $newsletter = filter_var($_POST['newsletter'], FILTER_SANITIZE_STRING);

  /***validate each field***/
  $valid = true;

  //test each way the form could fail
  //empty name field
  if ($name == '') {
    $valid = false;
    $errors['name'] = 'The name field is required.';
  }
  //empty email field, invalid format
  if ( ! filter_var($email, FILTER_VALIDATE_EMAIL) ) {
    $valid = false;
    $errors['email'] = 'Please provide a valid email address.';
  }
  //check reason input to make sure given it is NOT on the list of choices
  $allowed_reasons = array( 'help', 'hi', 'bug' );
  if ( ! in_array($reason, $allowed_reasons) ) {
    $valid = false;
    $errors['reason'] = 'Please choose one of the choices from the list';
  }
  //make sure checkbox can only result in true or false
  if ( $newsletter != true ) {
    $newsletter = false;
  }
  //end validation

  if ( $valid ) {
    //send the mail!
    $to = 'gneri723@gmail.com';
    $subject = 'A contact form submission from' . $name;

    $body = "Email Address: $email\n";
    $body .= "Phone Number: $phone\n";
    $body .= "Reason for contacting me: $reason\n";
    $body .= "Subscribe to the newsletter? $newsletter\n\n";
    $body .= "$message\n\n";

    $headers = "From: no-reply@gabeneri.com\r\n";
    $headers .= "Reply-to: $email\r\n";
    $headers .= "Bcc: gneri723@gmail.com";

    $mail_sent = mail($to. $subject, $body, $headers);
  } //end if valid

  //give user feedback message
  if ($mail_sent) {
    $class = 'success';
    $feedback = 'Thank you for contacting me, I will get back to you shortly.';
  }else{
    $class = 'error';
    $feedback = 'Something went wrong, message cannot be sent.';
  }
} //end parser
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Contact Me</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <h1>Contact Me</h1>
  <?php
  if ( isset($feedback) ) {
    echo '<div class="feedback ' . $class . '">';
    echo $feedback;

    //if there are errors, show them
    if ( ! empty($errors) ) {
      echo '<ul class="error-list-ul">';
      foreach ($errors as $error) {
        echo '<li class="error-list-li">';
        echo $error;
        echo '</li>';
      }
      echo '</ul>';
    }
    echo '</div>';
  }
  ?>
  <form class="form-contact" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" novalidate>

    <label for="the_name">Your Name:</label>
    <input id="the_name" type="text" name="name" value="<?php echo $name; ?>" <?php error_highlight( 'name', $errors ); ?> autofocus required>

    <label for="the_email">Email Address:</label>
    <input id="the_email" type="email" name="email" value="<?php echo $email; ?>" <?php error_highlight( 'email', $errors ); ?> required>

    <label for="the_phone">Phone Number:</label>
    <input id="the_phone" type="tel" name="phone" value="<?php echo $phone; ?>">

    <label for="the_reason">How can I help you?</label>
    <select id="the_reason" name="reason" <?php error_highlight( 'reason', $errors ); ?> required>
      <option>Choose an Option</option>
      <option value="help" <?php if ( $reason == 'help') {
        echo 'selected';
      } ?>>Help me!</option>
      <option value="hi" <?php if ( $reason == 'hi') {
        echo 'selected';
      } ?>>Hi!</option>
      <option value="bug" <?php if ( $reason == 'bug') {
        echo 'selected';
      } ?>>Hey, you there!</option>
    </select>

    <label for="the_message"></label>
    <textarea id="the_message" name="message"><?php echo $message; ?></textarea>

    <label>
      <input type="checkbox" name="newsletter" value="true" <?php if ( $newsletter ) {
        echo 'checked';
      } ?>>
      Yes! Sign me up Scotty!
    </label>

    <input type="submit" name="submit" value="Send Message">
    <input type="hidden" name="did_send" value="true">


  </form>
</body>
</html>
