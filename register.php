<?php

  // Name: Piolo Turdanes
  // Date: 
  // Purpose: Allows users to register for an account on the website.

  require 'connection.php';

  $email  = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $username = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $password = filter_input(INPUT_POST, 'pass', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $pass_again = filter_input(INPUT_POST, 'pass_again', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  $query     = "INSERT INTO users (email, username, password, usertype) values (:email, :name, :pass, 1)";
  $select = "SELECT * FROM users WHERE email = :email";

  $statement = $db->prepare($query);
  $statement->bindValue(':email', $email);
  $statement->bindValue(':name', $username);
  $statement->bindValue(':pass', $password);

  $select_statement = $db->prepare($select);
  $select_statement->bindValue("email", $email);
  $select_statement->execute(); 
  $count = $select_statement->rowCount();
  
  if($pass_again === $password && $count < 1){
  	if(isset($_POST['email']) && 
      isset($_POST['name']) && 
  	  isset($_POST['pass'])){
    	$statement->execute();
    	$insert_id = $db->lastInsertId();

    	header('Location: login.php');
    	exit();
  	}

    if(!isset($_SESSION)){
		session_start();
	}
  } 
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>ELM - Create</title>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous"/>
     <script src="register.js"></script>
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
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="login.php">Login</a>
        </li>
      </ul>
      <form class="d-flex">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav>
  <div id="wrapper">

    <div id="all_blogs">
      <form method="post">
        <fieldset>
          <legend>Register</legend>
          <p>
            <label for="email">Email</label>
            <input name="email" id="email" />
            <p id="email_error" class = "error">Email is required.</p>
            <p id="invalid_error" class = "error">Invalid email.</p>
          </p>
          <p>
            <label for="name">Username</label>
            <input name="name" id="name" />
            <p id="name_error" class = "error">Username is required.</p>
          </p>
          <p>
            <label for="pass">Password</label>
            <input name="pass" id="pass" type="password" />
            <p id="pass_error" class = "error">Password is required.</p>
          </p>
          <p>
            <label for="pass_again">Enter Password Again</label>
            <input name="pass_again" id="pass_again" type="password" />
            <p id="pass_again_error" class = "error">Please re-enter your password.</p>
            <p id="match_error" class = "error">Passwords do not match.</p>
          </p>
          <p>
            <input type="submit" name="command" value="Register" id="register" />
          </p>
          <?php if(isset($count) && $count == 1): ?>
            <p>Account already exists.</p>
          <?php endif ?>

        </fieldset>
      </form>
    </div>
  </div> 
</body>
</html>