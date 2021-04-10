<?php
  // Name: Piolo Turdanes
  // Date:
  // Purpose: Allows users to edit blog posts and update the posts in the database.

    $category_query = "SELECT * FROM categories";

    $category_statement = $db->prepare($category_query);
    $category_statement->execute();
    $categories = $category_statement->fetchAll();

?>


<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body>
  <ul class="nav">
  <?php foreach($categories as $category): ?>
  <li class="nav-item">
    <a class="nav-link" aria-current="page" href="categorySort.php?id=<?= $category['categoryId']?>"><?= $category['title'] ?></a>
  </li>
<?php endforeach ?>
</ul>
</body>
</html>

