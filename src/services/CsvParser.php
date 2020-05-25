<?php

namespace Parser\Services;

class CsvParser 
{
	private static $homeOwners;
	private static $owners = [];

	public static function processFile() 
	{
        $success = null;
        $data 	 = [];
        
        $results['status'] = 'warning';
        $results['msg']   = 'CSV data parsed successfully.';
	    
	    if ($_FILES["file"]["size"] > 0) {

	    	$fileName = $_FILES["file"]["tmp_name"];
        
	        $file 	 = fopen($fileName, "r");
	    	$results = [];

	    	//get all home owners
	        while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {

		            
	            if ( isset($column[0]) ) {

	            	if( $column[0] == 'homeowner' || $column[0] == '' ) { //ignore first row and empty rows

	            		continue;
	            	}

	            	$homeOwner = $column[0];
	            	static::parseData( trim($homeOwner) );
	            }
			}
		}

		return new static;
	}


	public static function parseData($homeOwner) {

		$title 		= "(Mr\s|Mrs\s|Dr\s|Mister\s|Ms\s|Prof\s)";
		$initial	= "(\w\.?\s)";
		$singleName = "(\w{2,})";
		$fullName 	= "(\w{2,})\s(\w{2,}(-\w*)?\s?)";
		$separator  = "(and|&)\s";

		$lastNameInitialPattern 	= $title . $initial . $singleName;
		$fullNamePattern 			= $title . $fullName;
		$dblTitleSingleNamePattern	= $title . $separator . $title . $singleName;
		$dblTitleFullNamePattern	= $title . $separator . $title . $fullName;
		$dblFullNamePattern			= $title . $fullName . $separator . $title . $fullName;



		//double titles and double full name
		if(preg_match("/$dblFullNamePattern/", $homeOwner)) {

			preg_match_all("/$dblFullNamePattern/", $homeOwner, $match);
			$person[1]['title'] 		= $match[1][0];
			$person[1]['first_name'] 	= $match[2][0];
			$person[1]['initial'] 		= null;
			$person[1]['last_name'] 	= $match[3][0];

			$person[2]['title'] 		= $match[6][0];
			$person[2]['first_name'] 	= $match[7][0];
			$person[2]['initial'] 		= null;
			$person[2]['last_name'] 	= $match[8][0];

			static::$owners[] = $person;

		}

		//double title with single full name
		else if(preg_match("/$dblTitleFullNamePattern/", $homeOwner)) {

			preg_match_all("/$dblTitleFullNamePattern/", $homeOwner, $match);

			$person[1]['title'] 		= $match[1][0];
			$person[1]['first_name'] 	= $match[4][0];
			$person[1]['initial'] 		= null;
			$person[1]['last_name'] 	= $match[5][0];

			$person[2]['title'] 		= $match[3][0];
			$person[2]['first_name'] 	= $match[4][0];
			$person[2]['initial'] 		= null;
			$person[2]['last_name'] 	= $match[5][0];

			static::$owners[] = $person;	

		}

		//double titles and a first name
		else if(preg_match("/$dblTitleSingleNamePattern/", $homeOwner)) {

			preg_match_all("/$dblTitleSingleNamePattern/", $homeOwner, $match);
			$person[1]['title'] 		= $match[1][0];
			$person[1]['first_name'] 	= null;
			$person[1]['initial'] 		= null;
			$person[1]['last_name'] 	= $match[4][0];

			$person[2]['title'] 		= $match[3][0];
			$person[2]['first_name'] 	= null;
			$person[2]['initial'] 		= null;
			$person[2]['last_name'] 	= $match[4][0];

			static::$owners[] = $person;
		}

		//title with last name and Initial
		else if(preg_match("/$lastNameInitialPattern/", $homeOwner)) {
			preg_match_all("/$lastNameInitialPattern/", $homeOwner, $match);
			
			$person['title'] 		= $match[1][0];
			$person['first_name'] 	= null;
			$person['initial'] 		= $match[2][0];
			$person['last_name'] 	= $match[3][0];

			static::$owners[] = $person;			
		}  

		//title with full name
		else if(preg_match("/$fullNamePattern/", $homeOwner)) {

			preg_match_all("/$fullNamePattern/", $homeOwner, $match);
			$person['title'] 		= $match[1][0];
			$person['first_name'] 	= $match[2][0];
			$person['initial'] 		= null;
			$person['last_name'] 	= $match[3][0];

			static::$owners[] = $person;			
		}
	}

	public static function getOwners()
	{
		return static::$owners;
	}
}