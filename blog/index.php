<?php
require('db-config.php');
//use _once on function definitions to prevent duplicates
include_once('functions.php');
//get the doctype and header element
include_once('header.php');
?>
<main id="content">
  <?php
  //get the most recent 2 published posts and the category names
  $query = "SELECT posts.title, posts.date, categories.name, posts.body, users.username, posts.post_id
  FROM posts, categories, users
  WHERE posts.is_published = 1
  AND posts.category_id = categories.category_id
  AND posts.user_id = users.user_id
  ORDER BY posts.date DESC
  LIMIT 2";
  //run the query, catch the returned info in a result object
  $result = $db->query( $query );
  //check to see if the result has rows (posts in this case)
  if ( $result->num_rows >= 1 ) {
    //loop through each row found, displaying the article each time
    while( $row = $result->fetch_assoc() ){
      ?>
      <article class="post">
        <a href="single.php?post_id=<?php echo $row['post_id'] ?>"><h2><?php echo $row['title']; ?></h2></a>
        <div class="post-meta">
          By <?php echo $row['username']; ?> on <?php echo convert_timestamp($row['date']); ?> in <?php echo $row['name']; ?></div>
          <p><?php echo $row['body']; ?></p>
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
