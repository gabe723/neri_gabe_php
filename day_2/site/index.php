<?php
//if the page is not set in the query string, set it to home
if( isset($_GET['page']) ){
  $current = $_GET['page'];
}else{
  $current = 'home';
}



?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>My Mini Site With Query String Vars | Home</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header>
    <h1>My Mini Site</h1>
    <nav>
      <ul>
        <li><a href="index.php?page=home">Home</a></li>
        <li><a href="index.php?page=about">About</a></li>
        <li><a href="index.php?page=contact">Contact</a></li>
      </ul>
    </nav>
  </header>
  <main>
    <?php
    switch ( $current ) {
      case 'home':
      include('includes/home-content.php');
      break;
      case 'about':
      include('includes/about-content.php');
      break;
      case 'contact':
      include ('includes/contact-content.php');
      break;
      default:
      echo 'Use the Navigation';
    }
    ?>
  </main>

  <footer>
    <p>&copy My Site</p>
  </footer>
</body>
</html>
