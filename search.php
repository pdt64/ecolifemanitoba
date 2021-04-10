<?php

	require 'header.php';
	require 'categoryNav.php';

	$search = filter_input(INPUT_GET, 'search', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$category = filter_input(INPUT_GET, 'category', FILTER_SANITIZE_NUMBER_INT);

	$query = "SELECT * 
				FROM blogposts
				WHERE title 
				LIKE CONCAT('%', :title, '%') OR 
				content LIKE CONCAT('%', :title, '%')";

	$restricted_query = "SELECT * 
						FROM blogposts
						WHERE (title 
						LIKE CONCAT('%', :title, '%') OR 
						content LIKE CONCAT('%', :title, '%')) AND
						categoryId = :category";

	if($category == 0){
		$statement = $db->prepare($query); 
  		$statement->bindValue(':title', $search);
  		$statement->execute(); 
  		$posts = $statement->fetchAll();
	} else{
		$statement = $db->prepare($restricted_query); 
  		$statement->bindValue(':title', $search);
  		$statement->bindValue(':category', $category);
  		$statement->execute(); 
  		$posts = $statement->fetchAll();
	}
  	

  if(!isset($_SESSION)){
	session_start();
  }

?>

<!DOCTYPE html>
<html>
<head>
	<title>Search Results</title>

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous"/>
</head>


<body>
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
          <h4><?= $post['categoryId'] ?></h4>
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
</body>
</html>


