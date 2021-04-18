<?php

  // Name: Piolo Turdanes
  // Date: 
  // Purpose: Allows users to login.
  require 'header.php';

  $email  = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $password = filter_input(INPUT_POST, 'pass', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  if(isset($_POST['email']) && 
      isset($_POST['pass'])){
    $query     = "SELECT * FROM users WHERE email = :email";

    $statement = $db->prepare($query);
    $statement->bindValue(':email', $email);

    $statement->execute();
    $count = $statement->rowCount();
    $user = $statement->fetchAll();

    if($count == 1 && password_verify($password, $user[0]['password'])){
      $_SESSION['userId'] = $user[0]['userId'];
      $_SESSION['username'] = $user[0]['username'];
      $_SESSION['usertype'] = $user[0]['usertype'];
      header('Location: index.php');
      exit;
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
    <title>ELM - Login</title>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous"/>
     <script src="login.js"></script>
     <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
  <div id="wrapper">

    <div id="all_blogs">
      <form method="post">
        <fieldset>
          <legend>Login</legend>
          <p>
            <label for="email">Email</label>
            <input name="email" id="email" />
            <p id="email_error" class="error">Please enter your email.</p>
          </p>
          <p>
            <label for="pass">Password</label>
            <input name="pass" id="pass" type="password" />
            <p id="pass_error" class="error">Please enter your password.</p>
          </p>
          <p>
            <input type="submit" name="command" value="Login" id="login" />
          </p>
          <?php if(isset($count) && $count != 1): ?>
            <p>Login failed.</p>
          <?php endif ?>
        </fieldset>
      </form>
    </div>
  </div> 
</body>
</html>