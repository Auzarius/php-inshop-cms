<?php 
	session_start();
	include ('framework.php');
	@ $fw = new scaleDB('localhost', 'root', '', 'brechbuhler_test');
	
	if ( $fw->isLoggedIn( $_SESSION ) && $fw->isValidUser( $_SESSION ) && $fw->isSuperAdmin( $_SESSION ) ) {

		if ( isset( $_GET['id'] ) ) { 
			$scale_id = $fw->clean_input($_GET['id']);
		} else {
			die("No scale was defined in the delete request.");
		}
		
		#$fullname = $_SESSION['user_validation']['fullname'];
		#$username = $_SESSION['user_validation']['username'];
		
		echo $scale_id . "<br />";
		
		$query_scales = "delete from scales where id = '". $scale_id ."'";
		echo $query_scales . "<br />";
		$result_scales = $fw->query($query_scales);
		
		if ( !$result_scales ) {
			die ( "Something happened.  The scale could not be removed from the database at this time.  Please try again later." );
		}
		
		$query_events = "delete from events where scale_id = '". $scale_id ."'";
		$result_events = $fw->query($query_events);
		
		if ( !$result_events ) {
			die ( "Something happened.  The events could not be removed from the database at this time.  Please notify an admin." );
		}
		
		header( 'Location: index.php?result=31' );
		die( "The scale was successfully removed from the database." );
		
	} else {
		header( "Location: login.php" );
		die ( "You must be logged in to view this page." );
	}
?>