<?php
$host = 'localhost';
$username = 'gabe_blog';
$password = 'j8apjGY77vbcjAw5';
$database = 'gabe_blog';
//connect to database
$db = new mysqli( $host, $username, $password, $database );
//if there was a problem connecting, kill the page
if ( $db->connect_errno > 0 ) {
  die( 'Cannot connect to Database.' . $db->connect_error );
}
//hide notices
error_reporting( E_ALL & ~ E_NOTICE );
