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


  <div id="wrapper">

    <div id="all_blogs">
      <form method="post">
        <fieldset>
          <legend>Login</legend>
            <label for="email">Email</label>
            <input name="email" id="email" />
            <p id="email_error" class="error">Please enter your email.</p>
            <br>
            <label for="pass">Password</label>
            <input name="pass" id="pass" type="password" />
            <p id="pass_error" class="error">Please enter your password.</p>
            <br>
            <input type="submit" name="command" value="Login" id="login" />
          <?php if(isset($count) && $count != 1): ?>
            <p>Login failed.</p>
          <?php endif ?>
        </fieldset>
      </form>
    </div>
  </div> 
  <script src="login.js"></script>
</body>

</html>