<?php

 	// Name: Piolo Turdanes
  	// Date: 
  	// Purpose: Connects to the database.

	define('DB_DSN','mysql:host=localhost;dbname=project');
  	define('DB_USER','admin');
  	define('DB_PASS','pr0j3ct38!!!');

	try {
	    $db = new PDO(DB_DSN, DB_USER, DB_PASS);
	} catch (PDOException $e) {
	    print "Error: " . $e->getMessage();
	    die(); 
	}

?>