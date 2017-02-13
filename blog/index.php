<?php
require('db-config.php');
//use _once on function definitions to prevent duplicates
include_once('functions.php');
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>My First Blog Using PHP</title>
  <link rel="stylesheet" href="style.css">
  <meta name=viewport content="width=device-width, initial-scale=1">
</head>
<body>
  <header>
    <h1>My First Blog Using PHP</h1>
  </header>
  <main>
    <?php
    //get the most recent 2 published posts
    $query = "SELECT title, date, category_id, body
    FROM posts
    WHERE is_published = 1
    ORDER BY date DESC
    LIMIT 2";
    //run the query, catch the returned info in a result object
    $db->query($query);
    $result = $db->query($query);
    //check to see if the result has rows (posts in this case)
    if ( $result->num_rows >= 1 ) {
      //loop through each row found, displaying the article each time
      while( $row = $result->fetch_assoc() ){
        ?>
        <article class="post">
          <h2><?php echo $row['title']; ?></h2>
          <div class="post-meta">Posted <?php echo convert_timestamp($row['date']); ?> in CATEGORY</div>
          <p><?php echo $row['body']; ?></p>
        </article>
        <?php
      }//end while there are posts
    }//end if there are posts
    else{
      echo 'Sorry, no posts to show.';
    }
    ?>
  </main>
  <aside class="sidebar">
    <section>
      <h2>Recent Posts</h2>
      <?php
      //get the 5 latest published post titles
      $query = "SELECT title
      FROM posts
      WHERE is_published = 1
      ORDER BY date DESC
      LIMIT 5";
      //run it
      $result = $db->query($query);
      //check it
      if ( $result->num_rows >=1 ) {
        ?>
        <ul>
          <?php
          //loop it
          while( $row = $result->fetch_assoc() ){
            ?>
            <li><?php echo $row['title']; ?></li>
            <?php
          }//end while
          //free it
          $result->free();
          ?>
        </ul>
        <?php }//end if there are posts
        else{
          echo 'There are currently no posts to show. Please check back later.';
        }
        ?>
      </section>
      <section>
        <h2>Categories</h2>
        <?php
        //get all category names in alphabetical order
        $query = "SELECT name
        FROM categories
        ORDER BY name ASC
        LIMIT 5";
        //run it
        $result = $db->query($query);
        //check it
        if ( $result->num_rows >=1 ) {
          ?>
          <ul>
            <?php
            //loop it
            while( $row = $result->fetch_assoc() ){
              ?>
              <li><?php echo $row['name']; ?></li>
              <?php
            }//end while
            //free it
            $result->free();
            ?>
          </ul>
          <?php }//end if there are categories
          else{
            echo 'There are currently no categories to show. Please check back later.';
          }
          ?>
        </section>
        <section>
          <h2>Links</h2>
          <?php
          //get all links in alphabetical order
          $query = "SELECT title, url
          FROM links
          ORDER BY title ASC
          LIMIT 5";
          //run it
          $result = $db->query($query);
          //check it
          if ( $result->num_rows >=1 ) {
            ?>
            <ul>
              <?php
              //loop it
              while( $row = $result->fetch_assoc() ){
                ?>
                <li><a href="<?php echo $row['url']; ?>"><?php echo $row['title']; ?></a></li>
                <?php
              }//end while
              //free it
              $result->free();
              ?>
            </ul>
            <?php }//end if there are links
            else{
              echo 'There are currently no links to show. Please check back later.';
            }
            ?>
          </section>
        </aside>
        <footer>
          <small>&copy; 2017 My PHP Blog</small>
        </footer>
      </body>
      </html>
      <?php
      //end the open DB connection
      $db->close();
      ?>
