<?php

  // Name: Piolo Turdanes
  // Date: 
  // Purpose: Allows users to create posts and insert them into the database.



  require 'connection.php';

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
   <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">Eco-Life Manitoba</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="index.php">Home</a>
        </li>
        <?php if(isset($_SESSION['userId'])): ?>
        <li class="nav-item">
          <a class="nav-link active" href="create.php">Create Post</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="logout.php">Logout</a>
        </li>
      <?php endif ?>
      </ul>
      <form class="d-flex">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav>
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