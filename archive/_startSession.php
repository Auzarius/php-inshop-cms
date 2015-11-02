<?php
	session_start();
	date_default_timezone_set('EST');
	include ('framework.php');
	
	$fw = new framework;
	
	$username = $fw->clean_input($_POST['username']);
	$password = $fw->clean_input($_POST['password']);	
	
	@ $db = new mysqli('localhost', 'root', '', 'brechbuhler');
	
	if (mysqli_connect_error()) {
		$errnum = mysqli_connect_errno();
		echo "Error($errnum): Could not connect to database. Please try again later.";
		exit;
	}
	
	$query = "select * from users where username like '%". $username ."%'";
	$result = $db->query($query);
	
	if ( $result ) {
		while($row = $result->fetch_assoc()) {
				$db_id = $row['id'];
				$db_username = $row['username'];
				$db_pass = $row['password'];
				$db_fullname = $row['fullname'];
				$db_email = $row['email'];
				$db_user = $row['is_user'];
				$db_admin = $row['is_admin'];
				$db_superadmin = $row['is_superadmin'];	
			}
			
		if ( sha1( $password ) == $db_pass ) {
			
			$digest = md5( 
				$db_id .
				$db_username .
				$db_fullname .
				$db_pass .
				$db_email .
				$db_user .
				$db_admin .
				$db_superadmin
			);
			
		} else {
			header( "Location: login.php?result=1" );
			die ("The password you entered is not correct");
			exit();
		}
		
		$_SESSION['USER'] = array(
			'userid'		=>		$db_id,
			'username'		=>		$db_username,
			'fullname'		=>		$db_fullname,
			'digest'		=>		$digest,
			'is_user'		=>		$db_user,
			'is_admin'		=>		$db_admin,
			'is_superadmin'	=>		$db_superadmin,
		);
		
		/*
		$_SESSION['user_id'] = $db_id;
		$_SESSION['val_username'] = $db_username;
		$_SESSION['val_digest'] = $digest;
		$_SESSION['val_fullname'] = $db_fullname;
		$_SESSION['is_user'] = $db_user;
		$_SESSION['is_admin'] = $db_admin;
		$_SESSION['is_superadmin'] = $db_superadmin;
		*/
		header("Location: index.php");
	} else {
		header( "Location: login.php?result=2" );
		die( "Unable to log you in at this time, please try again later." );
		exit();
	}
	
?>