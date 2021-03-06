<?php

  // Name: Piolo Turdanes
  // Date: 
  // Purpose: Allows users to create posts and insert them into the database.

  

  require 'header.php';

  $title  = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  $query = "INSERT INTO categories (title) values (:title)";

  if(isset($_POST['title']) && strlen($_POST['title']) >= 1){

  	$statement = $db->prepare($query);

    $statement->bindValue(':title', $title);

    $statement->execute();
    $insert_id = $db->lastInsertId(); 

    header('Location: categories.php');
    exit();
  }

  if(!isset($_SESSION)){
    session_start();
  }
  
?>

<?php if(isset($_SESSION['userId'])): ?>
  <div id="wrapper">
    <div id="category">
      <form method="post">
        <fieldset>
          <legend>New Category</legend>
          <p>
            <label for="title">Title</label>
            <input name="title" id="title" />
          </p>
            <input type="submit" name="submit" value="Create"  />
          <?php if(isset($_POST['title']) && strlen($_POST['title']) < 1): ?>
            <p>Title may not be less than 1 character.</p>
          <?php endif ?>
        </fieldset>
      </form>
    </div>
  </div> 
<?php else: ?>
  <p>You do not have access to this page.</p>
<?php endif ?>
</body>
</html>