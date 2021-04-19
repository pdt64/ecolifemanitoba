<?php 

  require 'connection.php';

  $search  = filter_input(INPUT_POST, 'search', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $category = filter_input(INPUT_POST, 'categories', FILTER_SANITIZE_NUMBER_INT);

  $category_query = "SELECT * FROM categories";

  $category_statement = $db->prepare($category_query);
  $category_statement->execute();
  $categories = $category_statement->fetchAll();

  if(isset($_POST['search'])){
    header("Location: search.php?search=$search&category=$category");
    exit();
  }

    if(!isset($_SESSION)){
  session_start();
  }

?> 

<!DOCTYPE html>
<html lang="en">
  <head>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Eco-Life Manitoba</title>
    <!-- Bootstrap CSS -->

    <link rel="stylesheet" type="text/css" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous"/>

  </head>
    <body class="body myBody">
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
        <li class="nav-item">
          <a class="nav-link active" href="pages.php">Page List</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="categories.php">Categories</a>
        </li>
        <?php if(isset($_SESSION['usertype']) && $_SESSION['usertype'] == 2): ?>
        <li class="nav-item">
          <a class="nav-link active" href="users.php">Users</a>
        </li>
         <?php endif ?>
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
      <form class="d-flex" method="post">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="search">
        <button class="btn btn-outline-success" type="submit">Search</button>
        <select name="categories">
            <option value="0" selected>All Categories</option>
            <?php foreach($categories as $category): ?>
              <option value="<?= $category['categoryId'] ?>"><?= $category['title'] ?></option>
            <?php endforeach ?>
          </select>
      </form>
    </div>
  </div>
</nav>


