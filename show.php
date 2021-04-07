<?php
  // Name: Piolo Turdanes
  // Date: 
  // Purpose: Displays the selected page.

  require 'connection.php';
  require 'header.php';

   $id      = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

  	$query = "SELECT * FROM blogposts WHERE postId = :id";
  	if(filter_var($id, FILTER_VALIDATE_INT)){
      $select_statement = $db->prepare($query); 
      $select_statement->bindValue(':id', $id, PDO::PARAM_INT);
      $select_statement->execute(); 
      $post = $select_statement->fetchAll();
    } else {
      header('Location: index.php');
      exit();
    }

    if(count($post) == 0){
      header('Location: index.php');
      exit();
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
<div id="carouselExampleDark" class="carousel carousel-dark slide" data-bs-ride="carousel">
  <div class="carousel-indicators">
    <button type="button my-button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2" aria-label="Slide 3"></button>
  </div>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="images/nature.jpg" class="d-block w-100" alt="Nature">
      <div class="carousel-caption d-none d-md-block">
        <h1 class="header">Eco-Life Manitoba</h1>
        <p></p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="images/snow.jpg" class="d-block w-100" alt="Snow">
      <div class="carousel-caption d-none d-md-block">
        <h1 class="header">Dedicated to preserving Manitoba's wildlife.</h1>
        <p></p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="images/river.jpg" class="d-block w-100" alt="River">
      <div class="carousel-caption d-none d-md-block">
        <h1 class="header">Join us today!</h1>
        <p></p>
      </div>
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark"  data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark"  data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>
	<div id="blogposts">
    <div class="blog_post">
      <h2><?= $post[0]['title'] ?></h2>
      <?php if($post[0]['image'] != null): ?>
              <img src="uploads\<?= $post[0]['image'] ?>" alt="Picture"/>
      <?php endif ?>
      <p>
        <small>
          <?= date('F j, Y,  g:i a', strtotime($post[0]['postDate'])) ?>
          <?php if(isset($_SESSION['userId'])): ?>
          <small> - </small><a href="edit.php?id=<?= $post[0]['postId']?>">edit</a>
        <?php endif ?>
        </small>
      </p>
      <div class='blog_content'>
        <p><?= $post[0]['content'] ?></p>
      </div>
	</div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>

  </body>
</html>