<aside class="sidebar">
  <section>
    <h2>Recent Posts</h2>
    <?php
    //get the latests 5 published posts and their comment count
    //TODO: make this show the posts that have 0 comments
    $query = "SELECT posts.title, COUNT(*) AS total, posts.post_id
    FROM posts, comments
    WHERE posts.post_id = comments.post_id
    AND posts.is_published = 1
    GROUP BY comments.post_id
    ORDER BY posts.date DESC
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
          <li><a href="single.php?post_id=<?php echo $row['post_id'] ?>"><?php echo $row['title']; ?></a> - (<?php echo $row['total']; ?>)</li>
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
      $query = "SELECT c.name, COUNT(*) AS total
      FROM categories AS c, posts
      WHERE c.category_id = posts.category_id
      GROUP BY posts.category_id
      ORDER BY c.name ASC
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
            <li><?php echo $row['name']; ?> (<?php echo $row['total']; ?>)</li>
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
