<?php
  // Name: Piolo Turdanes
  // Date:
  // Purpose: Allows users to edit blog posts and update the posts in the database.
    require 'header.php';

  	$title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  	$id      = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

  	$update_query = "UPDATE categories SET title = :title WHERE categoryId = :id";
  	$select_query = "SELECT * FROM categories WHERE categoryId = :id";

  	$select_statement = $db->prepare($select_query);
  	$select_statement->bindValue(':id', $id, PDO::PARAM_INT);
 	$select_statement->execute(); 
  	$category = $select_statement->fetchAll();

  	if(count($category) == 0){
  		header('Location: users.php');
  		exit();
  	} else {
  	if(filter_var($id, FILTER_VALIDATE_INT)){
  		if(isset($_POST['title']) && strlen($_POST['title']) >= 1 && isset($_POST['update'])){
  			$update_statement = $db->prepare($update_query);
			$update_statement->bindValue(':title', $title);
  			$update_statement->bindValue(':id', $id, PDO::PARAM_INT);
			$update_statement->execute();

		 	header('Location: categories.php');
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

<?php if(isset($_SESSION)): ?>
    <div id="wrapper">
	<div id="category">
	  <form method="post" enctype="multipart/form-data">
	    <fieldset>
	      <legend>Edit Category</legend>
	      <p>
	        <label for="title">Title</label>
	        <input name="title" id="title" value="<?= $category[0]['title'] ?>" />
	      </p>
	      <p>
	        <input type="hidden" name="id" value="<?= $category[0]['categoryId'] ?>" />
	        <input type="submit" name="update" value="Update" />
	      </p>
	      <?php if(isset($_POST['title']) && strlen($_POST['title']) < 1): ?>
	        <p>Title may not be less than 1 character.</p>
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