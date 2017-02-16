<?php
require('db-config.php');
//use _once on function definitions to prevent duplicates
include_once('functions.php');
//get the doctype and header element
include_once('header.php');

//extract and sanitize the keywords that the user is searching footer
$keywords = clean_string( $_GET['keywords'] );
?>
<main id="content">
  <?php
  //get all the published posts that contain the keywords in their title or body
  $query = "SELECT DISTINCT *
  FROM posts
  WHERE is_published = 1
  AND ( title LIKE '%$keywords%' OR body LIKE '%$keywords%' )";
  //run the query, catch the returned info in a result object
  $result = $db->query($query);
  //check to see if the result has rows (posts in this case)
  if ( $result->num_rows >= 1 ) {
    //loop through each row found, displaying the article each time
    while( $row = $result->fetch_assoc() ){
      ?>
      <article class="post">
        <a href="single.php?post_id=<?php echo $row['post_id'] ?>"><h2><?php echo $row['title']; ?></h2></a>
        <div class="post-meta">
          <?php echo convert_timestamp($row['date']); ?>
        </article>
        <?php
      }//end while there are posts
    }//end if there are posts
    else{
      echo 'Sorry, no posts to show.';
    }
    ?>
    <a href="blog.php">Read All Posts</a>
  </main>
  <?php
  //get the aside element
  include_once('aside.php');
  ?>
  <?php
  //get the footer element and close the open body and html tags
  include_once('footer.php');
  ?>
