<?php
require('db-config.php');
//use _once on function definitions to prevent duplicates
include_once('functions.php');
//get the doctype and header element
include_once('header.php');
//extract and sanitize the keywords that the user is searching footer
$keywords = clean_string( $_GET['keywords'] );
//pagination configuration
$per_page = 1;
//start on page 1
$current_page = 1;
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
  //how many posts were found?
  $total_posts = $result->num_rows;
  //check to see if the result has rows (posts in this case)
  if ( $result->num_rows >= 1 ) {
    //how many pages are needed to hold all the results?
    $total_pages = ceil( $total_posts / $per_page );
    //what page is the user trying to view?
    //URL will look like: search.php?keyword=cheese$page=2
    //if the ?page variable is not set, we are on page 1
    if ( $_GET['page'] ){
      $current_page = $_GET['page'];
    }
    //make sure they are viewing a valid page
    if ( $current_page <= $total_pages ) {
      echo "<h2>Search Results for $keywords</h2>";
      echo "<h3>Showing page $current_page of $total_pages</h3>";
      //modify the original query to get the right subset of results
      $offset = $current_page - 1 * $per_page;
      $query = $query . " LIMIT $offset, $per_page";
      //run the modified query
      $result = $db->query($query);
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
        $prev = $current_page - 1;
        $next = $current_page + 1;
        ?>
        <section class="pagination">
          <?php if ( $current_page != 1 ){ ?>
          <a href="search.php?keywords=<?php echo $keywords; ?>&amp;page=<?php echo $prev; ?>">Previous Page</a>
          <?php } //end if current page does not equal 1 ?>
          <?php if ( $current_page < $total_pages ){ ?>
          <a href="search.php?keywords=<?php echo $keywords; ?>&amp;page=<?php echo $next; ?>">Next Page</a>
          <?php } //end if current page is less than total pages ?>
        </section>
        <?php
      }//end if the user is on a valid page
      else{
        echo 'This is an invalid page.';
      }
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
