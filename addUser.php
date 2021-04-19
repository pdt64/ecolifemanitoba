<?php

  // Name: Piolo Turdanes
  // Date: 
  // Purpose: Allows users to create posts and insert them into the database.


  require 'header.php';

  $username  = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $password = filter_input(INPUT_POST, 'pass', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $usertype = filter_input(INPUT_POST, 'usertype', FILTER_SANITIZE_NUMBER_INT);


  $query     = "INSERT INTO users (username, email, password, usertype) values (:username, :email, :password, :usertype)";

  $statement = $db->prepare($query);
  $statement->bindValue(':username', $username);
  $statement->bindValue(':email', $email);
  $statement->bindValue(':password', $password);
  $statement->bindValue(':usertype', $usertype, PDO::PARAM_INT);
  
  if(isset($_POST['username']) && strlen($_POST['username']) >= 1 && 
      isset($_POST['email']) && strlen($_POST['email']) >= 1 &&
      isset($_POST['pass']) && strlen($_POST['pass']) >= 1 &&
      isset($_POST['usertype']) && $_POST['usertype'] >= 1 && $_POST['usertype'] <= 2){
    $statement->execute();
    $insert_id = $db->lastInsertId();

    header('Location: users.php');
    exit();
  }

  if(!isset($_SESSION)){
    session_start();
  }
  
?>

<?php if(isset($_SESSION['userId'])): ?>
  <div id="wrapper">
    <div id="all_blogs">
      <form method="post">
        <fieldset>
          <legend>New User</legend>
        
            <label for="username">Username</label>
            <input name="username" id="username" />
            <p id="name_error" class = "error">Username is required.</p>
            <br/>
            <label for="email">Email</label>
            <input name="email" id="email" />
            <p id="email_error" class = "error">Email is required.</p>
            <p id="invalid_error" class = "error">Invalid email.</p>
            <br/>
            <label for="pass">Password</label>
            <input name="pass" id="pass" />
            <p id="pass_error" class = "error">Password is required.</p>
            <br/>
            <label for="usertype">User type (1 for member, 2 for admin)</label>
            <input name="usertype" id="usertype" />
            <p id="usertype_error" class = "error">Usertype is required.</p>
            <p id="invalidtype_error" class = "error">Only 1 and 2 are allowed for usertypes.</p>
            <br/>
            <input type="submit" name="command" value="Add" id="add"  />

        </fieldset>
      </form>
    </div>
  </div> 
<?php else: ?>
  <p>You do not have access to this page.</p>
<?php endif ?>
<script src="addUser.js"></script>
</body>

</html>