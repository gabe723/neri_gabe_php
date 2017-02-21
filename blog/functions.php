<?php
//a function to convert ugly timestamps to human-friendly dates
function convert_timestamp( $ugly ){
  $date = new DateTime( $ugly );
  echo $date->format('l, jS, F, o');
}

//a function to convert ugly time rss to human-friendly rss
function convert_timerss( $ugly ){
  $date = new DateTime( $ugly );
  echo $date->format('r');
}

//sanitize functions: extract the values that the user typed in and sanitize
function clean_string( $untrusted ){
  global $db;
  return mysqli_real_escape_string($db, filter_var( $untrusted, FILTER_SANITIZE_STRING ));
}

function clean_integer( $untrusted ){
  global $db;
  return mysqli_real_escape_string($db, filter_var( $untrusted, FILTER_SANITIZE_NUMBER_INT ));
}

function clean_email( $untrusted ){
  global $db;
  return mysqli_real_escape_string($db, filter_var( $untrusted, FILTER_SANITIZE_EMAIL ));
}

function clean_url( $untrusted ){
  global $db;
  return mysqli_real_escape_string($db, filter_var( $untrusted, FILTER_SANITIZE_URL ));
}
//DO NOT CLOSE PHP HERE!
