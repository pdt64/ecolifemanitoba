<?php
  // Name: Piolo Turdanes
  // Date:
  // Purpose: Allows users to edit blog posts and update the posts in the database.


    require 'header.php';

    include '\xampp\htdocs\TermProject\uploads\php-image-resize-master\lib\ImageResize.php';
    include '\xampp\htdocs\TermProject\uploads\php-image-resize-master\lib\ImageResizeException.php';

    use \Gumlet\ImageResize;

    function file_is_valid($temporary_path, $new_path) {
        $allowed_mime_types      = ['image/jpeg', 'image/jpg', 'image/png'];
        $allowed_file_extensions = ['JPG', 'jpg', 'JPEG', 'jpeg', 'png'];

        $actual_file_extension   = pathinfo($new_path, PATHINFO_EXTENSION);
        $actual_mime_type        = mime_content_type($temporary_path);

        $file_extension_is_valid = in_array($actual_file_extension, $allowed_file_extensions);
        $mime_type_is_valid      = in_array($actual_mime_type, $allowed_mime_types);

        return $file_extension_is_valid && $mime_type_is_valid;
    }

    function file_upload_path($original_filename, $upload_subfolder_name) {
       $current_folder = dirname(__FILE__);
       $path_segments = [$current_folder, $upload_subfolder_name, basename($original_filename)];
       return join(DIRECTORY_SEPARATOR, $path_segments);
    }

	  $title  = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  	$content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  	$id      = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    $category = filter_input(INPUT_POST, 'categories', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $image_query     = "UPDATE blogposts SET title = :title, content = :content, dateUpdated = CURRENT_TIMESTAMP, 
                        image = :image, categoryId = :category WHERE postid = :id";
  	$update_query     = "UPDATE blogposts SET title = :title, content = :content, dateUpdated = CURRENT_TIMESTAMP,
                        categoryId = :category WHERE postid = :id";
  	$delete_query = "DELETE FROM blogposts WHERE postid = :id"; 	
  	$select_query = "SELECT * FROM blogposts WHERE postid = :id";
    $category_query = "SELECT * FROM categories";

    $category_statement = $db->prepare($category_query);
    $category_statement->execute();
    $categories = $category_statement->fetchAll();

    $select_statement = $db->prepare($select_query);
    $select_statement->bindValue(':id', $id, PDO::PARAM_INT);
    $select_statement->execute(); 
    $post = $select_statement->fetchAll();

    if(filter_var($id, FILTER_VALIDATE_INT)){
    if(isset($_POST['title']) && strlen($_POST['title']) >= 1 && 
      isset($_POST['content']) && strlen($_POST['content']) >= 1 && isset($_POST['update'])){

    $image_upload_detected = isset($_FILES['image']) && ($_FILES['image']['error'] === 0);

    if ($image_upload_detected) {
        $image_filename       = $_FILES['image']['name'];
        $temporary_image_path = $_FILES['image']['tmp_name'];
        $new_image_path       = file_upload_path($image_filename, 'uploads');

          if(file_is_valid($temporary_image_path, $new_image_path)) {

            move_uploaded_file($temporary_image_path, $new_image_path);

            $path_parts = pathinfo($new_image_path);

              $image = new \Gumlet\ImageResize($new_image_path);

                  $file_components = explode('.', $image_filename);

                  $image
                      ->resizeToWidth(400)
                      ->save($file_components[0] . "_medium." . $file_components[1])

                      ->resizeToWidth(200)
                      ->save($file_components[0] . "_thumbnail." . $file_components[1])
                  ;
            $image = $_FILES['image']['name'];
      
            $statement = $db->prepare($image_query);

            $statement->bindValue(':image', $image);
            $statement->bindValue(':title', $title);
            $statement->bindValue(':content', $content);
            $statement->bindValue(':id', $id, PDO::PARAM_INT);
            $statement->bindValue(':category', $category);

            $statement->execute();

            header('Location: index.php');
            exit();
          } 
        
    } else {
            $statement = $db->prepare($update_query);

            $statement->bindValue(':title', $title);
            $statement->bindValue(':content', $content);
            $statement->bindValue(':id', $id, PDO::PARAM_INT);
            $statement->bindValue(':category', $category);

            $statement->execute();

            header('Location: index.php');
            exit();
    
  }
}
}


  	if(count($post) == 0){
  		header('Location: index.php');
  		exit();
  	} else {

	    if(isset($_POST['delete'])){
	    	$delete_statement = $db->prepare($delete_query);
			$delete_statement->bindValue(':id', $id, PDO::PARAM_INT);
	  	    $delete_statement->execute();
	  		header('Location: index.php');
	  		exit();
	  	}

      if(isset($_POST['deleteImage'])){

        $file_components = explode('.', $post[0]['image']);
        $thumbnail = $file_components[0] . "_thumbnail." . $file_components[1];
        $medium = $file_components[0] . "_medium." . $file_components[1];

        unlink(file_upload_path($post[0]['image'], 'uploads'));
        unlink(file_upload_path($thumbnail, ''));
        unlink(file_upload_path($medium, ''));
        $delete_image_query = "UPDATE blogposts SET image = null WHERE postId = :id";
        $delete_statement = $db->prepare($delete_image_query);

        $delete_statement->bindValue(':id', $id, PDO::PARAM_INT);

            $delete_statement->execute();

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
	  <form method="post" enctype="multipart/form-data">
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
        <label>Select a category: (optional)</label>
          <select name="categories">
            <option value="" selected>No Category</option>
            <?php foreach($categories as $category): ?>
              <option value="<?= $category['categoryId'] ?>"><?= $category['title'] ?></option>
            <?php endforeach ?>
          </select>
          <br>
        <?php if($post[0]['image'] != null): ?>
          <p>Existing image:</p>
          <?php $file_components = explode('.', $post[0]['image']) ?>
          <?php $thumbnail = $file_components[0] . "_thumbnail." . $file_components[1] ?>
          <img src="<?= $thumbnail ?>" alt="Picture"/>
          <p><?= $post[0]['image'] ?></p>
          <input type="submit" name="deleteImage" value="Delete Image" />
        <?php else: ?>
          <label for="image">Image Filename:</label>
          <input type="file" name="image" id="image"/>
        <?php endif ?>
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
