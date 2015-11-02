<?php 
	session_start();
	date_default_timezone_set('EST');
	include ('framework.php');
	
	$fw = new framework;

	$status = $fw->clean_input($_POST['status']);
	$scale_id = $fw->clean_input($_POST['scale_id']);
	$fullname = $_SESSION['val_fullname'];
	$username = $_SESSION['val_username'];
	
	#echo $status . "<br>";
	#echo $scale_id . "<br>";
	#echo $fullname . "<br>";
	#echo $username . "<br>";
	#echo $_SESSION['val_username'];
	
	@ $db = new mysqli('localhost', 'root', '', 'brechbuhler');
			
	if ( mysqli_connect_error() ) {
		$errnum = mysqli_connect_errno();
		echo "Error($errnum): Could not connect to database. Please try again later.";
		exit;
	}
	
	#Check if the user is actually an admin
	$query_user = "select * from users where username like '%$username%'";
	#echo $query_user;
	$result_user = $db->query($query_user);
	
	if ( $result_user ) {
		while( $row = $result_user->fetch_assoc() ) {
			$db_pass = $row['password'];
			$db_user = $row['username'];
			$db_name = $row['fullname'];
			$db_email = $row['email'];
			$db_user = $row['is_user'];
			$db_admin = $row['is_admin'];
			$db_superadmin = $row['is_superadmin'];
		}
	} else {
		die ( "Something happened.  Your credentials could not be authenticated against the database at this time." );
	}
	
	if ( $result_user && $db_superadmin ) {
		$digest = md5(	
				$db_user .
				$db_pass .
				$db_email .
				$db_user .
				$db_admin
			);
			
		if ( $_SESSION['val_digest'] == $digest ) {
			$query_scales = "delete from scales where id = '". $scale_id ."'";
			$result_scales = $db->query($query_scales);
			
			if ( !$result_scales ) {
				die ( "Something happened.  The scale could not be removed from the database at this time.  Please try again later." );
			}
			
			$query_events = "delete from events where scale_id = '". $scale_id ."'";
			$result_events = $db->query($query_events);
			
			if ( !$result_scales ) {
				die ( "Something happened.  The events could not be removed from the database at this time.  Please notify an admin." );
			}
			
			header( "Location: index.php?result=31" );
			exit();
		} else {
			header( "Location: index.php?result=99" );
			die( "You do not actually have superadmin privelages, nice try!" );
		}
	} else {
		header( "Location: index.php?result=99" );
		die( "You must have superadmin privelages to perform that action!" );
	}
			
	exit();
?>