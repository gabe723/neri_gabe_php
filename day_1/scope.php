<?php
$number = 7;
function add_ten( $num ){
  return $num += 10;
}
add_ten($number);
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Scope</title>
  </head>
  <body>
    <?php echo $number; ?>
  </body>
</html>
