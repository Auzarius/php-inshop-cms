<?php
	session_start();
	date_default_timezone_set("America/Fort_Wayne");
	include ('framework.php');
	
	$fw = new framework;
	
	$scale_id = $fw->clean_input($_POST['scale_id']);
	$tech = $fw->clean_input($_POST['tech']);
	$status = $fw->clean_input($_POST['status']);
	$stage = $fw->clean_input($_POST['stage']);
	$date = date('m/d/Y') . " @ " . date('h:i:s A');
	$comments = $fw->clean_input($_POST['comments']);
	
	
	$digest = md5(	$_POST['scale_id'] .
					$_POST['tech'] .
					$_POST['status'] .
					$_POST['stage'] .
					$date
				);
	
	$sessionDigest = isset($_SESSION['digest'])?$_SESSION['digest']:'';
	
	if( $digest != $sessionDigest ) {
				
		@ $db = new mysqli('localhost', 'root', '', 'brechbuhler');
				
		if (mysqli_connect_error()) {
			$errnum = mysqli_connect_errno();
			echo "Error($errnum): Could not connect to database. Please try again later.";
			exit;
		}
		
		#if ( $stage != "Additional Notes" ) {
		#	$event = "From " . $status . " to " . $stage;
		#} else {
			$event = $stage;
		#}
		
		$query = "insert into events values\r\n" .
			"('NULL', " .
			"'" . $date . "', " .
			"'" . $scale_id . "', " .
			"'" . $tech . "', " .
			"'" . $event . "', " .
			"'" . $comments . "'); ";
		
		$result = $db->query($query);
		
		if ( $stage != "Added Additional Notes" ) {
		
			$query_two = "update scales set status='". $stage ."' where id='". $scale_id ."';";
			$result_two = $db->query($query_two);
			
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
		header("Location: index.php?result=3");
		die();
	}
?>