<?php
require dirname(__DIR__) . '/src/core/bootstrap.php';

/*
** imitate router 
*/
$uri = trim($_SERVER['REQUEST_URI'], '/');

if($uri == "") { //home page

	require dirname(__DIR__) . '/src/controllers/UploadFile.php';
}

else if($uri == "upload_file") { //upload csv

	require dirname(__DIR__) . '/src/controllers/Parser.php';
} 

else {

	echo "<h1>404</h1> Invalid request.";
}