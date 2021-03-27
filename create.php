<?php

  // Name: Piolo Turdanes
  // Date: 
  // Purpose: Allows users to create posts and insert them into the database.



  require 'connection.php';
  require 'header.php';

  $title  = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  $query     = "INSERT INTO blogposts (title, content) values (:title, :content)";

  $statement = $db->prepare($query);
  $statement->bindValue(':title', $title);
  $statement->bindValue(':content', $content);
  
  if(isset($_POST['title']) && strlen($_POST['title']) >= 1 && 
      isset($_POST['content']) && strlen($_POST['content']) >= 1){
    $statement->execute();
    $insert_id = $db->lastInsertId();

    header('Location: index.php');
    exit();
  }

  if(!isset($_SESSION)){
    session_start();
  }
  
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>ELM - Create</title>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous"/>
</head>
<body>
<?php if(isset($_SESSION['userId'])): ?>
  <div id="wrapper">
    <div id="all_blogs">
      <form method="post">
        <fieldset>
          <legend>New Blog Post</legend>
          <p>
            <label for="title">Title</label>
            <input name="title" id="title" />
          </p>
          <p>
            <label for="content">Content</label>
            <textarea name="content" id="content" cols="100" rows="20"></textarea>
          </p>
          <p>
            <input type="submit" name="command" value="Create"  />
          </p>
          <?php if(isset($_POST['title']) && strlen($_POST['title']) < 1 && 
          isset($_POST['content']) && strlen($_POST['content']) < 1): ?>
            <p>Title and content may not be less than 1 character.</p>
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