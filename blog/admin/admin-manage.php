<?php
session_start();
require('../db-config.php');
include_once('../functions.php');
//header contains the security check, doctype, and <header> element
include('admin-header.php');
include('admin-nav.php');
//"delete" parser
if ( $_POST['did_delete'] ) {
  //which boxes did they check?
  $checked = $_POST['delete'];
  foreach ( $checked as $post_id ) {
    $query = "DELETE FROM posts WHERE post_id = $post_id";
    $result = $db->query( $query );
  }
}
?>
<main role="main">
  <section class="panel important">
    <h2>Manage Posts</h2>
    <?php
    //get ALL posts
    $query = "SELECT posts.*, users.username, categories.name
    FROM posts, users, categories
    WHERE posts.user_id = users.user_id
    AND categories.category_id = posts.category_id";
    //if not an admin, only show the logged in user's posts
    if ( ! IS_ADMIN ) {
      $user_id = USER_ID;
      $query .= " AND posts.user_id = $user_id";
    }
    //newest posts first
    $query .= " ORDER BY posts.date DESC";
    $result = $db->query( $query );
    if ( $result->num_rows >= 1 ) {
      ?>
      <form class="form-manage-posts" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <table>
          <thead>
            <tr>
              <th>Title</th>
              <th>Date</th>
              <th>Author</th>
              <th>Status</th>
              <th>Category</th>
              <th><button type="submit"><i class="fa fa-trash fa-2x"></i></button></th>
            </tr>
          </thead>
          <?php while ( $row = $result->fetch_assoc() ) { ?>
            <tbody>
              <tr>
                <td><a href="admin-edit.php?post_id=<?php echo $row['post_id']; ?>"><?php echo $row['title']; ?></a></td>
                <td><?php echo convert_timestamp( $row['date'] ); ?></td>
                <td><?php echo $row['username']; ?></td>
                <td><?php echo $row['is_published'] == 1 ? 'Public' : '<b>Draft<b>'; ?></td>
                  <td><?php echo $row['name']; ?></td>
                  <td><input type="checkbox" name="delete[]" value="<?php echo $row['post_id']; ?>"></td>
                </tr>
              </tbody>
              <?php }//end while ?>
            </table>
            <?php }//end if there are posts ?>
            <input type="hidden" name="did_delete" value="1">
          </form>
        </section>
      </main>
      <?php include('admin-footer.php'); ?>
