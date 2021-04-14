<?php

	require 'connection.php';
	$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
	$post = filter_input(INPUT_GET, 'post', FILTER_SANITIZE_NUMBER_INT);

	$delete = "DELETE FROM comments WHERE commentId = :id";

	$delete_statement = $db->prepare($delete);
	$delete_statement->bindValue(':id', $id, PDO::PARAM_INT);
	$delete_statement->execute();
	header("Location: show.php?id=$post");
	exit();
?>