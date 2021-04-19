<?php

  // Name: Piolo Turdanes
  // Date: 
  // Purpose: Allows users to register for an account on the website.

  require 'header.php';

  $email  = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $username = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $password = filter_input(INPUT_POST, 'pass', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $pass_again = filter_input(INPUT_POST, 'pass_again', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  $query     = "INSERT INTO users (email, username, password, usertype) values (:email, :name, :pass, 1)";
  $select = "SELECT * FROM users WHERE email = :email";

  $select_statement = $db->prepare($select);
  $select_statement->bindValue("email", $email);
  $select_statement->execute(); 
  $count = $select_statement->rowCount();
  
  if($pass_again === $password && $count < 1){
  	if(isset($_POST['email']) && 
      isset($_POST['name']) && 
  	  isset($_POST['pass'])){

      $hashed_pass = password_hash($password, PASSWORD_DEFAULT);

      $statement = $db->prepare($query);
      $statement->bindValue(':email', $email);
      $statement->bindValue(':name', $username);
      $statement->bindValue(':pass', $hashed_pass);

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

  <div id="wrapper">

    <div id="all_blogs">
      <form method="post">
        <fieldset>
          <legend>Register</legend>

            <label for="email">Email</label>
            <input name="email" id="email" />
            <p id="email_error" class = "error">Email is required.</p>
            <p id="invalid_error" class = "error">Invalid email.</p>
            <br>
            <label for="name">Username</label>
            <input name="name" id="name" />
            <p id="name_error" class = "error">Username is required.</p>
            <br>
            <label for="pass">Password</label>
            <input name="pass" id="pass" type="password" />
            <p id="pass_error" class = "error">Password is required.</p>
            <br>
            <label for="pass_again">Enter Password Again</label>
            <input name="pass_again" id="pass_again" type="password" />
            <p id="pass_again_error" class = "error">Please re-enter your password.</p>
            <p id="match_error" class = "error">Passwords do not match.</p>
            <br>
            <input type="submit" name="command" value="Register" id="register" />
            <br>
          <?php if(isset($count) && $count == 1): ?>
            <p>Account already exists.</p>
          <?php endif ?>

        </fieldset>
      </form>
    </div>
  </div> 
  <script src="register.js"></script>

</body>
</html>