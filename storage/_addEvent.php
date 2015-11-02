<?php
	session_start();
	include ('framework.php');
	@ $fw = new scaleDB('localhost', 'root', '', 'brechbuhler_test');
	
	if ( $fw->isLoggedIn( $_SESSION ) && $fw->isValidUser( $_SESSION ) ) {
		
		$scale_id = $fw->clean_input($_POST['scale_id']);
		$tech = $fw->clean_input($_POST['tech']);
		$status = $fw->clean_input($_POST['status']);
		$stage = $fw->clean_input($_POST['stage']);
		$date = $fw->getDate();
		$comments = $fw->clean_input($_POST['comments']);

		$event = $stage;
		
		$query = "insert into events values\r\n" .
			"('NULL', " .
			"'" . $date . "', " .
			"'" . $scale_id . "', " .
			"'" . $tech . "', " .
			"'" . $event . "', " .
			"'" . $comments . "'); ";
		
		$result = $fw->query($query);
		
		if ( $stage != "Added Additional Notes" ) {
		
			$query_two = "update scales set status='". $stage ."' where id='". $scale_id ."';";
			$result_two = $fw->query($query_two);
			
			if ( $result && $result_two ) {
				//$result->free();
				header("Location: index.php?result=5");
				
				die();
			} elseif ( $result || $result_two ) {
				header("Location: index.php?result=4");
			} else {
				header("Location: index.php?result=2");
				//echo $query;
				die();
			}
		} elseif ( $stage == "Additional Notes" && $result ) {
			header("Location: index.php?result=5");
			die();
		}
	} else {
		echo "You must be logged in to view this page.";
		header( "Location: login.php" );
	}
?>