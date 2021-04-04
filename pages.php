<?php
  // Name: Piolo Turdanes
  // Date: 
  // Purpose: Displays the index page and 15 most recent blog posts.

  require 'connection.php';
  require 'header.php';

  	$date_query = "SELECT * FROM blogposts ORDER BY postDate";
    $title_query = "SELECT * FROM blogposts ORDER BY title";
    $update_query = "SELECT * FROM blogposts ORDER BY dateUpdated";
  	$statement = $db->prepare($date_query); 
  	$statement->execute(); 
  	$posts = $statement->fetchAll();
    $sort = "Date Created";

    if(isset($_POST['title'])){
      $statement = $db->prepare($title_query); 
      $statement->execute(); 
      $posts = $statement->fetchAll();
      $sort = "Title";
    }
    if(isset($_POST['dateCreated'])){
      $statement = $db->prepare($date_query); 
      $statement->execute(); 
      $posts = $statement->fetchAll();
      $sort = "Date Created";
    }
    if(isset($_POST['dateUpdated'])){
      $statement = $db->prepare($update_query); 
      $statement->execute(); 
      $posts = $statement->fetchAll();
      $sort = "Date Updated";
    }

  if(!isset($_SESSION)){
	session_start();
  }

?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous"/>


    <title>Eco-Life Manitoba</title>

  </head>

  <body class="body myBody">
   <form method="post">
        <fieldset>
          <legend>Sort By:</legend>
            <input type="submit" name="title" value="Title"/>
            <input type="submit" name="dateCreated" value="Date Created"/>
            <input type="submit" name="dateUpdated" value="Date Updated"/>
            <p>Sorted by <?= $sort ?></p>
        </fieldset>
      </form>
  <div id="blogposts">
         <?php foreach($posts as $post): ?>
        <div class="blog_post">
          <h2><a href="show.php?id=<?= $post['postId'] ?>"><?= $post['title'] ?></a></h2>
          <p>
            <small>
              <?= date('F j, Y,  g:i a ', strtotime($post['postDate'])) ?> - Updated <?= date('F j, Y,  g:i a ', strtotime($post['dateUpdated'])) ?>
             <?php if(isset($_SESSION['userId'])): ?>
              <small> - </small><a href="edit.php?id=<?= $post['postId'] ?>">edit</a>
            <?php endif ?>
            </small>
          </p>
        </div>
      <?php endforeach ?>
  </div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>

  </body>
</html>