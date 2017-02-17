<?php require ('db-config.php'); ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Simple AJAX Demo</title>
  <link rel="stylesheet" type="text/css" href="styles/ajax-style.css">
</head>
<body>
  <h1>Read all the posts in a category:</h1>
  <?php
  $query = "SELECT * FROM categories";
  $result = $db->query($query);
  //handy way to check for query problems!
  if ( ! $result ) {
    echo $db->error;
  }
  //checl to see if there are rows to show
  if ( $result->num_rows >= 1 ) {
    ?>
    <select id="picker" class="picker">
      <option>Choose a category</option>
      <?php while ($row = $result->fetch_assoc() ) { ?>
        <option value="<?php echo $row['category_id']; ?>">
          <?php echo $row['name']; ?>
        </option>
        <?php } //end while ?>
      </select>
      <?php
    } //end if num_rows
    ?>
    <div id="display-area">Pick a category to view the posts</div>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script type="text/javascript">
    $('#picker').change( function() {
      //get this ID value of the chosen category
      var cat_id = this.value;
      // alert(cat_id);
      //make a request to ajax-response.php
      $.ajax({
        method: 'GET',
        url: 'ajax-response.php',
        data: {'cat_id' : cat_id},
        dataType: 'html',
        success: function (response) {
          $('#display-area').html(response);
        }
      }); //end ajax
    }); //end on change
    $(document).on({
      ajaxStart: function () { $('#display-area').addClass('loading');},
      ajaxStop: function () { $('#display-area').removeClass('loading');}
    });
    </script>
  </body>
  </html>
