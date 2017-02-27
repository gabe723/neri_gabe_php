<?php
$host = 'localhost';
$username = 'gabe_blog';
$password = 'j8apjGY77vbcjAw5';
$database = 'gabe_blog';
//connect to database
$db = new mysqli( $host, $username, $password, $database );
//if there was a problem connecting, kill the page
if ( $db->connect_errno > 0 ) {
  die( 'Cannot connect to the Database.' . $db->connect_error );
}
//hide notices
error_reporting( E_ALL & ~ E_NOTICE );
/***CONFIDENTIAL global salt for making our passwords stronger.CONFIDENTIAL***/
define('SALT', 'ohsdoh!&*fodhfodjqwpjkojlpo1-o-ok1o-k-lkaplp;;ajlnlqiio');
