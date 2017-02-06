<?php
//define variables at the top right chiah
$username = 'Gabe';
$favoritenumber = 3;
$favoritenumber ++;
$favoritenumber += 10;
$favoritenumber = $favoritenumber + 1;

//define a really simple function
function todays_date(){
  echo '<br>';
  echo date('l, jS, F, o');
}

//a function to convert ugly timestamps to human-friendly dates
function convert_timestamp( $ugly ){
  $date = new DateTime( $ugly );
  echo $date->format('l, jS, F, o');
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>My First PHP Doc</title>
  <style type="text/css">
  body{
    color: purple;
    width: 50%;
    margin: 0 auto;
  }
  h2{
    color: yellow;
  }
  li{
    display: inline-block;
    background-color: green;
  }
  a.menu-item{
    padding: .5em;
    list-style-type: none;
  }
  a{
    text-decoration: none;
  }
  </style>
</head>
<body>
  <h1>My First PHP Doc</h1>
  <?php convert_timestamp('2017-02-03'); ?>
  <?php include('nav.php'); ?>
  <?php echo '<h2>Hello, ' . $username . '</h2>';
  // We have escaped into PHP mode
  echo '<p>Your favorite number is now ' . $favoritenumber . '</p>';
  ?>
  <P> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</P>
</body>
</html>
