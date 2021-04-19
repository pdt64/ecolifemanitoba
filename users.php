<?php
  // Name: Piolo Turdanes
  // Date: 
  // Purpose: Displays the index page and 15 most recent blog posts.

  require 'header.php';

  	$query = "SELECT * FROM users ORDER BY usertype";
  	$statement = $db->prepare($query); 
  	$statement->execute(); 
  	$users = $statement->fetchAll();

  if(isset($_POST['add'])){
    header("Location: addUser.php");
  }

  if(!isset($_SESSION)){
	session_start();
  }

?>

  <?php if(isset($_SESSION['userId'])): ?>
  <div id="users">
    <form method="post"> 
      <input type="submit" name="add" value="Add User"  />
    </form>
        
         <?php foreach($users as $user): ?>
        <div class="user">
          <h2><?= $user['username'] ?>   <a href="editUser.php?id=<?= $user['userId'] ?>">edit</a></h2>
          <p>
            <?= $user['email'] ?>
          </p>
            <?php if($user['usertype'] == 1): ?>
              <p>Member</p>
            <?php else: ?>
              <p>Admin</p>
            <?php endif ?>
            <br/>
        </div>
      <?php endforeach ?>
  </div>
<?php else: ?>
  <p>You do not have access to this page.</p>
<?php endif ?>
</body>
</html>

