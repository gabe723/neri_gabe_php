<?php
/**
* A function to convert ugly timestamps to human-friendly dates
*/
function convert_timestamp( $ugly ){
  $date = new DateTime( $ugly );
  echo $date->format('l, jS, F, o');
}
/**
* A function to convert ugly time rss to human-friendly rss
*/
function convert_timerss( $ugly ){
  $date = new DateTime( $ugly );
  echo $date->format('r');
}
//sanitize functions: extract the values that the user typed in and sanitize
/**
* A function to clean string
*/
function clean_string( $untrusted ){
  global $db;
  return mysqli_real_escape_string($db, filter_var( $untrusted, FILTER_SANITIZE_STRING ));
}
/**
* A function to clean integer
*/
function clean_integer( $untrusted ){
  global $db;
  return mysqli_real_escape_string($db, filter_var( $untrusted, FILTER_SANITIZE_NUMBER_INT ));
}
/**
* A function to clean boolean
*/
function clean_boolean( $untrusted ){
  if ( $untrusted != 1) {
    $untrusted = 0;
  }
  return $untrusted;
}
/**
* A function to clean email
*/
function clean_email( $untrusted ){
  global $db;
  return mysqli_real_escape_string($db, filter_var( $untrusted, FILTER_SANITIZE_EMAIL ));
}
/**
* A function to clean url
*/
function clean_url( $untrusted ){
  global $db;
  return mysqli_real_escape_string($db, filter_var( $untrusted, FILTER_SANITIZE_URL ));
}
/**
* A Helper function to show feedback
* @param string $feedback - A quick feedback message to the user
* @param array $errors - A list of any inline field errors
* @return string - Displays a div containing all the feedback and errors
*/
function show_feedback( $feedback, $errors = array() ){
  if( isset($feedback) ) {
    echo '<div class="feedback">';
    echo $feedback;
    //if there are errors, show them as a list
    if( ! empty($errors) ){
      echo '<ul>';
      foreach ($errors as $error) {
        echo '<li>' . $error . '</li>';
      }
      echo '</ul>';
    }
    echo '</div>';
  }
}
/**
*  A Helper function to make <select> elements "sticky"
* @param mixed $thing_one - The first thing we're comparing
* @param mixed $thing_two - The second thing we're comparing
* @return string - displays "selected" if they match
*/
function select_it( $thing_one, $thing_two ){
  if( $thing_one == $thing_two ){
    echo 'selected';
  }
}
/**
* A Helper function to make checkbox elements "sticky"
* @param mixed $thing_one - The first thing we're comparing
* @param mixed $thing_two - The second thing we're comparing
* @return string - displays "checked" if they match
*/
function check_it( $thing_one, $thing_two ){
  if( $thing_one == $thing_two ){
    echo 'checked';
  }
}
/**
* A Helper function to count the comments on any given post
* @param int $post_id: Any valid post_id
* @return string: echos the number of comments, with 'comment/comments' grammar
*/
function count_comments( $post_id ){
  global $db;
  $query = "SELECT COUNT(*) as total FROM comments WHERE post_id = $post_id";
  $result = $db->query( $query );
  if ( $result->num_rows == 1 ) {
    $row = $result->fetch_assoc();
    $comments_number = $row['total'];
    //display then number with the correct grammer
    if ( $comments_number == 1 ) {
      echo '1 Comment';
    }elseif ( $comments_number == 0 ) {
      echo '0 Comments';
    }else{
      echo $comments_number . ' comments';
    }
  }
}
/**
* A Helper function to count the number of posts written by any user
* @param int $user_id - Any valid user_id
* @param boolean $is_published - 1 means TRUE - count public posts (default)
*                                0 means FALSE - count drafts
* @return int - echos the total number of posts
*/
function count_posts_by_user( $user_id, $is_published = 1 ){
  global $db;
  $query = "SELECT COUNT(*) as total FROM posts WHERE user_id = $user_id AND is_published = $is_published";
  $result = $db->query( $query );
  if ( $result->num_rows == 1 ) {
    $row = $result->fetch_assoc();
    echo $row['total'];
  }
}
/**
* A helper function to display an <img> for any user's pic at any known size
*/
function show_profile_pic( $user_id, $size ){
  global $db;
  $query = "SELECT userpic, username FROM users WHERE user_id = $user_id LIMIT 1";
  $result = $db->query( $query );
  if ( $result->num_rows == 1 ) {
    //display the image if it exists, otherwise show the default profile picture
    $row = $result->fetch_assoc();
    if ( $row['userpic'] != '' ) {
      echo '<img src="' . ROOT_URL . '/uploads/' . $row['userpic'] . '_' . $size . '.jpg" class="userpic" alt="' . $row['username'] . '\'s profile picture">';
    }else{
      echo '<img src="' . ROOT_URL . '/images/default_user_' . $size . '.jpg" class="userpic" alt="default userpic">';
    }
  }
}
//DO NOT CLOSE PHP HERE!
