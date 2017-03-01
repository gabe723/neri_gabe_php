<?php
session_start();
require('../db-config.php');
include_once('../functions.php');
//header contains the security check, doctype, and <header> element
include('admin-header.php');
include('admin-nav.php');
//begin parsing the image upload
if ( $_POST['did_upload'] ) {
  //where is the uploads
  $upload_path = '../uploads';
  $sizes = array(
    'small' => 150,
    'medium' => 300,
    'large' => 600,
  );
  //extract the image was uploaded
  $uploaded_file = $_FILES['uploaded_file']['tmp_name'];
  //validate = make sure it has pixels
  list( $width, $height ) = getimagesize( $uploaded_file );
  if ( $width > 0 AND $height > 0 ) {
    //what MIME type of image is it?
    $file_type = $_FILES['uploaded_file']['type'];
    switch ( $file_type ) {
      case 'image/gif':
        $source = imagecreatefromgif( $uploaded_file );
        break;
        case 'image/jpeg':
        case 'image/pjpeg':
        case 'image/jpg':
        $source = imagecreatefromjpeg( $uploaded_file );
        break;
        case 'image/png':
        ini_set( 'memory_limit', '16M' );
        $source = imagecreatefrompng( $uploaded_file );
        ini_restore( 'memory_limit' );
        break;
        default:
        $message = ( 'Please upload a .gif, .png, .jpeg' );
        break;
      }//end switch
      //resize the image
      $unique_string = sha1( microtime() );
      foreach ( $sizes as $name => $upload_width ) {
        if ( $width < $upload_width ) {
          //keep original size if image width is too small
          $new_width = $width;
          $new_height = $height;
        }else{
          $new_width = $upload_width;
          $new_height = ( $new_width * $height ) / $width;
        }
        //create a new blank file at the correct size
        $tmp_canvas = imagecreatetruecolor( $new_width, $new_height );
        imagecopyresampled( $tmp_canvas, $source, 0, 0, 0, 0, $new_width, $new_height, $width, $height );
        $file_name = $upload_path . '/' . $unique_string . '_' . $name . '.jpg';
        $did_save = imagejpeg( $tmp_canvas, $file_name, 75 );
      }//end foreach
      //if it saved, update the DB
      if ( $did_save ) {
        //DELETE OLD FILE
        //look up the old image name
        $query_old_file = "SELECT userpic FROM users where user_id = " . USER_ID . " LIMIT 1";
        $result_old_file = $db->query($query_old_file);
        if($result_old_file->num_rows == 1){
          $row_old_file = $result_old_file->fetch_assoc();
          //delete old files
          foreach ($sizes as $size_name => $size_width) {
            $old_file = ROOT_PATH . '/uploads/' . $row_old_file['userpic'] . '_' . $size_name . '.jpg'  ;
            //Delete the file from the directory with unlink()
            @unlink($old_file);
          }
        }
        //END DELETE OLD FILE
        $user_id = USER_ID;
        $query = "UPDATE users SET userpic = '$unique_string' WHERE user_id = $user_id";
        $result = $db->query( $query );
        if ( $db->affected_rows == 1 ) {
          //show user feedback
          $message = ( 'Success! Your User Picture has been updated.' );
        }else{
          $message = ( 'Sorry, your User Picture has not been updated.' );
        }
      }//end if did_save
      else{
        $message = ( 'Sorry, your User Picture did not save.' );
      }
    }//end if it has width and height
    else{
      $message = ( 'Please choose an image to upload.' );
    }
  }//end of parser
  ?>
  <main role="main">
    <section class="panel important">
      <h2>Edit Profile Picture</h2>
      <?php echo show_feedback( $message ); ?>
      <form class="form-edit-profile" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
        <label>Upload photo:</label>
        <input type="file" name="uploaded_file">
        <input type="submit" name="Edit Profile Pic">
        <input type="hidden" name="did_upload" value="1">
      </form>
      <?php show_profile_pic( USER_ID, 'medium' ); ?>
    </section>
  </main>
  <?php include('admin-footer.php'); ?>
