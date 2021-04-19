<?php
  // Name: Piolo Turdanes
  // Date: 
  // Purpose: Displays the index page and 15 most recent blog posts.
  require 'header.php';

  	$query = "SELECT * FROM categories ORDER BY categoryId";
  	$statement = $db->prepare($query); 
  	$statement->execute(); 
  	$categories = $statement->fetchAll();

  if(isset($_POST['add'])){
    header("Location: addCategory.php");
  }

  if(!isset($_SESSION)){
	session_start();
  }

?>

  <?php if(isset($_SESSION['userId'])): ?>
  <div id="categories">
    <form method="post"> 
      <input type="submit" name="add" value="Add Category"  />
    </form>
        
      <?php foreach($categories as $category): ?>
        <div class="category">
          <h2><?= $category['categoryId'] ?>. <?= $category['title'] ?>   <a href="editCategory.php?id=<?= $category['categoryId'] ?>">edit</a></h2>
          <br/>
        </div>
      <?php endforeach ?>
  </div>
<?php else: ?>
  <p>You do not have access to this page.</p>
<?php endif ?>
</body>
</html>