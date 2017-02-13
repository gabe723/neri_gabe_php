<?php
$host = 'localhost';
$username = 'gabe_blog';
$password = 'j8apjGY77vbcjAw5';
$database = 'gabe_blog';
//connect to database
$db = new mysqli( $host, $username, $password, $database );
//check to make sure it worked
if ( $db->connect_errno > 0 ) {
  die( 'Cannot connect to Database.');
}
