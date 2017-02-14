<?php
//display the message if the user’s age is at least 21
$message = 'hooray! Your are over 21'
$age = $_GET['age'];

if ( $age >= 21) {
  echo $message;
}
?>

<?php
//redirect the user to the file ‘secret-page.php’ if they are logged in. The session variable ‘loggedin’ will be true if they are logged in
session_start();
$logged_in = $_SESSION['loggedin'];

if ( $logged_in == true) {
  header('location:secret-page.php');
}
?>

<?php
//display a success message if the score is higher than the high score. otherwise, show an error message.
$score = $_COOKIE['score'];
$high_score = 45,897,146,526;

if ( $score > $high_score ) {
  $feedback = 'Success!';
}else{
  $feedback = 'Failure!';
}
?>

<?php
//display a different message for each day of the week.  ( use php.net to look up what date(’w’) means)
$day = date('w');

if ( $day ) {
  switch ( $day ) {
    case 0:
    $feedback = "Ahh fuck Mondays!"
    break;

    case 1:
    $feedback = "Ahh fuck Tuesdays!"
    break;

    case 2:
    $feedback = "Ahh fuck Wednesdays!"
    break;

    case 3:
    $feedback = "Ahh fuck Thursdays!"
    break;

    case 4:
    $feedback = "Ahh fuck thank god its fucking Friday baby!!"
    break;

    case 5:
    $feedback = "Ahhhhh Saturday..the best of days."
    break;

    case 6:
    $feedback = "Ahhhhh Sundays..my fav!"
    break;

    default:
    $feedback = "The day is incorrect?"
    break;
  }
  echo $feedback;
}
?>

<?php
//The vote represents whether a user answered ‘yes’ or ‘no’; Add one to the count if the vote is ‘yes’; Add one to the total regardless of whether the user voted ‘yes’ or ‘no’
$vote = $_GET['vote'];
$count = 0;
$total = 0;

if ( $vote == 'yes' ) {
  $count ++;
  $total ++;
}else{
  $total ++;
}
?>
