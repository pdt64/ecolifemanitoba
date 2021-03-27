<?php
  // Name: Piolo Turdanes
  // Date:
  // Purpose: Allows users to edit blog posts and update the posts in the database.

   	require 'connection.php';
    require 'header.php';

	$title  = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  	$content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  	$id      = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

  	$update_query     = "UPDATE blogposts SET title = :title, content = :content WHERE postid = :id";
  	$delete_query = "DELETE FROM blogposts WHERE postid = :id"; 	
  	$select_query = "SELECT * FROM blogposts WHERE postid = :id";

  	$select_statement = $db->prepare($select_query);
  	$select_statement->bindValue(':id', $id, PDO::PARAM_INT);
 	$select_statement->execute(); 
  	$post = $select_statement->fetchAll();


  	if(count($post) == 0){
  		header('Location: index.php');
  		exit();
  	} else {
  	if(filter_var($id, FILTER_VALIDATE_INT)){
		if(isset($_POST['title']) && strlen($_POST['title']) >= 1 && 
		    isset($_POST['content']) && strlen($_POST['content']) >= 1 && isset($_POST['update'])) {
			$update_statement = $db->prepare($update_query);
			$update_statement->bindValue(':title', $title);
  			$update_statement->bindValue(':content', $content);
  			$update_statement->bindValue(':id', $id, PDO::PARAM_INT);
			$update_statement->execute();

		 	header('Location: index.php');
		    exit();
		}

	    if(isset($_POST['delete'])){
	    	$delete_statement = $db->prepare($delete_query);
			$delete_statement->bindValue(':id', $id, PDO::PARAM_INT);
	  	    $delete_statement->execute();
	  		header('Location: index.php');
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


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>ELM - Edit</title>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous"/>
</head>
<body>
<?php if(isset($_SESSION)): ?>
    <div id="wrapper">
	<div id="all_blogs">
	  <form method="post">
	    <fieldset>
	      <legend>Edit Blog Post</legend>
	      <p>
	        <label for="title">Title</label>
	        <input name="title" id="title" value="<?= $post[0]['title']?>" />
	      </p>
	      <p>
	        <label for="content">Content</label>
	        <textarea name="content" id="content" cols="100" rows="20"><?= $post[0]['content'] ?></textarea>
	      </p>
	      <p>
	        <input type="hidden" name="id" value="<?= $post[0]['postId'] ?>" />
	        <input type="submit" name="update" value="Update" />
	        <input type="submit" name="delete" value="Delete" onclick="return confirm('Are you sure you wish to delete this post?')" />
	      </p>
	      <?php if(isset($_POST['title']) && strlen($_POST['title']) < 1 && 
	      	isset($_POST['content']) && strlen($_POST['content']) < 1): ?>
	        <p>Title and content may not be less than 1 character.</p>
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
