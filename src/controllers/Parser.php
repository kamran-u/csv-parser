<?php

use Parser\Services\CsvParser;

$structeredOwners = [];

if (isset($_POST["upload_file"])) {
    
	$structeredOwners = CsvParser::processFile()->getOwners();
	
} 

require dirname(__DIR__, 2) . '/resources/views/home.php';            