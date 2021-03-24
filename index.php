<?php
  // Name: Piolo Turdanes
  // Date: 
  // Purpose: Displays the index page and 15 most recent blog posts.

  require 'connection.php';

  	$query = "SELECT * FROM blogposts ORDER BY postDate LIMIT 15";
  	$statement = $db->prepare($query); 
  	$statement->execute(); 
  	$posts = $statement->fetchAll();

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
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Eco-Life Manitoba</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li>
        <?php if(isset($_SESSION['userId'])): ?>
        <li class="nav-item">
          <a class="nav-link active" href="create.php">Create Post</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="logout.php">Logout</a>
        </li>
    	<?php endif ?>
    	<?php if(!isset($_SESSION['userId'])): ?>
    	<li class="nav-item">
          <a class="nav-link active" href="login.php">Login</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="register.php">Register</a>
        </li>
    	<?php endif ?>
      </ul>
      <form class="d-flex">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav>
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
         <?php foreach($posts as $post): ?>
        <div class="blog_post">
          <h2><a href="show.php?id=<?= $post['postId'] ?>"><?= $post['title'] ?></a></h2>
          <p>
            <small>
              <?= date('F j, Y,  g:i a ', strtotime($post['postDate'])) ?>
             <?php if(isset($_SESSION['userId'])): ?>
              <small> - </small><a href="edit.php?id=<?= $post['postId'] ?>">edit</a>
          	<?php endif ?>
            </small>
          </p>
          <div class='blog_content'>
            <?php if(strlen($post['content']) > 200): ?>
              <p><?= substr($post['content'], 0, 200) ?> ... <a href="show.php?id=<?= $post['postId'] ?>">Read Full Post</a></p>
            <?php else: ?>
              <?= $post['content'] ?>
            <?php endif ?>
          </div>
        </div>
      <?php endforeach ?>
	</div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>

  </body>
</html>