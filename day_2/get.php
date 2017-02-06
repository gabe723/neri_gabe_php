<?php
//hide notices
error_reporting( E_ALL & ~E_NOTICE );
//begin form parser
//extract the data
$name      = $_GET['name'];
$breakfast = $_GET['breakfast'];
$submitted = $_GET['submitted']
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Get</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <h1>Thanks for taking my survey!</h1>

  <?php
  if ( $submitted ) {
    if ( $name and $breakfast ) {
      echo "Thanks " . $name . ", " . $breakfast . " sounds delish!";
    }else{
      echo "Please fill in both fields";
    }
  }
  ?>

  <p>Answer these questions, damn you!</p>

  <form class="survey-form" action="get.php" method="get">
    <label for="input-name">What's your name?</label>
    <input id="input-name" type="text" name="name" value="">
    <label for="input-breakfast">What is your favorite breakfast food?</label>
    <input id="input-breakfast" type="text" name="breakfast" value="">
    <input type="submit" name="submit" value="Submit">

    <input type="hidden" name="submitted" value="true">
  </form>

</body>
</html>
