<?php
//a function to convert ugly timestamps to human-friendly dates
function convert_timestamp( $ugly ){
  $date = new DateTime( $ugly );
  echo $date->format('l, jS, F, o');
}
