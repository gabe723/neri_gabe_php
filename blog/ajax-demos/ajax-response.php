<?php
/**
* Display Output
* This file has no doctype and will never leave the server.
* It simply runs a query and returns the text content for our interface.
*/
require('db-config.php');
//this variable will be sent to the file via JS or (in our URL window)
$category_id = $_REQUEST['cat_id']; //Trish says use GET instead becasue REQUEST pulls 3 sets of arrays(get, post, cookie), if the value keys are the same on two of them then then cookie will override get
//question about notices came up (which is why I added this)
//query to get all published posts from that category_id
//needs category id in order to run query
$query = "SELECT posts.title, posts.body, users.username
FROM posts, users
WHERE posts.user_id = users.user_id
AND posts.category_id = $category_id
ORDER BY date DESC
LIMIT 10";
$result = $db->query( $query );
if ( ! $result ) {
  // echo $query. '<br>';
  // echo $db->error;
  // // when I am done debugging...
  echo '<p>Pick a Category to view posts</p>';
}
$num = $result->num_rows;
$num_of_results = $num > 0 ? $num : '0';
?>
<h2><?php echo $num_of_results; ?> posts found</h2>
<?php
if ( $result->num_rows >= 1 ) {
  while ( $row = $result->fetch_assoc() ){
    ?>
    <article>
      <h3><?php echo $row['title'] ?></h3>
      <h4>by <?php echo $row['username']; ?></h4>
      <p><?php echo $row['body']; ?></p>
    </article>
    <?php
  } //end while
} //end if
?>
