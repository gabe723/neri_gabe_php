<?php
session_start();
require('../db-config.php');
include_once('../functions.php');
//header contains the security check, doctype, and <header> element
include('admin-header.php');
include('admin-nav.php');
//parse the form!
include('admin-write-parser.php');
?>
<main role="main">
  <section class="panel important">
    <h2>Write Post</h2>
    <?php show_feedback( $feedback, $errors ); ?>
    <form class="form-write-post" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
      <div class="twothirds">
        <label>Title</label>
        <input type="text" name="title" value="<?php echo $title; ?>">
        <label>Body</label>
        <textarea name="body" rows="20" cols="20"><?php echo $body; ?></textarea>
      </div>
      <div class="onethird">
        <?php
        $query = "SELECT * FROM categories";
        $result = $db->query( $query );
        if ( $result->num_rows >=1 ) {
          ?>
          <label>Category</label>
          <select name="category_id">
            <?php while( $row = $result->fetch_assoc() ){ ?>
              <option value="<?php echo $row['category_id']; ?>"
                <?php select_it( $category_id, $row['category_id'] ); ?>>
                <?php echo $row['name']; ?>
              </option>
              <?php }//end while ?>
            </select>
            <?php }//end if there are categories ?>
            <label>
              <input type="checkbox" name="is_published" value="1" <?php
              check_it( $is_published, 1 ) ?>>
              Make this post public?
            </label>
            <label>
              <input type="checkbox" name="allow_comments" value="1" <?php
              check_it( $allow_comments, 1 ) ?>>
              Allow people to comment on this post?
            </label>
            <input type="submit" value="Save Post">
            <input type="hidden" name="did_post" value="1">
          </div>
        </form>
      </section>
    </main>
    <?php include('admin-footer.php'); ?>
