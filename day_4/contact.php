<?php
error_reporting( E_ALL & ~ E_NOTICE );
//parse the form if the user submitted it
if ( $_POST['did_send']) {
  //extract a;; the data that was inputed by user
  //TODO: sanatize all data
  $name       = $_POST['name'];
  $email      = $_POST['email'];
  $phone      = $_POST['phone'];
  $reason     = $_POST['reason'];
  $message    = $_POST['message'];
  $newsletter = $_POST['newsletter'];
  //TODO: validate each field
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

    //preview what the body of the email is
    echo '<pre>';
    echo $body;
    echo '<pre>';

    echo '</div>';
  }
  ?>
  <form class="form-contact" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">

    <label for="the_name">Your Name:</label>
    <input id="the_name" type="text" name="name" autofocus required>

    <label for="the_email">Email Address:</label>
    <input id="the_email" type="email" name="email" required>

    <label for="the_phone">Phone Number:</label>
    <input id="the_phone" type="tel" name="phone">

    <label for="the_reason">How can I help you?</label>
    <select id="the_reason" name="reason" required>
      <option selected value="">Choose an Option</option>
      <option value="help">Help me!</option>
      <option value="hi">Hi!</option>
      <option value="bug">Hey, you there!</option>
    </select>

    <label for="the_message"></label>
    <textarea id="the_message" name="message"></textarea>

    <label>
      <input type="checkbox" name="newsletter" value="true">
      Yes! Sign me up Scotty!
    </label>

    <input type="submit" name="submit" value="Send Message">
    <input type="hidden" name="did_send" value="">


  </form>
</body>
</html>
