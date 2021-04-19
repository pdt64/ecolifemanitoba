<?php
  // Name: Piolo Turdanes
  // Date:
  // Purpose: Allows users to edit blog posts and update the posts in the database.

    require 'header.php';

	$username  = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  	$usertype = filter_input(INPUT_POST, 'usertype', FILTER_SANITIZE_NUMBER_INT);
  	$id      = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

  	$update_query = "UPDATE users SET username = :username, usertype = :usertype WHERE userId = :id";
  	$delete_query = "DELETE FROM users WHERE userId = :id"; 	
  	$select_query = "SELECT * FROM users WHERE userId = :id";

  	$select_statement = $db->prepare($select_query);
  	$select_statement->bindValue(':id', $id, PDO::PARAM_INT);
 	$select_statement->execute(); 
  	$user = $select_statement->fetchAll();


  	if(count($user) == 0){
  		header('Location: users.php');
  		exit();
  	} else {
  	if(filter_var($id, FILTER_VALIDATE_INT)){
		if(isset($_POST['username']) && strlen($_POST['username']) >= 1 && 
		    isset($_POST['usertype']) && $_POST['usertype'] >= 1 && $_POST['usertype'] <= 2 &&
		     isset($_POST['update'])) {
			$update_statement = $db->prepare($update_query);
			$update_statement->bindValue(':username', $username);
  			$update_statement->bindValue(':usertype', $usertype, PDO::PARAM_INT);
  			$update_statement->bindValue(':id', $id, PDO::PARAM_INT);
			$update_statement->execute();

		 	header('Location: users.php');
		    exit();
		}

	    if(isset($_POST['delete'])){
	    	$delete_statement = $db->prepare($delete_query);
			$delete_statement->bindValue(':id', $id, PDO::PARAM_INT);
	  	    $delete_statement->execute();
	  		header('Location: users.php');
	  		exit();
	  	}
	} else {
		header('Location: index.php');
		exit();
	}
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
	      <legend>Edit User</legend>
	      <p>
	        <label for="username">Username</label>
	        <input name="username" id="username" value="<?= $user[0]['username']?>" />
	      </p>
	      <p>
	        <label for="usertype">Usertype</label>
	        <input name="usertype" id="usertype" value="<?= $user[0]['usertype'] ?>"/>
	      </p>
	      <p>
	        <input type="hidden" name="id" value="<?= $user[0]['userId'] ?>" />
	        <input type="submit" name="update" value="Update" />
	        <input type="submit" name="delete" value="Delete" onclick="return confirm('Are you sure you wish to delete this post?')" />
	      </p>
	      <?php if(isset($_POST['username']) && strlen($_POST['username']) < 1): ?>
	        <p>Username may not be less than 1 character.</p>
	      <?php endif ?>
	      <?php if(isset($_POST['usertype']) && ($_POST['usertype'] < 1 || $_POST['usertype'] > 2)): ?>
	        <p>Usertype can only be 1 or 2.</p>
	      <?php endif ?>
	    </fieldset>
	  </form>
	</div>
    </div> 
<?php else: ?>
  <p>You do not have access to this page.</p>
<?php endif ?>
</body>
</html>