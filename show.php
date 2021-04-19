<?php
  // Name: Piolo Turdanes
  // Date: 
  // Purpose: Displays the selected page.

  require 'header.php';

  if(isset($_SESSION['userId'])){
    $userId = $_SESSION['userId'];
    $commenter = $_SESSION['username'];
  }

   $id      = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
   $userPostId = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
   $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  	$query = "SELECT * FROM blogposts WHERE postId = :id";
    $comment_query = "SELECT * FROM comments WHERE postId = :id ORDER BY dateCreated";
    $insert = "INSERT INTO comments (postId, userId, content, commenter) values (:postId, :userId, :content, :commenter)";

  	if(filter_var($id, FILTER_VALIDATE_INT)){
      $select_statement = $db->prepare($query); 
      $select_statement->bindValue(':id', $id, PDO::PARAM_INT);
      $select_statement->execute(); 
      $post = $select_statement->fetchAll();

      $comment_statement = $db->prepare($comment_query); 
      $comment_statement->bindValue(':id', $id, PDO::PARAM_INT);
      $comment_statement->execute(); 
      $comments = $comment_statement->fetchAll();
    } else {
      header('Location: index.php');
      exit();
    }

    if(isset($_POST['content']) && strlen($_POST['content']) >= 1 && isset($_POST['submit'])){
      if(isset($userId)){
        $statement = $db->prepare($insert);

        $statement->bindValue(':content', $content);
        $statement->bindValue(':userId', $userPostId);
        $statement->bindValue(':postId', $id);
        $statement->bindValue(':commenter', $commenter);

        $statement->execute();
        $insert_id = $db->lastInsertId();

        header("Location: show.php?id=$id");
        exit();
      }
    }

    if(count($post) == 0){
      header('Location: index.php');
      exit();
    } 
  if(!isset($_SESSION)){
	session_start();
  }

?>


	<div id="blogposts">
    <div class="blog_post">
      <h2><?= $post[0]['title'] ?></h2>
      <?php if($post[0]['image'] != null): ?>
              <img src="uploads/<?= $post[0]['image'] ?>" alt="Picture"/>
      <?php endif ?>
      <p>
        <small>
          <?= date('F j, Y,  g:i a', strtotime($post[0]['postDate'])) ?>
          <?php if(isset($_SESSION['userId'])): ?>
          <small> - </small><a href="edit.php?id=<?= $post[0]['postId']?>">edit</a>
        <?php endif ?>
        </small>
      </p>
      <div class='blog_content'>
        <p><?= $post[0]['content'] ?></p>
      </div>
      <h2>Comments:</h2>
      <?php foreach ($comments as $comment): ?>
        <div class="container-fluid">
          <p><?= $comment['content'] ?></p>
          <small><?= date('F j, Y,  g:i a ', strtotime($comment['dateCreated'])) ?> - <?= $comment['commenter'] ?></small>
          <?php if(isset($_SESSION['userId']) && $_SESSION['usertype'] == 2): ?>
            <a href="deleteComment.php?id=<?= $comment['commentId'] ?>&post=<?= $post[0]['postId'] ?>">Delete</a>
          <?php endif ?>
          <br/>
          <br>
        </div>
      <?php endforeach ?>
      <?php if(isset($_SESSION['userId'])): ?>
      <h2>Add a comment:</h2>
      <form method="post">
        <input type="hidden" name="id" value="<?= $comments[0]['userId'] ?>" />
        <textarea name="content" id="content" cols="50" rows="10"></textarea>
        <input type="submit" name="submit" value="Comment"  />
          <?php if(isset($_POST['content']) && strlen($_POST['content']) < 1): ?>
            <p>Comment may not be less than 1 character.</p>
          <?php endif ?>
      </form>
    <?php endif ?>
	</div>
</div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
  </body>
      
</html>